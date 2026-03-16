<?php

namespace App\Services;

use App\Core\SupabaseClient;

class PlacementService
{
    public function __construct(private SupabaseClient $supabase)
    {
    }

    public function getAllPlacements(): array
    {
        $response = $this->supabase->from(
            'placements',
            'GET',
            null,
            'select=*,applicants(full_name),jobs(title,company_name)&order=created_at.desc',
            true
        );

        if (!$response['success'] || !is_array($response['data'])) {
            return [];
        }

        return array_map([$this, 'normalizePlacement'], $response['data']);
    }

    public function getPlacementById(int $id): ?array
    {
        $response = $this->supabase->from(
            'placements',
            'GET',
            null,
            'select=*,applicants(full_name),jobs(title,company_name)&id=eq.' . $id . '&limit=1',
            true
        );

        if (!$response['success'] || !is_array($response['data']) || empty($response['data'])) {
            return null;
        }

        return $this->normalizePlacement($response['data'][0]);
    }

    public function createPlacement(array $data): bool
    {
        $response = $this->supabase->from(
            'placements',
            'POST',
            [
                'applicant_id' => $data['applicant_id'],
                'job_id' => $data['job_id'],
                'status' => $data['status'],
                'notes' => $data['notes'],
            ],
            '',
            true
        );

        return $response['success'];
    }

    public function updatePlacement(int $id, array $data): bool
    {
        $response = $this->supabase->from(
            'placements',
            'PATCH',
            [
                'status' => $data['status'],
                'notes' => $data['notes'],
            ],
            'id=eq.' . $id,
            true
        );

        return $response['success'];
    }

    public function groupByJob(array $placements): array
    {
        $grouped = [];

        foreach ($placements as $placement) {
            $jobTitle = $placement['job_title'] ?: 'Unknown Job';
            $grouped[$jobTitle][] = $placement;
        }

        return $grouped;
    }

    private function normalizePlacement(array $placement): array
    {
        return [
            'id' => (int) ($placement['id'] ?? 0),
            'applicant_id' => (int) ($placement['applicant_id'] ?? 0),
            'job_id' => (int) ($placement['job_id'] ?? 0),
            'applicant_name' => $placement['applicants']['full_name'] ?? '',
            'job_title' => $placement['jobs']['title'] ?? '',
            'company_name' => $placement['jobs']['company_name'] ?? '',
            'status' => $placement['status'] ?? '',
            'notes' => $placement['notes'] ?? '',
            'date' => isset($placement['created_at']) ? date('Y-m-d', strtotime($placement['created_at'])) : '',
        ];
    }

    public function countHiredPlacements(): int
    {
        $response = $this->supabase->from(
            'placements',
            'GET',
            null,
            'select=id&status=eq.Hired',
            true
        );

        if (!$response['success'] || !is_array($response['data'])) {
            return 0;
        }

        return count($response['data']);
    }
}