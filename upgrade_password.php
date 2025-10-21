
<?php
// Database connection
$host = "localhost";
$user = "root"; // change if needed
$pass = "";     // change if needed
$db   = "attendance_system";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("DB connection failed: " . $conn->connect_error);
}

$sql = "SELECT id, username, password FROM admins";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $id = $row['id'];
        $username = $row['username'];
        $password = $row['password'];

        // Check if password is already hashed (hashed ones start with $2y$)
        if (strpos($password, '$2y$') !== 0) {
            $hashed = password_hash($password, PASSWORD_DEFAULT);

            $update = $conn->prepare("UPDATE admins SET password=? WHERE id=?");
            $update->bind_param("si", $hashed, $id);
            if ($update->execute()) {
                echo "✅ Password for admin '$username' has been hashed.<br>";
            } else {
                echo "❌ Failed to update password for '$username'.<br>";
            }
            $update->close();
        } else {
            echo "ℹ️ Admin '$username' already has a hashed password.<br>";
        }
    }
} else {
    echo "⚠️ No admins found in the database.";
}

$conn->close();
?>
