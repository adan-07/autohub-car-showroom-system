<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['logged_in'])) {
    header("Location: login.php");
    exit();
}

$res = mysqli_query($conn, "SELECT COUNT(*) as t FROM car");
$count = mysqli_fetch_assoc($res)['t'] ?? 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Hub | AutoHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body { background: #020617; color: white; padding: 50px; font-family: sans-serif; }
        .card { background: linear-gradient(135deg, #2563eb, #1e40af); border-radius: 40px; padding: 40px; text-decoration: none; color: white; transition: 0.3s; display: block; }
        .card:hover { transform: translateY(-10px); filter: brightness(1.1); }
    </style>
</head>
<body>
    <div class="flex justify-between items-center mb-16">
        <h1 class="text-4xl font-black italic">ADMIN <span class="text-blue-500">HUB</span></h1>
        <a href="logout.php" class="bg-red-500 text-white px-8 py-3 rounded-2xl text-[10px] font-bold uppercase tracking-widest">Logout</a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <a href="view_cars.php" class="card">
            <h3 class="text-3xl font-black italic">FLEET</h3>
            <div class="flex justify-between items-end mt-10">
                <span class="text-6xl font-black opacity-30"><?php echo $count; ?></span>
                <i class="fa-solid fa-car text-4xl opacity-40"></i>
            </div>
        </a>
    </div>
</body>
</html>