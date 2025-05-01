
<?php 
/*John Loyd Climaco
  Rafsan Unaid
  Justin james Alviar
*/
require_once 'database/db_connect.php';

/* Counts the querys per task */
$stmt = $pdo->query("SELECT COUNT(*) FROM tasks WHERE completed = 0");
$pendingTasks = $stmt->fetchColumn();

$stmt = $pdo->query("SELECT COUNT(*) FROM habits WHERE completed = 0");
$pendingHabits = $stmt->fetchColumn();

$stmt = $pdo->query("SELECT COUNT(*) FROM books WHERE completed = 0");
$books = $stmt->fetchColumn();

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
                        <a class="nav-link" href="todolist.php">To-Do List</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="habittracker.php">Habit Tracker</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="readinglist.php">Reading List</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="budgettracker.php">Budget Tracker</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="welcome-section">
            <h1>CRUD ASSIGNMENT</h1>
            <p>Please select among the given <strong>CRUD</strong> tasks:</p>
        </div>

        <div class="features-grid">
            <div class="feature-card">
                <h3>To-Do List</h3>
                <p>Keep track of your tasks and deadlines. <br>Currently <span style="color: red;"><?php echo $pendingTasks; ?></span> pending tasks.</p>
                <a href="todolist.php" class="btn">Manage Tasks</a>
            </div>

            <div class="feature-card">
                <h3>Habit Tracker</h3>
                <p>Build and maintain good habits. <br>Currently <span style="color: red;"><?php echo $pendingHabits; ?></span> pending tasks.</p>
                <a href="habittracker.php" class="btn">Track Habits</a>
            </div>

            <div class="feature-card">
                <h3>Reading List</h3>
                <p>Manage your reading goals. <br>Currently <span style="color: red;"><?php echo $books; ?></span> pending tasks.</p>
                <a href="readinglist.php" class="btn">View Reading List</a>
            </div>

            <div class="feature-card">
                <h3>Budget Tracker</h3>
                <p>Monitor your expenses. <span style="color: red;">Total expenses: $<?php echo number_format($totalExpenses, 2); ?></span></p>
                <a href="budgettracker.php" class="btn">Track Budget</a>
            </div>
        </div>
    </div>
</body>
</html> 