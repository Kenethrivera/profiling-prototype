<div class="container-fluid px-0">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
        <div>
            <h1 class="page-title mb-1">Job Matches</h1>
            <p class="page-subtitle mb-0">Review applicants matched for this job listing.</p>
        </div>

        <a href="/jobs" class="btn btn-outline-secondary rounded-pill px-4">
            Back to Jobs
        </a>
    </div>

    <div class="panel-card mb-4">
        <div class="row g-3">
            <div class="col-12 col-lg-8">
                <div class="item-title"><?= htmlspecialchars($job['title']) ?></div>
                <div class="item-subtitle mb-2"><?= htmlspecialchars($job['company_name']) ?></div>
                <div class="text-secondary mb-3"><?= htmlspecialchars($job['description']) ?></div>

                <div class="d-flex flex-wrap gap-2 mb-3">
                    <?php if (!empty($job['required_skills'])): ?>
                        <?php foreach ($job['required_skills'] as $skill): ?>
                            <span class="skill-badge"><?= htmlspecialchars($skill) ?></span>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <span class="text-secondary">No required skills listed</span>
                    <?php endif; ?>
                </div>
            </div>

            <div class="col-12 col-lg-4">
                <div class="small text-secondary fw-semibold mb-1">Experience Required</div>
                <div class="mb-3"><?= htmlspecialchars($job['experience_required'] ?: 'Not specified') ?></div>

                <div class="small text-secondary fw-semibold mb-1">Education Requirement</div>
                <div class="mb-3"><?= htmlspecialchars($job['education_requirement'] ?: 'Not specified') ?></div>

                <div class="small text-secondary fw-semibold mb-1">Employment Type</div>
                <div><?= htmlspecialchars($job['employment_type'] ?: 'Not specified') ?></div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <?php if (empty($matches)): ?>
            <div class="col-12">
                <div class="panel-card text-center">
                    <div class="text-secondary">No matches found for this job.</div>
                </div>
            </div>
        <?php endif; ?>

        <?php foreach ($matches as $match): ?>
            <?php
            $applicant = $match['applicant'];
            $score = $match['match_percent'];

            $badgeClass = 'bg-danger-subtle text-danger';
            if ($score >= 80) {
                $badgeClass = 'bg-success-subtle text-success';
            } elseif ($score >= 60) {
                $badgeClass = 'bg-warning-subtle text-warning';
            }
            ?>
            <div class="col-12">
                <div class="panel-card">
                    <div class="d-flex justify-content-between align-items-start flex-wrap gap-3 mb-3">
                        <div class="d-flex gap-3 align-items-start">
                            <div class="avatar">
                                <?= htmlspecialchars(strtoupper(substr($applicant['full_name'], 0, 1))) ?>
                            </div>

                            <div>
                                <div class="item-title"><?= htmlspecialchars($applicant['full_name']) ?></div>
                                <div class="item-subtitle mb-1">
                                    <?= htmlspecialchars(!empty($applicant['job_preferred']) ? implode(', ', $applicant['job_preferred']) : 'Not specified') ?>
                                </div>
                                <div class="text-secondary small">
                                    <?= htmlspecialchars($applicant['location'] ?: 'No location') ?>
                                </div>
                            </div>
                        </div>

                        <span class="badge <?= $badgeClass ?> rounded-pill px-3 py-2">
                            <?= htmlspecialchars((string) $score) ?>% Match
                        </span>
                    </div>

                    <div class="row g-4">
                        <div class="col-12 col-lg-4">
                            <div class="small text-secondary fw-semibold mb-2">Matching Skills</div>
                            <div class="d-flex flex-wrap gap-2">
                                <?php if (!empty($match['matching_skills'])): ?>
                                    <?php foreach ($match['matching_skills'] as $skill): ?>
                                        <span class="skill-badge"><?= htmlspecialchars($skill) ?></span>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <span class="text-secondary">No matching skills</span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="col-12 col-lg-4">
                            <div class="small text-secondary fw-semibold mb-2">Missing Skills</div>
                            <div class="d-flex flex-wrap gap-2">
                                <?php if (!empty($match['missing_skills'])): ?>
                                    <?php foreach ($match['missing_skills'] as $skill): ?>
                                        <span class="skill-badge"><?= htmlspecialchars($skill) ?></span>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <span class="text-secondary">No missing skills</span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="col-12 col-lg-4">
                            <div class="small text-secondary fw-semibold mb-2">AI Recommendation</div>
                            <div class="text-secondary mb-3">
                                <?= htmlspecialchars($match['ai_explanation']) ?>
                            </div>

                            <a href="/applicants/profile?id=<?= $applicant['id'] ?>" class="btn btn-primary rounded-pill px-4">
                                View Profile
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>