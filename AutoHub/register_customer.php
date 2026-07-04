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
    <title>AutoHub Elite | Register Client</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script>
        tailwind.config = { darkMode: 'class' }
        if (localStorage.getItem('theme') === 'dark') document.documentElement.classList.add('dark');
    </script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; transition: 0.3s; margin: 0; overflow: hidden; }
        
        /* Side Decorative Accents for Premium Look */
        .bg-accent {
            position: fixed; top: 0; bottom: 0; width: 25%; z-index: -1;
            background: radial-gradient(circle at center, rgba(168, 85, 247, 0.05) 0%, transparent 70%);
        }
        .left-accent { left: 0; border-right: 1px solid rgba(0,0,0,0.02); }
        .right-accent { right: 0; border-left: 1px solid rgba(0,0,0,0.02); }
        .dark .bg-accent { background: radial-gradient(circle at center, rgba(168, 85, 247, 0.08) 0%, transparent 70%); border-color: rgba(255,255,255,0.05); }

        .elite-card { 
            background: white; border-radius: 35px; border: 1px solid #f1f5f9;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.05);
        }
        .dark .elite-card { background: #0f172a; border-color: #1e293b; box-shadow: none; }
        
        .premium-input {
            width: 100%; padding: 12px 15px 12px 45px; border-radius: 15px;
            background: #f8fafc; border: 2px solid transparent; font-weight: 700;
            transition: 0.2s; outline: none; font-size: 0.85rem;
        }
        .dark .premium-input { background: #1e293b; color: white; border-color: #374151; }
        .premium-input:focus { border-color: #a855f7; background: white; }
        
        .input-icon { position: absolute; left: 18px; top: 38px; font-size: 0.9rem; color: #94a3b8; }
        .label-text { font-size: 0.65rem; font-weight: 800; text-transform: uppercase; letter-spacing: 1.5px; color: #64748b; margin-bottom: 6px; display: block; margin-left: 5px; }
        textarea.premium-input { min-height: 80px; resize: none; padding-top: 15px; }
    </style>
</head>
<body class="bg-[#fafafa] dark:bg-[#020617] min-h-screen flex items-center justify-center">

    <div class="bg-accent left-accent"></div>
    <div class="bg-accent right-accent"></div>

    <div class="w-full max-w-lg px-4 relative">
        <div class="flex justify-between items-end mb-6">
            <div>
                <h1 class="text-2xl font-black italic dark:text-white uppercase leading-none">Client <span class="text-purple-600">Onboard</span></h1>
                <p class="text-[9px] font-bold text-slate-400 mt-1 uppercase tracking-[0.2em]">Customer Relations Management</p>
            </div>
            <a href="index.php" class="text-[10px] font-black uppercase tracking-widest text-purple-600 hover:underline">Return to Hub →</a>
        </div>

        <form action="save_customer.php" method="POST" class="elite-card p-10">
            <div class="grid grid-cols-2 gap-5">
                
                <div class="col-span-2 relative">
                    <label class="label-text">Customer ID</label>
                    <i class="fa-solid fa-id-card-clip input-icon"></i>
                    <input type="text" name="customer_id" placeholder="CUST-101" class="premium-input" required>
                </div>

                <div class="col-span-2 relative">
                    <label class="label-text">Full Legal Name</label>
                    <i class="fa-solid fa-user-tie input-icon"></i>
                    <input type="text" name="name" placeholder="Enter Client's Name" class="premium-input" required>
                </div>

                <div class="relative">
                    <label class="label-text">CNIC Number</label>
                    <i class="fa-solid fa-address-card input-icon"></i>
                    <input type="text" name="cnic" placeholder="42101-XXXXXXX-X" class="premium-input" required>
                </div>

                <div class="relative">
                    <label class="label-text">Phone Contact</label>
                    <i class="fa-solid fa-phone-volume input-icon"></i>
                    <input type="text" name="phone" placeholder="0300-XXXXXXX" class="premium-input" required>
                </div>

                <div class="col-span-2 relative">
                    <label class="label-text">Residential Address</label>
                    <i class="fa-solid fa-map-location-dot input-icon" style="top: 38px;"></i>
                    <textarea name="address" placeholder="Complete Address Details..." class="premium-input" required style="padding-left: 45px;"></textarea>
                </div>

            </div>

            <button type="submit" class="w-full mt-8 bg-purple-600 hover:bg-purple-700 text-white p-4 rounded-2xl font-black text-xs uppercase tracking-[0.2em] transition-all shadow-lg shadow-purple-100 dark:shadow-none active:scale-95">
                Register New VIP Client
            </button>
        </form>

        <p class="text-center mt-8 text-[9px] font-bold text-slate-300 dark:text-slate-700 uppercase tracking-[0.4em]">AutoHub Elite CRM Engine</p>
    </div>

</body>
</html>