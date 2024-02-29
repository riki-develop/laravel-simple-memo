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

    public function trash()
    {
        $users = User::onlyTrashed()->get(); // 論理削除されたユーザーの一覧を取得
        return view('admin.trash', ['users' => $users]); // ビューにデータを渡す
    }

    public function restoreUser($id)
    {
        $user = User::withTrashed()->find($id);
        if ($user) {
            $user->restore();
            return redirect()->back()->with('success', 'ユーザーを元に戻しました。');
        }
        return redirect()->back()->with('error', 'ユーザーが見つかりませんでした。');
    }

    // public function emptyTrash()
    // {
    //     User::onlyTrashed()->forceDelete(); // 論理削除されたユーザーを物理削除
    //     return redirect()->back()->with('success', 'ゴミ箱を空にしました。');
    // }
}
