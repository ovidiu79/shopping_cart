<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use ErrorException;
use Illuminate\Http\Request;
use Stripe\Checkout\Session;
use Stripe\Stripe;

class PaymentController extends Controller
{
    public function payByStripe(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_KEY'));

        try {
            $checkout_session = Session::create([
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            'name' => 'Vue Shop Orders'
                        ],
                        'unit_ammount' => $this->calculateOrderTotal($request->cartItems)
                    ],
                    'quantity' => 1
                ]],
                'mode' => 'payment',
                'success_url' => $request->success_url,
            ]);

            return response()->json(['url' => $checkout_session->url]);
        } catch (ErrorException $e) {
            response()->json([
                'error' => $e->getMessage(),
            ]);
        }
    }

    private function calculateOrderTotal(array $items)
    {
        $total = 0;

        foreach ($items as $item) {
            $total += $this->calculateTotal($item['product_price'], $item['quantity']);
        }

        return $total * 100;
    }

    private function calculateTotal(int $product_price, int $quantity)
    {
        $total = $product_price * $quantity;

        return $total;
    }
}
