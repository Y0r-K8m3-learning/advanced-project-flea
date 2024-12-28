<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Category;
use App\Models\Condition;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ItemStoreTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    protected $user;
    protected $categories;
    protected $condition;

    /**
     * テスト用のデータをセットアップ
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        // テスト用のユーザーを作成
        $this->user = User::factory()->create();

        // テスト用のカテゴリーを複数作成
        $this->categories = Category::factory()->count(3)->create();

        // テスト用のコンディションを作成
        $this->condition = Condition::factory()->create();
    }

    /**
     * 商品を正常に出品できることを確認するテスト
     *
     * @return void
     */
    public function test_user_can_store_item_with_image()
    {
        // ストレージをフェイクする
        Storage::fake('public');

        // 出品フォームに送信するデータ
        $data = [
            'image' => UploadedFile::fake()->image('product.jpg'),
            'categories' => $this->categories->pluck('id')->toArray(),
            'condition' => $this->condition->id,
            'name' => 'テスト商品',
            'brand' => 'テストブランド',
            'description' => 'これはテスト商品の説明です。',
            'price' => 5000,
        ];

        // 認証状態にする
        $response = $this->actingAs($this->user)
            ->post(route('item.store'), $data);

        // リダイレクトの確認
        $response->assertRedirect(route('items.create'));

        // セッションに成功メッセージが含まれていることを確認
        $response->assertSessionHas('success', '商品が正常に出品されました。');

        // データベースに商品が存在することを確認
        $this->assertDatabaseHas('items', [
            'name' => 'テスト商品',
            'brand' => 'テストブランド',
            'description' => 'これはテスト商品の説明です。',
            'price' => 5000,
            'user_id' => $this->user->id,
        ]);

        // 画像がストレージに保存されていることを確認
        Storage::disk('public')->assertExists('images/' . $data['image']->hashName());

        // 商品にカテゴリーが関連付けられていることを確認
        $item = \App\Models\Item::where('name', 'テスト商品')->first();
        $this->assertCount(3, $item->categories);
    }

    /**
     * 未認証ユーザーが商品を出品できないことを確認するテスト
     *
     * @return void
     */
    public function test_guest_cannot_store_item()
    {
        // 出品フォームに送信するデータ
        $data = [
            'image' => UploadedFile::fake()->image('product.jpg'),
            'categories' => [1, 2],
            'condition' => 1,
            'name' => 'テスト商品',
            'brand' => 'テストブランド',
            'description' => 'これはテスト商品の説明です。',
            'price' => 5000,
        ];

        // 未認証状態で出品を試みる
        $response = $this->post(route('item.store'), $data);

        // リダイレクト先がログインページであることを確認
        $response->assertRedirect(route('login'));

        // データベースに商品が存在しないことを確認
        $this->assertDatabaseMissing('items', [
            'name' => 'テスト商品',
        ]);

        // ストレージに画像が保存されていないことを確認
        Storage::disk('public')->assertMissing('images/' . $data['image']->hashName());
    }

    /**
     * 不正なデータで商品を出品できないことを確認するテスト
     *
     * @return void
     */
    public function test_store_item_with_invalid_data_fails()
    {
        // ストレージをフェイクする
        Storage::fake('public');

        // 出品フォームに送信する不正なデータ（画像なし、カテゴリなし、価格マイナスなど）
        $data = [
            // 'image' => UploadedFile::fake()->image('product.jpg'), // 画像なし
            'categories' => [], // カテゴリーなし
            'condition' => 999, // 存在しないコンディションID
            'name' => '', // 商品名なし
            'brand' => '', // ブランド名なし（オプションの場合はOK）
            'description' => '', // 説明なし
            'price' => -100, // マイナス価格
        ];

        // 認証状態にする
        $response = $this->actingAs($this->user)
            ->post(route('item.store'), $data);

        // リダイレクト先が出品ページであることを確認
        $response->assertRedirect(route('items.create'));

        // セッションにエラーメッセージが含まれていることを確認
        $response->assertSessionHasErrors(['image', 'categories', 'condition', 'name', 'description', 'price']);

        // データベースに商品が存在しないことを確認
        $this->assertDatabaseMissing('items', [
            'user_id' => $this->user->id,
        ]);

        // ストレージに画像が保存されていないことを確認
        // 画像が送信されていないため特に確認する必要はありません
    }
}
