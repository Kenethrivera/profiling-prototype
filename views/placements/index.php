<div class="container-fluid px-0">
    <div class="d-flex justify-content-between align-items-start flex-wrap gap-3 mb-4">
        <div>
            <h1 class="page-title mb-1">Placements</h1>
            <p class="page-subtitle mb-0">Track hiring results from the job fair</p>
        </div>

        <div class="d-flex gap-2 flex-wrap">
            <a href="/placements/create" class="btn btn-primary px-4 py-2 rounded-3">
                Add Placement
            </a>
            <a href="/placements/export" class="btn btn-success px-4 py-2 rounded-3">
                Export Excel
            </a>
        </div>
    </div>

    <?php if (empty($grouped)): ?>
        <div class="panel-card p-5 text-center">
            <div class="text-secondary" style="font-size: 0.98rem;">
                No placements recorded yet.
            </div>
        </div>
    <?php endif; ?>

    <?php foreach ($grouped as $jobTitle => $rows): ?>
        <?php $companyName = $rows[0]['company_name'] ?? ''; ?>
        <div class="panel-card p-4 mb-4">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                <div>
                    <h2 class="panel-title mb-1"><?= htmlspecialchars($jobTitle) ?></h2>
                    <div class="text-secondary small"><?= htmlspecialchars($companyName) ?></div>
                </div>
                <span class="text-secondary small"><?= count($rows) ?> record(s)</span>
            </div>

            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead>
                        <tr class="text-secondary small">
                            <th class="fw-semibold">Applicant</th>
                            <th class="fw-semibold">Status</th>
                            <th class="fw-semibold">Notes</th>
                            <th class="fw-semibold">Date</th>
                            <th class="fw-semibold">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($rows as $row): ?>
                            <?php
                            $status = strtolower($row['status']);
                            $badgeClass = 'bg-secondary-subtle text-secondary';

                            if ($status === 'hired') {
                                $badgeClass = 'bg-success-subtle text-success';
                            } elseif ($status === 'interviewed') {
                                $badgeClass = 'bg-primary-subtle text-primary';
                            } elseif ($status === 'for medical' || $status === 'for requirements') {
                                $badgeClass = 'bg-warning-subtle text-warning';
                            } elseif ($status === 'not qualified') {
                                $badgeClass = 'bg-danger-subtle text-danger';
                            }
                            ?>
                            <tr>
                                <td class="fw-medium"><?= htmlspecialchars($row['applicant_name']) ?></td>
                                <td>
                                    <span class="badge <?= $badgeClass ?> rounded-pill px-3 py-2 fw-medium">
                                        <?= htmlspecialchars($row['status']) ?>
                                    </span>
                                </td>
                                <td class="text-secondary"><?= htmlspecialchars($row['notes']) ?></td>
                                <td class="text-secondary"><?= htmlspecialchars($row['date']) ?></td>
                                <td>
                                    <a href="/placements/edit?id=<?= $row['id'] ?>"
                                        class="btn btn-outline-primary btn-sm rounded-pill px-3">
                                        Edit
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endforeach; ?>
</div>