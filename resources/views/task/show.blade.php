<!DOCTYPE html>
<html>
<head>
    <title>詳細ページ</title>
</head>
<body>


@if(session('success'))
    <p>{{session('success')}}</p>
@endif

<table>
    <tr><th align="left">担当:</th><th align="left">{{$Tasks->name}}</th></tr>
    <tr><th align="left">案件名:</th><th align="left">{{$Tasks->projects}}</th></tr>
    <tr><th align="left">カテゴリー:</th><th align="left">{{$Tasks->categories}}</th></tr>
    <tr><th align="left">業務名:</th><th align="left">{{$Tasks->works}}</th></tr>
    <tr><th align="left">開始日:</th><th align="left">{{$Tasks->start_date}}</th></tr>
    <tr><th align="left">期限:</th><th align="left">{{$Tasks->end_date}}</th></tr>
    <tr><th align="left">進捗:</th><th align="left">{{$Tasks->progress}}</th></tr>
    <tr><th align="left">備考:</th><th align="left">{{ $Tasks->remarks }}</th></tr>
</table>
<form action="{{route('task.complete',['id'=>$Tasks->id])}}" method="POST" onsubmit="return confirm('完了済みに移動させちゃう？');">
    @csrf
    <button type="submit">完了済み</button>
</form>
<form action="{{route('task.delete',['id'=>$Tasks->id])}}" method="POST" onsubmit="return confirm('削除しますか？');">
    @csrf
    @method('DELETE')
    <button type="submit">削除</button>
</form>

<p><a href="{{route('task.edit',['id'=>$Tasks->id])}}">編集する</a> </p>
<p><a href="/task">タスク一覧へ</a></p>

</body>
</html>
