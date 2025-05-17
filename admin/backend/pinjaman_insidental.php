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
        $bulan = $sheet[$i][1];
        $tahun = $sheet[$i][2];
        $jumlah_angsuran_raw = (string) $sheet[$i][3]; // pastikan ini string

        // Bersihkan format: hapus "Rp", titik, spasi, dan karakter non-angka lainnya
        $jumlah_angsuran = preg_replace('/[^\d]/', '', $jumlah_angsuran_raw);

        // Kalau hasil kosong atau bukan angka valid, set ke 0
        if (empty($jumlah_angsuran)) {
            $jumlah_angsuran = 0;
        }

        $jumlah_angsuran = (int) $jumlah_angsuran;

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
        $conn->query("INSERT INTO tb_pinjaman_insidental (id_pengguna, bulan, tahun, jumlah_angsuran) 
                         VALUES ('$id_pengguna', '$bulan', '$tahun', '$jumlah_angsuran')");
    }

    header("Location: ../pages/pinjaman_insidental.php");
    exit;
} else {
    echo "Tidak ada file yang diupload.";
}
?>
