@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">新規メモ作成</div>
        <form class="card-body" action="/store" method="POST">
            <div class="form-group mb-3">
                @csrf {{-- なりすまし対策 --}}
                <textarea class="form-control" name="content" row5="3" placeholder="ここにメモを入力"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">保存</button>
        </form>
    </div>
@endsection
