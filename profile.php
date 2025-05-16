<?php
// Profil pengguna - data bisa diganti dengan data dari database
$profileData = [
    'name' => 'Muhammad Thalat Hamdi',
    'email' => 'hamdithalat@gmail.com',
    'phone' => '+6286754892018',
    'address' => 'Jl.Pluto 1 no 77, Kota Bekasi'
];
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Profil Pengguna</title>
    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            background-color: white;
        }

        html {
            background-color: #e5e7eb;
        }

        .home-button {
            bottom: 2.5rem;
        }
    </style>
</head>

<body>
    <div class="w-full max-w-md mx-auto bg-gray-200 min-h-screen relative">
        <!-- Profile Content -->
        <div class="flex flex-col items-center pt-24">
            <!-- Profile Picture -->
            <div class="w-32 h-32 rounded-full overflow-hidden border-4 border-white">
                <img src="image/profilelogo.png" alt="Profile Picture" class="w-full h-full object-cover bg-blue-500">
            </div>

            <!-- User Name and Email -->
            <h1 class="text-2xl font-semibold mt-4 text-gray-800"><?php echo $profileData['name']; ?></h1>
            <p class="text-gray-500 mt-1 text-lg"><?php echo $profileData['email']; ?></p>

            <!-- Other Information Section -->
            <div class="w-full mt-12">
                <p class="text-lg text-gray-500 mb-2 px-2">Informasi lainnya</p>

                <!-- Phone Number -->
                <div class="flex items-center py-4 border-b border-gray-200 px-2">
                    <div class="w-10 h-10 flex items-center justify-center mr-4">
                        <i class="fas fa-phone text-2xl text-gray-600"></i>
                    </div>
                    <div class="text-lg text-gray-800"><?php echo $profileData['phone']; ?></div>
                </div>

                <!-- Address -->
                <div class="flex items-center py-4 px-2">
                    <div class="w-10 h-10 flex items-center justify-center mr-4">
                        <i class="fas fa-map-marker-alt text-2xl text-gray-600"></i>
                    </div>
                    <div class="text-lg text-gray-800"><?php echo $profileData['address']; ?></div>
                </div>

                <!-- Ganti Password Button -->
                <div class="w-full px-4 mt-4 mb-24">
                    <button class="w-full bg-white text-red-500 font-medium border border-red-500 py-3 rounded-lg text-center">
                        <i class="fas fa-lock mr-2"></i>Ganti Password
                    </button>
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

            <a href="profile.php" class="flex flex-col items-center text-orange-500">
                <i class="far fa-user text-xl mb-1"></i>
                <span class="text-xs">Profil</span>
            </a>
        </div>
    </div>
</body>

</html>