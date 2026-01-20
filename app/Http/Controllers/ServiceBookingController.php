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
        return response()->view('backend.service_booking.invoice_print', compact('booking'))->header('Content-Type', 'text/html');
    }

    /**
     * ✅ Admin modal availability check
     * GET: cleaner_id, job_id, start_time
     */
    public function checkCleanerAvailability(Request $request)
    {
        $request->validate([
            'cleaner_id' => 'required|integer',
            'job_id' => 'required|exists:service_bookings,id',
            'start_time' => 'required',
        ]);

        $booking = ServiceBooking::with('service')->findOrFail($request->job_id);

        $bookingDate = Carbon::parse($booking->booking_date)->toDateString(); // YYYY-MM-DD only
        $startAt = Carbon::parse($bookingDate . ' ' . $request->start_time);

        $durationMinutes = $this->getDurationMinutes($booking->service);
        if ($durationMinutes <= 0) {
            return response()->json(
                [
                    'available' => false,
                    'message' => 'Service duration set kora nai (minutes)',
                ],
                422,
            );
        }

        $endAt = $startAt->copy()->addMinutes($durationMinutes);

        $hasOverlap = CleanerAssign::query()
            ->where('cleaner_id', $request->cleaner_id)
            ->whereIn('status', ['pending', 'in_progress'])
            ->whereHas('booking', function ($q) use ($startAt, $endAt) {
                $q->where('status', '!=', 'cancelled')->whereNotNull('booking_start_at')->whereNotNull('booking_end_at')->where('booking_start_at', '<', $endAt)->where('booking_end_at', '>', $startAt);
            })
            ->exists();

        return response()->json([
            'available' => !$hasOverlap,
            'message' => $hasOverlap ? 'Busy' : 'Available',
        ]);
    }

    /**
     * ✅ Admin assign cleaner + set booking_start_at/end_at
     * POST: cleaner_id, job_id, start_time
     */
    public function CleanerAssign(Request $request)
    {
        $request->validate([
            'cleaner_id' => 'required|integer',
            'job_id' => 'required|exists:service_bookings,id',
            'start_time' => 'required',
        ]);

        DB::beginTransaction();
        try {
            $booking = ServiceBooking::with('service')->findOrFail($request->job_id);

            if ($booking->status === 'cancelled') {
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'Cancelled booking e cleaner assign kora jabe na',
                    ],
                    422,
                );
            }

            // ✅ booking_date + admin selected time
            $bookingDate = Carbon::parse($booking->booking_date)->toDateString(); // YYYY-MM-DD only
            $startAt = Carbon::parse($bookingDate . ' ' . $request->start_time);

            // ✅ duration from service_duration
            $durationMinutes = $this->getDurationMinutes($booking->service);

            if ($durationMinutes <= 0) {
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'Service duration set kora nai (minutes)',
                    ],
                    422,
                );
            }

            $endAt = $startAt->copy()->addMinutes($durationMinutes);

            // 🔴 Overlap check
            $busy = CleanerAssign::query()
                ->where('cleaner_id', $request->cleaner_id)
                ->whereIn('status', ['pending', 'in_progress'])
                ->whereHas('booking', function ($q) use ($startAt, $endAt) {
                    $q->where('status', '!=', 'cancelled')->whereNotNull('booking_start_at')->whereNotNull('booking_end_at')->where('booking_start_at', '<', $endAt)->where('booking_end_at', '>', $startAt);
                })
                ->exists();

            if ($busy) {
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'Ei time e cleaner busy ache',
                    ],
                    422,
                );
            }

            // ✅ booking time save
            $booking->update([
                'booking_start_at' => $startAt,
                'booking_end_at' => $endAt,
                'progress_status' => 'in_progress',
            ]);

            // ✅ HERE → CleanerAssign replace হবে
            CleanerAssign::updateOrCreate(
                ['job_id' => $booking->id],
                [
                    'cleaner_id' => $request->cleaner_id,
                    'status' => 'in_progress',
                ],
            );

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Cleaner assign & time set successful',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('CleanerAssign error: ' . $e->getMessage());

            return response()->json(
                [
                    'success' => false,
                    'message' => 'Server error: ' . $e->getMessage(),
                ],
                500,
            );
        }
    }

    public function updateProgressStatus(Request $request, $id)
    {
        $request->validate([
            'progress_status' => 'required|in:pending,in_progress,completed,rejected',
        ]);

        $booking = ServiceBooking::findOrFail($id);

        if ($booking->status === 'cancelled') {
            return redirect()->back()->with('message', 'Cancelled booking progress cannot be updated.')->with('alert-type', 'warning');
        }

        if ($request->progress_status === 'completed' && $booking->status !== 'confirmed') {
            return redirect()->back()->with('message', 'Booking must be confirmed before marking completed.')->with('alert-type', 'warning');
        }

        if ($request->progress_status === 'completed' && $booking->payment_method === 'bkash' && $booking->payment_status !== 'verified') {
            return redirect()->back()->with('message', 'bKash payment must be verified before completing.')->with('alert-type', 'warning');
        }

        $booking->update([
            'progress_status' => $request->progress_status,
        ]);

        return redirect()->back()->with('message', 'Progress status updated successfully.')->with('alert-type', 'success');
    }

    private function getDurationMinutes($service): int
    {
        $raw = (string) ($service->service_duration ?? '');

        // numeric হলে
        if (is_numeric(trim($raw))) {
            return (int) trim($raw);
        }

        // "Kitchen Clean 30 mins" => 30 extract
        if (preg_match('/(\d+)/', $raw, $m)) {
            return (int) $m[1];
        }

        return 0;
    }
}
