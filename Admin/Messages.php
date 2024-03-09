<?php
session_start();

$host = "localhost";
$username = "root";
$password = "As+s01galaxysa";
$database = "Movie";

// Create a database connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve user messages data
$sql = "SELECT full_name, email, message FROM contacts";
$result = $conn->query($sql);

// Close the database connection
$conn->close();
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
            <h2>Messages for Movies</h2>
        </header>

        <div class="row">
            <div class="col">
                <h3>Messages for Admins</h3>
                <div class="movies-container">
                    <ul>
                    </ul>
                </div>
            </div>

            <div class="bookings-container">
                <table>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Message</th>
                    </tr>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["full_name"] . "</td>";
                            echo "<td>" . $row["email"] . "</td>";
                            echo "<td>" . $row["message"] . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='3'>No messages found.</td></tr>";
                    }
                    ?>
                </table>
            </div>
        </div>
    </div>

</body>

</html>