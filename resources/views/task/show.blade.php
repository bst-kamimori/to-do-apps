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
    <tr><th align="left">担当:</th><th align="left">{{ $task->name }}</th></tr>
    <tr><th align="left">案件名:</th><th align="left">{{ optional($task->project_name)->name }}</th></tr>
    <tr><th align="left">カテゴリー:</th><th align="left">{{ optional($task->category)->name }}</th></tr>
    <tr><th align="left">業務名:</th><th align="left">{{ optional($task->operation)->name }}</th></tr>
    <tr><th align="left">開始日:</th><th align="left">{{ $task->start_date }}</th></tr>
    <tr><th align="left">期限:</th><th align="left">{{ $task->end_date }}</th></tr>
    <tr><th align="left">進捗:</th><th align="left">{{ $task->progress }}</th></tr>
    <tr><th align="left">備考:</th><th align="left">{{ $task->remarks }}</th></tr>
</table>


@if($task->is_completed!=1)
<form action="{{route('task.complete',['id'=>$task->id])}}" method="POST" onsubmit="return confirm('完了済みに移動させちゃう？');">
    @csrf
    <button type="submit">完了済み</button>
</form>
@endif
<form action="{{route('task.delete',['id'=>$task->id])}}" method="POST" onsubmit="return confirm('削除しますか？');">
    @csrf
    @method('DELETE')
    <button type="submit">削除</button>
</form>
@if($task->is_completed!=1)
    <p><a href="{{route('task.edit',['id'=>$task->id])}}">編集する</a> </p>
@endif
@if($task->is_completed=0)
    <p><a href="/task">タスク一覧へ</a></p>
@endif
@if($task->is_completed=1)
    <p><a href="complete/list">完了済みタスク一覧へ</a></p>
@endif



</body>
</html>
