<div class="container-fluid px-0">
    <div class="mb-4">
        <h1 class="page-title">Dashboard</h1>
        <p class="page-subtitle">Welcome back! Here's your job fair overview.</p>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-12 col-md-6 col-xl-3">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-start">
                    <div class="stat-label">Total Applicants</div>
                    <i class="bi bi-people stat-icon"></i>
                </div>
                <div class="stat-value">
                    <?= htmlspecialchars((string) $totalApplicants) ?>
                </div>
                <div class="stat-subtext">All applicant records</div>
            </div>
        </div>

        <div class="col-12 col-md-6 col-xl-3">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-start">
                    <div class="stat-label">Available Applicants</div>
                    <i class="bi bi-person-check stat-icon"></i>
                </div>
                <div class="stat-value">
                    <?= htmlspecialchars((string) $availableApplicants) ?>
                </div>
                <div class="stat-subtext">Not yet hired</div>
            </div>
        </div>

        <div class="col-12 col-md-6 col-xl-3">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-start">
                    <div class="stat-label">Active Jobs</div>
                    <i class="bi bi-briefcase stat-icon"></i>
                </div>
                <div class="stat-value">
                    <?= htmlspecialchars((string) $activeJobs) ?>
                </div>
                <div class="stat-subtext">Posted jobs</div>
            </div>
        </div>

        <div class="col-12 col-md-6 col-xl-3">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-start">
                    <div class="stat-label">Hired Placements</div>
                    <i class="bi bi-check-circle stat-icon"></i>
                </div>
                <div class="stat-value">
                    <?= htmlspecialchars((string) $hiredCount) ?>
                </div>
                <div class="stat-subtext">Successful hires</div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-12 col-xl-6">
            <div class="panel-card">
                <h2 class="panel-title">Recently Added Jobs</h2>

                <?php if (empty($recentJobs)): ?>
                    <div class="text-secondary">No recent jobs found.</div>
                <?php else: ?>
                    <?php foreach ($recentJobs as $job): ?>
                        <div class="inner-card">
                            <div class="d-flex justify-content-between align-items-start gap-3 mb-2">
                                <div>
                                    <div class="item-title">
                                        <?= htmlspecialchars($job['title']) ?>
                                    </div>
                                    <div class="item-subtitle">
                                        <?= htmlspecialchars($job['company_name']) ?>
                                    </div>
                                </div>

                                <div class="text-end">
                                    <div class="item-date">
                                        <?= htmlspecialchars($job['location'] ?: 'No location') ?>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex flex-wrap gap-2">
                                <?php foreach (array_slice($job['required_skills'], 0, 4) as $skill): ?>
                                    <span class="skill-badge">
                                        <?= htmlspecialchars($skill) ?>
                                    </span>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <div class="col-12 col-xl-6">
            <div class="panel-card">
                <h2 class="panel-title">Recently Registered Applicants</h2>

                <?php if (empty($recentApplicants)): ?>
                    <div class="text-secondary">No recent applicants found.</div>
                <?php else: ?>
                    <?php foreach ($recentApplicants as $applicant): ?>
                        <div class="inner-card">
                            <div class="applicant-block">
                                <div class="avatar">
                                    <?= htmlspecialchars(strtoupper(substr($applicant['full_name'], 0, 1))) ?>
                                </div>

                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-start gap-3 mb-2">
                                        <div>
                                            <div class="item-title">
                                                <?= htmlspecialchars($applicant['full_name']) ?>
                                            </div>
                                            <div class="item-subtitle">
                                                <?= htmlspecialchars(!empty($applicant['job_preferred']) ? implode(', ', $applicant['job_preferred']) : 'Not specified') ?>
                                            </div>
                                        </div>

                                        <div class="item-date">
                                            <?= !empty($applicant['is_hired']) ? 'Hired' : 'Available' ?>
                                        </div>
                                    </div>

                                    <div class="d-flex flex-wrap gap-2">
                                        <?php foreach (array_slice($applicant['skills'], 0, 4) as $skill): ?>
                                            <span class="skill-badge">
                                                <?= htmlspecialchars($skill) ?>
                                            </span>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>