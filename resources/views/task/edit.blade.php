<!DOCTYPE html>
<html>
<head>
    <title>詳細編集ページ</title>
</head>
<body>

<h2>編集</h2>

<form action="{{route('task.update',['id'=>$task->id])}}" method="POST">
    @csrf
    @method('PUT')

    <table>

        <tr><th>担当:</th><th><input type="text" name="name" value="{{ old('name', $task->name) }}"></th></tr>
        <tr>
            <th>案件名:</th>
            <td>
                <select name="project_select" id="project_select">
                    @foreach ($project_names as $project)
                        <option value="{{ $project->id }}" {{ request('project_select') == $project->id ? 'selected' : '' }}>
                            {{ $project->name }}
                        </option>
                    @endforeach
                </select>
            </td>
        </tr>

        <tr>
            <th>カテゴリ:</th>
            <td>
                <select name="category_select" id="category_select">
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category_select') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </td>
        </tr>

        <tr>
            <th>業務名:</th>
            <td>
                <select name="operation_select" id="operation_select">
                    @foreach($operations as $operation)
                        <option value="{{ $operation->id }}" {{ request('operation_select') == $operation->id ? 'selected' : '' }}>
                            {{ $operation->name }}
                        </option>
                    @endforeach
                </select>
            </td>
        </tr>
        <tr><th>開始日:</th><th><input type="text" name="start_date" value="{{ old('start_date', $task->start_date) }}"></th></tr>
        <tr><th>期限:</th><th><input type="text" name="end_date" value="{{ old('end_date', $task->end_date) }}"></th></tr>
        <tr><th>進捗（％）:</th><th><input type="text" name="progress" value="{{ old('progress', $task->progress) }}"></th></tr>
        <tr><th>備考:</th><th><input type="text" name="remarks" value="{{ old('remarks', $task->remarks) }}"></th></tr>
        <tr><th>更新日:</th><th><input type="text" name="created_at" value="{{ old('created_at', $task->created_at) }}"></th></tr>



    </table>

    <p><button type="submit">更新する</button>
        <a href="{{route('task.show',['id'=>$task->id])}}">戻る</a>
    </p>

</form>
{{--案件名・カテゴリー・業務名を連動させた動的セレクトボックス--}}
<script>
    const selectTargets = {
        'project_select': 'project_select',
        'category_select': 'category_select'
    };

    for (const [id, paramName] of Object.entries(selectTargets)) {
        const selectEl = document.getElementById(id);
        if (!selectEl) continue;

        selectEl.addEventListener('change', () => {
            const value = selectEl.value || '';
            const url = new URL(window.location.href);
            if (value) url.searchParams.set(paramName, value);
            else url.searchParams.delete(paramName);

            // project を変えたらカテゴリー・業務名をクリア
            if (id === 'project_select') {
                url.searchParams.delete('category_select');
                url.searchParams.delete('operation_select');
            }
            if (id === 'category_select') {
                url.searchParams.delete('operation_select');
            }

            window.location.href = url.pathname + (url.search ? '?' + url.searchParams.toString() : '');
        });
    }
</script>

</body>
</html>
