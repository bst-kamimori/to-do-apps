<!DOCTYPE html>
<html>
<head>
    <title>詳細編集ページ</title>
</head>
<body>

<h2>編集</h2>

<form action="{{route('task.update',['id'=>$Tasks->id])}}" method="POST">
    @csrf
    @method('PUT')

    <table>

        <tr><th>担当:</th><th><input type="text" name="name" value="{{ old('name', $Tasks->name) }}"></th></tr>
{{--        <tr><th>案件名:</th><th><select name="projects">--}}
{{--                    @foreach($projects as $project)--}}
{{--                        <option value="{{ $project }}">{{ $Tasks->$project}}</option>--}}
{{--                    @endforeach--}}
{{--                </select></th></tr>--}}
        <tr><th>案件名:</th><th><input type="text" name="projects" value="{{ old('projects', $Tasks->projects) }}"></th></tr>
        <tr><th>カテゴリー:</th><th><input type="text" name="categories" value="{{ old('categories', $Tasks->categories) }}"></th></tr>
        <tr><th>業務名:</th><th><input type="text" name="works" value="{{ old('works', $Tasks->works) }}"></th></tr>
        <tr><th>開始日:</th><th><input type="text" name="start_date" value="{{ old('start_date', $Tasks->start_date) }}"></th></tr>
        <tr><th>期限:</th><th><input type="text" name="end_date" value="{{ old('end_date', $Tasks->end_date) }}"></th></tr>
        <tr><th>進捗（％）:</th><th><input type="text" name="progress" value="{{ old('progress', $Tasks->progress) }}"></th></tr>
        <tr><th>備考:</th><th><input type="text" name="remarks" value="{{ old('remarks', $Tasks->remarks) }}"></th></tr>

                <tr><td>{{$Tasks->created_at}}</td></tr>

    </table>

    <p><button type="submit">更新する</button>
        <a href="{{route('task.show',['id'=>$Tasks->id])}}">戻る</a>
    </p>

</form>


</body>
</html>
