<?php include 'header.php'; ?>
<h1>Tambah Buku Baru</h1>
<form action="process_add.php" method="post" enctype="multipart/form-data" class="book-form">
    <label for="title">Judul Buku:</label>
    <input type="text" id="title" name="title" required>

    <label for="author">Penulis:</label>
    <input type="text" id="author" name="author" required>

    <label for="category">Kategori:</label>
    <select id="category" name="category_id" required>
        <?php
        include 'koneksi.php';
        $sql = "SELECT * FROM category";
        $result = $conn->query($sql);
        while ($row = $result->fetch_assoc()): ?>
            <option value="<?= $row['id'] ?>"><?= htmlspecialchars($row['name']) ?></option>
        <?php endwhile; ?>
    </select>

    <label for="cover">Cover Buku:</label>
    <input type="file" id="cover" name="cover" required>

    <button type="submit" class="add-button">Tambah Buku</button>
</form>
<?php include 'footer.php'; ?>