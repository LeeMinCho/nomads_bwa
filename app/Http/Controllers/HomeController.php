<?php

namespace App\Http\Controllers;

use App\TravelPackage;

class HomeController extends Controller
{
    public function index()
    {
        $items = TravelPackage::with(['galleries'])->get();
        return view('pages.home', [
            'items' => $items
        ]);
    }
}
