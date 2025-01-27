<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use Illuminate\Foundation\Testing\RefreshDatabase;


class ItemDetailTest extends TestCase
{

    /**
     * ホームページが正常に表示されることを確認するテスト
     *
     * @return void
     */
    public function test_home_page_displays_correctly()
    {
        $response = $this->get(route('home')); // ルート名 'home' を使用

        $response->assertStatus(200);
        $response->assertViewIs('home'); // ビュー名が 'home.blade.php' と仮定

        // CSS の読み込み確認
        $response->assertSee('css/card.css', false);
        $response->assertSee('css/home.css', false);
        $response->assertSee('fonts.googleapis.com', false);

        // JS の読み込み確認
        $response->assertSee('js/home.js', false);

        // CSRF トークンの確認
        $response->assertSee('window.csrfToken', false);

        // リンクの確認
        $response->assertSee(route('item.search', ['recommend' => true]), false);
        $response->assertSee(route('item.search', ['mylist' => true]), false);

        // データベースに存在する商品が表示されていることを確認
        $items = \App\Models\Item::all();
        foreach ($items as $item) {
            $response->assertSee(asset($item->image_url), false);
            $response->assertSee($item->name, false);
            $response->assertSee(route('items.detail', ['id' => $item->id]), false);
        }
    }
}
