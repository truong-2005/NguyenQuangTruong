<?php
    require ('../lib/file.php');
    $u = new Upload();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get POST data
        $productName = $_POST['productName'];
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

        // Debugging output
        print_r($product);

        // File upload handling
        if (isset($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {
            $fileName = $_FILES['image']['name'];
            echo $fileName;
            $product['image'] = $fileName;
            $u->doUpload($_FILES['image']);
        } else {
            echo "No file selected";
        }

        // Check if the product name already exists
        $message = $f->checkExist("product", 'product_name', $productName);
        if ($message != 1) {
            $f->message($message);
        } else {
            // Add the new product to the database
            $f->addRecord("product", $product);
            // Redirect to product list page after successful insert
            header("Location: " . PATH_ADMIN . "page=productList");
            exit();
        }
    }
?>

<h2>Thêm Sản Phẩm</h2>
<form action="" method="POST" enctype="multipart/form-data">
    <div style="float: left; width: 48%; margin-right: 4%;">
        <label for="product_name">Tên sản phẩm:</label>
        <input type="text" id="product_name" name="productName" required placeholder="Nhập tên sản phẩm" style="width: 100%; padding: 10px; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 4px;"/>

        <label for="slug">Slug:</label>
        <input type="text" id="slug" name="slug" required placeholder="Nhập Slug" style="width: 100%; padding: 10px; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 4px;"/>

        <?php
            $sql = "SELECT id, category_name FROM category WHERE status = 1 AND trash = 0 AND parent != 0";
            $result = $f->getAll($sql);
        ?>
        <label for="cat">Danh mục:</label>
        <select class="form-control" name="cat" required>
            <?php
                foreach ($result as $c) {
                    echo "<option value='" . $c['id'] . "'>" . $c['category_name'] . "</option>";
                }
            ?>
        </select>

        <label for="description">Mô tả sản phẩm:</label>
        <textarea id="description" name="description" rows="5" required placeholder="Nhập mô tả sản phẩm" style="width: 100%; padding: 10px; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 4px;"></textarea>
    </div>

    <div style="float: left; width: 48%;">
        <label for="image">Hình ảnh sản phẩm:</label>
        <input type="file" id="image" name="image" accept="image/*" required style="width: 100%; padding: 10px; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 4px;"/>

        <label for="price">Giá:</label>
        <input type="number" id="price" name="price" required placeholder="Nhập giá sản phẩm" style="width: 100%; padding: 10px; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 4px;"/>

        <label for="metadesc">Metadesc:</label>
        <input type="text" id="metadesc" name="metadesc" required placeholder="Nhập Metadesc" style="width: 100%; padding: 10px; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 4px;"/>

        <label for="metakey">Metakey:</label>
        <input type="text" id="metakey" name="metakey" required placeholder="Nhập Metakey" style="width: 100%; padding: 10px; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 4px;"/>

        <button type="submit" style="width: 100%; padding: 12px; background-color: #4CAF50; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 16px;">
            Thêm sản phẩm
        </button>
    </div>
</form>