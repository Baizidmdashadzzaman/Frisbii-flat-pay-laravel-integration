<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Services\FrisbiiService;

class PaymentController extends Controller
{
    public function pay(FrisbiiService $frisbii)
    {
        $order = Order::create([
            'order_no' => uniqid('ORD_'),
            'amount' => 1, 
            'currency' => 'DKK',
        ]);

        $response = $frisbii->createCheckout($order);
        $paymentUrl = $response['url'] ?? null;
        
        if (!$paymentUrl) {
            return back()->with('error', 'Payment failed');
        }
        
        return redirect($paymentUrl);
    }

    public function success()
    {
        return "Payment success (waiting for confirmation)";
    }

    public function cancel()
    {
        return "Payment cancelled";
    }

    public function webhook(Request $request)
    {
        $data = $request->all();

        $order = Order::where('order_no', $data['order']['handle'])->first();

        if (!$order) {
            return response()->json(['error' => 'Order not found']);
        }

        // IMPORTANT: check payment status
        if ($data['state'] === 'paid') {
            $order->status = 'paid';
        } elseif ($data['state'] === 'failed') {
            $order->status = 'failed';
        }

        $order->save();

        return response()->json(['status' => 'ok']);
    }
}