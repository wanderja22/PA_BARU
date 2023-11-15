<?php
require "koneksi.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari formulir
    $nama = $_POST['nama'];
    $harga = floatval($_POST['harga']); // Mengubah harga menjadi tipe float
    $kategori = $_POST['kategori'];

    // Proses gambar yang diunggah
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
        $gambar = $_FILES['gambar']['name'];
        $target_dir = "upload/";
        $target_file = $target_dir . basename($gambar);

        // Cek apakah gambar sudah diunggah dengan sukses
        if (move_uploaded_file($_FILES['gambar']['tmp_name'], $target_file)) {
            echo "The image file has been uploaded successfully.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    } else {
        echo "No image uploaded or an error occurred while uploading.";
    }

    // Validasi data
    if (!empty($nama) && is_numeric($harga) && $harga > 0 && !empty($kategori) && isset($gambar)) {
        // Gunakan prepared statement untuk menghindari SQL Injection
        $stmt = $conn->prepare("INSERT INTO produk (nama, harga, kategori, gambar) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("siss", $nama, $harga, $kategori, $gambar);

        if ($stmt->execute()) {
            echo "Product added successfully.";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Invalid data provided.";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah</title>
</head>

<body>
    <!-- Form to add a new product with an image -->
    <form action="tambahproduk.php" method="post" enctype="multipart/form-data">
        <label for="nama">Product Name:</label>
        <input type="text" name="nama" required><br>

        <label for="harga">Price:</label>
        <input type="number" name="harga" required><br>

        <label for="kategori">Category:</label>
        <select name="kategori">
            <option value="Jacket">Jacket</option>
            <option value="T-Shirt">T-Shirt</option>
            <option value="Pants">Pants</option>
            <option value="Shoes">Shoes</option>
        </select><br>

        <label for="gambar">Product Image:</label>
        <input type="file" name="gambar" required><br>

        <input type="submit" value="Add Product">
    </form>
</body>

</html>
