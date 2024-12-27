<?php

namespace App\Repositories\Article;

use App\Models\Article;
use App\Repositories\Repository;



class ArticleRepository extends Repository
{
    public function __construct()
    {
        $this->model = Article::query();
        $this->paginate = 20;
    }
}
