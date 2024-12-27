<?php

namespace Tests\Feature;

use App\Enums\Statuses;
use App\Models\City;
use App\Models\FarabourseProject;
use App\Models\Media;
use App\Models\Project;
use App\Models\Status;
use App\Models\User;
use App\Models\Warranty;
use App\Traits\AdminTestable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectTest extends TestCase
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

    public function test_admin_can_see_projects(): void
    {
        $response = $this->getData(route('admin.projects.index'));

        $response->assertStatus(200);
    }

    public function test_admin_can_see_project()
    {
        $response = $this->getData(route('admin.projects.show', Project::query()->first()->id));
        $response->assertStatus(200);
    }

    public function test_admin_can_store_step_one_project(): void
    {
        $data = [
            'user_id' => User::query()->first()->id ,
            'title' => fake()->title(),
            'slug' => fake()->slug(),
            'percent' => fake()->numberBetween(0, 100),
            'funding_period' => fake()->numberBetween(9, 12),
            'city_id' => City::query()->first()->id,
            'project_intro' => fake()->paragraph(),
            'expert_opinion' => fake()->paragraph(),
            'plan_summery' => fake()->paragraph(),
            'project_risks' => fake()->paragraph(),
            'warranty_inquiry_id' => Warranty::query()->first()->id,
            'warranty_details' => fake()->paragraph(),
            'participation_generated' => fake()->boolean(),
            'status_id' => Status::query()->whereTitle(fake()->randomElement(Statuses::ProjectStatuses()))->getKey(),
            'stopped_at' => null,
        ];

        $response = $this->postData(route('admin.projects.store_step_one'), $data);
        $response->assertStatus(200);

        $this->assertDatabaseHas(Project::class, $data);
    }

    public function test_admin_can_store_step_two_project(): void
    {
        $data = [
            'guarantee_file' => $this->fakeImage(),
            'assessment_file' => $this->fakeImage(),
            'banner' => $this->fakeImage(),
            'logo' => $this->fakeImage(),
            '_method' => 'put'
        ];

        $response = $this->postData(route('admin.projects.store_step_two',Project::query()->first()->id), $data);
        $response->assertStatus(200);
        $this->assertDatabaseCount(Media::class,4);
    }

    public function test_admin_can_update_project(): void
    {
        $data = [
            'user_id' => User::query()->first()->id ,
            'title' => fake()->title(),
            'slug' => fake()->slug(),
            'percent' => fake()->numberBetween(0, 100),
            'funding_period' => fake()->numberBetween(9, 12),
            'city_id' => City::query()->first()->id,
            'project_intro' => fake()->sentence(),
            'expert_opinion' => fake()->sentence(),
            'plan_summery' => fake()->sentence(),
            'project_risks' => fake()->sentence(),
            'warranty_inquiry_id' => Warranty::query()->first()->id,
            'warranty_details' => fake()->sentence(),
            'participation_generated' => fake()->boolean(),
            'status_id' => Status::query()->whereTitle(fake()->randomElement(Statuses::ProjectStatuses()))->getKey(),
            'stopped_at' => null,
            '_method' => 'put'
        ];

        $response = $this->postData(route('admin.projects.update',Project::query()->first()->id), $data);
        $response->assertStatus(200);

        $this->assertDatabaseHas(Project::class, $this->removeIndex($data,['_method']));
    }

    public function test_admin_can_delete_project(): void
    {
        $response = $this->deleteData(route('admin.projects.destroy',Project::query()->first()->id));
        $response->assertStatus(200);
    }

    public function test_admin_can_see_experts()
    {
        $response = $this->getData(route('admin.projects.experts.index',Project::query()->first()->id));
        $response->assertStatus(200);
    }

    public function test_admin_can_store_expert(): void
    {
        $response = $this->postData(route('admin.projects.addExpert',Project::query()->first()->id), [
            'user_id' => User::query()->first()->id ,
            '_method' => 'put'
        ]);

        $response->assertStatus(200);
    }

    public function test_admin_can_delete_expert(): void
    {
        $response = $this->deleteData(route('admin.projects.destroy',Project::query()->first()->id));
        $response->assertStatus(200);
    }

    public function test_admin_can_see_project_files()
    {
        $data = [
            'guarantee_file' => $this->fakeImage(),
            'assessment_file' => $this->fakeImage(),
            'banner' => $this->fakeImage(),
            'logo' => $this->fakeImage(),
            '_method' => 'put'
        ];

        $this->postData(route('admin.projects.store_step_two',Project::query()->first()->id), $data);

        $response = $this->getData(route('admin.projects.files',Project::query()->first()->id));
        $response->assertStatus(200);
    }

    public function test_admin_can_delete_project_file(): void
    {
        $data = [
            'guarantee_file' => $this->fakeImage(),
            '_method' => 'put'
        ];

        $this->postData(route('admin.projects.store_step_two',Project::query()->first()->id), $data);

        $response = $this->deleteData(route('admin.projects.deleteFile',Project::query()->first()->medias->first()->id));
        $response->assertStatus(200);

        $this->assertDatabaseEmpty(Media::class);
    }

    public function test_admin_can_get_farabourse_project()
    {
        $data = [
            'trace_code' => '4b18b79b-67a0-408a-a70c-b43f849991e2',
            '_method' => 'put'
        ];

        $response = $this->postData(route('admin.projects.getFarabourseProject',Project::query()->first()->id), $data);
        $response->assertStatus(200);

        $this->assertDatabaseCount(FarabourseProject::class,1);
        $this->assertDatabaseHas(FarabourseProject::class, $this->removeIndex($data,['_method']));
    }

    public function test_admin_can_see_farabourse_project()
    {
        $data = [
            'trace_code' => '4b18b79b-67a0-408a-a70c-b43f849991e2',
            '_method' => 'put'
        ];

        $this->postData(route('admin.projects.getFarabourseProject',Project::query()->first()->id), $data);

        $response = $this->getData(route('admin.projects.farabourse.show',Project::query()->first()->id));
        $response->assertStatus(200);

    }

}
