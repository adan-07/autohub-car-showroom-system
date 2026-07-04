<?php
session_start();
// Security Check
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

include 'db_connect.php'; 

// Database Metrics - Fetching real counts for cards
$res_cars = mysqli_query($conn, "SELECT COUNT(Car_ID) as total FROM car");
$total_cars = mysqli_fetch_assoc($res_cars)['total'] ?? 0;

$res_clients = mysqli_query($conn, "SELECT COUNT(Customer_ID) as total FROM customer");
$total_clients = mysqli_fetch_assoc($res_clients)['total'] ?? 0;

$res_salesman = mysqli_query($conn, "SELECT COUNT(Salesman_ID) as total FROM salesman"); 
$total_salesman = mysqli_fetch_assoc($res_salesman)['total'] ?? 0;

$res_revenue = mysqli_query($conn, "SELECT SUM(Price) as total FROM car WHERE Status='Sold'");
$total_revenue = mysqli_fetch_assoc($res_revenue)['total'] ?? 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AutoHub Elite | Premium Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;700;800&display=swap" rel="stylesheet">
    <script>
        tailwind.config = { darkMode: 'class' }
        if (localStorage.getItem('theme') === 'dark') document.documentElement.classList.add('dark');
    </script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; transition: 0.3s; margin: 0; }
        .sidebar { width: 280px; height: 100vh; position: fixed; left: 0; top: 0; z-index: 50; overflow-y: auto; }
        .main-content { margin-left: 280px; padding: 2.5rem; width: calc(100% - 280px); min-height: 100vh; }
        
        .nav-link { display: flex; align-items: center; gap: 12px; padding: 12px 18px; border-radius: 16px; font-weight: 700; font-size: 0.85rem; transition: 0.3s; margin-bottom: 6px; }
        .active-link { background: #2563eb !important; color: white !important; box-shadow: 0 10px 15px -3px rgba(37, 99, 235, 0.3); }
        .icon-box { width: 32px; height: 32px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 14px; flex-shrink: 0; }
        
        .stat-card { transition: 0.3s; border-radius: 2.5rem; color: white; padding: 2rem; position: relative; overflow: hidden; }
        .stat-card:hover { transform: translateY(-8px); }
        .bg-blue-grad { background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%); }
        .bg-purple-grad { background: linear-gradient(135deg, #a855f7 0%, #6b21a8 100%); }
        .bg-orange-grad { background: linear-gradient(135deg, #f97316 0%, #c2410c 100%); }
        .bg-emerald-grad { background: linear-gradient(135deg, #10b981 0%, #064e3b 100%); }
    </style>
</head>
<body class="bg-slate-50 text-slate-900 dark:bg-slate-950 dark:text-white flex">

    <aside class="sidebar bg-white dark:bg-slate-900 p-6 flex flex-col border-r border-slate-100 dark:border-slate-800">
        <div class="flex items-center gap-3 mb-10">
            <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center text-white font-black italic shadow-lg">A</div>
            <h1 class="text-xl font-black tracking-tighter uppercase">Auto Hub</h1>
        </div>
        
        <nav class="flex-1">
            <a href="index.php" class="nav-link active-link">
                <span class="icon-box bg-blue-100 text-blue-600 dark:bg-blue-900/30">🏠</span> <span>Dashboard Hub</span>
            </a>
            
            <p class="text-[10px] font-black text-slate-300 uppercase tracking-widest mt-8 mb-4 ml-2">Fleet Management</p>
            <a href="view_cars.php" class="nav-link text-slate-500 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800">
                <span class="icon-box bg-cyan-100 text-cyan-600 dark:bg-cyan-900/30">🚘</span> <span>View Inventory</span>
            </a>
            <a href="add_car.php" class="nav-link text-slate-500 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800">
                <span class="icon-box bg-green-100 text-green-600 dark:bg-green-900/30">➕</span> <span>New Acquisition</span>
            </a>

            <p class="text-[10px] font-black text-slate-300 uppercase tracking-widest mt-8 mb-4 ml-2">Core Management</p>
            <a href="view_customers.php" class="nav-link text-slate-500 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800">
                <span class="icon-box bg-purple-100 text-purple-600 dark:bg-purple-900/30">👥</span> <span>Client List</span>
            </a>
            <a href="register_customer.php" class="nav-link text-slate-500 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800">
                <span class="icon-box bg-orange-100 text-orange-600 dark:bg-orange-900/30">📝</span> <span>Registration</span>
            </a>
            <a href="view_employees.php" class="nav-link text-slate-500 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800">
                <span class="icon-box bg-yellow-100 text-yellow-600 dark:bg-yellow-900/30">👔</span> <span>Manage Team</span>
            </a>

            <p class="text-[10px] font-black text-slate-300 uppercase tracking-widest mt-8 mb-4 ml-2">Business Intel</p>
            <a href="sales_report.php" class="nav-link text-slate-500 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800">
                <span class="icon-box bg-emerald-100 text-emerald-600 dark:bg-emerald-900/30">📊</span> <span>Sales Report</span>
            </a>
        </nav>

        <a href="logout.php" class="mt-4 flex items-center justify-center gap-3 p-4 rounded-2xl bg-red-50 text-red-600 font-bold border border-red-100 transition-all hover:bg-red-100">
            <span>🚪</span> <span>Exit System</span>
        </a>
    </aside>

    <main class="main-content">
        <header class="flex justify-between items-center mb-10">
            <div>
                <h2 class="text-5xl font-black tracking-tight mb-1 italic">Welcome Back! 👋</h2>
                <p class="text-slate-400 dark:text-slate-500 font-bold text-sm uppercase tracking-widest">Showroom Performance Overview</p>
            </div>
            <button onclick="toggleDarkMode()" id="modeToggleBtn" class="p-3 px-5 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm flex items-center gap-3 transition-all hover:scale-105">
                <span id="modeIcon">🌙</span> <span id="modeText" class="text-xs font-black uppercase">Dark Mode</span>
            </button>
        </header>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">
            <div class="stat-card bg-blue-grad shadow-xl shadow-blue-100 dark:shadow-none">
                <p class="text-[10px] font-black uppercase opacity-70 tracking-widest">Total Fleet</p>
                <h3 class="text-5xl font-black mt-2"><?php echo $total_cars; ?></h3>
            </div>
            <div class="stat-card bg-purple-grad shadow-xl shadow-purple-100 dark:shadow-none">
                <p class="text-[10px] font-black uppercase opacity-70 tracking-widest">Verified Clients</p>
                <h3 class="text-5xl font-black mt-2"><?php echo $total_clients; ?></h3>
            </div>
            <div class="stat-card bg-orange-grad shadow-xl shadow-orange-100 dark:shadow-none">
                <p class="text-[10px] font-black uppercase opacity-70 tracking-widest">Sales Experts</p>
                <h3 class="text-5xl font-black mt-2"><?php echo $total_salesman; ?></h3>
            </div>
            <div class="stat-card bg-emerald-grad shadow-xl shadow-emerald-100 dark:shadow-none">
                <p class="text-[10px] font-black uppercase opacity-70 tracking-widest">Total Revenue</p>
                <h3 class="text-4xl font-black mt-3">PKR <?php echo number_format($total_revenue / 1000000, 1); ?>M</h3>
            </div>
        </div>

        <div class="bg-white dark:bg-slate-900 p-10 rounded-[3rem] border border-slate-100 dark:border-slate-800 shadow-sm">
            <h4 class="text-xl font-black mb-6 uppercase tracking-tighter">Authorized System Activity</h4>
            <div class="space-y-4">
                <div class="flex items-center justify-between p-5 bg-slate-50 dark:bg-slate-800/50 rounded-3xl border border-transparent hover:border-blue-200 transition-all">
                    <div class="flex items-center gap-4">
                        <span class="w-10 h-10 bg-blue-100 dark:bg-blue-900/30 rounded-xl flex items-center justify-center text-lg">🛡️</span>
                        <div>
                            <p class="font-black text-sm">System Online: Encrypted Connection</p>
                            <p class="text-[10px] text-slate-400 font-bold tracking-wide">All showroom records are synced with ER Diagram.</p>
                        </div>
                    </div>
                    <span class="text-[10px] font-black text-slate-300">ACTIVE</span>
                </div>
            </div>
        </div>
    </main>

    <script>
        function toggleDarkMode() {
            const html = document.documentElement;
            const isDark = html.classList.toggle('dark');
            localStorage.setItem('theme', isDark ? 'dark' : 'light');
            updateToggleUI(isDark);
        }
        function updateToggleUI(isDark) {
            document.getElementById('modeIcon').innerText = isDark ? "☀️" : "🌙";
            document.getElementById('modeText').innerText = isDark ? "Light Mode" : "Dark Mode";
        }
        if (localStorage.getItem('theme') === 'dark') updateToggleUI(true);
    </script>
</body>
</html>