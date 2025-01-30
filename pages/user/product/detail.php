<?php
// Lấy id từ URL
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0; // Đảm bảo id là số nguyên

// Lấy thông tin sản phẩm dựa trên id
$sql  = "SELECT * FROM product WHERE id=$id";
$result = $f->getOne($sql); // Truy vấn một sản phẩm

// Kiểm tra nếu không có sản phẩm
if (!$result) {
    $result = [
        'product_name' => 'Sản phẩm không tồn tại',
        'price' => 0,
        'description' => 'Không có mô tả cho sản phẩm này',

    ];
}

// Tăng lượt xem nếu sản phẩm tồn tại
if ($id > 0) {
    $sql_view = "UPDATE product SET views = views + 1 WHERE id = $id";
    $f->setQuery($sql_view);
}
?>

<div class="product-container">
    <div class="product-image">
        <!-- Hiển thị ảnh sản phẩm -->
        <img src="asset/images/<?= htmlspecialchars($result['image']) ?>" alt="Product Image">
    </div>
</div>

<div class="product-details">
    <h1><?= htmlspecialchars($result['product_name']) ?></h1> <!-- Hiển thị tên sản phẩm -->
    <p class="price"><?= number_format($result['price'], 0, ',', '.') ?></p> <!-- Hiển thị giá với định dạng -->
    <p class="description">
        <?= htmlspecialchars($result['description']) ?> <!-- Hiển thị mô tả sản phẩm -->
    </p>

    <!-- Form thêm vào giỏ hàng -->
    <form action="cart.php" method="POST">
        <label for="quantity">Số lượng: </label>
        <input type="number" id="quantity" name="quantity" min="1" value="1">
        <a class="btn btn-primary btn-sm" href="<?= PATH ?>page=addtocart&id=<?= $value['id'] ?>">Thêm vào giỏ hàng</a>
    </form>
</div>
