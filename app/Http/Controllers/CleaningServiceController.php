<?php

namespace App\Http\Controllers;

use App\Models\CleaningService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Imagick\Driver;

class CleaningServiceController extends Controller
{
    public function index()
    {
        $service_list = CleaningService::latest()->get();

        return view('backend.cleaning_service.list', compact('service_list'));
    } // End Method

    public function create()
    {
        return view('backend.cleaning_service.add');
    } // End Method

    public function store(Request $request)
    {
        $data = new CleaningService();
        $data->service_title = $request->service_title;
        $data->slug = Str::slug($request->service_slug);
        $data->service_price = $request->service_price;
        $data->service_short_description = $request->service_short_description;
        $data->service_long_description = $request->service_long_description;


        if ($request->hasFile('service_image')) {
            $serviceImage = $request->file('service_image');

            $nameGen = uniqid() . '.' . $serviceImage->getClientOriginalExtension();

            $serviceImage->move(public_path('upload/cleaning_service'), $nameGen);

            $data->service_image = 'upload/cleaning_service/' . $nameGen;
        }

        $data->save();


        return redirect()->route('admin.Service.list');
    } // End Method

    public function edit($id)
    {
        $service_info = CleaningService::findOrFail($id);

        return view('backend.cleaning_service.edit', compact('service_info'));
    } // End Method

    public function update(Request $request, $id)
    {
        $data = CleaningService::findOrFail($id);
        if (!$data) {
            abort(404);
        }

        $data->service_title = $request->service_title;
        $data->slug = Str::slug($request->service_slug);
        $data->service_price = $request->service_price;
        $data->service_short_description = $request->service_short_description;
        $data->service_long_description = $request->service_long_description;

        if ($request->hasFile('service_image')) {
            $serviceImage = $request->file('service_image');
            if (file_exists(base_path('public/' . $data->service_image))) {
                unlink(base_path('public/' . $data->service_image));
            }
            $nameGen = uniqid() . '.' . $serviceImage->getClientOriginalExtension();

            $serviceImage->move(public_path('upload/cleaning_service'), $nameGen);

            $data->service_image = 'upload/cleaning_service/' . $nameGen;
        }

        $data->save();

        return redirect()->route('admin.Service.list');
    } // End Method

    public function delete($id)
    {
        $data = CleaningService::findOrFail($id);

        if (file_exists(base_path('public/' . $data->service_image))) {
            unlink(base_path('public/' . $data->service_image));
        }
        $data->delete();

        return redirect()->route('admin.Service.list');
    } // End Method
}
