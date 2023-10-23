<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST["nama"];
    $email = $_POST["email"];
    $nt = $_POST["nt"];
    $kamar = $_POST["kamar"];
    $tglci = $_POST["tglci"];
    $tglco = $_POST["tglco"];
    $jo = $_POST["jo"];
    $jk = $_POST["jk"];
    $metode_pembayaran = $_POST["metode_pembayaran"];

    $HargaRuangan = [
        'Suite' => 1400000,  
        'Superior' => 2100000,  
        'Deluxe' => 2500000 
    ];

    $tgl_checkin = new DateTime($tglci);
    $tgl_checkout = new DateTime($tglco);
    $interval = $tgl_checkin->diff($tgl_checkout);
    $total_days = $interval->days;

    $harga_kamar = $HargaRuangan[$kamar];

    $pembayaran_perhari = $harga_kamar;
    $base_cost = $pembayaran_perhari * $jk * $total_days;

    $diskon = 0;
    $plo = 'Rp 0,00';

    if ($jo > 2) {
        $perorang = 150500;
        $total_plo = $perorang * ($jo - 2);
        $plo = 'Rp ' . number_format($total_plo, 0, ',', '.') . ',00';
        $base_cost += $total_plo;
    }

    if ($base_cost > 15000000) {
        $discount = $base_cost * 0.05;
        $base_cost -= $discount;
        $discountText = 'Rp ' . number_format($discount, 0, ',', '.') . ',00';
    } else {
        $discountText = 'Rp 0,00';
    }

    $pajak = 0.10 * $base_cost;
    $harga_akhir = $base_cost + $pajak;

    
    $host = "localhost";
    $username = "root";
    $password = "";
    $database = "hotel";

    
    $koneksi = new mysqli($host, $username, $password, $database);

    
    if ($koneksi->connect_error) {
        die("Koneksi ke database gagal: " . $koneksi->connect_error);
    }

    
    $id_acak = uniqid(mt_rand(), true); 
$id_acak = substr($id_acak, 0, 5);
    
    
    $sql = "INSERT INTO data_pengunjung (id, nama, email, nt, kamar, jo, jk, tglci, tglco, metode_pembayaran, total_biaya, tanggal_pemesanan)
            VALUES ('$id_acak', '$nama', '$email', '$nt', '$kamar', '$jo', '$jk', '$tglci', '$tglco', '$metode_pembayaran', '$harga_akhir', NOW())";

    if ($koneksi->query($sql) === true) {
        
        $koneksi->close();
    } else {
        echo "Error MySQL: " . $koneksi->error;
        echo "Terjadi kesalahan. Pemesanan gagal. Silakan coba lagi.";
        
        $koneksi->close();
    }
} else {
    echo "Pemesanan gagal. Silakan coba lagi.";
}


?>
<!DOCTYPE html>
<html>
<head>
    <title>Hasil Pemesanan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            text-align: left;
        }
        .container {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            margin: 20px auto;
            padding: 20px;
            max-width: 400px;
        }
        h2 {
            color: #333;
        }
        strong {
            font-weight: bold;
        }
        a {
            text-decoration: none;
            background-color: #007bff;
            border: 1px solid #007bff;
            color: #fff;
            padding: 10px 20px;
            border-radius: 5px;
            display: inline-block;
            margin: 10px 0;
        }
        a:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Pemesanan Berhasil</h2>
        <?php
        if (isset($nama) && isset($id_acak)) {
            echo "<p>Terima kasih, $nama!</p>";
            echo "<p><strong>Nomor ID:</strong> $id_acak</p>";
            echo "<p><strong>Nomor Telepon:</strong> $nt</p>";
            echo "<p><strong>Email:</strong> $email</p>";
            echo "<p><strong>Tipe Kamar:</strong> $kamar</p>";
            echo "<p><strong>Jumlah Malam:</strong> $total_days</p>";
            echo "<p><strong>Jumlah Orang:</strong> $jo</p>";
            echo "<p><strong>Harga Kamar:</strong> Rp " . number_format($harga_kamar, 0, ',', '.') . ',00/malam</p>';
            echo "<p><strong>Harga Total:</strong> Rp " . number_format($base_cost, 0, ',', '.') . ',00</p>';
            echo "<p><strong>Pajak:</strong> Rp " . number_format($pajak, 0, ',', '.') . ',00</p>';
            echo "<p><strong>Biaya Orang Tambahan:</strong> $plo</p>";
            echo "<p><strong>Diskon:</strong> $discountText</p>";
            echo "<p><strong>Harga Akhir:</strong> Rp " . number_format($harga_akhir, 0, ',', '.') . ',00</p>';
            echo '<a href="index.html">Kembali</a>';
        }
        ?>
    </div>
</body>
</html>
