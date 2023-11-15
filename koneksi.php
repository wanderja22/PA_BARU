<?php
// Hubungkan ke database (gantilah dengan informasi koneksi database Anda)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "shop_db";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// In koneksi.php

function getCountProductsByCategory($conn, $category) {
    $sql = "SELECT COUNT(*) AS count FROM produk WHERE kategori = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $category);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close();
    return $row['count'];
}

function getCountJacketProducts($conn) {
    return getCountProductsByCategory($conn, "Jacket");
}
function getCountTShirtProducts($conn) {
    return getCountProductsByCategory($conn, "T-Shirt");
}

function getCountPantsProducts($conn) {
    return getCountProductsByCategory($conn, "Pants");
}

function getCountShoesProducts($conn) {
    return getCountProductsByCategory($conn, "Shoes");
}



?>
