<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<?php
    require('../lib/paginator.php');
    $p = new paginator;
    if(!isset($_GET['currentPage'])){
        $page = 1;
    } else {
        $page = $_GET['currentPage'];
    }

    $limit = 5;
    $sql_all = " SELECT * FROM product WHERE trash = 0";
    $result_all = $f->getAll($sql_all);
    $config = array (
        'base_url' => PATH_ADMIN."page=productList",
        'total_rows' => count($result_all),
        'per_page' => $limit,
        'cur_page' => $page
    );
    $p->init($config);
    $sql = "SELECT * FROM product WHERE trash = 0 ORDER BY id DESC LIMIT " . (($page - 1) * $limit) . ", " . $limit;
    
    $result = $f->getAll($sql);
?>
<div style="margin-bottom: 20px;">
    <div><a href="<?= PATH_ADMIN ?>page=productAdd"><button type="button" class="btn btn-primary">Thêm</button></a></div>
    <!-- <div><a href="<?= PATH_ADMIN ?>page=productDel"><button type="button" class="btn btn-primary">Xoa</button></a></div> -->
</div>

<table class="table table-bordered">
    <tr>
        <th>ID</th>
        <th>Hình ảnh</th>
        <th>Tên sản phẩm</th>
        <th>Danh mục</th>
        <th>Giá</th>
        <th>Giá khuyến mãi</th>
        <th>Sửa</th>
        <th>Xóa</th>
    </tr>
<?php
    $i = 1;
    foreach($result as $value):
?>

<tr>
    <td><?= $value['id'] ?></td>
    <td>
        <!-- Display image -->
        <img src="../asset/images/<?= $value['image'] ?>" alt="<?= $value['product_name'] ?>" width="100" height="100">
    </td>
    <td><?= $value['product_name'] ?></td>
    <td><?= $value['cat_id'] ?></td>
    <td><?= $value['price'] ?></td>
    <td><?= $value['sale_price'] ?></td>

    <td><a href="<?= PATH_ADMIN ?>page=productEdit&catId<?= $value['id'] ?>"><i class="fa fa-edit"></i></a></td>   
    <td><a href="<?= PATH_ADMIN ?>page=productDel&catId<?= $value['id'] ?>"><i class="fa fa-trash"></i></a></td>
</tr>

<?php 
    $i++;
endforeach;
?>
</table>
<p><?= $p->createLinks()?></p>