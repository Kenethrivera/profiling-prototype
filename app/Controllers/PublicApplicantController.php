<?php

namespace App\Controllers;

use App\Services\ApplicantService;

class PublicApplicantController
{
    public function __construct(private ApplicantService $applicantService)
    {
    }

    public function showForm(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $errors = $_SESSION['apply_errors'] ?? [];
        $old = $_SESSION['apply_old'] ?? [];
        $success = $_SESSION['apply_success'] ?? null;

        unset(
            $_SESSION['apply_errors'],
            $_SESSION['apply_old'],
            $_SESSION['apply_success']
        );

        require __DIR__ . '/../../views/public/apply.php';
    }

    public function submit(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $fullName = trim($_POST['full_name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $location = trim($_POST['location'] ?? '');
        $education = trim($_POST['education'] ?? '');
        $educationLevel = trim($_POST['education_level'] ?? '');
        $experience = trim($_POST['experience'] ?? '');
        $skillsRaw = trim($_POST['skills'] ?? '');
        $preferredJobsRaw = $_POST['preferred_jobs'] ?? '[]';

        $errors = [];

        if ($fullName === '')
            $errors[] = 'Full name is required.';
        if ($phone === '')
            $errors[] = 'Phone is required.';
        if ($location === '')
            $errors[] = 'Location is required.';
        if ($education === '')
            $errors[] = 'Education is required.';
        if ($educationLevel === '')
            $errors[] = 'Education level is required.';

        $skills = array_values(array_filter(array_map('trim', explode(',', $skillsRaw))));

        $preferredJobs = json_decode($preferredJobsRaw, true);
        if (!is_array($preferredJobs)) {
            $preferredJobs = [];
        }

        $preferredJobs = array_values(array_filter(array_map('trim', $preferredJobs)));

        if (empty($preferredJobs)) {
            $errors[] = 'At least one preferred job is required.';
        }

        $photoUrl = null;
        $resumeFileUrl = null;

        if (isset($_FILES['photo']) && $_FILES['photo']['error'] !== UPLOAD_ERR_NO_FILE) {
            $photoUpload = $this->uploadFile($_FILES['photo'], 'photos', ['jpg', 'jpeg', 'png', 'webp']);
            if (!$photoUpload['success']) {
                $errors[] = $photoUpload['message'];
            } else {
                $photoUrl = $photoUpload['path'];
            }
        }

        if (!isset($_FILES['resume']) || $_FILES['resume']['error'] === UPLOAD_ERR_NO_FILE) {
            $errors[] = 'Resume file is required.';
        } else {
            $resumeUpload = $this->uploadFile($_FILES['resume'], 'resumes', ['pdf', 'doc', 'docx']);
            if (!$resumeUpload['success']) {
                $errors[] = $resumeUpload['message'];
            } else {
                $resumeFileUrl = $resumeUpload['path'];
            }
        }

        if (empty($errors)) {
            $saved = $this->applicantService->createApplicant([
                'full_name' => $fullName,
                'email' => $email,
                'phone' => $phone,
                'location' => $location,
                'job_preferred' => $preferredJobs,
                'education' => $education,
                'education_level' => $educationLevel,
                'experience' => $experience,
                'skills' => $skills,
                'resume_file_url' => $resumeFileUrl,
                'photo_url' => $photoUrl,
            ]);

            if ($saved) {
                $_SESSION['apply_success'] = 'Application submitted successfully.';
                header('Location: /apply');
                exit;
            }

            $errors[] = 'Failed to submit application. Please try again.';
        }

        $_SESSION['apply_errors'] = $errors;
        $_SESSION['apply_old'] = $_POST;

        header('Location: /apply');
        exit;
    }

    private function uploadFile(array $file, string $folder, array $allowedExtensions): array
    {
        if (!isset($file['error']) || $file['error'] !== UPLOAD_ERR_OK) {
            return [
                'success' => false,
                'message' => 'Failed to upload file.'
            ];
        }

        $originalName = $file['name'] ?? '';
        $extension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

        if (!in_array($extension, $allowedExtensions, true)) {
            return [
                'success' => false,
                'message' => 'Invalid file type for ' . $folder . '.'
            ];
        }

        $uploadDir = __DIR__ . '/../../public/uploads/applicants/' . $folder . '/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $safeName = time() . '_' . bin2hex(random_bytes(4)) . '_' . preg_replace('/[^A-Za-z0-9._-]/', '_', $originalName);
        $targetPath = $uploadDir . $safeName;

        if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
            return [
                'success' => false,
                'message' => 'Could not save uploaded file.'
            ];
        }

        return [
            'success' => true,
            'path' => '/uploads/applicants/' . $folder . '/' . $safeName
        ];
    }
}