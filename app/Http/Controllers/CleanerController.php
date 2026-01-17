<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ServiceBooking;
use App\Models\CleanerAssign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CleanerController extends Controller
{
    public function CleanerLoginStore(Request $request)
    {
        // 1️⃣ Validate input
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // 2️⃣ Attempt login
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->route('cleaner.dashboard')->with('success', 'Login successful');
        }

        // 3️⃣ Login failed
        return back()
            ->withErrors([
                'email' => 'Invalid email or password.',
            ])
            ->withInput();
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

    public function CleanerBookingList()
    {
        $cleaner_id = Auth::user()->id;
        $booking_list = CleanerAssign::where('cleaner_id', $cleaner_id)->with('booking')->get();

        return view('cleaner.booking.list', compact('booking_list'));
    }

    // public function updateStatus(Request $request)
    // {
    //     $request->validate([
    //         'booking_id' => 'required|exists:service_bookings,id',
    //         'status' => 'required|in:pending,in_progress,completed,rejected',
    //     ]);

    //     $cleanerId = Auth::id();

    //     $assignment = CleanerAssign::where('job_id', $request->booking_id)->where('cleaner_id', $cleanerId)->first();

    //     if (!$assignment) {
    //         return response()->json(
    //             [
    //                 'success' => false,
    //                 'message' => 'Assignment not found',
    //             ],
    //             404,
    //         );
    //     }

    //     $assignment->status = $request->status;
    //     $assignment->save();

    //     // Optionally update the booking progress_status as well
    //     $booking = ServiceBooking::find($request->booking_id);
    //     if ($booking) {
    //         $booking->progress_status = $request->status;
    //         $booking->save();
    //     }

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Status updated successfully',
    //     ]);
    // }

    public function updateStatus(Request $request)
    {
        $request->validate([
            'booking_id' => 'required|exists:cleaner_assigns,id', // এখানে cleaner_assigns হবে
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

        // Booking এর progress_status ও update করা
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
        // dd($booking);
        return view('cleaner.booking.show', compact('booking'));
    }
}
