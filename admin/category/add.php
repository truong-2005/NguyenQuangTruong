<?php
    require ('../lib/file.php');
    $u = new Upload();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get POST data
        $productName = $_POST['productName'];
        $slug = $_POST['slug'];
        $catId = $_POST['catId'];
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
<div style="width: 400px">
    <form method="post" action="<?= PATH_ADMIN?>page=catAdd">
        <div class="form-group">
            <label for="catName">Tên danh mục</label>
            <input type="text" class="form-control" id="catName" name="catName" required> 
        </div>
        <div class="form-group">
            <label for="slug">Slug</label>
            <input type="text" class="form-control" id="slug" name="slug" required>
        </div>
        <div class="form-group">
            <label for="parent">Danh mục cha</label>
            <select name="parent" id="parent" class="form-control"> 
                <option value="0">--- Chọn danh mục cha ---</option>
                <?php
                $sql = "SELECT * FROM category WHERE trash = 0";
                $result= $f->getAll($sql);
                foreach($result as $value):
                ?>
                <option value="<?= $value['id'] ?>"><?= $value['category_name'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Thêm</button>
    </form>
</div>