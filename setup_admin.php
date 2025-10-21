
<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "attendance_system";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

$username = "admin";
$password = "admin"; // plain text
$hashed   = password_hash($password, PASSWORD_DEFAULT);

$stmt = $conn->prepare("INSERT INTO admins (username, password) VALUES (?, ?)");
$stmt->bind_param("ss", $username, $hashed);

if ($stmt->execute()) {
    echo "Admin account created successfully! (username: admin, password: admin)";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();

