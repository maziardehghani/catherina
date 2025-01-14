<?php

namespace App\Http\Controllers\Admin;

use App\Entities\Warranty;
use App\Http\Controllers\Controller;
use App\Http\Resources\Warranty\WarrantyResource;

use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WarrantyController extends Controller
{
    public function __construct(
        public EntityManagerInterface $entityManager
    )
    {}
    /**
     * @return JsonResponse warranties list
     *
     */
    public function index():JsonResponse
    {
        $warranties = $this->entityManager->getRepository(Warranty::class)->findAll();
        return response()->success(WarrantyResource::collection($warranties));
    }
}
