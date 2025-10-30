<!-- resources/views/task/index.blade.php -->
<html>
<head>
    <title>完了済みタスク一覧</title>

</head>
<body>

<h3>完了済みタスク一覧</h3>

<p><a href="/task">タスク一覧へ</a></p>


{{--@php--}}
{{--    $nextSort=($sort === '1') ? '0' : '1';--}}
{{--@endphp--}}

{{--<a href ="{{route('news.index',['sort'=>$nextSort,'keyword'=>$keyword])}}">投稿日付でソート({{$sort === '0' ? '昇順' : '降順' }})--}}
{{--</a>--}}

<table >
    <tr>
        <th>No.</th>
        <th>担当</th>
        <th>案件名</th>
        <th>カテゴリー</th>
        <th>業務名</th>
        <th>開始日</th>
        <th>期限</th>
        <th>進捗（％）</th>
        <th>備考</th>
    </tr>
    @foreach($tasks as $task)
        <tr>
            <td>{{$loop->iteration}}.</td>
            <td><a href="{{route('task.show',['id'=>$task->id])}}">{{$task->name}}</a></td>
            <td>{{$task->name}}</td>
            <td>{{$task->project_name->name}}</td>
            <td>{{$task->category->name}}</td>
            <td>{{$task->operation->name}}</td>
            <td>{{$task->start_date}}</td>
            <td>{{$task->end_date}}</td>
            <td>{{$task->progress}}</td>
            <td>{{$task->remarks}}</td>
        </tr>

    @endforeach

</table>
　　　　
@if(session('completed'))
    <p>{{ session('completed') }}</p>
@endif


</body>
</html>
