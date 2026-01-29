<?php

namespace Tests\Feature;

use Tests\TestCase;

class TaskControllerTest extends TestCase
{
    public function test_index()
    {
        $response = $this->get('/task');
        $response->assertStatus(200);
    }

    public function test_create()
    {
        $response = $this->get('/task/create');
        $response->assertStatus(200);
    }

    // バリデーション確認

    public function test_store()
    {
        $response = $this->post('store'); //url先の修正
        $response->assertStatus(302);
    }

    public function test_show()
    {
        $response = $this->get('show');
        $response->assertStatus(200);
    }

    public function test_edit()
    {
        $response = $this->get('edit');
        $response->assertStatus(200);
    }

    // バリデーションエラーの確認
    public function test_update()
    {
        $response = $this->put('update');
        $response->assertStatus(302);
    }

    // バリデーションエラーの確認
    public function test_delete()
    {
        $response = $this->delete('delete');
        $response->assertStatus(302);
    }

    public function test_complete()
    {
        $response = $this->get('complete');
        $response->assertStatus(200);
    }

    public function test_reopen()
    {
        $response = $this->get('reopen');
        $response->assertStatus(200);
    }

    public function test_completelist()
    {
        $response = $this->get('task/complete/list');
        $response->assertStatus(200);
    }

    public function test_masterlist()
    {
        $response = $this->get('task/masterlist');
        $response->assertStatus(200);
    }

    //バリデーションエラー
    public function test_masterliststore()
    {
        $response = $this->post('masterliststore');
        $response->assertStatus(302);
    }
}
