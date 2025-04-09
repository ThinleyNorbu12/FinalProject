<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CarDetail;


class HomeController extends Controller
{
    
public function index()
{
    $cars = CarDetail::latest()->get(); // Fetch the registered cars
    return view('home', compact('cars'));
}
}
