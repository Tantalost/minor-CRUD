<?php
require_once 'db_connect.php';

function getData($type) {
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM $type ORDER BY created_at DESC");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function addItem($type, $item) {
    global $pdo;
    $columns = implode(', ', array_keys($item));
    $values = implode(', ', array_fill(0, count($item), '?'));
    $stmt = $pdo->prepare("INSERT INTO $type ($columns) VALUES ($values)");
    $stmt->execute(array_values($item));
}

function updateItem($type, $id, $item) {
    global $pdo;
    $set = implode(' = ?, ', array_keys($item)) . ' = ?';
    $stmt = $pdo->prepare("UPDATE $type SET $set WHERE id = ?");
    $values = array_values($item);
    $values[] = $id;
    $stmt->execute($values);
}

function deleteItem($type, $id) {
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM $type WHERE id = ?");
    $stmt->execute([$id]);
}

function toggleComplete($type, $id) {
    global $pdo;
    $stmt = $pdo->prepare("UPDATE $type SET completed = NOT completed WHERE id = ?");
    $stmt->execute([$id]);
}
?> 