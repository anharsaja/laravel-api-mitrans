<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use Midtrans\Config;
use Midtrans\Notification;

class MidtransController extends Controller
{
    public function __construct()
    {
        // Set Midtrans configuration
        Config::$serverKey = env('SB-Mid-server-e85E2nJhfMlqEkcmzwnFx_6R');
        Config::$isProduction = false; // Set to true for production
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    public function handleNotification(Request $request)
    {
        $notification = new Notification();

        // Transaction status from Midtrans
        $transactionStatus = $notification->transaction_status;
        $orderId = $notification->order_id;

        if ($transactionStatus == 'settlement') {
            // Payment successful, process the order
            $this->processOrder($orderId);
        }

        return response()->json(['message' => 'Notification handled']);
    }

    private function processOrder($orderId)
    {
        // Find carts based on order_id (Assuming order_id is stored in cart records)
        $carts = Cart::where('order_id', $orderId)->get();

        foreach ($carts as $cart) {
            // Reduce product quantity
            $product = Product::find($cart->product_id);
            if ($product) {
                $product->quantity -= $cart->quantity;
                $product->save();
            }

            // Remove cart after processing
            $cart->delete();
        }
    }
}
