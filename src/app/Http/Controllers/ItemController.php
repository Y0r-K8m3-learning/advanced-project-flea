<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Favorite;
use App\Models\Category;
use App\Models\Condition;
use App\Models\ItemCategory;

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

    public function search(Request $request)
    {
        $query = Item::query();

        // おすすめアイテムをランダムに数件取得
        if ($request->has('recommend')) {
            $items = Item::inRandomOrder() // ランダム順序
                ->limit(3) // 件数制限
                ->get();
        }
        // マイリストアイテムを取得
        elseif ($request->has('mylist')) {

            if (!auth()->check()) {
                return response()->json([
                    'redirect' => route('login')
                ]);
            }

            $userId = auth()->id(); // ログインユーザーのIDを取得
            $items = Item::whereHas('favorites', function ($q) use ($userId) {
                $q->where('user_id', $userId);
            })
                ->get(); // HTTPステータスコード403（Forbidden）を返す
        } else {
            $items = collect(); // 空のコレクションを返す
        }

        return response()->json([
            'items' => $items->map(function ($item) {
                return [
                    'id' => $item->id,
                    'name' => $item->name,
                    'image_url' => asset($item->image_url),
                ];
            }),
        ]);
    }

    public function review_store(Request $request)
    {
        // バリデーション
        $request->validate([
            'item_id' => 'required|exists:items,id', // item_idが必須かつitemsテーブルに存在することを確認
            'comment' => 'required|string|max:500', // コメントは必須、文字列、最大500文字
        ]);

        // 商品が存在するか確認
        $item = Item::find($request->input('item_id'));
        if (!$item) {
            return redirect()->back()->with('error', '対象の商品が見つかりません。');
        }
        // レビューを保存
        $review = new Review();
        $review->item_id = $request->input('item_id');
        $review->user_id = auth()->id(); // 現在ログイン中のユーザーIDを取得
        $review->comment = $request->input('comment');
        $review->save();

        return redirect()->back()->with('success', 'レビューが投稿されました。');
    }

    public function showDetail($id)
    {
        // データベースから商品情報を取得
        $item = Item::find($id);

        // データが存在しない場合は404エラーを返す
        if (!$item) {
            abort(404, '商品が見つかりません');
        }
        // コメント情報を取得
        $comments = Review::where('item_id', $id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view(
            'detail',
            [
                'item' => $item,
                'comments' => $comments
            ]
        );
    }
    public function itemCreate()
    {
        // categories と conditions のデータを取得
        $categories = Category::all(); // すべてのカテゴリーを取得
        $conditions = Condition::all(); // すべての商品の状態を取得

        // ビューにデータを渡す
        return view('item_create', compact('categories', 'conditions'))->with('success', '商品が出品されました');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'image' => 'required|image|max:2048',
            'categories' => 'required|array',
            'condition' => 'required|string',
            'brand' => 'required|string',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|integer|min:0',
        ]);

        $imagePath = $request->file('image')->store('items', 'public');
        $itemCategoryIds = [];

        $item = Item::insertGetId([
            'image_url' => $imagePath,
            'condition_id' => $validated['condition'],
            'brand' => $validated['brand'],
            'seller_id' => auth()->id(),
            'name' => $validated['name'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        foreach ($validated['categories'] as $target) {

            // item_category テーブルに登録
            ItemCategory::create([
                'item_id' => $item,
                'category_id' => $target,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }


        return redirect()->route('item.create')->with('success', '商品が出品されました');
    }


    public function favoriteToggle(Request $request)
    {
        $user = auth()->user();

        if (!$user) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        $itemId = $request->input('item_id');

        // お気に入りの状態を切り替え
        $favorite = Favorite::where('user_id', $user->id)->where('item_id', $itemId)->first();

        if ($favorite) {
            // お気に入りを解除
            $favorite->delete();
            return response()->json(['is_favorite' => false]);
        } else {
            // お気に入りに追加
            Favorite::create([
                'user_id' => $user->id,
                'item_id' => $itemId,
            ]);
            return response()->json(['is_favorite' => true]);
        }
    }
}
