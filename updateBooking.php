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
    $roomID = $_POST['roomID'];
    $customerID = $_POST['customerID'];
    $checkInDate = $_POST['checkInDate'];
    $checkOutDate = $_POST['checkOutDate'];
    $contactNumber = $_POST['contactNumber'];
    $bookingExtra = $_POST['bookingExtra'];
    $reviewRoom = $_POST['reviewRoom'];

    $query = "UPDATE booking SET RoomID = ?, CustomerID = ?, CheckInDate = ?, CheckOutDate = ?, ContactNumber = ?, Booking_Extra = ?, Review_Room = ? WHERE bookingID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iississi", $roomID, $customerID, $checkInDate, $checkOutDate, $contactNumber, $bookingExtra, $reviewRoom, $bookingID);
    $stmt->execute();
    $stmt->close();
    header('Location: list_bookings.php');
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Booking</title>
</head>
<body>
    <h1>Edit Booking</h1>
    <form method="post">
        <label>Room ID: <input type="text" name="roomID" value="<?php echo $booking['RoomID']; ?>" required></label><br>
        <label>Customer ID: <input type="text" name="customerID" value="<?php echo $booking['CustomerID']; ?>" required></label><br>
        <label>Check-In Date: <input type="date" name="checkInDate" value="<?php echo $booking['CheckInDate']; ?>" required></label><br>
        <label>Check-Out Date: <input type="date" name="checkOutDate" value="<?php echo $booking['CheckOutDate']; ?>" required></label><br>
        <label>Contact Number: <input type="text" name="contactNumber" value="<?php echo $booking['ContactNumber']; ?>" required></label><br>
        <label>Booking Extra: <textarea name="bookingExtra" required><?php echo $booking['Booking_Extra']; ?></textarea></label><br>
        <label>Review: <textarea name="reviewRoom"><?php echo $booking['Review_Room']; ?></textarea></label><br>
        <input type="submit" value="Update Booking">
    </form>
</body>
</html>
