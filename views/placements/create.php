<div class="container-fluid px-0">
    <div class="d-flex justify-content-between align-items-start flex-wrap gap-3 mb-4">
        <div>
            <h1 class="page-title mb-1"><?= $isEdit ? 'Edit Placement' : 'Add Placement' ?></h1>
            <p class="page-subtitle mb-0">
                <?= $isEdit ? 'Update hiring status for this applicant.' : 'Record applicant hiring status for reporting.' ?>
            </p>
        </div>

        <a href="/placements" class="btn btn-outline-secondary px-4 py-2 rounded-3">
            Back to Placements
        </a>
    </div>

    <div class="panel-card p-4">
        <form method="POST" action="<?= $isEdit ? '/placements/update' : '/placements/store' ?>">
            <?php if ($isEdit): ?>
                <input type="hidden" name="id" value="<?= htmlspecialchars((string) $placement['id']) ?>">
            <?php endif; ?>

            <div class="row g-4">
                <?php if (!$isEdit): ?>
                    <div class="col-12 col-md-6">
                        <label class="form-label fw-semibold">Applicant</label>
                        <select name="applicant_id" class="form-select">
                            <?php foreach ($applicants as $a): ?>
                                <option value="<?= $a['id'] ?>">
                                    <?= htmlspecialchars($a['full_name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label fw-semibold">Job</label>
                        <select name="job_id" class="form-select">
                            <?php foreach ($jobs as $j): ?>
                                <option value="<?= $j['id'] ?>">
                                    <?= htmlspecialchars($j['title']) ?> - <?= htmlspecialchars($j['company_name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                <?php else: ?>
                    <div class="col-12 col-md-6">
                        <label class="form-label fw-semibold">Applicant</label>
                        <input type="text" class="form-control"
                            value="<?= htmlspecialchars($placement['applicant_name']) ?>" readonly>
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label fw-semibold">Job</label>
                        <input type="text" class="form-control"
                            value="<?= htmlspecialchars($placement['job_title'] . ' - ' . $placement['company_name']) ?>"
                            readonly>
                    </div>
                <?php endif; ?>

                <div class="col-12 col-md-6">
                    <label class="form-label fw-semibold">Status</label>
                    <?php $selectedStatus = $placement['status'] ?? 'Interviewed'; ?>
                    <select name="status" class="form-select">
                        <option value="Interviewed" <?= $selectedStatus === 'Interviewed' ? 'selected' : '' ?>>Interviewed
                        </option>
                        <option value="Hired" <?= $selectedStatus === 'Hired' ? 'selected' : '' ?>>Hired</option>
                        <option value="For Medical" <?= $selectedStatus === 'For Medical' ? 'selected' : '' ?>>For Medical
                        </option>
                        <option value="For Requirements" <?= $selectedStatus === 'For Requirements' ? 'selected' : '' ?>>
                            For Requirements</option>
                        <option value="Not Qualified" <?= $selectedStatus === 'Not Qualified' ? 'selected' : '' ?>>Not
                            Qualified</option>
                    </select>
                </div>

                <div class="col-12 col-md-6">
                    <label class="form-label fw-semibold">Notes</label>
                    <input type="text" name="notes" class="form-control" placeholder="Optional notes"
                        value="<?= htmlspecialchars($placement['notes'] ?? '') ?>">
                </div>
            </div>

            <div class="mt-4 d-flex gap-2 flex-wrap">
                <button class="btn btn-primary px-4 py-2 rounded-3" type="submit">
                    <?= $isEdit ? 'Update Placement' : 'Save Placement' ?>
                </button>

                <a href="/placements" class="btn btn-outline-secondary px-4 py-2 rounded-3">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>