<?php

namespace App\Http\Controllers\user;

use App\Models\Wishlist;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class WhishlistController extends Controller
{
    public function index()
    {
        $wishlist = Wishlist::with('product')->where('user_id', Auth::id())->latest()->get();
        return view('fronted.wishlist', compact('wishlist'));
    }

    public function getWishlistProduct()
    {

        $wishlist = Wishlist::with('product')->where('user_id', Auth::id())->latest()->get();
        return response()->json($wishlist);
    }

    public function destroyOne($id)
    {
        $wish = Wishlist::findOrFail($id);
        if ($wish) {
            $wish->delete();
            return redirect()->back()->with('success', 'the product was deleted');
        }
        return redirect()->back()->with('fail', 'the product was not deleted');
    }
}
