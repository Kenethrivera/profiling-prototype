<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Services\ApplicantService;
use App\Services\JobService;
use App\Services\PlacementService;

class DashboardController
{
    public function __construct(
        private ApplicantService $applicantService,
        private JobService $jobService,
        private PlacementService $placementService
    ) {
    }

    public function index(): void
    {
        Auth::requireLogin();

        $user = Auth::user();

        $totalApplicants = $this->applicantService->countAllApplicants();
        $availableApplicants = $this->applicantService->countAvailableApplicants();
        $activeJobs = $this->jobService->countAllJobs();
        $hiredCount = $this->placementService->countHiredPlacements();

        $recentApplicants = $this->applicantService->getRecentApplicants(5);
        $recentJobs = $this->jobService->getRecentJobs(5);

        $pageTitle = 'Dashboard';
        $view = __DIR__ . '/../../views/dashboard/index.php';

        require __DIR__ . '/../../views/layouts/main.php';
    }
}