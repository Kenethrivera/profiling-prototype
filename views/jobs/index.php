<div class="container-fluid px-0">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
        <div>
            <h1 class="page-title mb-1">Job Listings</h1>
            <p class="page-subtitle mb-0">Manage posted job opportunities and review matched applicants.</p>
        </div>

        <a href="/post-job" class="btn btn-primary rounded-pill px-4">
            <i class="bi bi-plus-circle me-2"></i>Post New Job
        </a>
    </div>

    <?php if (!empty($_SESSION['flash_success'])): ?>
        <div class="alert alert-success border-0 rounded-4 mb-4">
            <?= htmlspecialchars($_SESSION['flash_success']) ?>
        </div>
        <?php unset($_SESSION['flash_success']); ?>
    <?php endif; ?>

    <div class="row g-4">
        <?php if (empty($jobs)): ?>
            <div class="col-12">
                <div class="panel-card text-center">
                    <div class="text-secondary">No jobs found.</div>
                </div>
            </div>
        <?php endif; ?>

        <?php foreach ($jobs as $job): ?>
            <div class="col-12 col-xl-6">
                <div class="panel-card h-100">
                    <div class="d-flex justify-content-between align-items-start gap-3 mb-3">
                        <div>
                            <div class="item-title">
                                <?= htmlspecialchars($job['title']) ?>
                            </div>
                            <div class="item-subtitle mb-1">
                                <?= htmlspecialchars($job['company_name']) ?>
                            </div>
                            <div class="text-secondary small">
                                <?= htmlspecialchars($job['location'] ?: 'No location') ?> •
                                <?= htmlspecialchars($job['employment_type'] ?: 'Not specified') ?>
                                <?php if (!empty($job['source']) && $job['source'] === 'flyer'): ?>
                                    • Extracted from flyer
                                <?php endif; ?>
                            </div>
                        </div>

                        <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-2">
                            <?= htmlspecialchars((string) $job['matched_applicants']) ?> Matches
                        </span>
                    </div>

                    <p class="text-secondary mb-3">
                        <?= htmlspecialchars($job['description']) ?>
                    </p>

                    <div class="d-flex flex-wrap gap-2 mb-3">
                        <?php if (!empty($job['required_skills'])): ?>
                            <?php foreach ($job['required_skills'] as $skill): ?>
                                <span class="skill-badge">
                                    <?= htmlspecialchars($skill) ?>
                                </span>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <span class="text-secondary small">No required skills listed</span>
                        <?php endif; ?>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-12 col-md-6">
                            <div class="small text-secondary fw-semibold mb-1">Experience Required</div>
                            <div>
                                <?= htmlspecialchars($job['experience_required'] ?: 'Not specified') ?>
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="small text-secondary fw-semibold mb-1">Education Requirement</div>
                            <div>
                                <?= htmlspecialchars($job['education_requirement'] ?: 'Not specified') ?>
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="small text-secondary fw-semibold mb-1">Salary Range</div>
                            <div>
                                <?= htmlspecialchars($job['salary_range'] ?: 'Not specified') ?>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-2 flex-wrap">
                        <a href="/jobs/matches?id=<?= $job['id'] ?>" class="btn btn-outline-primary rounded-pill px-4">
                            View Matches
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>