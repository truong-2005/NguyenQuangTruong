<?php
require('lib/file.php');
    $userId = $_GET['id'];


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $image = $_FILES['image'];
    $password = $_POST['password'];
    $a = array(

        'email' => $_POST['email'],
        'phone' => $_POST['phone'], // Sửa lại từ 'name' thành 'phone'
        'address' => $_POST['address'],
        'gender' => $_POST['gender'],
        'username' => $_POST['username'],
    );

    if ($image['size'] != 0) {
        $a['avatar'] = $image['name'];
        $u = new Upload;
        $u->doUpload($image);
    }

    if (!empty($password)) { // Sửa kiểm tra mật khẩu
        $a['password'] = sha1($password); // Sửa lại chính tả từ 'passworrd'
    }

    $f->editRecord("user", $userId, $a);
}

$sql = "SELECT * FROM user WHERE id='$userId' ";
$result = $f->getOne($sql);
?>

<div class="account-container">
    <div class="sidebar">
        <ul>
            <li class="active"><a href="#">Cập nhật tài khoản</a></li>
            <li><a href="#">Quản lý đơn hàng</a></li>
            <li><a href="#">Blog</a></li>
        </ul>
    </div>

    <div class="content">
        <h1 class="title">Cập nhật tài khoản</h1>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>?page=account&id=<?= $userId; ?>" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="fullname">Họ tên <span class="required">*</span></label>
                <input type="text" name="fullname" placeholder="Nguyễn Văn A" value="<?= isset($result['name']) ? htmlspecialchars($result['name']) : ''; ?>" required>
            </div>
            <div class="form-group">
                <label>Giới tính</label>
                <div class="gender-options">
                    <label><input type="radio" name="gender" value="1" <?php if(isset($result['gender']) && $result['gender'] == 1) echo "checked"; ?>> Nam</label>
                    <label><input type="radio" name="gender" value="0" <?php if(isset($result['gender']) && $result['gender'] == 0) echo "checked"; ?>> Nữ</label>
                </div>
            </div>
            <div class="form-group">
                <label for="phone">Điện thoại</label>
                <input type="text" name="phone" placeholder="Điện thoại" value="<?= isset($result['phone']) ? htmlspecialchars($result['phone']) : ''; ?>">
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" placeholder="an@gmail.com" value="<?= isset($result['email']) ? htmlspecialchars($result['email']) : ''; ?>">
            </div>
            <div class="form-group">
                <label for="address">Địa chỉ</label>
                <input type="text" name="address" placeholder="123 Nguyễn Trãi" value="<?= isset($result['address']) ? htmlspecialchars($result['address']) : ''; ?>">
            </div>
            <div class="form-group">
                <label for="avatar">Avatar</label>
                <?php if (isset($result['avatar']) && !empty($result['avatar'])): ?>
                    <div>
                        <img src="path/to/uploads/<?= htmlspecialchars($result['avatar']); ?>" alt="Avatar" style="width: 100px; height: 100px; border-radius: 50%;">
                    </div>
                <?php endif; ?>
                <input type="file" name="image">
            </div>
            <div class="form-group">
                <label for="username">Tên đăng nhập</label>
                <input type="text" name="username" placeholder="an" value="<?= isset($result['username']) ? htmlspecialchars($result['username']) : ''; ?>">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter password">
            </div>
            <button type="submit" class="btn-submit">Đăng Ký</button>
        </form>
    </div>
</div>