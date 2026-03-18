<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class FrisbiiService
{
    protected $baseUrl;
    protected $apiKey;

    public function __construct()
    {
        $this->baseUrl = "https://checkout-api.frisbii.com/v1";
        $this->apiKey = config('services.frisbii.key');
    }

    protected function headers()
    {
        return [
            'accept' => 'application/json',
            'content-type' => 'application/json',
            'authorization' => 'Basic ' . base64_encode($this->apiKey . ':'),
        ];
    }

    public function createCheckout($order)
    {
        $response = Http::withHeaders($this->headers())
            ->post($this->baseUrl . '/session/charge', [
                "order" => [
                    "handle" => $order->order_no,
                    "amount" => $order->amount,
                    "currency" => $order->currency,
                    "customer" => [
                        "email" => "test@example.com",
                        "handle" => "cust_" . $order->id,
                        "first_name" => "Test",
                        "last_name" => "User"
                    ]
                ],
                "accept_url" => route('payment.success'),
                "cancel_url" => route('payment.cancel'),
            ]);

        return $response->json();
    }
}