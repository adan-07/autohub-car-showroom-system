<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}
include 'db_connect.php'; 

// --- Advanced Analytics Logic ---
// 1. Revenue & Sales Count
$res_total = mysqli_query($conn, "SELECT SUM(Price) as total_rev, COUNT(*) as sold_units FROM car WHERE Status='Sold'");
$data = mysqli_fetch_assoc($res_total);
$revenue = $data['total_rev'] ?? 0;
$units = $data['sold_units'] ?? 0;

// 2. Inventory Value (Available Cars)
$res_inv = mysqli_query($conn, "SELECT SUM(Price) as inv_val FROM car WHERE Status='Available'");
$inv_data = mysqli_fetch_assoc($res_inv);
$inventory_value = $inv_data['inv_val'] ?? 0;

// 3. Recent Sales Transactions
$res_recent = mysqli_query($conn, "SELECT * FROM car WHERE Status='Sold' ORDER BY Car_ID DESC LIMIT 5");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>AutoHub Elite | Business Intelligence</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script>
        if (localStorage.getItem('theme') === 'dark') document.documentElement.classList.add('dark');
    </script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; transition: 0.3s; margin: 0; padding: 10px 40px; }
        .dark body { background: #020617; color: #f8fafc; }
        
        .glass-card { 
            background: white; border-radius: 35px; border: 1px solid #f1f5f9;
            box-shadow: 0 20px 40px -15px rgba(0,0,0,0.03);
        }
        .dark .glass-card { background: #0f172a; border-color: #1e293b; box-shadow: none; }

        .stat-value { font-size: 2.8rem; font-weight: 900; letter-spacing: -2px; line-height: 1; }
        .label-style { font-size: 0.65rem; font-weight: 800; text-transform: uppercase; letter-spacing: 2px; color: #64748b; }
        
        .back-btn { text-decoration: none; color: #2563eb; font-weight: 800; background: white; padding: 10px 20px; border-radius: 15px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); font-size: 0.75rem; text-transform: uppercase; }
        .dark .back-btn { background: #1e293b; color: #60a5fa; border: 1px solid #334155; }
    </style>
</head>
<body class="bg-slate-50 dark:bg-[#020617]">

    <div class="flex justify-between items-center mb-8 mt-6">
        <div>
            <h1 class="text-3xl font-black italic uppercase dark:text-white">Business <span class="text-blue-600">Analytics</span></h1>
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.3em]">Financial Performance Hub</p>
        </div>
        <a href="index.php" class="back-btn">Back to Hub →</a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="glass-card p-8 border-l-8 border-l-emerald-500">
            <p class="label-style mb-4">Total Sales Revenue</p>
            <h2 class="stat-value text-emerald-600">PKR <?php echo number_format($revenue / 1000000, 1); ?>M</h2>
            <p class="text-[11px] font-bold text-slate-400 mt-2 italic">Total gross from delivered units</p>
        </div>

        <div class="glass-card p-8 border-l-8 border-l-blue-500">
            <p class="label-style mb-4">Vehicles Delivered</p>
            <h2 class="stat-value text-blue-600"><?php echo $units; ?> <span class="text-xl">Units</span></h2>
            <p class="text-[11px] font-bold text-slate-400 mt-2 italic">Successful showroom transactions</p>
        </div>

        <div class="glass-card p-8 border-l-8 border-l-purple-500">
            <p class="label-style mb-4">Current Fleet Value</p>
            <h2 class="stat-value text-purple-600">PKR <?php echo number_format($inventory_value / 1000000, 1); ?>M</h2>
            <p class="text-[11px] font-bold text-slate-400 mt-2 italic">Estimated value of available stock</p>
        </div>
    </div>

    <div class="glass-card p-10">
        <div class="flex justify-between items-center mb-8">
            <h3 class="text-xl font-black uppercase italic tracking-tighter">Recent Sales Record</h3>
            <span class="px-4 py-1 bg-blue-50 text-blue-600 dark:bg-blue-900/20 dark:text-blue-400 rounded-full text-[10px] font-black uppercase">Verified Audit</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="text-left border-b border-slate-100 dark:border-slate-800">
                        <th class="label-style pb-4">Transaction ID</th>
                        <th class="label-style pb-4">Vehicle Model</th>
                        <th class="label-style pb-4">Final Sold Price</th>
                        <th class="label-style pb-4 text-right">Verification</th>
                    </tr>
                </thead>
                <tbody class="font-bold text-sm">
                    <?php if($res_recent && mysqli_num_rows($res_recent) > 0) { 
                        while($row = mysqli_fetch_assoc($res_recent)) { ?>
                        <tr class="border-b border-slate-50 dark:border-slate-800/50 hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-all">
                            <td class="py-5 font-mono text-slate-400">#<?php echo $row['Car_ID']; ?></td>
                            <td class="py-5 dark:text-white"><?php echo $row['Model']; ?></td>
                            <td class="py-5 text-emerald-600">PKR <?php echo number_format($row['Price']); ?></td>
                            <td class="py-5 text-right">
                                <span class="bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400 text-[10px] px-3 py-1.5 rounded-xl uppercase font-black">
                                    <i class="fa-solid fa-check-double mr-1"></i> Verified Sale
                                </span>
                            </td>
                        </tr>
                    <?php } } else { ?>
                        <tr><td colspan="4" class="py-10 text-center text-slate-400 italic">No sales recorded in the current audit period.</td></tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>