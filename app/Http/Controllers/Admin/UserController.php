<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UserController extends Controller
{

    public function index()
    {
        $users = User::where('id', '!=', Auth::id())
                     ->orderBy('role')
                     ->orderBy('name')
                     ->get();
        
        return view('admin.users.index', compact('users'));
    }

    public function edit(User $user)
    {
        if ($user->id == Auth::id()) {
            return redirect()->route('admin.users.index')
                             ->with('error', 'Silakan edit profil Anda melalui halaman profil.');
        }
                             
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'role' => 'required|in:admin,seller,buyer',
        ]);

        $user->update($validatedData);

        return redirect()->route('admin.users.index')
                         ->with('success', 'Data user berhasil diperbarui.');
    }

    public function destroy(User $user)
    {

        if ($user->id == Auth::id()) {
            return redirect()->route('admin.users.index')
                             ->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
                         ->with('success', 'User berhasil dihapus.');
    }
}