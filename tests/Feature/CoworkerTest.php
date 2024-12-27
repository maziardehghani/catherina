<?php

namespace Tests\Feature;

use App\Enums\Statuses;
use App\Models\Coworker;
use App\Models\Status;
use App\Traits\AdminTestable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CoworkerTest extends TestCase
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

    public function test_admin_can_see_coworkers(): void
    {
        $response = $this->getData(route('admin.coworkers.index'));

        $response->assertStatus(200);
    }

    public function test_admin_can_see_coworker(): void
    {
        $response = $this->getData(route('admin.coworkers.show', Coworker::query()->first()->getKey()));
        $response->assertStatus(200);
    }

    public function test_admin_can_store_coworker(): void
    {
        $data = [
            'title' => fake()->company(),
            'link' => fake()->url(),
            'status_id' => Status::query()->whereTitle(fake()->randomElement(Statuses::commonStatuses()))->getKey(),
            'image' => $this->fakeImage(),
        ];

        $response = $this->postData(route('admin.coworkers.store'), $data);
        $response->assertStatus(200);

        $this->assertDatabaseHas(Coworker::class, $this->removeIndex($data,['image']));
        $this->assertFileExist(Coworker::query()->orderBy('id','desc')->first()->medias()->first()?->url);
    }

    public function test_admin_can_update_coworker(): void
    {
        $data = [
            'title' => fake()->company(),
            'link' => fake()->url(),
            'status_id' => Status::query()->whereTitle(fake()->randomElement(Statuses::commonStatuses()))->getKey(),
            'image' => $this->fakeImage(),
            '_method' => 'put'
        ];

        $response = $this->postData(route('admin.coworkers.update', Coworker::query()->first()->getKey()), $data);
        $response->assertStatus(200);
        $this->assertDatabaseHas(Coworker::class, $this->removeIndex($data,['image','_method']));
        $this->assertFileExist(Coworker::query()->first()->medias()->first()?->url);

    }

    public function test_admin_can_delete_coworker(): void
    {
        $response = $this->deleteData(route('admin.coworkers.destroy', Coworker::query()->first()->getKey()));
        $response->assertStatus(200);
    }
}
