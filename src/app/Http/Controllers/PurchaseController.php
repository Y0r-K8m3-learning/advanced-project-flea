<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use App\Models\Item;
use App\Models\PaymentMethod;
use Illuminate\Support\Facades\Auth;

class PurchaseController extends Controller
{

    public function edit($item_id)
    {
        return view('payment_edit', compact('item_id'));
    }

    public function update(Request $request)
    {

        $validated = $request->validate([
            'payment_method' => 'required|in:card,bank_transfer,konbini',
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

        // Stripeの設定
        \Stripe\Stripe::setApiKey(config('stripe.stripe_secret_key'));
        // セッションまたはDBから支払い方法を取得
        $paymentMethod = session('payment_method');
        $methods = PaymentMethod::all();

        $selectedPaymentMethodLabel = $paymentMethod ?? 'card';
        $paymethod = collect($methods)->firstWhere('value', $selectedPaymentMethodLabel);

        // 支払い情報を作成
        $paymentIntent = \Stripe\PaymentIntent::create([
            'amount' => $item->price * 100,
            'currency' => 'jpy',
            'payment_method_types' => [$selectedPaymentMethodLabel],
        ]);

        $clientSecret = $paymentIntent->client_secret;

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

        return view('purchase', compact('item', 'shipping', 'clientSecret', 'selectedPaymentMethodLabel', 'paymethod'));
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
