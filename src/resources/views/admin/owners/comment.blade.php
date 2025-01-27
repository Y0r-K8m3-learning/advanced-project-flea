<x-app-layout>
    <div class="container mt-5 w-75">
        <h2 class="fw-bold fs-4 mb-4">コメント一覧</h2>

        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        <!-- ユーザ一覧に戻るボタン -->
        <a href="{{ route('admin.owners.index') }}" class="btn btn-secondary mb-3">
            <i class="bi bi-arrow-left"></i> ユーザ一覧
        </a>

        <!-- コメント一覧テーブル -->
        <div class="row mt-4">
            <div class="col-12 rounded">
                <table class="table table-striped table-hover table-bordered align-middle table-secondary shadow">
                    <thead class="table-secondary text-center">
                        <tr>
                            <th>商品</th>
                            <th>ユーザー</th>
                            <th>コメント内容</th>
                            <th>投稿日時</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($comments as $comment)
                        <tr class="text-center">
                            <td>{{ $comment->item->name }}</td>
                            <td>{{ $comment->user->name ?? 'ゲスト' }}</td>
                            <td>{{ $comment->comment }}</td>
                            <td>{{ $comment->created_at->format('Y-m-d H:i') }}</td>
                            <td>
                                <!-- コメント削除ボタン -->
                                <form action="{{ route('admin.comments.destroy', $comment) }}" method="POST" onsubmit="return confirm('本当に削除しますか？');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="bi bi-trash"></i> 削除
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5">コメントがありません。</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- ページネーション -->
                <div class="d-flex justify-content-center">
                    {{ $comments->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>