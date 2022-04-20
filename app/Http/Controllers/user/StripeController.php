<?php

namespace App\Http\Controllers\user;

use Carbon\Carbon;
use App\Models\Order;
use App\Models\OrderItem;
use App\Mail\OrderRecieved;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Gloudemans\Shoppingcart\Facades\Cart;


class StripeController extends Controller
{
    public function stripeOrder(Request $request)
    {
        //dd($request);
        $total_amount = Session::has('coupon') ? Session::get('coupon')['total_amount'] : round(floatval(str_replace(',', '', Cart::total())), 2);

        // Set your secret key. Remember to switch to your live secret key in production.
        // See your keys here: https://dashboard.stripe.com/apikeys
        \Stripe\Stripe::setApiKey(
            'sk_test_51JwsEwK28qPY8wk1yO7dPbB8X5QJpiqsBaXpVKstefrAlyXkMJcth2FInAvRhEHPIuLvwl36OrKUGyXvORHNBGs100Cdh93Ocw'
        );

        // Token is created using Checkout or Elements!
        // Get the payment token ID submitted by the form in php:
        //$token = $_POST['stripeToken'];
        //but in laravel better:
        $token = $request->input('stripeToken');
        /* it shows error in vs code but it works... taken from https://stripe.com/docs/payments/charges-api */
        //it is possible to write Stripe\Charge and Stripe\Stripe with use Stripe;
        $charge = \Stripe\Charge::create([
            'amount' => $total_amount * 100,
            'currency' => 'usd',
            'description' => 'Ecommerce',
            'source' => $token,
            'metadata' => ['order_id' => uniqid()],
        ]);
        //dd($charge->metadata);
        $order = Order::create([
            'user_id' => Auth::id(),
            'division_id' => $request->division_id,
            'district_id' => $request->district_id,
            'state_id' => $request->state_id,
            'shipping_name' => $request->name,
            'shipping_email' => $request->email,
            'shipping_phone' => $request->phone,
            'city' => $request->city,
            'post_code' => $request->post_code,
            'notes' => $request->notes ? $request->notes : '',
            'shipping_street' => $request->shipping_street,
            'shipping_house_number' => $request->shipping_house_number,
            'shipping_entrance' => $request->shipping_entrance,
            'shipping_floor' => $request->shipping_floor,
            'shipping_apt_number' => $request->shipping_apt_number,
            'payment_type' => 'Stripe',
            'payment_method' => 'Stripe',
            'payment_type' => $charge->payment_method,
            'transaction_id' => $charge->balance_transaction,
            'currency' => $charge->currency,
            'amount' => $total_amount,
            'order_number' => $charge->metadata->order_id,
            'invoice_no' => 'ECOM' . mt_rand(10000000, 99999999),
            'order_date' => Carbon::now()->format('d F Y'),
            'order_month' => Carbon::now()->format('F'),
            'order_year' => Carbon::now()->format('Y'),
            'status' => 'Pending'

        ]);
        //dd($order);

        $carts = Cart::content();
        foreach ($carts as $cart) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $cart->id,
                'color' => $cart->options->color,
                'size' => $cart->options->size,
                'qty' => $cart->qty,
                'price' => $cart->price,
            ]);
        }
        $invoice = Order::findOrFail($order->id);
        $data = [
            'invoice_no' => $invoice->invoice_no,
            'amount' => $invoice->amount,
            'name' => $invoice->shipping_name,
            'email' => $invoice->shipping_email
        ];

        Mail::to(auth()->user())->send(new OrderRecieved($data));
        if (Session::has('coupon')) {
            Session::forget('coupon');
        }
        Cart::destroy();
        /* to create a markdown mail in cmd: php artisan make:mail OrderRecieved --markdown=emails.orders.order_recieved or just make:mail ... and use html...*/
        return redirect()->route('dashboard')->with('success', 'Your order placed successfully');
    }
}
