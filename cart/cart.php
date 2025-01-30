<div class="container mt-3">
    <?php
        if(!isset($_SESSION['user'])) {
            echo"<p>Đăng nhập để xem giỏ hàng</p>";
            exit();
        }
        if(!isset($_SESSION['cart']) || $_SESSION['number_of_item'] ==0) {
                    echo"<p>Chưa có sản phẩm trong giỏ hàng</p>";
                }
                else {
                ?>
    <h1 class="text-center mb-5 font">Giỏ hàng</h1>
    <div class="col-md-12 cart">
        <form action="<?= PATH?>page=cart" method="post">
            <table class="table table-hover table-bordered">
                <thead>
                    <tr>
                        <th>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="check1" name="option1"
                                    value="something" checked>
                                <label class="form-check-label"></label>
                            </div>
                        </th>
                        <th>Hình ảnh</th>
                        <th>Tên sản phẩm</th>
                        <th>Đơn giá</th>
                        <th>Số lượng</th>
                        <th>Thành tiền</th>
                        <th>Hành động</th>
                        <th>ID</th>
                    </tr>
                </thead>
                <?php 
                $cart=$_SESSION ['cart'];
                $a=$_SESSION['amount'];
                $n=count($cart);
                $cartProduct=[];
                
                for($i=0;$i<$n;$i++){
                $id=$cart[$i];
                $sql="SELECT * FROM product WHERE id = $id";
                $product=$f->getOne($sql);
                array_push($cartProduct,$product);
                }
                $s=0;
                $i=0;
                foreach ($cartProduct as $c) :
                    if($_SERVER['REQUEST_METHOD']=='POST') {
                        $q=$_POST['amount'.$i];
                        $_SESSION['amount'][$i]=$q;
                    }
                    else {
                        $q=$a[$i];
                    }
                    $price = ($c['sale_price'] > 0 && $c['sale_price'] < $c['price']) ? $c['sale_price'] : $c['price'];
                        ?>
                <tbody>
                    <tr>
                        <td>
                            <input type="checkbox">
                        </td>
                        <td><img src="asset/images/<?=$c['image']?>" style='width:50px'></td>
                        <td><?=$c['product_name']?></td>
                        <td><?=$price?></td>
                        <td>
                            <input class="text-center" type="number" name="amount<?= $i?>" value="<?=$q;?>" min="1" max="5"/>
                        </td>
                        <td><?= $price * $q ?></td>
                        <td>
                           <a href="<?=PATH?>page=delItemCart&id=<?=$c['id']?>"><button type='button' class='btn btn-danger rounded'>
                                <i class='fa-solid fa-trash-can'></i></button>
                            </a>
                        </td>
                        <td><?=$c['id']?></td>
                    </tr>
                </tbody>
                <?php
                    $s += $price * $q;
                    $i++;
                    endforeach;
                ?>
                <tfoot>
                    <tr>
                        <td colspan="5">Tổng cộng</td>
                        <td colspan="3"><?=$s;?></td>
                    </tr>
                </tfoot>
            </table>
            <div class="p-2 text-end">
                <p>
                    <button type="submit" class="btn btn-success">Cập nhật</button>
                    <a href="<?=PATH?>page=delCart"><button type="button" class="btn btn-success">Hủy giỏ hàng</button></a>
                    <a href="<?= PATH.'page=payCart&userId='.$_SESSION['userId']?>">
                    <button type="button" class="btn btn-success">Thannh toán</button>
                    </a>
                </p>
            </div>
        </form>
    </div>
    <?php
        }
    ?>
</div>