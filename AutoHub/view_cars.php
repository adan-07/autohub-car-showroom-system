<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}
include 'db_connect.php'; 

// Search & Filter Logic
$conditions = [];
if (!empty($_GET['search'])) {
    $keyword = mysqli_real_escape_string($conn, $_GET['search']);
    $conditions[] = "(Model LIKE '%$keyword%' OR Color LIKE '%$keyword%' OR Car_ID LIKE '%$keyword%')";
}
if (!empty($_GET['min_price'])) { $conditions[] = "Price >= " . (int)$_GET['min_price']; }
if (!empty($_GET['max_price'])) { $conditions[] = "Price <= " . (int)$_GET['max_price']; }

$sql = "SELECT * FROM Car";
if (count($conditions) > 0) { $sql .= " WHERE " . implode(' AND ', $conditions); }
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>AutoHub | Inventory Management</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;700;800&display=swap" rel="stylesheet">
    
    <script>
        if (localStorage.getItem('theme') === 'dark') {
            document.documentElement.classList.add('dark-mode');
        }
    </script>

    <style>
        :root { --primary: #2563eb; --bg: #f8fafc; --dark: #0f172a; }
        .dark-mode { --bg: #030712; --dark: #f8fafc; }
        
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background: var(--bg); padding: 10px 40px; margin: 0; color: var(--dark); 
        }
        
        .header-nav { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; margin-top: 10px; }
        .back-btn { text-decoration: none; color: var(--primary); font-weight: 800; background: white; padding: 10px 20px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); font-size: 0.8rem; text-transform: uppercase; }
        .dark-mode .back-btn { background: #111827; border: 1px solid #1f2937; }

        .search-container { background: white; padding: 20px; border-radius: 20px; margin-bottom: 25px; display: flex; gap: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.02); border: 1px solid #e2e8f0; }
        .dark-mode .search-container { background: #111827; border-color: #1f2937; }
        
        .search-container input { background: #f8fafc; border: 2px solid #f1f5f9; padding: 12px; border-radius: 12px; flex: 1; outline: none; font-weight: 600; }
        .dark-mode .search-container input { background: #1f2937; border-color: #374151; color: white; }
        
        .btn-filter { background: #0f172a; color: white; padding: 12px 25px; border: none; border-radius: 12px; cursor: pointer; font-weight: 800; text-transform: uppercase; font-size: 0.75rem; }
        .dark-mode .btn-filter { background: var(--primary); }

        .inventory-card { background: white; border-radius: 24px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.03); border: 1px solid #e2e8f0; }
        .dark-mode .inventory-card { background: #111827; border-color: #1f2937; }

        thead th { background: #1e293b; color: #ffffff; padding: 18px; text-transform: uppercase; font-size: 11px; letter-spacing: 1.5px; font-weight: 800; border-right: 1px solid #334155; text-align: left; }
        tbody td { padding: 18px; border-bottom: 1px solid #f1f5f9; font-size: 0.9rem; font-weight: 700; }
        .dark-mode tbody td { border-bottom-color: #1f2937; color: #cbd5e1; }

        .id-badge { background: #f1f5f9; color: #475569; padding: 4px 10px; border-radius: 8px; font-family: monospace; font-size: 0.8rem; }
        .dark-mode .id-badge { background: #1f2937; color: #94a3b8; }

        .status { padding: 6px 12px; border-radius: 10px; font-size: 11px; font-weight: 800; text-transform: uppercase; }
        .available { background: #dcfce7; color: #166534; }
        .booked { background: #fef3c7; color: #92400e; }
        .sold { background: #fee2e2; color: #991b1b; }

        .action-btn { text-decoration: none; font-size: 11px; font-weight: 800; padding: 8px 12px; border-radius: 10px; text-transform: uppercase; transition: 0.2s; }
        .edit { background: #eff6ff; color: #2563eb; }
        .delete { background: #fff1f2; color: #e11d48; margin-left: 5px; }
    </style>
</head>
<body>

<div class="container">
    <div class="header-nav">
        <h1 style="margin: 0; font-weight: 900; font-style: italic;">🏎️ AUTOHUB <span style="color: var(--primary);">INVENTORY</span></h1>
        <a href="index.php" class="back-btn">← Dashboard</a>
    </div>

    <form class="search-container" method="GET">
        <input type="text" name="search" placeholder="Search by ID, Model or Color..." value="<?php echo @$_GET['search']; ?>">
        <input type="number" name="min_price" placeholder="Min Price" value="<?php echo @$_GET['min_price']; ?>">
        <input type="number" name="max_price" placeholder="Max Price" value="<?php echo @$_GET['max_price']; ?>">
        <button type="submit" class="btn-filter">Filter Fleet</button>
    </form>

    <div class="inventory-card">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr>
                    <th>Car ID</th>
                    <th>Model Details</th>
                    <th>Make Year</th>
                    <th>Color</th>
                    <th>Price (PKR)</th>
                    <th>Status</th>
                    <th style="text-align: center;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result && $result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        $statusClass = strtolower($row['Status']);
                        
                        echo "<tr>
                                <td><span class='id-badge'>".$row["Car_ID"]."</span></td>
                                <td>".$row["Model"]."</td>
                                <td style='color: #64748b;'>".$row["Make_Year"]."</td>
                                <td>".$row["Color"]."</td>
                                <td style='color: var(--primary);'>".number_format($row["Price"])."</td>
                                <td><span class='status $statusClass'>".$row["Status"]."</span></td>
                                <td style='text-align: center;'>
                                    <a href='edit_car.php?id=".$row['Car_ID']."' class='action-btn edit'>Edit</a>
                                    <a href='delete_car.php?id=".$row['Car_ID']."' class='action-btn delete' onclick='return confirm(\"Permanently delete this vehicle?\")'>Delete</a>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='7' style='text-align:center; padding: 40px; font-weight:bold; color:#94a3b8;'>No vehicles found in the inventory.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>