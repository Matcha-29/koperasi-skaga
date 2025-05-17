<?php

require_once './config/connection.php';

session_start();

$nama = $_SESSION['nama'] ?? '';
$role = $_SESSION['role'] ?? '';
$idPengguna = $_SESSION['id_pengguna'] ?? '';
$success = $_SESSION['success'] ?? '';
$error = $_SESSION['error'] ?? '';
unset($_SESSION['success'], $_SESSION['error']);


if (empty($nama) && empty($idPengguna)) {
    header('Location: login.php');
}

$stmt = $conn->prepare('SELECT * FROM tb_pengguna WHERE id = ?');
$stmt->bind_param('s', $idPengguna);
$stmt->execute();
$result = $stmt->get_result();

$user = $result->fetch_assoc();

if (isset($_POST['change_password'])) {
    $newPassword = $_POST['password'];

    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

    $stmt = $conn->prepare('UPDATE tb_pengguna SET password = ? WHERE id = ?');
    $stmt->bind_param('ss', $hashedPassword, $idPengguna);
    $update = $stmt->execute();

    if ($update) 
    {
        $_SESSION['success'] = 'Password berhasil diubah.';
    } 
    else 
    {
        $_SESSION['error'] = 'Gagal mengubah password. Silakan coba lagi.';
    }

    header('Location: profile.php');
    exit;
}

if (isset($_POST['logout']))
{
    session_destroy();

    header('Location: login.php');
}

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
        <?php if (!empty($success)): ?>
            <div id="flash-message" class="bg-green-100 text-green-800 p-3 rounded mb-4 mx-4 text-center">
                <?= $success ?>
            </div>
        <?php elseif (!empty($error)): ?>
            <div id="flash-message" class="bg-red-100 text-red-800 p-3 rounded mb-4 mx-4 text-center">
                <?= $error ?>
            </div>
        <?php endif; ?>

        <!-- Profile Content -->
        <div class="flex flex-col items-center pt-24">
            <!-- Profile Picture -->
            <div class="w-32 h-32 rounded-full overflow-hidden border-4 border-white">
                <img src="image/profile/<?= $user['foto_profil'] ?? 'default.png' ?>" alt="Profile Picture" class="w-full h-full object-cover bg-blue-500">
            </div>

            <!-- User Name and Email -->
            <h1 class="text-2xl font-semibold mt-4 text-gray-800"><?= $user['nama'] ?></h1>
            <p class="text-gray-500 mt-1 text-lg"><?= $user['email'] ?></p>

            <!-- Other Information Section -->
            <div class="w-full mt-12">
                <p class="text-lg text-gray-500 mb-2 px-4">Informasi lainnya</p>

                <!-- Phone Number -->
                <div class="flex items-center py-4 border-b border-gray-200 px-2">
                    <div class="w-10 h-10 flex items-center justify-center mr-4">
                        <i class="fas fa-phone text-2xl text-gray-600"></i>
                    </div>
                    <div class="text-lg text-gray-800"><?= $user['no_telepon'] ?></div>
                </div>

                <!-- Address -->
                <div class="flex items-center py-4 px-2">
                    <div class="w-10 h-10 flex items-center justify-center mr-4">
                        <i class="fas fa-map-marker-alt text-2xl text-gray-600"></i>
                    </div>
                    <div class="text-lg text-gray-800"><?= $user['alamat'] ?></div>
                </div>

                <!-- Ganti Password Button -->
                <div class="w-full px-4 mt-4 mb-4">
                    <button class="btn-change-password w-full bg-white text-red-500 font-medium border border-red-500 py-3 rounded-lg text-center">
                        <i class="fas fa-lock mr-2"></i>Ganti Password
                    </button>
                </div>

                <!-- Logout Button -->
                <form method="POST" class="w-full px-4 mt-4 mb-4 ">
                    <button type="submit" name="logout" class="w-full bg-red-500 text-white font-medium py-3 rounded-lg text-center">
                        <i class="fas fa-sign-out-alt mr-2"></i>Keluar
                    </button>
                </form>

                <?php if ($role === 'admin') : ?>
                    <div class="w-full px-4 mt-4">
                        <a href="./admin/index.php" class="block w-full bg-gray-700 text-white font-medium py-3 rounded-lg text-center">
                            <i class="fas fa-user-cog mr-2"></i>Menu Admin
                        </a>
                    </div>
                <?php endif ?>
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

    <div class="overlay bg-black/20 absolute top-0 left-0 right-0 bottom-0 w-full h-full hidden"></div>
    <form method="POST" class="modal p-4 w-[300px] bg-white absolute rounded-md top-[50%] hidden left-[50%] translate-x-[-50%] translate-y-[-50%] ">
        <div class="modal-body flex items-center relative mb-2">
            <input
                type="password"
                id="password"
                name="password"
                placeholder="Masukkan sandi baru anda"
                class="w-full rounded-sm pl-2 border border-gray-300 py-2 pr-10 focus:outline-none"
                required>
            <button
                type="button"
                class="absolute right-2 text-gray-400"
                onclick="togglePassword()">
                <i id="eye-icon" class="fas fa-eye-slash"></i>
            </button>
        </div>
        <div class="modal-footer flex justify-end gap-2">
            <button class="btn-close rounded-sm bg-red-500 px-4 py-2 font-bold text-white">Tutup</button>
            <button type="submit" name="change_password" class="rounded-sm bg-green-500 px-4 py-2 font-bold text-white">Ubah</button>
        </div>
    </form>

    <script>
        const btnChangePassword = document.querySelector('.btn-change-password');
        const btnClose = document.querySelector('.btn-close');
        const overlay = document.querySelector('.overlay');
        const modal = document.querySelector('.modal');

        btnChangePassword.addEventListener('click', () => {
            overlay.classList.remove('hidden');
            overlay.classList.add('block');
            modal.classList.remove('hidden');
            modal.classList.add('block');
        });

        btnClose.addEventListener('click', () => {
            overlay.classList.remove('block');
            overlay.classList.add('hidden');
            modal.classList.remove('block');
            modal.classList.add('hidden');
        });

        // Hilangkan pesan otomatis setelah 4 detik
        setTimeout(() => {
            const flashMessage = document.getElementById('flash-message');
            if (flashMessage) {
                flashMessage.style.opacity = '0';
                flashMessage.style.transition = 'opacity 0.5s ease';

                // Setelah transisi selesai, sembunyikan sepenuhnya
                setTimeout(() => {
                    flashMessage.style.display = 'none';
                }, 500);
            }
        }, 4000); // 4 detik

        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            }
        }

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