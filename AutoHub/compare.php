<div class="grid grid-cols-2 gap-4">
    <div class="comparison-column border-r p-6">
        <h3 class="font-black"><?php echo $car1['Model']; ?></h3>
        <p>Price: <?php echo number_format($car1['Price']); ?></p>
        <p>Year: <?php echo $car1['Make_Year']; ?></p>
    </div>
    <div class="comparison-column p-6">
        <h3 class="font-black"><?php echo $car2['Model']; ?></h3>
        <p>Price: <?php echo number_format($car2['Price']); ?></p>
        <p>Year: <?php echo $car2['Make_Year']; ?></p>
    </div>
</div>