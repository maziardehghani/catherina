<?php

namespace Database\Seeders;

use App\Entities\City;
use App\Entities\State;
use App\Traits\DbTruncater;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class CitySeeder extends Seeder
{
    use DbTruncater;

    public function __construct(
        public EntityManagerInterface $entityManager
    ) {}
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->truncate($this->entityManager, 'cities');
        $this->truncate($this->entityManager, 'states');


        $filename = public_path('cities/provinces.json');
        $content = File::get($filename);
        foreach (json_decode($content) as $provinceItem) {
            $state = new State();
            $state->setName($provinceItem->name);
            $this->entityManager->persist($state);
        }
        $this->entityManager->flush();



        $filename = public_path('cities/cities.json');
        $content = File::get($filename);
        foreach (json_decode($content) as $cityItem) {
            $state = $this->entityManager->find(State::class, $cityItem->province_id);

            $city = new City();
            $city->setName($cityItem->name);
            $city->setState($state);
            $this->entityManager->persist($city);
        }


        $this->entityManager->flush();


    }
}
