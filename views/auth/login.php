<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - BESU Job Fair Management System</title>
    <style>
        * {
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            margin: 0;
            background: #f4f7fb;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        .card {
            width: 100%;
            max-width: 420px;
            background: white;
            border-radius: 16px;
            padding: 32px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, .08);
        }

        .title {
            margin: 0 0 8px;
            color: #1d4ed8;
            font-size: 28px;
            font-weight: bold;
        }

        .subtitle {
            margin: 0 0 24px;
            color: #6b7280;
            font-size: 14px;
        }

        .field {
            margin-bottom: 16px;
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-size: 14px;
            color: #374151;
            font-weight: 600;
        }

        input {
            width: 100%;
            padding: 12px 14px;
            border: 1px solid #d1d5db;
            border-radius: 10px;
            font-size: 14px;
        }

        input:focus {
            outline: none;
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, .12);
        }

        .btn {
            width: 100%;
            border: none;
            background: #2563eb;
            color: white;
            padding: 12px 14px;
            border-radius: 10px;
            font-size: 15px;
            font-weight: bold;
            cursor: pointer;
        }

        .btn:hover {
            background: #1d4ed8;
        }

        .error {
            background: #fee2e2;
            color: #991b1b;
            border-radius: 10px;
            padding: 10px 12px;
            margin-bottom: 16px;
            font-size: 14px;
        }
    </style>
</head>

<body>
    <div class="card">
        <h1 class="title">BESU Canlalay Admin </h1>
        <p class="subtitle">Sign in to manage jobs, applicants, and AI match results.</p>

        <?php if (!empty($error)): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="POST" action="/login">
            <div class="field">
                <label for="email">Email</label>
                <input id="email" name="email" type="email" required>
            </div>

            <div class="field">
                <label for="password">Password</label>
                <input id="password" name="password" type="password" required>
            </div>

            <button class="btn" type="submit">Login</button>
        </form>
    </div>
</body>

</html>