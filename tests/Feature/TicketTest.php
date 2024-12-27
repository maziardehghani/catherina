<?php

namespace Tests\Feature;

use App\Enums\Statuses;
use App\Enums\TicketCategories;
use App\Models\Status;
use App\Models\Ticket;
use App\Traits\AdminTestable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TicketTest extends TestCase
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

    public function test_admin_can_see_tickets(): void
    {
        $response = $this->getData(route('admin.tickets.index'));

        $response->assertStatus(200);
    }

    public function test_admin_can_see_ticket(): void
    {
        $response = $this->getData(route('admin.tickets.show', Ticket::query()->first()->id));

        $response->assertStatus(200);
    }

    public function test_admin_can_answer_tickets()
    {
        $data = [
            'subject' => fake()->title,
            'content' => fake()->paragraph,
            'status_id' => Status::query()->whereTitle(fake()->randomElement(Statuses::TicketStatuses()))->getKey(),
            'category' => fake()->randomElement(TicketCategories::categories()),
            '_method' => 'put'
        ];

        $response = $this->postData(route('admin.tickets.answer', Ticket::query()->first()->id),$data);

        $response->assertStatus(200);
        $this->assertDatabaseHas(Ticket::class, $this->removeIndex($data,['_method']));
    }

    public function test_admin_can_update_ticket()
    {
        $data = [
            'status_id' => Status::query()->whereTitle(fake()->randomElement(Statuses::TicketStatuses()))->getKey(),
            'category' => fake()->randomElement(TicketCategories::categories()),
            '_method' => 'put'
        ];

        $response = $this->postData(route('admin.tickets.update', Ticket::query()->first()->id),$data);

        $response->assertStatus(200);
        $this->assertDatabaseHas(Ticket::class, $this->removeIndex($data,['_method']));

    }

    public function test_admin_can_delete_ticket()
    {
        $response = $this->deleteData(route('admin.tickets.destroy', Ticket::query()->first()->id));
        $response->assertStatus(200);
    }
}
