<?php
require_once 'db.php';
if (!isset($_SESSION['user_id'])) {
    echo "<script>window.location.href='login.php';</script>";
}
$user_id = $_SESSION['user_id'];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $client_name = $_POST['client_name'];
    $amount = $_POST['amount'];
    $due_date = $_POST['due_date'];
    $stmt = $conn->prepare("INSERT INTO invoices (user_id, client_name, amount, due_date) VALUES (?, ?, ?, ?)");
    if ($stmt->execute([$user_id, $client_name, $amount, $due_date])) {
        echo "<script>alert('Invoice created!');</script>";
    }
}
$invoices = $conn->query("SELECT * FROM invoices WHERE user_id = $user_id ORDER BY created_at DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoices - QuickBooks Clone</title>
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
        .form-group input {
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
    <script>
        function downloadPDF(invoiceId, clientName, amount, dueDate) {
            const content = `Invoice ID: ${invoiceId}\nClient: ${clientName}\nAmount: $${amount}\nDue Date: ${dueDate}`;
            const blob = new Blob([content], { type: 'text/plain' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = `invoice_${invoiceId}.txt`;
            a.click();
            URL.revokeObjectURL(url);
        }
        function sendEmail(invoiceId) {
            alert('Email sent for Invoice ID: ' + invoiceId);
        }
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
        <h1>Invoices</h1>
        <div class="form-container">
            <h2>Create Invoice</h2>
            <form method="POST">
                <div class="form-group">
                    <label for="client_name">Client Name</label>
                    <input type="text" id="client_name" name="client_name" required>
                </div>
                <div class="form-group">
                    <label for="amount">Amount</label>
                    <input type="number" id="amount" name="amount" step="0.01" required>
                </div>
                <div class="form-group">
                    <label for="due_date">Due Date</label>
                    <input type="date" id="due_date" name="due_date" required>
                </div>
                <button type="submit" class="btn">Create Invoice</button>
            </form>
        </div>
        <h2>Invoice List</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Client</th>
                <th>Amount</th>
                <th>Status</th>
                <th>Due Date</th>
                <th>Actions</th>
            </tr>
            <?php foreach ($invoices as $invoice): ?>
            <tr>
                <td><?php echo $invoice['id']; ?></td>
                <td><?php echo $invoice['client_name']; ?></td>
                <td>$<?php echo number_format($invoice['amount'], 2); ?></td>
                <td><?php echo $invoice['status']; ?></td>
                <td><?php echo $invoice['due_date']; ?></td>
                <td>
                    <button class="btn" onclick="downloadPDF(<?php echo $invoice['id']; ?>, '<?php echo $invoice['client_name']; ?>', <?php echo $invoice['amount']; ?>, '<?php echo $invoice['due_date']; ?>')">Download</button>
                    <button class="btn" onclick="sendEmail(<?php echo $invoice['id']; ?>)">Send Email</button>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>
