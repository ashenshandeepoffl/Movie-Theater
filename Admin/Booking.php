<?php
session_start();

$host = "localhost";
$username = "root";
$password = "As+s01galaxysa";
$database = "Movie";

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the user is logged in as admin
if (!isset($_SESSION['user_id']) || $_SESSION['usertype'] !== 'admin') {
    header("Location: login_page.php");
    exit();
}

// Handle form submission to update booking status
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update_status"])) {
    $bookingId = $_POST["booking_id"];
    $status = $_POST["status"];

    $sqlUpdateStatus = "UPDATE bookings SET status = '$status' WHERE id = '$bookingId'";
    if ($conn->query($sqlUpdateStatus) === TRUE) {
        echo "Booking status updated successfully!";
    } else {
        echo "Error updating booking status: " . $conn->error;
    }
}

// Handle search
$searchEmail = isset($_POST["search_email"]) ? $_POST["search_email"] : '';
$sqlSelectBookings = "SELECT * FROM bookings WHERE user_email LIKE '%$searchEmail%'";
$resultBookings = $conn->query($sqlSelectBookings);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="Booking.css">
</head>

<body>
    <div class="container">
        <header>
            <h2>User Bookings</h2>
        </header>

        <div class="row">
            <div class="col">
                <h3>Movies Currently Going</h3>
                <div class="movies-container">
                    <ul>
                        <?php
                        $sqlSelectMovies = "SELECT id, movieName FROM movies";
                        $resultMovies = $conn->query($sqlSelectMovies);

                        while ($rowMovie = $resultMovies->fetch_assoc()) {
                            echo "<li>" . $rowMovie['id'] . " - " . $rowMovie['movieName'] . "</li>";
                        }
                        ?>

                    </ul>
                </div>
            </div>

            <div class="col">
                <h3>Bookings</h3>

                <form action="#" method="post" class="search-form">
                    <input type="text" name="search_email" placeholder="User Email Address" id="search_email" class="search-box" value="<?php echo $searchEmail; ?>">
                </form>

                <div class="bookings-container">
                    <table>
                        <tr>
                            <th>Booking ID</th>
                            <th>User ID</th>
                            <th>Movie ID</th>
                            <th>Booking Date</th>
                            <th>Time Slot</th>
                            <th>Selected Seats</th>
                            <th>User Email</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        <?php
                        while ($rowBooking = $resultBookings->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $rowBooking['id'] . "</td>";
                            echo "<td>" . $rowBooking['user_id'] . "</td>";
                            echo "<td>" . $rowBooking['movie_id'] . "</td>";
                            echo "<td>" . $rowBooking['booking_date'] . "</td>";
                            echo "<td>" . $rowBooking['time_slot'] . "</td>";
                            echo "<td>" . $rowBooking['selected_seats'] . "</td>";
                            echo "<td>" . $rowBooking['user_email'] . "</td>";
                            echo "<td>" . $rowBooking['status'] . "</td>";
                            echo "<td>";
                            echo "<form action='#' method='post'>";
                            echo "<input type='hidden' name='booking_id' value='" . $rowBooking['id'] . "'>";
                            echo "<select name='status'>";
                            echo "<option value='accepted'>Accepted</option>";
                            echo "<option value='declined'>Declined</option>";
                            echo "</select>";
                            echo "<input type='submit' name='update_status' value='Update Status'>";
                            echo "</form>";
                            echo "</td>";
                            echo "</tr>";
                        }
                        ?>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Live updating search
        let timerId;

        const searchEmailInput = document.getElementById('search_email');
        searchEmailInput.addEventListener('input', function() {
            clearTimeout(timerId);
            timerId = setTimeout(() => {
                this.form.submit();
            }, 2000); // Adjust the delay (in milliseconds) as needed
        });
    </script>
</body>

</html>

<?php
$conn->close();
?>