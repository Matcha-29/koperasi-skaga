<?php
session_start();

require_once '../config/connection.php';

$role = $_SESSION['role'] ?? '';

if (empty($role) || $role !== 'admin') {
   header('Location: ../index.php');
}

$role = 'pengguna';

$stmtUser = $conn->prepare("SELECT COALESCE(COUNT(id), 0) FROM tb_pengguna WHERE role = ?");
$stmtUser->bind_param('s', $role);
$stmtUser->execute();
$stmtUser->bind_result($jumlah_pengguna);
$stmtUser->fetch();
$stmtUser->close();

$stmtSimpananWajib = $conn->prepare("SELECT COALESCE(SUM(jumlah_simpanan), 0) FROM tb_simpanan_wajib");
$stmtSimpananWajib->execute();
$stmtSimpananWajib->bind_result($jumlah_simpanan_wajib);
$stmtSimpananWajib->fetch();
$stmtSimpananWajib->close();

$stmtSimpananSukarela = $conn->prepare("SELECT COALESCE(SUM(jumlah_simpanan), 0) FROM tb_simpanan_sukarela");
$stmtSimpananSukarela->execute();
$stmtSimpananSukarela->bind_result($jumlah_simpanan_sukarela);
$stmtSimpananSukarela->fetch();
$stmtSimpananSukarela->close();

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
               <a href="./index.php" class="flex ms-2 md:me-24">
                  <img src="../image/logo.png" class="h-8 me-3" alt="FlowBite Logo" />
                  <span class="self-center text-xl font-semibold sm:text-2xl whitespace-nowrap ">Koperasi</span>
               </a>
            </div>
            <div class="flex items-center">
               <div class="flex items-center ms-3">
                  <div>
                     <button type="button" class="cursor-pointer flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300" aria-expanded="false" data-dropdown-toggle="dropdown-user">
                        <span class="sr-only">Open user menu</span>
                        <img class="w-8 h-8 rounded-full" src="../image/profile/default.png" alt="user photo">
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
                           <a href="../index.php" class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Kembali</a>
                        </li>
                        <li>
                           <form action="./backend/logout.php" method="POST">
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
               <a href="#" class="flex items-center p-2 text-gray-900 rounded-lg bg-gray-100 group">
                  <svg class="w-5 h-5 text-gray-500 transition duration-75 text-gray-900" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 21">
                     <path d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z" />
                     <path d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z" />
                  </svg>
                  <span class="ms-3">Dashboard</span>
               </a>
            </li>
            <li>
               <a href="./pages/pengguna.php" class="flex items-center p-2 text-gray-900 rounded-lg  hover:bg-gray-100 -gray-700 group">
                  <svg class="shrink-0 w-5 h-5 text-gray-500 transition duration-75 -400 group-hover:text-gray-900 :text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 18">
                     <path d="M14 2a3.963 3.963 0 0 0-1.4.267 6.439 6.439 0 0 1-1.331 6.638A4 4 0 1 0 14 2Zm1 9h-1.264A6.957 6.957 0 0 1 15 15v2a2.97 2.97 0 0 1-.184 1H19a1 1 0 0 0 1-1v-1a5.006 5.006 0 0 0-5-5ZM6.5 9a4.5 4.5 0 1 0 0-9 4.5 4.5 0 0 0 0 9ZM8 10H5a5.006 5.006 0 0 0-5 5v2a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-2a5.006 5.006 0 0 0-5-5Z" />
                  </svg>
                  <span class="flex-1 ms-3 whitespace-nowrap">Pengguna</span>
               </a>
            </li>
            <li>
               <button type="button" class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100" aria-controls="dropdown-example" data-collapse-toggle="dropdown-example">
                  <!-- Ikon Tangan dengan Uang -->
                  <svg class="shrink-0 w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" fill="currentColor" aria-hidden="true">
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
                     <a href="./pages/simpanan_wajib.php" class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100">Simpanan Wajib</a>
                  </li>
                  <li>
                     <a href="./pages/simpanan_sukarela.php" class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100">Simpanan Sukarela</a>
                  </li>
                  <li>
                     <a href="./pages/simpanan_pokok.php" class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100">Simpanan Pokok</a>
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
                     <a href="./pages/pinjaman_reguler.php" class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100">Pinjaman Reguler</a>
                  </li>
                  <li>
                     <a href="./pages/pinjaman_insidental.php" class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100">Pinjaman Insidental</a>
                  </li>
               </ul>
            </li>
            <li>
               <a href="./pages/pengajuan_peminjaman.php" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group">
                  <i class="fas fa-handshake w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900"></i>
                  <span class="flex-1 ms-3 whitespace-nowrap">Pengajuan Pinjaman</span>
               </a>
            </li>
         </ul>
      </div>
   </aside>

   <div class="p-4 sm:ml-64">
      <div class="p-4 mt-14">
         <div class="grid grid-cols-3 gap-4 mb-4">
            <div class="flex justify-between items-center  p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
               <div class="">
                  <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">Jumlah Anggota Koperasi</p>
                  <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white"><?= $jumlah_pengguna ?> Orang</h5>
               </div>

               <div class="">
                  <i class="fas fa-user text-5xl"></i>
               </div>
            </div>
            <div class="flex justify-between items-center  p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
               <div class="">
                  <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">Jumlah Simpanan Wajib</p>
                  <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Rp <?= number_format($jumlah_simpanan_wajib, 0, ',', '.') ?></h5>
               </div>

               <div class="">
                  <i class="fa-solid fa-money-bill-wave text-5xl"></i>
               </div>
            </div>
            <div class="flex justify-between items-center  p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
               <div class="">
                  <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">Jumlah Simpanan Sukarela</p>
                  <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Rp <?= number_format($jumlah_simpanan_sukarela, 0, ',', '.') ?></h5>
               </div>

               <div class="">
                  <i class="fa-solid fa-money-bill-wave text-5xl"></i>
               </div>
            </div>
         </div>
      </div>
   </div>

   <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
</body>

</html>