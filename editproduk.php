<?php
require "koneksi.php";

// Mengecek apakah parameter ID produk telah diberikan
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Mengambil data produk berdasarkan ID
    $stmt = $conn->prepare("SELECT * FROM produk WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();
    $stmt->close();
} else {
    echo "ID produk tidak valid.";
    exit();
}

// Menangani formulir pengeditan produk yang disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $harga = floatval($_POST['harga']);
    $kategori = $_POST['kategori'];

    // Proses gambar yang diunggah
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
        $gambar = $_FILES['gambar']['name'];
        $target_dir = "upload/";
        $target_file = $target_dir . basename($gambar);

        if (move_uploaded_file($_FILES['gambar']['tmp_name'], $target_file)) {
            // Hapus gambar lama jika berhasil diunggah yang baru
            if (file_exists($target_dir . $product['gambar'])) {
                unlink($target_dir . $product['gambar']);
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    } else {
        // Jika tidak ada gambar yang diunggah, gunakan gambar yang lama
        $gambar = $product['gambar'];
    }

    // Update data produk
    $stmt = $conn->prepare("UPDATE produk SET nama=?, harga=?, kategori=?, gambar=? WHERE id=?");
    $stmt->bind_param("sissi", $nama, $harga, $kategori, $gambar, $id);

    if ($stmt->execute()) {
        echo "Product updated successfully.";
    } else {
        echo "Error updating product: " . $stmt->error;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
</head>

<body>
    <h2>Edit Product</h2>

    <!-- Form untuk mengedit produk -->
    <form action="editproduk.php?id=<?php echo $id; ?>" method="post" enctype="multipart/form-data">
        <label for="nama">Product Name:</label>
        <input type="text" name="nama" value="<?php echo $product['nama']; ?>" required><br>

        <label for="harga">Price:</label>
        <input type="number" name="harga" value="<?php echo $product['harga']; ?>" required><br>

        <label for="kategori">Category:</label>
        <select name="kategori">
            <option value="Jacket" <?php echo ($product['kategori'] == 'Jacket') ? 'selected' : ''; ?>>Jacket</option>
            <option value="T-Shirt" <?php echo ($product['kategori'] == 'T-Shirt') ? 'selected' : ''; ?>>T-Shirt</option>
            <option value="Pants" <?php echo ($product['kategori'] == 'Pants') ? 'selected' : ''; ?>>Pants</option>
            <option value="Shoes" <?php echo ($product['kategori'] == 'Shoes') ? 'selected' : ''; ?>>Shoes</option>
        </select><br>

        <label for="gambar">Product Image:</label>
        <input type="file" name="gambar"><br>

        <img src="upload/<?php echo $product['gambar']; ?>" alt="<?php echo $product['nama']; ?>" width="50"><br>

        <input type="submit" value="Update Product">

    </form>
    <button class="button" onclick="window.location.href='liatproduk.php'">Back</button>

</body>

</html>