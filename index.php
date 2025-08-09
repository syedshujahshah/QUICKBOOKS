<?php
require_once 'db.php';
if (isset($_SESSION['user_id'])) {
    echo "<script>window.location.href='dashboard.php';</script>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QuickBooks Clone - Home</title>
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            margin: 0;
            background: linear-gradient(135deg, #f0f4f8, #d9e2ec);
            color: #333;
        }
        header {
            background: #2c3e50;
            color: white;
            padding: 20px;
            text-align: center;
        }
        nav {
            display: flex;
            justify-content: center;
            gap: 20px;
            padding: 10px;
            background: #34495e;
        }
        nav a {
            color: white;
            text-decoration: none;
            font-weight: bold;
        }
        nav a:hover {
            color: #3498db;
        }
        .hero {
            text-align: center;
            padding: 50px 20px;
        }
        .hero h1 {
            font-size: 2.5em;
            margin-bottom: 20px;
        }
        .features {
            display: flex;
            justify-content: center;
            gap: 20px;
            flex-wrap: wrap;
            padding: 20px;
        }
        .feature-card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            width: 250px;
            text-align: center;
        }
        .feature-card h3 {
            color: #3498db;
        }
        footer {
            background: #2c3e50;
            color: white;
            text-align: center;
            padding: 10px;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
        @media (max-width: 768px) {
            .features {
                flex-direction: column;
                align-items: center;
            }
        }
    </style>
</head>
<body>
    <header>
        <h1>QuickBooks Clone</h1>
    </header>
    <nav>
        <a href="index.php">Home</a>
        <a href="#" onclick="window.location.href='signup.php'">Sign Up</a>
        <a href="#" onclick="window.location.href='login.php'">Login</a>
    </nav>
    <div class="hero">
        <h1>Manage Your Finances with Ease</h1>
        <p>Track invoices, expenses, and financial reports in one place.</p>
    </div>
    <div class="features">
        <div class="feature-card">
            <h3>Invoicing</h3>
            <p>Create, send, and track professional invoices effortlessly.</p>
        </div>
        <div class="feature-card">
            <h3>Expense Tracking</h3>
            <p>Monitor your expenses and categorize transactions.</p>
        </div>
        <div class="feature-card">
            <h3>Financial Reports</h3>
            <p>Get insights with monthly and yearly summaries.</p>
        </div>
    </div>
    <footer>
        <p>&copy; 2025 QuickBooks Clone</p>
    </footer>
</body>
</html>
