<?php
include 'header.php';
include 'koneksi.php';

// Ambil daftar kategori dari database
$sql = "SELECT * FROM category";
$result = $conn->query($sql);

// Cek apakah ada kategori yang dipilih
$category_id = isset($_GET['category_id']) ? intval($_GET['category_id']) : 0;

// Jika kategori dipilih, ambil buku-buku dalam kategori tersebut
$books = [];
$category_name = ''; // Variabel untuk menyimpan nama kategori
if ($category_id > 0) {
    // Ambil nama kategori
    $categorySql = "SELECT name FROM category WHERE id = $category_id LIMIT 1";
    $categoryResult = $conn->query($categorySql);

    if ($categoryRow = $categoryResult->fetch_assoc()) {
        $category_name = $categoryRow['name'];

        // Ambil buku dalam kategori tersebut
        $bookSql = "SELECT * FROM books WHERE category_id = $category_id";
        $bookResult = $conn->query($bookSql);
        while ($bookRow = $bookResult->fetch_assoc()) {
            $books[] = $bookRow;
        }
    }
}
?>

<h1>Kategori Buku</h1>
<div class="category-list">
    <?php while ($row = $result->fetch_assoc()): ?>
    <div class="category-item">
        <a href="kategori.php?category_id=<?= $row['id'] ?>">
            <?= htmlspecialchars($row['name']) ?>
        </a>
    </div>
    <?php endwhile; ?>
</div>

<?php if ($category_id > 0): ?>
<div class="book-list-row">
    <?php if (!empty($books)): ?>
    <?php foreach ($books as $book): ?>
    <div class="book-item">
        <div class="book-cover-wrapper">
            <img src="uploads/<?= htmlspecialchars($book['cover']) ?>" class="book-cover" alt="Cover">
        </div>
        <div class="book-info">
            <div class="book-title"><?= htmlspecialchars($book['title']) ?></div>
            <div class="book-author"><?= htmlspecialchars($book['author']) ?></div>
            <a href="edit_book.php?id=<?= $book['id'] ?>" class="book-details-button">Edit</a>
        </div>
    </div>
    <?php endforeach; ?>
    <?php else: ?>
    <p>Tidak ada buku dalam kategori ini.</p>
    <?php endif; ?>
</div>
<?php endif; ?>

<?php
if (file_exists('footer.php')) {
    include 'footer.php';
}
?>
</body>

</html>