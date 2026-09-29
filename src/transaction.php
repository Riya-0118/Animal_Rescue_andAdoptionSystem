<?php

require __DIR__ . '/vendor/autoload.php';

$stripeSecretKey = getenv('STRIPE_SECRET_KEY');

\Stripe\Stripe::setApiKey($stripe_secret_key);

$session = \Stripe\Checkout\Session::create([
    'payment_method_types' => ['card'],
    'line_items' => [[
        'price_data' => [
            'currency' => 'npr',
            'product_data' => [
                'name' => 'Donation',
            ],
            'unit_amount' => 50000,
        ],
        'quantity' => 1,
    ]],
    'mode' => 'payment',
    'success_url' => 'http://localhost:8000/success.php',
    'cancel_url' => 'http://localhost:8000/donation.php',
]);

header("Location: " . $session->url);