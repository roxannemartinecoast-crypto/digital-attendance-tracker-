
<?php
session_start();

// Database connection
$host = "localhost";
$user = "root";
$pass = "";
$db   = "attendance_system";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

$msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    $stmt = $conn->prepare("SELECT * FROM admins WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $dbPassword = $row["password"];

        // ✅ Check hashed or plain
        if (password_verify($password, $dbPassword) || $password === $dbPassword) {
            $_SESSION["admin"] = $row["username"];
            header("Location: dashboard.php");
            exit();
        } else {
            $msg = "❌ Invalid password!";
        }
    } else {
        $msg = "❌ No admin found with that username!";
    }

    $stmt->close();
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Login</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #0d1b2a;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }
    .card {
      background: #014421;
      padding: 40px;
      border-radius: 15px;
      width: 400px;
      color: white;
      text-align: center;
    }
    h2 {
      margin-bottom: 20px;
      color: #FFD700;
    }
    .input-wrapper {
      position: relative;
      margin-bottom: 15px;
    }
    input {
      width: 100%;
      padding: 12px;
      border: none;
      border-radius: 8px;
      margin-bottom: 10px;
      font-size: 16px;
    }
    .eye-icon {
      position: absolute;
      right: 10px;
      top: 50%;
      transform: translateY(-50%);
      cursor: pointer;
      background: #FFD700;
      border-radius: 50%;
      padding: 2px 6px;
      font-size: 12px;
      color: black;
    }
    button {
      width: 100%;
      padding: 14px;
      border: none;
      border-radius: 8px;
      background: #FFD700;
      color: black;
      font-size: 18px;
      font-weight: bold;
      cursor: pointer;
    }
    .msg {
      margin-top: 15px;
      color: #FFD700;
    }
  </style>
</head>
<body>
  <div class="card">
    <h2>Admin Login</h2>
    <?php if (!empty($msg)) echo "<p class='msg'>$msg</p>"; ?>
    <form method="POST">
      <input type="text" name="username" placeholder="Username" required>
      <div class="input-wrapper">
        <input type="password" name="password" id="password" placeholder="Password" required>
        <span class="eye-icon" onclick="togglePassword()">👁️</span>
      </div>
      <button type="submit">Login</button>
    </form>
  </div>

  <script>
    function togglePassword() {
      const input = document.getElementById("password");
      input.type = input.type === "password" ? "text" : "password";
    }
  </script>
</body>
</html>
