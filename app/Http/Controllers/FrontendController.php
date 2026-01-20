<?php

namespace App\Http\Controllers;

use App\Models\CleaningServices;
use App\Models\Event;
use App\Models\ServiceBooking;
use App\Models\Slider;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class FrontendController extends Controller
{
    public function Index()
    {
        $services = CleaningServices::where('service_status', 'active')->latest()->get();
        $slider = Slider::where('slider_status', 'active')->orderBy('id', 'asc')->get();
        $events = Event::where('status', 'active')->orderBy('event_date', 'desc')->get();

        return view('frontend.index', compact('services', 'slider', 'events'));
    }

    public function Services()
    {
        $services = CleaningServices::where('service_status', 'active')->latest()->get();
        return view('frontend.pages.services', compact('services'));
    }

    public function ServiceDetails($slug)
    {
        $service_details = CleaningServices::where('service_slug', $slug)->where('service_status', 'active')->firstOrFail();

        $service_list = CleaningServices::where('service_status', 'active')->orderBy('service_title')->latest()->take(5)->get();

        return view('frontend.details.service_details', compact('service_details', 'service_list'));
    } // End Method

    public function ServiceBookingStore(Request $request)
    {
        // ✅ Must be logged in
        if (!Auth::check()) {
            return redirect()->route('login')->with('message', 'Please login to book a service.')->with('alert-type', 'warning');
        }

        $validator = Validator::make(
            $request->all(),
            [
                'service_id' => ['required', 'integer', 'exists:cleaning_services,id'],

                // User info
                'name' => ['required', 'string', 'max:255'],
                'phone' => ['required', 'string', 'max:30'],

                // ✅ booking date + time
                'date' => ['required', 'date'],

                'note' => ['nullable', 'string', 'max:2000'],

                // Payment
                'payment_method' => ['required', 'in:cod,bkash'],
                'bkash_number' => ['required_if:payment_method,bkash', 'nullable', 'string', 'max:20'],
                'transaction_id' => ['required_if:payment_method,bkash', 'nullable', 'string', 'max:80', 'unique:service_bookings,transaction_id'],
            ],
            [
                'service_id.required' => 'Service is required.',
                'service_id.exists' => 'Invalid service selected.',

                'name.required' => 'Name is required.',
                'phone.required' => 'Phone is required.',

                'date.required' => 'Booking date is required.',

                'payment_method.required' => 'Please select a payment method.',
                'payment_method.in' => 'Invalid payment method.',
                'bkash_number.required_if' => 'bKash number is required for bKash payment.',
                'transaction_id.required_if' => 'Transaction ID is required for bKash payment.',
                'transaction_id.unique' => 'This Transaction ID is already used.',
            ],
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $booking = DB::transaction(function () use ($request) {
                $user = Auth::user();

                // ✅ Force email from authenticated user
                $emailToSave = $user->email;

                // ✅ COD rules: keep bkash fields empty
                $bkashNumber = $request->payment_method === 'bkash' ? $request->bkash_number : null;
                $trxId = $request->payment_method === 'bkash' ? $request->transaction_id : null;

                // ✅ payment_status: cod=pending, bkash=unverified
                $paymentStatus = $request->payment_method === 'bkash' ? 'unverified' : 'pending';

                // ✅ Load service to calculate duration
                $service = CleaningServices::findOrFail((int) $request->service_id);

                // ✅ Build start datetime from date + time
                $start = Carbon::parse($request->date . ' ' . $request->time);

                // ✅ IMPORTANT: service_duration must be minutes (example: "120")
                $minutes = (int) $service->service_duration;

                // fallback if empty duration
                if ($minutes <= 0) {
                    $minutes = 60; // default 60 minutes (change if you want)
                }

                $end = $start->copy()->addMinutes($minutes);

                // ✅ Create booking
                $booking = ServiceBooking::create([
                    'invoice_no' => 'TEMP',
                    'user_id' => $user->id,
                    'service_id' => (int) $request->service_id,

                    'name' => $request->name,
                    'email' => $emailToSave,
                    'phone' => $request->phone,

                    // ✅ user only date gives
                    'booking_date' => $request->date,

                    // ✅ admin will set later
                    'booking_start_at' => null,
                    'booking_end_at' => null,

                    'note' => $request->note,
                    'payment_method' => $request->payment_method,
                    'bkash_number' => $bkashNumber,
                    'transaction_id' => $trxId,
                    'payment_status' => $paymentStatus,

                    'status' => 'pending',
                    'progress_status' => 'pending',
                ]);

                // ✅ Generate invoice: INV-YYYYMMDD-000001
                $invoiceNo = 'INV-' . now()->format('Ymd') . '-' . str_pad((string) $booking->id, 6, '0', STR_PAD_LEFT);
                $booking->update(['invoice_no' => $invoiceNo]);

                return $booking;
            });

            return redirect()
                ->back()
                ->with('message', 'Booking created successfully! Invoice: ' . $booking->invoice_no)
                ->with('alert-type', 'success');
        } catch (\Throwable $e) {
            Log::error('ServiceBookingStore error: ' . $e->getMessage());

            return redirect()->back()->withInput()->with('message', 'Something went wrong! Please try again.')->with('alert-type', 'error');
        }
    }

    public function UserDashboard()
    {
        $user = Auth::user();

        $servicePurchases = ServiceBooking::with([
            'service',
            'cleanerAssign.cleaner', // ✅ cleaner name
        ])
            ->where('user_id', $user->id)
            ->latest()
            ->get();

        return view('frontend.user.dashboard', compact('servicePurchases'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make(
            $request->all(),
            [
                'name' => ['required', 'string', 'max:255'],
                'phone' => ['required', 'string', 'max:30'],
            ],
            [
                'name.required' => 'Name is required',
                'phone.required' => 'Phone is required',
            ],
        );

        if ($validator->fails()) {
            return redirect()->route('dashboard')->withErrors($validator)->withInput()->with('open_tab', 'profile'); // ✅ profile tab open রাখবে
        }

        /** @var \App\Models\User $user */
        $user = Auth::user();

        $user->update([
            'name' => $request->name,
            'phone' => $request->phone,
        ]);

        return redirect()->route('dashboard')->with('message', 'Profile updated successfully!')->with('alert-type', 'success')->with('open_tab', 'profile');
    }

    public function ServicePurchaseShow(ServiceBooking $booking)
    {
        abort_if($booking->user_id !== Auth::id(), 403);

        $booking->load('service', 'user');

        return view('frontend.user.service_purchase_show', compact('booking'));
    }

    public function ServicePurchaseInvoice(ServiceBooking $booking)
    {
        abort_if($booking->user_id !== Auth::id(), 403);

        $booking->load('service', 'user');

        return view('frontend.user.service_purchase_invoice', compact('booking'));
    }

    public function ServicePurchaseInvoicePrint(ServiceBooking $booking)
    {
        abort_if($booking->user_id !== Auth::id(), 403);

        $booking->load('service', 'user');

        return view('frontend.user.service_purchase_invoice_print', compact('booking'));
    }

    public function AboutUs()
    {
        return view('frontend.pages.about_us');
    } // End Method

    public function Events()
    {
        $events = Event::where('status', 'active')->orderBy('event_date', 'desc')->get();

        return view('frontend.pages.events', compact('events'));
    }

    public function EventDetails($slug)
    {
        $event = Event::where('slug', $slug)->where('status', 'active')->firstOrFail();

        $recentEvents = Event::where('status', 'active')->where('id', '!=', $event->id)->orderBy('event_date', 'desc')->limit(6)->get();

        return view('frontend.details.event_details', compact('event', 'recentEvents'));
    }

    public function ContactUs()
    {
        return view('frontend.pages.contact_us');
    } // End Method
}
