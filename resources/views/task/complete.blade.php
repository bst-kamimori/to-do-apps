
<html>
<head>
    <title>完了済みタスク一覧</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<h3>完了済みタスク一覧</h3>

<p><a href="/task">タスク一覧へ</a></p>


{{--@php--}}
{{--    $nextSort=($sort === '1') ? '0' : '1';--}}
{{--@endphp--}}

{{--<a href ="{{route('news.index',['sort'=>$nextSort,'keyword'=>$keyword])}}">投稿日付でソート({{$sort === '0' ? '昇順' : '降順' }})--}}
{{--</a>--}}
<br>

<form method="GET" action="{{ url('/task/complete/list') }}">
    <button type="submit">フィルタ適用</button>
    <a href="{{ url('/task/complete/list') }}">クリア</a>

<table>

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
{{--    案件・カテゴリ・業務名を連動させた動的セレクトボックス--}}
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
        </tr>

    @endforeach


</table>
</form>>

        　　　
@if(session('completed'))
    <p>{{ session('completed') }}</p>
@endif

<div>
    {{ $tasks->appends(request()->query())->links('pagination::bootstrap-4') }}
</div>

</body>
</html>
