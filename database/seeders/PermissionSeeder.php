<?php

namespace Database\Seeders;

use App\Enums\Statuses;
use App\Models\Status;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::query()->create([
            'name' => 'maziar',
            'family' => 'dehghani',
            'mobile' => '09931591988',
            'status_id' => Status::query()->whereTitle(fake()->randomElement(Statuses::commonStatuses()))->first()->id,
            'type' => 'real',
            'is_sejami' => 1,
            'is_private_investor' => 0,
            'email' => 'maziar@gmail.com',
            'password' => Hash::make(123456789),

        ]);

        $permission = Permission::query()->create([
            'name' => 'management',
        ]);

        $user->givePermissionTo($permission);
    }
}
