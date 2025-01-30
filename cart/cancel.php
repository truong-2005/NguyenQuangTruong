<?php
    unset($_SESSION['cart']);
    unset($_SESSION['amount']);
    unset($_SESSION['number_of_item']);
    header('Location: index.php?page=product');

?>