<?php

namespace App\Http\Controllers;

use App\Models\CleaningService;
use App\Models\CleaningServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class CleaningServiceController extends Controller
{
    public function index()
    {
        $service_list = CleaningServices::latest()->get();

        return view('backend.cleaning_service.list', compact('service_list'));
    } // End Method

    public function create()
    {
        return view('backend.cleaning_service.add');
    } // End Method

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'service_title' => 'required|string|max:255',
                'service_slug' => 'required|string|max:255|unique:cleaning_services,service_slug',
                'service_price' => 'required|numeric|min:0',
                'service_short_description' => 'required|string',
                'service_long_description' => 'required|string',
                'service_image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            ],
            [
                'service_title.required' => 'Service title is required',
                'service_slug.required' => 'Service slug is required',
                'service_slug.unique' => 'Service slug already exists',
                'service_price.required' => 'Service price is required',
                'service_price.numeric' => 'Service price must be numeric',
                'service_short_description.required' => 'Short description is required',
                'service_long_description.required' => 'Long description is required',
                'service_image.required' => 'Service image is required',
            ],
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();

            $service = new CleaningServices();
            $service->service_title = $request->service_title;
            $service->service_slug = Str::slug($request->service_slug);
            $service->service_price = $request->service_price;
            $service->service_short_description = $request->service_short_description;
            $service->service_long_description = $request->service_long_description;

            if ($request->hasFile('service_image')) {
                $file = $request->file('service_image');
                $fileName = uniqid('service_') . '.' . $file->getClientOriginalExtension();

                $manager = new ImageManager(new Driver());
                $image = $manager->read($file->getRealPath());
                $image->resize(914, 536);
                $image->save(public_path('upload/service_image/' . $fileName));

                $service->service_image = $fileName;
            }

            $service->save();

            DB::commit();

            return redirect()->route('admin.Service.list')->with('message', 'Cleaning Service created successfully!')->with('alert-type', 'success');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error($e->getMessage());

            return redirect()->back()->withInput()->with('message', 'Something went wrong!')->with('alert-type', 'error');
        }
    } // End Method

    public function edit($id)
    {
        $service_info = CleaningServices::findOrFail($id);

        return view('backend.cleaning_service.edit', compact('service_info'));
    } // End Method

    public function update(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'service_title' => 'required|string|max:255',
                'service_slug' => 'required|string|max:255|unique:cleaning_services,service_slug,' . $id,
                'service_price' => 'required|numeric|min:0',
                'service_short_description' => 'required|string',
                'service_long_description' => 'required|string',
                'service_status' => 'required|in:active,inactive',
                'service_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            ],
            [
                'service_title.required' => 'Service title is required',
                'service_slug.required' => 'Service slug is required',
                'service_slug.unique' => 'Service slug already exists',
                'service_price.required' => 'Service price is required',
                'service_price.numeric' => 'Service price must be numeric',
                'service_short_description.required' => 'Short description is required',
                'service_long_description.required' => 'Long description is required',
                'service_image.image' => 'Service image must be an image file',
            ],
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();

            $service = CleaningServices::findOrFail($id);

            $service->service_title = $request->service_title;
            $service->service_slug = Str::slug($request->service_slug);
            $service->service_price = $request->service_price;
            $service->service_short_description = $request->service_short_description;
            $service->service_long_description = $request->service_long_description;
            $service->service_status = $request->service_status;

            if ($request->hasFile('service_image')) {
                if ($service->service_image && file_exists(public_path('upload/service_image/' . $service->service_image))) {
                    @unlink(public_path('upload/service_image/' . $service->service_image));
                }

                $file = $request->file('service_image');
                $fileName = uniqid('service_') . '.' . $file->getClientOriginalExtension();

                $manager = new ImageManager(new Driver());
                $image = $manager->read($file->getRealPath());
                $image->resize(914, 536);
                $image->save(public_path('upload/service_image/' . $fileName));

                $service->service_image = $fileName;
            }

            $service->save();

            DB::commit();

            return redirect()->back()->with('message', 'Cleaning Service updated successfully!')->with('alert-type', 'success');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error($e->getMessage());

            return redirect()->back()->withInput()->with('message', 'Failed to update Cleaning Service.')->with('alert-type', 'error');
        }
    } // End Method

    public function delete($id)
    {
        try {
            DB::beginTransaction();

            $service_data = CleaningServices::findOrFail($id);

            if ($service_data->service_image) {
                $oldImage = public_path('upload/service_image/' . $service_data->service_image);
                if (file_exists($oldImage)) {
                    @unlink($oldImage);
                }
            }

            $service_data->delete();

            DB::commit();

            return redirect()
                ->route('admin.Service.list')
                ->with([
                    'message' => 'Cleaning Service deleted successfully!',
                    'alert-type' => 'success',
                ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Error deleting Cleaning Service: ' . $e->getMessage());
            return redirect()
                ->back()
                ->with([
                    'message' => 'Failed to delete Cleaning Service.',
                    'alert-type' => 'error',
                ]);
        }
    } // End Method
}
