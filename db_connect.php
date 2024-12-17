<?php
require_once 'config.php';

// Функция для подключения к базе данных
function connect_db() {
    $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8';
    try {
        $pdo = new PDO($dsn, DB_USER, DB_PASSWORD);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        die("Connection failed: " . $e->getMessage());
    }
}

// Функция для выполнения SQL-запросов
function query($sql, $params = []) {
    $stmt = connect_db()->prepare($sql);
    $stmt->execute($params);
    if ($stmt->columnCount()) {
        return $stmt->fetchAll();
    }
    return true;
}

// Функция для получения одного значения из базы данных
function get_value($sql, $params = []) {
    $result = query($sql, $params);
    return isset($result[0][0]) ? $result[0][0] : null;
}

// Функция для вставки новой записи и возврата её ID
function insert_and_get_id($table, $data) {
    $columns = implode(',', array_keys($data));
    $values = ':' . implode(',:', array_keys($data));
    $sql = "INSERT INTO $table ($columns) VALUES ($values)";
    query($sql, $data);
    return connect_db()->lastInsertId();
}
?>