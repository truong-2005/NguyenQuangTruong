<?php
    $sql = "SELECT * FROM category WHERE trash=0";
    $result= $f->getAll($sql);
    
?>

<div style="margin-bottom: 20px;">
    <div><a href="<?=PATH_ADMIN?>page=catAdd"><button type="button" class="btn btn-primary">Thêm</button></a></div>

</div>

<table class="table table-bordered">
    <tr>
        <th>Id</th>
        <th>Tên danh mục </th>
        <th>Sửa</th>
        <th>Xóa</th>
    </tr>
    <?php
        foreach($result as $value):
    ?>
    <tr>
        <td><?= $value['id'] ?></td>
        <td><?= $value['category_name']?></td>
        <td><a href="<?= PATH_ADMIN?>page=catEdit&catId=<?= $value['id']?>"><img src="asset/images/edit.png" alt="" width="25px" height="25px"/></a></td>
        <td><a href="<?= PATH_ADMIN?>page=catDel&cattId=<?= $value['id']?>"><img src="asset/images/delete.png"alt="" width="25px" height="25px"/></a></td>
    </tr>
    
    <?php
        endforeach;
    ?>
</table>
