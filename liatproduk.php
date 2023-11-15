<?php
require "koneksi.php";

// Query to retrieve products and order them by category
$sql = "SELECT * FROM produk ORDER BY kategori";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List</title>
</head>

<body>
    <h2>Product List</h2>

    <!-- Display products in a table -->
    <table border="1">
        <tr>
            <th>Name</th>
            <th>Price</th>
            <th>Category</th>
            <th>Image</th>
            <th>Action</th>
        </tr>

        <?php
        // Loop through each row in the result set
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>{$row['nama']}</td>";
            echo "<td>{$row['harga']}</td>";
            echo "<td>{$row['kategori']}</td>";
            echo "<td><img src='upload/{$row['gambar']}' alt='{$row['nama']}' width='50'></td>";
            echo "<td><a href='editproduk.php?id={$row['id']}'>Edit</a> | <a href='hapusproduk.php?id=" . $row['id'] . "' onclick='return confirm(\"Apakah Anda yakin ingin menghapus data?\")'>Delete</a></td>";
            echo "</tr>";
        }
        ?>
    </table>
    <div>
        <button class="button" onclick="window.location.href='tambahproduk.php'">Create Produk</button>
    </div>

</body>

</html>