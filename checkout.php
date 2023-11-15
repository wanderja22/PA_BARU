<?php
require "koneksi.php";

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir Data Pembeli</title>
    <style>
        /* (Gaya CSS Anda tetap di sini) */
    </style>
</head>

<body>
    <h1>Formulir Data Pembeli</h1>

    <!-- Tambahkan formulir pengisian data diri pembeli di sini -->
    <form action="detailpesanan.php" method="post">
        <label for="nama">Nama:</label>
        <input type="text" id="nama" name="nama" required>

        <label for="alamat">Alamat:</label>
        <input type="text" id="alamat" name="alamat" required>

        <label for="no_hp">No Hp:</label>
        <input type="text" id="no_hp" name="no_hp" required>

        <label for="metode_pembayaran">Metode Pembayaran:</label>
        <select id="metode_pembayaran" name="metode_pembayaran" required>
            <option value="COD">COD</option>
            <option value="NGUTANG">NGUTANG</option>
            <optgroup label="Transfer Bank">
                <option value="Bank BNI">Bank BNI</option>
                <option value="Bank BCA">Bank BCA</option>
                <option value="Bank BRI">Bank BRI</option>
            </optgroup>
            <!-- Tambahkan opsi metode pembayaran lain sesuai kebutuhan -->
        </select>

        <!-- Tambahkan input tersembunyi untuk total harga -->
        <input type="hidden" name="total_harga" value="<?php echo $totalPrice; ?>">

        <button type="submit" name="submit_checkout">Submit Checkout</button>
    </form>
</body>

</html>
