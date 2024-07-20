<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Location;
use League\Flysystem\Visibility;

class LocationController extends Controller
{
    public function index()
    {
        return Inertia::render('Locations');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:20',
            'latitude' => 'required|max:20',
            'longitude' => 'required|max:20',
            'visibility' => 'required',
            'comment' => 'nullable|max:30',
        ]);

        $name = $validated['name'];
        $latitude = $validated['latitude'];
        $longitude = $validated['longitude'];
        $visibility = $validated['visibility'];
        $comment = $validated['comment'];

        $location = new Location([
            'name' => $name,
            'latitude' => $latitude,
            'longitude' => $longitude,
            'visibility' => $visibility,
            'comment' => $comment,
        ]);

        if ($location->save())
        {
            return ['redirect' => route('locations')];
        }

        return response()->json(['message' => 'Problem occurred']);
    }
}
