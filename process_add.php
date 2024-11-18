<?php
include 'koneksi.php'; // Pastikan koneksi ke database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $title = $_POST['title'];
    $author = $_POST['author'];
    $category_id = $_POST['category_id'];

    // Proses upload cover
    $cover = $_FILES['cover']['name'];
    $target_dir = "uploads/"; // Pastikan folder 'uploads/' ada dan dapat diakses
    $target_file = $target_dir . basename($cover);
    $uploadOk = 1;

    // Cek apakah file gambar adalah gambar sebenarnya
    $check = getimagesize($_FILES['cover']['tmp_name']);
    if ($check === false) {
        echo "File yang diupload bukan gambar.";
        $uploadOk = 0;
    }

    // Cek apakah file sudah ada
    if (file_exists($target_file)) {
        echo "Maaf, file sudah ada.";
        $uploadOk = 0;
    }

    // Cek ukuran file (batas 2MB)
    if ($_FILES['cover']['size'] > 2000000) {
        echo "Maaf, ukuran file terlalu besar.";
        $uploadOk = 0;
    }

    // Izinkan hanya format tertentu
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    if (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
        echo "Maaf, hanya file JPG, JPEG, PNG & GIF yang diperbolehkan.";
        $uploadOk = 0;
    }

    // Jika semua cek lolos, maka upload file
    if ($uploadOk == 1) {
        if (move_uploaded_file($_FILES['cover']['tmp_name'], $target_file)) {
            // Siapkan SQL untuk memasukkan data buku
            $sql = "INSERT INTO books (title, author, cover, category_id) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssi", $title, $author, $cover, $category_id);

            // Eksekusi dan cek apakah berhasil
            if ($stmt->execute()) {
                echo "Buku berhasil ditambahkan.";
                header("Location: admin.php"); // Redirect ke halaman admin setelah berhasil
                exit;
            } else {
                echo "Terjadi kesalahan saat menambahkan buku: " . $stmt->error;
            }
        } else {
            echo "Maaf, terjadi kesalahan saat mengupload file.";
        }
    }
}
