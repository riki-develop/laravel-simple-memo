@extends('layouts.app')

{{-- app.blade.phpに渡す --}}
@section('javascript')
    <script src="/js/confirm.js"></script>
@endsection

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            メモ編集
            <form id="delete-form" action="{{ route('destroy') }}" method="POST">
                @csrf
                <input type="hidden" name="memo_id" value="{{ $edit_memo[0]['id'] }}" />
                <i class="fa-solid fa-trash me-3" onclick="deleteHandle(event);"></i>
            </form>
        </div>
        <form class="card-body my-card-body" action="{{ route('update') }}" method="POST">
            <div class="form-group mb-3">
                @csrf {{-- なりすまし対策 --}}
                <input type="hidden" name="memo_id" value="{{ $edit_memo[0]['id'] }}" />
                <textarea class="form-control" name="content" row5="3" placeholder="ここにメモを入力">{{ $edit_memo[0]['content'] }}</textarea>
            </div>

            @error('content') {{-- バリデーションエラー文 --}}
                <div class="alert alert-danger">メモ内容を入力してください！</div>
            @enderror

            @foreach ($tags as $t)
                <div class="form-check form-check-inline mb-3">
                    {{-- 三項演算子：　もし$include_tagsにループで回っているタグのidが含まれていたらcheckedを付与 --}}
                    <input type="checkbox" name="tags[]" id="{{ $t['id'] }}" value="{{ $t['id'] }}" class="form-check-input" {{in_array($t['id'], $include_tags) ? 'checked' : ''}} />
                    <label for="{{ $t['id'] }}">{{ $t['name'] }}</label>
                </div>
            @endforeach

            <input type="text" name="new_tag" class="form-control w-50 mb-3" placeholder="新しいタグを入力" />

            <div class="text-end">
                <button type="submit" class="btn btn-primary">更新</button>
            </div>
        </form>
    </div>
@endsection
