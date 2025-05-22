<?php
// index.php
session_start();
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
            transition: background-color 0.2s;
        }
        .keypad-button:hover {
            background-color: #f9fafb;
        }
        .keypad-button:active {
            background-color: #f3f4f6;
        }
        .bottom-nav {
            z-index: 1000;
        }
        
        /* Prevent scrolling when dropdown is open */
        .no-scroll {
            overflow: hidden;
        }
        
        /* Dropdown overlay to prevent interaction with other elements */
        .dropdown-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.1);
            z-index: 100;
        }
        
        /* Ensure dropdown appears above overlay */
        .dropdown-container {
            position: relative;
            z-index: 101;
        }
    </style>
</head>
<body class="bg-gray-100">
    <!-- Dropdown overlay (hidden by default) -->
    <div id="dropdownOverlay" class="dropdown-overlay hidden" onclick="closeDropdown()"></div>
    
    <div class="max-w-md mx-auto flex flex-col bg-gray-50 min-h-screen">
        <div class="px-5 pt-10 flex-1">
            <!-- Header -->
            <h1 class="text-2xl font-semibold text-center mb-8">Ajuan Pembiayaan</h1>
            
            <!-- Dropdown Selection -->
            <div class="bg-white rounded-lg shadow mb-8 dropdown-container">
                <div class="p-4 flex justify-between items-center cursor-pointer" onclick="toggleDropdown()">
                    <span class="text-black font-medium" id="selectedOption">Reguler</span>
                    <i id="dropdownIcon" class="fas fa-chevron-down text-gray-600 transition-transform duration-200"></i>
                </div>
                <div id="dropdownMenu" class="hidden border-t bg-white rounded-b-lg shadow-lg">
                    <div onclick="selectOption('Reguler')" class="cursor-pointer hover:bg-gray-100 p-4 font-medium transition-colors">Reguler</div>
                    <div onclick="selectOption('Insidental')" class="cursor-pointer hover:bg-gray-100 p-4 font-medium transition-colors border-t border-gray-100">Insidental</div>
                </div>
            </div>
            
            <!-- Nominal Input -->
            <div class="mb-6">
                <label class="text-gray-500 text-sm block mb-1">Masukan Nominal</label>
                <div class="border-b border-gray-300 pb-2">
                    <div class="flex items-center">
                        <span class="text-black mr-1">RP</span>
                        <input type="text" class="w-full bg-transparent outline-none text-black text-lg" id="nominal" value="0" readonly>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Submit Button - Positioned directly above keypad -->
        <button class="w-full bg-orange-500 hover:bg-orange-600 text-white font-bold py-4 rounded-lg text-center mb-4 mx-1 transition-colors" id="ajukanButton">AJUKAN</button>
        
        <!-- Custom Keypad -->
        <div class="w-full bg-gray-200 pb-28 pt-1 px-1"> <!-- Increased pb to pb-28 for better spacing -->
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
        
        <!-- Bottom Navigation -->
        <div class="fixed bottom-0 w-full max-w-md bg-white border-t border-gray-200 flex justify-around items-center py-4 bottom-nav">
            <a href="ajuan_pembiayaan.php" class="flex flex-col items-center text-orange-500">
                <i class="fas fa-th-large text-xl mb-1"></i>
                <span class="text-xs">Ajuan</span>
            </a>

            <!-- Spacer for home button -->
            <div class="absolute left-1/2 transform -translate-x-1/2 bottom-16">
                <a href="index.php" class="block">
                    <div class="w-16 h-16 bg-gray-500 rounded-full flex justify-center items-center shadow-md hover:bg-gray-600 transition-colors">
                        <i class="fas fa-home text-white text-2xl"></i>
                    </div>
                </a>
            </div>

            <a href="profile.php" class="flex flex-col items-center text-gray-500 hover:text-gray-700 transition-colors">
                <i class="far fa-user text-xl mb-1"></i>
                <span class="text-xs">Profil</span>
            </a>
        </div>
    </div>
    
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
                
                <!-- Success message -->
                <h2 class="text-xl font-bold mb-2 text-white text-center">Pembiayaan diajukan</h2>
                <p class="text-sm text-center text-white">Cek Aplikasi secara berkala untuk memastikan status pengajuan!</p>
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
        const dropdownOverlay = document.getElementById('dropdownOverlay');
        
        // Toggle dropdown visibility
        function toggleDropdown() {
            dropdownMenu.classList.toggle('hidden');
            dropdownIcon.classList.toggle('rotate-180');
            dropdownOverlay.classList.toggle('hidden');
            
            // Prevent body scrolling when dropdown is open
            if (!dropdownMenu.classList.contains('hidden')) {
                document.body.classList.add('no-scroll');
            } else {
                document.body.classList.remove('no-scroll');
            }
        }
        
        // Close dropdown
        function closeDropdown() {
            dropdownMenu.classList.add('hidden');
            dropdownIcon.classList.remove('rotate-180');
            dropdownOverlay.classList.add('hidden');
            document.body.classList.remove('no-scroll');
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
            closeDropdown();
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
        
        // Event listener for Submit button
        ajukanButton.addEventListener('click', function() {
            // Show success modal
            successContainer.classList.remove('hidden');
        });
        
        // Event listener for Close button on success modal
        closeButton.addEventListener('click', function() {
            // Hide success modal
            successContainer.classList.add('hidden');
        });
        
        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const dropdownContainer = document.querySelector('.dropdown-container');
            if (!dropdownContainer.contains(event.target) && !dropdownMenu.classList.contains('hidden')) {
                closeDropdown();
            }
        });
        
        // Add touch feedback for keypad buttons
        document.querySelectorAll('.keypad-button').forEach(button => {
            button.addEventListener('touchstart', function() {
                this.style.backgroundColor = '#f3f4f6';
            });
            
            button.addEventListener('touchend', function() {
                setTimeout(() => {
                    this.style.backgroundColor = 'white';
                }, 100);
            });
        });
        
        // Run format on initial value
        nominalInput.value = formatRupiah(nominalInput.value);
    </script>
</body>
</html>

<?php
// process.php (if needed to save data to server)
/*
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nominal = $_POST['nominal'] ?? '';
    
    // Process data here (e.g., save to database)
    
    // Return JSON response
    header('Content-Type: application/json');
    echo json_encode(['status' => 'success', 'message' => 'Pembiayaan berhasil diajukan']);
    exit;
}
*/
?>