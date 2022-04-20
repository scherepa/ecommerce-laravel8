<?php

namespace App\Http\Controllers\backend;

use Carbon\Carbon;
use App\Models\Coupon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CouponController extends Controller
{
    public function index()
    {
        return view('admin.coupon.index');
    }

    public function store(Request $request)
    {
        $request = $request->merge(['coupon_name' => trim(strip_tags($request->coupon_name)), 'coupon_discount' => (int) $request->coupon_discount]);
        $request->validate([
            'coupon_name' => 'required|string|max:255',
            'coupon_discount' => 'required|integer|max:90',
            'coupon_validity' => 'required|date',
        ]);
        Coupon::insert([
            'coupon_name' => strtoupper($request->coupon_name),
            'coupon_discount' => $request->coupon_discount,
            'coupon_validity' => $request->coupon_validity,
            'created_at' => Carbon::now(),
        ]);
        return redirect()->back()->with('success', 'Coupon added successfully');
    }

    public function edit($id)
    {
        $coupon = Coupon::find($id);
        if ($coupon) {
            return view('admin.coupon.edit', compact('coupon'));
        } else {
            return redirect()->route('admin.show.coupon')->with('fail', 'There is no such coupon...');
        }
    }

    public function updateCoup($id, Request $request)
    {
        $coupon = Coupon::find($id);
        if ($coupon) {
            $request = $request->merge(['coupon_name' => trim(strip_tags($request->coupon_name)), 'coupon_discount' => (int) $request->coupon_discount]);
            $request->validate([
                'coupon_name' => 'required|string|max:255',
                'coupon_discount' => 'required|integer|max:90',
                'coupon_validity' => 'required|date',
            ]);
            $coupon->update([
                'coupon_name' => strtoupper($request->coupon_name),
                'coupon_discount' => $request->coupon_discount,
                'coupon_validity' => $request->coupon_validity,
                'updated_at' => Carbon::now(),
            ]);
            return redirect()->back()->with('success', 'The coupon was successfully updated');
        } else {
            return redirect()->back()->with('fail', 'There is no such coupon...');
        }
    }
}
