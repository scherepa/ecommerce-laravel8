<?php

namespace App\Http\Controllers\frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    public function heb()
    {
        session()->get('language');
        session()->forget('language');
        Session::put('language', 'hebrew');
        return redirect()->back();
    }

    public function eng()
    {
        session()->get('language');
        session()->forget('language');
        Session::put('language', 'english');
        return redirect()->back();
    }
}
