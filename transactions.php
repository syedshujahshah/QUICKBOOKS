<?php
require_once 'db.php';
if (!isset($_SESSION['user_id'])) {
    echo "<script>window.location.href='login.php';</script>";
}
$user_id = $_SESSION['user_id'];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $type = $_POST['type'];
    $category = $_POST['category'];
    $amount = $_POST['amount'];
    $description = $_POST['description'];
    $stmt = $conn->prepare("INSERT INTO transactions (user_id, type, category, amount, description) VALUES (?, ?, ?, ?, ?)");
    if ($stmt->execute([$user_id, $type, $category, $amount, $description])) {
        echo "<script>alert('Transaction added!');</script>";
    }
}
$transactions = $conn->query("SELECT * FROM transactions WHERE user_id = $user_id ORDER BY created_at DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transactions - QuickBooks Clone</title>
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
        .form-container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input, .form-group select, .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .btn {
            padding: 10px 20px;
            background: #3498db;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn:hover {
            background: #2980b9;
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
        <h1>Transactions</h1>
        <div class="form-container">
            <h2>Add Transaction</h2>
            <form method="POST">
                <div class="form-group">
                    <label for="type">Type</label>
                    <select id="type" name="type" required>
                        <option value="income">Income</option>
                        <option value="expense">Expense</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="category">Category</label>
                    <input type="text" id="category" name="category" required>
                </div>
                <div class="form-group">
                    <label for="amount">Amount</label>
                    <input type="number" id="amount" name="amount" step="0.01" required>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description"></textarea>
                </div>
                <button type="submit" class="btn">Add Transaction</button>
            </form>
        </div>
        <h2>Transaction List</h2>
        <table>
            <tr>
                <th>Type</th>
                <th>Category</th>
                <th>Amount</th>
                <th>Description</th>
                <th>Date</th>
            </tr>
            <?php foreach ($transactions as $t): ?>
            <tr>
                <td><?php echo $t['type']; ?></td>
                <td><?php echo $t['category']; ?></td>
                <td>$<?php echo number_format($t['amount'], 2); ?></td>
                <td><?php echo $t['description'] ?: '-'; ?></td>
                <td><?php echo $t['created_at']; ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>
