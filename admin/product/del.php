<?php
if (isset($_GET['product_name'])) {
    $product_name = $_GET['product_name'];

    // Kết nối đến cơ sở dữ liệu
    $conn = new mysqli("localhost", "root", "", "NguyenQuangTruong_2123110098");

    // Kiểm tra kết nối
    if ($conn->connect_error) {
        die("Kết nối thất bại: " . $conn->connect_error);
    }

    // Chuẩn bị câu lệnh SQL để xóa sản phẩm
    $sql = "DELETE FROM product WHERE product_name = ?";

    // Sử dụng prepared statement để bảo mật
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $product_name);

    // Thực thi câu lệnh
    if ($stmt->execute()) {
        echo "Sản phẩm đã được xóa thành công!";
    } else {
        echo "Lỗi khi xóa sản phẩm: " . $stmt->error;
    }

    // Đóng câu lệnh và kết nối
    $stmt->close();
    $conn->close();
} else {
    echo "Vui lòng cung cấp tên sản phẩm cần xóa.";
}
?>
