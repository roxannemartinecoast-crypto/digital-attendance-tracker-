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

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    if (!empty($username) && !empty($password)) {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO admins (username, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $username, $hashed);

        if ($stmt->execute()) {
            $message = "✅ New admin '$username' added successfully!";
        } else {
            $message = "⚠ Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        $message = "⚠ Please enter both username and password.";
    }
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add New Admin</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #001f3f;
      color: white;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
      padding: 10px;
    }
    .card {
      background: #014421;
      padding: 40px 35px;
      border-radius: 20px;
      text-align: center;
      width: 420px;
      box-shadow: 0 5px 25px rgba(0,0,0,0.3);
    }
    .card h2 {
      margin-bottom: 20px;
    }
    input {
      width: 100%;
      padding: 12px 14px;
      margin: 10px 0;
      border: none;
      border-radius: 8px;
      font-size: 16px;
      box-sizing: border-box;
    }
    .password-wrapper {
      position: relative;
      width: 100%;
      margin-top: 10px;
    }
    .password-wrapper input {
      width: 100%;
      padding-right: 40px;
    }
    .toggle-password {
      position: absolute;
      right: 12px;
      top: 50%;
      transform: translateY(-50%);
      cursor: pointer;
      font-size: 20px;
      color: #333;
      user-select: none;
    }
    button {
      width: 100%;
      padding: 12px;
      background: #FFD700;
      color: black;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      font-size: 17px;
      font-weight: bold;
      margin-top: 15px;
    }
    button:hover {
      background: orange;
    }
    .message {
      margin-top: 10px;
      font-weight: bold;
    }
    a {
      display: inline-block;
      margin-top: 15px;
      color: #FFD700;
      text-decoration: none;
      font-size: 15px;
    }
    a:hover {
      text-decoration: underline;
    }

    /* 🔹 Mobile Responsive Design */
    @media (max-width: 480px) {
      .card {
        width: 90%;
        padding: 25px 20px;
      }
      input, button {
        font-size: 15px;
      }
      .toggle-password {
        right: 10px;
        font-size: 18px;
      }
    }
  </style>
</head>
<body>
  <div class="card">
    <h2>Add New Admin</h2>
    <?php if (!empty($message)) echo "<p class='message'>$message</p>"; ?>
    <form method="post">
      <input type="text" name="username" placeholder="New Username" required>
      <div class="password-wrapper">
        <input type="password" name="password" id="newAdminPassword" placeholder="New Password" required>
        <span class="toggle-password" onclick="togglePassword('newAdminPassword')">👁️</span>
      </div>
      <button type="submit">➕ Add Admin</button>
    </form>
    <a href="dashboard.php">⬅ Back to Dashboard</a>
  </div>

  <script>
    function togglePassword(id) {
      const field = document.getElementById(id);
      field.type = field.type === "password" ? "text" : "password";
    }
  </script>
</body>
</html>
