<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rules;
use Inertia\Inertia;

class UserController extends Controller
{

    /**
     * Get the page of the resources.
     */
    public function page()
    {
        return Inertia::render('User',[
            'name' => Auth::user()->name,
            'role' => Auth::user()->role,
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (! Gate::allows('is-admin')) {
            $users = User::orderBy('name', 'asc')->where('role', 'public')->get(['id', 'name', 'email', 'role']);
        } else {
            $users = User::orderBy('name', 'asc')->get(['id', 'name', 'email', 'role']);
        }

        return $users;

    }

    /**
     * Get the user creation page.
     */
    public function createUserPage()
    {
        $response = Gate::inspect('is-admin');
        if($response->allowed()) {
            return Inertia::render('CreateUser');
        } else {
            return Inertia::render('ErrorPage');
        }

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:20',
            'email' => 'required|string|lowercase|email|max:255|unique:'.User::class,
            'role' => 'required',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $name = $validated['name'];
        $email = $validated['email'];
        $role = $validated['role'];
        $password = $validated['password'];

        $user = new User([
            'name' => $name,
            'email' => $email,
            'role' => $role,
            'password' => $password,
        ]);

        if ($user->save()) {
            return ['redirect' => route('users.index')];
        }

        return response()->json(['message' => 'Problem occurred']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
