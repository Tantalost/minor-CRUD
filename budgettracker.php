<?php
require_once 'database/db_connect.php';

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'add':
                $stmt = $pdo->prepare("INSERT INTO expenses (description, amount, category, date) VALUES (?, ?, ?, ?)");
                $stmt->execute([$_POST['description'], $_POST['amount'], $_POST['category'], $_POST['date']]);
                break;
            
            case 'edit':
                $stmt = $pdo->prepare("UPDATE expenses SET description = ?, amount = ?, category = ?, date = ? WHERE id = ?");
                $stmt->execute([$_POST['description'], $_POST['amount'], $_POST['category'], $_POST['date'], $_POST['id']]);
                break;
            
            case 'delete':
                $stmt = $pdo->prepare("DELETE FROM expenses WHERE id = ?");
                $stmt->execute([$_POST['id']]);
                break;
        }
        
        // Redirect to prevent form resubmission
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    }
}

// Fetch all expenses
$stmt = $pdo->query("SELECT * FROM expenses ORDER BY date DESC");
$expenses = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Calculate summary
$totalExpenses = 0;
$categoryTotals = [
    'food' => 0,
    'transportation' => 0,
    'entertainment' => 0,
    'utilities' => 0,
    'other' => 0
];

foreach ($expenses as $expense) {
    $totalExpenses += $expense['amount'];
    $categoryTotals[$expense['category']] += $expense['amount'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Budget Tracker - CRUD App</title>
    <link rel="stylesheet" href="/css/styles.css">
    <link rel="stylesheet" href="css/budget.css">
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <a class="navbar-brand" href="index.php">CRUD App</a>
            <button class="navbar-toggle" type="button">
                <span class="navbar-toggle-icon"></span>
            </button>
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
                        <a class="nav-link active" href="budget.php">Budget Tracker</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <h1 class="page-title">Budget Tracker</h1>
        
        <div class="summary-section">
            <h3>Expense Summary</h3>
            <div class="summary-grid">
                <div class="summary-item">
                    <h4>Total Expenses</h4>
                    <div class="amount expense">$<?php echo number_format($totalExpenses, 2); ?></div>
                </div>
                <?php foreach ($categoryTotals as $category => $total): ?>
                    <div class="summary-item">
                        <h4><?php echo ucfirst($category); ?></h4>
                        <div class="amount expense">$<?php echo number_format($total, 2); ?></div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        
        <div class="budget-form">
            <h3>Add New Expense</h3>
            <form method="POST" action="">
                <input type="hidden" name="action" value="add">
                <div class="form-group">
                    <label for="description">Description</label>
                    <input type="text" class="form-control" id="description" name="description" required>
                </div>
                <div class="form-group">
                    <label for="amount">Amount</label>
                    <input type="number" step="0.01" class="form-control" id="amount" name="amount" required>
                </div>
                <div class="form-group">
                    <label for="category">Category</label>
                    <select class="form-control" id="category" name="category" required>
                        <option value="food">Food</option>
                        <option value="transportation">Transportation</option>
                        <option value="entertainment">Entertainment</option>
                        <option value="utilities">Utilities</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="date">Date</label>
                    <input type="date" class="form-control" id="date" name="date" required>
                </div>
                <button type="submit" class="btn btn-primary">Add Expense</button>
            </form>
        </div>

        <div class="expense-list">
            <?php foreach ($expenses as $expense): ?>
                <div class="expense-item">
                    <h4><?php echo htmlspecialchars($expense['description']); ?></h4>
                    <p>Amount: $<?php echo number_format($expense['amount'], 2); ?></p>
                    <p>Category: <span class="category-badge category-<?php echo $expense['category']; ?>">
                        <?php echo ucfirst(htmlspecialchars($expense['category'])); ?>
                    </span></p>
                    <p>Date: <?php echo htmlspecialchars($expense['date']); ?></p>
                    <div class="btn-group">
                        <button class="btn btn-warning" onclick="editExpense(<?php echo $expense['id']; ?>, '<?php echo htmlspecialchars($expense['description']); ?>', <?php echo $expense['amount']; ?>, '<?php echo $expense['category']; ?>', '<?php echo $expense['date']; ?>')">Edit</button>
                        
                        <form method="POST" action="" style="display: inline;">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="id" value="<?php echo $expense['id']; ?>">
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this expense?')">Delete</button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <script>
        function editExpense(id, description, amount, category, date) {
            const newDescription = prompt('Enter new description:', description);
            const newAmount = prompt('Enter new amount:', amount);
            const newCategory = prompt('Enter new category (food/transportation/entertainment/utilities/other):', category);
            const newDate = prompt('Enter new date (YYYY-MM-DD):', date);

            if (newDescription && newAmount && newCategory && newDate) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '';

                const fields = {
                    action: 'edit',
                    id: id,
                    description: newDescription,
                    amount: newAmount,
                    category: newCategory,
                    date: newDate
                };

                for (const [key, value] of Object.entries(fields)) {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = key;
                    input.value = value;
                    form.appendChild(input);
                }

                document.body.appendChild(form);
                form.submit();
            }
        }
    </script>
</body>
</html> 