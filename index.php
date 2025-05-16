<?php
// Contoh data pengguna - bisa diganti dengan data dari database
$userData = [
    'nama' => 'Muhammad Thalat Hamdi',
    'simpanan_sukarela' => 0,
    'simpanan_pokok' => 100000,
    'simpanan_wajib' => 12000000,
    'bulan_wajib' => 'Des 2024'
];
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Dashboard Koperasi SKAGA</title>
    <!-- Include Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Include Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body class="bg-gray-100 flex justify-center">
    <div class="w-full max-w-md min-h-screen bg-white relative">
        <!-- Header dengan background orange -->
        <div class="bg-orange-500 text-white w-full">
            <!-- App Header -->
            <div class="p-6">
                <h1 class="text-2xl font-bold mt-4 mb-4">KOPERASI SKAGA</h1>

                <!-- Orange Card -->
                <div class="bg-yellow-500 rounded-xl p-5 mb-4">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-white text-lg">Simpanan sukarela saat ini</p>
                            <p class="text-white text-3xl font-bold mt-1">Rp 0</p>

                            <div class="mt-4">
                                <p class="text-white">Nama</p>
                                <p class="text-white font-medium"><?php echo $userData['nama']; ?></p>
                            </div>
                        </div>
                        <div class="bg-white bg-opacity-20 p-3 rounded-full">
                            <i class="fas fa-wallet text-white text-xl"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="px-6 py-4 bg-white rounded-t-3xl -mt-3 w-full">
            <!-- Savings Cards -->
            <div class="flex gap-4 mb-5">
                <!-- Left Card -->
                <div class="flex-1 bg-green-50 rounded-xl p-4">
                    <div class="flex justify-between h-full">
                        <div class="flex flex-col justify-between h-full">
                            <p class="text-gray-800 font-medium">Simpanan Pokok</p>
                            <p class="text-gray-800 font-bold">Rp100.000</p>
                        </div>
                        <div class="bg-teal-600 p-2 rounded-full h-fit">
                            <i class="fas fa-university text-white"></i>
                        </div>
                    </div>
                </div>

                <!-- Right Card -->
                <div class="flex-1 bg-gray-200 rounded-xl p-4">
                    <div class="flex justify-between h-full">
                        <div class="flex flex-col justify-between h-full">
                            <p class="text-gray-800 font-medium">Simpanan Wajib Des 2024</p>
                            <p class="text-gray-800 font-bold">Rp12.000.000</p>
                        </div>
                        <div class="bg-teal-600 p-2 rounded-full h-fit">
                            <i class="fas fa-wallet text-white"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Loan Application Card -->
            <div a href="profile.php" class="bg-white rounded-xl p-4 shadow mb-6 cursor-pointer" onclick="window.location.href='ajuan_pembiayaan.php'">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-gray-800 text-lg font-medium">Ajuan Peminjaman</p>
                        <p class="text-gray-500 mt-1">Ayo ajukan pembiayaan sesuai kebutuhan anda</p>
                    </div>
                    <div class="bg-teal-700 p-3 rounded-full">
                        <i class="fas fa-hand-holding-usd text-white"></i>
                    </div>
                </div>
            </div>

            <!-- Services Section -->
            <div class="mb-20">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Layanan</h2>

                <!-- Service Card 1 - Simpanan Wajib 2025 -->
                <div class="bg-white rounded-xl p-4 shadow mb-3 flex justify-between items-center cursor-pointer" onclick="window.location.href='simpanan_wajib.php'">
                    <div class="flex items-center">
                        <div class="bg-blue-100 p-3 rounded-xl mr-4">
                            <i class="fas fa-store text-blue-400"></i>
                        </div>
                        <div>
                            <p class="text-gray-800 font-medium">Simpanan Wajib 2025</p>
                            <p class="text-gray-500 text-sm">Lihat detail</p>
                        </div>
                    </div>
                    <i class="fas fa-chevron-right text-gray-400"></i>
                </div>

                <!-- Service Card 2 - Simpanan Sukarela 2025 -->
                <div class="bg-white rounded-xl p-4 shadow mb-3 flex justify-between items-center cursor-pointer" onclick="window.location.href='simpanan_sukarela.php'">
                    <div class="flex items-center">
                        <div class="bg-white p-3 rounded-xl border border-green-400 mr-4">
                            <i class="fas fa-leaf text-green-500"></i>
                        </div>
                        <div>
                            <p class="text-gray-800 font-medium">Simpanan Sukarela 2025</p>
                            <p class="text-gray-500 text-sm">Lihat detail</p>
                        </div>
                    </div>
                    <i class="fas fa-chevron-right text-gray-400"></i>
                </div>

                <!-- Service Card 3 - Pinjaman Reguler -->
                <div class="bg-white rounded-xl p-4 shadow mb-3 flex justify-between items-center cursor-pointer" onclick="window.location.href='pinjaman_reguler.php'">
                    <div class="flex items-center">
                        <div class="bg-yellow-100 p-3 rounded-xl mr-4">
                            <i class="fas fa-lock text-yellow-500"></i>
                        </div>
                        <div>
                            <p class="text-gray-800 font-medium">Pinjaman Reguler</p>
                            <p class="text-gray-500 text-sm">Lihat detail</p>
                        </div>
                    </div>
                    <i class="fas fa-chevron-right text-gray-400"></i>
                </div>

                <!-- Service Card 4 - Pinjaman Insidental -->
                <div class="bg-white rounded-xl p-4 shadow mb-3 flex justify-between items-center cursor-pointer" onclick="window.location.href='pinjaman_insidental.php'">
                    <div class="flex items-center">
                        <div class="bg-blue-100 p-3 rounded-xl mr-4">
                            <i class="fas fa-coins text-blue-500"></i>
                        </div>
                        <div>
                            <p class="text-gray-800 font-medium">Pinjaman Insidental</p>
                            <p class="text-gray-500 text-sm">Lihat detail</p>
                        </div>
                    </div>
                    <i class="fas fa-chevron-right text-gray-400"></i>
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
                    <div class="w-16 h-16 bg-orange-500 rounded-full flex justify-center items-center shadow-md">
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

    <script>
        // Mencegah zoom saat fokus input pada perangkat mobile
        document.addEventListener('touchstart', function(event) {
            if (event.touches.length > 1) {
                event.preventDefault();
            }
        }, {
            passive: false
        });

        var lastTouchEnd = 0;
        document.addEventListener('touchend', function(event) {
            var now = Date.now();
            if (now - lastTouchEnd <= 300) {
                event.preventDefault();
            }
            lastTouchEnd = now;
        }, false);
    </script>
</body>

</html>