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
    public function index(Request $request)
    {

        $tasks = Task::with(['project_name','category','operation'])->get();

        return view('task.index', compact('tasks'));
    }


    public function create(Request $request)
    {
        $project_names = Project_Name::all();

        $selectedProjectId = $request->input('project_select');
        $selectedCategoryId = $request->input('category_select');

        $categories = collect();
        $operations = collect();

        if (!is_null($selectedProjectId) && $selectedProjectId !== '') {
            $categories = Category::where('project_name_id', $selectedProjectId)->get();
        } else {

             $categories = Category::all();
        }

        if (!is_null($selectedCategoryId) && $selectedCategoryId !== '') {
            $operations = Operation::where('category_id', $selectedCategoryId)->get();
        } else {

             $operations = Operation::all();
        }

            $task = Task::all();

            return view('task.create', compact('task', 'project_names','categories','operations'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:300',
            'progress' => 'required|string|min:0|max:100',
            'remarks' => 'required|string|max:60000',
        ]);

        $task = new Task();
        $task->name = $request->input('name');
        $task->project_name_id = $request->input('project_select');
        $task->category_id = $request->input('category_select');
        $task->operation_id = $request->input('operation_select');
        $task->start_date = $request->input('start_date');
        $task->end_date = $request->input('end_date');
        $task->progress = $request->input('progress');
        $task->remarks = $request->input('remarks');
        $task->save();


        return redirect()->route('task.index')->with('success','タスクが保存されました');
    }

    public function show(Request $request,$id)
    {
        $task= Task::with(['project_name','category','operation'])->findOrFail($id);
        return view('task.show',compact('task'));
    }

    public function edit(Request $request,$id)
    {
        $project_names = Project_Name::all();

        $selectedProjectId = $request->input('project_select');
        $selectedCategoryId = $request->input('category_select');

        $categories = collect();
        $operations = collect();

        if (!is_null($selectedProjectId) && $selectedProjectId !== '') {
            $categories = Category::where('project_name_id', $selectedProjectId)->get();
        } else {

            $categories = Category::all();
        }

        if (!is_null($selectedCategoryId) && $selectedCategoryId !== '') {
            $operations = Operation::where('category_id', $selectedCategoryId)->get();
        } else {

            $operations = Operation::all();
        }

        $task = Task::with(['project_name','category','operation'])->findOrFail($id);

        return view('task.edit', compact('task','project_names','categories','operations'));


    }

    public function update(Request $request,$id)
    {
        $task = Task::findOrFail($id);

        $request->validate([
            'name'=>'required|string|min:1|max:500',
            'progress' => 'required|string|min:0|max:100',
            'remarks' => 'required|string|min:0|max:6000'
        ]);

        $task->name = $request->input('name');
        $task->project_name_id = $request->input('project_select');
        $task->category_id = $request->input('category_select');
        $task->operation_id = $request->input('operation_select');
        $task->start_date = $request->input('start_date');
        $task->end_date = $request->input('end_date');
        $task->progress = $request->input('progress');
        $task->remarks = $request->input('remarks');
        $task->save();

        return redirect()->route('task.show',['id'=>$task->id])
            ->with('success',"更新しました！");
    }

    public function delete($id)
    {
        try {
            $tasks = Task::findOrFail($id);
            $tasks->delete();
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

        $selectedProjectId = $request->input('project_select');
        $categories = collect();
        $operations = collect();

        if (!is_null($selectedProjectId)) {
            $categories = Category::where('project_name_id', $selectedProjectId)->get();
        }

        if (!is_null($request->input('category_select'))) {
            $selectedCategoryId = $request->input('category_select');
            $operations = Operation::where('category_id', $selectedCategoryId)->get();
        }

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
                if (isset($date['project_select'])) {
                    $categories->project_name_id = ($date['project_select'] === 'new' && isset($projects)) ? $projects->id : $date['project_select'];
                }
                $categories->save();
            }

            if(isset($date['operation_select']) && $date['operation_select'] === 'new' && !empty($date['operations'])){
                $operations = new Operation();
                $operations->name = $date['operations'];
                if (isset($date['category_select'])) {
                    $operations->category_id = ($date['category_select'] === 'new' && isset($categories)) ? $categories->id : $date['category_select'];
                }
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
