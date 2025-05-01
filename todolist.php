<?php
/*John Loyd Climaco
  Rafsan Unaid
  Justin james Alviar
*/
require_once 'database/db_connect.php';

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'add':
                $stmt = $pdo->prepare("INSERT INTO tasks (name, start_date, end_date) VALUES (?, ?, ?)");
                $stmt->execute([$_POST['taskName'], $_POST['startDate'], $_POST['endDate']]);
                break;
            
            case 'toggle':
                $stmt = $pdo->prepare("UPDATE tasks SET completed = NOT completed WHERE id = ?");
                $stmt->execute([$_POST['id']]);
                break;
            
            case 'edit':
                $stmt = $pdo->prepare("UPDATE tasks SET name = ?, start_date = ?, end_date = ? WHERE id = ?");
                $stmt->execute([$_POST['name'], $_POST['startDate'], $_POST['endDate'], $_POST['id']]);
                break;
            
            case 'delete':
                $stmt = $pdo->prepare("DELETE FROM tasks WHERE id = ?");
                $stmt->execute([$_POST['id']]);
                break;
        }
        
        // Redirect to prevent form resubmission
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    }
}

// Fetch all tasks
$stmt = $pdo->query("SELECT * FROM tasks ORDER BY created_at DESC");
$tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task 1</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/td-style.css">
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <a class="navbar-brand" href="index.php">CRUD Web-Applications</a>
            <div class="navbar-menu">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" href="todolist.php">To-Do List</a>
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
        <h1 class="page-title">Interactive To-Do List</h1>
        
        <div class="todo-form">
            <h3>Add New Task</h3>
            <form method="POST" action="">
                <input type="hidden" name="action" value="add">
                <div class="form-group">
                    <label for="taskName">Task Name</label>
                    <input type="text" class="form-control" id="taskName" name="taskName" required>
                </div>
                <div class="form-group">
                    <label for="startDate">Start Date</label>
                    <input type="date" class="form-control" id="startDate" name="startDate" required>
                </div>
                <div class="form-group">
                    <label for="endDate">End Date</label>
                    <input type="date" class="form-control" id="endDate" name="endDate" required>
                </div>
                <button type="submit" class="btn btn-primary">Add Task</button>
            </form>
        </div>

        <div class="task-list">
            <?php foreach ($tasks as $task): ?>
                <div class="task-item <?php echo $task['completed'] ? 'completed' : ''; ?>">
                    <h4><?php echo htmlspecialchars($task['name']); ?></h4>
                    <p>Start Date: <?php echo htmlspecialchars($task['start_date']); ?></p>
                    <p>End Date: <?php echo htmlspecialchars($task['end_date']); ?></p>
                    <p>Status: <span class="status-badge <?php echo $task['completed'] ? 'status-completed' : 'status-pending'; ?>">
                        <?php echo $task['completed'] ? 'Completed' : 'Pending'; ?>
                    </span></p>
                    <div class="btn-group">
                        <form method="POST" action="" style="display: inline;">
                            <input type="hidden" name="action" value="toggle">
                            <input type="hidden" name="id" value="<?php echo $task['id']; ?>">
                            <button type="submit" class="btn btn-success">
                                <?php echo $task['completed'] ? 'Mark Incomplete' : 'Mark Complete'; ?>
                            </button>
                        </form>
                        
                        <button class="btn btn-warning" onclick="editTask(<?php echo $task['id']; ?>, '<?php echo htmlspecialchars($task['name']); ?>', '<?php echo $task['start_date']; ?>', '<?php echo $task['end_date']; ?>')">Edit</button>
                        
                        <form method="POST" action="" style="display: inline;">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="id" value="<?php echo $task['id']; ?>">
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this task?')">Delete</button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <script src="/js/td-script.js"></script>
</body>
</html> 