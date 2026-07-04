<?php
$conn = mysqli_connect("localhost", "root", "", "autohub_db");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
// Iske neeche kuch nahi likhna