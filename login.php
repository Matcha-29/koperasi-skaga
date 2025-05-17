<?php
include './config/connection.php';

// Mulai sesi jika diperlukan
session_start();

$nama = $_SESSION['nama'] ?? '';
$idPengguna = $_SESSION['id_pengguna'] ?? '';

if (!empty($nama) && !empty($idPengguna))
{
    header('Location: index.php');
}

// Menangani pengiriman formulir
$pesanError = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($password)) {
        $pesanError = 'Nama dan password wajib diisi.';
    } else {
        $stmt = $conn->prepare('SELECT * FROM tb_pengguna WHERE nama = ?');
        $stmt->bind_param('s', $username);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result && $user = $result->fetch_assoc())
        {
            if (password_verify($password, $user['password']))
            {
                $_SESSION['id_pengguna'] = $user['id'];
                $_SESSION['nama'] = $user['nama'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['role'] = $user['role'];

                if ($user['role'] === 'admin')
                {
                    header('Location: ./admin/index.php');
                }
                else
                {
                    header('Location: index.php');
                }

                exit;
            }
            else
            {
                $pesanError = 'Password salah.';
            }
        }
        else
        {
            $pesanError = 'Nama atau password salah.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Login Koperasi</title>
    <!-- Include Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Include Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
        }
    </style>
</head>
<body class="bg-gray-100 flex justify-center">
    <div class="w-full max-w-md min-h-screen bg-white relative">
        <!-- Full height orange gradient background -->
        <div class="bg-gradient-to-b from-orange-600 to-orange-500 h-[70vh] flex flex-col items-center">
            <h1 class="text-4xl font-bold text-white mt-20 mb-8">KOPERASI</h1>
            <div>
                <img src="image/logo.png" alt="Logo Koperasi" class="w-36 h-36 object-contain">
            </div>
        </div>
        
        <!-- White rounded container -->
        <div class="bg-white rounded-t-[40px] absolute bottom-0 left-0 right-0 p-8">
            <h2 class="text-2xl font-bold text-red-600 mb-8 text-center">Masuk Akun</h2>
            
            <?php if ($pesanError): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <?php echo htmlspecialchars($pesanError); ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="space-y-8">
                <div>
                    <label for="username" class="block text-gray-700 mb-2">Nama Pengguna</label>
                    <input
                        type="text"
                        id="username"
                        name="username"
                        placeholder="Masukan nama anda"
                        class="w-full border-b border-gray-300 py-2 focus:outline-none"
                        required
                    >
                </div>
                
                <div class="relative">
                    <label for="password" class="block text-gray-700 mb-2">Sandi</label>
                    <div class="flex items-center relative">
                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="Masukkan sandi anda"
                            class="w-full border-b border-gray-300 py-2 pr-10 focus:outline-none"
                            required
                        >
                        <button 
                            type="button"
                            class="absolute right-2 text-gray-400"
                            onclick="togglePassword()"
                        >
                            <i id="eye-icon" class="fas fa-eye-slash"></i>
                        </button>
                    </div>
                </div>
                
                <button
                    type="submit"
                    class="w-full bg-gray-400 hover:bg-gray-500 text-white py-4 rounded-lg mt-8 font-bold"
                >
                    Masuk
                </button>
            </form>
        </div>
    </div>

    <script>
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
        }, { passive: false });
        
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