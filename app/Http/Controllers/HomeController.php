<?php

namespace App\Http\Controllers;

use App\TravelPackage;

class HomeController extends Controller
{
    public function index()
    {
        $items = TravelPackage::with(['galleries'])->limit(12)->get();
        return view('pages.home', [
            'items' => $items
        ]);
    }
}
