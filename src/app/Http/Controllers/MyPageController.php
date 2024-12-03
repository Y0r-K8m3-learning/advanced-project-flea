<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class MyPageController extends Controller
{

    public function address_index()
    {
        // ダミーデータをビューに渡す
        $user = (object) [
            'username' => 'ダミー太郎',
            'postcode' => '123-4567',
            'address' => 'XXXXX',
            'building' => 'ダミービル101',
            'icon' => null, // アイコンは未設定
        ];
        return view('auth.address_edit', ['user' => $user]);
    }

    public function address_edit() {}

    public function profile()
    {
        // ダミーデータをビューに渡す
        $user = (object) [
            'username' => 'hoge',
            'postcode' => '123-4567',
            'address' => 'XXXX',
            'building' => 'hogeービル101',
            'icon' => null, // アイコンは未設定
        ];

        //return view('auth.profile_edit', ['user' => auth()->user()]);
        return view('auth.profile_edit', ['user' => $user]);
    }
    public function index()
    {
        // ダミーデータの設定
        $listings = [
            ['name' => '商品A', 'image' => 'images/product_a.png', 'price' => 1200],
            ['name' => '商品B', 'image' => 'images/product_b.png', 'price' => 2500],
        ];

        $purchases = [
            ['name' => '商品C', 'image' => 'images/product_c.png', 'price' => 3000],
            ['name' => '商品D', 'image' => 'images/product_d.png', 'price' => 1800],
        ];

        // ビューにダミーデータを渡す
        return view('mypage', compact('listings', 'purchases'));


        $user = auth()->user();

        // ダミーデータでリストを作成（後でDB接続に切り替え）
        $listings = Product::where('user_id', $user->id)->get(); // 出品商品
        $purchases = Product::whereHas('purchases', function ($query) use ($user) {
            $query->where('user_id', $user->id); // 購入商品
        })->get();

        return view('mypage', [
            'user' => $user,
            'listings' => $listings,
            'purchases' => $purchases,
        ]);
    }

    public function destroy($id)
    {
        $user = Auth::user();

        Reservation::where('user_id', $user->id)
            ->where('id', $id)
            ->delete();

        return response()->json(['status' => 'deleted']);
    }
}
