<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Operation;
use App\Models\Project_Name;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;


class TaskController extends Controller
{

    /**  */
    public function index()
    {

        $projects = Project_Name::all();


        return view('task.index', compact('projects', ));
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
            'name' => 'required|string|max:300',
            'remarks' => 'required|string|max:60000',
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
        $Tasks->project_id = $request->input('project_id');
        $Tasks->category_id = $request->input('category_id');
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

    public function masterlist(Request $request)
    {
        $projects = Project_Name::all();
        $categories = Category::all();
        $operations = Operation::all();


        return view('task.master',compact('projects','categories','operations'));
    }

    public function masterliststore(Request $request)
    {
        $date = $request->validate([
            'project_select' => 'nullable',
            'category_select' => 'nullable',
            'operation_select' => 'nullable',
            'project_names' => 'required_if:project_select,new|string|max:100',
            'categories' => 'required_if:category_select,new|string|max:100',
            'operations' => 'required_if:operation_select,new|string|max:300',
        ]);

        DB::beginTransaction();
        try {
            if (isset($date['project_select']) && $date['project_select'] === 'new' && !empty($date['project_names'])){
                $projects = new Project_Name();
                $projects->name = $date['project_names'];
                $projects->save();
            }

            if(isset($date['category_select']) && $date['category_select'] === 'new' && !empty($date['categories'])){
                $categories = new Category();
                $categories->name = $date['categories'];
                $categories->save();
            }

            if(isset($date['operation_select']) && $date['operation_select'] === 'new' && !empty($date['operations'])){
                $operations = new Operation();
                $operations->name = $date['operations'];
                $operations->save();
            }


            DB::commit();
        } catch(\Throwable $e) {
            DB::rollBack();
            return back()->withErrors([
                'error' => '保存中にエラーが発生しました。:' . $e->getMessage(),
                ])->withInput();
        }

        return redirect()->route('task.masterlist')->with('success','マスタが保存されました。');
    }
}
