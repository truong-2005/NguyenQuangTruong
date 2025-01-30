

<h1 style="text-align: center; color: #005085; font-size: 3rem; font-family: 'Arial', sans-serif; text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.3);">
    Các Sản Phẩm
</h1>

<!-- Thêm Bootstrap CSS -->


<div style="display: flex; justify-content: space-around; flex-wrap: wrap; font-family: Arial, sans-serif; text-align: center;">
    <?php
        // Lấy danh sách sản phẩm từ cơ sở dữ liệu
        $sql = "SELECT * FROM product WHERE status = 1 AND trash = 0";
        $result = $f->getAll($sql);
        foreach ($result as $value):
    ?>
    
    <div class="card shadow-sm" style="width: 22%; margin: 15px; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2); transition: transform 0.3s ease, box-shadow 0.3s ease;">
        <div class="position-relative" style="height: 350px; background-color: #f9f9f9;"> <!-- Tăng chiều cao vùng chứa -->
            <img src="asset/images/<?= $value['image'] ?>" alt="Sản phẩm" class="img-fluid w-100 h-100" style="width:100%">
            <span class="badge bg-warning text-dark position-absolute top-0 end-0 m-2 px-3 py-1" style="font-size: 0.8rem;">New</span>
        </div>
        <div class="card-body text-center">
            <h5 class="card-title text-truncate" style="font-size: 1.1rem;"><?= $value['product_name'] ?></h5>
            <p class="card-text text-danger fw-bold" style="font-size: 1.2rem;"><?= number_format($value['price'], 0, ',', '.') ?> VNĐ</p>
            <div class="d-flex justify-content-center gap-2">
                <!-- Nút xem chi tiết và thêm vào giỏ hàng với màu xanh dương -->
                <a class="btn btn-outline-primary btn-sm" href="<?= PATH ?>page=detail&id=<?= $value['id'] ?>">Xem Chi tiết Sản Phẩm</a>
                <a class="btn btn-primary btn-sm" href="<?= PATH ?>page=addtocart&id=<?= $value['id'] ?>">Thêm vào giỏ hàng</a>
            </div>
        </div>
    </div>
    
    <?php endforeach; ?>
</div>
