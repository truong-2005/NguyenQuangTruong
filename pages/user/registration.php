<?php
// define variables and set to empty values
$nameErr = $emailErr = $genderErr = $addErr = $phoneErr = $userErr = $passErr = $birthErr = "";
$name = $email = $gender = $add = $phone = $username = $pass = $birth = "";
$flag = 0;

try {
    // Kết nối cơ sở dữ liệu
    $conn = new PDO("mysql:host=localhost;dbname=nguyenquangtruong_2123110098", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Lỗi kết nối cơ sở dữ liệu: " . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    // Kiểm tra name
    if (empty($_POST["name"])) {
        $nameErr = "Name is required";
    } else {
        $name = test_input($_POST["name"]);
        $flag = 1;
        if (!preg_match("/^[a-zA-Z-' ]*$/", $name)) {
            $nameErr = "Only letters and white space allowed";
            $flag = 0;
        }
    }

    // Kiểm tra gender
    if (empty($_POST["gender"])) {
        $genderErr = "Gender is required";
        $flag = 0;
    } else {
        $gender = test_input($_POST["gender"]);
        $flag = 1;
    }

    // Kiểm tra email
    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
        $flag = 0;
    } else {
        $email = test_input($_POST["email"]);
        $flag = 1;
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
            $flag = 0;
        } else {
            // Kiểm tra email trùng
            $sql = "SELECT * FROM user WHERE email = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$email]);
            if ($stmt->fetch()) {
                $emailErr = "Email đã được sử dụng";
                $flag = 0;
            }
        }
    }

    // Kiểm tra birthday
    if (empty($_POST["birthday"])) {
        $birthErr = "Birthday is required";
        $flag = 0;
    } else {
        $birth = test_input($_POST["birthday"]);
        $flag = 1;
    }

    // Kiểm tra số điện thoại
    if (empty($_POST["phone"])) {
        $phoneErr = "Phone is required";
        $flag = 0;
    } else {
        $phone = test_input($_POST["phone"]);
        $flag = 1;
        if (!preg_match("/^\d{10}$/", $phone)) {
            $phoneErr = "Số điện thoại phải có 10 số và chỉ bao gồm chữ số";
            $flag = 0;
        } else {
            // Kiểm tra số điện thoại trùng
            $sql = "SELECT * FROM user WHERE phone = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$phone]);
            if ($stmt->fetch()) {
                $phoneErr = "Số điện thoại đã được sử dụng";
                $flag = 0;
            }
        }
    }

    // Kiểm tra địa chỉ
    if (empty($_POST["add"])) {
        $addErr = "Address is required";
        $flag = 0;
    } else {
        $add = test_input($_POST["add"]);
        $flag = 1;
    }

    // Kiểm tra username
    if (empty($_POST["username"])) {
        $userErr = "Username is required";
        $flag = 0;
    } else {
        $username = test_input($_POST["username"]);
        $flag = 1;
        // Kiểm tra username trùng
        $sql = "SELECT * FROM user WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$username]);
        if ($stmt->fetch()) {
            $userErr = "Tên đăng nhập đã được sử dụng";
            $flag = 0;
        }
    }

    // Kiểm tra password
    if (empty($_POST["pswd"])) {
        $passErr = "Password is required";
        $flag = 0;
    } else {
        $pass = sha1(test_input($_POST["pswd"]));
        $flag = 1;
    }

    if ($flag == 1) {
        // Xử lý ảnh đại diện (nếu có)
        $i = "temp.png";
        if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
            require("lib/file.php");
            $file = $_FILES['image'];
            $i = $file['name'];
            $u = new Upload();
            $u->doUpload($file);
        }

        // Lưu thông tin người dùng vào cơ sở dữ liệu
        $sql = "INSERT INTO user (username, password, name, email, phone, birthday, address, gender, avatar) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            $username, $pass, $name, $email, $phone, $birth, $add, $gender, $i
        ]);
        if ($flag == 1) {
          try {
              // Kiểm tra dữ liệu trùng trước khi chèn
              $checkSQL = "SELECT * FROM user WHERE email = ? OR phone = ? OR username = ?";
              $stmt = $conn->prepare($checkSQL);
              $stmt->execute([$email, $phone, $username]);
              $existingUser = $stmt->fetch();
      
              if ($existingUser) {
                  // Xử lý lỗi nếu dữ liệu đã tồn tại
                  if ($existingUser['email'] === $email) {
                      $emailErr = "Email đã được sử dụng";
                  }
                  if ($existingUser['phone'] === $phone) {
                      $phoneErr = "Số điện thoại đã được sử dụng";
                  }
                  if ($existingUser['username'] === $username) {
                      $userErr = "Tên đăng nhập đã được sử dụng";
                  }
                  $flag = 0; // Ngăn chặn việc chèn thêm
              }
      
              if ($flag == 1) {
                  // Xử lý ảnh đại diện (nếu có)
                  $i = "temp.png";
                  if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
                      require("lib/file.php");
                      $file = $_FILES['image'];
                      $i = $file['name'];
                      $u = new Upload();
                      $u->doUpload($file);
                  }
      
                  // Thêm bản ghi mới
                  $sql = "INSERT INTO user (username, password, name, email, phone, birthday, address, gender, avatar) 
                          VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
                  $stmt = $conn->prepare($sql);
                  $stmt->execute([
                      $username, $pass, $name, $email, $phone, $birth, $add, $gender, $i
                  ]);
                  echo "Đăng ký thành công!";
              }
          } catch (PDOException $e) {
              echo "Lỗi: " . $e->getMessage();
          }
      }
      
    }
}
?>


<?php
// Đoạn mã PHP xử lý dữ liệu vẫn giữ nguyên như bạn đã cung cấp
?>

<!-- Biểu mẫu đăng ký -->
<div class="container my-5">
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>?page=registration" method="post" enctype="multipart/form-data" class="p-5 shadow rounded bg-white">
    <h1 class="text-center text-primary mb-4">ĐĂNG KÝ THÀNH VIÊN</h1>
    <p class="text-center text-muted mb-4">Hãy điền đầy đủ thông tin bên dưới để trở thành thành viên của chúng tôi.</p>

    <!-- Họ tên -->
    <div class="mb-4">
      <label for="name" class="form-label"><i class="bi bi-person-fill me-2"></i>Họ tên</label>
      <input type="text" class="form-control" id="name" placeholder="Nhập tên của bạn" name="name" value="<?= $name ?>">
      <span class="error text-danger"><?= $nameErr ?></span>
    </div>

    <!-- Giới tính -->
    <div class="mb-4">
      <label class="form-label"><i class="bi bi-gender-ambiguous me-2"></i>Giới tính:</label><br>
      <div class="form-check form-check-inline">
        <input type="radio" class="form-check-input" id="male" name="gender" value="1" <?= isset($gender) && $gender == 1 ? 'checked' : '' ?>>
        <label class="form-check-label" for="male">Nam</label>
      </div>
      <div class="form-check form-check-inline">
        <input type="radio" class="form-check-input" id="female" name="gender" value="0" <?= isset($gender) && $gender == 0 ? 'checked' : '' ?>>
        <label class="form-check-label" for="female">Nữ</label>
      </div>
      <span class="error text-danger"><?= $genderErr ?></span>
    </div>

    <!-- Ngày sinh -->
    <div class="mb-4">
      <label for="birthday" class="form-label"><i class="bi bi-calendar-event-fill me-2"></i>Ngày sinh</label>
      <input type="date" class="form-control" id="birthday" name="birthday" value="<?= $birth ?>">
      <span class="error text-danger"><?= $birthErr ?></span>
    </div>

    <!-- Điện thoại -->
    <div class="mb-4">
      <label for="phone" class="form-label"><i class="bi bi-telephone-fill me-2"></i>Điện thoại</label>
      <input type="text" class="form-control" id="phone" placeholder="Nhập số điện thoại" name="phone" value="<?= $phone ?>">
      <span class="error text-danger"><?= $phoneErr ?></span>
    </div>

    <!-- Email -->
    <div class="mb-4">
      <label for="email" class="form-label"><i class="bi bi-envelope-fill me-2"></i>Email</label>
      <input type="email" class="form-control" id="email" placeholder="Nhập Email của bạn" name="email" value="<?= $email ?>">
      <span class="error text-danger"><?= $emailErr ?></span>
    </div>

    <!-- Địa chỉ -->
    <div class="mb-4">
      <label for="address" class="form-label"><i class="bi bi-geo-alt-fill me-2"></i>Địa chỉ</label>
      <input type="text" class="form-control" id="address" placeholder="Nhập địa chỉ của bạn" name="add" value="<?= $add ?>">
      <span class="error text-danger"><?= $addErr ?></span>
    </div>

    <!-- Ảnh đại diện -->
    <div class="mb-4">
      <label for="image" class="form-label"><i class="bi bi-image-fill me-2"></i>Ảnh đại diện</label>
      <input type="file" class="form-control" id="image" name="image">
    </div>

    <!-- Tên đăng nhập -->
    <div class="mb-4">
      <label for="username" class="form-label"><i class="bi bi-person-badge-fill me-2"></i>Tên đăng nhập</label>
      <input type="text" class="form-control" id="username" placeholder="Nhập tên đăng nhập" name="username" value="<?= $username ?>">
      <span class="error text-danger"><?= $userErr ?></span>
    </div>

    <!-- Mật khẩu -->
    <div class="mb-4">
      <label for="pwd" class="form-label"><i class="bi bi-lock-fill me-2"></i>Mật khẩu</label>
      <input type="password" class="form-control" id="pwd" placeholder="Nhập mật khẩu" name="pswd">
      <span class="error text-danger"><?= $passErr ?></span>
    </div>

    <!-- Nút Đăng ký -->
    <div class="text-center">
      <button type="submit" class="btn btn-primary btn-lg px-5">Đăng Ký</button>
    </div>
  </form>
</div>
