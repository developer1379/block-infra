<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Repositories\CategoryRepository;
use App\Repositories\Contracts\UnitRepositoryInterface;
use App\Repositories\Contracts\WorkRepositoryInterface;
use App\Repositories\UnitRepository;
use App\Repositories\WorkRepository;
use App\Repositories\Interfaces\ProjectRepositoryInterface;
use App\Repositories\Contracts\ProjectRepository;
use App\Repositories\Interfaces\BidRepositoryInterface;
use App\Repositories\Contracts\BidRepository;
use App\Repositories\Interfaces\ProjectAwardRepositoryInterface;
use App\Repositories\Contracts\ProjectAwardRepository;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
        $this->app->bind(WorkRepositoryInterface::class, WorkRepository::class);
        $this->app->bind(UnitRepositoryInterface::class, UnitRepository::class);
        $this->app->bind(ProjectRepositoryInterface::class, ProjectRepository::class);
        $this->app->bind(BidRepositoryInterface::class, BidRepository::class);
        $this->app->bind(ProjectAwardRepositoryInterface::class, ProjectAwardRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
