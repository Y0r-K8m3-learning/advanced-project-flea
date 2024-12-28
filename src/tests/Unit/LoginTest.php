<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends TestCase
{
    use WithFaker;

    /**
     * テスト用のユーザーをセットアップ
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        // 既存のユーザーが存在することを前提としています。
        // 必要に応じて、特定のユーザーを取得または作成します。
        // 例:
        // $this->user = User::factory()->create([
        //     'email' => 'test@example.com',
        //     'password' => bcrypt('password123'),
        // ]);
    }

    /**
     * ログインページが正常に表示されることを確認するテスト
     *
     * @return void
     */
    public function test_login_page_displays_correctly()
    {
        $response = $this->get(route('login'));

        $response->assertStatus(200);
        $response->assertViewIs('login'); // ビュー名が 'login.blade.php' であることを確認
        $response->assertSee('メールアドレス');
        $response->assertSee('パスワード');
        $response->assertSee('Log in');
        $response->assertSee('会員登録はこちら');
    }

    /**
     * 正しい認証情報でユーザーがログインできることを確認するテスト
     *
     * @return void
     */
    public function test_user_can_login_with_correct_credentials()
    {
        // 既存のユーザーを取得（メールアドレスとパスワードを知っていることが前提）
        $user = User::where('email', 'test@example.com')->first();

        // テスト用のパスワード（実際のユーザーのパスワードを知っている必要があります）
        $password = 'password123';

        $response = $this->post(route('login'), [
            'email' => $user->email,
            'password' => $password,
        ]);

        // 認証後、リダイレクト先がホームページ（例）であることを確認
        $response->assertRedirect(route('home'));

        // ユーザーが認証されていることを確認
        $this->assertAuthenticatedAs($user);
    }





    /**
     * 存在しないユーザーでログインを試みた場合、ログインに失敗することを確認するテスト
     *
     * @return void
     */
    public function test_user_cannot_login_with_non_existing_user()
    {
        // 存在しないメールアドレスを使用
        $credentials = [
            'email' => 'nonexistentuser@example.com',
            'password' => 'somepassword',
        ];

        // ログイン試行
        $response = $this->from(route('login'))->post(route('login'), $credentials);

        // リダイレクト先がログインページであることを確認
        $response->assertRedirect(route('login'));

        // セッションにエラーメッセージが含まれていることを確認
        $response->assertSessionHasErrors('email');

        // ユーザーが認証されていないことを確認
        $this->assertGuest();
    }


    /**
     * 認証済みユーザーがログインページにアクセスすると、ホームページにリダイレクトされることを確認するテスト
     *
     * @return void
     */
    public function test_authenticated_user_is_redirected_from_login_page()
    {
        // 既存のユーザーを取得
        $user = User::where('email', 'test@example.com')->first();

        // ユーザーを認証状態にする
        $this->actingAs($user);

        $response = $this->get(route('login'));

        // 認証済みユーザーはホームページにリダイレクトされることを確認
        $response->assertRedirect(route('home'));
    }

    /**
     * ログインに必要なフィールドがバリデーションされていることを確認するテスト
     *
     * @return void
     */
    public function test_login_requires_email_and_password()
    {
        $response = $this->from(route('login'))->post(route('login'), [
            'email' => '',
            'password' => '',
        ]);

        // リダイレクト先がログインページであることを確認
        $response->assertRedirect(route('login'));

        // セッションにエラーメッセージが含まれていることを確認
        $response->assertSessionHasErrors(['email', 'password']);

        // ユーザーが認証されていないことを確認
        $this->assertGuest();
    }
}
