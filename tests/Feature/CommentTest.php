<?php

namespace Tests\Feature;

use App\Enums\Statuses;
use App\Models\Comment;
use App\Models\Status;
use App\Models\User;
use App\Traits\AdminTestable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use RefreshDatabase, AdminTestable;

    /**
     * A basic feature test example.
     */
    public function setUp(): void
    {
        Parent::setUp();
        $this->seed();
    }

    public function test_admin_can_see_project_comments(): void
    {
        $response = $this->getData(route('admin.comments.projects'));

        $response->assertStatus(200);
    }

    public function test_admin_can_see_article_comments(): void
    {
        $response = $this->getData(route('admin.comments.articles'));

        $response->assertStatus(200);
    }

    public function test_admin_can_see_comment()
    {
        $response = $this->getData(route('admin.comments.show',Comment::query()->first()->id));

        $response->assertStatus(200);
    }

    public function test_admin_can_update_comments()
    {
        $data = [
            'content' => fake()->sentence(),
            'status_id' => Status::query()->whereTitle(fake()->randomElement(Statuses::commonStatuses()))->getKey(),
            '_method' => 'put'
        ];

        $response = $this->postData(route('admin.comments.update',Comment::query()->first()->id),$data);
        $response->assertStatus(200);

        $this->assertDatabaseHas(Comment::class,$this->removeIndex($data, ['_method']));
    }

    public function test_admin_can_answer_comment()
    {
        $data = [
            'content' => fake()->sentence(),
            'status_id' => Status::query()->whereTitle(fake()->randomElement(Statuses::commonStatuses()))->getKey(),
            '_method' => 'put'
        ];

        $response = $this->postData(route('admin.comments.answerComment',Comment::query()->first()->id),$data);
        $response->assertStatus(200);

        $this->assertDatabaseHas(Comment::class,$this->removeIndex($data, ['_method']));
    }

    public function test_admin_can_delete_comment()
    {
        $response = $this->deleteData(route('admin.comments.destroy',Comment::query()->first()->id));
        $response->assertStatus(200);
    }
}
