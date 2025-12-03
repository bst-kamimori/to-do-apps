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
    <tr>
        <th style="text-align: left;">担当:</th>
        <td style="text-align: left;">{{ $task->name }}</td>
    </tr>
    <tr>
        <th style="text-align: left;">案件名:</th>
        <td style="text-align: left;">{{ optional($task->project_name)->name }}</td>
    </tr>
    <tr>
        <th style="text-align: left;">カテゴリ:</th>
        <td style="text-align: left;">{{ optional($task->category)->name }}</td>
    </tr>
    <tr>
        <th style="text-align: left;">業務名:</th>
        <td style="text-align: left;">{{ optional($task->operation)->name }}</td>
    </tr>
    <tr>
        <th style="text-align: left;">開始日:</th>
        <td style="text-align: left;">{{ $task->start_date }}</td>
    </tr>
    <tr>
        <th style="text-align: left;">期限:</th>
        <td style="text-align: left;">{{ $task->end_date }}</td>
    </tr>
    <tr>
        <th style="text-align: left;">進捗:</th>
        <td style="text-align: left;">{{ $task->progress }}</td>
    </tr>
    <tr>
        <th style="text-align: left;">備考:</th>
        <td style="text-align: left;">{{ $task->remarks }}</td>
    </tr>
</table>


@if($task->is_completed!=1)
<form action="{{route('task.complete',['id'=>$task->id])}}" method="POST" onsubmit="return confirm('完了済みに移動させますか？');">
    @csrf
    <button type="submit">完了済み</button>
</form>
@else
<form action="{{route('task.reopen',['id'=>$task->id])}}" method="POST" onsubmit="return confirm('タスクを未完了に戻しますか？');">
    @csrf
    <button type="submit">未完了に戻す</button>
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
@if($task->is_completed!=1)
    <p><a href="/task">タスク一覧へ</a></p>
@else
    <p><a href="complete/list">完了済みタスク一覧へ</a></p>
@endif



</body>
</html>
