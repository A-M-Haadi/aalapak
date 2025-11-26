<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class SellerVerificationController extends Controller
{

    public function index()
    {
        $pendingSellers = User::where('role', 'seller')
                              ->where('store_status', 'pending')
                              ->get();

        return view('admin.sellers.index', compact('pendingSellers'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'action' => 'required|in:approve,reject',
        ]);

        $message = '';

        if ($request->action == 'approve') {
            $user->store_status = 'approved';
            $message = 'Seller berhasil disetujui (Approved).';
        } 
        elseif ($request->action == 'reject') {
            $user->store_status = 'rejected';
            $message = 'Seller berhasil ditolak (Rejected).';
        }

        $user->save();

        return redirect()->route('admin.sellers.index')
                         ->with('success', $message);
    }
}