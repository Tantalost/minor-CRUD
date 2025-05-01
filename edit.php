<?php
/*John Loyd Climaco
  Rafsan Unaid
  Justin james Alviar
*/
session_start();

$index = $_GET['index'];
$book = $_SESSION['books'][$index];
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
        <input type="text" name="book_name" value="<?= htmlspecialchars($book['name']) ?>" required>
        <input type="text" name="author_name" value="<?= htmlspecialchars($book['author']) ?>" required>
        <div class="radio-group">
            <label><input type="radio" name="type" value="Fiction" <?= $book['type'] == 'Fiction' ? 'checked' : '' ?>> Fiction</label>
            <label><input type="radio" name="type" value="Non-Fiction" <?= $book['type'] == 'Non-Fiction' ? 'checked' : '' ?>> Non-Fiction</label>
        </div>
        <input type="date" name="target_date" value="<?= $book['target_date'] ?>" required>
        <button type="submit" name="edit">Save Changes</button>
    </form>
</div>
</body>
</html>
