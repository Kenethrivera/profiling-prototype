<?php

namespace App\Services;

use App\Core\SupabaseClient;

class ApplicantService
{
    public function __construct(private SupabaseClient $supabase)
    {
    }

    public function getAllApplicants(): array
    {
        $response = $this->supabase->from(
            'applicants',
            'GET',
            null,
            'select=*&order=created_at.desc',
            true
        );

        if (!$response['success'] || !is_array($response['data'])) {
            return [];
        }

        return array_map([$this, 'normalizeApplicant'], $response['data']);
    }

    public function getApplicantById(int $id): ?array
    {
        $response = $this->supabase->from(
            'applicants',
            'GET',
            null,
            'select=*&id=eq.' . $id . '&limit=1',
            true
        );

        if (!$response['success'] || !is_array($response['data']) || empty($response['data'])) {
            return null;
        }

        return $this->normalizeApplicant($response['data'][0]);
    }

    public function getAvailableApplicants(): array
    {
        $response = $this->supabase->from(
            'applicants',
            'GET',
            null,
            'select=*&is_hired=eq.false&order=created_at.desc',
            true
        );

        if (!$response['success'] || !is_array($response['data'])) {
            return [];
        }

        return array_map([$this, 'normalizeApplicant'], $response['data']);
    }

    public function markAsHired(int $id): bool
    {
        $response = $this->supabase->from(
            'applicants',
            'PATCH',
            [
                'is_hired' => true,
            ],
            'id=eq.' . $id,
            true
        );

        return $response['success'];
    }

    private function normalizeApplicant(array $applicant): array
    {
        $applicant['id'] = (int) ($applicant['id'] ?? 0);
        $applicant['full_name'] = $applicant['full_name'] ?? '';
        $applicant['email'] = $applicant['email'] ?? '';
        $applicant['phone'] = $applicant['phone'] ?? '';
        $applicant['location'] = $applicant['location'] ?? '';
        $applicant['job_preferred'] = $this->normalizeArrayField($applicant['job_preferred'] ?? []);
        $applicant['education'] = $applicant['education'] ?? '';
        $applicant['education_level'] = $applicant['education_level'] ?? '';
        $applicant['experience'] = $applicant['experience'] ?? '';
        $applicant['resume_summary'] = $applicant['resume_summary'] ?? '';
        $applicant['resume_file_url'] = $applicant['resume_file_url'] ?? '';
        $applicant['is_hired'] = (bool) ($applicant['is_hired'] ?? false);
        $applicant['skills'] = $this->normalizeArrayField($applicant['skills'] ?? []);
        $applicant['photo_url'] = $applicant['photo_url'] ?? '';

        return $applicant;
    }

    private function normalizeArrayField(mixed $value): array
    {
        if (is_array($value)) {
            return array_values(array_filter(array_map('strval', $value)));
        }

        if (is_string($value) && $value !== '') {
            $decoded = json_decode($value, true);
            if (is_array($decoded)) {
                return array_values(array_filter(array_map('strval', $decoded)));
            }
        }

        return [];
    }

    public function createApplicant(array $data): bool
    {
        $payload = [
            'full_name' => trim($data['full_name'] ?? ''),
            'email' => trim($data['email'] ?? '') !== '' ? trim($data['email']) : null,
            'phone' => trim($data['phone'] ?? ''),
            'location' => trim($data['location'] ?? ''),
            'job_preferred' => $data['job_preferred'] ?? [],
            'education' => trim($data['education'] ?? ''),
            'education_level' => trim($data['education_level'] ?? ''),
            'experience' => trim($data['experience'] ?? ''),
            'skills' => $data['skills'] ?? [],
            'resume_file_url' => $data['resume_file_url'] ?? null,
            'photo_url' => $data['photo_url'] ?? null,
            'resume_summary' => null,
            'is_hired' => false,
        ];

        $response = $this->supabase->from(
            'applicants',
            'POST',
            $payload,
            '',
            true
        );

        return $response['success'];
    }



public function countAllApplicants(): int
{
    return count($this->getAllApplicants());
}

public function countAvailableApplicants(): int
{
    return count($this->getAvailableApplicants());
}

public function getRecentApplicants(int $limit = 5): array
{
    $response = $this->supabase->from(
        'applicants',
        'GET',
        null,
        'select=*&order=created_at.desc&limit=' . $limit,
        true
    );

    if (!$response['success'] || !is_array($response['data'])) {
        return [];
    }

    return array_map([$this, 'normalizeApplicant'], $response['data']);
}
}