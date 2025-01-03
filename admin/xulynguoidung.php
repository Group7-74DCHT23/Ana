<?php
require ('connect.php');

// Thêm người dùng
if (isset($_POST['insert'])) {
    // Lấy dữ liệu từ form
    $username = $_POST['username'];
    $password = $_POST['password'];  
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    // Kiểm tra xem email đã tồn tại trong cơ sở dữ liệu chưa
    $checkEmail = "SELECT * FROM nguoidung WHERE email = '$email'";
    $result = $conn->query($checkEmail);

    if ($result->num_rows > 0) {
        // Nếu email đã tồn tại, thông báo lỗi
        echo "<script>alert('Lỗi: Email này đã tồn tại.');</script>";
    } else {
        // Thực hiện câu lệnh SQL để thêm người dùng vào cơ sở dữ liệu
        $sql = "INSERT INTO nguoidung (username, password, fullname, email, phone, address) 
                VALUES ('$username', '$password', '$fullname', '$email', '$phone', '$address')";

        if ($conn->query($sql) === TRUE) {
            echo "<script>
                alert('Thêm người dùng thành công!');
                window.location.href = 'xulynguoidung.php';  // Điều hướng về trang quản lý người dùng
            </script>";
        } else {
            echo "<script>alert('Lỗi: Không thể thêm người dùng');</script>";
        }
    }
}

// Xử lý xóa người dùng
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM nguoidung WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        echo "<script>
        alert('Xóa người dùng thành công!');
        window.location.href = 'xulynguoidung.php';
   </script>";
    } else {
        echo "<script>alert('Lỗi: Không thể xóa người dùng');</script>";
    }
}

// Xử lý cập nhật người dùng
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $username = $_POST['username'];
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    $sql = "UPDATE nguoidung SET 
            username = '$username', fullname = '$fullname', email = '$email',
            phone = '$phone', address = '$address' 
            WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        echo "<script>
        alert('Cập nhật người dùng thành công!');
        window.location.href = 'xulynguoidung.php';
        </script>";
    } else {
        echo "<script>alert('Lỗi: Không thể cập nhật người dùng');</script>";
    }
}

// Xử lý tìm kiếm
$search = $_GET['search'] ?? '';
$sql = "SELECT * FROM nguoidung WHERE username LIKE '%$search%' OR fullname LIKE '%$search%'";
$result = $conn->query($sql);

// Số lượng người dùng hiển thị trên mỗi trang
$limit = 5; 
// Lấy số trang hiện tại từ URL (mặc định là 1)
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
// Tính vị trí bắt đầu
$start = ($page - 1) * $limit;
// Lấy tổng số bản ghi
$total_result = $conn->query("SELECT COUNT(*) AS total FROM nguoidung WHERE username LIKE '%$search%' OR fullname LIKE '%$search%'");
$total = $total_result->fetch_assoc()['total'];
// Tính tổng số trang
$total_pages = ceil($total / $limit);
// Lấy dữ liệu cho trang hiện tại
$sql = "SELECT * FROM nguoidung 
        WHERE username LIKE '%$search%' OR fullname LIKE '%$search%' 
        LIMIT $start, $limit";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Quản lý người dùng</title>
</head>
<body>
<div class="sidebar">
    <h1>ADMIN</h1>
    <ul>
        <li><a href="index.php"><i class='bx bx-menu'></i><span>Trang chủ</span></a></li>
        <li><a href="xulydonhang.php"><i class='bx bx-spreadsheet'></i><span>Quản lý đơn hàng</span></a></li>
        <li><a href="xulysanpham.php"><i class='bx bx-category-alt'></i><span>Quản lý sản phẩm</span></a></li>
        <li><a href="xulynguoidung.php"><i class="bx bxs-user"></i><span>Quản lý người dùng</span></a></li>
    </ul>
</div>

<div class="main-content">
    <div class="container">
        <img src="https://ananas.vn/wp-content/themes/ananas/fe-assets/images/svg/ananas_logo.svg" alt="logo">
        <h3>MỌI NGƯỜI THƯỜNG GỌI CHÚNG TÔI LÀ DỨA !</h3>   
     </div>
</div>

<div class="main-content">
    <div class="quanlynguoidung">
        <h1 class="mb-5 mt-2 text-center">QUẢN LÝ NGƯỜI DÙNG</h1>
        <div class="d-flex justify-content-center">
            <form method="GET" class="d-flex justify-content-between w-75 mb-3">
                <input type="text" name="search" class="form-control me-2 w-75" placeholder="Nhập tên đăng nhập hoặc họ và tên để tìm kiếm..." value="<?= htmlspecialchars($search) ?>">
                <button type="submit" class="btn btn-secondary w-25">
                    <i class="bi bi-search"></i> Tìm kiếm
                </button>
            </form>
        </div>
        <div class="d-flex justify-content-between mb-3">
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addUserModal">
                <i class="bi bi-person-plus"></i> Thêm người dùng
            </button>
            <div class="pagination">
    <nav>
        <ul class="pagination justify-content-center">
            <?php if ($page > 1): ?>
                <li class="page-item">
                    <a class="page-link" href="?search=<?= htmlspecialchars($search) ?>&page=<?= $page - 1 ?>">Trang trước</a>
                </li>
            <?php endif; ?>
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                    <a class="page-link" href="?search=<?= htmlspecialchars($search) ?>&page=<?= $i ?>"><?= $i ?></a>
                </li>
            <?php endfor; ?>
            <?php if ($page < $total_pages): ?>
                <li class="page-item">
                    <a class="page-link" href="?search=<?= htmlspecialchars($search) ?>&page=<?= $page + 1 ?>">Trang sau</a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
</div>

        </div>
    

        <!-- Bảng Người Dùng -->
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Tên đăng nhập</th>
                    <th>Họ và tên</th>
                    <th>Email</th>
                    <th>Số điện thoại</th>
                    <th>Địa chỉ</th>
                    <th>Hành động</th>
                </tr>
            </thead>
        
    <tbody>
    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()):
    ?>
       <tr>
                <td><?= $row['id'] ?></td>
                <td><?= $row['username'] ?></td>
                <td><?= $row['fullname'] ?></td>
                <td><?= $row['email'] ?></td>
                <td><?= $row['phone'] ?></td>
                <td><?= $row['address'] ?></td>
                <td>
                    <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editUserModal<?= $row['id'] ?>"><i class='bi bi-pencil'></i> Sửa</button>
                    <a href="?delete=<?= $row['id'] ?>" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa không?')">
                        <i class="bi bi-trash"></i> Xóa
                    </a>
                </td>
            </tr>

            <!-- Modal Sửa Người Dùng -->
            <div class="modal fade" id="editUserModal<?= $row['id'] ?>" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form method="POST">
                            <div class="modal-header">
                                <h5 class="modal-title">Sửa Người Dùng</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                <div class="mb-3">
                                    <label for="username" class="form-label">Tên đăng nhập</label>
                                    <input type="text" name="username" class="form-control" value="<?= $row['username'] ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="fullname" class="form-label">Họ và tên</label>
                                    <input type="text" name="fullname" class="form-control" value="<?= $row['fullname'] ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control" value="<?= $row['email'] ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Số điện thoại</label>
                                    <input type="text" name="phone" class="form-control" value="<?= $row['phone'] ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="address" class="form-label">Địa chỉ</label>
                                    <input type="text" name="address" class="form-control" value="<?= $row['address'] ?>" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" name="update" class="btn btn-primary">Lưu</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                            </div>
                        </form>
                    </div>
                </div>
    <?php
        endwhile;
    } else {
        echo "<script type='text/javascript'>
                alert('Không tìm thấy người dùng');
                window.location.href = 'xulynguoidung.php';  // Quay lại trang chủ
            </script>";
    }
    ?>
    </tbody>

    </table>
</div>

<!-- Modal Thêm Người Dùng -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST">
                <div class="modal-header">
                    <h5 class="modal-title">Thêm Người Dùng</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="username" class="form-label">Tên đăng nhập</label>
                        <input type="text" name="username" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Mật khẩu</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="fullname" class="form-label">Họ và tên</label>
                        <input type="text" name="fullname" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Số điện thoại</label>
                        <input type="text" name="phone" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Địa chỉ</label>
                        <input type="text" name="address" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="insert" class="btn btn-primary">Thêm</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
