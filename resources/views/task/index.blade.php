<!-- resources/views/task/index.blade.php -->
<html>
<head>
    <title>タスク一覧</title>
</head>
<body>

<p><a href="{{route('task.create')}}">タスクの登録</a></p>

<p><a href="{{route('task.masterlist')}}">業務マスタの登録</a></p>

<p><a href="{{route('task.complete.list')}}">完了済みタスク一覧</a></p>

<form action="{{route('task.index')}}" method="GET">
{{--    <input type="text" name="keyword" value="{{$keyword??''}}">--}}
{{--    <button type="submit">検索</button>--}}
</form>

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
        <th>更新日</th>
    </tr>
    @foreach($projects as $index =>$project)
        @foreach($project->cagetories as $category)
            @foreach($category->operations as $operation)
                @foreach($operation->tasks as $task)
                         dd($task);




                <tr>
                    <td>{{$index+1}}.</td>
        {{--            <td><a href="{{route('task.show',['id'=>$task->id])}}">{{$task->name}}</a></td>--}}
                    <td>神森さん</td>
                    <td>{{$project->name}}</td>
                    <td>{{$category->name}}</td>
                    <td>{{$operation->name}}</td>
                    <td>{{$task->start_date}}</td>
                    <td>{{$task->end_date}}</td>
                    <td>{{$task->progress}}</td>
                    <td>{{$task->remarks}}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                <td>{{$operation->created_at}}</td>
                </tr>

                @endforeach
          @endforeach
        @endforeach
    @endforeach

</table>　　　　

{{--@if($list->isEmpty() && isset($keyword))--}}
{{--    <p>「{{$keyword}}」はヒットしませんでした。</p>--}}
{{--@endif--}}

{{--<div>--}}
{{--    {{ $list->links() }}--}}
{{--</div>--}}

@if(session('success'))
    <p>{{session('success')}}</p>
@endif

@if(session('remove'))
    <p>{{session('remove')}}</p>
@endif

</body>
</html>
