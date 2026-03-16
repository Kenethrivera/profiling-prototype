<div class="container-fluid px-0">
    <div class="mb-4">
        <h1 class="page-title">Applicants</h1>
        <p class="page-subtitle">Browse and review registered job fair applicants.</p>
    </div>

    <div class="panel-card mb-4">
        <div class="row g-3">
            <div class="col-12 col-md-6 col-xl-4">
                <label class="form-label fw-semibold text-secondary">Applicants Overview</label>
                <div class="text-secondary small">
                    Showing all registered applicants from the database.
                </div>
            </div>

            <div class="col-12 col-md-6 col-xl-4">
                <label class="form-label fw-semibold text-secondary">Available Applicants</label>
                <div class="text-secondary small">
                    Hired applicants should no longer appear in matching and placement selection.
                </div>
            </div>

            <div class="col-12 col-md-12 col-xl-4">
                <label class="form-label fw-semibold text-secondary">Total Records</label>
                <div class="text-secondary small">
                    <?= count($applicants) ?> applicant(s)
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <?php if (empty($applicants)): ?>
            <div class="col-12">
                <div class="panel-card text-center">
                    <div class="text-secondary">No applicants found.</div>
                </div>
            </div>
        <?php endif; ?>

        <?php foreach ($applicants as $applicant): ?>
            <div class="col-12 col-xl-6">
                <div class="panel-card h-100">
                    <div class="d-flex gap-3">
                        <div class="avatar">
                            <?= htmlspecialchars(strtoupper(substr($applicant['full_name'], 0, 1))) ?>
                        </div>

                        <div class="flex-grow-1">
                            <div class="d-flex justify-content-between align-items-start gap-3 mb-2">
                                <div>
                                    <div class="item-title">
                                        <?= htmlspecialchars($applicant['full_name']) ?>
                                    </div>
                                    <div class="item-subtitle mb-1">
                                        <?= htmlspecialchars(!empty($applicant['job_preferred']) ? implode(', ', $applicant['job_preferred']) : 'No preferred job') ?>
                                    </div>
                                </div>

                                <?php if (!empty($applicant['is_hired'])): ?>
                                    <span class="badge bg-success-subtle text-success rounded-pill px-3 py-2">
                                        Hired
                                    </span>
                                <?php else: ?>
                                    <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-2">
                                        Available
                                    </span>
                                <?php endif; ?>
                            </div>

                            <div class="text-secondary small mb-2">
                                <strong>Location:</strong>
                                <?= htmlspecialchars($applicant['location'] ?: 'Not specified') ?>
                            </div>

                            <div class="text-secondary small mb-3">
                                <strong>Education Level:</strong>
                                <?= htmlspecialchars($applicant['education_level'] ?: 'Not specified') ?>
                            </div>

                            <div class="d-flex flex-wrap gap-2 mb-3">
                                <?php if (!empty($applicant['skills'])): ?>
                                    <?php foreach (array_slice($applicant['skills'], 0, 4) as $skill): ?>
                                        <span class="skill-badge">
                                            <?= htmlspecialchars($skill) ?>
                                        </span>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <span class="text-secondary small">No skills listed</span>
                                <?php endif; ?>
                            </div>

                            <a href="/applicants/profile?id=<?= $applicant['id'] ?>"
                                class="btn btn-primary rounded-pill px-4">
                                View Profile
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>