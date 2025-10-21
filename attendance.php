
<?php
// Database connection
$host = "localhost";
$user = "root";       // change if needed
$pass = "";           // change if needed
$db   = "attendance_system";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Default values
$message = "Invalid QR code.";
$studentID = "";
$studentName = "";
$timestamp = "";

if (isset($_GET['id']) && isset($_GET['name'])) {
    $studentID = $_GET['id'];
    $studentName = $_GET['name'];
    $timestamp = date("Y-m-d H:i:s");

    // Insert attendance record
    $sql = "INSERT INTO attendance (student_id, student_name, time_in) 
            VALUES ('$studentID', '$studentName', '$timestamp')";
    
    if ($conn->query($sql) === TRUE) {
        $message = "Thank You for Attending My Class Today!";
    } else {
        $message = "Database Error: " . $conn->error;
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Attendance Confirmation</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #0d1b2a; /* Dark Blue */
      color: white;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
      padding: 10px;
    }
    .card {
      background: #014421; /* Army Green */
      padding: 25px;
      border-radius: 12px;
      text-align: center;
      box-shadow: 0 4px 12px rgba(0,0,0,0.3);
      width: 90%;
      max-width: 380px;
    }
    h2 {
      color: #FFD700; /* Gold for message */
      font-size: 1.4rem;
      margin-bottom: 15px;
    }
    p {
      margin: 8px 0;
      font-size: 1rem;
    }
    @media (max-width: 500px) {
      h2 {
        font-size: 1.2rem;
      }
      p {
        font-size: 0.95rem;
      }
    }
  </style>
</head>
<body>
  <div class="card">
    <h2><?php echo $message; ?> 🎉</h2>
    <?php if ($studentID && $studentName): ?>
      <p><strong>Student ID:</strong> <?php echo htmlspecialchars($studentID); ?></p>
      <p><strong>Name:</strong> <?php echo htmlspecialchars($studentName); ?></p>
      <p><strong>Time:</strong> <?php echo $timestamp; ?></p>
    <?php endif; ?>
  </div>
</body>
</html>

