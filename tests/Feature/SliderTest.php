<?php

namespace Tests\Feature;

use App\Enums\Statuses;
use App\Models\Slider;
use App\Models\Status;
use App\Traits\AdminTestable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SliderTest extends TestCase
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

    public function test_admin_can_see_sliders(): void
    {
        $response = $this->getData(route('admin.sliders.index'));

        $response->assertStatus(200);
    }

    public function test_admin_can_see_slider(): void
    {
        $response = $this->getData(route('admin.sliders.show', Slider::first()->id));

        $response->assertStatus(200);
    }

    public function test_admin_can_store_slider(): void
    {
        $data = [
            'title' => fake()->sentence(),
            'link' => fake()->url(),
            'status_id' => Status::query()->whereTitle(fake()->randomElement(Statuses::commonStatuses()))->getKey(),
            'order' => fake()->numberBetween(1,10),
            'banner' => $this->fakeImage()
        ];

        $response = $this->postData(route('admin.sliders.store'), $data);
        $response->assertStatus(200);

        $this->assertDatabaseHas(Slider::class,$this->removeIndex($data,['banner']));
        $this->assertFileExist(Slider::query()->orderBy('id','desc')->first()->medias()->first()?->url);
    }


    public function test_admin_can_update_slider(): void
    {
        $data = [
            'title' => fake()->sentence(),
            'link' => fake()->url(),
            'status_id' => Status::query()->whereTitle(fake()->randomElement(Statuses::commonStatuses()))->getKey(),
            'order' => fake()->numberBetween(1,10),
            'banner' => $this->fakeImage(),
            '_method' => 'PUT'
        ];

        $response = $this->postData(route('admin.sliders.update', Slider::query()->first()->id), $data);
        $response->assertStatus(200);

        $this->assertDatabaseHas(Slider::class,$this->removeIndex($data,['banner', '_method']));
        $this->assertFileExist(Slider::query()->first()->medias()->first()?->url);
    }

    public function test_admin_can_destroy_slider(): void
    {
        $response = $this->deleteData(route('admin.sliders.destroy', Slider::query()->first()->id));

        $response->assertStatus(200);
    }
}
