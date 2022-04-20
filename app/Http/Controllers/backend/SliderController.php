<?php

namespace App\Http\Controllers\backend;

use App\Models\Slider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SliderController extends Controller
{
    public function index()
    {
        return view('admin.slider.index');
    }

    public function store(Request $request)
    {

        $allsliders = Slider::pluck('slider_img');

        /* if we want images to be stored in storage and not in public we have to write in cmd: php artisan storage:link
        and don't forget toupate:
            APP_URL=http://localhost to APP_URL=http://localhost:8000 in .env */

        $request = $request->merge(['title' => trim(strip_tags($request->title)), 'description' =>  trim(strip_tags($request->description))]);

        //dd($request);

        $this->validate($request, [
            'title' => 'nullable|string|max:255|min:2',
            'thumbnail' => 'required|mimes:jpg,jpeg,png,gif,bmp,svg,webp',
            'description' => 'nullable|string|min:2'
        ]);
        $slider_image = $request->file('thumbnail');
        if ($slider_image) {
            do {
                $name_gen = hexdec(uniqid());
                $img_ext = strtolower($slider_image->getClientOriginalExtension());
                $img_name = $name_gen . '.' . $img_ext;
                $up_location = 'images/sliders/';
                $last_img = $up_location . $img_name;
                if (!$allsliders) break;
            } while ($allsliders->contains($last_img));
            $slider_image->move($up_location, $img_name);
        }
        Slider::create([
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status ? $request->status : 0,
            'slider_img' => $last_img
        ]);
        return back()->with('success', 'The new slider was successfully added');
    }

    public function edit($editId)
    {
        $slide = Slider::find($editId);
        if (!$slide) {
            return back()->with('fail', 'There is no such slide');
        }
        return view('admin.slider.edit', compact('slide'));
    }

    public function update($updateId, Request $request)
    {
        //dd($request);
        $slide = Slider::find($updateId);
        if (!$slide) {
            return back()->with('fail', 'There is no such slide');
        }

        /* if we want images to be stored in storage and not in public we have to write in cmd: php artisan storage:link
        and don't forget toupate:
            APP_URL=http://localhost to APP_URL=http://localhost:8000 in .env */
        if ($request->title != $slide->title) {
            $request = $request->merge(['title' => trim(strip_tags($request->title))]);
            $this->validate($request, ['title' => 'nullable|string|max:255|min:2']);
            $slide->update(['title' => $request->title]);
        }

        if ($request->description != $slide->description) {
            $request = $request->merge(['description' => trim(strip_tags($request->description))]);
            $this->validate($request, ['description' => 'nullable|string|min:2']);
            $slide->update(['description' => $request->description]);
        }

        if ($request->disactivate) {
            $slide->update(['status' => 0]);
        }
        if ($request->activate) {
            $slide->update(['status' => 1]);
        }


        $slider_image = $request->file('thumbnail');
        if ($slider_image) {
            $this->validate($request, [
                'thumbnail' => 'required|mimes:jpg,jpeg,png,gif,bmp,svg,webp'
            ]);
            $allsliders = Slider::pluck('slider_img');
            do {
                $name_gen = hexdec(uniqid());
                $img_ext = strtolower($slider_image->getClientOriginalExtension());
                $img_name = $name_gen . '.' . $img_ext;
                $up_location = 'images/sliders/';
                $last_img = $up_location . $img_name;
                if (!$allsliders) break;
            } while ($allsliders->contains($last_img));
            $slider_image->move($up_location, $img_name);
            unlink($slide->slider_img);
            $slide->update([
                'slider_img' => $last_img
            ]);
        }
        return back()->with('success', 'The new slider was successfully updated');
    }
}
