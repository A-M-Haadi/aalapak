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
        // 1. Validasi Dasar (Nama & Email)
        $rules = [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                \Illuminate\Validation\Rule::unique('users')->ignore($user->id),
            ],
        ];

        if ($user->role == 'seller') {
            $rules['store_status'] = 'required|in:pending,approved,rejected';
        }

        $validatedData = $request->validate($rules);

        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];

        if ($user->role == 'seller') {
            $user->store_status = $validatedData['store_status'];
        }

        $user->save();

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