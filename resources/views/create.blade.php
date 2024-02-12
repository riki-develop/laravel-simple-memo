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
            <input type="text" name="new_tag" class="form-control w-50 mb-3" placeholder="新しいタグを入力" />
            <button type="submit" class="btn btn-primary">保存</button>
        </form>
    </div>
@endsection
