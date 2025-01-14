<?php

namespace Database\Seeders;

use App\Entities\Article;
use App\Entities\Status;
use App\Entities\User;
use App\Traits\DbTruncater;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
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
        $this->truncate($this->entityManager,'articles');
        $user = $this->entityManager->find(User::class,1);
        $status = $this->entityManager->find(Status::class,1);

        for ($i = 0; $i < 10; $i++  ) {

            $article = new Article();
            $article->setUser($user);
            $article->setTitle(fake()->title());
            $article->setSlug(fake()->slug());
            $article->setIntro(fake()->text());
            $article->setContent(fake()->text());
            $article->setStatus($status);
            $this->entityManager->persist($article);
        }
        $this->entityManager->flush();

    }
}
