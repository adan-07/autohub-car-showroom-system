<?php
// Salesman Duties: Register Clients, Create Sale, Test Drives
include 'db_connect.php';
$pending_tests = mysqli_query($conn, "SELECT * FROM booking WHERE Booking_Type='Test Drive' AND Status='Pending'");
?>
<div class="p-10">
    <h2 class="text-2xl font-black mb-8 italic text-purple-600">SALES & DEALS MANAGEMENT</h2>
    <div class="flex gap-4 mb-10">
        <a href="register_customer.php" class="bg-purple-600 text-white px-8 py-4 rounded-2xl font-bold">+ New Customer</a>
        <a href="create_sale.php" class="bg-slate-900 text-white px-8 py-4 rounded-2xl font-bold">Create Sale Record</a>
    </div>

    <div class="bg-white p-8 rounded-[2rem] border">
        <h3 class="font-black mb-4">Pending Test Drives (FR-18)</h3>
        <?php while($test = mysqli_fetch_assoc($pending_tests)){ ?>
            <div class="flex justify-between p-4 bg-slate-50 rounded-2xl mb-2">
                <span>Customer: <?php echo $test['Customer_ID']; ?> | Car: <?php echo $test['Car_ID']; ?></span>
                <a href="update_booking.php?id=<?php echo $test['Booking_ID']; ?>" class="text-blue-600 font-bold underline">Manage Status</a>
            </div>
        <?php } ?>
    </div>
</div>