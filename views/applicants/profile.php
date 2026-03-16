<div class="container-fluid px-0">
    <div class="mb-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div>
            <h1 class="page-title mb-1">Applicant Profile</h1>
            <p class="page-subtitle mb-0">Detailed applicant information.</p>
        </div>

        <a href="/applicants" class="btn btn-outline-secondary rounded-pill px-4">
            Back to Applicants
        </a>
    </div>

    <div class="row g-4">
        <div class="col-12 col-lg-4">
            <div class="panel-card h-100">
                <div class="text-center mb-4">
    <?php if (!empty($applicant['photo_url'])): ?>
                        <img src="<?= htmlspecialchars($applicant['photo_url']) ?>" alt="Applicant Photo"
                            style="width:72px;height:72px;border-radius:50%;object-fit:cover;" class="mb-3">
                    <?php else: ?>
                        <div class="avatar mx-auto mb-3" style="width:72px;height:72px;font-size:1.2rem;">
                            <?= htmlspecialchars(strtoupper(substr($applicant['full_name'], 0, 1))) ?>
                        </div>
                    <?php endif; ?>
                
                    <div class="item-title">
                        <?= htmlspecialchars($applicant['full_name']) ?>
                    </div>
                    <div class="item-subtitle">
                        <?= htmlspecialchars(!empty($applicant['job_preferred']) ? implode(', ', $applicant['job_preferred']) : 'No preferred job') ?>
                    </div>
                </div>2

                <div class="mb-3">
                    <div class="small text-secondary fw-semibold mb-1">Email</div>
                    <div>
                        <?= htmlspecialchars($applicant['email'] ?: 'Not provided') ?>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="small text-secondary fw-semibold mb-1">Phone</div>
                    <div>
                        <?= htmlspecialchars($applicant['phone'] ?: 'Not provided') ?>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="small text-secondary fw-semibold mb-1">Location</div>
                    <div>
                        <?= htmlspecialchars($applicant['location'] ?: 'Not specified') ?>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="small text-secondary fw-semibold mb-1">Preferred Job</div>
                    <div>
                        <?= htmlspecialchars(!empty($applicant['job_preferred']) ? implode(', ', $applicant['job_preferred']) : 'No preferred job') ?>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="small text-secondary fw-semibold mb-1">Current Status</div>
                    <div>
                        <?php if (!empty($applicant['is_hired'])): ?>
                            <span class="badge bg-success-subtle text-success rounded-pill px-3 py-2">Hired</span>
                        <?php else: ?>
                            <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-2">Available</span>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="mt-4">
                    <?php if (!empty($applicant['resume_file_url'])): ?>
                        <a href="<?= htmlspecialchars($applicant['resume_file_url']) ?>" target="_blank"
                            class="btn btn-primary w-100 rounded-pill">
                            View Resume
                        </a>
                    <?php else: ?>
                        <button class="btn btn-secondary w-100 rounded-pill" type="button" disabled>
                            No Resume Uploaded
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-4">
            <div class="panel-card h-100">
                <div class="panel-title">Qualifications</div>

                <div class="mb-3">
                    <div class="small text-secondary fw-semibold mb-2">Skills</div>
                    <div class="d-flex flex-wrap gap-2">
                        <?php if (!empty($applicant['skills'])): ?>
                            <?php foreach ($applicant['skills'] as $skill): ?>
                                <span class="skill-badge">
                                    <?= htmlspecialchars($skill) ?>
                                </span>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <span class="text-secondary">No skills listed</span>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="small text-secondary fw-semibold mb-1">Education</div>
                    <div>
                        <?= htmlspecialchars($applicant['education'] ?: 'Not specified') ?>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="small text-secondary fw-semibold mb-1">Education Level</div>
                    <div>
                        <?= htmlspecialchars($applicant['education_level'] ?: 'Not specified') ?>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="small text-secondary fw-semibold mb-1">Experience</div>
                    <div>
                        <?= htmlspecialchars($applicant['experience'] ?: 'Not specified') ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-4">
            <div class="panel-card h-100">
                <div class="panel-title">Applicant Summary</div>

                <div class="mb-3">
                    <div class="small text-secondary fw-semibold mb-1">Resume Summary</div>
                    <div>
                        <?= htmlspecialchars($applicant['resume_summary'] ?: 'No summary provided.') ?>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="small text-secondary fw-semibold mb-1">Applicant ID</div>
                    <div>#
                        <?= htmlspecialchars((string) $applicant['id']) ?>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="small text-secondary fw-semibold mb-1">Email Availability</div>
                    <div>
                        <?= !empty($applicant['email']) ? 'Has email address' : 'No email provided' ?>
                    </div>
                </div>

                <div>
                    <div class="small text-secondary fw-semibold mb-1">Record State</div>
                    <div>
                        <?= !empty($applicant['is_hired']) ? 'Already placed/hired' : 'Still available for matching' ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>