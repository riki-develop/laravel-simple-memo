@extends('layouts.auth', ['authgroup'=>'admin'])

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">管理者：{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    
                    <div>登録ユーザー一覧</div>
                    <ul class="user-list">
                        @foreach ($users as $user)
                            <li>
                                <span>ID：{{ $user->id }}</span><br>
                                <span>ユーザー名：{{ $user->name }}</span><br>
                                <span>メールアドレス：{{ $user->email }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
