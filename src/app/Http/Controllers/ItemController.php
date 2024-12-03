<?php

namespace App\Http\Controllers;

use App\Models\Item;
use GuzzleHttp\Psr7\Request;

class ItemController extends Controller
{

    public function index()
    {

        // おすすめ: ランダムに5件
        $items = Item::inRandomOrder()->take(5)->get();



        // すべてのアイテムを取得
        $items = Item::all();


        return view('home', compact('items'));
    }

    // Ajax 検索
    public function search(Request $request)
    {
        $items = [];

        if ($request->type === 'recommend') {
            // おすすめ: ランダムに5件
            $items = Item::inRandomOrder()->take(5)->get();
        } elseif ($request->type === 'mylist') {
            // マイリスト: ログイン中のユーザーのお気に入りアイテム
            $items = auth()->user()->favorites()->with('item')->get()->pluck('item');
        }

        return response()->json(['items' => $items]);
    }

    public function showDetail($id)
    {

        // ダミーデータ（実際はデータベースから取得）
        $item = [
            'id' => $id,
            'image' => 'storage/images/items/juice.png',
            'name' => '商品' . $id,
            'description' => 'この商品の詳細情報です。',
            'price' => 1200
        ];

        return view('detail', compact('item'));
    }
    public function itemCreate()
    {
        // ダミーデータ（実際はデータベースから取得）


        return view('item_create');
    }
}
