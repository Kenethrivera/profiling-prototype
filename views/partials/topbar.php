<div class="topbar">
    <div class="topbar-title">
        <?= htmlspecialchars($pageTitle ?? 'Dashboard') ?>
    </div>

    <div class="topbar-right">
        <div class="user-badge">
            <?= htmlspecialchars($user['email'] ?? 'Admin') ?>
        </div>

        <form method="POST" action="/logout" style="margin: 0;">
            <button class="logout-btn" type="submit">Logout</button>
        </form>
    </div>
</div>