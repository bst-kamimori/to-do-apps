
<!DOCTYPE html>
<html>
<head>
    <title>新規作成ページ</title>
</head>
<body>

<form action="{{ route('task.store') }}" method="POST">
    @csrf

    <table>
        <tr>
            <th>担当:</th>
            <td>
                <input type="text" name="name" value="{{ old('name') }}" size="45">
                @if($errors->has('name'))
                    <p>{{ $errors->first('name') }}</p>
                @endif
            </td>
        </tr>

        <tr>
            <th>案件名:</th>
            <td>
                <select name="project_select" id="project_select">
                    <option value="">-- 選択 --</option>
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
                    <option value="">-- 選択 --</option>
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
                    <option value="">-- 選択 --</option>
                    @foreach($operations as $operation)
                        <option value="{{ $operation->id }}" {{ request('operation_select') == $operation->id ? 'selected' : '' }}>
                            {{ $operation->name }}
                        </option>
                    @endforeach
                </select>
            </td>
        </tr>

        <tr>
            <th>開始日:</th>
            <td>
                <input type="datetime-local" name="start_date" value="{{ old('start_date') }}" size="10">
                @if($errors->has('start_date'))
                    <p>{{ $errors->first('start_date') }}</p>
                @endif
            </td>
        </tr>

        <tr>
            <th>期限:</th>
            <td>
                <input type="datetime-local" name="end_date" value="{{ old('end_date') }}" size="10">
                @if($errors->has('end_date'))
                    <p>{{ $errors->first('end_date') }}</p>
                @endif
            </td>
        </tr>

        <tr>
            <th>進捗:</th>
            <td>
                <input type="text" name="progress" value="{{ old('progress') }}" size="10">％
                @if($errors->has('progress'))
                    <p>{{ $errors->first('progress') }}</p>
                @endif
            </td>
        </tr>

        <tr>
            <th>Content:</th>
            <td>
                <input type="text" name="remarks" value="{{ old('remarks') }}" size="10">
                @if($errors->has('remarks'))
                    <p>{{ $errors->first('remarks') }}</p>
                @endif
            </td>
        </tr>

        <tr>
            <td colspan="2">
                <button>タスクを保存する</button>
            </td>
        </tr>
    </table>
</form>

<p><a href="/task">タスク一覧へ</a></p>

<p><a href="{{ route('task.masterlist') }}">マスタ登録へ</a></p>

{{--案件・カテゴリ・業務名を連動させた動的なセレクトボックス--}}
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

