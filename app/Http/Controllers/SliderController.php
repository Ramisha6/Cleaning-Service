<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class SliderController extends Controller
{
    public function list()
    {
        $slider_list = Slider::orderBy('id', 'asc')->get();

        return view('backend.slider.list', compact('slider_list'));
    } // End Method

    public function add()
    {
        return view('backend.slider.add');
    } // End Method

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'slider_image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            ],
            [
                'slider_image.required' => 'Service image is required',
            ],
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();

            $data = new Slider();

            if ($request->hasFile('slider_image')) {
                $file = $request->file('slider_image');
                $fileName = uniqid('slider_') . '.' . $file->getClientOriginalExtension();

                $manager = new ImageManager(new Driver());
                $image = $manager->read($file->getRealPath());
                $image->resize(1920, 780);
                $image->save(public_path('upload/slider_image/' . $fileName));

                $data->slider_image = $fileName;
            }

            $data->save();

            DB::commit();

            return redirect()->route('admin.slider.list')->with('message', 'Slider created successfully!')->with('alert-type', 'success');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error($e->getMessage());

            return redirect()->back()->withInput()->with('message', 'Something went wrong!')->with('alert-type', 'error');
        }
    } // End Method

    public function edit($id)
    {
        $slider_info = Slider::findOrFail($id);

        return view('backend.slider.edit', compact('slider_info'));
    } // End Method

    public function update(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'slider_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            ],
            [
                'slider_image.image' => 'Service image must be an image file',
            ],
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();

            $data = Slider::findOrFail($id);
            $data->slider_status = $request->slider_status;

            if ($request->hasFile('slider_image')) {
                if ($data->slider_image && file_exists(public_path('upload/slider_image/' . $data->slider_image))) {
                    @unlink(public_path('upload/slider_image/' . $data->slider_image));
                }

                $file = $request->file('slider_image');
                $fileName = uniqid('slider_') . '.' . $file->getClientOriginalExtension();

                $manager = new ImageManager(new Driver());
                $image = $manager->read($file->getRealPath());
                $image->resize(1920, 780);
                $image->save(public_path('upload/slider_image/' . $fileName));

                $data->slider_image = $fileName;
            }

            $data->save();

            DB::commit();

            return redirect()->route('admin.slider.list')->with('message', 'Slider updated successfully!')->with('alert-type', 'success');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error($e->getMessage());

            return redirect()->back()->withInput()->with('message', 'Failed to update Slider.')->with('alert-type', 'error');
        }
    } // End Method

    public function delete($id)
    {
        try {
            DB::beginTransaction();

            $data = Slider::findOrFail($id);

            if ($data->slider_image) {
                $oldImage = public_path('upload/slider_image/' . $data->slider_image);
                if (file_exists($oldImage)) {
                    @unlink($oldImage);
                }
            }

            $data->delete();

            DB::commit();

            return redirect()
                ->route('admin.slider.list')
                ->with([
                    'message' => 'Slider deleted successfully!',
                    'alert-type' => 'success',
                ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Error deleting Slider: ' . $e->getMessage());
            return redirect()
                ->back()
                ->with([
                    'message' => 'Failed to delete Slider.',
                    'alert-type' => 'error',
                ]);
        }
    } // End Method
}
