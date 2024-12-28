<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;

class ItemControllerTest   extends TestCase
{
    use WithFaker;

    /**
     * index メソッドのテスト
     *
     * @return void
     */
    public function test_index_method_displays_home_view_with_items()
    {
        $response = $this->get(route('home')); // または route('index')

        $response->assertStatus(200);
        $response->assertViewIs('home');
        $response->assertViewHas('items');

        $items = $response->viewData('items');
        $this->assertIsIterable($items);
    }

    /**
     * search メソッドのテスト - おすすめアイテム
     *
     * @return void
     */
    public function test_search_method_with_recommend_parameter_returns_recommended_items()
    {
        $response = $this->get(route('item.search', ['recommend' => true]));

        $response->assertStatus(200);
        $response->assertJsonStructure(['items' => [['id', 'name', 'image_url']]]);

        $items = $response->json('items');
        $this->assertCount(3, $items); // search メソッドではおすすめアイテムを 3 件取得
    }

    /**
     * search メソッドのテスト - マイリストアイテム（未認証）
     *
     * @return void
     */
    public function test_search_method_with_mylist_parameter_without_authentication()
    {
        $response = $this->get(route('item.search', ['mylist' => true]));

        $response->assertStatus(200);
        $response->assertJsonStructure(['redirect']);

        $this->assertEquals(route('login'), $response->json('redirect'));
    }

    /**
     * search メソッドのテスト - マイリストアイテム（認証済み）
     *
     * @return void
     */
    public function test_search_method_with_mylist_parameter_with_authentication()
    {
        $user = User::first(); // 既存のユーザーを取得
        $this->actingAs($user);

        $response = $this->get(route('item.search', ['mylist' => true]));

        $response->assertStatus(200);
        $response->assertJsonStructure(['items' => [['id', 'name', 'image_url']]]);

        $items = $response->json('items');

        // ユーザーがお気に入りに登録している商品を確認
        $expectedItems = $user->favorites->map(function ($favorite) {
            return [
                'id' => $favorite->item->id,
                'name' => $favorite->item->name,
                'image_url' => asset($favorite->item->image_url),
            ];
        })->toArray();

        $this->assertEquals($expectedItems, $items);
    }
}
