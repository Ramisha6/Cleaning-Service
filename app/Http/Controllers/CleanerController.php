<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ServiceBooking;
use App\Models\CleanerAssign;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CleanerController extends Controller
{
    // ✅ Cleaner Dashboard with FREE SLOTS + schedule
    public function dashboard()
    {
        $cleaner = Auth::user();
        // counts
        $total_bookings = CleanerAssign::where('cleaner_id', $cleaner->id)->count();
        $pending_bookings = CleanerAssign::where('cleaner_id', $cleaner->id)->where('status', 'pending')->count();
        $in_progress_bookings = CleanerAssign::where('cleaner_id', $cleaner->id)->where('status', 'in_progress')->count();
        $completed_bookings = CleanerAssign::where('cleaner_id', $cleaner->id)->where('status', 'completed')->count();

        // ✅ Next 7 days assigned bookings (active jobs)
        $from = Carbon::today()->startOfDay();
        $to = Carbon::today()->addDays(7)->endOfDay();

        $assignedBookings = CleanerAssign::where('cleaner_id', $cleaner->id)
            ->whereIn('status', ['pending', 'in_progress'])
            ->whereHas('booking', function ($q) use ($from, $to) {
                $q->where('status', '!=', 'cancelled')
                    ->whereNotNull('booking_start_at')
                    ->whereNotNull('booking_end_at')
                    ->whereBetween('booking_start_at', [$from, $to]);
            })
            ->with([
                'booking' => function ($q) {
                    $q->orderBy('booking_start_at', 'asc');
                },
            ])
            ->get()
            ->pluck('booking')
            ->filter()
            ->values();

        // ✅ Today's busy bookings
        $todayBookings = $assignedBookings
            ->filter(function ($b) {
                return Carbon::parse($b->booking_start_at)->isToday();
            })
            ->sortBy('booking_start_at')
            ->values();

        // ✅ Working hour (edit if needed)
        $workStart = Carbon::today()->setTime(9, 0);
        $workEnd = Carbon::today()->setTime(20, 0);

        // ✅ Free slots calculation
        $freeSlots = [];
        $cursor = $workStart->copy();

        foreach ($todayBookings as $job) {
            $jobStart = Carbon::parse($job->booking_start_at);
            $jobEnd = Carbon::parse($job->booking_end_at);

            if ($cursor->lt($jobStart)) {
                $freeSlots[] = ['from' => $cursor->copy(), 'to' => $jobStart->copy()];
            }

            if ($cursor->lt($jobEnd)) {
                $cursor = $jobEnd->copy();
            }
        }

        if ($cursor->lt($workEnd)) {
            $freeSlots[] = ['from' => $cursor->copy(), 'to' => $workEnd->copy()];
        }

        return view('cleaner.index', compact('total_bookings', 'cleaner', 'pending_bookings', 'in_progress_bookings', 'completed_bookings', 'todayBookings', 'freeSlots', 'assignedBookings'));
    }

    // ---------------- existing cleaner login/store etc ----------------

    public function CleanerLoginStore(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('cleaner.dashboard')->with('success', 'Login successful');
        }

        return back()
            ->withErrors(['email' => 'Invalid email or password.'])
            ->withInput();
    }

    public function CleanerBookingList()
    {
        $cleaner_id = Auth::user()->id;
        $booking_list = CleanerAssign::where('cleaner_id', $cleaner_id)->orderBy('created_at', 'desc')->with('booking')->get();
        return view('cleaner.booking.list', compact('booking_list'));
    }

    public function updateStatus(Request $request)
    {
        $request->validate([
            'booking_id' => 'required|exists:cleaner_assigns,id',
            'status' => 'required|in:pending,in_progress,completed,rejected',
        ]);

        $cleanerId = Auth::id();

        $assignment = CleanerAssign::where('id', $request->booking_id)->where('cleaner_id', $cleanerId)->first();

        if (!$assignment) {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Assignment not found or unauthorized',
                ],
                404,
            );
        }

        $assignment->status = $request->status;
        $assignment->save();

        // update booking progress_status also
        $booking = ServiceBooking::find($assignment->job_id);
        if ($booking) {
            $booking->progress_status = $request->status;
            $booking->save();
        }

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully',
        ]);
    }

    public function showBooking($id)
    {
        $booking = ServiceBooking::findOrFail($id);
        return view('cleaner.booking.show', compact('booking'));
    }

    public function index()
    {
        $cleaner_list = User::where('role', 'cleaner')->latest()->get();
        return view('backend.cleaner.list', compact('cleaner_list'));
    }

    public function create()
    {
        return view('backend.cleaner.add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'cleaner',
        ]);

        return redirect()->route('admin.cleaner.list')->with('message', 'Cleaner created successfully!')->with('alert-type', 'success');
    }

    public function edit($id)
    {
        $cleaner = User::where('role', 'cleaner')->findOrFail($id);
        return view('backend.cleaner.edit', compact('cleaner'));
    }

    public function update(Request $request, $id)
    {
        $cleaner = User::where('role', 'cleaner')->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $cleaner->id,
        ]);

        $cleaner->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return back()->with('message', 'Cleaner updated successfully!')->with('alert-type', 'success');
    }

    public function delete($id)
    {
        User::where('role', 'cleaner')->findOrFail($id)->delete();

        return back()->with('message', 'Cleaner deleted successfully!')->with('alert-type', 'success');
    }
}
