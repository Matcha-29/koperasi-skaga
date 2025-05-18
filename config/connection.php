<?php

date_default_timezone_set('Asia/Jakarta');
setlocale(LC_TIME, 'id_ID.utf8');

$username = 'root';
$password = '';
$database = 'db_koperasi';
$hostname = 'localhost';

$conn = new mysqli($hostname, $username, $password, $database);

if (!$conn)
{
    die('Koneksi Gagal');
}