<?php
require_once ('../lib/db.php'); // Kết nối database
require_once ('../lib/paginator.php'); // Chỉ tải 1 lần

$database = new Database();
$conn = $database->conn;

// Đếm tổng số bản ghi trong bảng user
$sql_count = "SELECT COUNT(*) AS total FROM user";
$result_count = $conn->query($sql_count);

if (!$result_count) {
    die("Count query failed: " . $conn->error);
}

$row = $result_count->fetch_assoc();
$total_users = $row['total'];

// Tạo đối tượng Paginator
$paginator = new Paginator([
    'base_url' => 'dashboard.php', // Thay bằng URL file hiện tại
    'total_rows' => $total_users,
    'per_page' => 5,
    'cur_page' => isset($_GET['currentPage']) ? (int)$_GET['currentPage'] : 1,
]);

// Tạo các đường dẫn phân trang
$pagination_links = $paginator->createLinks();

// Xác định offset
$offset = ($paginator->cur_page - 1) * $paginator->per_page;

// Lấy danh sách người dùng
$sql = "SELECT * FROM user LIMIT $offset, {$paginator->per_page}";
$result = $conn->query($sql);

if (!$result) {
    die("Query failed: " . $conn->error);
}
?>
<style>
    /* Kiểu dáng chung */
body {
    font-family: Arial, sans-serif;
    margin: 20px;
    padding: 0;
    background-color: #f9f9f9;
}

/* Tiêu đề */
h1 {
    color: #333;
    text-align: center;
    margin-bottom: 20px;
}

/* Bảng hiển thị dữ liệu */
table {
    width: 80%;
    margin: 0 auto 20px auto;
    border-collapse: collapse;
    background-color: #fff;
    border: 1px solid #ddd;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

thead tr {
    background-color: #007bff;
    color: #fff;
    text-align: left;
}

thead th {
    padding: 10px;
    font-weight: bold;
    text-transform: uppercase;
}

tbody tr:nth-child(even) {
    background-color: #f2f2f2;
}

tbody tr:hover {
    background-color: #e9ecef;
}

tbody td {
    padding: 10px;
    border-bottom: 1px solid #ddd;
    text-align: center;
}

/* Phân trang */
.pagination {
    display: flex;
    justify-content: center;
    list-style: none;
    padding: 0;
    margin: 20px 0;
}

.pagination li {
    margin: 0 5px;
}

.pagination a {
    display: block;
    padding: 8px 12px;
    text-decoration: none;
    color: #007bff;
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 4px;
    transition: all 0.3s ease;
}

.pagination a:hover {
    background-color: #007bff;
    color: #fff;
}

.pagination .disabled {
    pointer-events: none;
    opacity: 0.6;
}

.pagination .active {
    background-color: #007bff;
    color: #fff;
    border-color: #007bff;
    pointer-events: none;
}

</style>

    <h1>QUẢN LÝ TÀI KHOẢN</h1>
    <table border="1" cellpadding="10" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . $row['name'] . "</td>";
                echo "<td>" . $row['email'] . "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
    <div>
        <?php echo $pagination_links; ?>
    </div>
</body>
</html>
