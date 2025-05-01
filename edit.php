<?php
/*John Loyd Climaco
  Rafsan Unaid
  Justin james Alviar
*/
session_start();
require_once 'database/db_connect.php';
$stmt = $pdo->query("SELECT * FROM books");
$_SESSION['books'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

$index = $_GET['index'];
$books = $_SESSION['books'][$index];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Book</title>
    <link rel="stylesheet" href="readinglist.css">
</head>
<body>
<div class="container">
    <h2>Edit Book</h2>
    <form method="post" action="index.php" class="form">
        <input type="hidden" name="index" value="<?= $index ?>">
        <input type="text" name="book_name" value="<?= htmlspecialchars($books['name']) ?>" required>
        <input type="text" name="author_name" value="<?= htmlspecialchars($books['author']) ?>" required>
        <div class="radio-group">
            <label><input type="radio" name="genre" value="Fiction" <?= $books['genre'] == 'Fiction' ? 'checked' : '' ?>> Fiction</label>
            <label><input type="radio" name="genre" value="Non-Fiction" <?= $books['genre'] == 'Non-Fiction' ? 'checked' : '' ?>> Non-Fiction</label>
        </div>
        <input type="date" name="start_date" value="<?= $books['start_date'] ?>" required>
        <button type="submit" name="edit">Save Changes</button>
    </form>
</div>
</body>
</html>
