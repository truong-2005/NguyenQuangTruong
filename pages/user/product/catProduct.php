
<?php
$catId=$_GET['catId'];
$sql="SELECT * FROM product WHERE  cat_id=$catId AND status = 1 AND trash = 0";
$result  =$f->getAll($sql);
?>


<div style="display: flex; justify-content: center; flex-wrap: wrap; font-family: Arial, sans-serif; gap: 20px;">
    <?php foreach ($result as $p): ?>
        <div class="card shadow-sm" style="width: 22%; margin: 10px; border-radius: 15px; overflow: hidden; transition: all 0.3s ease; background-color: #ffffff; border: none;">
            <!-- Phần ảnh sản phẩm -->
            <div class="position-relative" style="height: 250px; background-color: #f4f4f4;">
                <img src="asset/images/<?= $p['image'] ?>" alt="Sản phẩm" class="img-fluid w-100 h-100" style="object-fit: cover;">
                <span class="badge bg-danger text-white position-absolute top-0 start-0 m-2 px-3 py-1" style="font-size: 0.8rem; border-radius: 20px;">Hot</span>
                <span class="badge bg-success text-white position-absolute top-0 end-0 m-2 px-3 py-1" style="font-size: 0.8rem; border-radius: 20px;">New</span>
            </div>
            <!-- Thông tin sản phẩm -->
            <div class="card-body text-center">
                <h5 class="card-title text-truncate fw-bold" style="font-size: 1.1rem;"><?= $p['product_name'] ?></h5>
                <p class="card-text text-danger fw-bold mb-2" style="font-size: 1.2rem;"><?= number_format($p['price'], 0, ',', '.') ?> VNĐ</p>
                <!-- Nút bấm -->
                <div class="d-flex justify-content-center gap-2">
                    <a class="btn btn-outline-primary btn-sm px-3 py-2" href="<?= PATH ?>page=detail&id=<?= $p['id'] ?>">Xem Chi Tiết</a>
                    <a class="btn btn-primary btn-sm px-3 py-2" href="<?= PATH ?>page=addtocart&id=<?= $p['id'] ?>">Thêm vào Giỏ</a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>



