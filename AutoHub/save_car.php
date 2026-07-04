<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // ER Diagram ke exact names
    $car_id = mysqli_real_escape_string($conn, $_POST['car_id']);
    $model = mysqli_real_escape_string($conn, $_POST['model']);
    $make_year = mysqli_real_escape_string($conn, $_POST['make_year']);
    $color = mysqli_real_escape_string($conn, $_POST['color']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    $sql = "INSERT INTO car (Car_ID, Model, Make_Year, Color, Price, Status) 
            VALUES ('$car_id', '$model', '$make_year', '$color', '$price', '$status')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Vehicle Saved Successfully!'); window.location='view_cars.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>