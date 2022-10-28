<?php

namespace App\Http\Controllers;

use Stripe\StripeClient;
use Stripe\PaymentIntent;
use Illuminate\Http\Request;

class StripeTestController extends Controller
{
    public function create()
    {
        return view('stripe_connect');
    }

    public function store(Request $request)
    {
        $stripe = new StripeClient('sk_test_51LDwKMFMI4ifYudWSV3f2Jl5coQHC0g1d5FCFwhFfpQVLWhhGKoXrsWsBiwhDAO7X7DHg7tnQ9q3rUGMK4y139Xz00i180d1xx');
        $customer = $stripe->accounts->create([
            "type" => "express",
            // "email" => "princegentle4@gmail.com",
            // "description" => "test customer",
            // "email" => "marvinw1ll1s92@gmail.com"
            // "email"=>"Mints_912@yahoo.com",
            "email"=>"kk@kk.com",
        ]);
        // sk_test_51LDwKMFMI4ifYudWSV3f2Jl5coQHC0g1d5FCFwhFfpQVLWhhGKoXrsWsBiwhDAO7X7DHg7tnQ9q3rUGMK4y139Xz00i180d1xx

        dd($customer);
    }

    public function processPayment()
    {
        $stripeAccount = 'acct_1Lsjz5FQJwvbRwY3';
        $intent = PaymentIntent::create([
            'amount' => 1099,
            'currency' => 'usd',
            'automatic_payment_methods' => [
              'enabled' => 'true',
            ],
            'application_fee_amount' => 100,
          ], ['stripe_account' => $stripeAccount]);

          echo json_encode(array('client_secret' => $intent->client_secret));
    }
}
