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
        $price = $_POST['price'];
        $metadesc = $_POST['metadesc'];
        $metakey = $_POST['metakey'];
        $is_on_sale = $_POST['is_on_sale'];
        $sale_price = $_POST['sale_price'];
        $status = $_POST['status'];

        $product = [
            'product_name' => $product_name,
            'slug' => $slug,
            'cat_id' => $catId, 
            'description' => $description,
            //'image' => $image,
            'price' => (float)$price,
            'metadesc' => $metadesc,
            'metakey' => $metakey,
            'is_on_sale'=>$is_one_sale,
            'sale_price'=>$sale_price,
            'status'=>$status
        ];
        print_r($product);
        if(isset($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE)
        {
            $fileName = $_FILES['image']['name'];
            echo $fileName;
            $product['image'] = $fileName;
            $u->doUpload($_FILES['image']);
        } else {
            echo "No file selected";
        }

        $sql_edit = "SELECT product_name FROM product WHERE id != $id";
        $result_edit = $f->getAll($sql_edit);
        foreach($result_edit as $e)
        {
            if($e['product_name'] == $product_name)
            {
                $message = $product_name. "Da ton tai";
                $f->message($message);
                exit();
            }
        }
        
        $f->editRecord("product", $id, $product);
        header("Location:" .PATH_ADMIN. "page=productlist");
        exit();
    }