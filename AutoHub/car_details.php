<?php
session_start();
include 'db_connect.php';
$id = $_GET['id'];
$res = mysqli_query($conn, "SELECT * FROM car WHERE Car_ID = '$id'");
$car = mysqli_fetch_assoc($res);
?>
<div class="glass-card p-10 max-w-4xl mx-auto">
    <h1 class="text-4xl font-black"><?php echo $car['Model']; ?></h1>
    <div class="grid grid-cols-2 gap-8 mt-6">
        <div class="p-6 bg-slate-50 rounded-2xl">
            <p class="text-xs font-bold text-slate-400">PRICE TAG</p>
            <h2 class="text-3xl font-black text-blue-600">PKR <?php echo number_format($car['Price']); ?></h2>
        </div>
        <div class="p-6 bg-slate-50 rounded-2xl">
            <p class="text-xs font-bold text-slate-400">AVAILABILITY</p>
            <h2 class="text-xl font-black"><?php echo $car['Status']; ?></h2>
        </div>
    </div>
    <form action="place_booking.php" method="POST" class="mt-10">
        <input type="hidden" name="car_id" value="<?php echo $car['Car_ID']; ?>">
        <button type="submit" class="w-full bg-blue-600 text-white p-5 rounded-2xl font-black uppercase tracking-widest">Confirm Booking Request</button>
    </form>
</div>