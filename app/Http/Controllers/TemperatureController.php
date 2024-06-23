<?php

namespace App\Http\Controllers;

use App\Models\Temperature;
use Illuminate\Http\Request;

class TemperatureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $temperatures = Temperature::all();
        return response()->json($temperatures);
    }

    public function latest()
    {
        // Fetch the latest temperature record
        $latestTemperature = Temperature::latest()->first();
        return response()->json($latestTemperature);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // celsuis, elapsed 
        $validatedData = $request->validate([
            'celsius' => 'required|numeric',
            'elapsed' => 'required|integer',
        ]);

        // Access validated data
        $celsius = $validatedData['celsius'];
        $elapsed = $validatedData['elapsed'];

        Temperature::create([
            'celsius' => $celsius,
            'elapsedTime' => $elapsed
        ]);

        return response()->json(['message' => 'Temperature stored successfully'], 200);
    }
    public function show(Temperature $temperature)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Temperature $temperature)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Temperature $temperature)
    {
        //
    }
}
