<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use App\Models\Item;
use App\Models\PaymentMethod;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PurchaseController extends Controller
{

    public function edit($item_id)
    {
        return view('payment_edit', compact('item_id'));
    }

    public function update(Request $request)
    {

        $validated = $request->validate([
            'payment_method' => 'required|in:card,customer_balance,konbini',
            'item_id' => 'required|integer',
        ]);

        // 選択された支払い方法をセッションに保存
        session(['payment_method' => $validated['payment_method']]);

        // 元の購入ページにリダイレクト
        return redirect()->route('purchase.show', ['item' => $validated['item_id']])->with('success', '支払い方法を更新しました');
    }

    public function show($itemId)
    {
        // ログインしていない場合はログインページへリダイレクト
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        // 商品データを取得
        $item = Item::find($itemId);

        // 商品が存在しない場合は404エラー
        if (!$item) {
            abort(404, '商品が見つかりません');
        }

        // 選択した商品をセッションに保存
        session(['selected_item_id' => $itemId]);

        // セッションまたはDBから支払い方法を取得
        $paymentMethod = session('payment_method');
        $methods = PaymentMethod::all();

        $selectedPaymentMethodLabel = $paymentMethod ?? 'card';
        $paymethod = collect($methods)->firstWhere('value', $selectedPaymentMethodLabel);



        // 商品データ（DBから取得）
        $item = [
            'item_id' => $itemId,
            'name' => $item->name,
            'price' => $item->price,
            'image' => $item->image_url,
        ];

        // 配送情報を取得（例: ユーザーの配送情報）
        $user = auth()->user(); // ログイン中のユーザーを取得

        $shipping = [
            'postcode' => $user->postcode ?? '未登録',
            'address' => $user->address ?? '未登録',
            'building' => $user->building ?? '未登録',
        ];
        return view('purchase', compact('item', 'shipping',  'selectedPaymentMethodLabel', 'paymethod'));
    }

    public function confirm(Request $request)
    {
        $data = $request->validate([
            'paymentIntentId' => 'required|string',
            'item_id' => 'required|integer',
        ]);

        Stripe::setApiKey(config('stripe.stripe_secret_key'));
        try {
            $paymentIntent = PaymentIntent::retrieve($data['paymentIntentId']);
        } catch (\Exception $e) {
            Log::error('PaymentIntent retrieve error: ' . $e->getMessage());
            return response()->json(['success' => false, 'error' => 'Failed to retrieve PaymentIntent.'], 500);
        }
        Log::error($paymentIntent->status);
        if ($paymentIntent->status === 'succeeded') {
            $item = Item::find($data['item_id']);
            if ($item) {
                $item->sales_flg = true;
                $item->save(); // DB更新
            }
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false, 'error' => 'Payment not succeeded'], 400);
        }
    }

    // 購入ボタンが押されたときに呼ばれるメソッド
    // フロントから item_id, payment_methodなどを受け取りPaymentIntent作成
    // 購入ボタンクリック後に呼ばれるメソッド
    // item_idとpayment_methodを受け取り、ここでPaymentIntentを作成
    public function initiatePurchase(Request $request)
    {
        try {
            $data = $request->validate([
                'item_id' => 'required|integer',
                'payment_method' => 'required|in:card,konbini,customer_balance'
            ]);

            $item = [
                'price' =>
                $request['price'],
            ];

            Stripe::setApiKey(config('stripe.stripe_secret_key'));

            $paymentIntentParams = [
                'amount' => $item['price'],
                'currency' => 'jpy',
            ];

            if ($data['payment_method'] === 'card') {
                $paymentIntentParams['payment_method_types'] = ['card'];
            } elseif ($data['payment_method'] === 'konbini') {
                $paymentIntentParams['payment_method_types'] = ['konbini'];
            } elseif ($data['payment_method'] === 'customer_balance') {
                // Bank Transfer用にcustomerが必要
                $customer = \Stripe\Customer::create([
                    'email' => 'customer@example.com',
                ]);
                $paymentIntentParams['customer'] = $customer;
                $paymentIntentParams['payment_method_types'] = ['customer_balance', 'card'];
                $paymentIntentParams['payment_method_data'] = [
                    'type' => 'customer_balance',
                ];
                $paymentIntentParams['payment_method_options'] = [
                    'customer_balance' => [
                        'funding_type' => 'bank_transfer',
                        'bank_transfer' => [
                            'type' => 'jp_bank_transfer',
                        ],
                    ],
                ];
            }

            // エラーハンドリングも考慮

            $paymentIntent = PaymentIntent::create($paymentIntentParams);
            return response()->json([
                'client_secret' => $paymentIntent->client_secret,
                'payment_intent_id' => $paymentIntent->id
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
