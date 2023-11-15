<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="katalog.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Louvy Store</title>

    <!-- Tambahkan script untuk menampilkan pop-up notifikasi -->
    <script>
        // Function to show notification
        function showNotification(message) {
            alert(message); // Anda dapat mengganti ini dengan library notifikasi yang lebih canggih
        }
    </script>
</head>

<body>
    <div style="text-align: left; padding: 10px;">
        <button class="button" onclick="window.location.href='index.php'">Back</button>
        <button class="button" onclick="window.location.href='keranjang.php'">Your Cart</button>
    </div>
    <h1>Products - Jacket</h1>

    <div class="product-list">
        <?php
        require "koneksi.php";

        // Function to get products by category
        function getProductsByCategory($conn, $category)
        {
            $sql = "SELECT * FROM produk WHERE kategori = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $category);
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();
            return $result;
        }

        $selectedCategory = "Jacket"; // Category corresponding to this page

        $products = getProductsByCategory($conn, $selectedCategory);

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_to_cart'])) {
            $product_id = $_POST['product_id'];
            $product_name = $_POST['product_name'];
            $product_price = $_POST['product_price'];
            $product_image = $_POST['product_image'];

            // Insert the product into the cart
            $stmt = $conn->prepare("INSERT INTO keranjang (nama, harga, gambar) VALUES (?, ?, ?)");
            $stmt->bind_param("sds", $product_name, $product_price, $product_image);

            if ($stmt->execute()) {
                // Panggil fungsi JavaScript untuk menampilkan notifikasi
                echo "<script>showNotification('Product added to cart successfully.');</script>";
            } else {
                echo "Error adding product to cart: " . $stmt->error;
            }

            $stmt->close();
        }

        if ($products->num_rows > 0) {
            while ($row = $products->fetch_assoc()) {
                echo "<div class='product'>";
                echo "<h2>Product: " . $row['nama'] . "</h2>";
                echo "Price: " . $row['harga'] . "<br>";
                echo "Category: " . $row['kategori'] . "<br>";
                echo "Image: <img src='upload/" . $row['gambar'] . "' width='150'><br>";

                // Replace the link with a form containing a button
                echo "<form action='jaket.php' method='post'>";
                echo "<input type='hidden' name='product_id' value='" . $row['id'] . "'>";
                echo "<input type='hidden' name='product_name' value='" . $row['nama'] . "'>";
                echo "<input type='hidden' name='product_price' value='" . $row['harga'] . "'>";
                echo "<input type='hidden' name='product_image' value='" . $row['gambar'] . "'>";
                echo "<button type='submit' name='add_to_cart'>Add to Cart</button>";
                echo "</form>";

                echo "<hr>";
                echo "</div>";
            }
        } else {
            echo "No products in the Jacket category.";
        }
        ?>
    </div>
</body>

</html>
