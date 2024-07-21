<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Hash;
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
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
    public function indexUser(string $id)
    {
        $user = User::findOrFail($id);
        return $user;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $response = Gate::inspect('is-admin');
        if($response->allowed() || strval(Auth::user()->id) === $id) {
            $user = User::findOrFail($id)->get();

            return Inertia::render('EditUser', [
                'id' => $id,
                'role' => Auth::user()->role,
            ]);
        } else {
            return Inertia::render('ErrorPage');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            // Find the user by ID
            $user = User::findOrFail($id);

            // Update fields if they are provided
            if ($request->filled('name')) {
                $user->name = $request->name;
            }
            if ($request->filled('email')) {
                $user->email = $request->email;
            }
            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }
            if ($request->filled('role')) {
                $user->admin = $request->role === 'admin' ? 1 : 0;
            }
            // Save the user
            $user->save();

            return redirect()->route('users.index')->with('success', 'User updated successfully.');
        } catch (\Exception $e) {
            return redirect()->route('users.index')->with('error', 'Failed to update user.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
