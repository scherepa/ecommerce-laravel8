<?php

namespace App\Http\Controllers\user;

use App\Models\State;
use App\Models\Product;
use App\Models\District;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Gloudemans\Shoppingcart\Facades\Cart;

class CheckoutController extends Controller
{
    public function getDistrict($id)
    {
        $distr = District::where('division_id', $id)->get();
        return json_encode($distr);
    }
    public function getState($id)
    {
        $st = State::where('district_id', $id)->get();
        return json_encode($st);
    }

    public function checkoutStore(Request $request)
    {
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
        $product = null;
        if (!Cart::count()) {
            return redirect()->route('mycartpage')->with('fail', 'Please add products to cart before checkout');
        }
        if ($changed) {
            return redirect()->back()->with('fail', 'Review cart items, cart has been changed due to current availability');
        }
        $request = $request->merge(['shipping_name' => trim(strip_tags($request->shipping_name)), 'shipping_email' => trim(strip_tags($request->shipping_email)), 'shipping_phone' => trim(strip_tags($request->shipping_phone)), 'shipping_street' => trim(strip_tags($request->shipping_street)), 'shipping_entrance' => !$request->shipping_entrance ? null : trim(strip_tags($request->shipping_entrance)), 'shipping_floor' => $request->shipping_floor ? trim(strip_tags($request->shipping_floor)) : "0", 'shipping_apt_number' => !$request->shipping_apt_number ? null : trim(strip_tags($request->shipping_apt_number)), 'notes' => trim(strip_tags($request->notes)), 'shipping_house_number' => trim(strip_tags($request->shipping_house_number)), 'post_code' => trim(strip_tags($request->post_code))]);
        //dd($request);
        $request->validate([
            'shipping_name' => 'required|string|max:255',
            'shipping_email' => 'required|email',
            'shipping_phone' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'post_code' => 'required|string|min:4|max:255',
            'shipping_street' => 'required|string|max:255',
            'shipping_house_number' => 'required|string|max:255',
            'shipping_entrance' => 'nullable|string|max:255',
            'shipping_floor' => 'string|max:255',
            'shipping_apt_number' => 'nullable|string|max:255',
            'notes' => 'string|max:255'
        ]);

        //dd($request);
        $data = array(
            'shipping_name' => $request->shipping_name,
            'shipping_email' => $request->shipping_email,
            'shipping_phone' => $request->shipping_phone,
            'division' => $request->division,
            'district' => $request->district,
            'state_name' => $request->state_name,
            'city' => strtoupper($request->city),
            'post_code' => $request->post_code,
            'shipping_street' => $request->shipping_street,
            'shipping_house_number' => $request->shipping_house_number,
            'shipping_entrance' => $request->shipping_entrance,
            'shipping_floor' => $request->shipping_floor,
            'shipping_apt_number' => $request->shipping_apt_number,
            'notes' => $request->notes
        );
        //dd($data);
        if ($request->payment_method == 'stripe') {
            return view('fronted.payment.stripe', compact('data'));
        } else if ($request->payment_method == 'card') {
            return 'card';
        } else {
            return view('fronted.payment.cash', compact('data'));
        }
    }
}
