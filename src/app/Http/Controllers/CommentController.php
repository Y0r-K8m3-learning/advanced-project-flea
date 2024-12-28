<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;

class CommentController extends Controller
{
    /**
     * コメント一覧を表示する。
     */
    public function index($selectedOwnerId)
    {
        // 最新のコメントから表示
        $comments =  Review::where('user_id', $selectedOwnerId)->with('item')->latest()->paginate(20);  // ページネーションを追加

        return view('admin.owners.comment', compact('comments'));
    }

    /**
     * コメントを削除する。
     */
    public function destroy(Review $comment)
    {
        // 認可チェック（ポリシーが設定されている場合）
        // Gate::authorize('delete', $comment);

        $comment->delete();
        // 最新のコメントから表示
        $comments =  Review::where('user_id', $comment->user_id)->with('item')->latest()->paginate(20);  // ページネーションを追加

        return view('admin.owners.comment', compact('comments'))->with('success', 'コメントを削除しました。');
    }
}
