<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CartItem;
use Illuminate\Support\Str;
use App\Models\Order;
use App\Models\OrderItem;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Stripe\Exception\ApiErrorException;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = CartItem::where('user_id', auth()->id())->with('product')->get();
        $total = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        $stripeKey = config('services.stripe.key');
        $paypalClientId = config('services.paypal.client_id');

        return view('cart.index', compact('cartItems', 'total', 'stripeKey', 'paypalClientId'));
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
            'payment_method' => 'required|in:card,paypal,oxxo,transfer',
        ]);

        $user = auth()->user();
        $cartItems = CartItem::where('user_id', $user->id)->with('product')->get();
        
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Tu carrito está vacío.');
        }

        $total = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        $paymentMethod = $request->payment_method;
        $transactionId = null;

        // Proceso de pago real con Stripe
        if ($paymentMethod === 'card') {
            if (!$request->stripe_payment_id) {
                return redirect()->back()->with('error', 'Error en el método de pago.');
            }

            try {
                Stripe::setApiKey(config('services.stripe.secret'));

                $intent = PaymentIntent::create([
                    'amount' => $total * 100, // Stripe usa centavos
                    'currency' => 'mxn',
                    'payment_method' => $request->stripe_payment_id,
                    'confirmation_method' => 'manual',
                    'confirm' => true,
                    'return_url' => route('cart.success'), // Requerido para algunos métodos de confirmación
                ]);

                if ($intent->status === 'succeeded') {
                    $transactionId = $intent->id;
                } else {
                    return redirect()->back()->with('error', 'El pago no pudo ser procesado. Estado: ' . $intent->status);
                }
            } catch (ApiErrorException $e) {
                return redirect()->back()->with('error', 'Error de Stripe: ' . $e->getMessage());
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Ocurrió un error inesperado al procesar el pago.');
            }
        }
        
        // Simular generación de folio único
        $orderNumber = 'ORD-' . strtoupper(Str::random(8));

        // Crear el registro del Pedido Real
        $order = Order::create([
            'user_id' => $user->id,
            'order_number' => $orderNumber,
            'total' => $total,
            'payment_method' => $paymentMethod,
            'status' => ($paymentMethod == 'card' || $paymentMethod == 'paypal') ? 'completed' : 'pending',
            'transaction_id' => ($paymentMethod == 'card') ? $transactionId : (($paymentMethod == 'paypal') ? ($request->paypal_order_id ?? null) : null),
            'reference' => ($paymentMethod == 'oxxo' || $paymentMethod == 'transfer') ? rand(1000000000, 9999999999) : null
        ]);

        // Registrar los productos del pedido para el historial antes de borrar el carrito
        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->product->price
            ]);
        }

        // Datos para la vista success
        $itemsData = $cartItems->map(function($item) {
            return [
                'name' => $item->product->name,
                'price' => $item->product->price,
                'quantity' => $item->quantity,
                'total' => $item->total
            ];
        });

        // Vaciar el carrito
        CartItem::where('user_id', $user->id)->delete();

        // Almacenar en sesión para la ruta GET de éxito
        session()->put('last_order', [
            'total' => $total,
            'paymentMethod' => $paymentMethod,
            'orderNumber' => $orderNumber,
            'items' => $itemsData,
            'reference' => $order->reference,
            'order_id' => $order->id
        ]);

        return redirect()->route('cart.success');
    }

    public function success()
    {
        $order = session()->get('last_order');

        if (!$order) {
            return redirect()->route('home');
        }

        return view('cart.success', [
            'total' => $order['total'],
            'paymentMethod' => $order['paymentMethod'],
            'orderNumber' => $order['orderNumber'],
            'items' => $order['items'],
            'reference' => $order['reference'] ?? null
        ]);
    }
}
