<div class="container-fluid px-0">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
        <div>
            <h1 class="page-title mb-1">Post New Job</h1>
            <p class="page-subtitle mb-0">Create a job manually or simulate OCR extraction from a flyer upload.</p>
        </div>

        <a href="/jobs" class="btn btn-outline-secondary rounded-pill px-4">
            Back to Jobs
        </a>
    </div>

    <?php if (!empty($uploadSuccess)): ?>
        <div class="alert alert-success border-0 rounded-4 mb-4">
            <?= htmlspecialchars($uploadSuccess) ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($uploadErrors)): ?>
        <div class="alert alert-danger border-0 rounded-4 mb-4">
            <div class="fw-semibold mb-2">Upload Error:</div>
            <ul class="mb-0 ps-3">
                <?php foreach ($uploadErrors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger border-0 rounded-4 mb-4">
            <div class="fw-semibold mb-2">Please fix the following:</div>
            <ul class="mb-0 ps-3">
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="row g-4">
        <div class="col-12 col-xl-4">
            <div class="panel-card h-100">
                <div class="panel-title">Upload Job Flyer</div>
                <p class="text-secondary mb-3">
                    Supported formats: JPG, JPEG, PNG, PDF. The system will simulate OCR and prefill the job form.
                </p>

                <form method="POST" action="/post-job/upload" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Select Flyer File</label>
                        <input type="file" name="job_flyer" class="form-control" accept=".jpg,.jpeg,.png,.pdf">
                    </div>

                    <button type="submit" class="btn btn-primary rounded-pill px-4">
                        Upload and Extract
                    </button>
                </form>

                <?php if (!empty($extracted)): ?>
                    <hr class="my-4">

                    <div class="small text-secondary fw-semibold mb-1">Uploaded File</div>
                    <div class="mb-2"><?= htmlspecialchars($extracted['original_flyer_name'] ?? $extracted['flyer_name']) ?>
                    </div>

                    <div class="small text-secondary fw-semibold mb-1">Extraction Status</div>
                    <div class="text-success">Fields extracted and ready for review.</div>
                <?php endif; ?>
            </div>
        </div>

        <div class="col-12 col-xl-8">
            <div class="panel-card">
                <div class="panel-title">
                    <?= !empty($extracted) ? 'Extracted Job Details (Editable)' : 'Manual Job Entry' ?>
                </div>

                <form method="POST" action="/post-job">
                    <input type="hidden" name="source" value="<?= !empty($extracted) ? 'flyer' : 'manual' ?>">
                    <input type="hidden" name="flyer_name"
                        value="<?= htmlspecialchars($extracted['flyer_name'] ?? '') ?>">

                    <div class="row g-4">
                        <div class="col-12 col-md-6">
                            <label class="form-label fw-semibold">Job Title</label>
                            <input type="text" name="title" class="form-control"
                                value="<?= htmlspecialchars($old['title'] ?? $extracted['title'] ?? '') ?>"
                                placeholder="Enter job title">
                        </div>

                        <div class="col-12 col-md-6">
                            <label class="form-label fw-semibold">Company Name</label>
                            <input type="text" name="company_name" class="form-control"
                                value="<?= htmlspecialchars($old['company_name'] ?? $extracted['company_name'] ?? '') ?>"
                                placeholder="Enter company name">
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold">Job Description</label>
                            <textarea name="description" class="form-control" rows="4"
                                placeholder="Enter job description"><?= htmlspecialchars($old['description'] ?? $extracted['description'] ?? '') ?></textarea>
                        </div>

                        <div class="col-12 col-md-6">
                            <label class="form-label fw-semibold">Required Skills</label>
                            <input type="text" name="required_skills" class="form-control"
                                value="<?= htmlspecialchars($old['required_skills'] ?? $extracted['required_skills'] ?? '') ?>"
                                placeholder="Example: Python, SQL, Excel">
                            <div class="form-text">Separate skills with commas.</div>
                        </div>

                        <div class="col-12 col-md-6">
                            <label class="form-label fw-semibold">Years / Experience Required</label>
                            <input type="text" name="experience_required" class="form-control"
                                value="<?= htmlspecialchars($old['experience_required'] ?? $extracted['experience_required'] ?? '') ?>"
                                placeholder="Example: 2 years">
                        </div>

                        <div class="col-12 col-md-6">
                            <label class="form-label fw-semibold">Education Requirement</label>
                            <input type="text" name="education_requirement" class="form-control"
                                value="<?= htmlspecialchars($old['education_requirement'] ?? $extracted['education_requirement'] ?? '') ?>"
                                placeholder="Example: Bachelor’s Degree">
                        </div>

                        <div class="col-12 col-md-6">
                            <label class="form-label fw-semibold">Location</label>
                            <input type="text" name="location" class="form-control"
                                value="<?= htmlspecialchars($old['location'] ?? $extracted['location'] ?? '') ?>"
                                placeholder="Enter job location">
                        </div>

                        <div class="col-12 col-md-6">
                            <label class="form-label fw-semibold">Employment Type</label>
                            <?php $selectedEmployment = $old['employment_type'] ?? $extracted['employment_type'] ?? ''; ?>
                            <select name="employment_type" class="form-select">
                                <option value="">Select employment type</option>
                                <option value="Full-time" <?= ($selectedEmployment === 'Full-time') ? 'selected' : '' ?>>
                                    Full-time</option>
                                <option value="Part-time" <?= ($selectedEmployment === 'Part-time') ? 'selected' : '' ?>>
                                    Part-time</option>
                                <option value="Internship" <?= ($selectedEmployment === 'Internship') ? 'selected' : '' ?>>
                                    Internship</option>
                            </select>
                        </div>

                        <div class="col-12 col-md-6">
                            <label class="form-label fw-semibold">Salary Range (Optional)</label>
                            <input type="text" name="salary_range" class="form-control"
                                value="<?= htmlspecialchars($old['salary_range'] ?? $extracted['salary_range'] ?? '') ?>"
                                placeholder="Example: ₱20,000 - ₱25,000">
                        </div>
                    </div>

                    <div class="d-flex gap-2 mt-4 flex-wrap">
                        <button type="submit" class="btn btn-primary rounded-pill px-4">
                            Save Job
                        </button>

                        <a href="/jobs" class="btn btn-outline-secondary rounded-pill px-4">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>