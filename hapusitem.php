<?php
require "koneksi.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['remove_from_cart'])) {
    $item_id = $_POST['item_id'];

    // Hapus item dari keranjang berdasarkan id
    $stmt = $conn->prepare("DELETE FROM keranjang WHERE id = ?");
    $stmt->bind_param("i", $item_id);

    if ($stmt->execute()) {
        echo "Item removed from cart successfully.";
    } else {
        echo "Error removing item from cart: " . $stmt->error;
    }

    $stmt->close();
}

header("Location: keranjang.php");
exit();
?>
