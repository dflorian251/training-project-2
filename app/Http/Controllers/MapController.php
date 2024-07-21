<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MapController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Map');
    }

    public function getLocations()
    {
        $locations = Location::get(['latitude', 'longitude', 'comment']);

        return $locations;
    }
}
