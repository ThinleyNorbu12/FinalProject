<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserGuideController extends Controller
{
    public function index()
    {
        return view('user-guide', [
            'title' => 'User Guide - Car Rental System',
            'version' => '1.0.0'
        ]);
    }
}