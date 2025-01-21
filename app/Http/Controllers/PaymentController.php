<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;
use App\Models\Cart; // Sesuaikan dengan model Cart kamu

class PaymentController extends Controller
{
    public function __construct()
    {
        // Set konfigurasi Midtrans
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
    }

    public function checkout(Request $request)
    {
        $user = $request->user();

        // Ambil daftar produk di cart
        $cartItems = Cart::where('user_id', $user->id)->get();

        if ($cartItems->isEmpty()) {
            return response()->json(['message' => 'Cart is empty'], 400);
        }

        // Hitung total harga
        $total = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity; // Sesuaikan dengan relasi model
        });

        $orderId = 'ORDER-' . uniqid(); // Generate order ID

        foreach ($cartItems as $cart) {
            $cart->order_id = $orderId;
            $cart->save();
        }

        // Include $orderId in the Midtrans payload
        $transactionDetails = [
            'order_id' => $orderId,
            'gross_amount' => $total,
        ];

        $itemDetails = $cartItems->map(function ($item) {
            return [
                'id' => $item->product_id,
                'name' => $item->product->name,
                'price' => $item->product->price,
                'quantity' => $item->quantity,
            ];
        })->toArray();

        $customerDetails = [
            'name' => $user->name,
            'email' => $user->email,
        ];

        $payload = [
            'transaction_details' => $transactionDetails,
            'item_details' => $itemDetails,
            'customer_details' => $customerDetails,
        ];

        try {
            // Buat Snap Token
            $snapToken = Snap::getSnapToken($payload);

            return response()->json(['snap_token' => $snapToken]);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
