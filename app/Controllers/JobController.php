<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Services\ApplicantService;
use App\Services\JobService;

class JobController
{
    public function __construct(
        private JobService $jobService,
        private ApplicantService $applicantService
    ) {
        Auth::start();
    }

    public function index(): void
    {
        Auth::requireLogin();

        $jobs = $this->jobService->getAllJobs();

        foreach ($jobs as &$job) {
            $matches = $this->calculateMatchesForJob($job);
            $job['matched_applicants'] = count($matches);
        }

        $pageTitle = 'Job Listings';
        $view = __DIR__ . '/../../views/jobs/index.php';

        require __DIR__ . '/../../views/layouts/main.php';
    }

    public function create(): void
    {
        Auth::requireLogin();

        $pageTitle = 'Post New Job';
        $errors = $_SESSION['job_errors'] ?? [];
        $old = $_SESSION['job_old'] ?? [];
        $uploadErrors = $_SESSION['upload_errors'] ?? [];
        $extracted = $_SESSION['extracted_job_data'] ?? null;
        $uploadSuccess = $_SESSION['upload_success'] ?? null;

        unset(
            $_SESSION['job_errors'],
            $_SESSION['job_old'],
            $_SESSION['upload_errors'],
            $_SESSION['upload_success']
        );

        $view = __DIR__ . '/../../views/jobs/create.php';

        require __DIR__ . '/../../views/layouts/main.php';
    }

    public function store(): void
    {
        Auth::requireLogin();

        $title = trim($_POST['title'] ?? '');
        $companyName = trim($_POST['company_name'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $requiredSkills = trim($_POST['required_skills'] ?? '');
        $experienceRequired = trim($_POST['experience_required'] ?? '');
        $educationRequirement = trim($_POST['education_requirement'] ?? '');
        $location = trim($_POST['location'] ?? '');
        $employmentType = trim($_POST['employment_type'] ?? '');
        $salaryRange = trim($_POST['salary_range'] ?? '');
        $source = trim($_POST['source'] ?? 'manual');
        $flyerName = trim($_POST['flyer_name'] ?? '');

        $errors = [];

        if ($title === '')
            $errors[] = 'Job title is required.';
        if ($companyName === '')
            $errors[] = 'Company name is required.';
        if ($description === '')
            $errors[] = 'Job description is required.';
        if ($requiredSkills === '')
            $errors[] = 'Required skills are required.';
        if ($experienceRequired === '')
            $errors[] = 'Experience required is required.';
        if ($educationRequirement === '')
            $errors[] = 'Education requirement is required.';
        if ($location === '')
            $errors[] = 'Location is required.';
        if ($employmentType === '')
            $errors[] = 'Employment type is required.';

        if (!empty($errors)) {
            $_SESSION['job_errors'] = $errors;
            $_SESSION['job_old'] = $_POST;
            header('Location: /post-job');
            exit;
        }

        $skillsArray = array_values(array_filter(array_map('trim', explode(',', $requiredSkills))));

        $saved = $this->jobService->createJob([
            'title' => $title,
            'company_name' => $companyName,
            'description' => $description,
            'required_skills' => $skillsArray,
            'experience_required' => $experienceRequired,
            'education_requirement' => $educationRequirement,
            'location' => $location,
            'employment_type' => $employmentType,
            'salary_range' => $salaryRange !== '' ? $salaryRange : 'Not specified',
            'source' => $source,
            'flyer_name' => $flyerName !== '' ? $flyerName : null,
        ]);

        if (!$saved) {
            $_SESSION['job_errors'] = ['Failed to save job to database.'];
            $_SESSION['job_old'] = $_POST;
            header('Location: /post-job');
            exit;
        }

        unset($_SESSION['extracted_job_data']);
        $_SESSION['flash_success'] = 'Job posted successfully.';

        header('Location: /jobs');
        exit;
    }

    public function uploadFlyer(): void
    {
        Auth::requireLogin();

        $errors = [];

        if (!isset($_FILES['job_flyer']) || $_FILES['job_flyer']['error'] !== UPLOAD_ERR_OK) {
            $errors[] = 'Please upload a valid flyer file.';
        }

        if (!empty($errors)) {
            $_SESSION['upload_errors'] = $errors;
            header('Location: /post-job');
            exit;
        }

        $file = $_FILES['job_flyer'];
        $originalName = $file['name'];
        $extension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'pdf'];

        if (!in_array($extension, $allowed, true)) {
            $_SESSION['upload_errors'] = ['Only JPG, JPEG, PNG, and PDF files are allowed.'];
            header('Location: /post-job');
            exit;
        }

        $uploadDir = __DIR__ . '/../../public/uploads/job_flyers/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $safeName = time() . '_' . preg_replace('/[^A-Za-z0-9._-]/', '_', $originalName);
        $targetPath = $uploadDir . $safeName;

        if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
            $_SESSION['upload_errors'] = ['Failed to save uploaded flyer.'];
            header('Location: /post-job');
            exit;
        }

        $mockExtracted = $this->simulateOcrExtraction($originalName);

        $_SESSION['extracted_job_data'] = array_merge($mockExtracted, [
            'source' => 'flyer',
            'flyer_name' => $safeName,
            'original_flyer_name' => $originalName,
        ]);

        $_SESSION['upload_success'] = 'Flyer uploaded and job details extracted successfully.';
        header('Location: /post-job');
        exit;
    }

    public function matches(): void
    {
        Auth::requireLogin();

        $id = (int) ($_GET['id'] ?? 0);
        $job = $this->jobService->getJobById($id);

        if (!$job) {
            header('HTTP/1.1 404 Not Found');
            echo 'Job not found';
            exit;
        }

        $matches = $this->calculateMatchesForJob($job);

        $pageTitle = 'Job Matches';
        $view = __DIR__ . '/../../views/jobs/matches.php';

        require __DIR__ . '/../../views/layouts/main.php';
    }

    private function calculateMatchesForJob(array $job): array
    {
        $applicants = $this->applicantService->getAvailableApplicants();
        $results = [];

        foreach ($applicants as $applicant) {
            $applicantSkills = array_map('strtolower', $applicant['skills']);

            $matchingSkills = [];
            $missingSkills = [];

            foreach ($job['required_skills'] as $requiredSkill) {
                if (in_array(strtolower($requiredSkill), $applicantSkills, true)) {
                    $matchingSkills[] = $requiredSkill;
                } else {
                    $missingSkills[] = $requiredSkill;
                }
            }

            $skillScore = 0;
            if (count($job['required_skills']) > 0) {
                $skillScore = (count($matchingSkills) / count($job['required_skills'])) * 70;
            }

            $jobPreferredScore = 0;
            $preferredJobs = $applicant['job_preferred'] ?? [];

            if (!is_array($preferredJobs)) {
                $preferredJobs = [$preferredJobs];
            }

            foreach ($preferredJobs as $preferredJob) {
                if (
                    is_string($preferredJob) &&
                    (
                        stripos($preferredJob, $job['title']) !== false ||
                        stripos($job['title'], $preferredJob) !== false
                    )
                ) {
                    $jobPreferredScore = 20;
                    break;
                }
            }

            $educationScore = !empty($applicant['education_level']) ? 10 : 0;
            $totalScore = round($skillScore + $jobPreferredScore + $educationScore);

            $results[] = [
                'applicant' => $applicant,
                'match_percent' => $totalScore,
                'matching_skills' => $matchingSkills,
                'missing_skills' => $missingSkills,
                'ai_explanation' => $this->generateExplanation($applicant, $job, $totalScore, $matchingSkills, $missingSkills),
            ];
        }

        usort($results, fn($a, $b) => $b['match_percent'] <=> $a['match_percent']);

        return $results;
    }

    private function generateExplanation(array $applicant, array $job, int $score, array $matchingSkills, array $missingSkills): string
    {
        $name = $applicant['full_name'];
        $jobTitle = $job['title'];

        if ($score >= 85) {
            return "{$name} is a strong match for {$jobTitle} because of relevant skills in " . implode(', ', $matchingSkills) . ".";
        }

        if ($score >= 70) {
            return "{$name} is a good candidate for {$jobTitle} with matching strengths in " . implode(', ', $matchingSkills) . ", but may still need improvement in " . implode(', ', $missingSkills) . ".";
        }

        if (!empty($matchingSkills)) {
            return "{$name} has partial alignment for {$jobTitle}, especially in " . implode(', ', $matchingSkills) . ", but lacks several required skills.";
        }

        return "{$name} currently has limited compatibility for {$jobTitle} due to missing required skills.";
    }

    private function simulateOcrExtraction(string $filename): array
    {
        $lower = strtolower($filename);

        if (str_contains($lower, 'data')) {
            return [
                'title' => 'Data Analyst',
                'company_name' => 'Insight Bridge Solutions',
                'description' => 'Analyze data trends, prepare reports, and support business decision-making through dashboards and insights.',
                'required_skills' => 'Python, SQL, Excel',
                'experience_required' => '1 year',
                'education_requirement' => 'Bachelor’s Degree',
                'location' => 'Santa Rosa, Laguna',
                'employment_type' => 'Full-time',
                'salary_range' => '₱25,000 - ₱32,000',
            ];
        }

        if (str_contains($lower, 'hr') || str_contains($lower, 'human')) {
            return [
                'title' => 'HR Assistant',
                'company_name' => 'PeopleFirst Corp.',
                'description' => 'Assist in recruitment, employee onboarding, records handling, and HR documentation tasks.',
                'required_skills' => 'Recruitment, Onboarding, Documentation',
                'experience_required' => '1 year',
                'education_requirement' => 'Bachelor’s Degree',
                'location' => 'San Pedro, Laguna',
                'employment_type' => 'Full-time',
                'salary_range' => '₱20,000 - ₱24,000',
            ];
        }

        if (str_contains($lower, 'service') || str_contains($lower, 'customer')) {
            return [
                'title' => 'Customer Service Representative',
                'company_name' => 'BPO Excellence Inc.',
                'description' => 'Respond to customer concerns, provide solutions, and maintain excellent client communication.',
                'required_skills' => 'Customer Support, Communication, Problem Solving',
                'experience_required' => '2 years',
                'education_requirement' => 'Bachelor’s Degree',
                'location' => 'Biñan, Laguna',
                'employment_type' => 'Full-time',
                'salary_range' => '₱18,000 - ₱22,000',
            ];
        }

        return [
            'title' => 'Marketing Officer',
            'company_name' => 'GrowthEdge Media',
            'description' => 'Support digital campaigns, assist with content planning, and coordinate marketing activities.',
            'required_skills' => 'Communication, Social Media, Content Writing',
            'experience_required' => '1 year',
            'education_requirement' => 'Bachelor’s Degree',
            'location' => 'Calamba, Laguna',
            'employment_type' => 'Full-time',
            'salary_range' => '₱22,000 - ₱28,000',
        ];
    }
}