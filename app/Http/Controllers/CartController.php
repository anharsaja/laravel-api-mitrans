<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // Get cart for the authenticated user
    public function index()
    {
        $cart = Cart::where('user_id', Auth::id())->with('product')->get();
        return response()->json($cart);
    }

    // Add product to cart
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        // Tidak perlu memanggil $product jika hanya untuk validasi dan pengecekan cart
        $existingCart = Cart::where('user_id', Auth::id())
            ->where('product_id', $request->product_id)
            ->first();

        if ($existingCart) {
            // Jika produk sudah ada di cart, kita update quantity
            $existingCart->quantity += $request->quantity;
            $existingCart->save();
            return response()->json(['message' => 'Product quantity updated in cart', 'cart' => $existingCart]);
        }

        // Jika produk belum ada di cart, kita buat item cart baru
        $cart = Cart::create([
            'user_id' => Auth::id(),
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
        ]);

        return response()->json(['message' => 'Product added to cart', 'cart' => $cart], 201);
    }

    // Update product quantity in cart
    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = Cart::findOrFail($id);

        if ($cart->user_id != Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $cart->quantity = $request->quantity;
        $cart->save();

        return response()->json(['message' => 'Cart updated successfully', 'cart' => $cart]);
    }

    // Remove product from cart
    public function destroy($id)
    {
        $cart = Cart::findOrFail($id);

        if ($cart->user_id != Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $cart->delete();

        return response()->json(['message' => 'Product removed from cart']);
    }
}
