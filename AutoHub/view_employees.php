<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}
include 'db_connect.php'; 

// Fetching Team Data
$sql = "SELECT * FROM salesman";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>AutoHub Elite | Team Management</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
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
        
        /* Premium Header */
        .header-nav { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; margin-top: 10px; }
        .back-btn { text-decoration: none; color: var(--primary); font-weight: 800; background: white; padding: 10px 18px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); font-size: 0.75rem; text-transform: uppercase; transition: 0.2s; }
        .dark .back-btn { background: #111827; border: 1px solid #1f2937; }

        /* Table Card Design */
        .team-card { background: white; border-radius: 28px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.02); border: 1px solid #e2e8f0; }
        .dark .team-card { background: #111827; border-color: #1f2937; }

        thead th { background: #1e293b; color: #ffffff; padding: 18px; text-transform: uppercase; font-size: 11px; letter-spacing: 1.5px; font-weight: 800; text-align: left; }
        tbody td { padding: 18px 20px; border-bottom: 1px solid #f1f5f9; font-size: 0.9rem; font-weight: 700; }
        .dark tbody td { border-bottom-color: #1f2937; color: #cbd5e1; }

        /* Colorful Attribute Pills */
        .attr-pill { display: inline-flex; align-items: center; gap: 10px; }
        .icon-circle { 
            width: 32px; height: 32px; border-radius: 10px; 
            display: flex; align-items: center; justify-content: center; 
            font-size: 13px; flex-shrink: 0; 
        }
        
        .bg-blue-light { background: #eff6ff; color: #2563eb; }
        .bg-yellow-light { background: #fefce8; color: #a16207; }
        .bg-emerald-light { background: #ecfdf5; color: #059669; }
        
        .dark .bg-blue-light { background: rgba(37, 99, 235, 0.1); }
        .dark .bg-yellow-light { background: rgba(161, 98, 7, 0.1); }
        .dark .bg-emerald-light { background: rgba(5, 150, 105, 0.1); }

        .id-badge { font-family: monospace; font-size: 0.8rem; color: #64748b; }
    </style>
</head>
<body>

<div class="container">
    <div class="header-nav">
        <h1 style="margin: 0; font-weight: 900; font-style: italic; font-size: 1.8rem;">👔 MANAGE <span style="color: var(--primary);">SALES TEAM</span></h1>
        <a href="index.php" class="back-btn">Back to Dashboard →</a>
    </div>

    <div class="team-card">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr>
                    <th>Identity</th>
                    <th>Full Name</th>
                    <th>Contact Info</th>
                    <th>Official Email</th>
                    <th>Salary (PKR)</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result && $result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        // Fix for Potential Undefined Keys (Safe Check)
                        $salary = isset($row['Salary']) ? number_format($row['Salary']) : "0";
                        $phone = isset($row['Phone']) ? $row['Phone'] : "N/A";
                        $email = isset($row['Email']) ? $row['Email'] : "N/A";

                        echo "<tr>
                                <td><span class='id-badge'>#".$row["Salesman_ID"]."</span></td>
                                <td style='font-size: 1rem;'>".$row["Name"]."</td>
                                
                                <td>
                                    <div class='attr-pill'>
                                        <div class='icon-circle bg-blue-light'><i class='fa-solid fa-phone'></i></div>
                                        <span>".$phone."</span>
                                    </div>
                                </td>
                                
                                <td>
                                    <div class='attr-pill'>
                                        <div class='icon-circle bg-yellow-light'><i class='fa-solid fa-envelope'></i></div>
                                        <span style='font-size: 0.85rem;'>".$email."</span>
                                    </div>
                                </td>
                                
                                <td>
                                    <div class='attr-pill'>
                                        <div class='icon-circle bg-emerald-light'><i class='fa-solid fa-money-bill-wave'></i></div>
                                        <span style='color: #059669; font-weight: 900;'>".$salary."</span>
                                    </div>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5' style='text-align:center; padding: 50px; opacity: 0.5;'>No team members added to the roster yet.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>