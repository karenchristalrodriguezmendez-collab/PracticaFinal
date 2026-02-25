<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CartItem;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = CartItem::where('user_id', auth()->id())->with('product')->get();
        $total = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        return view('cart.index', compact('cartItems', 'total'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $cartItem = CartItem::where('user_id', auth()->id())
            ->where('product_id', $request->product_id)
            ->first();

        if ($cartItem) {
            $cartItem->quantity += $request->quantity;
            $cartItem->save();
        } else {
            CartItem::create([
                'user_id' => auth()->id(),
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
            ]);
        }

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Producto añadido al carrito.',
                'cart_count' => CartItem::where('user_id', auth()->id())->sum('quantity')
            ]);
        }

        return redirect()->back()->with('success', 'Producto añadido al carrito.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cartItem = CartItem::where('user_id', auth()->id())->findOrFail($id);
        $cartItem->quantity = $request->quantity;
        $cartItem->save();

        return redirect()->back()->with('success', 'Carrito actualizado.');
    }

    public function remove($id)
    {
        $cartItem = CartItem::where('user_id', auth()->id())->findOrFail($id);
        $cartItem->delete();

        return redirect()->back()->with('success', 'Producto eliminado del carrito.');
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|in:card,oxxo,transfer',
        ]);

        // Simulación de procesamiento de pago exitoso
        CartItem::where('user_id', auth()->id())->delete();

        return redirect()->route('home')->with('success', '¡Gracias por tu compra! El pago ha sido procesado con éxito mediante ' . ucfirst($request->payment_method) . '.');
    }
}
