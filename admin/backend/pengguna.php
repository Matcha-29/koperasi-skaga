<?php
require_once '../../config/connection.php';

if (isset($_POST['submit'])) {
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $alamat = $_POST['alamat'];
    $no_telepon = $_POST['no_telepon'];
    $password = password_hash("password", PASSWORD_DEFAULT);

    if ($_FILES['foto_profil']['error'] === 0) {
        $foto = $_FILES['foto_profil']['name'];
        $tmp = $_FILES['foto_profil']['tmp_name'];
        move_uploaded_file($tmp, "../../image/profile/$foto");
    } else {
        $foto = null;
    }

    $stmt = $conn->prepare("INSERT INTO tb_pengguna (nama, email, alamat, no_telepon, password, foto_profil) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $nama, $email, $alamat, $no_telepon, $password, $foto);
    $stmt->execute();
    $stmt->close();

    header("Location: ../pages/pengguna.php");
    exit;
}

if (isset($_POST['edit'])) {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $alamat = $_POST['alamat'];
    $no_telepon = $_POST['no_telepon'];

    if ($_FILES['foto_profil']) {
        $foto = $_FILES['foto_profil']['name'];
        $tmp = $_FILES['foto_profil']['tmp_name'];
        move_uploaded_file($tmp, "../../image/profile/$foto");

        $stmt = $conn->prepare("UPDATE tb_pengguna SET nama = ?, email = ?, alamat = ?, no_telepon = ?, foto_profil = ? WHERE id = ?");
        $stmt->bind_param("sssssi", $nama, $email, $alamat, $no_telepon, $foto, $id);
    } else {
        $stmt = $conn->prepare("UPDATE tb_pengguna SET nama = ?, email = ?, alamat = ?, no_telepon = ? WHERE id = ?");
        $stmt->bind_param("ssssi", $nama, $email, $alamat, $no_telepon, $id);
    }

    $stmt->execute();
    $stmt->close();

    header("Location: ../pages/pengguna.php");
    exit;
}

if (isset($_POST['hapus'])) {
    $id = $_POST['id'];

    $stmt = $conn->prepare("DELETE FROM tb_pengguna WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();

    header("Location: ../pages/pengguna.php");
    exit;
}

if (isset($_POST['reset'])) {
    $id = $_POST['id'];
    $password = password_hash("password", PASSWORD_DEFAULT);

    $stmt = $conn->prepare("UPDATE tb_pengguna SET password = ? WHERE id = ?");
    $stmt->bind_param("si", $password, $id);
    $stmt->execute();
    $stmt->close();

    header("Location: ../pages/pengguna.php");
    exit;
}
?>
