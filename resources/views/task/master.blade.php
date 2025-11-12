<?php
// resources/views/task/master.blade.php
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body>


<form action="/task/masterlist" method="GET">

    <label>案件</label>
    <select name="project_select" id="project-select">
        <option value="">-- 案件を選択 --</option>
        @foreach ($projects as $project)
            <option value="{{ $project->id }}" {{ request('project_select') == $project->id ? 'selected' : '' }}>
                {{ $project->name }}
            </option>
        @endforeach
        <option value="new" {{ request('project_select') === 'new' ? 'selected' : '' }}>＋新規追加</option>
    </select>

    <label>カテゴリ</label>
    <select name="category_select" id="category-select">
        <option value="">-- カテゴリを選択 --</option>
        @foreach ($categories as $category)
            <option value="{{ $category->id }}" {{ request('category_select') == $category->id ? 'selected' : '' }}>
                {{ $category->name }}
            </option>
        @endforeach
        <option value="new" {{ request('category_select') === 'new' ? 'selected' : '' }}>＋新規追加</option>
    </select>

    <label>業務名</label>
    <select name="operation_select" id="operation-select">
        <option value="">-- 業務名を選択 --</option>
        @foreach ($operations as $operation)
            <option value="{{ $operation->id }}" {{ request('operation_select') == $operation->id ? 'selected' : '' }}>
                {{ $operation->name }}
            </option>
        @endforeach
        <option value="new" {{ request('operation_select') === 'new' ? 'selected' : '' }}>＋新規追加</option>
    </select>

    <button type="submit">反映</button>
</form>

<script>
    const selectTargets = {
        'project-select': 'project_select',
        'category-select': 'category_select',
    };

    for (const [id, paramName] of Object.entries(selectTargets)) {
        const selectEl = document.getElementById(id);
        if (!selectEl) continue;

        selectEl.addEventListener('change', () => {
            const value = selectEl.value;
            const url = new URL(window.location.href);
            url.searchParams.set(paramName, value);
            window.location.href = url.pathname + '?' + url.searchParams.toString();
        });
    }

</script>




<form method="POST" action="{{ route('task.masterlist.store') }}">
    @csrf

    @if(request('project_select') === 'new')
        <label>新規案件名</label>
        <input type="text" name="project_names" value="{{ old('project_names') }}">
    @endif

    @if(request('category_select') === 'new')
        <label>新規カテゴリ名</label>
        <input type="text" name="categories" value="{{ old('categories') }}">
    @endif

    @if(request('operation_select') === 'new')
        <label>新規業務名</label>
        <input type="text" name="operations" value="{{ old('operations') }}">
    @endif

{{--    既存値を渡す--}}
    <input type="hidden" name="project_select" value="{{ request('project_select') }}">
    <input type="hidden" name="category_select" value="{{ request('category_select') }}">
    <input type="hidden" name="operation_select" value="{{ request('operation_select') }}">

    @if(request('project_select')==='new' || request('category_select')==='new' || request('operation_select')==='new')
        <button type="submit">登録する</button>
    @endif
</form>

<p><a href="{{route('task.index')}}">タスク一覧へ戻る</a></p>
<p><a href="{{route('task.create')}}">タスクの新規作成へ戻る</a></p>
</body>
</html>
