<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User; // Pastikan ini di-import

class SellerVerificationController extends Controller
{
    /**
     * Tampilkan halaman verifikasi seller.
     */
    public function index()
    {
        // Ambil semua user dengan role 'seller' DAN status 'pending'
        $pendingSellers = User::where('role', 'seller')
                              ->where('store_status', 'pending')
                              ->get();

        // Kirim data ke view
        return view('admin.sellers.index', compact('pendingSellers'));
    }

    /**
     * Update status seller (Approve/Reject).
     */
    public function update(Request $request, User $user)
    {
        // Validasi input 'action'
        $request->validate([
            'action' => 'required|in:approve,reject',
        ]);

        $message = '';
        

        // Logika untuk Approve
        if ($request->action == 'approve') {
            $user->store_status = 'approved';
            $message = 'Seller berhasil disetujui (Approved).';
        } 
        // Logika untuk Reject
        elseif ($request->action == 'reject') {
            $user->store_status = 'rejected';
            $message = 'Seller berhasil ditolak (Rejected).';
        }

        // Simpan perubahan ke database
        $user->save();

        // Redirect kembali dengan pesan sukses
        return redirect()->route('admin.sellers.index')
                         ->with('success', $message);
    }
}