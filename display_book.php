<?php
include 'koneksi.php';

// Buat koneksi database
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Konfigurasi pagination
$buku_per_halaman = 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $buku_per_halaman;

// Ambil data buku dengan batasan sesuai pagination
$sql = "SELECT * FROM books LIMIT $offset, $buku_per_halaman";
$result = $conn->query($sql);

// Tampilkan daftar buku
if ($result->num_rows > 0) {
    echo '<div class="book-list-row">';
    while ($row = $result->fetch_assoc()) {
        echo '<div class="book-item">';
        echo '<div class="book-cover-wrapper">';
        echo '<img class="book-cover" src="uploads/' . $row["cover"] . '" alt="Cover Buku">';
        echo '</div>';
        echo '<div class="book-info">';
        echo '<h3 class="book-title">' . $row["title"] . '</h3>';
        echo '<p class="book-author">by ' . $row["author"] . '</p>';
        echo '<a href="#" class="book-details-button">Detail</a>';
        echo '</div>';
        echo '</div>';
    }
    echo '</div>';
} else {
    echo "Tidak ada buku di perpustakaan.";
}

// Hitung total buku untuk pagination
$total_buku_sql = "SELECT COUNT(*) as total FROM books";
$total_buku_result = $conn->query($total_buku_sql);
$total_buku_row = $total_buku_result->fetch_assoc();
$total_buku = $total_buku_row['total'];
$total_halaman = ceil($total_buku / $buku_per_halaman);

// Tampilkan navigasi pagination
echo '<div class="pagination">';
for ($i = 1; $i <= $total_halaman; $i++) {
    $active = ($i == $page) ? 'class="active"' : '';
    echo '<a ' . $active . ' href="?page=' . $i . '">' . $i . '</a>';
}
echo '</div>';

// Tutup koneksi
$conn->close();
