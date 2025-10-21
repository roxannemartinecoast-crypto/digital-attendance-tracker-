
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
$admin_id = $_GET['id'] ?? null;

// Handle password reset
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['admin_id'])) {
    $newPass = trim($_POST['new_password']);
    if (!empty($newPass)) {
        $hashed = password_hash($newPass, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("UPDATE admins SET password=? WHERE id=?");
        $stmt->bind_param("si", $hashed, $_POST['admin_id']);

        if ($stmt->execute()) {
            $message = "✅ Password updated successfully!";
        } else {
            $message = "⚠ Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $message = "⚠ Password cannot be empty.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Reset Password</title>
  <style>
    body {
      font-family: Arial;
      background: #001f3f;
      color: white;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }
    .card {
      background: #014421;
      padding: 25px;
      border-radius: 10px;
      text-align: center;
      width: 350px;
    }
    input, button {
      width: 90%;
      padding: 10px;
      margin: 8px 0;
      border: none;
      border-radius: 6px;
    }
    button {
      background: #FFD700;
      color: black;
      cursor: pointer;
    }
    button:hover {
      background: orange;
    }
    .toggle-password {
      position: absolute;
      right: 12px;
      top: 50%;
      transform: translateY(-50%);
      cursor: pointer;
    }
    .password-wrapper {
      position: relative;
      width: 90%;
      margin: 8px auto;
    }
    .message {
      margin-bottom: 12px;
      color: #FFD700;
      font-weight: bold;
    }
    a {
      display: inline-block;
      margin-top: 10px;
      color: #FFD700;
      text-decoration: none;
    }
  </style>
</head>
<body>
  <div class="card">
    <h2>🔑 Reset Admin Password</h2>
    <?php if (!empty($message)) echo "<p class='message'>$message</p>"; ?>
    <form method="post">
      <input type="hidden" name="admin_id" value="<?php echo htmlspecialchars($admin_id); ?>">
      <div class="password-wrapper">
        <input type="password" name="new_password" id="resetPassword" placeholder="Enter New Password" required>
        <span class="toggle-password" onclick="togglePassword('resetPassword')">👁️</span>
      </div>
      <button type="submit">Save New Password</button>
    </form>
    <a href="manage_admins.php">⬅ Back to Manage Admins</a>
  </div>

  <script>
    function togglePassword(id) {
      const input = document.getElementById(id);
      input.type = input.type === "password" ? "text" : "password";
    }
  </script>
</body>
</html>

