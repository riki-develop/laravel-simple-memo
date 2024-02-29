@extends('layouts.auth', ['authgroup'=>'admin'])

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div>ゴミ箱</div>
                    <table>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Actions</th>
                        </tr>
                        @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <form action="{{ route('admin.restoreUser', $user->id) }}" method="POST">
                                    @csrf
                                    @method('POST')
                                    <button type="submit" class="btn btn-primary">元に戻す</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                    {{-- <form action="{{ route('admin.emptyTrash') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-danger">ゴミ箱を空にする</button>
                    </form> --}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection