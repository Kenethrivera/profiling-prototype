<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Services\ApplicantService;

class ApplicantController
{
    public function __construct(private ApplicantService $applicantService)
    {
    }

    public function getApplicants(): array
    {
        return $this->applicantService->getAllApplicants();
    }

    public function index(): void
    {
        Auth::requireLogin();

        $pageTitle = 'Applicants';
        $applicants = $this->applicantService->getAllApplicants();
        $view = __DIR__ . '/../../views/applicants/index.php';

        require __DIR__ . '/../../views/layouts/main.php';
    }

    public function profile(): void
    {
        Auth::requireLogin();

        $id = (int) ($_GET['id'] ?? 0);
        $applicant = $this->applicantService->getApplicantById($id);

        if (!$applicant) {
            header('HTTP/1.1 404 Not Found');
            echo 'Applicant not found';
            exit;
        }

        $pageTitle = 'Applicant Profile';
        $view = __DIR__ . '/../../views/applicants/profile.php';

        require __DIR__ . '/../../views/layouts/main.php';
    }
}