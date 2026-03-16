<?php

namespace App\Services;

use App\Core\SupabaseClient;

class JobService
{
    public function __construct(private SupabaseClient $supabase)
    {
    }

    public function getAllJobs(): array
    {
        $response = $this->supabase->from(
            'jobs',
            'GET',
            null,
            'select=*&order=created_at.desc',
            true
        );

        if (!$response['success'] || !is_array($response['data'])) {
            return [];
        }

        return array_map([$this, 'normalizeJob'], $response['data']);
    }

    public function getJobById(int $id): ?array
    {
        $response = $this->supabase->from(
            'jobs',
            'GET',
            null,
            'select=*&id=eq.' . $id . '&limit=1',
            true
        );

        if (!$response['success'] || !is_array($response['data']) || empty($response['data'])) {
            return null;
        }

        return $this->normalizeJob($response['data'][0]);
    }

    public function createJob(array $data): bool
    {
        $payload = [
            'title' => $data['title'] ?? '',
            'company_name' => $data['company_name'] ?? '',
            'description' => $data['description'] ?? '',
            'required_skills' => $data['required_skills'] ?? [],
            'experience_required' => $data['experience_required'] ?? '',
            'education_requirement' => $data['education_requirement'] ?? '',
            'location' => $data['location'] ?? '',
            'employment_type' => $data['employment_type'] ?? '',
            'salary_range' => $data['salary_range'] ?? 'Not specified',
            'source' => $data['source'] ?? 'manual',
            'flyer_name' => $data['flyer_name'] ?? null,
        ];

        $response = $this->supabase->from(
            'jobs',
            'POST',
            $payload,
            '',
            true
        );

        return $response['success'];
    }

    private function normalizeJob(array $job): array
    {
        $job['id'] = (int) ($job['id'] ?? 0);
        $job['title'] = $job['title'] ?? '';
        $job['company_name'] = $job['company_name'] ?? '';
        $job['description'] = $job['description'] ?? '';
        $job['experience_required'] = $job['experience_required'] ?? '';
        $job['education_requirement'] = $job['education_requirement'] ?? '';
        $job['location'] = $job['location'] ?? '';
        $job['employment_type'] = $job['employment_type'] ?? '';
        $job['salary_range'] = $job['salary_range'] ?? 'Not specified';
        $job['source'] = $job['source'] ?? 'manual';
        $job['flyer_name'] = $job['flyer_name'] ?? null;
        $job['required_skills'] = $this->normalizeArrayField($job['required_skills'] ?? []);
        $job['matched_applicants'] = 0;

        return $job;
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

    public function countAllJobs(): int
    {
        return count($this->getAllJobs());
    }

    public function getRecentJobs(int $limit = 5): array
    {
        $response = $this->supabase->from(
            'jobs',
            'GET',
            null,
            'select=*&order=created_at.desc&limit=' . $limit,
            true
        );

        if (!$response['success'] || !is_array($response['data'])) {
            return [];
        }

        return array_map([$this, 'normalizeJob'], $response['data']);
    }
}