<?php

namespace App\Providers;

use App\Events\FarabourseDataEvent;
use App\Events\VerificationEvent;
use App\Listeners\FarabourseDataListener;
use App\Listeners\ShareHoldersDataListener;
use App\Listeners\StakMembersDataListener;
use App\Listeners\VerificationListener;
use App\Models\FarabourseProject;
use App\Models\Project;
use App\Observers\ProjectStatusLogObserver;
use App\Services\ResponseServices\ResponseService;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        Response::macro('success', function ($data = null , $message='عملیات با موفقیت انجام شد', $status = 200) {
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


        Project::observe(ProjectStatusLogObserver::class);
    }
}
