<?php

namespace App\Http\Controllers\Api;

use Stripe\Stripe;
use App\Models\Group;
use Stripe\PaymentIntent;
use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Models\PaymentDetail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    //Save new card payment detail
    public function newCardPaymentDetail(Request $request)
    {
        $validator = Validator::make($request->all(),
        [
            'first_name' => ['required','string'],
            'last_name' => ['required','string'],
            'email' => ['required','email'],
            'card_number' => ['required','string','min:10','max:20'],
            'expiration_date' => ['required','date'],
            'cvv' => ['required','string','min:3','max:5'],
            'subscription_id' => ['required','numeric']
        ]
        );
        if($validator->fails()){
            return $this->appResponse(false,'error',$validator->errors()->all(), [], 422);
        }

        // Get user Id and group id
        $subscription = Subscription::find($request->subscription_id);
        if(empty($subscription)){
            return $this->appResponse(false,'error','Subscription Id not found', ['subscription_id'=>$request->subscription_id], 404);
        }

        $paymentDetail = new PaymentDetail();
        $paymentDetail->user_id = $subscription->user_id;
        $paymentDetail->first_name = $request->first_name;
        $paymentDetail->last_name = $request->last_name;
        $paymentDetail->email = $request->email;
        $paymentDetail->card_number = $request->card_number;
        $paymentDetail->expiration_date = $request->expiration_date;
        $paymentDetail->cvv = $request->cvv;
        $paymentDetail->save();

        //check if group is paid
        $group = Group::find($subscription->group_id);
        if((int)$group->paid_group === 1){

            // Process card payment

            //on successful payment, make subscription active
            $subscription->active = 1;
            $subscription->save();
        }

        return $this->appResponse(true, 'success', '', [],201);
    }

    //List all cards for a user
    public function userCards()
    {
        $cards = PaymentDetail::where('user_id', auth()->id())->get();
        return $this->appResponse(true, 'success', 'cards', ['cards'=>$cards],200);
    }

    // Process Payment and return client_screet
    public function makePayment()
    {
        $stripeAccount = 'acct_1Lsjz5FQJwvbRwY3';

        Stripe::setApiKey(config('app.stripe_secret_key'));
        $intent = PaymentIntent::create([
            'amount' => 1000,
            'currency' => 'usd',
            'automatic_payment_methods' => [
              'enabled' => 'true',
            ],
            'application_fee_amount' => 100,
            'transfer_data' => [
                'destination' => $stripeAccount,
              ],
          ]
        //   , ['stripe_account' => $stripeAccount]
        );

        return $this->appResponse(true, 'success', 'Client Secret and stripe account Id', [
            'client_secret'=>$intent->client_secret,
            'account_connection_id' => $stripeAccount
        ], 200);
    }

}
