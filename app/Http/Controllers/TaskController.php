<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Operation;
use App\Models\Project_Name;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TaskController extends Controller
{
    public function index()
    {

        $tasks = Task::where('is_completed',false)->get();

        return view('task.index', compact('tasks' ));
    }


    public function create()
    {
//        $csvpath = storage_path('0801_業務マスタ.csv');
//            $csvcolums = [];
//
//            if (file_exists($csvpath)) {
//                $file = fopen($csvpath, 'r');
//                if ($file !== false) {
//                    $header = fgetcsv($file); // ヘッダーを読み飛ばす
//
//                    while (($row = fgetcsv($file)) !== false) {
//                        [$project, $category, $work] = $row;
//
//                        // 案件ごとにまとめる
//                        if (!isset($csvcolums[$project])) {
//                            $csvcolums[$project] = [];
//                        }
//
//                        // カテゴリごとにまとめる
//                        if (!isset($csvcolums[$project][$category])) {
//                            $csvcolums[$project][$category] = [];
//                        }
//
//                        // 業務を追加
//                        $csvcolums[$project][$category][] = $work;
//                    }
//
//                    fclose($file);
//                }
//            }

            $projects_names = Project_Name::all();
            $categories = Category::all();
            $operations = Operation::all();

            $tasks = Task::all();

            return view('task.create', compact('tasks', 'projects_names','categories','operations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:300',
            'remarks' => 'required|max:60000',
        ]);

        $Tasks = new Task();
        $Tasks->name = $request->input('name');
//        $Tasks->projects = $request->input('projects');
//        $Tasks->categories = $request->input('categories');
//        $Tasks->works = $request->input('works');
        $Tasks->project_id = $request->input('project_id');
        $Tasks->category_id = $request->input('category_id');
        $Tasks->operation_id = $request->input('operation_id');
        $Tasks->start_date = $request->input('start_date');
        $Tasks->end_date = $request->input('end_date');
        $Tasks->progress = $request->input('progress');
        $Tasks->remarks = $request->input('remarks');
        $Tasks->save();

        return redirect()->route('task.index')->with('success','タスクが保存されました');
    }

    public function show($id)
    {
        $Tasks = Task::findOrFail($id);
        return view('task.show',compact('Tasks'));
    }

    public function edit($id)
    {
        $Tasks=Task::findOrFail($id);

// ここでセレクトボックスのカラムをひきわたしてあげないといけない。’projects’'cotegories''works'
        return view('task.edit',compact('Tasks'));
    }

    public function update(Request $request,$id)
    {
        $request->validate([
            'name'=>'required | min:1 | max:500',
            'progress' => 'required | min:0 | max:100',
            'remarks' => 'required | min:0 | max:6000'
        ]);

        $Tasks=Task::findOrFail($id);
        $Tasks->name = $request->input('name');
        $Tasks->projects = $request->input('projects');
        $Tasks->categories = $request->input('categories');
        $Tasks->works = $request->input('works');
        $Tasks->start_date = $request->input('start_date');
        $Tasks->end_date = $request->input('end_date');
        $Tasks->progress = $request->input('progress');
        $Tasks->remarks = $request->input('remarks');
        $Tasks->save();

        return redirect()->route('task.show',['id'=>$Tasks->id])
            ->with('success',"更新しました！");
    }

    public function delete($id)
    {
        try{
            $Tasks=Task::findOrFail($id);
            $Tasks->delete();
            return redirect()->route('task.index')->with('remove','削除しました!');
        } catch (ModelNotFoundException $e) {
            abort(404);
        }
    }

    public function complete($id)
    {
        $tasks = Task::findOrFail($id);
        $tasks->is_completed = true;
        $tasks->save();

        return redirect()->route('task.complete.list')->with('completed','タスクを完了済みにしました');
    }

    public function completelist()
    {
        $tasks = Task::where('is_completed',true)->get();

        return view('task.complete',compact('tasks'));
    }

}
