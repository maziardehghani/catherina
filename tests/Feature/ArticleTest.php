<?php

namespace Tests\Feature;

use App\Enums\Statuses;
use App\Models\Article;
use App\Models\Status;
use App\Traits\AdminTestable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ArticleTest extends TestCase
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

    public function test_admin_can_see_articles(): void
    {
        $response = $this->getData(route('admin.articles.index'));

        $response->assertStatus(200);
    }

    public function test_admin_can_see_article()
    {
        $response = $this->getData(route('admin.articles.show', Article::first()->id));

        $response->assertStatus(200);
    }

    public function test_admin_can_create_article(): void
    {
        $data = [
            'title' => fake()->sentence(),
            'slug' => fake()->slug(),
            'content' => fake()->paragraph(),
            'intro' => fake()->sentence(),
            'status_id' => Status::query()->whereTitle(fake()->randomElement(Statuses::commonStatuses()))->getKey(),
            'image' => $this->fakeImage()
        ];

        $response = $this->postData(route('admin.articles.store'), $data);
        $response->assertStatus(200);

        $this->assertDatabaseHas(Article::class,$this->removeIndex($data,['image','user_id']));
    }

    public function test_admin_can_update_article(): void
    {
        $data = [
            'title' => fake()->sentence(),
            'slug' => fake()->slug(),
            'content' => fake()->paragraph(),
            'intro' => fake()->sentence(),
            'status_id' => Status::query()->whereTitle(fake()->randomElement(Statuses::commonStatuses()))->getKey(),
            'image' => $this->fakeImage(),
            '_method' => 'PUT',
        ];


        $response = $this->postData(route('admin.articles.update', Article::query()->first()->id), $data);
        $response->assertStatus(200);

        $this->assertDatabaseHas(Article::class, $this->removeIndex($data,['image','user_id','_method']));
    }

    public function test_admin_can_delete_article(): void
    {
        $response = $this->deleteData(route('admin.articles.destroy', Article::query()->first()->id));
        $response->assertStatus(200);
    }
}
