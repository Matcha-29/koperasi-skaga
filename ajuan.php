<?php
require_once './config/connection.php';

session_start();

$nama = $_SESSION['nama'] ?? '';
$idPengguna = $_SESSION['id_pengguna'] ?? '';
$success = $_SESSION['success'] ?? '';
$error = $_SESSION['error'] ?? '';
unset($_SESSION['success'], $_SESSION['error']);

if (empty($nama) && empty($idPengguna)) {
    header('Location: login.php');
}

if (isset($_POST['submit'])) {
    // Ambil dan validasi input
    $nominalInput = $_POST['nominal'] ?? '0';
    $nominal = (int) str_replace('.', '', $nominalInput); // Hapus titik dan konversi ke integer

    if ($nominal <= 0) {
        $_SESSION['error'] = 'Nominal tidak valid.';
        header('Location: ajuan.php');
        exit;
    }

    $jenisPengajuan = 'reguler'; // Atau ambil dari input jika tersedia
    $tanggal = date('Y-m-d');
    $status = 'proses';

    // Siapkan pernyataan SQL
    $stmt = $conn->prepare('INSERT INTO tb_pengajuan_peminjaman (id_pengguna, jenis_pengajuan, nominal, tanggal, status) VALUES (?, ?, ?, ?, ?)');
    if ($stmt === false) {
        $_SESSION['error'] = 'Gagal menyiapkan pernyataan SQL.';
        header('Location: ajuan.php');
        exit;
    }

    // Ikat parameter
    $stmt->bind_param('isdss', $idPengguna, $jenisPengajuan, $nominal, $tanggal, $status);

    // Eksekusi pernyataan
    if ($stmt->execute()) {
        $_SESSION['success'] = 'Pengajuan berhasil diajukan.';
    } else {
        $_SESSION['error'] = 'Terjadi kesalahan saat mengirim pengajuan.';
    }

    $stmt->close();
    header('Location: ajuan_pembiayaan.php');
    exit;
}

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Ajuan Pembiayaan</title>
    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            background-color: #f5f5f5;
        }
        .keypad-button {
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            border-radius: 4px;
        }
    </style>
</head>
<body class="bg-gray-100">
    <form method="POST" class="max-w-md mx-auto h-screen flex flex-col bg-gray-50">
        <div class="px-5 pt-10 flex-1">
            <!-- Header -->
            <h1 class="text-2xl font-semibold text-center mb-8">Ajuan Pembiayaan</h1>
            
            <!-- Dropdown Selection -->
            <div class="bg-white rounded-lg shadow mb-8">
                <div class="p-4 flex justify-between items-center" onclick="toggleDropdown()">
                    <span class="text-black font-medium" id="selectedOption">Reguler</span>
                    <i id="dropdownIcon" class="fas fa-chevron-down text-gray-600 transition-transform duration-200"></i>
                </div>
                <div id="dropdownMenu" class="hidden p-4 border-t">
                    <div onclick="selectOption('Reguler')" class="cursor-pointer hover:bg-gray-100 p-2 rounded font-medium">Reguler</div>
                    <div onclick="selectOption('Insidental')" class="cursor-pointer hover:bg-gray-100 p-2 rounded font-medium">Insidental</div>
                </div>
            </div>
            
            <!-- Nominal Input -->
            <div class="mb-6">
                <label class="text-gray-500 text-sm block mb-1">Masukan Nominal</label>
                <div class="border-b border-gray-300 pb-2">
                    <div class="flex items-center">
                        <span class="text-black mr-1">RP</span>
                        <input name="nominal" type="text" class="w-full bg-transparent outline-none text-black text-lg" id="nominal" value="0">
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Submit Button - Positioned directly above keypad -->
        <button type="submit" name="submit" class="w-full bg-orange-500 text-white font-bold py-4 rounded-lg text-center mb-4 mx-1" id="ajukanButton">AJUKAN</button>
        
        <!-- Custom Keypad -->
        <div class="w-full bg-gray-200 pb-8 pt-1 px-1">
            <div class="grid grid-cols-3 gap-2">
                <div class="bg-white keypad-button flex flex-col items-center py-3 cursor-pointer" onclick="appendNumber('1')">
                    <span class="font-bold text-lg">1</span>
                </div>
                <div class="bg-white keypad-button flex flex-col items-center py-3 cursor-pointer" onclick="appendNumber('2')">
                    <span class="font-bold text-lg">2</span>
                    <span class="text-xs text-gray-500">A B C</span>
                </div>
                <div class="bg-white keypad-button flex flex-col items-center py-3 cursor-pointer" onclick="appendNumber('3')">
                    <span class="font-bold text-lg">3</span>
                    <span class="text-xs text-gray-500">D E F</span>
                </div>
                <div class="bg-white keypad-button flex flex-col items-center py-3 cursor-pointer" onclick="appendNumber('4')">
                    <span class="font-bold text-lg">4</span>
                    <span class="text-xs text-gray-500">G H I</span>
                </div>
                <div class="bg-white keypad-button flex flex-col items-center py-3 cursor-pointer" onclick="appendNumber('5')">
                    <span class="font-bold text-lg">5</span>
                    <span class="text-xs text-gray-500">J K L</span>
                </div>
                <div class="bg-white keypad-button flex flex-col items-center py-3 cursor-pointer" onclick="appendNumber('6')">
                    <span class="font-bold text-lg">6</span>
                    <span class="text-xs text-gray-500">M N O</span>
                </div>
                <div class="bg-white keypad-button flex flex-col items-center py-3 cursor-pointer" onclick="appendNumber('7')">
                    <span class="font-bold text-lg">7</span>
                    <span class="text-xs text-gray-500">P Q R S</span>
                </div>
                <div class="bg-white keypad-button flex flex-col items-center py-3 cursor-pointer" onclick="appendNumber('8')">
                    <span class="font-bold text-lg">8</span>
                    <span class="text-xs text-gray-500">T U V</span>
                </div>
                <div class="bg-white keypad-button flex flex-col items-center py-3 cursor-pointer" onclick="appendNumber('9')">
                    <span class="font-bold text-lg">9</span>
                    <span class="text-xs text-gray-500">W X Y Z</span>
                </div>
                <div class="bg-white keypad-button flex flex-col items-center py-3 cursor-pointer" onclick="clearInput()">
                    <i class="fas fa-times text-red-500 text-lg"></i>
                    <span class="text-xs text-gray-500">CLEAR</span>
                </div>
                <div class="bg-white keypad-button flex flex-col items-center py-3 cursor-pointer" onclick="appendNumber('0')">
                    <span class="font-bold text-lg">0</span>
                </div>
                <div class="bg-white keypad-button flex flex-col items-center py-3 cursor-pointer" onclick="deleteNumber()">
                    <i class="fas fa-backspace text-gray-600 text-lg"></i>
                    <span class="text-xs text-gray-500">DELETE</span>
                </div>
            </div>
            
        </div>
    </form>
    
    <!-- Success Modal (initially hidden) - Centered square with close button -->
    <div class="fixed inset-0 flex items-center justify-center z-50 hidden" id="successContainer">
        <!-- Semi-transparent overlay -->
        <div class="absolute inset-0 bg-black bg-opacity-50"></div>
        
        <!-- Success modal card with sukses.png as background -->
        <div class="rounded-3xl shadow-lg w-80 relative z-10 overflow-hidden">
            <!-- Background image -->
            <img src="image/sukses.png" alt="Success Background" class="absolute inset-0 w-full h-full object-cover">
            
            <!-- Close button -->
            <button class="absolute top-3 right-3 text-white text-xl font-bold hover:text-gray-200 z-20" id="closeButton">
                <i class="fas fa-times-circle"></i>
            </button>
            
            <!-- Success content -->
            <div class="flex flex-col items-center p-8 relative z-10">
                <!-- White circle with red checkmark -->
                <div class="w-24 h-24 bg-white rounded-full flex items-center justify-center mb-6">
                    <i class="fas fa-check text-red-600 text-4xl"></i>
                </div>
                
                <?php if(!empty($success)) : ?>
                    <!-- Success message -->
                    <h2 class="text-xl font-bold mb-2 text-white text-center"><?= $success ?></h2>
                    <p class="text-sm text-center text-white">Cek Aplikasi secara berkala untuk memastikan status pengajuan!</p>
                <?php elseif (!empty($error)): ?>
                    <h2 class="text-xl font-bold mb-2 text-white text-center"><?= $error ?></h2>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <script>
        // Get required elements
        const successContainer = document.getElementById('successContainer');
        const ajukanButton = document.getElementById('ajukanButton');
        const closeButton = document.getElementById('closeButton');
        const nominalInput = document.getElementById('nominal');
        const dropdownMenu = document.getElementById('dropdownMenu');
        const dropdownIcon = document.getElementById('dropdownIcon');
        const selectedOption = document.getElementById('selectedOption');
        
        // Toggle dropdown visibility
        function toggleDropdown() {
            dropdownMenu.classList.toggle('hidden');
            dropdownIcon.classList.toggle('rotate-180');
            
            // If opening the dropdown, scroll to top to ensure visibility
            if (!dropdownMenu.classList.contains('hidden')) {
                window.scrollTo(0, 0);
            }
        }
        
        // Select option from dropdown
        function selectOption(option) {
            // Only navigate if the option is different from current
            if (selectedOption.textContent !== option) {
                if (option === 'Insidental') {
                    window.location.href = 'ajuan_insidental.php';
                    return;
                }
            }
            
            selectedOption.textContent = option;
            dropdownMenu.classList.add('hidden');
            dropdownIcon.classList.remove('rotate-180');
        }
        
        // Format number to Indonesian Rupiah format
        function formatRupiah(angka) {
            let number_string = angka.replace(/[^,\d]/g, '').toString();
            let split = number_string.split(',');
            let sisa = split[0].length % 3;
            let rupiah = split[0].substr(0, sisa);
            let ribuan = split[0].substr(sisa).match(/\d{3}/gi);
            
            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }
            
            return rupiah + (split[1] != undefined ? ',' + split[1] : '');
        }
        
        // Function to append numbers to the input field
        function appendNumber(num) {
            let currentValue = nominalInput.value.replace(/\./g, '');
            
            // If current value is 0, replace it with the new number
            if (currentValue === '0') {
                currentValue = num;
            } else {
                // Otherwise append the number
                currentValue += num;
            }
            
            nominalInput.value = formatRupiah(currentValue);
        }
        
        // Function to delete the last digit
        function deleteNumber() {
            let currentValue = nominalInput.value.replace(/\./g, '');
            
            // Remove the last character
            if (currentValue.length > 1) {
                currentValue = currentValue.slice(0, -1);
            } else {
                currentValue = '0';
            }
            
            nominalInput.value = formatRupiah(currentValue);
        }
        
        // Function to clear the input
        function clearInput() {
            nominalInput.value = formatRupiah('0');
        }
        
        // Tampilkan modal jika ada session success atau error
        <?php if (!empty($success) || !empty($error)) : ?>
            successContainer.classList.remove('hidden');
        <?php endif; ?>
        
        // Tampilkan modal jika ada session success
        <?php if (!empty($success)) : ?>
            successContainer.classList.remove('hidden');
        <?php endif; ?>
        
        // Event listener for Close button on success modal
        closeButton.addEventListener('click', function() {
            // Hide success modal
            successContainer.classList.add('hidden');
        });
        
        // Run format on initial value
        nominalInput.value = formatRupiah(nominalInput.value);
    </script>
</body>
</html>