<?php

namespace App\Http\Controllers\user;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Gloudemans\Shoppingcart\Facades\Cart;

class CartPageController extends Controller
{
    public function index()
    {
        return view('fronted.mycart_view');
    }

    public function getCartProduct()
    {
        if (!Cart::count() && Session::has('coupon')) {
            Session::forget('coupon');
        }
        $coupon_name = Session::has('coupon') ? Session::get('coupon.coupon_name') : '';
        $discount = Session::has('coupon') ? round(floatval(str_replace(',', '', Cart::total())) * Session::get('coupon.coupon_discount') / 100, 2) : '';
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
        if ($changed) {
            $carts = Cart::content();
        }
        $cartQty = Cart::count();
        $cartSubTotal = Cart::subtotal();
        $cartTax = round(floatval(str_replace(',', '', Cart::tax())), 2);
        if (Session::has('coupon')) {
            Session::put('coupon.discount_amount', round(floatval(floatval(str_replace(',', '', Cart::total()))) * Session::get('coupon.coupon_discount') / 100, 2));
            Session::put('coupon.total_amount', round(floatval(str_replace(',', '', Cart::total())) - $discount, 2));
        }
        $cartTotal = Session::has('coupon') ? Session::get('coupon.total_amount') : Cart::total();

        return response()->json(array(
            'carts' => $carts,
            'cartQty' => $cartQty,
            'coupon_name' => $coupon_name,
            'discount_amount' => $discount,
            'cartTotal' =>  $cartTotal,
            'cartTax' => $cartTax,
            'cartSubTotal' => $cartSubTotal
        ));
    }

    //remove from cart
    public function removeCartProduct($rowId)
    {
        Cart::remove($rowId);

        return response()->json([
            'success' => 'Successfully Removed From Cart'
        ]);
    } //end method

    // Cart Increment 
    public function cartIncrement($rowId)
    {
        $row = Cart::get($rowId);
        $product = Product::findOrFail($row->id);
        if (($product->product_qty - ($row->qty + 1)) < 0) {
            Cart::update($rowId, $product->product_qty);
            return response()->json(['error' => 'Only ' . $product->product_qty . ' available']);
        }
        if ($product->product_qty == 0) {
            Cart::remove($rowId);
            return response()->json(['error' => 'This product is out of stock now and was removed from cart']);
        }
        Cart::update($rowId, $row->qty + 1);

        return response()->json('increment');
    } // end mehtod 

    // Cart Decrement 
    public function cartDecrement($rowId)
    {
        $row = Cart::get($rowId);
        Cart::update($rowId, $row->qty - 1);

        return response()->json('decrement');
    } // end mehtod
}
