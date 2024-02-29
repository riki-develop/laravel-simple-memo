const deleteHandle = (e) => {
    e.preventDefault()

    if(window.confirm('本当に削除していいですか？')) {
        const form = event.target.closest('.delete-form')
        form.submit()
    }else{
        alert('キャンセルしました')
    }
}