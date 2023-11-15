<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pesanan</title>
    <style>
        /* (Gaya CSS Anda tetap di sini) */
    </style>
</head>

<body>
    <?php
    session_start();

    $total_harga = isset($_POST['total_harga']) ? $_POST['total_harga'] : 0;

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_checkout'])) {
        $nama = $_POST['nama'];
        $alamat = $_POST['alamat'];
        $no_hp = $_POST['no_hp'];
        $metode_pembayaran = $_POST['metode_pembayaran'];
    ?>
        <h1>Detail Pesanan</h1>
        <h2>Informasi Pembeli:</h2>
        <p><strong>Nama:</strong> <?php echo $nama; ?></p>
        <p><strong>Alamat:</strong> <?php echo $alamat; ?></p>
        <p><strong>No Hp:</strong> <?php echo $no_hp; ?></p>
        <p><strong>Metode Pembayaran:</strong> <?php echo $metode_pembayaran; ?></p>

        <h2>Total Harga:</h2>
        <?php
        // Ubah nilai total harga dari session menjadi float
        $total_harga = isset($_SESSION['totalPrice']) ? floatval($_SESSION['totalPrice']) : 0;
        echo "<p>Rp " . number_format($total_harga, 0, ',', '.') . "</p>";
        ?>

        <?php
        // Kosongkan keranjang setelah checkout
        require "koneksi.php"; // Pastikan file koneksi.php sudah di-require di awal
        $sqlEmptyCart = "DELETE FROM keranjang";
        if ($conn->query($sqlEmptyCart) === TRUE) {
        } else {
            echo "Error mengosongkan keranjang: " . $conn->error;
        }
        ?>

        <!-- Tombol kembali ke index.php -->
        <button onclick="window.location.href='index.php'">Kembali ke Beranda</button>

    <?php
    } else {
        echo "<p>Data pembeli tidak ditemukan.</p>";
    }
    ?>
</body>

</html>