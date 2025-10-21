CREATE ADMIN:

<?php
// Database connection
$host = "localhost";
$user = "root"; // change if you set a password in XAMPP
$pass = "";     
$db   = "attendance_system";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Default admin credentials
$username = "admin";
$password_plain = "admin123";
$password_hashed = password_hash($password_plain, PASSWORD_DEFAULT);

// Check if admin already exists
$check = $conn->prepare("SELECT * FROM admins WHERE username = ?");
$check->bind_param("s", $username);
$check->execute();
$result = $check->get_result();

if ($result->num_rows > 0) {
    echo "✅ Admin account already exists. Use <b>$username / $password_plain</b> to login.";
} else {
    $stmt = $conn->prepare("INSERT INTO admins (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $password_hashed);

    if ($stmt->execute()) {
        echo "🎉 Admin account created successfully!<br>";
        echo "👉 Username: <b>$username</b><br>";
        echo "👉 Password: <b>$password_plain</b><br>";
    } else {
        echo "❌ Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
