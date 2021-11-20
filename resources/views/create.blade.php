@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">新規メモ作成</div>
    <!-- route('store')と書くと → /store と出力される（Laravelメソッド） -->
    <form class="card-body" action="{{ route('store') }}" method="POST">
        <!-- csrfトークン発行：成りすまし送信防止 -->
        @csrf
        <div class="form-group">
            <textarea class="form-control" name="content" rows="3" placeholder="ここにメモを入力"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">保存</button>
    </form>
</div>
@endsection
