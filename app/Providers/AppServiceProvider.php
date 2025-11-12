<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Repositories\CategoryRepository;
use App\Repositories\Contracts\UnitRepositoryInterface;
use App\Repositories\Contracts\WorkRepositoryInterface;
use App\Repositories\UnitRepository;
use App\Repositories\WorkRepository;

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
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
