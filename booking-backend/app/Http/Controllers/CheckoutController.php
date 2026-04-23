<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Http;

class CheckoutController extends Controller
{
    public function index(Request $request)
    {
        $productName = $request->query('product_name');
        $price = $request->query('price');

        if (!$productName || !$price) {
            return redirect()->back()->with('error', 'Producto no seleccionado.');
        }

        return view('checkout', compact('productName', 'price'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_name' => 'required|string',
            'price' => 'required|numeric',
            'address' => 'required|string',
            'stripeToken' => 'nullable|string' // We use a dummy token from JS
        ]);

        $user = auth()->user();

        // 1. Guardar en Laravel
        $order = Order::create([
            'user_id' => $user->id,
            'product_name' => $request->product_name,
            'price' => $request->price,
            'status' => 'Pagado' // Modo ficticio
        ]);

        // 2. Enviar a WordPress
        // URL del REST API de WP. Ajusta esto según el dominio local
        $wpApiUrl = 'http://localhost/Proyecto-KapoBarber/wp-json/kapo/v1/orders';

        try {
            $response = Http::post($wpApiUrl, [
                'name' => $user->name,
                'email' => $user->email,
                'product_name' => $request->product_name,
                'price' => $request->price,
                'status' => 'Realizado'
            ]);
            
            // Opcional: chequear $response->successful()
        } catch (\Exception $e) {
            // Log error, no detener el flujo para el usuario
            \Log::error('Error sync WP Order: ' . $e->getMessage());
        }

        return response()->json(['success' => true, 'redirect' => route('dashboard')]);
    }
}
