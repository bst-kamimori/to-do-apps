<html>
<head>
    <title>タスク一覧</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<p><a href="{{route('task.create')}}">タスクの登録</a></p>

<p><a href="{{route('task.masterlist')}}">業務マスタの登録</a></p>

<p><a href="{{route('task.complete.list')}}">完了済みタスク一覧</a></p>


{{--@php--}}
{{--    $nextSort=($sort === '1') ? '0' : '1';--}}
{{--@endphp--}}

{{--<a href ="{{route('news.index',['sort'=>$nextSort,'keyword'=>$keyword])}}">投稿日付でソート({{$sort === '0' ? '昇順' : '降順' }})--}}
{{--</a>--}}

<br>

<form method="GET" action="{{ route('task.index') }}">
    <button type="submit">フィルタ適用</button>
    <a href="{{ route('task.index') }}">クリア</a>

<table>
    <tr>
        <th>No.</th>
        <th>担当</th>
        <th>案件名</th>
        <th>カテゴリ</th>
        <th>業務名</th>
        <th>開始日</th>
        <th>期限</th>
        <th>進捗（％）</th>
        <th>備考</th>
        <th>更新日</th>
    </tr>
{{--検索ボックスのフィルター--}}
    <tr>
        <td></td>
        <td><input type="text" name="name" value="{{ request('name') }}"></td>
        <td>
            <select name="project_select">
                <option value="">--</option>
                @foreach ($project_names as $project_name)
                    <option value="{{ $project_name->id }}" {{ request('project_select') == $project_name->id ? 'selected' : '' }}>
                        {{ $project_name->name }}
                    </option>
                @endforeach
            </select>
        </td>
        <td>
            <select name="category_select">
                <option value="">--</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category_select') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </td>
        <td>
            <select name="operation_select">
                <option value="">--</option>
                @foreach($operations as $operation)
                    <option value="{{ $operation->id }}" {{ request('operation_select') == $operation->id ? 'selected' : '' }}>
                        {{ $operation->name }}
                    </option>
                @endforeach
            </select>
        </td>
        <td><input type="date" name="start_date" value="{{ request('start_date') }}"></td>
        <td><input type="date" name="end_date" value="{{ request('end_date') }}"></td>

        <td></td>
        <td></td>
    </tr>

    @foreach($tasks as $task)

        <tr>
            <td>{{$loop->iteration}}.</td>
            <td><a href="{{route('task.show',['id'=>$task->id])}}">{{$task->name}}</a></td>
            <td>{{ optional($task->project_name)->name }}</td>
            <td>{{ optional($task->category)->name }}</td>
            <td>{{ optional($task->operation)->name }}</td>
            <td>{{$task->start_date}}</td>
            <td>{{$task->end_date}}</td>
            <td>{{$task->progress}}</td>
            <td>{{$task->remarks}}</td>
            <td>{{$task->created_at}}</td>
        </tr>

    @endforeach

</table>　　　　
</form>


@if(session('success'))
    <p>{{session('success')}}</p>
@endif

@if(session('remove'))
    <p>{{session('remove')}}</p>
@endif

<div>
    {{ $tasks->appends(request()->query())->links('pagination::bootstrap-4') }}
</div>

</body>
</html>
