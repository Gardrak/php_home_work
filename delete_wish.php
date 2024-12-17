<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$wish_id = $_GET['id'];
$query = "DELETE FROM wishes WHERE id = ? AND user_id = ?";
query($query, [$wish_id, $_SESSION['user_id']]);
header('Location: wishlist.php');
exit;
?>