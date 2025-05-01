<?php
session_start();
/*John Loyd Climaco
  Rafsan Unaid
  Justin james Alviar
*/
require_once 'database/db_connect.php';

if (!isset($_SESSION['books'])) {
    $_SESSION['books'] = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add'])) {
        $name = $_POST['book_name'];
        $author = $_POST['author_name'];
        $genre = $_POST['genre'];
        $start_date = $_POST['start_date'];
        $done = 0;

    $stmt = $pdo->prepare("INSERT INTO books (name, author, genre, start_date,completed) VALUES (?,?,?,?,?)");
    $stmt->execute([$name, $author, $genre, $start_date, $done]);

    header("Location: index.php");
    exit;
}

if (isset($_GET['done'])) {
    $_SESSION['books'][$_GET['done']]['done'] = true;
    header("Location: index.php");
    exit;
}

if (isset($_GET['delete'])) {
    array_splice($_SESSION['books'], $_GET['delete'], 1);
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit'])) {
    $index = $_POST['readinglist'];
    $_SESSION['books'][$index] = [
        'name' => $_POST['book_name'],
        'author' => $_POST['author_name'],
        'genre' => $_POST['genre'],
        'start_date' => $_POST['start_date'],
        'done' => false,
    ];
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reading List</title>
    <link rel="stylesheet" href="readinglist.css">
</head>
<body>
    <div class="container">
        <h1>My Reading List</h1>

        <form method="post" class="form">
            <label>Book Name: </label>
            <input type="text" name="book_name" placeholder="Book Name" required>
            <label>Author Name:</label>
            <input type="text" name="author_name" placeholder="Author Name" required>
            <div class="radio-group">
                <label>Type of Book:</label>
                <label><br><input type="radio" name="genre" value="Fiction" required> Fiction</label>
                <label><br><input type="radio" name="genre" value="Non-Fiction" required> Non-Fiction</label>
            </div>
            <label>Start to Read Date: </label>
            <br>
            <input type="date" name="start_date" required>
            <br>
            <button type="submit" name="add">Add Book</button>
        </form>

        <ul class="book-list">
            <?php  
            $stmt = $pdo->query("SELECT * FROM books");
            $books = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($books as $index => $books):
            ?>
                <li class="<?= $books['completed'] ? 'done' : '' ?>">
                    <strong><?= htmlspecialchars($books['name']) ?></strong> by <?= htmlspecialchars($books['author']) ?>
                    (<?= $books['genre'] ?>) - Start by <?= $books['start_date'] ?>
                    <div class="actions">
                        <?php if (!$books['completed']): ?>
                            <a href="?done=<?= $index ?>">Mark as Done</a>
                        <?php endif; ?>
                        <a href="edit.php?index=<?= $index ?>">Edit</a>
                        <a href="?delete=<?= $index ?>" onclick="return confirm('Are you sure?')">Delete</a>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</body>
</html>
