<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{

    public function index()
    {

        $orders = Auth::user()->orders()->orderBy('created_at', 'desc')->get();

        return view('buyer.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {

        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $orderItems = $order->items()->with('product')->get();

        return view('buyer.orders.show', compact('order', 'orderItems'));
    }
}