<?php
include 'db_connect.php';
if(isset($_POST['register'])){
    $id = $_POST['cust_id'];
    $name = $_POST['name'];
    $cnic = $_POST['cnic'];
    $phone = $_POST['phone'];
    $addr = $_POST['address'];

    $sql = "INSERT INTO Customer (Customer_ID, Name, CNIC, Phone, Address) VALUES ('$id', '$name', '$cnic', '$phone', '$addr')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Customer Registered!'); window.location.href='view_customers.php';</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>