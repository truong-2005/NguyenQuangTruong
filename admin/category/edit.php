<?php
    require('../lib/file.php');
    $u = new Upload();
    $id = $_GET['id'];

    $sql = "SELECT * FROM product WHERE id = $id";
    $result = $f -> getOne($sql);
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
        $product_name = $_POST['product_name'];
        $slug = $_POST['slug'];
        $catId = $_POST['cat'];
        $description = $_POST['description'];
        $image = "temp.jpg"; // Default image if none selected
        $price = $_POST['price'];

        $metadesc = $_POST['metadesc'];
        $metakey = $_POST['metakey'];

        // Create product array
        $product = [
            'product_name' => $productName,
            'slug' => $slug,
            'cat_id' => $catId, // Updated to match column name
            'description' => $description,
            'image' => $image,
            'price' => (float)$price,
            'metadesc' => $metadesc,
            'metakey' => $metakey
        ];
    }
  ?>

<div style="width: 400px">
  <form method="post" action="<?= PATH_ADMIN ?>page=catEdit&catId=<?= $catId ?>">
    <div class="form-group">
      <label for="name">Tên danh mục</label>
      <input type="text" class="form-control" name="catname" value="<?= $cat['category_name'] ?>"  />
    </div>

    <!-- Thêm trường cho slug -->
    <div class="form-group">
      <label for="slug">Slug</label>
      <input type="text" class="form-control" name="slug" value="<?= $cat['slug'] ?>"  />
    </div>

    <!-- Thêm trường cho danh mục cha -->
    <div class="form-group">
      <label for="parent_category">Danh mục cha</label>
      <select class="form-control" name="parent_category">
        <option value="0">--Danh mục cha--</option>
        <?php
            // Lấy tất cả danh mục không bị xóa (trash = 0)
            $sql = "SELECT * FROM category WHERE trash = 0";
            $result = $f->getAll($sql);
            foreach ($result as $value):
        ?>
        <option value="<?= $value['id'] ?>" <?= $cat['parent'] == $value['id'] ? 'selected' : '' ?>>
            <?= $value['category_name'] ?>
        </option>
        <?php endforeach; ?>
      </select>
    </div>

    <input type="submit" class="btn btn-primary" value="Cập nhật" />
  </form>
</div>