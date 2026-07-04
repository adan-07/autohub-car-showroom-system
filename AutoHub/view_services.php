<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}
?>
<?php
include 'db_connect.php';
$sql = "SELECT * FROM Service_Record";
$result = $conn->query($sql);
?>
<html>
<head>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #f4f7f6; padding: 30px; }
        .container { max-width: 1000px; margin: auto; background: white; padding: 20px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #eee; }
        th { background: #2c3e50; color: white; }
        .status-badge { padding: 5px 10px; border-radius: 5px; font-size: 12px; background: #e67e22; color: white; }
    </style>
</head>
<body>
    <div class="container">
        <a href="index.php">← Back to Dashboard</a>
        <h2>🛠️ Current Service Jobs</h2>
        <table>
            <tr><th>Record ID</th><th>Date</th><th>Description</th><th>Status</th><th>Car ID</th></tr>
            <?php while($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['Record_ID']; ?></td>
                <td><?php echo $row['Date']; ?></td>
                <td><?php echo $row['Description']; ?></td>
                <td><span class="status-badge"><?php echo $row['Status']; ?></span></td>
                <td><?php echo $row['Car_ID']; ?></td>
            </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>