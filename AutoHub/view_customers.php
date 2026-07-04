<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}
include 'db_connect.php'; 

$sql = "SELECT * FROM customer";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>AutoHub Elite | Clients</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;700;800&display=swap" rel="stylesheet">
    <script>
        if (localStorage.getItem('theme') === 'dark') {
            document.documentElement.classList.add('dark');
        }
    </script>
    <style>
        :root { --primary: #2563eb; --bg: #f8fafc; --dark: #0f172a; }
        .dark { --bg: #030712; --dark: #f8fafc; }
        
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background: var(--bg); 
            padding: 10px 40px; 
            margin: 0; 
            color: var(--dark); 
            transition: 0.3s; 
        }
        
        /* Header Fix: Back on Right */
        .header-nav { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; margin-top: 10px; }
        .back-btn { text-decoration: none; color: var(--primary); font-weight: 800; background: white; padding: 10px 18px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); font-size: 0.75rem; text-transform: uppercase; transition: 0.2s; }
        .back-btn:hover { transform: translateX(5px); }
        .dark .back-btn { background: #111827; border: 1px solid #1f2937; }

        .customer-card { background: white; border-radius: 28px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.02); border: 1px solid #e2e8f0; }
        .dark .customer-card { background: #111827; border-color: #1f2937; }

        thead th { background: #1e293b; color: #ffffff; padding: 20px; text-transform: uppercase; font-size: 11px; letter-spacing: 1.5px; font-weight: 800; text-align: left; }
        tbody td { padding: 18px 20px; border-bottom: 1px solid #f1f5f9; font-size: 0.9rem; font-weight: 700; }
        .dark tbody td { border-bottom-color: #1f2937; color: #cbd5e1; }

        /* Colorful Circle Styles */
        .attr-pill { display: inline-flex; align-items: center; gap: 10px; }
        .icon-circle { 
            width: 32px; height: 32px; border-radius: 10px; 
            display: flex; align-items: center; justify-content: center; 
            font-size: 14px; flex-shrink: 0; 
        }
        
        .bg-blue-light { background: #eff6ff; color: #2563eb; }
        .bg-purple-light { background: #faf5ff; color: #a855f7; }
        .bg-orange-light { background: #fff7ed; color: #f97316; }
        
        .dark .bg-blue-light { background: rgba(37, 99, 235, 0.1); }
        .dark .bg-purple-light { background: rgba(168, 85, 247, 0.1); }
        .dark .bg-orange-light { background: rgba(249, 115, 22, 0.1); }

        .id-badge { font-family: monospace; font-size: 0.8rem; color: #64748b; }
    </style>
</head>
<body>

<div class="container">
    <div class="header-nav">
        <h1 style="margin: 0; font-weight: 900; font-style: italic; font-size: 1.8rem;">👥 ELITE <span style="color: var(--primary);">CLIENTS</span></h1>
        <a href="index.php" class="back-btn">Back to Dashboard →</a>
    </div>

    <div class="customer-card">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr>
                    <th>Identity</th>
                    <th>Customer Name</th>
                    <th>CNIC Verification</th>
                    <th>Contact Info</th>
                    <th>Location</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result && $result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td><span class='id-badge'>#".$row["Customer_ID"]."</span></td>
                                <td style='font-size: 1rem;'>".$row["Name"]."</td>
                                
                                <td>
                                    <div class='attr-pill'>
                                        <div class='icon-circle bg-purple-light'>🆔</div>
                                        <span>".$row["CNIC"]."</span>
                                    </div>
                                </td>
                                
                                <td>
                                    <div class='attr-pill'>
                                        <div class='icon-circle bg-blue-light'>📞</div>
                                        <span>".$row["Phone"]."</span>
                                    </div>
                                </td>
                                
                                <td>
                                    <div class='attr-pill'>
                                        <div class='icon-circle bg-orange-light'>📍</div>
                                        <span style='font-size: 0.8rem; opacity: 0.8;'>".$row["Address"]."</span>
                                    </div>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5' style='text-align:center; padding: 50px;'>No registered clients found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>