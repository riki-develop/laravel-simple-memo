@extends('layouts.auth')

@section('content')


<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">お問い合わせフォーム</div>

            <div class="card-body w-75 mx-auto">
                <form method="POST" action="{{ route('contact.submit') }}">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="name">ユーザー名</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="email">メールアドレス</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="message">問い合わせ内容</label>
                        <textarea class="form-control" id="message" name="message" rows="4" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary mb-3" onclick="return confirm('この内容で送信してよろしいですか？')">送信</button>

                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                </form>
            </div>

        </div>
    </div>
</div>
@endsection