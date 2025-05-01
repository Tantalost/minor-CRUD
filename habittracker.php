<?php
require_once 'database/db_helper.php';

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'add':
                $habit = [
                    'name' => $_POST['habitName'],
                    'frequency' => $_POST['frequency'],
                    'start_date' => $_POST['startDate'],
                    'completed' => false
                ];
                addItem('habits', $habit);
                break;
            case 'toggle':
                toggleComplete('habits', $_POST['id']);
                break;
            case 'edit':
                $habit = [
                    'name' => $_POST['habitName'],
                    'frequency' => $_POST['frequency'],
                    'start_date' => $_POST['startDate']
                ];
                updateItem('habits', $_POST['id'], $habit);
                break;
            case 'delete':
                deleteItem('habits', $_POST['id']);
                break;
        }
        header('Location: habits.php');
        exit;
    }
}

$habits = getData('habits');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Habit Tracker - CRUD App</title>
    <link rel="stylesheet" href="/css/styles.css">
    <link rel="stylesheet" href="css/habits.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">CRUD Web-Applications</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="todo.php">To-Do List</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="habits.php">Habit Tracker</a>
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
        <h1 class="mb-4">Habit Tracker</h1>
        
        <div class="form-container mb-4">
            <h3>Add New Habit</h3>
            <form method="POST">
                <input type="hidden" name="action" value="add">
                <div class="mb-3">
                    <label for="habitName" class="form-label">Habit Name</label>
                    <input type="text" class="form-control" id="habitName" name="habitName" required>
                </div>
                <div class="mb-3">
                    <label for="frequency" class="form-label">Frequency</label>
                    <select class="form-select" id="frequency" name="frequency" required>
                        <option value="daily">Daily</option>
                        <option value="weekly">Weekly</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="startDate" class="form-label">Start Date</label>
                    <input type="date" class="form-control" id="startDate" name="startDate" required>
                </div>
                <button type="submit" class="btn btn-primary">Add Habit</button>
            </form>
        </div>

        <div id="habitList" class="mt-4">
            <?php foreach ($habits as $habit): ?>
                <div class="habit-item <?php echo $habit['completed'] ? 'completed' : ''; ?>">
                    <h4><?php echo htmlspecialchars($habit['name']); ?></h4>
                    <p>Frequency: <?php echo htmlspecialchars($habit['frequency']); ?></p>
                    <p>Start Date: <?php echo htmlspecialchars($habit['start_date']); ?></p>
                    <p>Status: <?php echo $habit['completed'] ? 'Completed' : 'Pending'; ?></p>
                    <div class="btn-group">
                        <form method="POST" style="display: inline;">
                            <input type="hidden" name="action" value="toggle">
                            <input type="hidden" name="id" value="<?php echo $habit['id']; ?>">
                            <button type="submit" class="btn btn-success btn-sm">
                                <?php echo $habit['completed'] ? 'Mark Incomplete' : 'Mark Complete'; ?>
                            </button>
                        </form>
                        <button class="btn btn-warning btn-sm" onclick="editHabit(<?php echo $habit['id']; ?>)">Edit</button>
                        <form method="POST" style="display: inline;">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="id" value="<?php echo $habit['id']; ?>">
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <script>
        function editHabit(id) {
            const habit = <?php echo json_encode($habits); ?>.find(h => h.id === id);
            const newName = prompt('Enter new habit name:', habit.name);
            const newFrequency = prompt('Enter new frequency (daily/weekly):', habit.frequency);
            const newStartDate = prompt('Enter new start date (YYYY-MM-DD):', habit.start_date);

            if (newName && newFrequency && newStartDate) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.innerHTML = `
                    <input type="hidden" name="action" value="edit">
                    <input type="hidden" name="id" value="${id}">
                    <input type="hidden" name="habitName" value="${newName}">
                    <input type="hidden" name="frequency" value="${newFrequency}">
                    <input type="hidden" name="startDate" value="${newStartDate}">
                `;
                document.body.appendChild(form);
                form.submit();
            }
        }
    </script>
</body>
</html> 