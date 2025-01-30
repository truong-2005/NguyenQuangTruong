<?php
    $id = $_GET['id'];
    $k=array_search($id,$_SESSION['cart']);
    array_splice($_SESSION['cart'],$k,1);
    $_SESSION['number_of_item']--;
    header('location: index.php?page=cart');
?>