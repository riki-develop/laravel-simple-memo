<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $users = User::all(); // 一般ユーザーの情報を全て取得
        return view('admin', ['users' => $users]); // ビューにデータを渡す
    }

    public function deleteUser($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->delete();
            return redirect()->back()->with('success', 'ユーザーを削除しました。');
        }
        return redirect()->back()->with('error', 'ユーザーが見つかりませんでした。');
    }
}
