<?php

namespace App\Http\Controllers\backend;

use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use App\Models\SubSubCategory;
use App\Http\Controllers\Controller;
use App\Models\MultiImg;

class ProductController extends Controller
{
    public function index()
    {
        /* I had to remove foreign ids of category, subcategory an 2sub category cause otherwise it causes trouble to change category and sub category and 2sub category.... */
        $brands = Brand::get();
        $categories = Category::get();
        $prods = Product::latest()->where('status', '=', 1)->get();
        return view('admin.product.index', [
            'brands' => $brands,
            'categories' => $categories,
            'prods' => $prods
        ]);
    }
    public function store(Request $request)
    {
        //dd($request);
        $allprods = Product::pluck('product_thumbnail');

        /* if we want images to be stored in storage and not in public we have to write in cmd: php artisan storage:link
        and don't forget toupate:
            APP_URL=http://localhost to APP_URL=http://localhost:8000 in .env */

        $request = $request->merge(['name_en' => trim(strip_tags($request->name_en)), 'product_name_heb' =>  trim(strip_tags($request->name_heb)), 'code' => trim(strip_tags($request->code)), 'product_tags_en' => trim(strip_tags($request->product_tags_en)), 'product_tags_heb' => trim(strip_tags($request->product_tags_heb)), 'product_size_en' => trim(strip_tags($request->product_size_en)), 'product_color_en' => trim(strip_tags($request->product_color_en)), 'product_color_heb' => trim(strip_tags($request->product_color_heb)), 'selling_price' => trim(strip_tags($request->selling_price)), 'discount_price' => trim(strip_tags($request->discount_price)), 'short_descp_en' => trim(strip_tags($request->short_descp_en)), 'short_descp_heb' => trim(strip_tags($request->short_descp_heb)), 'long_descp_en' => trim(strip_tags($request->long_descp_en)), 'long_descp_heb' => trim(strip_tags($request->long_descp_heb))]);


        $this->validate($request, [
            'name_en' => 'required|string|max:255|min:2',
            'product_thumbnail' => 'mimes:jpg,jpeg,png,gif,bmp,svg,webp',
            'name_heb' => 'required|string|max:255|min:2',
            'brand_id' => 'required',
            'category_id' => 'required',
            'sub_category_id' => 'required',
            'sub_sub_category_id' => 'required',
            'thumbnail' => 'required',
            'code' => 'required|string|max:255|min:5',

            'product_qty' => 'required',
            'product_tags_en' => 'required|string|max:255|min:2',
            'product_tags_heb' => 'required|string|max:255|min:2',
            'product_size_en' => 'nullable|string|max:255|min:2',
            'product_color_en' => 'required|string|max:255|min:2',
            'product_color_heb' => 'required|string|max:255|min:2',

            'selling_price' => 'required',
            'discount_price' => 'nullable',
            'short_descp_en' => 'required|string|max:255|min:2',
            'short_descp_heb' => 'required|string|max:255|min:2',
            'long_descp_en' => 'required|string|min:2',
            'long_descp_heb' => 'required|string|min:2',

            'hot_deals' => 'nullable',
            'featured' => 'nullable',
            'special_offer' => 'nullable',
            'special_deals' => 'nullable',

        ], [
            'name_en.required' => 'Please fill in the english brand name field',
            'name_en.max' => 'Brand name is too long... Choose one that is maximum 255 chars!',
            'name_en.min' => 'Brand name is too short... Choose one that has at least 2 chars!'
        ]);
        $prod_thumbnail = $request->file('thumbnail');
        if ($prod_thumbnail) {
            do {
                $name_gen = hexdec(uniqid());
                $img_ext = strtolower($prod_thumbnail->getClientOriginalExtension());
                $img_name = $name_gen . '.' . $img_ext;
                $up_location = 'images/products/';
                $last_img = $up_location . $img_name;
                if (!$allprods) break;
            } while ($allprods->contains($last_img));
            $prod_thumbnail->move($up_location, $img_name);
        }
        //dd($request);
        $prod = Product::create([
            'brand_id' => $request->brand_id,
            'category_id' => $request->category_id,
            'sub_category_id' => $request->sub_category_id,
            'sub_sub_category_id' => $request->sub_sub_category_id,
            'product_name_en' => $request->name_en,
            'product_name_heb' => $request->name_heb,
            'product_slug_en' => strtolower(str_replace(' ', '-', $request->name_en)),
            'product_slug_heb' => str_replace(' ', '-', $request->name_heb),
            'product_thumbnail' => $last_img,
            'product_code' => $request->code,

            'product_qty' => $request->product_qty,
            'product_tags_en' => $request->product_tags_en,
            'product_tags_heb' => $request->product_tags_heb,
            'product_size_en' => $request->product_size_en ? $request->product_size_en : NULL,
            'product_color_en' => $request->product_color_en,
            'product_color_heb' => $request->product_color_heb,

            'selling_price' => $request->selling_price,
            'discount_price' => $request->discount_price ? $request->discount_price : NULL,
            'short_descp_en' => $request->short_descp_en,
            'short_descp_heb' => $request->short_descp_heb,
            'long_descp_en' => $request->long_descp_en,
            'long_descp_heb' => $request->long_descp_heb,

            'hot_deals' => $request->hot_deals,
            'featured' => $request->featured,
            'special_offer' => $request->special_offer,
            'special_deals' => $request->special_deals,
            'status' => 1
        ]);


        $images = $request->file('image');
        if ($images) {
            $this->validate(
                $request,
                [
                    'image' => 'nullable',
                    'image.*' => 'mimes:jpg,jpeg,png,bmp,svg,webp|max:8000'
                ]
            );

            $names = (MultiImg::pluck('photo_name'));
            //I want to be sure that generated name do not exist in multiImg
            foreach ($images as $image) {
                $img_ext1 = strtolower($image->getClientOriginalExtension());
                do {
                    $name_gen1 = hexdec(uniqid());
                    $name = $name_gen1 . '.' . $img_ext1;
                    $location = 'images/multi/';
                    $path_img = $location . $name;
                } while ($names->contains($path_img));

                $image->move($location, $name);
                MultiImg::create([
                    'photo_name' => $path_img,
                    'product_id' => $prod->id
                ]);
            }
        }

        return back()->with('success', 'The new brand was successfully added');
    }

    public function edit($editId)
    {
        $brands = Brand::get();
        $categories = Category::get();
        $product = Product::with(['brand', 'category', 'sub_category', 'sub_sub_category'])->findOrFail($editId);
        $multi = $product->multi;
        //dd($multi);
        return view('admin.product.edit', [
            'product' => $product,
            'brands' => $brands,
            'categories' => $categories,
            'multi' => $multi
        ]);
    }

    public function updateThumbnail(Request $request, $updateId)
    {
        //to be sure this product exists
        //dd($request);
        $prod = Product::findOrFail($updateId);
        if (!$prod) {
            return back()->with('fail', 'There is no such Product');
        }
        $prod_thumbnail = $request->file('thumbnail');
        //dd($prod_thumbnail);
        if (!$prod_thumbnail) {
            return back()->with('fail', 'No new product thumbnail image has been chosen.');
        } else {
            $this->validate($request, [
                'thumbnail' => 'required|mimes:jpg,jpeg,png,gif,bmp,svg,webp'
            ]);
            $allprods = Product::pluck('product_thumbnail');
            do {
                $name_gen = hexdec(uniqid());
                $img_ext = strtolower($prod_thumbnail->getClientOriginalExtension());
                $img_name = $name_gen . '.' . $img_ext;
                $up_location = 'images/products/';
                $last_img = $up_location . $img_name;
                if (!$allprods) break;
            } while ($allprods->contains($last_img));
            $prod_thumbnail->move($up_location, $img_name);
            if ($prod->product_thumbnail) {
                unlink($prod->product_thumbnail);
            }
            $prod->update(['product_thumbnail' => $last_img]);
            return back()->with('success', 'The product thumbnail image was successfully updated.');
        }
    }
    public function imageEdit($imageId)
    {
        $prod_image = MultiImg::findOrFail($imageId);
        $product = Product::findOrFail($prod_image->product_id);
        return view('admin.multi.edit', compact('prod_image', 'product'));
    }
    public function updateImage($updateId, Request $request)
    {
        $img = MultiImg::findOrFail($updateId);
        if (!$img) {
            return back()->with('fail', 'There is no such image...');
        }
        $photo = $request->file('photo_name');
        if (!$photo) {
            return back()->with('fail', 'No new product image has been chosen.');
        } else {
            $names = (MultiImg::pluck('photo_name'));
            //I want to be sure that generated name do not exist in multiImg
            $img_ext1 = strtolower($photo->getClientOriginalExtension());
            do {
                $name_gen1 = hexdec(uniqid());
                $name = $name_gen1 . '.' . $img_ext1;
                $location = 'images/multi/';
                $path_img = $location . $name;
            } while ($names->contains($path_img));
            $photo->move($location, $name);
            unlink($img->photo_name);
            $img->update([
                'photo_name' => $path_img
            ]);
            return back()->with('success', 'The image was successfully replaced!');
        }
    }


    public function storeMulti(Request $request, $updateId)
    {
        //dd($request);
        //to be sure this product exists
        $prod = Product::findOrFail($updateId);
        //dd($prod);
        if (!$prod) {
            return back()->with('fail', 'There is no such Product');
        }
        $images = $request->file('image');
        if ($images) {
            $this->validate(
                $request,
                [
                    'image' => 'nullable',
                    'image.*' => 'mimes:jpg,jpeg,png,bmp,svg,webp|max:8000'
                ]
            );

            $names = (MultiImg::pluck('photo_name'));
            //I want to be sure that generated name do not exist in multiImg
            foreach ($images as $image) {
                $img_ext1 = strtolower($image->getClientOriginalExtension());
                do {
                    $name_gen1 = hexdec(uniqid());
                    $name = $name_gen1 . '.' . $img_ext1;
                    $location = 'images/multi/';
                    $path_img = $location . $name;
                } while ($names->contains($path_img));

                $image->move($location, $name);
                MultiImg::create([
                    'photo_name' => $path_img,
                    'product_id' => $updateId
                ]);
            }
            return back()->with('success', 'The product gallery images were successfully uploaded.');
        }
        return back()->with('fail', 'No new images have been chosen for the gallery');
    }

    public function updateFeatures(Request $request, $updateId)
    {
        //to be sure this product exists
        $prod = Product::findOrFail($updateId);
        //dd($request);
        //dd($prod);
        if ($prod->hot_deals == $request->hot_deals && $prod->featured == $request->featured && $prod->special_offer == $request->special_offer && $prod->special_deals == $request->special_deals) {
            return back()->with('fail', 'Nothing to update...');
        }
        if (!$prod) {
            return back()->with('fail', 'There is no such Product');
        }
        if ($prod->hot_deals != $request->hot_deals) {
            $this->validate($request, [
                'hot_deals' => 'nullable'
            ]);
            $prod->update(['hot_deals' => $request->hot_deals ? $request->hot_deals : null]);
        }
        if ($prod->featured != $request->featured) {
            $this->validate($request, [
                'featured' => 'nullable'
            ]);
            $prod->update(['featured' => $request->featured ? $request->featured : null]);
        }
        if ($prod->special_offer != $request->special_offer) {
            $this->validate($request, [
                'special_offer' => 'nullable'
            ]);
            $prod->update(['special_offer' => $request->special_offer ? $request->special_offer : null]);
        }
        if ($prod->special_deals != $request->special_deals) {
            $this->validate($request, [
                'special_deals' => 'nullable'
            ]);
            $prod->update(['special_deals' => $request->special_deals ? $request->special_deals : null]);
        }
        return back()->with('success', 'The product features were updated successfully.');
    }


    public function updateProd(Request $request, $updateId)
    {

        //to be sure this product exists
        $prod = Product::findOrFail($updateId);

        if (!$prod) {
            return back()->with('fail', 'There is no such Product');
        }

        if ($prod->product_name_en != $request->name_en) {
            $request = $request->merge(['name_en' => trim(strip_tags($request->name_en))]);
            $this->validate($request, [
                'name_en' => 'required|string|max:255|min:2'
            ]);
            $prod->update(['product_name_en' => $request->name_en]);
        }
        if ($prod->product_name_heb != $request->name_heb) {
            $request = $request->merge(['name_heb' => trim(strip_tags($request->name_heb))]);
            $this->validate($request, [
                'name_heb' => 'required|string|max:255|min:2'
            ]);
            $prod->update(['product_name_heb' => $request->name_heb]);
        }

        if ($prod->brand_id != $request->brand_id) {
            $this->validate($request, [
                'brand_id' => 'required'
            ]);
            $prod->update(['brand_id' => $request->brand_id]);
        }
        if ($prod->category_id != $request->category_id || $prod->sub_category_id != $request->sub_category_id || $prod->sub_sub_category_id != $request->sub_sub_category_id) {
            $this->validate($request, [
                'category_id' => 'required',
                'sub_category_id' => 'required',
                'sub_sub_category_id' => 'required'
            ]);
            $prod->update([
                'category_id' => $request->category_id,
                'sub_category_id' => $request->sub_category_id,
                'sub_sub_category_id' => $request->sub_sub_category_id
            ]);
        }
        if ($prod->product_code != $request->code) {
            $request = $request->merge(['code' => trim(strip_tags($request->code))]);
            $this->validate($request, [
                'code' => 'required|string|max:255|min:2'
            ]);
            $prod->update(['product_code' => $request->code]);
        }
        if ($prod->product_qty != $request->product_qty) {
            $request = $request->merge(['product_qty' => trim(strip_tags($request->product_qty))]);
            $this->validate($request, [
                'product_qty' => 'required|string|max:255|min:2'
            ]);
            $prod->update(['product_qty' => $request->product_qty]);
        }

        if ($prod->product_tags_en != $request->product_tags_en) {
            $request = $request->merge(['product_tags_en' => trim(strip_tags($request->product_tags_en))]);
            $this->validate($request, [
                'product_tags_en' => 'required|string|max:255|min:2'
            ]);
            $prod->update(['product_tags_en' => $request->product_tags_en]);
        }

        if ($prod->product_tags_heb != $request->product_tags_heb) {
            $request = $request->merge(['product_tags_en' => trim(strip_tags($request->product_tags_heb))]);
            $this->validate($request, [
                'product_tags_heb' => 'required|string|max:255|min:2'
            ]);
            $prod->update(['product_tags_heb' => $request->product_tags_heb]);
        }

        if ($prod->product_size_en != $request->product_size_en) {
            $request = $request->merge(['product_size_en' => trim(strip_tags($request->product_size_en))]);
            $this->validate($request, [
                'product_size_en' => 'nullable|string|max:255|min:2'
            ]);
            $prod->update(['product_size_en' => $request->product_size_en ? $request->product_size_en : NULL]);
        }

        if ($prod->product_color_en != $request->product_color_en) {
            $request = $request->merge(['product_color_en' => trim(strip_tags($request->product_color_en))]);
            $this->validate($request, [
                'product_color_en' => 'required|string|max:255|min:2',
            ]);
            $prod->update(['product_color_en' => $request->product_color_en]);
        }

        if ($prod->product_color_heb != $request->product_color_heb) {
            $request = $request->merge(['product_color_heb' => trim(strip_tags($request->product_color_heb))]);
            $this->validate($request, [
                'product_color_heb' => 'required|string|max:255|min:2',
            ]);
            $prod->update(['product_color_heb' => $request->product_color_heb]);
        }
        if ($prod->selling_price != $request->selling_price) {
            $request = $request->merge(['selling_price' => trim(strip_tags($request->selling_price))]);
            $this->validate($request, [
                'selling_price' => 'required'
            ]);
            $prod->update(['selling_price' => $request->selling_price]);
        }

        if ($prod->discount_price != $request->discount_price) {
            $request = $request->merge(['discount_price' => trim(strip_tags($request->discount_price))]);
            $this->validate($request, [
                'discount_price' => 'nullable'
            ]);
            $prod->update(['discount_price' => $request->discount_price ? $request->discount_price : NULL]);
        }
        if ($prod->short_descp_en != $request->short_descp_en) {
            $request = $request->merge(['short_descp_en' => trim(strip_tags($request->short_descp_en))]);
            $this->validate($request, [
                'short_descp_en' => 'required|string|max:255|min:2'
            ]);
            $prod->update(['short_descp_en' => $request->short_descp_en]);
        }
        if ($prod->short_descp_heb != $request->short_descp_heb) {
            $request = $request->merge(['short_descp_heb' => trim(strip_tags($request->short_descp_heb))]);
            $this->validate($request, [
                'short_descp_heb' => 'required|string|min:2'
            ]);
            $prod->update(['short_descp_heb' => $request->short_descp_heb]);
        }

        if ($prod->long_descp_en != $request->long_descp_en) {
            $request = $request->merge(['long_descp_en' => trim(strip_tags($request->long_descp_en))]);
            $this->validate($request, [
                'long_descp_en' => 'required|string|min:2'
            ]);
            $prod->update(['long_descp_en' => $request->long_descp_en]);
        }
        if ($prod->long_descp_heb != $request->long_descp_heb) {
            $request = $request->merge(['long_descp_heb' => trim(strip_tags($request->long_descp_heb))]);
            $this->validate($request, [
                'long_descp_heb' => 'required|string|min:2'
            ]);
            $prod->update(['long_descp_heb' => $request->long_descp_heb]);
        }
        return back()->with('success', 'The product general information was updated successfully.');
    }

    public function getSubSubCategory($category_id)
    {
        $subcat = SubSubCategory::where('sub_category_id', $category_id)->orderBy('name_en', 'ASC')->get();
        return json_encode($subcat);
    }
    /* fronend */
    /* home */
    public function single($prodId, $slug)
    {
        $product = Product::with(['brand', 'category', 'sub_category', 'sub_sub_category'])->where('status', 1)->findOrFail($prodId);
        $relatedProduct = Product::where('category_id', $product->category_id)->where('status', 1)->where('id', '!=', $prodId)->latest()->limit(3)->get();
        $fprods = Product::with(['category'])->where('id', '<>', $prodId)->where('status', 1)->where('featured', 1)->latest()->limit(3)->get();
        foreach ($fprods as $key => $f) {
            if ($relatedProduct->contains($f)) {
                $fprods->forget($key);
            }
        }
        $color_en = $product->product_color_en;
        $color_heb = $product->product_color_heb;
        $product_color_en = explode(',', $color_en);
        foreach ($product_color_en as $col_en) {
            $col_en = trim($col_en);
        }


        $color_heb = $product->product_color_heb;
        $product_color_heb = explode(',', $color_heb);
        foreach ($product_color_heb as $col_heb) {
            $col_heb = trim($col_heb);
        }

        $size_en = $product->product_size_en ? $product->product_size_en : NULL;
        if ($size_en) {
            $product_size_en = explode(',', $size_en);
            foreach ($product_size_en as $size) {
                $size = trim($size);
            }
        } else {
            $product_size_en = NULL;
        }


        $multi = $product->multi;
        //dd($multi);
        return view('fronted.product.single', [
            'prod' => $product,
            'multi' => $multi,
            'color_en' => $product_color_en,
            'color_heb' => $product_color_heb,
            'size_en' => $product_size_en,
            'related' => $relatedProduct,
            'prods' => $fprods
        ]);
    }
    /* sale */
    public function sale()
    {
        $prods = Product::with(['category'])->where('status', 1)->where('discount_price', '!=', "")->get();
        //dd($prods->contains('category_id', 2));
        $cats = Category::get();
        return view('fronted.product.allsale', [
            'prods' => $prods,
            'cats' => $cats
        ]);
    }
    /* hot */
    public function hot()
    {
        $prods = Product::where('status', 1)->with(['category'])->where('hot_deals', '=', 1)->get();
        //dd($prods->contains('category_id', 2));
        $cats = Category::get();
        return view('fronted.product.allhot', [
            'prods' => $prods,
            'cats' => $cats
        ]);
    }

    public function allCateg($categId, $slug)
    {
        $cat = Category::findOrFail($categId);
        $prods = Product::where('status', 1)->where('category_id', '=', $categId)->get();
        return view('fronted.product.allcategory', [
            'prods' => $prods,
            'cat' => $cat
        ]);
    }
    public function allSubcateg($categId, $slug)
    {
        $cat = SubCategory::findOrFail($categId);
        $prods = Product::where('status', 1)->where('sub_category_id', '=', $categId)->get();
        return view('fronted.product.allsubcategory', [
            'prods' => $prods,
            'cat' => $cat
        ]);
    }
    public function allSubsubcateg($categId, $slug)
    {
        $cat = SubSubCategory::findOrFail($categId);
        $prods = Product::where('status', 1)->where('sub_sub_category_id', '=', $categId)->get();
        return view('fronted.product.allsubsubcategory', [
            'prods' => $prods,
            'cat' => $cat
        ]);
    }

    public function productViewAjax($id)
    {
        $product = Product::with('category', 'brand')->findOrFail($id);

        $color = $product->product_color_en;
        $product_color = explode(',', $color);

        $size = $product->product_size_en;
        $product_size = $size == null ? null : explode(',', $size);
        $product_image = url($product->product_thumbnail);
        $product_cat = $product->category->name_en;
        $product_brand = $product->brand->name_en;

        return response()->json(array(
            'product' => $product,
            'color' => $product_color,
            'size' => $product_size ? $product_size : null,
            'img' => $product_image,
            'product_cat' => $product_cat,
            'product_brand' => $product_brand
        ));
    }
}
