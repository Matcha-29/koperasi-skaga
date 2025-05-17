<?php
require_once '../../config/connection.php';

if (isset($_POST['terima'])) {
    $id = $_POST['id'];
    $query = "UPDATE tb_pengajuan_peminjaman SET status = 'diterima' WHERE id = '$id'";
    mysqli_query($conn, $query);
    header("Location: ../pages/pengajuan_peminjaman.php");
    exit;
}

if (isset($_POST['tolak'])) {
    $id = $_POST['id'];
    $query = "UPDATE tb_pengajuan_peminjaman SET status = 'ditolak' WHERE id = '$id'";
    mysqli_query($conn, $query);
    header("Location: ../pages/pengajuan_peminjaman.php");
    exit;
}
?>
