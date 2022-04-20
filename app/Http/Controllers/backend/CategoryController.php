<?php

namespace App\Http\Controllers\backend;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    /* if you haven't written it in the web.php then
        to redirect to login page when user is not authorized add: 
            public function __construct(){
                $this->middleware('auth:admin');
                
            } */

    public function index()
    {
        $categories = Category::latest()->get();
        return view('admin.category.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request = $request->merge(['name_en' => trim(strip_tags($request->name_en)), 'name_heb' =>  trim(strip_tags($request->name_heb)), 'icon' =>  trim(strip_tags($request->icon))]);

        $this->validate($request, [
            'name_en' => 'required|unique:categories|string|max:255|min:2',
            'icon' => 'required|string|max:255',
            'name_heb' => 'required|string|max:255|min:2'
        ], [
            'name_en.required' => 'Please fill in the english category name field',
            'name_en.unique' => 'This is an existing category',
            'name_en.max' => 'Category name is too long... Choose one that is maximum 255 chars!',
            'name_en.min' => 'Category name is too short... Choose one that has at least 2 chars!',
            'name_heb.required' => 'Please fill in the hebrew category name field',
            'name_heb.unique' => 'This is an existing category',
            'name_heb.max' => 'Category name is too long... Choose one that is maximum 255 chars!',
            'name_heb.min' => 'Category name is too short... Choose one that has at least 2 chars!'
        ]);

        Category::create([
            'name_en' => $request->name_en,
            'name_heb' => $request->name_heb,
            'slug_en' => strtolower(str_replace(' ', '-', $request->name_en)),
            'slug_heb' => str_replace(' ', '-', $request->name_heb),
            'icon' => $request->icon ? $request->icon : NULL
        ]);
        return back()->with('success', 'The new category was successfully added');
    }

    public function edit($editId)
    {
        $category = Category::find($editId);
        if (!$category) {
            return back()->with('fail', 'There is no such Category');
        }
        return view('admin.category.edit', compact('category'));
    }

    public function update(Request $request, $editId)
    {
        //to be sure this brand exists
        $cat = Category::find($editId);
        if (!$cat) {
            return back()->with('fail', 'There is no such Category');
        } else {
            $request = $request->merge(['name_en' => trim(strip_tags($request->name_en)), 'name_heb' =>  trim(strip_tags($request->name_heb)), 'icon' =>  trim(strip_tags($request->icon))]);
            if ($request->name_heb == $cat->name_heb && $request->icon == $cat->icon && $request->name_en == $cat->name_en) {
                return back()->with('fail', 'There is nothing to update!');
            }
            $bn = "required|max:255|min:2|unique:categories,name_en," . $editId;
            $this->validate($request, [
                'name_en' => $bn,
                'name_heb' => 'required|max:255|min:2',
                'icon' => 'required|string|max:255'
            ], [
                'name_en.required' => 'Please fill in the english category name field',
                'name_en.unique' => 'This is an existing category',
                'name_en.max' => 'Category name is too long... Choose one that is maximum 255 chars!',
                'name_en.min' => 'Category name is too short... Choose one that has at least 2 chars!',
                'name_heb.required' => 'Please fill in the hebrew category name field',
                'name_heb.unique' => 'This is an existing category',
                'name_heb.max' => 'Category name is too long... Choose one that is maximum 255 chars!',
                'name_heb.min' => 'Category name is too short... Choose one that has at least 2 chars!'
            ]);
        }
        $cat->update([
            'name_en' => $request->name_en,
            'name_heb' => $request->name_heb,
            'icon' => $request->icon,
            'slug_en' => strtolower(str_replace(' ', '-', $request->name_en)),
            'slug_heb' => str_replace(' ', '-', $request->name_heb),
        ]);

        return back()->with('success', 'The Brand Was Successfully Updated');
    }

    public function destroy($delId)
    {
        //there is auth:admin guard which is why i don't check it here but I have to be sure that the brand exists
        $cat = Category::find($delId);
        if ($cat) {
            $cat->delete();
            return back()->with('success', 'The Category Was Successfully Moved to Trash');
        }
        return redirect()->route('admin.show.category')->with('fail', 'Oo...ps! Something went wrong...');
    }
}
