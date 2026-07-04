<?php
include 'db_connect.php';

// URL se Car ID uthana
if(isset($_GET['id'])){
    $id = $_GET['id'];

    // Database se gaari khatam karne ki query
    $sql = "DELETE FROM Car WHERE Car_ID = $id";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Car record deleted successfully!'); window.location.href='view_cars.php';</script>";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}
?>