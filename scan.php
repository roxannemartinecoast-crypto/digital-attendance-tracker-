
<?php
// scan.php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "attendance_system"; // adjust to your DB name

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("DB Connection failed: " . $conn->connect_error);
}

if (isset($_GET['code'])) {
    $code = $conn->real_escape_string($_GET['code']);

    // Record attendance
    $stmt = $conn->prepare("INSERT INTO attendance (qr_code, scan_time) VALUES (?, NOW())");
    $stmt->bind_param("s", $code);
    if ($stmt->execute()) {
        echo "<h2>✅ Attendance recorded for code: $code</h2>";
    } else {
        echo "❌ Failed to record attendance";
    }
    $stmt->close();
} else {
    echo "⚠️ No code detected!";
}

$conn->close();
?>
