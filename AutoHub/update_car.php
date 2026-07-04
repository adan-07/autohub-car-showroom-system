<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $old_id = $_POST['old_id'];
    $car_id = $_POST['car_id'];
    $model = $_POST['model'];
    $make_year = $_POST['make_year'];
    $color = $_POST['color'];
    $price = $_POST['price'];
    $status = $_POST['status'];

    $sql = "UPDATE car SET 
            Car_ID = '$car_id', 
            Model = '$model', 
            Make_Year = '$make_year', 
            Color = '$color', 
            Price = '$price', 
            Status = '$status' 
            WHERE Car_ID = '$old_id'";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Vehicle Updated Successfully!'); window.location='view_cars.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>