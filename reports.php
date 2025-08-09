<?php
require_once 'db.php';
if (!isset($_SESSION['user_id'])) {
    echo "<script>window.location.href='login.php';</script>";
}
$user_id = $_SESSION['user_id'];
$monthly = $conn->query("SELECT MONTH(created_at) as month, SUM(amount) as total, type FROM transactions WHERE user_id = $user_id GROUP BY MONTH(created_at), type")->fetchAll();
$yearly = $conn->query("SELECT YEAR(created_at) as year, SUM(amount) as total, type FROM transactions WHERE user_id = $user_id GROUP BY YEAR(created_at), type")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports - QuickBooks Clone</title>
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            margin: 0;
            background: #f0f4f8;
        }
        .sidebar {
            width: 250px;
            background: #2c3e50;
            color: white;
            position: fixed;
            height: 100%;
            padding: 20px;
        }
        .sidebar a {
            color: white;
            display: block;
            padding: 10px;
            text-decoration: none;
        }
        .sidebar a:hover {
            background: #3498db;
        }
        .main {
            margin-left: 270px;
            padding: 20px;
        }
        canvas {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            max-width: 600px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background: #3498db;
            color: white;
        }
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: static;
            }
            .main {
                margin-left: 0;
            }
            canvas {
                max-width: 100%;
            }
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('financeChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Income', 'Expense'],
                    datasets: [{
                        label: 'Monthly Summary',
                        data: [<?php echo $monthly[0]['total'] ?? 0; ?>, <?php echo $monthly[1]['total'] ?? 0; ?>],
                        backgroundColor: ['#3498db', '#e74c3c'],
                    }]
                },
                options: {
                    scales: {
                        y: { beginAtZero: true }
                    }
                }
            });
        });
    </script>
</head>
<body>
    <div class="sidebar">
        <h2>QuickBooks Clone</h2>
        <a href="#" onclick="window.location.href='dashboard.php'">Dashboard</a>
        <a href="#" onclick="window.location.href='invoices.php'">Invoices</a>
        <a href="#" onclick="window.location.href='transactions.php'">Transactions</a>
        <a href="#" onclick="window.location.href='reports.php'">Reports</a>
        <a href="#" onclick="window.location.href='profile.php'">Profile</a>
        <a href="#" onclick="window.location.href='logout.php'">Logout</a>
    </div>
    <div class="main">
        <h1>Financial Reports</h1>
        <h2>Monthly Summary</h2>
        <canvas id="financeChart"></canvas>
        <h2>Yearly Summary</h2>
        <table>
            <tr>
                <th>Year</th>
                <th>Type</th>
                <th>Total</th>
            </tr>
            <?php foreach ($yearly as $y): ?>
            <tr>
                <td><?php echo $y['year']; ?></td>
                <td><?php echo $y['type']; ?></td>
                <td>$<?php echo number_format($y['total'], 2); ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>
