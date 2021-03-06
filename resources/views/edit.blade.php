@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">メモ編集</div>
    <!-- route('store')と書くと → /store と出力される（Laravelメソッド） -->
    <form class="card-body" action="{{ route('store') }}" method="POST">
        <!-- csrfトークン発行：成りすまし送信防止 -->
        @csrf
        <div class="form-group">
            <textarea class="form-control" name="content" rows="3" placeholder="ここにメモを入力">{{ $edit_memo['content'] }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">更新</button>
    </form>
</div>
@endsection
