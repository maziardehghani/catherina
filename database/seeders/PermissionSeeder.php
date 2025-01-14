<?php

namespace Database\Seeders;

use App\Entities\Permission;
use App\Entities\Role;
use App\Entities\Status;
use App\Entities\User;
use App\Enums\UserTypes;

use App\Traits\DbTruncater;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PermissionSeeder extends Seeder
{
    use DbTruncater;

    public function __construct(
        public EntityManagerInterface $entityManager
    ){}

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $status = $this->entityManager->find(Status::class, 1);

        $user = new User();
        $user->setName('maziar');
        $user->setFamily('dehghani');
        $user->setEmail('maziar@gmail.com');
        $user->setMobile('09931591988');
        $user->setIsSejami(true);
        $user->setIsPrivateInvestor(true);
        $user->setStatus($status);
        $user->setBio('laravel developer');
        $user->setType(UserTypes::REAL);
        $user->setPassword(Hash::make(123456789));

        $this->entityManager->persist($user);



        $permission = new Permission();
        $permission->setName('management');
        $this->entityManager->persist($permission);


        $role = new Role();
        $role->setName('super-admin');
        $role->addPermission($permission);

        $role->setUser($user);
        $this->entityManager->persist($role);

        $this->entityManager->flush();
        $this->entityManager->clear();
    }
}
