<?php
    session_start();
    require('../lib/coreFunction.php');
    $f = new coreFunction();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $username = $_POST['username'];
        $password = sha1($_POST['password']);
        $sql = "SELECT * FROM user WHERE username='" . $username . "' AND password='" . $password . "' AND role='admin'";
        $result = $f->getOne($sql);

        if (!is_null($result)) {
            $_SESSION['admin'] = $result['username'];
            header("Location: index.php");
        } else {
            echo "<script>alert('Sai username hoặc password')</script>";
            header("Location: login.php");
        }
    }
?>