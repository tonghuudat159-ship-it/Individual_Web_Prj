<?php
/**
 * Temporary database connection test page
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once '../config/app.php';
require_once '../config/database.php';
require_once '../app/helpers/url.php';

$counts = [];
$connectionSuccess = false;
$errorMessage = '';

$tables = [
    'users',
    'categories',
    'instructors',
    'courses',
    'course_lessons',
    'locations',
    'course_locations',
];

try {
    $pdo = getPDO();
    $connectionSuccess = true;

    foreach ($tables as $table) {
        $statement = $pdo->query("SELECT COUNT(*) AS total_rows FROM {$table}");
        $result = $statement->fetch();
        $counts[$table] = $result['total_rows'] ?? 0;
    }
} catch (PDOException $exception) {
    $errorMessage = $exception->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DatEdu Database Test</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f7fb;
            color: #1f2937;
            margin: 0;
            padding: 32px 16px;
        }

        .container {
            max-width: 760px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 12px 30px rgba(15, 23, 42, 0.08);
            padding: 32px;
        }

        h1 {
            margin-top: 0;
            font-size: 28px;
        }

        .message {
            padding: 14px 16px;
            border-radius: 8px;
            margin-bottom: 24px;
        }

        .message.success {
            background: #ecfdf5;
            color: #166534;
            border: 1px solid #bbf7d0;
        }

        .message.error {
            background: #fef2f2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 24px;
        }

        th,
        td {
            padding: 12px 14px;
            border-bottom: 1px solid #e5e7eb;
            text-align: left;
        }

        th {
            background: #f9fafb;
        }

        a {
            color: #2563eb;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>DatEdu Database Connection Test</h1>

        <?php if ($connectionSuccess): ?>
            <div class="message success">
                Database connection successful.
            </div>

            <table>
                <thead>
                    <tr>
                        <th>Table Name</th>
                        <th>Row Count</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($counts as $table => $count): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($table); ?></td>
                            <td><?php echo (int) $count; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="message error">
                <strong>Database connection failed.</strong>
                <?php if ($errorMessage !== ''): ?>
                    <div style="margin-top: 8px;"><?php echo htmlspecialchars($errorMessage); ?></div>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <a href="<?php echo base_url('index.php'); ?>">Back to Home</a>
    </div>
</body>
</html>
