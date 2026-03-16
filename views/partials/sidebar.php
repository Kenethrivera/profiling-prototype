<?php
$currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

function isActive(string $path, string $currentPath): string
{
    return $path === $currentPath ? 'active' : '';
}
?>

<aside class="sidebar">
    <div class="sidebar-top">
        <div class="brand">
            <div class="brand-logo">
                <i class="bi bi-grid-1x2-fill"></i>
            </div>
            <p class="brand-name">BESU Jobs</p>
        </div>

        <nav class="nav-stack">
            <a class="sidebar-link <?= isActive('/dashboard', $currentPath) ?>" href="/dashboard">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>

            <a class="sidebar-link <?= isActive('/applicants', $currentPath) ?>" href="/applicants">
                <i class="bi bi-people"></i>
                <span>Applicants</span>
            </a>

            <a class="sidebar-link <?= isActive('/jobs', $currentPath) ?>" href="/jobs">
                <i class="bi bi-briefcase"></i>
                <span>Job Listings</span>
            </a>

            <a class="sidebar-link <?= isActive('/post-job', $currentPath) ?>" href="/post-job">
                <i class="bi bi-plus-circle"></i>
                <span>Post New Job</span>
            </a>

            <a class="sidebar-link <?= ($currentPath === '/placements') ? 'active' : '' ?>" href="/placements">
                <i class="bi bi-check-circle"></i>
                <span>Placements</span>
            </a>

            <a class="sidebar-link <?= isActive('/settings', $currentPath) ?>" href="/settings">
                <i class="bi bi-gear"></i>
                <span>Settings</span>
            </a>
        </nav>
    </div>

    <div class="sidebar-bottom">
        <form method="POST" action="/logout" class="m-0">
            <button class="logout-btn" type="submit">
                <i class="bi bi-box-arrow-right me-2"></i>Logout
            </button>
        </form>
    </div>
</aside>