<?php

namespace App\Providers;

use App\Events\FarabourseDataEvent;
use App\Events\VerificationEvent;
use App\Listeners\FarabourseDataListener;
use App\Listeners\ShareHoldersDataListener;
use App\Listeners\StakMembersDataListener;
use App\Listeners\VerificationListener;
use App\Services\ResponseServices\ResponseService;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use function App\Helpers\getEntityName;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {

        $entityManager = $this->app->make(EntityManagerInterface::class);

        foreach (config('repository.binders') as $concrete => $bind) {
            $this->app->bind($concrete, function () use ($bind, $entityManager) {
                return $entityManager->getRepository($bind);
            });
        }


        $metadataFactory = $entityManager->getMetadataFactory();
        $allMetadata = $metadataFactory->getAllMetadata();

        foreach ($allMetadata as $metadata) {
            Route::bind(getEntityName($metadata->getName()), function ($value) use ($entityManager, $metadata) {
                return $entityManager->getRepository($metadata->getName())->find($value)
                    ?? abort(404,'model not found');
            });
        }
    }


    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        Response::macro('success', function ($data = null, $message = 'عملیات با موفقیت انجام شد', $status = 200) {
            return ResponseService::successResponse($data, $message, $status = 200);
        });

        Response::macro('error', function ($message, $status = 400) {
            return ResponseService::errorResponse($message, $status);
        });

        Response::macro('excelResponse', function ($writer) {
            return ResponseService::excelResponse($writer);
        });

        Response::macro('pdfResponse', function ($meta) {
            return ResponseService::pdfResponse($meta);
        });

        Event::listen(
            VerificationEvent::class,
            VerificationListener::class
        );

        Event::listen(
            FarabourseDataEvent::class,
            FarabourseDataListener::class,
        );

        Event::listen(
            FarabourseDataEvent::class,
            ShareHoldersDataListener::class,
        );

        Event::listen(
            FarabourseDataEvent::class,
            StakMembersDataListener::class,
        );

    }
}
