
<!DOCTYPE html>
<html>
<head>
    <title>新規作成ページ</title>
</head>
<body>
<h2>新規タスク作成フォーム</h2>

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
       <select name="project_id">
           @foreach($projects_names as $project)
               <option value="{{$project->id}}">{{$project->name}}</option>
           @endforeach
       </select>
        </tr>

        <tr>
            <th>カテゴリ:</th>
        <select name="category_id">
            @foreach($categories as $category)
                <option value="{{$category->id}}">{{$category->name}}</option>
            @endforeach
        </select>
        </tr>

        <tr>
            <th>業務名:</th>
        <select name="operation_id">
            @foreach($operations as $operation)
                <option value="{{$operation->id}}">{{$operation->name}}</option>
            @endforeach
        </select>
        </tr>

        {{--        <script>--}}
{{--            const csvData = @json($csvcolums);--}}

{{--            const projectSelect = document.getElementById('project');--}}
{{--            const categorySelect = document.getElementById('category');--}}
{{--            const workSelect = document.getElementById('work');--}}

{{--            projectSelect.addEventListener('change', function () {--}}
{{--                const project = this.value;--}}
{{--                categorySelect.innerHTML = '<option value="">-- カテゴリを選択 --</option>';--}}
{{--                workSelect.innerHTML = '<option value="">-- 業務を選択 --</option>';--}}

{{--                if (project && csvData[project]) {--}}
{{--                    Object.keys(csvData[project]).forEach(category => {--}}
{{--                        const opt = document.createElement('option');--}}
{{--                        opt.value = category;--}}
{{--                        opt.textContent = category;--}}
{{--                        categorySelect.appendChild(opt);--}}
{{--                    });--}}
{{--                }--}}
{{--            });--}}

{{--            categorySelect.addEventListener('change', function () {--}}
{{--                const project = projectSelect.value;--}}
{{--                const category = this.value;--}}
{{--                workSelect.innerHTML = '<option value="">-- 業務を選択 --</option>';--}}

{{--                if (project && category && csvData[project][category]) {--}}
{{--                    csvData[project][category].forEach(work => {--}}
{{--                        const opt = document.createElement('option');--}}
{{--                        opt.value = work;--}}
{{--                        opt.textContent = work;--}}
{{--                        workSelect.appendChild(opt);--}}
{{--                    });--}}
{{--                }--}}
{{--            });--}}
{{--        </script>--}}

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
                <button type="submit">タスクを保存する</button>
            </td>
        </tr>
    </table>
</form>


<p><a href="/task">タスク一覧へ</a></p>

</body>
</html>
