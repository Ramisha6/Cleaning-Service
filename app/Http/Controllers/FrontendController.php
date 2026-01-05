<?php

namespace App\Http\Controllers;

use App\Models\CleaningServices;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function Index()
    {
        $services = CleaningServices::where('service_status', 'active')->latest()->get();

        return view('frontend.index', compact('services'));
    }

    public function ServiceDetails($slug)
    {
        $service_details = CleaningServices::where('service_slug', $slug)->where('service_status', 'active')->firstOrFail();

        $service_list = CleaningServices::where('service_status', 'active')->orderBy('service_title')->latest()->take(5)->get();

        return view('frontend.details.service_details', compact('service_details', 'service_list'));
    } // End Method
}
