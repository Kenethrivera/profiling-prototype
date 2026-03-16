<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Services\ApplicantService;
use App\Services\JobService;
use App\Services\PlacementService;

class PlacementController
{
    public function __construct(
        private PlacementService $placementService,
        private ApplicantService $applicantService,
        private JobService $jobService
    ) {
        Auth::start();
    }

    public function index(): void
    {
        Auth::requireLogin();

        $placements = $this->placementService->getAllPlacements();
        $grouped = $this->placementService->groupByJob($placements);

        $pageTitle = "Placements";
        $view = __DIR__ . "/../../views/placements/index.php";

        require __DIR__ . "/../../views/layouts/main.php";
    }

    public function create(): void
    {
        Auth::requireLogin();

        $applicants = $this->applicantService->getAvailableApplicants();
        $jobs = $this->jobService->getAllJobs();
        $placement = null;
        $isEdit = false;

        $pageTitle = "Add Placement";
        $view = __DIR__ . "/../../views/placements/create.php";

        require __DIR__ . "/../../views/layouts/main.php";
    }

    public function store(): void
    {
        Auth::requireLogin();

        $applicantId = (int) ($_POST['applicant_id'] ?? 0);
        $jobId = (int) ($_POST['job_id'] ?? 0);
        $status = trim($_POST['status'] ?? '');
        $notes = trim($_POST['notes'] ?? '');

        $applicant = $this->applicantService->getApplicantById($applicantId);
        $job = $this->jobService->getJobById($jobId);

        if (!$applicant || !$job || $status === '') {
            header("Location: /placements");
            exit;
        }

        $saved = $this->placementService->createPlacement([
            'applicant_id' => $applicantId,
            'job_id' => $jobId,
            'status' => $status,
            'notes' => $notes,
        ]);

        if ($saved && strtolower($status) === 'hired') {
            $this->applicantService->markAsHired($applicantId);
        }

        header("Location: /placements");
        exit;
    }

    public function edit(): void
    {
        Auth::requireLogin();

        $id = (int) ($_GET['id'] ?? 0);
        $placement = $this->placementService->getPlacementById($id);

        if (!$placement) {
            header('HTTP/1.1 404 Not Found');
            echo 'Placement not found';
            exit;
        }

        $applicants = [];
        $jobs = [];
        $isEdit = true;

        $pageTitle = "Edit Placement";
        $view = __DIR__ . "/../../views/placements/create.php";

        require __DIR__ . "/../../views/layouts/main.php";
    }

    public function update(): void
    {
        Auth::requireLogin();

        $id = (int) ($_POST['id'] ?? 0);
        $status = trim($_POST['status'] ?? '');
        $notes = trim($_POST['notes'] ?? '');

        $existing = $this->placementService->getPlacementById($id);

        if (!$existing || $status === '') {
            header("Location: /placements");
            exit;
        }

        $updated = $this->placementService->updatePlacement($id, [
            'status' => $status,
            'notes' => $notes,
        ]);

        if ($updated && strtolower($status) === 'hired') {
            $this->applicantService->markAsHired($existing['applicant_id']);
        }

        header("Location: /placements");
        exit;
    }

    public function export(): void
    {
        Auth::requireLogin();

        $placements = $this->placementService->getAllPlacements();

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="placements_report.csv"');

        $output = fopen("php://output", "w");

        fputcsv($output, [
            "Job",
            "Company",
            "Applicant",
            "Status",
            "Notes",
            "Date"
        ]);

        foreach ($placements as $row) {
            fputcsv($output, [
                $row['job_title'],
                $row['company_name'],
                $row['applicant_name'],
                $row['status'],
                $row['notes'],
                $row['date']
            ]);
        }

        fclose($output);
        exit;
    }
}