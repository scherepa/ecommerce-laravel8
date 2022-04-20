<?php

namespace App\Http\Controllers\frontend;

use Carbon\Carbon;
use App\Models\State;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\District;
use App\Models\Division;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Gloudemans\Shoppingcart\Facades\Cart;

class CartController extends Controller
{
    ///add to cart
    public function addProduct(Request $request, $id)
    {
        $now_qty = '';
        foreach (Cart::content() as $ind => $row) {
            foreach ($row as $key => $item) {
                if ($key == 'id' && $item == $id) {
                    $now_qty = $row->qty;
                }
            }
        }
        $product = Product::findOrFail($id);
        /* new product in cart but asking for more then there is in stock */
        if ($now_qty == '' && $product->product_qty < $request->quantity) {
            return response()->json(['fail' => "Please choose up to {$product->product_qty}"]);
        }
        /* no more in stock */
        if ($now_qty == $product->product_qty) {
            return response()->json(['fail' => "Sorry no more in stock..."]);
        }
        /* this product is already in cart but adding more will cause out of stock */
        if ($now_qty != '') {
            if ($product->product_qty < $request->quantity + $now_qty) {
                $max = $product->product_qty - $now_qty;
                return response()->json(['fail' => "Please choose up to {$max}"]);
            }
        }
        $img = $product->product_thumbnail;
        if ($product->discount_price == NULL) {
            Cart::add([
                'id' => $id,
                'name' => $request->product_name,
                'qty' => $request->quantity,
                'price' => $product->selling_price,
                'weight' => 1,
                'options' => ['image' => $img, 'size' => $request->size, 'color' => $request->color],
            ]);
            if (Session::has('coupon')) {
                $discount = Session::get('coupon.coupon_discount');
                Session::put('coupon.discount_amount', round(floatval(Cart::total()) * $discount / 100, 2));
                Session::put('coupon.total_amount', round(floatval(Cart::total()) - floatval(Cart::total()) * $discount / 100, 2));
            }
            return response()->json(['success' => 'Successfully added to cart']);
        } else {
            Cart::add([
                'id' => $id,
                'name' => $request->product_name,
                'qty' => $request->quantity,
                'price' => $product->discount_price,
                'weight' => 1,
                'options' => ['image' => $img, 'size' => $request->size, 'color' => $request->color],
            ])->associate('Product');
            if (Session::has('coupon')) {
                $discount = Session::get('coupon.coupon_discount');
                Session::put('coupon.discount_amount', round(floatval(Cart::total()) * $discount / 100, 2));
                Session::put('coupon.total_amount', round(floatval(Cart::total()) - floatval(Cart::total()) * $discount / 100, 2));
            }
            return response()->json(['success' => 'Successfully added to cart']);
        }
        return response()->json(['fail' => 'Smth went wrong']);
    }

    ///display total qty and subtotal sum
    public function showMiniCart()
    {
        if (!Cart::count() && Session::has('coupon')) {
            Session::forget('coupon');
        }
        $carts = Cart::content();
        $cartQty = Cart::count();
        $cartSubTotal = Cart::subtotal();
        $cartTotal = Cart::total();;

        return response()->json(array(
            'carts' => $carts,
            'cartQty' => $cartQty,
            'cartSubTotal' => $cartSubTotal,
            'cartTotal' => $cartTotal
        ));
    }

    /// remove mini cart 
    public function removeMiniCart($rowId)
    {
        Cart::remove($rowId);
        if (!Cart::count() && Session::has('coupon')) {
            Session::forget('coupon');
        }
        if (Session::has('coupon')) {
            $discount = Session::get('coupon.coupon_discount');
            Session::put('coupon.discount_amount', round(floatval(Cart::total()) * $discount / 100, 2));
            Session::put('coupon.total_amount', round(floatval(Cart::total()) - floatval(Cart::total()) * $discount / 100, 2));
        }
        return response()->json(['success' => 'Product Remove from Cart']);
    }

    ///add to wishlist
    public function addToWishlist(Request $request, $id)
    {
        if (Auth::check()) {
            $exists = Wishlist::where('user_id', Auth::id())->where('product_id', $id)->first();
            if ($exists) {
                return response()->json(['error' => 'The Product already in the wishlist']);
            } else {
                Wishlist::create([
                    'user_id' => Auth::id(),
                    'product_id' => $id,
                ]);
                return response()->json(['success' => 'Successfully Added To Your Wishlist']);
            }
        } else {
            return response()->json(['error' => 'Please login to add product to your wishlist']);
        }
    }

    public function couponApply($name)
    {
        $coupon = Coupon::where('coupon_name', strtoupper($name))->where('coupon_validity', '>=', Carbon::now()->format('Y-m-d'))->first();
        if ($coupon) {
            Session::put('coupon', [
                'coupon_name' => $coupon->coupon_name,
                'coupon_discount' => $coupon->coupon_discount,
                'discount_amount' => round(floatval(Cart::total()) * $coupon->coupon_discount / 100, 2),
                'total_amount' => round(floatval(Cart::total()) - floatval(Cart::total()) * $coupon->coupon_discount / 100, 2)
            ]);
            return response()->json(array(
                'validity' => true,
                'success' => 'Coupon Applied Successfully'
            ));
        } else {
            return response()->json(['error' => 'Invalid Coupon']);
        }
    }

    public function couponRemove()
    {
        Session::forget('coupon');
        return response()->json(['success' => 'Coupon Removed Successfully']);
    }

    public function checkoutCreate()
    {
        if (!Cart::count() && Session::has('coupon')) {
            Session::forget('coupon');
        }
        $divisions = Division::get();
        //dd($divisions->first()->id);
        $districts = District::where('division_id', $divisions->first()->id)->get();
        //dd($districts);
        $carts = Cart::content();
        $changed = false;
        foreach ($carts as $row => $cart) {
            $product = Product::findOrFail($cart->id);
            if ($product->product_qty < $cart->qty && $product->product_qty > 0) {
                Cart::update($cart->rowId, $product->product_qty);
                $changed = true;
            }
            if ($product->product_qty == 0) {
                Cart::remove($cart->rowId);
                $changed = true;
            }
        }
        if (!Cart::count()) {
            return redirect()->route('mycartpage')->with('fail', 'Please add products to cart before checkout');
        }
        $discount = Session::has('coupon') ? round(floatval(str_replace(',', '', Cart::total())) * Session::get('coupon.coupon_discount') / 100, 2) : '';
        //dd($discount);
        if ($changed) {
            $carts = Cart::content();
        }
        if (Session::has('coupon')) {
            Session::put('coupon.discount_amount', round(floatval(floatval(str_replace(',', '', Cart::total()))) * Session::get('coupon.coupon_discount') / 100, 2));
            Session::put('coupon.total_amount', round(floatval(str_replace(',', '', Cart::total())) - $discount, 2));
        }
        $cartQty = Cart::count();
        //dd(floatval(Session::get('coupon.discount_amount')));
        $cartTotal = Session::has('coupon') ? Session::get('coupon.total_amount') : Cart::total();
        $cartSubTotal = Cart::subtotal();
        $cartTax = Cart::tax();

        return view('fronted.checkout', compact('carts', 'cartQty', 'cartTotal', 'cartSubTotal', 'cartTax', 'discount', 'divisions', 'districts'));
    }
}
