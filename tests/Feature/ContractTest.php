<?php

namespace Tests\Feature;

use App\Enums\ContractTypes;
use App\Enums\Statuses;
use App\Models\Contract;
use App\Models\Coworker;
use App\Models\Project;
use App\Models\Status;
use App\Models\User;
use App\Traits\AdminTestable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ContractTest extends TestCase
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

    public function test_admin_can_see_contracts(): void
    {
        $response = $this->getData(route('admin.contracts.index'));

        $response->assertStatus(200);
    }

    public function test_admin_can_see_contract():void
    {
        $response = $this->getData(route('admin.contracts.show',Contract::query()->first()->id));

        $response->assertStatus(200);
    }

    public function test_admin_can_store_contract(): void
    {
        $data = [
            'user_id' => User::query()->first()->id ,
            'project_id' => Project::query()->first()->id ,
            'title' => fake()->title(),
            'description' => fake()->sentence(),
            'type' => fake()->randomElement(ContractTypes::contracts()),
            'document_type' => fake()->randomElement(['contract', 'progress_report']),
            'status_id' => Status::query()->whereTitle(fake()->randomElement(Statuses::commonStatuses()))->getKey() ,
            'file' => $this->fakeImage(),
        ];

        $response = $this->postData(route('admin.contracts.store'), $data);
        $response->assertStatus(200);

        $this->assertDatabaseHas(Contract::class, $this->removeIndex($data, ['file']));
        $this->assertFileExist(Contract::query()->orderBy('id','desc')->first()->medias()->first()?->url);

    }

    public function test_admin_can_update_contract()
    {
        $data = [
            'user_id' => User::query()->first()->id ,
            'project_id' => Project::query()->first()->id ,
            'title' => fake()->title(),
            'description' => fake()->sentence(),
            'type' => fake()->randomElement(ContractTypes::contracts()),
            'document_type' => fake()->randomElement(['contract', 'progress_report']),
            'status_id' => Status::query()->whereTitle(fake()->randomElement(Statuses::commonStatuses()))->getKey() ,
            'file' => $this->fakeImage(),
            '_method' => 'put'
        ];


        $response = $this->postData(route('admin.contracts.update', Contract::query()->first()->id), $data);
        $response->assertStatus(200);

        $this->assertDatabaseHas(Contract::class, $this->removeIndex($data, ['file','_method']));
        $this->assertFileExist(Contract::query()->first()->medias()->first()?->url);

    }

    public function test_admin_can_delete_contract()
    {
        $response = $this->deleteData(route('admin.contracts.destroy', Contract::query()->first()->id));

        $response->assertStatus(200);
    }
}
