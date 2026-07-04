<?php
// Mechanic Portal: Service Requests, Parts Used, History
include 'db_connect.php';
$jobs = mysqli_query($conn, "SELECT * FROM service_jobs WHERE Status != 'Completed'");
?>
<div class="p-10">
    <h2 class="text-2xl font-black mb-8 italic text-orange-600">MECHANIC SERVICE BAY</h2>
    <div class="space-y-4">
        <?php while($job = mysqli_fetch_assoc($jobs)){ ?>
            <div class="bg-white p-6 rounded-3xl border-l-8 border-orange-500 shadow-sm">
                <div class="flex justify-between">
                    <h4 class="font-black">Car ID: <?php echo $job['Car_ID']; ?></h4>
                    <span class="text-xs font-bold text-orange-500 uppercase italic"><?php echo $job['Status']; ?></span>
                </div>
                <p class="text-slate-400 text-sm mt-1">Issue: <?php echo $job['Service_Details']; ?></p>
                <form action="update_service.php" method="POST" class="mt-4 flex gap-2">
                    <input type="hidden" name="service_id" value="<?php echo $job['Service_ID']; ?>">
                    <input type="text" name="parts" placeholder="Parts used (e.g. Oil Filter)" class="bg-slate-100 p-2 rounded-lg text-xs flex-1">
                    <button type="submit" class="bg-orange-600 text-white px-4 py-2 rounded-lg text-[10px] font-bold">Update Job</button>
                </form>
            </div>
        <?php } ?>
    </div>
</div>