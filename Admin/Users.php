<?php
$host = "localhost";
$username = "root";
$password = "As+s01galaxysa";
$database = "Movie";

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

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
</head>
<body>
    <h2>User List</h2>
    <form method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="search">Search:</label>
        <input type="text" name="search" id="search" value="<?php echo $searchTerm; ?>">
        <input type="submit" value="Search">
    </form>

    <table border="1">
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
</body>
</html>

<?php
$conn->close();
?>