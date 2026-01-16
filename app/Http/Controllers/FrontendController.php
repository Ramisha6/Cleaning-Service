<?php

namespace App\Http\Controllers;

use App\Models\CleaningServices;
use App\Models\ServiceBooking;
use App\Models\Slider;
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

        $slider = Slider::where('slider_status', 'active')->latest()->get();

        return view('frontend.index', compact('services', 'slider'));
    }
    public function Services()
    {
        $services = CleaningServices::where('service_status', 'active')->latest()->get();

        return view('frontend.service.services', compact('services'));
    }

    public function ServiceDetails($slug)
    {
        $service_details = CleaningServices::where('service_slug', $slug)->where('service_status', 'active')->firstOrFail();

        $service_list = CleaningServices::where('service_status', 'active')->orderBy('service_title')->latest()->take(5)->get();

        return view('frontend.details.service_details', compact('service_details', 'service_list'));
    } // End Method

    public function ServiceBookingStore(Request $request)
    {
        // If route middleware not added, enforce here too:
        if (!Auth::check()) {
            return redirect()->route('login')->with('message', 'Please login to book a service.')->with('alert-type', 'warning');
        }

        $validator = Validator::make(
            $request->all(),
            [
                'service_id' => ['required', 'integer', 'exists:cleaning_services,id'],
                'name' => ['required', 'string', 'max:255'],
                'email' => ['nullable', 'email', 'max:255'],
                'phone' => ['required', 'string', 'max:30'],
                'date' => ['required', 'date'],
                'note' => ['nullable', 'string', 'max:2000'],

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
                // Create first to get ID, then generate invoice
                $booking = ServiceBooking::create([
                    'invoice_no' => 'TEMP',

                    'user_id' => Auth::id(),
                    'service_id' => (int) $request->service_id,

                    'name' => $request->name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'booking_date' => $request->date,
                    'note' => $request->note,

                    'payment_method' => $request->payment_method,
                    'bkash_number' => $request->payment_method === 'bkash' ? $request->bkash_number : null,
                    'transaction_id' => $request->payment_method === 'bkash' ? $request->transaction_id : null,

                    // payment_status: cod = pending, bkash = unverified (admin will verify)
                    'payment_status' => $request->payment_method === 'bkash' ? 'unverified' : 'pending',

                    'status' => 'pending',
                ]);

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

        // Service Purchases (bookings)
        $servicePurchases = ServiceBooking::with('service')->where('user_id', $user->id)->latest()->get();

        return view('frontend.user.dashboard', compact('servicePurchases')); // add other vars you use
    }

    public function ServicePurchaseShow(ServiceBooking $booking)
    {
        // Protect: user can only see own booking
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

        // Print-optimized view
        return view('frontend.user.service_purchase_invoice_print', compact('booking'));
    }

    public function AboutUs()
    {
        return view('frontend.pages.about_us');
    }
}
