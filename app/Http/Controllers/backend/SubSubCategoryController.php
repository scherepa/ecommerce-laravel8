<?php

namespace App\Http\Controllers\backend;

use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use App\Models\SubSubCategory;
use App\Http\Controllers\Controller;

class SubSubCategoryController extends Controller
{
    public function index()
    {
        $categories = Category::latest()->get();
        //$subcategories = SubCategory::latest()->get();
        $subsubcategories = SubSubCategory::latest()->with(['category', 'subcategory'])->get();
        return view('admin.subsubcategory.index', compact('categories', 'subsubcategories'));
    }

    public function store(Request $request)
    {
        $request = $request->merge(['name_en' => trim(strip_tags($request->name_en)), 'name_heb' =>  trim(strip_tags($request->name_heb))]);

        $this->validate($request, [
            'name_en' => 'required|unique:sub_sub_categories|string|max:255|min:2',
            'category_id' => 'required',
            'sub_category_id' => 'required',
            'name_heb' => 'required|string|max:255|min:2'
        ], [
            'category_id.required' => 'Please select category',
            'sub_category_id.required' => 'Please select sub category',
            'name_en.required' => 'Please fill in the english sub sub category name field',
            'name_en.unique' => 'This is an existing sub sub category',
            'name_en.max' => 'Sub Sub Category name is too long... Choose one that is maximum 255 chars!',
            'name_en.min' => 'Sub Sub Category name is too short... Choose one that has at least 2 chars!',
            'name_heb.required' => 'Please fill in the hebrew sub sub category name field',
            'name_heb.max' => 'Sub Sub Category name is too long... Choose one that is maximum 255 chars!',
            'name_heb.min' => 'Sub Sub Category name is too short... Choose one that has at least 2 chars!'
        ]);

        SubSubCategory::create([
            'name_en' => $request->name_en,
            'name_heb' => $request->name_heb,
            'slug_en' => strtolower(str_replace(' ', '-', $request->name_en)),
            'slug_heb' => str_replace(' ', '-', $request->name_heb),
            'category_id' => $request->category_id,
            'sub_category_id' => $request->sub_category_id
        ]);

        return back()->with('success', 'The new sub sub category was successfully added');
    }

    public function edit($editId)
    {
        $subsubcategory = SubSubCategory::findOrFail($editId);
        $subcategory_id = $subsubcategory->subcategory_id;
        $category_id = $subsubcategory->category->id;
        $categories = Category::all();
        $subcategories = SubCategory::all();
        if (!$subsubcategory) {
            return back()->with('fail', 'There is no such Sub Category');
        }
        return view('admin.subsubcategory.edit', compact('category_id', 'subcategory_id', 'categories', 'subcategories', 'subsubcategory'));
    }

    public function update(Request $request, $editId)
    {
        //to be sure this sub sub category exists... but doing find or fail
        $cat = SubSubCategory::findOrFail($editId);
        if (!$cat) {
            return back()->with('fail', 'There is no such Sub Sub Category');
        } else {

            $request = $request->merge(['name_en' => trim(strip_tags($request->name_en)), 'name_heb' =>  trim(strip_tags($request->name_heb))]);
            if ($request->name_heb == $cat->name_heb && $request->category_id == $cat->category_id && $request->name_en == $cat->name_en && $request->sub_category_id == $cat->sub_category_id) {
                return back()->with('fail', 'There is nothing to update!');
            }

            $this->validate($request, [
                'name_en' => 'required|max:255|min:2',
                'name_heb' => 'required|max:255|min:2',
                'category_id' => 'required',
                'sub_category_id' => 'required'
            ], [
                'category_id.required' => 'Please select category',
                'sub_category_id.required' => 'Please select sub category',
                'name_en.required' => 'Please fill in the english sub sub category name field',
                'name_en.unique' => 'This is an existing category',
                'name_en.max' => 'Sub Sub Category name is too long... Choose one that is maximum 255 chars!',
                'name_en.min' => 'Sub Sub Category name is too short... Choose one that has at least 2 chars!',
                'name_heb.required' => 'Please fill in the hebrew category name field',
                'name_heb.max' => 'Sub Sub Category name is too long... Choose one that is maximum 255 chars!',
                'name_heb.min' => 'Sub Sub Category name is too short... Choose one that has at least 2 chars!'
            ]);
        }
        $cat->update([
            'name_en' => $request->name_en,
            'name_heb' => $request->name_heb,
            'category_id' => $request->category_id,
            'sub_category_id' => $request->sub_category_id,
            'slug_en' => strtolower(str_replace(' ', '-', $request->name_en)),
            'slug_heb' => str_replace(' ', '-', $request->name_heb),
        ]);

        return back()->with('success', 'The Sub Sub Category Was Successfully Updated');
    }

    public function destroy($delId)
    {
        //there is auth:admin guard which is why i don't check it here but I have to be sure that the brand exists
        $cat = SubSubCategory::findOrFail($delId);
        if ($cat) {
            $cat->delete();
            return back()->with('success', 'The Sub Sub Category Was Successfully Moved to Trash');
        }
        return redirect()->route('admin.show.subcategory')->with('fail', 'Oo...ps! Something went wrong...');
    }

    public function getSubCategory($category_id)
    {
        $subcat = SubCategory::where('category_id', $category_id)->orderBy('name_en', 'ASC')->get();
        return json_encode($subcat);
    }
}
