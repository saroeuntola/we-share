<?php
include('../admin/lib/permission.php');
OnlyRolesAdmin();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$root = $_SERVER['DOCUMENT_ROOT'];



$csv_file = __DIR__ . '/../log/visitors.csv';

if (isset($_POST['delete_logs'])) {
    if (file_exists($csv_file)) {

        file_put_contents($csv_file, '');
    }
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

$rows = [];
if (file_exists($csv_file) && ($handle = fopen($csv_file, 'r')) !== false) {
    while (($data = fgetcsv($handle, 1000, ",")) !== false) {
        $rows[] = $data;
    }
    fclose($handle);
}

$rows = array_reverse($rows);
$total_visitors = count($rows);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visitor Logs</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .container {
            max-width: 100%;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.95);
            min-height: 100vh;
            backdrop-filter: blur(10px);
        }

        .header {
            background: linear-gradient(135deg, #2c3e50, #34495e);
            color: white;
            padding: 30px 40px;
            text-align: center;
        }

        .header h1 {
            font-size: 2.5rem;
            margin-bottom: 10px;
            font-weight: 300;
        }

        .stats {
            background: rgba(52, 152, 219, 0.1);
            padding: 20px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #ecf0f1;
        }

        .total-visitors {
            font-size: 1.2rem;
            color: #2c3e50;
            font-weight: 600;
        }

        .total-visitors .number {
            color: #3498db;
            font-size: 1.5rem;
            font-weight: 700;
        }

        .delete-btn {
            background: linear-gradient(135deg, #e74c3c, #c0392b);
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 25px;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(231, 76, 60, 0.3);
        }

        .delete-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(231, 76, 60, 0.4);
        }

        .content {
            padding: 30px 40px;
        }

        .no-logs {
            text-align: center;
            padding: 60px 0;
            color: #7f8c8d;
            font-size: 1.2rem;
        }

        .no-logs::before {
            content: "📋";
            display: block;
            font-size: 4rem;
            margin-bottom: 20px;
        }

        .table-container {
            overflow-x: auto;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            font-size: 0.9rem;
        }

        th {
            background: linear-gradient(135deg, #34495e, #2c3e50);
            color: white;
            padding: 18px 15px;
            text-align: left;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 0.85rem;
            position: sticky;
            top: 0;
            z-index: 10;
        }

        td {
            padding: 15px;
            border-bottom: 1px solid #ecf0f1;
            vertical-align: top;
            transition: background-color 0.2s ease;
        }

        tr:hover td {
            background-color: rgba(52, 152, 219, 0.05);
        }

        tr:nth-child(even) td {
            background-color: rgba(149, 165, 166, 0.02);
        }

        .date-cell {
            font-weight: 600;
            color: #2c3e50;
            white-space: nowrap;
            min-width: 140px;
        }

        .ip-cell {
            font-family: 'Courier New', monospace;
            background: rgba(52, 152, 219, 0.1);
            color: #2980b9;
            border-radius: 6px;
            padding: 4px 8px;
            display: inline-block;
            font-weight: 600;
            min-width: 120px;
        }

        .page-cell {
            color: #27ae60;
            font-weight: 500;
            max-width: 200px;
            word-break: break-all;
        }

        .referrer-cell {
            color: #8e44ad;
            max-width: 200px;
            word-break: break-all;
        }

        .user-agent-cell {
            color: #7f8c8d;
            font-size: 0.85rem;
            max-width: 250px;
            line-height: 1.4;
            word-break: break-word;
        }

        .empty-cell {
            color: #bdc3c7;
            font-style: italic;
        }

        @media (max-width: 768px) {
            body {
                padding: 10px;
            }

            .header,
            .stats,
            .content {
                padding: 20px;
            }

            .header h1 {
                font-size: 2rem;
            }

            .stats {
                flex-direction: column;
                gap: 15px;
            }

            th,
            td {
                padding: 10px 8px;
                font-size: 0.8rem;
            }

            .user-agent-cell {
                font-size: 0.75rem;
            }
        }

        .loading-animation {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid #f3f3f3;
            border-top: 3px solid #3498db;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin-left: 10px;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .search-container {
            margin-bottom: 20px;
            position: relative;
        }

        .search-input {
            width: 100%;
            padding: 12px 45px 12px 15px;
            border: 2px solid #ecf0f1;
            border-radius: 25px;
            font-size: 1rem;
            transition: border-color 0.3s ease;
        }

        .search-input:focus {
            outline: none;
            border-color: #3498db;
        }

        .search-icon {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #7f8c8d;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>🌐 Visitor Analytics</h1>
            <p>Real-time visitor tracking and analytics</p>
        </div>

        <div class="stats">
            <div class="total-visitors">
                Total Visitors: <span class="number"><?= $total_visitors ?></span>
            </div>

            <form method="post" onsubmit="return confirm('⚠️ Are you sure you want to delete all logs? This action cannot be undone.');">
                <button type="submit" name="delete_logs" class="delete-btn">
                    🗑️ Delete All Logs
                </button>
            </form>

        </div>

        <div class="content">
            <!-- Search functionality -->
            <div class="search-container">
                <input type="text" class="search-input" placeholder="Search logs by IP, page, or user agent..." id="searchInput">
                <span class="search-icon">🔍</span>
            </div>

            <?php if (empty($rows)): ?>
                <div class="no-logs">
                    No logs yet.
                    <br><small>Logs will appear here once visitors start browsing your site.</small>
                </div>
            <?php else: ?>
                <div class="table-container">
                    <table id="logsTable">
                        <thead>
                            <tr>
                                <th>📅 Date & Time</th>
                                <th>🌍 IP Address</th>
                                <th>📄 Page</th>
                                <th>🔗 Referrer</th>
                                <th>💻 User Agent</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($rows as $r): ?>
                                <tr>
                                    <td class="date-cell"><?= htmlspecialchars($r[0]) ?></td>
                                    <td><span class="ip-cell"><?= htmlspecialchars($r[1]) ?></span></td>
                                    <td class="page-cell"><?= htmlspecialchars($r[2]) ?></td>
                                    <td class="referrer-cell"><?= htmlspecialchars($r[3]) ?></td>
                                    <td class="user-agent-cell"><?= htmlspecialchars($r[4]) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script>
        document.getElementById('searchInput').addEventListener('keyup', function() {
            const searchTerm = this.value.toLowerCase();
            const tableRows = document.querySelectorAll('#logsTable tbody tr');

            tableRows.forEach(row => {
                const text = row.textContent.toLowerCase();
                if (text.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    </script>
</body>

</html>