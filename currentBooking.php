<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit;
}
require 'config.php';

$query = "SELECT * FROM booking";
$result = $conn->query($query);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Bookings List</title>
</head>
<body>
    <h1>Current Bookings</h1>
    <table border="1">
        <tr>
            <th>Booking ID</th>
            <th>Room ID</th>
            <th>Customer ID</th>
            <th>Check-In Date</th>
            <th>Check-Out Date</th>
            <th>Contact Number</th>
            <th>Booking Extra</th>
            <th>Review</th>
            <th>Actions</th>
        </tr>
        <?php while($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['bookingID']; ?></td>
            <td><?php echo $row['RoomID']; ?></td>
            <td><?php echo $row['CustomerID']; ?></td>
            <td><?php echo $row['CheckInDate']; ?></td>
            <td><?php echo $row['CheckOutDate']; ?></td>
            <td><?php echo $row['ContactNumber']; ?></td>
            <td><?php echo $row['Booking_Extra']; ?></td>
            <td><?php echo $row['Review_Room']; ?></td>
            <td>
                <a href="edit_booking.php?id=<?php echo $row['bookingID']; ?>">Edit</a>
                <a href="delete_booking.php?id=<?php echo $row['bookingID']; ?>">Delete</a>
                <a href="edit_review.php?id=<?php echo $row['bookingID']; ?>">Edit Review</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
