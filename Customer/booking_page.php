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

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login_page.php"); // Redirect to the login page if not logged in
    exit();
}

// Get user details including email
$userId = $_SESSION['user_id'];
$sqlSelectUser = "SELECT * FROM users WHERE id = '$userId'";
$resultUser = $conn->query($sqlSelectUser);

if ($resultUser->num_rows > 0) {
    $user = $resultUser->fetch_assoc();
    $userEmail = $user['email'];
} else {
    echo "User not found!";
    exit();
}

// Check if the movie_id is set in the URL
if (isset($_GET['movie_id'])) {
    $movieId = $_GET['movie_id'];

    // Retrieve movie details
    $sqlSelectMovie = "SELECT * FROM movies WHERE id = '$movieId'";
    $resultMovie = $conn->query($sqlSelectMovie);

    if ($resultMovie->num_rows > 0) {
        $movie = $resultMovie->fetch_assoc();
    } else {
        echo "Movie not found!";
        exit();
    }
} else {
    echo "Movie ID not provided!";
    exit();
}

// Initialize bookedSeats as an empty array
$bookedSeats = array();

// Handle search form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["search"])) {
    $searchDate = $_POST['search_date'];
    $searchTimeSlot = $_POST['search_time_slot'];

    // Retrieve booked seats for the current movie and selected date, time slot
    $sqlSelectBookedSeats = "SELECT selected_seats FROM bookings 
                             WHERE movie_id = '$movieId' 
                             AND booking_date = '$searchDate' 
                             AND time_slot = '$searchTimeSlot'";
    $resultBookedSeats = $conn->query($sqlSelectBookedSeats);

    if ($resultBookedSeats->num_rows > 0) {
        while ($row = $resultBookedSeats->fetch_assoc()) {
            $seats = explode(', ', $row['selected_seats']);
            $bookedSeats = array_merge($bookedSeats, $seats);
        }
    }
}

// Handle booking form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["book"])) {
    // Retrieve selected seats, date, and time slot from the form
    if (isset($_POST['selected_seats'])) {
        $selectedSeats = implode(', ', $_POST['selected_seats']);
        $bookingDate = $_POST['booking_date'];
        $timeSlot = $_POST['time_slot'];

        // Get the user's email from the session
        $userEmail = $_SESSION['user_email'];

        // Perform the booking with selected seats, date, and time slot
        $sqlBook = "INSERT INTO bookings (user_id, movie_id, booking_date, time_slot, selected_seats, user_email) 
                    VALUES ('$userId', '$movieId', '$bookingDate', '$timeSlot', '$selectedSeats', '$userEmail')";

        if ($conn->query($sqlBook) === TRUE) {
            echo "Booking successful! Selected Seats: " . $selectedSeats . ", Date: " . $bookingDate . ", Time Slot: " . $timeSlot;
        } else {
            echo "Error: " . $sqlBook . "<br>" . $conn->error;
        }
    } else {
        echo "Please select at least one seat!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Page</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        h2,
        h3 {
            color: #333;
            margin-bottom: 10px;
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 20px;
        }

        label {
            margin-top: 10px;
            color: #555;
        }

        input,
        select {
            margin-top: 5px;
            padding: 8px;
            width: 100%;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 5px;
            outline: none;
        }

        input[type="submit"] {
            background-color: #3498db;
            color: #fff;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #2980b9;
        }

        div {
            text-align: center;
            margin-bottom: 20px;
        }

        img {
            max-width: 100%;
            height: auto;
        }

        .seat {
            display: none;
        }

        .seat+label {
            display: inline-block;
            padding: 5px;
            margin: 5px;
            cursor: pointer;
            border-radius: 5px;
            background-color: #eee;
        }

        .seat:checked+label {
            background-color: #3498db;
            color: #fff;
        }

        .seat[disabled]+label {
            background-color: #ddd;
            color: #777;
            cursor: not-allowed;
        }

        /* Responsive Styles */
        @media only screen and (min-width: 600px) {
            form {
                max-width: 400px;
            }
        }

        @media only screen and (min-width: 768px) {
            form {
                max-width: 600px;
            }
        }

        @media only screen and (min-width: 992px) {
            form {
                max-width: 800px;
            }
        }

        @media only screen and (min-width: 1200px) {
            form {
                max-width: 1000px;
            }
        }
    </style>
</head>

<body>
    <h2>Booking Page</h2>
    <h3>Movie Details</h3>

    <div>
        <img src='<?php echo $movie['posterImage']; ?>' alt="Movie Poster">
        <h3><?php echo $movie['movieName']; ?></h3>
    </div>

    <h3>Search for Available Seats</h3>
    <form action="#" method="post">
        <label for="search_date">Select Date:</label>
        <input type="date" id="search_date" name="search_date" required>

        <label for="search_time_slot">Select Time Slot:</label>
        <select id="search_time_slot" name="search_time_slot" required>
            <option value="morning">Morning</option>
            <option value="afternoon">Afternoon</option>
            <option value="evening">Evening</option>
        </select>

        <input type="submit" name="search" value="Search">
    </form>

    <h3>Booking Form</h3>
    <form action="#" method="post">
        <label for="booking_date">Select Date:</label>
        <input type="date" id="booking_date" name="booking_date" required>

        <label for="time_slot">Select Time Slot:</label>
        <select id="time_slot" name="time_slot" required>
            <option value="morning">Morning</option>
            <option value="afternoon">Afternoon</option>
            <option value="evening">Evening</option>
        </select>

        <?php
        $totalSeats = 200;

        // Display available seats as checkboxes
        for ($seat = 1; $seat <= $totalSeats; $seat++) {
            $seatId = "seat_" . $seat;
            $disabled = in_array($seatId, $bookedSeats) ? "disabled" : "";
            $status = in_array($seatId, $bookedSeats) ? "Booked" : "Available";
        ?>
            <input type="checkbox" name="selected_seats[]" id="<?php echo $seatId; ?>" class="seat" value="<?php echo $seatId; ?>" <?php echo $disabled; ?>>
            <label for="<?php echo $seatId; ?>">Seat <?php echo $seat; ?> (<?php echo $status; ?>)</label>
        <?php
        }
        ?>

        <input type="submit" name="book" value="Book Now">
    </form>
</body>

</html>

<?php
$conn->close();
?>