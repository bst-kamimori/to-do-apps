<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Task;
use App\Models\ProjectName;
use App\Models\Category;
use App\Models\Operation;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * 共通で使うマスタデータの作成
     */
   private  function createMasterData()
   {
       $projectName = ProjectName::factory()->create();
       $category = Category::factory()->create(['project_name_id' => $projectName->id]);
       $operation = Operation::factory()->create(['category_id' => $category->id]);

       return compact('projectName','category','operation');
   }

   /** @test 未完了タスクが表示される*/
    public function index()
    {
        Task::factory()->create(['is_completed' => false]);

        $response = $this->get(route('task.index'));
        $response->assertStatus(200);
    }

    /** @test 新規作成画面が表示される*/
    public function create()
    {
        $response = $this->get(route('task.create'));
        $response->assertStatus(200);
    }

    /** @test タスクを保存できる*/
    public function store()
    {
        [$project, $category, $operation] = $this->createMasterData();

        $response = $this->post(route('task.store'), [
            'name' => 'テスト',
            'progress' => '50',
            'remarks' => '備考',
            'project_select' => $project->id,
            'category_select' => $category->id,
            'operation_select' => $operation->id,
            'start_date' => now()->toDateString(),
            'end_date' => now()->addDay()->toDateString(),
            ]);

        $response->assertStatus(route('task.index'));
        $this->assertDatabaseHas('tasks', ['name' => 'テスト']);
    }

    /** @test バリデーションエラーになる*/
    public function store_error()
    {
        $response = $this->post(route('task.store'), []);
        $response->assertSessionHasErrors(['name']);
    }

    /** @test 詳細画面が表示される*/
    public function show()
    {
        $task = Task::factory()->create();

        $response = $this->get(route('task.show', $task->id));

        $response->assertStatus(200);
        $response->assertSee($task->name);
    }

    /** @test 編集画面が表示される*/
    public function test_edit()
    {
        $task = Task::factory()->create();

        $response = $this->get(route('task.edit', $task->id));
        $response->assertStatus(200);
    }

    /** @test タスクを更新できる*/
    public function test_update()
    {
        [$project, $category, $operation] = $this->createMasterData();
        $task = Task::factory()->create();

        $response = $this->put(route('task.update', $task->id), [
            'name' => '更新後',
            'progress' => '80',
            'remarks' => '更新',
            'project_select' => $project->id,
            'category_select' => $category->id,
            'operation_select' => $operation->id,
            ]);

        $response->assertRedirect(route('task.show', $task->id));
        $this->assertDatabaseHas('tasks', ['name' => '更新後']);
    }

    /** @test タスクを削除できる*/
    public function delete()
    {
        $task = Task::factory()->create();

        $response = $this->delete(route('task.delete', $task->id));

        $response->assertRedirect(route('task.index'));
        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }

    /** @test 定期タスクに設定できる*/
    public function recurring()
    {
        $task = Task::factory()->create();

        $response = $this->post(route('task.recurring', $task->id));

        $response->assertRedirect(route('task.show', $task->id));
        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'is_recurring' => true,
        ]);
    }

    /** @test タスクを完了にできる*/
    public function complete()
    {
        $task = Task::factory()->create(['is_completed' => false]);

        $response = $this->post(route('task.complete', $task->id));

        $response->assertRedirect(route('task.complete.list'));
        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'is_completed' => true,
        ]);
    }

    /** @test 完了タスクを未完了に戻せる*/
    public function reopen()
    {
        $task = Task::factory()->create(['is_completed' => true]);

        $response = $this->post(route('task.reopen', $task->id));

        $response->assertRedirect(route('task.index'));
        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'is_completed' => false,
        ]);
    }

    /** @test 完了タスク一覧が表示される*/
    public function completelist()
    {
        Task::factory()->create(['is_completed' => true]);

        $response = $this->get(route('task.complete.list'));

        $response->assertStatus(200);
    }

    /** @test マスタ画面が表示される*/
    public function masterlist()
    {
        $response = $this->get(route('task.masterlist'));

        $response->assertStatus(200);
    }

    /** @test マスタを保存できる*/
    public function masterliststore()
    {
        $response = $this->post(route('task.masterliststore'), [
            'project_select' => 'new',
            'project_names' => '新案件',
        ]);

        $response->assertRedirect(route('task.masterlist'));
        $this->assertDatabaseHas('project_names', ['name' => '新案件']);
    }
}
