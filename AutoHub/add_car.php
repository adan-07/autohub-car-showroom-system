<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}
include 'db_connect.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>AutoHub Elite | Add Vehicle</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script>
        tailwind.config = { darkMode: 'class' }
        if (localStorage.getItem('theme') === 'dark') document.documentElement.classList.add('dark');
    </script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; transition: 0.3s; margin: 0; overflow: hidden; }
        
        /* Side Decorative Backgrounds */
        .bg-ornament {
            position: fixed; top: 0; bottom: 0; width: 30%; z-index: -1;
            background: radial-gradient(circle at center, rgba(37, 99, 235, 0.05) 0%, transparent 70%);
        }
        .left-ornament { left: 0; border-right: 1px solid rgba(0,0,0,0.03); }
        .right-ornament { right: 0; border-left: 1px solid rgba(0,0,0,0.03); }
        .dark .bg-ornament { background: radial-gradient(circle at center, rgba(37, 99, 235, 0.1) 0%, transparent 70%); border-color: rgba(255,255,255,0.05); }

        .elite-form-card { 
            background: white; border-radius: 35px; border: 1px solid #f1f5f9;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.08);
        }
        .dark .elite-form-card { background: #0f172a; border-color: #1e293b; box-shadow: none; }
        
        .premium-input {
            width: 100%; padding: 12px 15px 12px 45px; border-radius: 14px;
            background: #f8fafc; border: 2px solid transparent; font-weight: 700;
            transition: 0.2s; outline: none; font-size: 0.85rem;
        }
        .dark .premium-input { background: #1e293b; color: white; border-color: #334151; }
        .premium-input:focus { border-color: #2563eb; background: white; }
        
        .input-icon { position: absolute; left: 18px; top: 38px; font-size: 0.9rem; color: #94a3b8; }
        .label-style { font-size: 0.65rem; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; color: #64748b; margin-bottom: 6px; display: block; }
    </style>
</head>
<body class="bg-[#fcfdfe] dark:bg-[#020617] min-h-screen flex items-center justify-center">

    <div class="bg-ornament left-ornament"></div>
    <div class="bg-ornament right-ornament"></div>

    <div class="w-full max-w-lg px-4 relative">
        <div class="flex justify-between items-end mb-6">
            <div>
                <h1 class="text-2xl font-black italic dark:text-white uppercase leading-none">Add <span class="text-blue-600">Fleet</span></h1>
                <p class="text-[10px] font-bold text-slate-400 mt-1 uppercase tracking-widest">Inventory Management</p>
            </div>
            <a href="index.php" class="text-[10px] font-black uppercase tracking-widest text-blue-600 hover:underline">Back to Hub →</a>
        </div>

        <form action="save_car.php" method="POST" class="elite-form-card p-10">
            <div class="grid grid-cols-2 gap-5">
                
                <div class="col-span-2 relative">
                    <label class="label-style">Vehicle Identity ID</label>
                    <i class="fa-solid fa-hashtag input-icon"></i>
                    <input type="text" name="car_id" placeholder="C-101" class="premium-input" required>
                </div>

                <div class="col-span-2 relative">
                    <label class="label-style">Model Name</label>
                    <i class="fa-solid fa-car input-icon"></i>
                    <input type="text" name="model" placeholder="Enter Vehicle Model" class="premium-input" required>
                </div>

                <div class="relative">
                    <label class="label-style">Make Year</label>
                    <i class="fa-solid fa-calendar input-icon"></i>
                    <input type="number" name="make_year" placeholder="2024" class="premium-input" required>
                </div>

                <div class="relative">
                    <label class="label-style">Color</label>
                    <i class="fa-solid fa-palette input-icon"></i>
                    <input type="text" name="color" placeholder="e.g. Black" class="premium-input" required>
                </div>

                <div class="relative">
                    <label class="label-style">Price (PKR)</label>
                    <i class="fa-solid fa-money-bill-wave input-icon"></i>
                    <input type="number" name="price" placeholder="Price" class="premium-input" required>
                </div>

                <div class="relative">
                    <label class="label-style">Status</label>
                    <i class="fa-solid fa-shield-check input-icon"></i>
                    <select name="status" class="premium-input appearance-none">
                        <option value="Available">Available</option>
                        <option value="Booked">Booked</option>
                        <option value="Sold">Sold</option>
                    </select>
                </div>

            </div>

            <button type="submit" class="w-full mt-8 bg-blue-600 hover:bg-blue-700 text-white p-4 rounded-2xl font-black text-xs uppercase tracking-widest transition-all shadow-lg shadow-blue-100 dark:shadow-none active:scale-95">
                Save Vehicle to Showroom
            </button>
        </form>

        <p class="text-center mt-8 text-[9px] font-bold text-slate-300 dark:text-slate-700 uppercase tracking-[0.4em]">AutoHub Elite Inventory Engine</p>
    </div>

</body>
</html>