<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\ServiceBooking;

class AdminController extends Controller
{
    public function dashboard()
    {
        $admin_data = Auth::user();

        // ✅ Booking counts (FIXED: progress_status)
        $total_bookings = ServiceBooking::count();
        $pending_bookings = ServiceBooking::where('status', 'pending')->count();
        $in_progress_bookings = ServiceBooking::where('progress_status', 'in_progress')->count();
        $completed_bookings = ServiceBooking::where('progress_status', 'completed')->count();

        // ✅ Monthly sales report
        $monthlySales = DB::table('service_bookings as sb')
            ->join('cleaning_services as cs', 'cs.id', '=', 'sb.service_id')
            ->selectRaw(
                "
                DATE_FORMAT(sb.booking_date, '%Y-%m') as month,
                COUNT(sb.id) as total_orders,
                SUM(CAST(cs.service_price AS DECIMAL(10,2))) as total_sales
            ",
            )
            ->where('sb.progress_status', 'completed')
            ->where(function ($q) {
                $q->where('sb.payment_method', 'cod')->orWhere(function ($q2) {
                    $q2->where('sb.payment_method', 'bkash')->where('sb.payment_status', 'verified');
                });
            })
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();

        // ✅ Latest bookings (table)
        $latestBookings = DB::table('service_bookings as sb')->join('cleaning_services as cs', 'cs.id', '=', 'sb.service_id')->select('sb.id', 'sb.invoice_no', 'sb.name', 'sb.phone', 'sb.booking_date', 'sb.payment_method', 'sb.payment_status', 'sb.status', 'sb.progress_status', 'cs.service_title', DB::raw('CAST(cs.service_price AS DECIMAL(10,2)) as service_price'))->orderBy('sb.id', 'desc')->limit(10)->get();

        // ✅ Chart data
        $chartLabels = $monthlySales->pluck('month')->toArray();
        $chartData = $monthlySales->pluck('total_sales')->toArray();

        return view('admin.index', compact('admin_data', 'total_bookings', 'pending_bookings', 'in_progress_bookings', 'completed_bookings', 'monthlySales', 'latestBookings', 'chartLabels', 'chartData'));
    }

    // existing login method (unchanged)
    public function store(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('admin.dashboard')->with('success', 'Login successful');
        }

        return back()
            ->withErrors(['email' => 'Invalid email or password.'])
            ->withInput();
    }
}
