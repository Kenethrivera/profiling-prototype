<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apply - BESU Jobs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --bg: #f6f7fb;
            --panel: #ffffff;
            --border: #e6ebf2;
            --muted: #7b8aa5;
            --text: #0f172a;
            --primary: #3567e8;
            --primary-soft: #eef4ff;
            --input-bg: #fbfcfe;
            --shadow: 0 10px 30px rgba(15, 23, 42, 0.06);
            }

        body {
            margin: 0;
            background: var(--bg);
            font-family: "Segoe UI", Arial, sans-serif;
            color: var(--text);
        }

        .page-shell {
            min-height: 100vh;
            padding: 42px 18px;
        }

        .page-wrap {
            max-width: 860px;
            margin: 0 auto;
        }

        .page-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 18px;
            gap: 16px;
        }

        .page-title {
            font-size: 2rem;
            font-weight: 700;
            margin: 0;
        }

        .brand {
            color: var(--primary);
            font-weight: 800;
            letter-spacing: 0.08em;
            font-size: 1.15rem;
        }

        .form-card {
            background: var(--panel);
            border: 1px solid var(--border);
            border-radius: 22px;
            overflow: hidden;
            box-shadow: var(--shadow);
        }

        .photo-section {
            padding: 40px 32px 30px;
            border-bottom: 1px solid var(--border);
            text-align: center;
        }

        .photo-label {
            cursor: pointer;
            display: inline-block;
        }

        .avatar-wrap {
            width: 110px;
            height: 110px;
            margin: 0 auto 14px;
            border-radius: 50%;
            background: #edf1f7;
            display: grid;
            place-items: center;
            position: relative;
            color: #97a1b2;
            font-size: 2.2rem;
            overflow: hidden;
        }

        .avatar-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .upload-badge {
            position: absolute;
            right: -2px;
            bottom: 6px;
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: var(--primary);
            color: white;
            display: grid;
            place-items: center;
            font-size: 0.95rem;
            border: 4px solid white;
        }

        .upload-text {
            color: #5f6f8c;
            font-size: 1rem;
        }

        .form-body {
            padding: 28px 40px 0;
        }

        .section-label {
            font-size: 0.84rem;
            font-weight: 800;
            letter-spacing: 0.16em;
            color: #8ca0c4;
            margin-bottom: 16px;
            text-transform: uppercase;
        }

        .section-block {
            margin-bottom: 34px;
        }

        .form-label {
            font-weight: 700;
            color: #324560;
            margin-bottom: 8px;
        }

        .form-control,
        .form-select,
        textarea {
            border-radius: 12px !important;
            border: 1px solid #dbe3ef !important;
            background: #fbfcfe !important;
            min-height: 46px;
            padding: 12px 14px !important;
            box-shadow: none !important;
        }

        textarea.form-control {
            min-height: 110px;
            resize: vertical;
        }

        .preferred-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 18px;
        }

        .preferred-tag {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 12px 16px;
            border-radius: 18px;
            background: #edf4ff;
            color: var(--primary);
            border: 1px solid #d2dfff;
            font-size: 0.98rem;
        }

        .preferred-tag button {
            border: none;
            background: transparent;
            color: var(--primary);
            font-size: 1rem;
            line-height: 1;
            cursor: pointer;
            padding: 0;
        }

        .preferred-input-row {
            display: flex;
            gap: 10px;
        }

        .preferred-add-btn {
            min-width: 60px;
            border: 1px solid #dbe3ef;
            background: #eef3fb;
            border-radius: 12px;
            font-size: 1.8rem;
            color: #506b93;
        }

        .chip-row {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 12px;
        }

        .chip {
            border: 1px solid #d7dfec;
            border-radius: 999px;
            padding: 7px 14px;
            background: #fff;
            color: #5f7393;
            font-size: 0.95rem;
            cursor: pointer;
        }

        .upload-box {
            border: 2px dashed #c8d8f4;
            border-radius: 18px;
            min-height: 140px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 24px;
            color: #415372;
            background: #fcfdff;
            cursor: pointer;
        }

        .submit-bar {
            border-top: 1px solid var(--border);
            background: #fbfcfe;
            padding: 30px 40px;
            margin-top: 8px;
        }

        .submit-btn {
            width: 100%;
            border: none;
            border-radius: 14px;
            background: var(--primary);
            color: white;
            font-weight: 700;
            font-size: 1.05rem;
            padding: 15px 18px;
        }

        .helper {
            color: var(--muted);
            font-size: 0.92rem;
            margin-top: 7px;
        }

        .hidden-input {
            display: none;
        }
    </style>
</head>
<body>
    <div class="page-shell">
        <div class="page-wrap">
            <div class="page-top">
                <h1 class="page-title">Personal Details</h1>
                <div class="brand">BESU JOBS</div>
            </div>

            <?php if (!empty($success)): ?>
                    <div class="alert alert-success mb-3"><?= htmlspecialchars($success) ?></div>
            <?php endif; ?>

            <?php if (!empty($errors)): ?>
                    <div class="alert alert-danger mb-3">
                        <ul class="mb-0 ps-3">
                            <?php foreach ($errors as $error): ?>
                                    <li><?= htmlspecialchars($error) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
            <?php endif; ?>

            <div class="form-card">
                <form method="POST" action="/apply" enctype="multipart/form-data">
                    <div class="photo-section">
                        <label class="photo-label" for="photo">
                            <div class="avatar-wrap" id="avatarPreview">
                                <span id="avatarIcon">👤</span>
                                <div class="upload-badge">📷</div>
                            </div>
                            <div class="upload-text">Upload Photo</div>
                        </label>
                        <input type="file" id="photo" name="photo" class="hidden-input" accept=".jpg,.jpeg,.png,.webp">
                    </div>

                    <div class="form-body">
                        <div class="section-block">
                            <div class="section-label">Personal Information</div>

                            <div class="row g-4">
                                <div class="col-12">
                                    <label class="form-label">Full Name</label>
                                    <input type="text" name="full_name" class="form-control" value="<?= htmlspecialchars($old['full_name'] ?? '') ?>" required>
                                </div>

                                <div class="col-12 col-md-6">
                                    <label class="form-label">Mobile Number</label>
                                    <input type="text" name="phone" class="form-control" value="<?= htmlspecialchars($old['phone'] ?? '') ?>" placeholder="09XXXXXXXXX" required>
                                </div>

                                <div class="col-12 col-md-6">
                                    <label class="form-label">Email Address</label>
                                    <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($old['email'] ?? '') ?>" placeholder="Optional">
                                </div>
                            </div>
                        </div>

                        <div class="section-block">
                            <div class="section-label">Address</div>

                            <div class="row g-4">
                                <div class="col-12">
                                    <label class="form-label">Current Address</label>
                                    <textarea name="location" class="form-control" required><?= htmlspecialchars($old['location'] ?? '') ?></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="section-block">
                            <div class="section-label">Preferred Jobs</div>

                            <div id="preferredTags" class="preferred-tags"></div>

                            <div class="preferred-input-row">
                                <input type="text" id="preferredInput" class="form-control" placeholder="Type a job title...">
                                <button type="button" id="addPreferredBtn" class="preferred-add-btn">+</button>
                            </div>

                            <div class="form-label mt-3 mb-2">Suggestions</div>
                            <div class="chip-row">
                                <span class="chip" data-value="Cashier">Cashier</span>
                                <span class="chip" data-value="Sales Associate">Sales Associate</span>
                                <span class="chip" data-value="Customer Service">Customer Service</span>
                                <span class="chip" data-value="Warehouse Staff">Warehouse Staff</span>
                                <span class="chip" data-value="Office Assistant">Office Assistant</span>
                                <span class="chip" data-value="Receptionist">Receptionist</span>
                                <span class="chip" data-value="Encoder">Encoder</span>
                                <span class="chip" data-value="Delivery Helper">Delivery Helper</span>
                                <span class="chip" data-value="Driver">Driver</span>
                                <span class="chip" data-value="Store Staff">Store Staff</span>
                            </div>

                            <input type="hidden" name="preferred_jobs" id="preferredJobsHidden" value="<?= htmlspecialchars($old['preferred_jobs'] ?? '[]') ?>">
                        </div>

                        <div class="section-block">
                            <div class="section-label">Education</div>

                            <div class="row g-4">
                                <div class="col-12 col-md-6">
                                    <label class="form-label">Education Level</label>
                                    <?php $selectedEducationLevel = $old['education_level'] ?? ''; ?>
                                    <select name="education_level" class="form-select" required>
                                        <option value="">Select education level</option>
                                        <?php
                                        $educationLevels = [
                                            'High School',
                                            'Senior High School',
                                            'Vocational',
                                            'Associate Degree',
                                            'College Undergraduate',
                                            'Bachelor’s Degree'
                                        ];
                                        foreach ($educationLevels as $level):
                                            ?>
                                                <option value="<?= htmlspecialchars($level) ?>" <?= $selectedEducationLevel === $level ? 'selected' : '' ?>>
                                                    <?= htmlspecialchars($level) ?>
                                                </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="col-12 col-md-6">
                                    <label class="form-label">Education Details</label>
                                    <input type="text" name="education" class="form-control" value="<?= htmlspecialchars($old['education'] ?? '') ?>" required>
                                </div>
                            </div>
                        </div>

                        <div class="section-block">
                            <div class="section-label">Skills and Experience</div>

                            <div class="row g-4">
                                <div class="col-12">
                                    <label class="form-label">Skills</label>
                                    <input type="text" name="skills" class="form-control" value="<?= htmlspecialchars($old['skills'] ?? '') ?>" placeholder="Example: Customer Service, Cash Handling, Documentation">
                                    <div class="helper">Separate skills with commas.</div>
                                </div>

                                <div class="col-12">
                                    <label class="form-label">Experience</label>
                                    <textarea name="experience" class="form-control"><?= htmlspecialchars($old['experience'] ?? '') ?></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="section-block">
                            <div class="section-label">Resume</div>
                            <label class="upload-box" for="resume">
                                <div id="resumeText">Click to upload or drag and drop PDF/DOCX</div>
                            </label>
                            <input type="file" id="resume" name="resume" class="hidden-input" accept=".pdf,.doc,.docx">
                        </div>
                    </div>

                    <div class="submit-bar">
                        <button type="submit" class="submit-btn">✓ Save Profile</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const preferredInput = document.getElementById('preferredInput');
        const addPreferredBtn = document.getElementById('addPreferredBtn');
        const preferredTags = document.getElementById('preferredTags');
        const preferredJobsHidden = document.getElementById('preferredJobsHidden');
        let preferredJobs = [];

        try {
            preferredJobs = JSON.parse(preferredJobsHidden.value || '[]');
            if (!Array.isArray(preferredJobs)) preferredJobs = [];
        } catch (e) {
            preferredJobs = [];
        }

        function syncPreferredJobs() {
            preferredJobsHidden.value = JSON.stringify(preferredJobs);
            preferredTags.innerHTML = '';

            preferredJobs.forEach((job, index) => {
                const tag = document.createElement('div');
                tag.className = 'preferred-tag';
                tag.innerHTML = `
                    <span>${job}</span>
                    <button type="button" data-index="${index}">×</button>
                `;
                preferredTags.appendChild(tag);
            });

            preferredTags.querySelectorAll('button').forEach(btn => {
                btn.addEventListener('click', function () {
                    const index = parseInt(this.getAttribute('data-index'));
                    preferredJobs.splice(index, 1);
                    syncPreferredJobs();
                });
            });
        }

        function addPreferredJob(value) {
            const job = value.trim();
            if (!job) return;
            if (preferredJobs.includes(job)) return;

            preferredJobs.push(job);
            preferredInput.value = '';
            syncPreferredJobs();
        }

        addPreferredBtn.addEventListener('click', function () {
            addPreferredJob(preferredInput.value);
        });

        preferredInput.addEventListener('keydown', function (e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                addPreferredJob(preferredInput.value);
            }
        });

        document.querySelectorAll('.chip').forEach(chip => {
            chip.addEventListener('click', function () {
                addPreferredJob(this.getAttribute('data-value'));
            });
        });

        syncPreferredJobs();

        const photoInput = document.getElementById('photo');
        const avatarPreview = document.getElementById('avatarPreview');
        const avatarIcon = document.getElementById('avatarIcon');

        photoInput.addEventListener('change', function () {
            const file = this.files[0];
            if (!file) return;

            const reader = new FileReader();
            reader.onload = function (e) {
                avatarPreview.innerHTML = `<img src="${e.target.result}" alt="Profile Photo"><div class="upload-badge">📷</div>`;
            };
            reader.readAsDataURL(file);
        });

        const resumeInput = document.getElementById('resume');
        const resumeText = document.getElementById('resumeText');

        resumeInput.addEventListener('change', function () {
            const file = this.files[0];
            if (!file) return;
            resumeText.textContent = file.name;
        });
    </script>
</body>
</html>