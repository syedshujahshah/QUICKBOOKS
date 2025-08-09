<?php
require_once 'db.php';
if (!isset($_SESSION['user_id'])) {
    echo "<script>window.location.href='login.php';</script>";
}
$user_id = $_SESSION['user_id'];
$income = $conn->query("SELECT SUM(amount) as total FROM transactions WHERE user_id = $user_id AND type = 'income'")->fetch()['total'] ?? 0;
$expense = $conn->query("SELECT SUM(amount) as total FROM transactions WHERE user_id = $user_id AND type = 'expense'")->fetch()['total'] ?? 0;
$balance = $income - $expense;
$transactions = $conn->query("SELECT * FROM transactions WHERE user_id = $user_id ORDER BY created_at DESC LIMIT 5")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - QuickBooks Clone</title>
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
        .summary {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }
        .card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            width: 200px;
            text-align: center;
        }
        .card h3 {
            margin: 0;
            color: #3498db;
        }
        .transactions {
            margin-top: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 10px;
            overflow: hidden;
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
            .summary {
                flex-direction: column;
            }
        }
    </style>
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
        <h1>Financial Dashboard</h1>
        <div class="summary">
            <div class="card">
                <h3>Income</h3>
                <p>$<?php echo number_format($income, 2); ?></p>
            </div>
            <div class="card">
                <h3>Expenses</h3>
                <p>$<?php echo number_format($expense, 2); ?></p>
            </div>
            <div class="card">
                <h3>Balance</h3>
                <p>$<?php echo number_format($balance, 2); ?></p>
            </div>
        </div>
        <div class="transactions">
            <h2>Recent Transactions</h2>
            <table>
                <tr>
                    <th>Type</th>
                    <th>Category</th>
                    <th>Amount</th>
                    <th>Date</th>
                </tr>
                <?php foreach ($transactions as $t): ?>
                <tr>
                    <td><?php echo $t['type']; ?></td>
                    <td><?php echo $t['category']; ?></td>
                    <td>$<?php echo number_format($t['amount'], 2); ?></td>
                    <td><?php echo $t['created_at']; ?></td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
</body>
</html>
