<?php
// Customer Views: Search, Details, Compare, Book
include 'db_connect.php';
$search = $_GET['search'] ?? '';
$sql = "SELECT * FROM car WHERE Status='Available' AND Model LIKE '%$search%'";
$cars = $conn->query($sql);
?>
<nav class="p-6 flex justify-between bg-white shadow-sm rounded-b-[2rem]">
    <div class="font-black text-xl italic">AUTOHUB <span class="text-blue-600">SHOP</span></div>
    <div class="flex gap-6 font-bold text-xs uppercase">
        <a href="compare.php">Compare Cars</a>
        <a href="my_history.php">My Bookings</a>
    </div>
</nav>

<div class="grid grid-cols-3 gap-8 p-12">
    <?php while($c = $cars->fetch_assoc()){ ?>
        <div class="bg-white p-6 rounded-[2.5rem] border hover:shadow-2xl transition">
            <h3 class="text-2xl font-black"><?php echo $c['Model']; ?></h3>
            <p class="text-blue-600 font-extrabold text-lg">PKR <?php echo number_format($c['Price']); ?></p>
            <div class="flex gap-2 mt-6">
                <a href="car_details.php?id=<?php echo $c['Car_ID']; ?>" class="flex-1 bg-slate-900 text-white text-center p-3 rounded-xl text-[10px] font-bold uppercase">Details</a>
                <a href="book_now.php?id=<?php echo $c['Car_ID']; ?>" class="flex-1 bg-blue-600 text-white text-center p-3 rounded-xl text-[10px] font-bold uppercase">Book Now</a>
            </div>
        </div>
    <?php } ?>
</div>