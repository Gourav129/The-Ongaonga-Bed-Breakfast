<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit;
}

require 'config.php';

if (isset($_GET['id'])) {
    $bookingID = $_GET['id'];
    $query = "SELECT * FROM booking WHERE bookingID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $bookingID);
    $stmt->execute();
    $result = $stmt->get_result();
    $booking = $result->fetch_assoc();
    $stmt->close();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $reviewRoom = $_POST['reviewRoom'];
    $query = "UPDATE booking SET Review_Room = ? WHERE bookingID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("si", $reviewRoom, $bookingID);
    $stmt->execute();
    $stmt->close();
    header('Location: list_bookings.php');
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Review</title>
</head>
<body>
    <h1>Edit Review</h1>
    <form method="post">
        <label>Review: <textarea name="reviewRoom"><?php echo $booking['Review_Room']; ?></textarea></label><br>
        <input type="submit" value="Update Review">
    </form>
</body>
</html>

