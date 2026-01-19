<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::orderBy("name")->where('role', 'member')->paginate(10);
        // dd($users);
        return view("users.index", compact("users"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("users.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validateWithBag("addUser", [
            'name' => 'required|string|min:3|max:255|not_regex:/[0-9]/',
            'avatar' => 'image|mimes:jpeg,jpg,png|max:2048',
            'role'=> 'required|in:admin,member',
            'email'=> 'required|string|lowercase|max:255|email|unique:'. User::class,
            'password'=> ['required', 'confirmed', Password::defaults()]
            ]);

        User::create([
            'name' => $validated['name'],
            'avatar' => $validated['avatar'] ?? null,
            'role' => $validated['role'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('users.index')->with('success','User data successfully added');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validateWithBag('editUser', [
            'name' => 'required|string|min:3|max:255|not_regex:/[0-9]/',
            'avatar' => 'image|mimes:jpeg,jpg,png|max:2048',
            'role'=> 'required|in:admin,member',
            'email' => 'required|string|max:255|'. Rule::unique(User::class)->ignore($user->id),
        ]);

        $user->update($validated);

        return redirect()->route('users.index')->with('success','User data successfully edited');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success','User data successfully deleted.');
    }
}
