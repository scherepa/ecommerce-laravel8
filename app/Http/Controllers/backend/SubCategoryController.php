<?php

namespace App\Http\Controllers\backend;

use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SubCategoryController extends Controller
{
    public function index()
    {
        $categories = Category::latest()->get();
        $subcategories = SubCategory::latest()->with(['category', 'sub_subcategory'])->get();
        //dd($subcategories, $categories);
        return view('admin.subcategory.index', compact('categories', 'subcategories'));
    }

    public function store(Request $request)
    {
        $request = $request->merge(['name_en' => trim(strip_tags($request->name_en)), 'name_heb' =>  trim(strip_tags($request->name_heb))]);

        $this->validate($request, [
            'name_en' => 'required|unique:sub_categories|string|max:255|min:2',
            'category_id' => 'required',
            'name_heb' => 'required|string|max:255|min:2'
        ], [
            'category_id.required' => 'Please select category',
            'name_en.required' => 'Please fill in the english category name field',
            'name_en.unique' => 'This is an existing category',
            'name_en.max' => 'Category name is too long... Choose one that is maximum 255 chars!',
            'name_en.min' => 'Category name is too short... Choose one that has at least 2 chars!',
            'name_heb.required' => 'Please fill in the hebrew category name field',
            'name_heb.unique' => 'This is an existing category',
            'name_heb.max' => 'Category name is too long... Choose one that is maximum 255 chars!',
            'name_heb.min' => 'Category name is too short... Choose one that has at least 2 chars!'
        ]);

        SubCategory::create([
            'name_en' => $request->name_en,
            'name_heb' => $request->name_heb,
            'slug_en' => strtolower(str_replace(' ', '-', $request->name_en)),
            'slug_heb' => str_replace(' ', '-', $request->name_heb),
            'category_id' => $request->category_id
        ]);

        return back()->with('success', 'The new category was successfully added');
    }

    public function edit($editId)
    {
        $subcategory = SubCategory::findOrFail($editId);
        $category_id = $subcategory->category->id;
        $categories = Category::all();
        if (!$subcategory) {
            return back()->with('fail', 'There is no such Sub Category');
        }
        return view('admin.subcategory.edit', compact('category_id', 'subcategory', 'categories'));
    }

    public function update(Request $request, $editId)
    {
        //to be sure this brand exists
        $cat = SubCategory::findOrFail($editId);
        if (!$cat) {
            return back()->with('fail', 'There is no such Sub Category');
        } else {

            $request = $request->merge(['name_en' => trim(strip_tags($request->name_en)), 'name_heb' =>  trim(strip_tags($request->name_heb))]);
            if ($request->name_heb == $cat->name_heb && $request->category_id == $cat->category_id && $request->name_en == $cat->name_en) {
                return back()->with('fail', 'There is nothing to update!');
            }
            $bn = "required|max:255|min:2|unique:sub_categories,name_en," . $editId;
            $this->validate($request, [
                'name_en' => $bn,
                'name_heb' => 'required|max:255|min:2',
                'category_id' => 'required'
            ], [
                'category_id.required' => 'Please select category',
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
            'category_id' => $request->category_id,
            'slug_en' => strtolower(str_replace(' ', '-', $request->name_en)),
            'slug_heb' => str_replace(' ', '-', $request->name_heb),
        ]);

        return back()->with('success', 'The Sub Category Was Successfully Updated');
    }

    public function destroy($delId)
    {
        //there is auth:admin guard which is why i don't check it here but I have to be sure that the brand exists
        $cat = SubCategory::findOrFail($delId);
        if ($cat) {
            $cat->delete();
            return back()->with('success', 'The Sub Category Was Successfully Moved to Trash');
        }
        return redirect()->route('admin.show.category')->with('fail', 'Oo...ps! Something went wrong...');
    }
}
