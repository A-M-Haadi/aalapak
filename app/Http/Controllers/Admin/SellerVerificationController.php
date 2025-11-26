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

    }
}