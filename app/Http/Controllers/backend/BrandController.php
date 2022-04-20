<?php

namespace App\Http\Controllers\backend;

use App\Models\Admin;
use App\Models\Brand;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BrandController extends Controller
{
    /* if you haven't written it in the web.php then
        to redirect to login page when user is not authorized add: 
            public function __construct(){
                $this->middleware('auth:admin');
                
            } */

    public function index()
    {
        $brands = Brand::latest()->paginate(3);
        //$brands = Brand::latest()->get();
        return view('admin.brand.index', compact('brands'));
    }

    public function store(Request $request)
    {

        $allbrands = Brand::get('image');

        /* if we want images to be stored in storage and not in public we have to write in cmd: php artisan storage:link
        and don't forget toupate:
            APP_URL=http://localhost to APP_URL=http://localhost:8000 in .env */

        $request = $request->merge(['name_en' => trim(strip_tags($request->name_en)), 'name_heb' =>  trim(strip_tags($request->name_heb))]);

        $this->validate($request, [
            'name_en' => 'required|unique:brands|string|max:255|min:2',
            'image' => 'nullable|mimes:jpg,jpeg,png,gif,bmp,svg,webp',
            'name_heb' => 'required|string|max:255|min:2',

        ], [
            'name_en.required' => 'Please fill in the english brand name field',
            'name_en.unique' => 'This is an existing brand',
            'name_en.max' => 'Brand name is too long... Choose one that is maximum 255 chars!',
            'name_en.min' => 'Brand name is too short... Choose one that has at least 2 chars!'
        ]);
        $brand_image = $request->file('image');
        if ($brand_image) {
            do {
                $name_gen = hexdec(uniqid());
                $img_ext = strtolower($brand_image->getClientOriginalExtension());
                $img_name = $name_gen . '.' . $img_ext;
                $up_location = 'images/brands/';
                $last_img = $up_location . $img_name;
                if (!$allbrands) break;
            } while ($allbrands->contains($last_img));
            $brand_image->move($up_location, $img_name);
        }
        Brand::create([
            'name_en' => $request->name_en,
            'name_heb' => $request->name_heb,
            'slug_en' => strtolower(str_replace(' ', '-', $request->name_en)),
            'slug_heb' => str_replace(' ', '-', $request->name_heb),
            'image' => $brand_image ? $last_img : NULL
        ]);
        return back()->with('success', 'The new brand was successfully added');
    }

    public function edit($brand)
    {
        $brand = Brand::find($brand);
        if (!$brand) {
            return back()->with('fail', 'There is no such Brand');
        }
        return view('admin.brand.edit', compact('brand'));
    }

    public function update(Request $request, $editId)
    {
        //to be sure this brand exists
        $brand = Brand::findOrFail($editId);
        if (!$brand) {
            return back()->with('fail', 'There is no such Brand');
        }
        //need to know if to unlink and what to give for update
        $old_image = $brand->image;
        //I need to know if to clean it and if there is nothing to update
        $old_name = $brand->name_en;
        if ($request->image == NULL && $request->name_en == $old_name && $request->name_heb == $brand->name_heb) {
            return back()->with('fail', 'Nothing To Update');
        }
        $bn = "required|max:255|min:2|unique:brands,name_en," . $editId;
        $request = $request->merge(['image' => ($request->image != NULL) ? $request->image : $old_image]);
        $request = $request->merge(['name_en' => $request->name_en != $old_name ? trim(strip_tags($request->name_en)) : $old_name]);
        $request = $request->merge(['name_heb' => $request->name_en != $old_name ? trim(strip_tags($request->name_heb)) : $old_name]);
        $image = $request->file('image');
        //there is a new image passed so no need in required
        if ($image) {
            $this->validate($request, [
                'name_en' => $bn,
                'name_heb' => "required|max:255|min:2",
                'image' => 'nullable|mimes:jpg,jpeg,png,gif,bmp,svg,webp'
            ], [
                'name_en.unique' => 'This is an existing brand',
                'name_en.max' => 'Brand name is too long... Choose one that is maximum 255 chars!',
                'name_en.min' => 'Brand name is too short... Choose one that has at least 2 chars!'
            ]);
            $name_gen = hexdec(uniqid());
            $img_ext = strtolower($image->getClientOriginalExtension());
            $img_name = $name_gen . '.' . $img_ext;
            $up_location = 'images/brands/';
            $last_img = $up_location . $img_name;
            $image->move($up_location, $img_name);
            unlink($old_image);
        } else {
            $this->validate($request, [
                'name_en' => $bn,
                'name_heb' => 'required|max:255|min:2'
            ], [
                'name_en.unique' => 'This is an existing brand',
                'name_en.max' => 'Brand name is too long... Choose one that is maximum 255 chars!',
                'name_en.min' => 'Brand name is too short... Choose one that has at least 4 chars!'
            ]);
        }
        $brand->update([
            'name_en' => $request->name_en,
            'name_heb' => $request->name_heb,
            'image' => $request->image != $old_image ? $last_img : $old_image,
            'slug_en' => strtolower(str_replace(' ', '-', $request->name_en)),
            'slug_heb' => str_replace(' ', '-', $request->name_heb),
        ]);

        return back()->with('success', 'The Brand Was Successfully Updated');
    }

    public function destroy($delId)
    {
        //there is auth:admin guard which is why i don't check it here but I have to be sure that the brand exists
        $brand = Brand::find($delId);
        if ($brand) {
            if ($brand->image) {
                unlink($brand->image);
            }
            $brand->delete();
            return back()->with('success', 'The Brand Was Successfully Moved to Trash');
        }
        return redirect()->route('admin.show.brand');
    }
}
