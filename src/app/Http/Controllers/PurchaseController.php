<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\PaymentIntent;

class PurchaseController extends Controller
{

    public function edit()
    {
        $paymentMethod = 'stripe'; // ダミーデータ

        return view('payment_edit', compact('paymentMethod'));
    }

    public function update(Request $request)
    {
        return redirect()->route('checkout.index')->with('status', '支払方法を更新しました（ダミー処理）。');
    }

    public function index()
    {

        \Stripe\Stripe::setApiKey(config('stripe.stripe_secret_key'));
        $paymentIntent = PaymentIntent::create([
            'amount' => 1200 * 100, // 金額（セント単位）
            'currency' => 'jpy',
            'payment_method_types' => ['card'],
        ]);

        $clientSecret = $paymentIntent->client_secret;

        // ダミーデータ
        $product = [
            'name' => 'ダミー商品',
            'price' => 1200,
            'image' => 'images/dummy_product.png',
        ];

        // ダミーデータ
        $product = [
            'name' => 'ダミー商品',
            'price' => 1200,
            'image' => 'images/dummy_product.png',
        ];

        $shipping = [
            'postcode' => '123-4567',
            'address' => '東京都渋谷区道玄坂',
            'building' => 'ダミービル101',
        ];

        return view('purchase', compact('product', 'shipping', 'clientSecret'));
    }

    public function process(Request $request)
    {
        // Stripe 支払い処理
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));
        //
        try {
            $paymentIntent = $stripe->paymentIntents->create([
                'amount' => $request->product['price'] * 100, // 金額はセント単位
                'currency' => 'jpy',
                'payment_method_types' => ['card'],
            ]);

            return redirect()->route('purchase.success');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
