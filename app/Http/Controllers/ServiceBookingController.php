<?php

namespace App\Http\Controllers;

use App\Models\ServiceBooking;
use App\Models\User;
use App\Models\CleanerAssign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class ServiceBookingController extends Controller
{
    public function index()
    {
        $booking_list = ServiceBooking::with(['user', 'service'])
            ->latest()
            ->get();
        $cleaners = User::where('role', 'cleaner')->get();

        return view('backend.service_booking.list', compact('booking_list', 'cleaners'));
    }

    public function show($id)
    {
        $booking = ServiceBooking::with(['user', 'service'])->findOrFail($id);

        return view('backend.service_booking.show', compact('booking'));
    }

    public function confirm($id)
    {
        $booking = ServiceBooking::findOrFail($id);
        $booking->update(['status' => 'confirmed']);

        return redirect()->back()->with('message', 'Booking confirmed')->with('alert-type', 'success');
    }

    public function cancel($id)
    {
        $booking = ServiceBooking::findOrFail($id);
        $booking->update(['status' => 'cancelled']);

        return redirect()->back()->with('message', 'Booking cancelled')->with('alert-type', 'success');
    }

    public function verifyPayment($id)
    {
        $booking = ServiceBooking::findOrFail($id);

        if ($booking->payment_method !== 'bkash') {
            return redirect()->back()->with('message', 'Not a bKash booking')->with('alert-type', 'warning');
        }

        $booking->update(['payment_status' => 'verified']);

        return redirect()->back()->with('message', 'Payment verified')->with('alert-type', 'success');
    }

    public function rejectPayment($id)
    {
        $booking = ServiceBooking::findOrFail($id);

        if ($booking->payment_method !== 'bkash') {
            return redirect()->back()->with('message', 'Not a bKash booking')->with('alert-type', 'warning');
        }

        $booking->update(['payment_status' => 'rejected']);

        return redirect()->back()->with('message', 'Payment rejected')->with('alert-type', 'success');
    }

    public function invoice($id)
    {
        $booking = ServiceBooking::with(['user', 'service'])->findOrFail($id);
        return view('backend.service_booking.invoice', compact('booking'));
    }

    public function invoiceDownload($id)
    {
        $booking = ServiceBooking::with(['user', 'service'])->findOrFail($id);

        // This uses the "print invoice" approach (browser Save as PDF)
        return response()->view('backend.service_booking.invoice_print', compact('booking'))->header('Content-Type', 'text/html');
    }

    public function CleanerAssign(Request $request)
    {
        $request->validate([
            'cleaner_id' => 'required|integer',
            'job_id' => 'required|integer',
        ]);

        DB::beginTransaction();
        try {
            CleanerAssign::create([
                'cleaner_id' => $request->cleaner_id,
                'job_id' => $request->job_id,
                'status' => 'pending',
            ]);

            ServiceBooking::where('id', $request->job_id)
                ->where('status', '!=', 'cancelled')
                ->update(['progress_status' => 'in_progress']);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Cleaner assigned successfully.',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error assigning cleaner: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function updateProgressStatus(Request $request, $id)
    {
        $request->validate([
            'progress_status' => 'required|in:pending,in_progress,completed,rejected',
        ]);

        $booking = ServiceBooking::findOrFail($id);

        // ✅ Rule: if booking is cancelled, don't allow progress change
        if ($booking->status === 'cancelled') {
            return redirect()->back()->with('message', 'Cancelled booking progress cannot be updated.')->with('alert-type', 'warning');
        }

        // ✅ Rule: must be confirmed before completed (recommended)
        if ($request->progress_status === 'completed' && $booking->status !== 'confirmed') {
            return redirect()->back()->with('message', 'Booking must be confirmed before marking completed.')->with('alert-type', 'warning');
        }

        // ✅ Rule: bKash must be verified before completed (recommended)
        if ($request->progress_status === 'completed' && $booking->payment_method === 'bkash' && $booking->payment_status !== 'verified') {
            return redirect()->back()->with('message', 'bKash payment must be verified before completing.')->with('alert-type', 'warning');
        }

        $booking->update([
            'progress_status' => $request->progress_status,
        ]);

        return redirect()->back()->with('message', 'Progress status updated successfully.')->with('alert-type', 'success');
    }
}
