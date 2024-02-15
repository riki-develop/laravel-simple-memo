@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">新規メモ作成</div>
        {{-- web.phpのルーティング設定で「->name('store')」を定義しているのでroute('store')と書くと→　　/storeになる --}}
        <form class="card-body" action="{{ route('store') }}" method="POST">
            <div class="form-group mb-3">
                @csrf {{-- なりすまし対策 --}}
                <textarea class="form-control" name="content" row5="3" placeholder="ここにメモを入力"></textarea>
            </div>

            @error('content') {{-- バリデーションエラー文 --}}
                <div class="alert alert-danger">メモ内容を入力してください！</div>
            @enderror

            @foreach ($tags as $t)
                <div class="form-check form-check-inline mb-3">
                    {{-- タグは複数選択を想定し、name属性は「配列」で定義する --}}
                    <input type="checkbox" name="tags[]" id="{{ $t['id'] }}" value="{{ $t['id'] }}" class="form-check-input" />
                    <label for="{{ $t['id'] }}">{{ $t['name'] }}</label>
                </div>
            @endforeach

            <input type="text" name="new_tag" class="form-control w-50 mb-3" placeholder="新しいタグを入力" />
            <button type="submit" class="btn btn-primary">保存</button>
        </form>
    </div>
@endsection
