<?php

namespace App\Http\Controllers;

use App\Models\ServiceBooking;
use Illuminate\Http\Request;

class ServiceBookingController extends Controller
{
    public function index()
    {
        $booking_list = ServiceBooking::with(['user', 'service'])
            ->latest()
            ->get();

        return view('backend.service_booking.list', compact('booking_list'));
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
}
