DASHBOARD:

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

$result = $conn->query("SELECT * FROM attendance ORDER BY time_in DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #001f3f;
      color: white;
      margin: 0;
      padding: 20px;
    }
    .topbar {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
      background: #014421;
    }
    th, td {
      padding: 10px;
      border: 1px solid #ccc;
      text-align: center;
    }
    th { background: #007bff; }
    a.button {
      background: #FFD700;
      padding: 8px 12px;
      border-radius: 6px;
      color: black;
      text-decoration: none;
      font-weight: bold;
    }
    a.button:hover {
      background: orange;
    }
  </style>
</head>
<body>
  <div class="topbar">
    <h2>Admin Dashboard</h2>
    <div>
      <a href="add_admin.php" class="button">➕ Add Admin</a>
      <a href="manage_admins.php" class="button">👥 Manage Admins</a>
      <a href="export_csv.php" class="button">⬇ Export CSV</a>
      <a href="logout.php" class="button">Logout</a>
    </div>
  </div>

  <table>
    <tr>
      <th>ID</th>
      <th>Student ID</th>
      <th>Name</th>
      <th>Time In</th>
    </tr>
    <?php while($row = $result->fetch_assoc()): ?>
      <tr>
        <td><?php echo $row["id"]; ?></td>
        <td><?php echo $row["student_id"]; ?></td>
        <td><?php echo $row["student_name"]; ?></td>
        <td><?php echo $row["time_in"]; ?></td>
      </tr>
    <?php endwhile; ?>
  </table>
</body>
</html>
