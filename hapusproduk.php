<?php
require 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $id = $_GET['id'];

    // Ambil nama file gambar sebelum menghapus data dari database
    $query = "SELECT gambar FROM produk WHERE id = $id";
    $result = mysqli_query($conn, $query);

    if ($result && $row = mysqli_fetch_assoc($result)) {
        $nama_file = $row['gambar'];

        // Hapus file gambar terkait
        $file_path = "upload/" . $nama_file;
        if (file_exists($file_path)) {
            unlink($file_path);
        } else {
            echo "File tidak ditemukan: $nama_file";
        }

        // Setelah menghapus file gambar, hapus data dari database
        $delete_query = "DELETE FROM produk WHERE id = $id";

        if (mysqli_query($conn, $delete_query)) {
            echo "<script>window.location.href = 'liatproduk.php'</script>";
        } else {
            echo "Error: " . $delete_query . "<br>" . mysqli_error($conn);
        }
    } else {
        echo "Data tidak ditemukan.";
    }

    // Menutup koneksi ke database
    $conn->close();
}
?>