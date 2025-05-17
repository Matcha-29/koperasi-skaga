<?php
require '../../vendor/autoload.php'; // pastikan sudah install PhpSpreadsheet
use PhpOffice\PhpSpreadsheet\IOFactory;

require_once '../../config/connection.php';

if (isset($_FILES['file_excel'])) {
    $file = $_FILES['file_excel']['tmp_name'];
    $spreadsheet = IOFactory::load($file);
    $sheet = $spreadsheet->getActiveSheet()->toArray();

    // Lewati header, mulai dari index 1
    for ($i = 1; $i < count($sheet); $i++) {
        $nama = trim($sheet[$i][0]);
        $tanggal_simpanan = $sheet[$i][1];
        $jumlah_simpanan_raw = (string) $sheet[$i][2]; // pastikan ini string

        // Bersihkan format: hapus "Rp", titik, spasi, dan karakter non-angka lainnya
        $jumlah_simpanan = preg_replace('/[^\d]/', '', $jumlah_simpanan_raw);

        // Kalau hasil kosong atau bukan angka valid, set ke 0
        if (empty($jumlah_simpanan)) {
            $jumlah_simpanan = 0;
        }

        $jumlah_simpanan = (int) $jumlah_simpanan;

        // Cari id_pengguna berdasarkan nama
        $cek = $conn->query("SELECT id FROM tb_pengguna WHERE nama = '$nama'");
        if ($cek->num_rows > 0) {
            $row = $cek->fetch_assoc();
            $id_pengguna = $row['id'];
        } else {
            // Buat pengguna baru jika tidak ditemukan
            $conn->query("INSERT INTO tb_pengguna (nama, email) VALUES ('$nama', CONCAT(LOWER('$nama'), '@example.com'))");
            $id_pengguna = $conn->insert_id;
        }

        // Simpan ke tabel simpanan
        $conn->query("INSERT INTO tb_simpanan_pokok (id_pengguna, tanggal_simpanan, jumlah_simpanan) 
                         VALUES ('$id_pengguna', '$tanggal_simpanan', '$jumlah_simpanan')");
    }

    header("Location: ../pages/simpanan_pokok.php");
    exit;
}

if (isset($_POST['ubah_nominal'])) 
{
    $nominal = $_POST['nominal'];
    $jenis = 'simpanan_pokok';
    
    $stmt = $conn->prepare("UPDATE tb_nominal_simpanan SET nominal = ? WHERE jenis = ?");
    $stmt->bind_param('ds', $nominal, $jenis);
    $stmt->execute();

    header("Location: ../pages/simpanan_pokok.php");
    exit;
}
?>
