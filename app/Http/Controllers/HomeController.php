<?php

namespace App\Http\Controllers;

use App\Models\Temperature;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $temperatures = Temperature::all(); // Fetch all data from the temperature table
        return view('home', compact('temperatures')); // Pass the data to the view
    }
}
