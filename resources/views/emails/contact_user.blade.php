<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
</head>
<body>
    <h1>お問い合わせがありました</h1>
    <p><strong>ユーザー名：</strong>{{ $data['name'] }}</p>
    <p><strong>メールアドレス：</strong>{{ $data['email'] }}</p>
    <p><strong>問い合わせ内容：</strong><br>{{ nl2br($data['message']) }}</p>
</body>
</html>