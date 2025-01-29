<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;
use App\Models\UserDetail;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $user = auth()->user();
        $userDetail = $user->userDetail;

        return view('auth.profile_edit', compact('user', 'userDetail'));
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request)
    {
        $user = Auth::user();
        $userDetail = $user->userDetail;

        // バリデーション済みデータの取得
        $validatedData = $request->validated();

        // ユーザー名の更新
        $user->name = $validatedData['username'];
        $user->save();

        // アイコンの処理
        if ($request->hasFile('icon')) {
            // 既存の画像がある場合は削除
            if ($userDetail && $userDetail->image_id) {
                Storage::disk('public')->delete($userDetail->image_id);
            }

            // 新しい画像を保存
            $path = $request->file('icon')->store('images', 'public');

            // UserDetailの更新または作成
            if ($userDetail) {
                $userDetail->image_id = $path;
                $userDetail->post_code = $validatedData['post_code'];
                $userDetail->address = $validatedData['address'];
                $userDetail->building = $validatedData['building'];
                $userDetail->save();
            } else {
                $user->userDetail()->create([
                    'image_id' => $path,
                    'post_code' => $validatedData['post_code'],
                    'address' => $validatedData['address'],
                    'building' => $validatedData['building'],
                ]);
            }
        } else {
            // アイコンが更新されていない場合の処理
            if ($userDetail) {
                $userDetail->post_code = $validatedData['post_code'];
                $userDetail->address = $validatedData['address'];
                $userDetail->building = $validatedData['building'];
                $userDetail->save();
            } else {
                $user->userDetail()->create([
                    'post_code' => $validatedData['post_code'],
                    'address' => $validatedData['address'],
                    'building' => $validatedData['building'],
                ]);
            }
        }

        return redirect()->route('profile.edit')->with('status', 'プロフィールが更新されました。');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
