<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Location;

class LocationController extends Controller
{
    public function index()
    {
        return Inertia::render('Locations');
    }

    public function store(Request $request)
    {
        Location::create($request->validate([
            'name' => ['required', 'max:20'],
            'latitude' => ['required', 'max_digits:10'],
            'longitude' => ['required', 'max_digits:10'],
            'visibility' => ['required'],
            'comment' => ['max: 30'],
        ]));

        return to_route('locations');
    }
}
