<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\UserDetail;

class MyPageController extends Controller
{

    public function address_index()
    {
        // ログインユーザーのID取得
        $userId = auth()->id();

        // user_detailテーブルからログインユーザーのデータを取得
        $userDetail = UserDetail::where('user_id', $userId)->first();
        if (!$userDetail) {
            $userDetail = (object)[
                'username' => '未設定',
                'post_code' => '',
                'address' => '',
                'building' => '',
                'icon' => null,
            ];
        }
        return view('auth.address_edit', ['user' => $userDetail]);
    }

    public function address_update(Request $request)
    {
        // バリデーション
        $validated = $request->validate([
            'post_code' => 'required|string|max:10', // 郵便番号の形式に合わせて調整
            'address'  => 'required|string|max:255',
            'building' => 'nullable|string|max:255',
        ]);

        $userId = auth()->id();
        $userDetail = UserDetail::where('user_id', $userId)->first();

        // user_detail レコードがない場合、新規作成
        if (!$userDetail) {
            $userDetail = new UserDetail();
            $userDetail->user_id = $userId;
        }

        // 更新
        $userDetail->post_code = $validated['post_code'];
        $userDetail->address  = $validated['address'];
        $userDetail->building = $validated['building'] ?? '';
        $userDetail->save();

        // セッションから選択商品IDを取得
        $itemId = session('selected_item_id');
        if (!$itemId) {
            return redirect()->route('home')->with('error', '商品が選択されていません');
        }
        // 更新後、元のページや購入ページへ戻す
        return redirect()->route('purchase.show', ['item' => $itemId])->with('success', '住所情報が更新されました！');
    }

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
