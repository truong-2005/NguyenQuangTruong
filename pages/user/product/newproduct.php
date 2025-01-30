<h1 style="text-align: center; color: #005085; font-size: 3rem; font-family: 'arial', sans-serif; text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.3);">
    Các Sản Phẩm Mới Nhất
</h1>




<div style="display: flex; justify-content: space-around; flex-wrap: wrap; font-family: Arial, sans-serif; text-align: center;">
    <?php
        // Lấy 4 sản phẩm mới nhất từ cơ sở dữ liệu
        $sql = "SELECT * FROM product WHERE status = 1 AND trash = 0 ORDER BY created_at DESC LIMIT 0,4"; 
        $result = $f->getAll($sql);
        foreach ($result as $value):
    ?>
    
    <div class="card shadow-sm" style="width: 22%; margin: 15px; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2); transition: transform 0.3s ease, box-shadow 0.3s ease;">
        <div class="position-relative" style="height: 350px; background-color: #f9f9f9;"> <!-- Tăng chiều cao vùng chứa -->
            <img src="asset/images/<?= $value['image'] ?>" alt="Sản phẩm" class="img-fluid w-100 h-100" style="width:100%">
            <?php if ($value['is_on_sale'] == 1): ?>
                <span class="badge bg-danger text-white position-absolute top-0 end-0 m-2 px-3 py-1" style="font-size: 0.8rem;">Sale</span>
            <?php else: ?>
                <span class="badge bg-warning text-dark position-absolute top-0 end-0 m-2 px-3 py-1" style="font-size: 0.8rem;">New</span>
            <?php endif; ?>
        </div>
        <div class="card-body text-center">
            <h5 class="card-title text-truncate" style="font-size: 1.1rem;"><?= $value['product_name'] ?></h5>
            <p class="card-text text-danger fw-bold" style="font-size: 1.2rem;"><?= number_format($value['price'], 0, ',', '.') ?> VNĐ</p>
            <div class="d-flex justify-content-center gap-2">
                <!-- Nút xem chi tiết và thêm vào giỏ hàng với màu xanh dương -->
                <a class="btn btn-outline-primary btn-sm" href="<?= PATH ?>page=detail&id=<?= $value['id'] ?>">Xem Chi tiết Sản Phẩm</a>
                <a class="btn btn-primary btn-sm" href="#">Thêm vào giỏ hàng</a>
            </div>
        </div>
    </div>
    
    <?php endforeach; ?>
</div>

<h1 style="text-align: center; color: #005085; font-size: 3rem; font-family: 'Arial', sans-serif; text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.3);">
    Các Sản Phẩm Giảm giá
</h1>

<!-- Thêm Bootstrap CSS -->


<div style="display: flex; justify-content: space-around; flex-wrap: wrap; font-family: Arial, sans-serif; text-align: center;">
    <?php
        // Lấy các sản phẩm giảm giá từ cơ sở dữ liệu
        $sql = "SELECT * FROM product WHERE is_on_sale = 1 AND status = 1 AND trash = 0"; 
        $result = $f->getAll($sql);
        foreach ($result as $value):
    ?>
<div class="card shadow-sm" style="width: 22%; margin: 15px; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2); transition: transform 0.3s ease, box-shadow 0.3s ease;">
        <div class="position-relative" style="height: 350px; background-color: #f9f9f9;"> <!-- Tăng chiều cao vùng chứa -->
            <img src="asset/images/<?= $value['image'] ?>" alt="Sản phẩm" class="img-fluid w-100 h-100" style="width:100%">
            <span class="badge bg-danger text-white position-absolute top-0 end-0 m-2 px-3 py-1" style="font-size: 0.8rem;">Sale</span>
        </div>
        <div class="card-body text-center">
            <h5 class="card-title text-truncate" style="font-size: 1.1rem;"><?= $value['product_name'] ?></h5>
            
            <!-- Hiển thị giá cũ (nếu có) và giá mới -->
            <p class="card-text">
                <?php if (!empty($value['sale_price']) && $value['sale_price'] < $value['price']): ?>
                    <span style="text-decoration: line-through; color: #888; font-size: 1.1rem;"><?= number_format($value['price'], 0, ',', '.') ?> VNĐ</span>
                    <span style="color: red; font-size: 1.2rem; font-weight: bold;">Giảm còn: <?= number_format($value['sale_price'], 0, ',', '.') ?> VNĐ</span>
                <?php else: ?>
                    <span style="color: red; font-size: 1.2rem; font-weight: bold;"><?= number_format($value['price'], 0, ',', '.') ?> VNĐ</span>
                <?php endif; ?>
            </p>
            
            <div class="d-flex justify-content-center gap-2">
                <!-- Nút xem chi tiết và thêm vào giỏ hàng với màu xanh dương -->
                <a class="btn btn-outline-primary btn-sm" href="<?= PATH ?>page=detail&id=<?= $value['id'] ?>">Xem Chi tiết Sản Phẩm</a>
                <a class="btn btn-primary btn-sm" href="#">Thêm vào giỏ hàng</a>
            </div>
        </div>
    </div>
    
    <?php endforeach; ?>
</div>
<!-- 4 Sản phẩm được xem nhiều nhất-->
<h1 style="text-align: center; color: #005085; font-size: 3rem; font-family: 'Arial', sans-serif; text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.3);">
    Các Sản Phẩm Được Xem Nhiều Nhất
</h1>

<!-- Thêm Bootstrap CSS -->


<div style="display: flex; justify-content: space-around; flex-wrap: wrap; font-family: Arial, sans-serif; text-align: center;">
    <?php
        // Lấy 4 sản phẩm được xem nhiều nhất từ cơ sở dữ liệu
        $sql_view = "SELECT * FROM product ORDER BY views DESC LIMIT 0,4"; 
        $result = $f->getAll($sql_view);
        foreach ($result as $value)
    ?>

    <!-- <div class="card shadow-sm" style="width: 22%; margin: 15px; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2); transition: transform 0.3s ease, box-shadow 0.3s ease;"> -->