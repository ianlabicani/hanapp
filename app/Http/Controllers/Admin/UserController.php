<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of all users with their roles.
     */
    public function index()
    {
        $users = User::with('roles')->latest()->paginate(20);

        return view('admin.users.index', compact('users'));
    }

    /**
     * Display the specified user.
     */
    public function show(User $user)
    {
        $user->load('roles', 'foodspots');

        return view('admin.users.show', compact('user'));
    }
}
