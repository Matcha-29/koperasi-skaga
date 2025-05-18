<?php
session_start();

$role = $_SESSION['role'] ?? '';

if (empty($role) || $role !== 'admin')
{
   header('Location: ../index.php');
}

require_once '../../config/connection.php';

// Eksekusi query
$stmt = $conn->prepare("
    SELECT p.*, u.nama 
    FROM tb_simpanan_pokok p 
    INNER JOIN tb_pengguna u ON p.id_pengguna = u.id 
    ORDER BY u.nama ASC
");
$stmt->execute();

// Ambil hasil
$result = $stmt->get_result();

function formatTanggal($tanggal)
{
    $date = new DateTime($tanggal);

    $formatter = new IntlDateFormatter('id_ID', IntlDateFormatter::LONG, IntlDateFormatter::NONE, 'Asia/Jakarta');

    return $formatter->format($date);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Koperasi</title>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body>


    <nav class="fixed top-0 z-50 w-full bg-white border-b border-gray-200">
        <div class="px-3 py-3 lg:px-5 lg:pl-3">
            <div class="flex items-center justify-between">
                <div class="flex items-center justify-start rtl:justify-end">
                    <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar" type="button" class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 -400 -gray-700 -gray-600">
                        <span class="sr-only">Open sidebar</span>
                        <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
                        </svg>
                    </button>
                    <a href="../index.php" class="flex ms-2 md:me-24">
                        <img src="../../image/logo.png" class="h-8 me-3" alt="FlowBite Logo" />
                        <span class="self-center text-xl font-semibold sm:text-2xl whitespace-nowrap ">Koperasi</span>
                    </a>
                </div>
                <div class="flex items-center">
                    <div class="flex items-center ms-3">
                        <div>
                            <button type="button" class="cursor-pointer flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300" aria-expanded="false" data-dropdown-toggle="dropdown-user">
                                <span class="sr-only">Open user menu</span>
                                <img class="w-8 h-8 rounded-full" src="../../image/profile/default.png" alt="user photo">
                            </button>
                        </div>
                        <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-sm shadow-sm" id="dropdown-user">
                            <div class="px-4 py-3" role="none">
                                <p class="text-sm text-gray-900 " role="none">
                                    <?= $_SESSION['nama'] ?? '-' ?>
                                </p>
                                <p class="text-sm font-medium text-gray-900 truncate" role="none">
                                    <?= $_SESSION['email'] ?? '-' ?>
                                </p>
                            </div>
                            <ul class="py-1" role="none">
                                <li>
                                    <a href="../../index.php" class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Kembali</a>
                                </li>
                                <li>
                                    <form action="../backend/logout.php" method="POST">
                                        <button type="submit" name="logout" class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Keluar</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <aside id="logo-sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full bg-white border-r border-gray-200 sm:translate-x-0 -800 -700" aria-label="Sidebar">
        <div class="h-full px-3 pb-4 overflow-y-auto bg-white -800">
            <ul class="space-y-2 font-medium">
                <li class="">
                    <a href="../index.php" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group">
                        <svg class="w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 21">
                            <path d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z" />
                            <path d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z" />
                        </svg>
                        <span class="ms-3">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="./pengguna.php" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 -gray-700 group">
                        <svg class="shrink-0 w-5 h-5 text-gray-500 transition duration-75 -400 hover:text-gray-900 :text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 18">
                            <path d="M14 2a3.963 3.963 0 0 0-1.4.267 6.439 6.439 0 0 1-1.331 6.638A4 4 0 1 0 14 2Zm1 9h-1.264A6.957 6.957 0 0 1 15 15v2a2.97 2.97 0 0 1-.184 1H19a1 1 0 0 0 1-1v-1a5.006 5.006 0 0 0-5-5ZM6.5 9a4.5 4.5 0 1 0 0-9 4.5 4.5 0 0 0 0 9ZM8 10H5a5.006 5.006 0 0 0-5 5v2a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-2a5.006 5.006 0 0 0-5-5Z" />
                        </svg>
                        <span class="flex-1 ms-3 whitespace-nowrap">Pengguna</span>
                    </a>
                </li>
                <li>
                    <button type="button" class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group bg-gray-100" aria-controls="dropdown-example" data-collapse-toggle="dropdown-example">
                  <!-- Ikon Tangan dengan Uang -->
                  <svg class="shrink-0 w-5 h-5 text-gray-500 transition duration-75 text-gray-900" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" fill="currentColor" aria-hidden="true">
                     <path d="M312 24V34.5c6.4 1.2 12.6 2.7 18.2 4.2c12.8 3.4 20.4 16.6 17 29.4s-16.6 20.4-29.4 17c-10.9-2.9-21.1-4.9-30.2-5c-7.3-.1-14.7 1.7-19.4 4.4c-2.1 1.3-3.1 2.4-3.5 3c-.3 .5-.7 1.2-.7 2.8c0 .3 0 .5 0 .6c.2 .2 .9 1.2 3.3 2.6c5.8 3.5 14.4 6.2 27.4 10.1l.9 .3 0 0c11.1 3.3 25.9 7.8 37.9 15.3c13.7 8.6 26.1 22.9 26.4 44.9c.3 22.5-11.4 38.9-26.7 48.5c-6.7 4.1-13.9 7-21.3 8.8V232c0 13.3-10.7 24-24 24s-24-10.7-24-24V220.6c-9.5-2.3-18.2-5.3-25.6-7.8c-2.1-.7-4.1-1.4-6-2c-12.6-4.2-19.4-17.8-15.2-30.4s17.8-19.4 30.4-15.2c2.6 .9 5 1.7 7.3 2.5c13.6 4.6 23.4 7.9 33.9 8.3c8 .3 15.1-1.6 19.2-4.1c1.9-1.2 2.8-2.2 3.2-2.9c.4-.6 .9-1.8 .8-4.1l0-.2c0-1 0-2.1-4-4.6c-5.7-3.6-14.3-6.4-27.1-10.3l-1.9-.6c-10.8-3.2-25-7.5-36.4-14.4c-13.5-8.1-26.5-22-26.6-44.1c-.1-22.9 12.9-38.6 27.7-47.4c6.4-3.8 13.3-6.4 20.2-8.2V24c0-13.3 10.7-24 24-24s24 10.7 24 24zM568.2 336.3c13.1 17.8 9.3 42.8-8.5 55.9L433.1 485.5c-23.4 17.2-51.6 26.5-80.7 26.5H192 32c-17.7 0-32-14.3-32-32V416c0-17.7 14.3-32 32-32H68.8l44.9-36c22.7-18.2 50.9-28 80-28H272h16 64c17.7 0 32 14.3 32 32s-14.3 32-32 32H288 272c-8.8 0-16 7.2-16 16s7.2 16 16 16H392.6l119.7-88.2c17.8-13.1 42.8-9.3 55.9 8.5z"/>
                  </svg>
                  <!-- Teks Tombol -->
                  <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">Simpanan</span>
                  <!-- Ikon Panah Bawah -->
                  <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                     <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1l4 4 4-4" />
                  </svg>
               </button>
                    <ul id="dropdown-example" class="hidden py-2 space-y-2">
                        <li>
                            <a href="./simpanan_wajib.php" class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100">Simpanan Wajib</a>
                        </li>
                        <li>
                            <a href="./simpanan_sukarela.php" class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100">Simpanan Sukarela</a>
                        </li>
                        <li>
                            <a href="./simpanan_pokok.php" class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group bg-gray-100">Simpanan Pokok</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <button type="button" class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100" aria-controls="pinjaman" data-collapse-toggle="pinjaman">
                  <!-- Ganti icon dengan font awesome -->
                  <i class="fas fa-credit-card w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900"></i>
                  
                  <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">Pinjaman</span>

                  <!-- Panah dropdown tetap pakai SVG -->
                  <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                     <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
                  </svg>
               </button>
                    <ul id="pinjaman" class="hidden py-2 space-y-2">
                        <li>
                            <a href="./pinjaman_reguler.php" class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100">Pinjaman Reguler</a>
                        </li>
                        <li>
                            <a href="./pinjaman_insidental.php" class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100">Pinjaman Insidental</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="./pengajuan_peminjaman.php" class="flex items-center p-2 text-gray-900 rounded-lg  hover:bg-gray-100 -gray-700 group">
                    <i class="fas fa-handshake w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900"></i>
                  <span class="flex-1 ms-3 whitespace-nowrap">Pengajuan Pinjaman</span>
                    </a>
                </li>
            </ul>
        </div>
    </aside>

    <div class="p-4 sm:ml-64">
        <div class="p-4 mt-14">
            <div class="w-full p-4 bg-white border border-gray-200 rounded-lg shadow-sm sm:p-8 dark:bg-gray-800 dark:border-gray-700">
                <div class="mb-6 flex justify-between">
                    <h2 class="font-bold text-2xl">Data Simpanan Pokok</h2>

                    <div class="">
                        <button class="px-4 py-2 rounded-md bg-blue-500 font-medium text-white cursor-pointer" data-drawer-target="drawer-right-example" data-drawer-show="drawer-right-example" data-drawer-placement="right" aria-controls="drawer-right-example"><i class="fas fa-file-upload mr-1"></i> Unggah Data</button>
                        <button class="px-4 py-2 rounded-md bg-blue-500 font-medium text-white cursor-pointer" data-drawer-target="drawer-right-nominal" data-drawer-show="drawer-right-nominal" data-drawer-placement="right" aria-controls="drawer-right-example"><i class="fas fa-pencil mr-1"></i> Ubah Nominal</button>
                    </div>
                </div>

                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    No
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Nama
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Tanggal Simpanan
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Jumlah Simpanan
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            while ($row = mysqli_fetch_assoc($result)) :
                            ?>
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        <?= $no++ ?>
                                    </th>
                                    <td class="px-6 py-4">
                                        <?= $row['nama'] ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <?= formatTanggal($row['tanggal_simpanan']) ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        Rp <?= number_format($row['jumlah_simpanan'], 0, ',', '.') ?>
                                    </td>
                                </tr>
                            <?php endwhile ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- drawer component -->
    <div id="drawer-right-example" class="pt-20 fixed top-0 right-0 z-40 h-screen p-4 overflow-y-auto transition-transform translate-x-full bg-white w-80 dark:bg-gray-800" tabindex="-1" aria-labelledby="drawer-right-label">
        <div class="flex justify-between">
            <h5 id="drawer-right-label" class="inline-flex items-center mb-4 text-base font-semibold text-gray-500 dark:text-gray-400">Unggah File Excel</h5>
            <button type="button" data-drawer-hide="drawer-right-example" aria-controls="drawer-right-example" class="btn-close text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 inline-flex items-center justify-center dark:hover:bg-gray-600 dark:hover:text-white">
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                </svg>
                <span class="sr-only">Close menu</span>
            </button>
        </div>

        <form method="POST" action="../backend/simpanan_pokok.php" class="mb-6" enctype="multipart/form-data">
            <div class="mb-6">
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="file_input">File Excel</label>
                <input name="file_excel" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" aria-describedby="file_input_help" id="file_input" type="file">
            </div>

                <button name="submit" type="submit" class="cursor-pointer text-white justify-center flex items-center bg-blue-700 hover:bg-blue-800 w-full focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                    Unggah
                </button>
        </form>
    </div>

    <div id="drawer-right-nominal" class="pt-20 fixed top-0 right-0 z-40 h-screen p-4 overflow-y-auto transition-transform translate-x-full bg-white w-80 dark:bg-gray-800" tabindex="-1" aria-labelledby="drawer-right-label">
        <div class="flex justify-between">
            <h5 id="drawer-right-label" class="inline-flex items-center mb-4 text-base font-semibold text-gray-500 dark:text-gray-400">Ubah Nominal Simpanan Pokok</h5>
            <button type="button" data-drawer-hide="drawer-right-nominal" aria-controls="drawer-right-nominal" class="btn-close text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 inline-flex items-center justify-center dark:hover:bg-gray-600 dark:hover:text-white">
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                </svg>
                <span class="sr-only">Close menu</span>
            </button>
        </div>

        <form method="POST" action="../backend/simpanan_pokok.php" class="mb-6">
            <div class="mb-6">
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="nominal">Nominal</label>
                <input name="nominal" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" aria-describedby="nominal_help" id="nominal" type="number">
            </div>

                <button name="ubah_nominal" type="submit" class="cursor-pointer text-white justify-center flex items-center bg-blue-700 hover:bg-blue-800 w-full focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                    Ubah
                </button>
        </form>
    </div>

    <!-- Modal -->
    <div id="confirmModal" tabindex="-1" aria-hidden="true"
        class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto bg-black/50 inset-0 h-modal h-full justify-center items-center">
        <div class="relative w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow p-6">
                <h3 class="mb-4 text-lg font-semibold text-gray-900" id="modalTitle">Konfirmasi</h3>
                <p class="mb-6 text-sm text-gray-600" id="modalMessage">Apakah Anda yakin?</p>

                <form method="post" action="../backend/pengguna.php">
                    <input type="hidden" name="id" id="modalUserId">
                    <div class="flex justify-end gap-2">
                        <button type="button" data-modal-hide="confirmModal" class="text-gray-500 bg-gray-200 hover:bg-gray-300 px-4 py-2 rounded cursor-pointer">
                            Batal
                        </button>
                        <button type="submit" id="modalSubmitButton" name="" class="bg-red-600 text-white px-4 py-2 rounded cursor-pointer">
                            Ya, Lanjutkan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function setModalData(userId, action) {
            document.getElementById('modalUserId').value = userId;
            const title = document.getElementById('modalTitle');
            const message = document.getElementById('modalMessage');
            const submitButton = document.getElementById('modalSubmitButton');

            if (action === 'hapus') {
                title.textContent = 'Konfirmasi Hapus';
                message.textContent = 'Apakah Anda yakin ingin menghapus data ini?';
                submitButton.name = 'hapus';
                submitButton.classList.replace('bg-gray-700', 'bg-red-600');
            } else if (action === 'reset') {
                title.textContent = 'Reset Password';
                message.textContent = 'Apakah Anda yakin ingin me-reset password ke default?';
                submitButton.name = 'reset';
                submitButton.classList.replace('bg-red-600', 'bg-gray-700');
            }
        }

        document.querySelector('.btn-close').addEventListener('click', () => {
            setTimeout(() => {
                document.querySelector('.overlay').classList.add('hidden');
            }, 200);
        })
    </script>

    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
</body>

</html>