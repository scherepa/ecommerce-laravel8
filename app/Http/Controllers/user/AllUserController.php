<?php

namespace App\Http\Controllers\user;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;

class AllUserController extends Controller
{
    public function getAllOrders()
    {
        //dd(Auth::id());
        $orders = Order::where('user_id', '=', Auth::id())->latest()->get();
        return view('fronted.myorders_view', compact('orders'));
    }

    public function getOrderDetails($id)
    {
        $order = Order::with(['district', 'division', 'state'])->findOrFail($id);
        if (!$order) {
            return back()->with('fail', 'There is no such order...');
        }
        $items = OrderItem::where('order_id', '=', $id)->with(['product', 'order'])->get();
        return view('fronted.orderitems_view', compact('items', 'order'));
    }
}
