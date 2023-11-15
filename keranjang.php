<?php
require "koneksi.php";
session_start();

// Fungsi untuk mengambil data keranjang
function getCartItems($conn)
{
    $sql = "SELECT * FROM keranjang";
    $result = $conn->query($sql);
    return $result;
}

// Handle "Add to Cart" action
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_image = $_POST['product_image'];

    // Insert the product into the cart
    $stmt = $conn->prepare("INSERT INTO keranjang (nama, harga, gambar) VALUES (?, ?, ?)");
    $stmt->bind_param("sds", $product_name, $product_price, $product_image);

    if ($stmt->execute()) {
        echo "Product added to cart successfully.";
    } else {
        echo "Error adding product to cart: " . $stmt->error;
    }

    $stmt->close();
}

// Ambil data keranjang
$cartItems = getCartItems($conn);

// Tambahkan variabel total harga
$totalPrice = 0;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja</title>
    <style>
        /* (Gaya CSS Anda tetap di sini) */
    </style>
</head>

<body>
    <div style="text-align: left; padding: 10px;">
        <button class="button" onclick="window.location.href='index.php'">Back</button>
    </div>

    <h1>Keranjang Belanja</h1>

    <?php
    if ($cartItems->num_rows > 0) {
    ?>
        <div class="cart-list">
            <?php
            while ($item = $cartItems->fetch_assoc()) {
                echo "<div class='cart-item'>";
                echo "<h3>Produk: " . $item['nama'] . "</h3>";
                echo "Harga: " . $item['harga'] . "<br>";
                echo "Gambar: <img src='upload/" . $item['gambar'] . "' width='100'><br>";

                // Tambahkan harga produk ke total
                $totalPrice += $item['harga'];

                // Tombol Hapus
                echo "<form action='hapusitem.php' method='post'>";
                echo "<input type='hidden' name='item_id' value='" . $item['id'] . "'>";
                echo "<button type='submit' name='remove_from_cart'>Hapus</button>";
                echo "</form>";

                echo "<hr>";
                echo "</div>";
            }
            ?>
            <div style="text-align: center; margin-top: 20px;">
            <?php
            $_SESSION['totalPrice'] = $totalPrice;
            ?>
            <h2>Total Harga: <?php echo "Rp " . number_format($totalPrice, 0, ',', '.'); ?></h2>
            <a href="checkout.php">
                <button name="checkout">Checkout</button>
            </a>
        </div>
        </div>

    <?php
    } else {
        echo "<p>Keranjang belanja Anda kosong.</p>";
    }
    ?>
</body>

</html>