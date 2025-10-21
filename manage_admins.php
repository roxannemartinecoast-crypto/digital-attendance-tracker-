
<?php
session_start();

// ✅ Only allow logged-in admins
if (!isset($_SESSION["admin"])) {
    header("Location: admin_login.php");
    exit();
}

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

// Handle Add Admin
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add_admin"])) {
    $new_username = trim($_POST["username"]);
    $new_password = trim($_POST["password"]);
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO admins (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $new_username, $hashed_password);

    if ($stmt->execute()) {
        $msg = "✅ New admin '$new_username' added successfully!";
    } else {
        $msg = "❌ Error: " . $stmt->error;
    }
    $stmt->close();
}

// Handle Delete Admin
if (isset($_GET["delete"])) {
    $id = intval($_GET["delete"]);
    $stmt = $conn->prepare("DELETE FROM admins WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $msg = "🗑️ Admin deleted successfully!";
    } else {
        $msg = "❌ Error deleting admin.";
    }
    $stmt->close();
}

// Handle Update Password
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update_password"])) {
    $id = intval($_POST["admin_id"]);
    $new_password = trim($_POST["new_password"]);
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("UPDATE admins SET password = ? WHERE id = ?");
    $stmt->bind_param("si", $hashed_password, $id);

    if ($stmt->execute()) {
        $msg = "🔑 Password updated successfully!";
    } else {
        $msg = "❌ Error updating password.";
    }
    $stmt->close();
}

// Fetch all admins
$result = $conn->query("SELECT * FROM admins");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manage Admins</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #0d1b2a;
      color: white;
      display: flex;
      justify-content: center;
      align-items: flex-start;
      min-height: 100vh;
      margin: 0;
      padding: 20px;
    }
    .card {
      background: #014421;
      padding: 25px;
      border-radius: 12px;
      width: 650px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.3);
    }
    h2 {
      text-align: center;
      color: #FFD700;
    }
    form {
      margin-bottom: 20px;
    }
    .input-wrapper {
      position: relative;
      display: inline-block;
      width: 90%;
    }
    input {
      width: 100%;
      padding: 8px;
      margin: 6px 0;
      border-radius: 6px;
      border: none;
    }
    .eye-icon {
      position: absolute;
      right: 10px;
      top: 50%;
      transform: translateY(-50%);
      cursor: pointer;
      color: black;
      background: #FFD700;
      border-radius: 50%;
      padding: 2px 6px;
      font-size: 12px;
    }
    button {
      padding: 8px 12px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      background: #FFD700;
      color: black;
      font-weight: bold;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 15px;
      background: #001f3f;
    }
    th, td {
      padding: 10px;
      border: 1px solid #ccc;
      text-align: center;
    }
    a.delete {
      color: red;
      text-decoration: none;
      font-weight: bold;
    }
    .msg {
      text-align: center;
      margin-bottom: 10px;
      color: lightgreen;
    }
    .update-form {
      margin-top: 10px;
    }
  </style>
</head>
<body>
  <div class="card">
    <h2>👨‍💻 Manage Admins</h2>
    <?php if (!empty($msg)) echo "<p class='msg'>$msg</p>"; ?>

    <!-- Add New Admin -->
    <form method="POST">
      <input type="text" name="username" placeholder="New Admin Username" required><br>
      <div class="input-wrapper">
        <input type="password" name="password" id="newAdminPass" placeholder="New Admin Password" required>
        <span class="eye-icon" onclick="togglePassword('newAdminPass')">👁️</span>
      </div><br>
      <button type="submit" name="add_admin">➕ Add Admin</button>
    </form>

    <!-- List of Admins -->
    <h3>Existing Admins</h3>
    <table>
      <tr>
        <th>ID</th>
        <th>Username</th>
        <th>Actions</th>
      </tr>
      <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
          <td><?php echo $row["id"]; ?></td>
          <td><?php echo htmlspecialchars($row["username"]); ?></td>
          <td>
            <a class="delete" href="manage_admins.php?delete=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
            <!-- Update Password Form -->
            <form method="POST" class="update-form">
              <input type="hidden" name="admin_id" value="<?php echo $row['id']; ?>">
              <div class="input-wrapper">
                <input type="password" name="new_password" id="pass_<?php echo $row['id']; ?>" placeholder="New Password" required>
                <span class="eye-icon" onclick="togglePassword('pass_<?php echo $row['id']; ?>')">👁️</span>
              </div>
              <button type="submit" name="update_password">Update</button>
            </form>
          </td>
        </tr>
      <?php endwhile; ?>
    </table>
  </div>

  <script>
    function togglePassword(id) {
      const input = document.getElementById(id);
      if (input.type === "password") {
        input.type = "text";
      } else {
        input.type = "password";
      }
    }
  </script>
</body>
</html>
<?php $conn->close(); ?>
