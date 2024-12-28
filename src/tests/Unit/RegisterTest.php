<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegisterTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /**
     * テスト用のユーザーをセットアップ
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        // ここでは既存のユーザーは作成しません。必要に応じて追加してください。
    }

    /**
     * 登録ページが正常に表示されることを確認するテスト
     *
     * @return void
     */
    public function test_registration_page_displays_correctly()
    {
        $response = $this->get(route('register'));

        $response->assertStatus(200);
        $response->assertViewIs('register'); // ビュー名が 'register.blade.php' であることを確認
        $response->assertSee('Profile Register');
        $response->assertSee('メールアドレス');
        $response->assertSee('パスワード');
        $response->assertSee('Register');
        $response->assertSee('ログインはこちら');
    }

    /**
     * 正しい登録情報でユーザーが登録できることを確認するテスト
     *
     * @return void
     */
    public function test_user_can_register_with_valid_data()
    {
        // 登録フォームに送信するデータ
        $userData = [
            'email' => 'newuser@example.com',
            'password' => 'password123',
            // 'password_confirmation' => 'password123', // 必要に応じて
        ];

        // 登録試行
        $response = $this->post(route('register'), $userData);

        // 登録後にリダイレクトされることを確認（例: ホームページ）
        $response->assertRedirect(route('home'));

        // ユーザーがデータベースに存在することを確認
        $this->assertDatabaseHas('users', [
            'email' => 'newuser@example.com',
        ]);

        // ユーザーが認証されていることを確認
        $user = User::where('email', 'newuser@example.com')->first();
        $this->assertAuthenticatedAs($user);
    }

    /**
     * 既に存在するメールアドレスで登録を試みた場合、登録に失敗することを確認するテスト
     *
     * @return void
     */
    public function test_user_cannot_register_with_existing_email()
    {
        // 既存のユーザーを作成
        $existingUser = User::factory()->create([
            'email' => 'existinguser@example.com',
        ]);

        // 登録フォームに送信するデータ
        $userData = [
            'email' => 'existinguser@example.com',
            'password' => 'password123',
            // 'password_confirmation' => 'password123', // 必要に応じて
        ];

        // 登録試行
        $response = $this->from(route('register'))->post(route('register'), $userData);

        // リダイレクト先が登録ページであることを確認
        $response->assertRedirect(route('register'));

        // セッションにエラーメッセージが含まれていることを確認
        $response->assertSessionHasErrors('email');

        // ユーザーが認証されていないことを確認
        $this->assertGuest();
    }

    /**
     * 不正な登録情報で登録を試みた場合、登録に失敗することを確認するテスト
     *
     * @return void
     */
    public function test_user_cannot_register_with_invalid_data()
    {
        // 不正な登録データ（例: 無効なメールアドレス、短すぎるパスワード）
        $invalidData = [
            'email' => 'invalid-email',
            'password' => 'short',
            // 'password_confirmation' => 'different', // 必要に応じて
        ];

        // 登録試行
        $response = $this->from(route('register'))->post(route('register'), $invalidData);

        // リダイレクト先が登録ページであることを確認
        $response->assertRedirect(route('register'));

        // セッションにエラーメッセージが含まれていることを確認
        $response->assertSessionHasErrors(['email', 'password']);

        // ユーザーが認証されていないことを確認
        $this->assertGuest();
    }

    /**
     * 認証済みユーザーが登録ページにアクセスするとホームページにリダイレクトされることを確認するテスト
     *
     * @return void
     */
    public function test_authenticated_user_is_redirected_from_register_page()
    {
        // 既存のユーザーを作成
        $user = User::factory()->create();

        // ユーザーを認証状態にする
        $this->actingAs($user);

        // 登録ページにアクセス
        $response = $this->get(route('register'));

        // ホームページにリダイレクトされることを確認
        $response->assertRedirect(route('home'));
    }
}
