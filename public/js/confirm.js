function deleteHandle(event) {
    // 一旦formの動きを止める
    event.preventDefault()

    window.confirm('本当に削除していいですか？')
        ? document.getElementById('delete-form').submit()
        : alert('キャンセルしました');
}