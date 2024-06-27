<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit;
}
require 'config.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $roomID = $_POST['roomID'];
    $customerID = $_POST['customerID'];
    $checkInDate = $_POST['checkInDate'];
    $checkOutDate = $_POST['checkOutDate'];
    $contactNumber = $_POST['contactNumber'];
    $bookingExtra = $_POST['bookingExtra'];

    $query = "INSERT INTO booking (RoomID, CustomerID, CheckInDate, CheckOutDate, ContactNumber, Booking_Extra) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iissss", $roomID, $customerID, $checkInDate, $checkOutDate, $contactNumber, $bookingExtra);
    $stmt->execute();
    $stmt->close();
    header('Location: list_bookings.php');
    exit;
}
$query = "SELECT roomID FROM room";
$rooms = $conn->query($query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create Booking</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    function checkAvailability() {
        var fromDate = $('#checkInDate').val();
        var toDate = $('#checkOutDate').val();
        $.ajax({
            url: 'roomsearch.php',
            type: 'GET',
            data: {
                fromdate: fromDate,
                enddate: toDate
            },
            success: function(response) {
                $('#roomID').html(response);
            }
        });
    }
    </script>
</head>
<body>
    <h1>Create Booking</h1>
    <form method="post">
        <label>Room ID:
            <select id="roomID" name="roomID" required>
                <?php while($room = $rooms->fetch_assoc()): ?>
                <option value="<?php echo $room['roomID']; ?>"><?php echo $room['roomID']; ?></option>
                <?php endwhile; ?>
            </select>
        </label><br>
        <label>Customer ID: <input type="text" name="customerID" required></label><br>
        <label>Check-In Date: <input type="date" id="checkInDate" name="checkInDate" required onchange="checkAvailability()"></label><br>
        <label>Check-Out Date: <input type="date" id="checkOutDate" name="checkOutDate" required onchange="checkAvailability()"></label><br>
        <label>Contact Number: <input type="text" name="contactNumber" required></label><br>
        <label>Booking Extra: <textarea name="bookingExtra" required></textarea></label><br>
        <input type="submit" value="Create Booking">
    </form>
</body>
</html>
