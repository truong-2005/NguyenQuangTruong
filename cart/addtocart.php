<?php
if(!isset($_SESSION['cart']))
{
    $_SESSION['cart'] = array();
    $_SESSION['amount'] = array(); // so luong tung id tung san pham 
    $_SESSION['number_of_item'] = 0; // so luong sp trong gio hang
    $_SESSION['price'] = array(); // giá của từng sản phẩm
}
$id = $_GET['id'];
$price = $_GET['price']; // lấy giá sản phẩm từ request
$discount = $_GET['discount']; // lấy giảm giá từ request

$k = array_search($id, $_SESSION['cart']);
if($k === false)
{
    array_push($_SESSION['cart'], $id);
    array_push($_SESSION['amount'], 1);
    $_SESSION['number_of_item']++;
    if ($discount > 0) {
        array_push($_SESSION['price'], $price - ($price * $discount / 100));
    } else {
        array_push($_SESSION['price'], $price);
    }
}
else
{
    $_SESSION['amount'][$k]++;
}
print_r($_SESSION['cart']);
print_r($_SESSION['amount']);
print_r($_SESSION['price']);
// print_r($_SESSION['number_of_item']);

// echo $id;
header("Location: index.php");
?>