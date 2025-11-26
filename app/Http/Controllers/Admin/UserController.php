<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

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

    /**
     * Display users with pending owner requests.
     */
    public function pendingOwners()
    {
        $pendingOwnerRole = Role::where('name', 'pending_owner')->first();

        $users = $pendingOwnerRole
            ? User::whereHas('roles', fn ($q) => $q->where('name', 'pending_owner'))
                ->with('roles')
                ->latest()
                ->paginate(20)
            : collect();

        return view('admin.users.pending-owners', compact('users'));
    }

    /**
     * Approve a pending owner request.
     */
    public function approveOwner(User $user)
    {
        $pendingOwnerRole = Role::where('name', 'pending_owner')->first();
        $ownerRole = Role::firstOrCreate(['name' => 'owner']);

        if ($pendingOwnerRole && $user->roles->contains($pendingOwnerRole)) {
            // Remove pending_owner role and add owner role
            $user->roles()->detach($pendingOwnerRole->id);
            $user->roles()->syncWithoutDetaching([$ownerRole->id]);

            return back()->with('success', "Owner request approved for {$user->name}.");
        }

        return back()->with('error', 'User does not have a pending owner request.');
    }

    /**
     * Reject a pending owner request.
     */
    public function rejectOwner(User $user)
    {
        $pendingOwnerRole = Role::where('name', 'pending_owner')->first();
        $userRole = Role::firstOrCreate(['name' => 'user']);

        if ($pendingOwnerRole && $user->roles->contains($pendingOwnerRole)) {
            // Remove pending_owner role and assign user role
            $user->roles()->detach($pendingOwnerRole->id);
            $user->roles()->syncWithoutDetaching([$userRole->id]);

            return back()->with('success', "Owner request rejected for {$user->name}.");
        }

        return back()->with('error', 'User does not have a pending owner request.');
    }
}
