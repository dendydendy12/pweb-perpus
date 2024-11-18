<?php
$servername = "localhost";
$username = 'root';
$password = "";
$dbname  = "perpusku";

//buat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

//cek koneksi
if ($conn->connect_error) {
    die("koneksi gagal: " .$conn->connect_error);
}







?>