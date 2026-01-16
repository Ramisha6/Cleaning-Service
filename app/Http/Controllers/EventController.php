<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class EventController extends Controller
{
    public function list()
    {
        $event_list = Event::latest()->get();

        return view('backend.event.list', compact('event_list'));
    } // End Method

    public function add()
    {
        return view('backend.event.add');
    } // End Method

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'title' => 'required|string|max:255',
                'slug' => 'required|string|max:255|unique:events,slug',
                'event_date' => 'required|date',
                'event_time' => 'nullable|date_format:H:i',
                'location' => 'nullable|string|max:255',
                'short_description' => 'nullable|string',
                'description' => 'required|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            ],
            [
                'title.required' => 'Event title is required',
                'slug.required' => 'Event slug is required',
                'slug.unique' => 'Event slug already exists',

                'event_date.required' => 'Event date is required',
                'event_date.date' => 'Event date is not valid',

                'event_time.date_format' => 'Event time must be like 14:30',

                'description.required' => 'Event details is required',

                'image.image' => 'Event image must be an image file',
                'image.mimes' => 'Event image must be jpeg, png, jpg, or webp',
                'image.max' => 'Event image must be maximum 2MB',
            ],
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();

            $event = new Event();
            $event->title = $request->title;
            $event->slug = Str::slug($request->slug);

            $event->event_date = $request->event_date;
            $event->event_time = $request->event_time; // nullable ok

            $event->location = $request->location;
            $event->short_description = $request->short_description;
            $event->description = $request->description;

            if ($request->hasFile('event_image')) {
                $file = $request->file('event_image');
                $fileName = uniqid('event_') . '.' . $file->getClientOriginalExtension();

                $manager = new ImageManager(new Driver());
                $image = $manager->read($file->getRealPath());

                // Resize like your blog/service card size (change if you want)
                $image->resize(914, 536);

                $uploadPath = public_path('upload/event_image/');
                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0777, true);
                }

                $image->save($uploadPath . $fileName);

                $event->event_image = $fileName;
            }

            $event->save();

            DB::commit();

            return redirect()->route('admin.event.list')->with('message', 'Event created successfully!')->with('alert-type', 'success');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error($e->getMessage());

            return redirect()->back()->withInput()->with('message', 'Something went wrong!')->with('alert-type', 'error');
        }
    } // End Method

    public function edit($id)
    {
        $event_info = Event::findOrFail($id);

        return view('backend.event.edit', compact('event_info'));
    } // End Method

    public function update(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'title' => 'required|string|max:255',
                'slug' => 'required|string|max:255|unique:events,slug,' . $id,
                'event_date' => 'required|date',
                'event_time' => 'nullable|date_format:H:i',
                'location' => 'nullable|string|max:255',
                'short_description' => 'nullable|string',
                'description' => 'required|string',
                'status' => 'required|in:active,inactive',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            ],
            [
                'title.required' => 'Event title is required',
                'slug.required' => 'Event slug is required',
                'slug.unique' => 'Event slug already exists',

                'event_date.required' => 'Event date is required',
                'event_date.date' => 'Event date is not valid',

                'event_time.date_format' => 'Event time must be like 14:30',

                'description.required' => 'Event details is required',

                'status.required' => 'Status is required',
                'status.in' => 'Status must be active or inactive',

                'image.image' => 'Event image must be an image file',
                'image.mimes' => 'Event image must be jpeg, png, jpg, or webp',
                'image.max' => 'Event image must be maximum 2MB',
            ],
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();

            $event = Event::findOrFail($id);

            $event->title = $request->title;
            $event->slug = Str::slug($request->slug);

            $event->event_date = $request->event_date;
            $event->event_time = $request->event_time; // nullable ok

            $event->location = $request->location;
            $event->short_description = $request->short_description;
            $event->description = $request->description;

            $event->status = $request->status;

            if ($request->hasFile('event_image')) {
                // Delete old image
                if ($event->event_image && file_exists(public_path('upload/event_image/' . $event->event_image))) {
                    @unlink(public_path('upload/event_image/' . $event->event_image));
                }

                $file = $request->file('event_image');
                $fileName = uniqid('event_') . '.' . $file->getClientOriginalExtension();

                $manager = new ImageManager(new Driver());
                $image = $manager->read($file->getRealPath());
                $image->resize(914, 536);

                $uploadPath = public_path('upload/event_image/');
                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0777, true);
                }

                $image->save($uploadPath . $fileName);

                $event->event_image = $fileName;
            }

            $event->save();

            DB::commit();

            return redirect()->route('admin.event.list')->with('message', 'Event updated successfully!')->with('alert-type', 'success');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error($e->getMessage());

            return redirect()->back()->withInput()->with('message', 'Failed to update Event.')->with('alert-type', 'error');
        }
    } // End Method

    public function delete($id)
    {
        try {
            DB::beginTransaction();

            $data = Event::findOrFail($id);

            if ($data->event_image) {
                $oldImage = public_path('upload/event_image/' . $data->event_image);
                if (file_exists($oldImage)) {
                    @unlink($oldImage);
                }
            }

            $data->delete();

            DB::commit();

            return redirect()
                ->route('admin.event.list')
                ->with([
                    'message' => 'Event deleted successfully!',
                    'alert-type' => 'success',
                ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Error deleting Event: ' . $e->getMessage());
            return redirect()
                ->back()
                ->with([
                    'message' => 'Failed to delete Event.',
                    'alert-type' => 'error',
                ]);
        }
    } // End Method
}
