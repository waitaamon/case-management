<?php

namespace App\Http\Controllers;

use App\Models\LegalCase;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $role = auth()->user()->role == 'agency-admin' ? 'investigator' : 'judiciary-officer';

        $users = User::query()->where('role', $role)->get();


        return view('users.index', compact('users'));
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate(['name' => 'required', 'email' => 'required|email', 'password' => 'nullable']);

        $user->update($request->only('name', 'email'));

        $request->filled('password') ? $user->update(['password' => bcrypt($request->get('password'))]) : null;

        return redirect('users');

    }
}
