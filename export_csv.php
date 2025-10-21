EXPORT CSV

<?php
session_start();
if (!isset($_SESSION["admin"])) {
    header("Location: admin_login.php");
    exit();
}

$host = "localhost";
$user = "root";
$pass = "";
$db   = "attendance_system";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

header("Content-Type: text/csv");
header("Content-Disposition: attachment; filename=attendance_export.csv");
header("Pragma: no-cache");
header("Expires: 0");

$output = fopen("php://output", "w");

// Write column headers
fputcsv($output, ["ID", "Student ID", "Name", "Time In"]);

$result = $conn->query("SELECT * FROM attendance ORDER BY time_in DESC");
while ($row = $result->fetch_assoc()) {
    fputcsv($output, $row);
}

fclose($output);
$conn->close();
exit;
?>
