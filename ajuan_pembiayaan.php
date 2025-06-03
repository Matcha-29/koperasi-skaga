<?php

require_once './config/connection.php';

session_start();

$nama = $_SESSION['nama'] ?? '';
$idPengguna = $_SESSION['id_pengguna'] ?? '';

if (empty($nama) && empty($idPengguna)) {
    header('Location: login.php');
}

// Perbaikan 1: Tambahkan ORDER BY untuk konsistensi urutan data
$stmt = $conn->prepare('SELECT * FROM tb_pengajuan_peminjaman WHERE id_pengguna = ? ORDER BY tanggal DESC, id DESC');
$stmt->bind_param('i', $idPengguna);
$stmt->execute();
$result = $stmt->get_result();

// Perbaikan 2: Hitung total data untuk debugging
$countStmt = $conn->prepare('SELECT COUNT(*) as total FROM tb_pengajuan_peminjaman WHERE id_pengguna = ?');
$countStmt->bind_param('i', $idPengguna);
$countStmt->execute();
$countResult = $countStmt->get_result();
$totalData = $countResult->fetch_assoc()['total'];

function formatTanggal($tanggal)
{
    $date = new DateTime($tanggal);
    $formatter = new IntlDateFormatter('id_ID', IntlDateFormatter::LONG, IntlDateFormatter::NONE, 'Asia/Jakarta');
    return $formatter->format($date);
}

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Ajuan Pembiayaan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
        }
    </style>
</head>

<body class="bg-gray-100 flex justify-center">
    <div class="w-full max-w-md min-h-screen bg-white relative">
        <div class="pt-12 px-4 pb-32">
            <div class="flex items-center mb-6">
                <h1 class="text-2xl font-semibold text-center w-full">Ajuan Pembiayaan</h1>
            </div>

            <div class="bg-white rounded-lg shadow-lg mb-4">
                <div class="p-4 border-b cursor-pointer flex justify-between items-center" onclick="toggleDropdown()">
                    <span class="text-gray-600">Pilih jenis Ajuan</span>
                    <i id="dropdownIcon" class="fas fa-chevron-down text-gray-600 transition-transform duration-200"></i>
                </div>
                <div id="dropdownMenu" class="hidden p-4 space-y-2">
                    <div onclick="selectOption('Pinjaman Reguler')" class="cursor-pointer hover:bg-gray-100 p-2 rounded">Pinjaman Reguler</div>
                    <div onclick="selectOption('Pinjaman Insidental')" class="cursor-pointer hover:bg-gray-100 p-2 rounded">Pinjaman Insidental</div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm mb-6">
                <div class="p-4">
                    <h2 class="text-lg font-semibold mb-4 text-center">Data Pengajuan</h2>
                    
                    <!-- Perbaikan 3: Tambahkan info total data untuk debugging -->
                    <div class="text-sm text-gray-600 mb-2">
                        Total data: <?= $totalData ?> pengajuan
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full min-w-[600px] border border-gray-300">
                            <thead>
                                <tr class="bg-red-50">
                                    <th class="py-2 px-2 text-left border border-gray-300">No.</th>
                                    <th class="py-2 px-2 text-left border border-gray-300">Tanggal</th>
                                    <th class="py-2 px-2 text-left border border-gray-300">Jenis Ajuan</th>
                                    <th class="py-2 px-2 text-left border border-gray-300">Nominal</th>
                                    <th class="py-2 px-2 text-left border border-gray-300">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Perbaikan 4: Simpan semua data dalam array terlebih dahulu
                                $dataArray = [];
                                while ($row = $result->fetch_assoc()) {
                                    $dataArray[] = $row;
                                }
                                
                                // Perbaikan 5: Tampilkan semua data dengan penomoran yang benar
                                $no = 1;
                                foreach ($dataArray as $row) : ?>
                                    <tr>
                                        <td class="py-2 px-2 border border-gray-300"><?= $no ?></td>
                                        <td class="py-2 px-2 border border-gray-300"><?= formatTanggal($row['tanggal']) ?></td>
                                        <td class="py-2 px-2 border border-gray-300"><?= ucfirst($row['jenis_pengajuan']) ?></td>
                                        <td class="py-2 px-2 border border-gray-300">Rp <?= number_format($row['nominal'], 0, ',', '.') ?></td>
                                        <td class="py-2 px-2 border border-gray-300">
                                            <?php if ($row['status'] === 'proses') : ?>
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                    Proses
                                                </span>
                                            <?php elseif ($row['status'] === 'diterima') : ?>
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    Diterima
                                                </span>
                                            <?php else : ?>
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                    Ditolak
                                                </span>
                                            <?php endif ?>
                                        </td>
                                    </tr>
                                <?php 
                                $no++; // Increment setelah menampilkan row
                                endforeach ?>
                                
                                <?php if (empty($dataArray)) : ?>
                                    <tr>
                                        <td colspan="5" class="py-4 px-2 text-center text-gray-500 border border-gray-300">
                                            Tidak ada data pengajuan
                                        </td>
                                    </tr>
                                <?php endif ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom Navigation -->
        <div class="fixed bottom-0 w-full max-w-md bg-white border-t border-gray-200 flex justify-around items-center py-4">
            <a href="ajuan_pembiayaan.php" class="flex flex-col items-center text-orange-500">
                <i class="fas fa-th-large text-xl mb-1"></i>
                <span class="text-xs">Ajuan</span>
            </a>

            <!-- Spacer for home button -->
            <div class="absolute left-1/2 transform -translate-x-1/2 bottom-16">
                <a href="index.php" class="block">
                    <div class="w-16 h-16 bg-gray-500 rounded-full flex justify-center items-center shadow-md">
                        <i class="fas fa-home text-white text-2xl"></i>
                    </div>
                </a>
            </div>

            <a href="profile.php" class="flex flex-col items-center text-gray-500">
                <i class="far fa-user text-xl mb-1"></i>
                <span class="text-xs">Profil</span>
            </a>
        </div>
    </div>
</body>

</html>

<script>
    function toggleDropdown() {
        const menu = document.getElementById('dropdownMenu');
        const icon = document.getElementById('dropdownIcon');
        menu.classList.toggle('hidden');
        icon.classList.toggle('rotate-180');
    }

    function selectOption(option) {
        if (option === 'Pinjaman Reguler') {
            window.location.href = 'ajuan.php';
        } else if (option === 'Pinjaman Insidental') {
            window.location.href = 'ajuan_insidental.php';
        }
    }
</script>   