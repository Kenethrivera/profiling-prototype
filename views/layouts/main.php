<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle ?? 'BESU Jobs') ?></title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
    :root {
        --bg: #f6f7fb;
        --panel: #ffffff;
        --border: #e9edf3;
        --text: #0f172a;
        --muted: #64748b;
        --primary: #2563eb;
        --sidebar-width: 254px;
        --radius-lg: 20px;
        --radius-md: 16px;
        --radius-sm: 12px;
        --shadow-soft: 0 1px 2px rgba(15, 23, 42, 0.03);
    }

    body {
        background: var(--bg);
        color: var(--text);
        font-family: "Segoe UI", Arial, sans-serif;
        font-size: 16px;
    }

    .app-shell {
        min-height: 100vh;
        display: flex;
    }

    .sidebar {
        width: var(--sidebar-width);
        background: var(--panel);
        border-right: 1px solid var(--border);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        position: sticky;
        top: 0;
        height: 100vh;
    }

    .sidebar-top {
        padding: 18px 14px;
    }

    .brand {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 8px 10px 18px;
        border-bottom: 1px solid var(--border);
        margin-bottom: 16px;
    }

    .brand-logo {
        width: 28px;
        height: 28px;
        border-radius: 9px;
        display: grid;
        place-items: center;
        background: #eef4ff;
        color: var(--primary);
        font-size: 14px;
    }

    .brand-name {
        font-size: 1.05rem;
        font-weight: 700;
        letter-spacing: -0.01em;
        margin: 0;
    }

    .nav-stack {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .sidebar-link {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 14px;
        border-radius: 14px;
        text-decoration: none;
        color: #334155;
        font-weight: 600;
        font-size: 0.98rem;
        transition: all 0.15s ease;
    }

    .sidebar-link:hover {
        background: #f8fafc;
        color: #0f172a;
    }

    .sidebar-link.active {
        background: #eef4ff;
        color: var(--primary);
    }

    .sidebar-link i {
        font-size: 0.95rem;
        width: 18px;
    }

    .sidebar-bottom {
        padding: 16px 14px;
        border-top: 1px solid var(--border);
    }

    .logout-btn {
        width: 100%;
        border-radius: 14px;
        padding: 12px 14px;
        font-weight: 600;
        font-size: 0.96rem;
        background: #fff;
        border: 1px solid var(--border);
        color: #111827;
        text-align: left;
    }

    .logout-btn:hover {
        background: #f8fafc;
    }

    .main-content {
        flex: 1;
        padding: 32px;
    }

    .page-title {
        font-size: 2rem;
        font-weight: 700;
        letter-spacing: -0.02em;
        margin-bottom: 6px;
        line-height: 1.15;
    }

    .page-subtitle {
        color: var(--muted);
        font-size: 0.98rem;
        font-weight: 400;
        margin-bottom: 26px;
    }

    .stat-card,
    .panel-card,
    .inner-card {
        background: var(--panel);
        border: 1px solid var(--border);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-soft);
    }

    .stat-card {
        padding: 24px;
        height: 100%;
    }

    .stat-label {
        font-size: 0.98rem;
        font-weight: 600;
        color: #334155;
        margin-bottom: 22px;
    }

    .stat-icon {
        color: #94a3b8 !important;
        font-size: 1rem;
    }

    .stat-value {
        font-size: 2rem;
        font-weight: 700;
        letter-spacing: -0.02em;
        line-height: 1;
        margin-bottom: 8px;
    }

    .stat-subtext {
        color: var(--muted);
        font-size: 0.96rem;
        font-weight: 400;
    }

    .panel-card {
        padding: 24px;
        height: 100%;
    }

    .panel-title {
        font-size: 1.2rem;
        font-weight: 700;
        letter-spacing: -0.01em;
        margin-bottom: 18px;
        line-height: 1.25;
    }

    .inner-card {
        padding: 18px;
        margin-bottom: 16px;
        border-radius: 18px;
    }

    .inner-card:last-child {
        margin-bottom: 0;
    }

    .item-title {
        font-size: 1.05rem;
        font-weight: 700;
        letter-spacing: -0.01em;
        margin-bottom: 2px;
        line-height: 1.3;
    }

    .item-subtitle {
        color: var(--muted);
        font-size: 0.96rem;
        font-weight: 400;
        margin-bottom: 12px;
    }

    .item-link {
        color: var(--primary);
        text-decoration: none;
        font-weight: 600;
        font-size: 0.95rem;
    }

    .item-link:hover {
        text-decoration: underline;
    }

    .item-date {
        color: var(--muted);
        font-size: 0.92rem;
        font-weight: 400;
    }

    .skill-badge {
        background: #f8fafc;
        color: #0f172a;
        border: 1px solid #e5e7eb;
        border-radius: 999px;
        padding: 5px 11px;
        font-size: 0.85rem;
        font-weight: 500;
    }

    .avatar {
        width: 52px;
        height: 52px;
        border-radius: 50%;
        background: #dbeafe;
        color: #1d4ed8;
        display: grid;
        place-items: center;
        font-weight: 700;
        font-size: 0.95rem;
        flex-shrink: 0;
    }

    .applicant-block {
        display: flex;
        gap: 14px;
        align-items: flex-start;
    }

    @media (max-width: 1199.98px) {
        .main-content {
            padding: 24px 20px;
        }

        .page-title {
            font-size: 1.75rem;
        }

        .panel-title {
            font-size: 1.12rem;
        }
    }

    @media (max-width: 991.98px) {
        .app-shell {
            flex-direction: column;
        }

        .sidebar {
            width: 100%;
            height: auto;
            position: static;
        }

        .main-content {
            padding: 20px 16px 28px;
        }
    }
</style>
</head>

<body>
    <div class="app-shell">
        <?php require __DIR__ . '/../partials/sidebar.php'; ?>

        <main class="main-content w-100">
            <?php require $view; ?>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>