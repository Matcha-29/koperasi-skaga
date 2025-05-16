<?php
// Data pinjaman reguler
$pinjamanReguler = [
    'Januari' => 'Rp0',
    'Februari' => 'Rp0',
    'Maret' => 'Rp840.000',
    'April' => 'Rp0',
    'Mei' => 'Rp0',
    'Juni' => 'Rp0',
    'Juli' => 'Rp0',
    'Agustus' => 'Rp0',
    'September' => 'Rp0',
    'Oktober' => 'Rp0',
    'November' => 'Rp0',
    'Desember' => 'Rp0'
];
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Pinjaman Reguler</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
        }
    </style>
</head>

<body class="bg-gray-100 flex justify-center">
    <div class="w-full max-w-md min-h-screen bg-gray-200 relative">
        <div class="container mx-auto px-4 pb-24">
            <h1 class="text-2xl font-semibold text-center text-gray-800 my-6">Pinjaman Insidental</h1>

            <!-- Status Banner -->
            <div class="bg-orange-500 text-white text-center py-4 rounded-lg mb-4 font-medium text-lg">
                Sisa angsuran kurang 1x
            </div>

            <!-- Card untuk tabel -->
            <div class="w-full border bg-white rounded-md overflow-hidden p-4">
                <div class="bg-white rounded-lg shadow-sm border-2 border-black">
                    <table class="w-full rounded-md overflow-hidden">
                        <thead>
                            <tr class="bg-red-50">
                                <th class="w-1/2 py-3 px-4 border-b text-left font-semibold text-black text-center">Bulan</th>
                                <th class="w-1/2 py-3 px-4 border-b text-left font-semibold text-black text-center">Jumlah Angsuran</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($pinjamanReguler as $bulan => $jumlah): ?>
                                <tr>
                                    <td class="py-3 px-4 border-b text-center"><?php echo $bulan; ?></td>
                                    <td class="py-3 px-4 border-b "><?php echo $jumlah; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Bottom Navigation -->
        <div class="fixed bottom-0 w-full max-w-md bg-white border-t border-gray-200 flex justify-around items-center py-4">
            <a href="ajuan_pembiayaan.php" class="flex flex-col items-center text-gray-500">
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