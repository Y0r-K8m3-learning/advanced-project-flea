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
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $user = auth()->user();
        $userDetail = $user->userDetail;


        // アイコンのアップロード処理
        if ($request->hasFile('icon')) {
            // 既存のアイコンがあれば削除
            if ($userDetail && $userDetail->image_id) {
                Storage::delete($userDetail->image_id);
            }

            $path = $request->file('icon')->store('public/icons');
            $validated['image_id'] = $path;
        }

        // ユーザー名の更新
        $user->username = $validated['username'];
        $user->save();

        // ユーザー詳細の更新または作成
        if ($userDetail) {
            $userDetail->post_code = $validated['post_code'];
            $userDetail->address = $validated['address'];
            $userDetail->building = $validated['building'];
            if (isset($validated['image_id'])) {
                $userDetail->image_id = $validated['image_id'];
            }
            $userDetail->save();
        } else {
            UserDetail::create([
                'user_id' => $user->id,
                'post_code' => $validated['post_code'],
                'address' => $validated['address'],
                'building' => $validated['building'],
                'image_id' => $validated['image_id'] ?? null,
            ]);
        }

        return redirect()->route('mypage')->with('status', 'プロフィールが更新されました。');
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
