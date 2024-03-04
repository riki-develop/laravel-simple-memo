<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\ContactUserMail;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    // 問い合わせフォームの表示
    public function showForm()
    {
        return view('contact_form');  // 問い合わせフォームのビューファイル名
    }

    public function submit(Request $request)
    {
        $data = $request->only(['name', 'email', 'message']);

        Mail::to('admin@example.com')->send(new ContactUserMail($data)); // 管理者のメールアドレスに送信

        return back()->with('success', 'お問い合わせが送信されました。');
    }
}