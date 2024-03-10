<?php
include 'dbConnection.php';
include 'Navigation.php';

function sanitizeInput($input)
{
    global $conn;
    return mysqli_real_escape_string($conn, htmlspecialchars(trim($input)));
}

// Update user type permissions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["updatePermission"])) {
        $userId = sanitizeInput($_POST["userId"]);
        $newUserType = sanitizeInput($_POST["newUserType"]);

        $sqlUpdateUserType = "UPDATE users SET usertype = '$newUserType' WHERE id = $userId";
        if ($conn->query($sqlUpdateUserType) === TRUE) {
            echo "User type updated successfully";
        } else {
            echo "Error updating user type: " . $conn->error;
        }
    }
}

// Search users
$searchTerm = isset($_GET['search']) ? sanitizeInput($_GET['search']) : '';
$searchCondition = "";
if (!empty($searchTerm)) {
    $searchCondition = " WHERE username LIKE '%$searchTerm%' OR email LIKE '%$searchTerm%' OR usertype LIKE '%$searchTerm%'";
}

$sqlSelectUsers = "SELECT id, username, email, usertype FROM users $searchCondition";
$resultUsers = $conn->query($sqlSelectUsers);

if (!$resultUsers) {
    die("Error: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - User List</title>
    <link rel="stylesheet" href="Booking.css">
</head>

<body>
    <div class="container">
        <header>
            <h2>User List</h2>
        </header>

        <div class="row">
            <div class="col">
                <h3>Messages for Admins</h3>
                <div class="movies-container">
                    <ul>
                    </ul>
                </div>
            </div>

            <div class="col">
                <h3>Search Users</h3>
                <form method="get" class="search-form" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <input type="text" name="search" id="search" class="search-box" value="<?php echo $searchTerm; ?>">
                    <input type="submit" value="Search">
                </form>

                <div class="bookings-container">
                    <table>
                        <tr>
                            <th>User ID</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>User Type</th>
                            <th>Change User Type</th>
                        </tr>
                        <?php
                        while ($rowUser = $resultUsers->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $rowUser['id'] . "</td>";
                            echo "<td>" . $rowUser['username'] . "</td>";
                            echo "<td>" . $rowUser['email'] . "</td>";
                            echo "<td>" . $rowUser['usertype'] . "</td>";
                            echo "<td>
                            <form method='post' action='" . $_SERVER["PHP_SELF"] . "'>
                                <input type='hidden' name='userId' value='" . $rowUser['id'] . "'>
                                <select name='newUserType'>
                                    <option value='admin' " . ($rowUser['usertype'] == 'admin' ? 'selected' : '') . ">Admin</option>
                                    <option value='customer' " . ($rowUser['usertype'] == 'customer' ? 'selected' : '') . ">Customer</option>
                                    <option value='cinema' " . ($rowUser['usertype'] == 'cinema' ? 'selected' : '') . ">Cinema</option>
                                </select>
                                <input type='submit' name='updatePermission' value='Update'>
                            </form>
                            </td>";
                            echo "</tr>";
                        }
                        ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>

</html>

<?php
$conn->close();
?>