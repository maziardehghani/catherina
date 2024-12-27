<?php

namespace Tests\Feature;

use App\Enums\Statuses;
use App\Enums\UserTypes;
use App\Models\Invoice;
use App\Models\Status;
use App\Models\User;
use App\Models\UserInfoValue;
use App\Traits\AdminTestable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase, AdminTestable;

    public function setUp(): void
    {
        Parent::setUp();
        $this->seed();
    }

    public function test_admin_can_see_users_list(): void
    {
        $response = $this->getData(route('admin.users.index'));

        $response->assertStatus(200);
    }

    public function test_admin_can_see_bank_list(): void
    {
        $response = $this->getData(
            route('admin.users.bankLists')
        );

        $response->assertStatus(200);
    }

    public function test_admin_can_see_users_detail(): void
    {
        $response = $this->getData(route('admin.users.show', User::query()->first()->getKey()));

        $response->assertStatus(200);
    }

    public function test_admin_can_create_user_real(): void
    {
        $data = [
            'name' => 'محمد',
            'family' => 'محمدی',
            'email' => fake()->unique()->safeEmail,
            'mobile' => '09132222222',
            'password' => '123456789',
            'status_id' => Status::query()->whereTitle(fake()->randomElement(Statuses::commonStatuses()))->getKey(),
            'type' => 'real',
            'bio' => fake()->paragraph,
            'is_private_investor' => fake()->boolean,
            'is_sejami' => true,
            'profile' => $this->fakeImage(),
            'national_id' => '1171011806',
            'register_code' => fake()->unique()->numerify('##########'),
            'economic_code' => fake()->unique()->numerify('##########'),
            'manager_name' => fake()->name,
            'manager_national_id' => '1171011806',
            'postal_code' => fake()->unique()->numerify('##########'),
            'phone_number' => '09133333333',
            'fax' => fake()->unique()->numerify('##########'),
            'address' => fake()->address(),
            'father_name' => fake()->name(),
            'serial_number' => fake()->title(),
            'gender' => 'male',
            'place_of_birth' => fake()->city(),
            'place_of_issue' => fake()->city(),
            'birth_date' => fake()->date(),
            'account_number' => fake()->numerify('#########'),
            'bank_name' => fake()->unique()->title(),
            'sheba' => fake()->unique()->numerify('##########'),
            'account_type' => fake()->title(),
            'company_name' => fake()->company(),
            'trading_code' => fake()->unique()->numerify('#####')
        ];

        $response = $this->postData(route('admin.users.store'), $data);
        $response->assertStatus(200);


        $this->assertDatabaseHas('users', $this->removeIndex($data, [
            'password',
            'profile',
            'national_id',
            'register_code',
            'economic_code',
            'manager_name',
            'manager_national_id',
            'postal_code',
            'phone_number',
            'fax',
            'address',
            'father_name',
            'serial_number',
            'gender',
            'place_of_birth',
            'place_of_issue',
            'birth_date',
            'account_number',
            'bank_name',
            'sheba',
            'account_type',
            'company_name',
            'trading_code']));

        collect($this->removeIndex($data, [
            'name',
            'family',
            'email',
            'mobile',
            'password',
            'status_id',
            'type',
            'bio',
            'is_private_investor',
            'is_sejami',
            'profile']))->map(function ($value) {
            $this->assertDatabaseHas(UserInfoValue::class, [
                'value' => $value
            ]);
        });
    }

    public function test_admin_can_update_user_real(): void
    {
        $data = [
            'name' => 'محمد',
            'family' => 'محمدی',
            'email' => fake()->unique()->safeEmail,
            'mobile' => '09132222222',
            'password' => '123456789',
            'status_id' => Status::query()->whereTitle(fake()->randomElement(Statuses::commonStatuses()))->getKey(),
            'type' => 'real',
            'bio' => fake()->paragraph,
            'is_private_investor' => fake()->boolean,
            'is_sejami' => true,
            'profile' => $this->fakeImage(),
            'national_id' => '1171011806',
            'register_code' => fake()->unique()->numerify('##########'),
            'economic_code' => fake()->unique()->numerify('##########'),
            'manager_name' => fake()->name,
            'manager_national_id' => '1171011806',
            'postal_code' => fake()->unique()->numerify('##########'),
            'phone_number' => '09133333333',
            'fax' => fake()->unique()->numerify('##########'),
            'address' => fake()->address(),
            'father_name' => fake()->name(),
            'serial_number' => fake()->title(),
            'gender' => 'male',
            'place_of_birth' => fake()->city(),
            'place_of_issue' => fake()->city(),
            'birth_date' => fake()->date(),
            'account_number' => fake()->numerify('#########'),
            'bank_name' => fake()->unique()->title(),
            'sheba' => fake()->unique()->numerify('##########'),
            'account_type' => fake()->title(),
            'company_name' => fake()->company(),
            'trading_code' => fake()->unique()->numerify('#####'),
            '_method' => 'put'
        ];

        $response = $this->postData(route('admin.users.update',User::query()->first()->id), $data);
        $response->assertStatus(200);


        $this->assertDatabaseHas('users', $this->removeIndex($data, [
            'password',
            'profile',
            'national_id',
            'register_code',
            'economic_code',
            'manager_name',
            'manager_national_id',
            'postal_code',
            'phone_number',
            'fax',
            'address',
            'father_name',
            'serial_number',
            'gender',
            'place_of_birth',
            'place_of_issue',
            'birth_date',
            'account_number',
            'bank_name',
            'sheba',
            'account_type',
            'company_name',
            'trading_code',
            '_method']));

        collect($this->removeIndex($data, [
            '_method',
            'name',
            'family',
            'email',
            'mobile',
            'password',
            'status_id',
            'type',
            'bio',
            'is_private_investor',
            'is_sejami',
            'profile']))->map(function ($value) {
            $this->assertDatabaseHas(UserInfoValue::class, [
                'value' => $value
            ]);
        });
    }

    public function test_admin_can_delete_user(): void
    {
        $response = $this->deleteData(route('admin.users.destroy', User::query()->first()->id));
        $response->assertStatus(200);

    }

    public function test_admin_can_see_invoices_of_user(): void
    {
        $response = $this->getData(
            route('admin.users.invoices', User::first()->id)
        );

        $response->assertStatus(200);

    }

    public function test_admin_can_see_transaction_of_user(): void
    {
        $response = $this->getData(
            route('admin.users.transactions', User::first()->id)
        );

        $response->assertStatus(200);
    }


    public function test_admin_can_see_installment_of_user(): void
    {
        $response = $this->getData(
            route('admin.users.installments', User::first()->id)
        );

        $response->assertStatus(200);
    }

    public function test_admin_can_see_bank_accounts_of_user(): void
    {
        $response = $this->getData(
            route('admin.users.bankAccounts', User::first()->id)
        );

        $response->assertStatus(200);
    }

    public function test_admin_can_see_investment_report_of_user(): void
    {
        $response = $this->getData(
            route('admin.users.investmentReport', User::first()->id)
        );

        $response->assertStatus(200);
    }
}
