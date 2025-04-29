<?php 
require_once 'database/db_connect.php';

$stmt = $pdo->query("SELECT COUNT(*) FROM tasks WHERE completed = 0");
$pendingTasks = $stmt->fetchColumn();

$stmt = $pdo->query("SELECT COUNT(*) FROM habits WHERE completed = 0");
$pendingHabits = $stmt->fetchColumn();

$stmt = $pdo->query("SELECT COUNT(*) FROM books WHERE completed = 0");
$pendingBooks = $stmt->fetchColumn();

$stmt = $pdo->query("SELECT SUM(amount) FROM expenses");
$totalExpenses = $stmt->fetchColumn() ?: 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Web Applications</title>
    <link rel="stylesheet" href="/css/styles.css">
    <link rel="stylesheet" href="/css/index-style.css">
</head>
<body>
<nav class="navbar">
        <div class="container">
            <a class="navbar-brand" href="index.php">CRUD Web-Applications</a>
            <div class="navbar-menu">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="todo.php">To-Do List</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="habits.php">Habit Tracker</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="reading.php">Reading List</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="budget.php">Budget Tracker</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="welcome-section">
            <h1>CRUD Assignment</h1>
            <p>Please select among the given <strong>CRUD</strong> tasks:</p>
        </div>

        <div class="features-grid">
            <div class="feature-card">
                <h3>To-Do List</h3>
                <p>Keep track of your tasks and deadlines. Currently <?php echo $pendingTasks; ?> pending tasks.</p>
                <a href="todo.php" class="btn">Manage Tasks</a>
            </div>

            <div class="feature-card">
                <h3>Habit Tracker</h3>
                <p>Build and maintain good habits. Currently <?php echo $pendingHabits; ?> active habits.</p>
                <a href="habits.php" class="btn">Track Habits</a>
            </div>

            <div class="feature-card">
                <h3>Reading List</h3>
                <p>Manage your reading goals. Currently <?php echo $pendingBooks; ?> books in progress.</p>
                <a href="reading.php" class="btn">View Reading List</a>
            </div>

            <div class="feature-card">
                <h3>Budget Tracker</h3>
                <p>Monitor your expenses. Total expenses: $<?php echo number_format($totalExpenses, 2); ?></p>
                <a href="budget.php" class="btn">Track Budget</a>
            </div>
        </div>
    </div>
</body>
</html> 