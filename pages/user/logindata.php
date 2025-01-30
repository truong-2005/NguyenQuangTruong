<?php
$username = $_POST['username'];
$password = $_POST['password'];
$sql = "SELECT * FROM user where username = '". $username."'and password = '" .sha1($password)."'";
$result = $f->getOne($sql);

if (!is_null($result)){
       $_SESSION['user'] = $result['username'];
       if (!is_null($result)) {
        $_SESSION['user'] = $result['username'];
        $_SESSION['userId'] = $result['id'];
    }
       if (isset($_POST['remember'])) {
        // Set cookies to remember the username and hashed password
        setcookie("user", $email, time() + 3600 * 24 * 30); // 30 days
        setcookie("pass", $pass, time() + 3600 * 24 * 30);  // 30 days
    } else {
        setcookie("user", '', time() - 3600); // Expire the cookie
        setcookie("pass", '', time() - 3600); // Expire the cookie
    }
    
    header("location:index.php");

}
else{
    echo "email hoặc password bị sai";
}

?>
