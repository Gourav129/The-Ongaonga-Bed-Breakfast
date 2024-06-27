<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit;
}

require 'config.php';
if (isset($_GET['id'])) {
    $bookingID = $_GET['id'];
    $query = "DELETE FROM booking WHERE bookingID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $bookingID);
    $stmt->execute();
    $stmt->close();
    header('Location: list_bookings.php');
    exit;
}
header('Location: list_bookings.php');
exit;
?>
