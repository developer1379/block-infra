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
use App\Repositories\Contracts\ContractorProfileRepository;
use App\Repositories\Interfaces\ProjectAwardRepositoryInterface;
use App\Repositories\Contracts\ProjectAwardRepository;
use App\Repositories\Interfaces\ContractorProfileRepositoryInterface;
use App\Repositories\ProjectMilestone\Interfaces\ProjectMilestoneRepositoryInterface;
use App\Repositories\ProjectMilestone\ProjectMilestoneRepository;
use App\Repositories\ProjectProgressUpdate\Interfaces\ProjectProgressUpdateRepositoryInterface;
use App\Repositories\ProjectProgressUpdate\ProjectProgressUpdateRepository;
use App\Interfaces\MilestoneCommentRepositoryInterface;
use App\Repositories\MilestoneCommentRepository;
use App\Repositories\Interfaces\InvoiceRepositoryInterface;
use App\Repositories\InvoiceRepository;
use App\Repositories\Interfaces\WorkerRepositoryInterface;
use App\Repositories\WorkerRepository;
use App\Repositories\Interfaces\MaterialRepositoryInterface;
use App\Repositories\MaterialRepository;
use App\Repositories\Interfaces\SiteReportRepositoryInterface;
use App\Repositories\SiteReportRepository;
use App\Repositories\Interfaces\AttendanceRepositoryInterface;
use App\Repositories\AttendanceRepository;

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
        $this->app->bind(ContractorProfileRepositoryInterface::class, ContractorProfileRepository::class);
        $this->app->bind(ProjectMilestoneRepositoryInterface::class, ProjectMilestoneRepository::class);
        $this->app->bind(ProjectProgressUpdateRepositoryInterface::class, ProjectProgressUpdateRepository::class);
        $this->app->bind(MilestoneCommentRepositoryInterface::class, MilestoneCommentRepository::class);
        $this->app->bind(InvoiceRepositoryInterface::class, InvoiceRepository::class);
        $this->app->bind(WorkerRepositoryInterface::class, WorkerRepository::class);
        $this->app->bind(MaterialRepositoryInterface::class, MaterialRepository::class);
        $this->app->bind(SiteReportRepositoryInterface::class, SiteReportRepository::class);
        $this->app->bind(AttendanceRepositoryInterface::class, AttendanceRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
