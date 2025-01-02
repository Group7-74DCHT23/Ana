<?php
require('connect.php');

// Thêm hóa đơn
if (isset($_POST['add'])) {
    $id_bill = $_POST['id_bill'];
    $fullname = $_POST['fullname'];
    $product_name = $_POST['product_name'];
    $total_bill = intval($_POST['total_bill']);
    $quantity = $_POST['quantity'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $date_order = $_POST['date_order'];
    $status = $_POST['status'];

    $sql = "INSERT INTO `hoadon` (`id_bill`, `fullname`, `product_name`, `total_bill`, `quantity`, `phone`, `address`, `date_order`, `status`) 
            VALUES ('$id_bill', '$fullname', '$product_name', '$total_bill', '$quantity', '$phone', '$address', '$date_order', '$status')";
    if ($conn->query($sql) === TRUE) {
        $message = "Thêm hóa đơn thành công";
        echo "<script type='text/javascript'>alert('$message');</script>";
    } else {
        echo "<script>alert('Thêm hóa đơn thất bại');</script>";
    }
}

// Xử lý sửa hóa đơn
$order_to_edit = null;
if (isset($_GET['id']) && isset($_GET['action']) && $_GET['action'] == 'edit') {
    $id = intval($_GET['id']); // Kiểm tra id hợp lệ
    $sql = "SELECT * FROM hoadon WHERE id=$id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $order_to_edit = $result->fetch_assoc();
    } else {
        echo "<script>alert('Hóa đơn không tồn tại'); window.location.href='xulydonhang.php';</script>";
        exit;
    }
}

// Xử lý cập nhật hóa đơn
if (isset($_POST['update'])) {
    $id = intval($_POST['id']);
    $id_bill = $_POST['id_bill'];
    $fullname = $_POST['fullname'];
    $product_name = $_POST['product_name'];
    $total_bill = intval($_POST['total_bill']);
    $quantity = intval($_POST['quantity']);
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $date_order = $_POST['date_order'];
    $status = $_POST['status'];

    // Cập nhật hóa đơn trong CSDL
    $sql = "UPDATE hoadon SET 
            id_bill='$id_bill', 
            fullname='$fullname', 
            product_name='$product_name', 
            total_bill='$total_bill', 
            quantity='$quantity', 
            phone='$phone', 
            address='$address', 
            date_order='$date_order', 
            status='$status' 
            WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Sửa hóa đơn thành công'); window.location.href='xulydonhang.php';</script>";
    } else {
        echo "<script>alert('Sửa hóa đơn thất bại');</script>";
    }
}

// Xử lý xóa hóa đơn
if (isset($_GET['action']) && $_GET['action'] == 'delete') {
    $id = (int) $_GET['id'];

    $sql = "DELETE FROM hoadon WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Xóa hóa đơn thành công'); window.location.href='xulydonhang.php';</script>";
    } else {
        echo "<script>alert('Xóa hóa đơn thất bại');</script>";
    }
}

// Tìm kiếm hóa đơn
$search = '';
if (isset($_GET['search'])) {
    $search = $_GET['search'];
}
$sql = "SELECT * FROM hoadon WHERE id_bill LIKE '%$search%' OR fullname LIKE '%$search%'";
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
    <title>Quản lý đơn hàng</title>
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
        <h1 class="mb-5 mt-2 text-center">QUẢN LÝ ĐƠN HÀNG</h1>

        <div class="d-flex justify-content-between mb-3">
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addOrderModal">
                <i class="bi bi-person-plus"></i> Thêm đơn hàng
            </button>

            <form method="GET" class="d-flex w-75 ms-3">
                <input type="text" name="search" class="form-control me-2 w-75" placeholder="Nhập mã hóa đơn hoặc tên khách hàng để tìm kiếm..." value="<?= htmlspecialchars($search) ?>">
                <button type="submit" class="btn btn-secondary w-25">
                    <i class="bi bi-search"></i> Tìm kiếm
                </button>
            </form>
        </div>

        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>STT</th>
                    <th>Mã hóa đơn</th>
                    <th>Tên khách hàng</th>
                    <th>Tên sản phẩm</th>
                    <th>Số lượng sản phẩm</th>
                    <th>Tổng số tiền</th>
                    <th>SĐT</th>
                    <th>Địa chỉ</th>
                    <th>Ngày đặt hàng</th>
                    <th>Tình trạng hóa đơn</th>
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
        <td><?= htmlspecialchars($row['id_bill']) ?></td>
        <td><?= htmlspecialchars($row['fullname']) ?></td>
        <td><?= htmlspecialchars($row['product_name']) ?></td>
        <td><?= $row['quantity'] ?></td>
        <td><?= $row['total_bill'] ?></td>
        <td><?= htmlspecialchars($row['phone']) ?></td>
        <td><?= htmlspecialchars($row['address']) ?></td>
        <td><?= $row['date_order'] ?></td>
        <td>
            <?php
            $status_text = ['Đang chờ duyệt', 'Đang vận chuyển', 'Hoàn thành', 'Hủy đơn'];
            echo $status_text[$row['status']];
            ?>
        </td>
        <td>
            <button class="btn btn-warning mb-1" data-bs-toggle="modal" data-bs-target="#editOrderModal<?= $row['id'] ?>"><i class='bi bi-pencil'></i> Sửa</button>
            <a href="?action=delete&id=<?= $row['id'] ?>" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa không?')">
                <i class="bi bi-trash"></i> Xóa
            </a>
        </td>
    </tr>

    <!-- Modal sửa hóa đơn -->
    <div class="modal fade" id="editOrderModal<?= $row['id'] ?>" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title">Sửa hóa đơn</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                        <div class="mb-3">
                            <label>Mã hóa đơn</label>
                            <input type="text" name="id_bill" class="form-control" value="<?= htmlspecialchars($row['id_bill']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label>Họ tên</label>
                            <input type="text" name="fullname" class="form-control" value="<?= htmlspecialchars($row['fullname']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label>Tên sản phẩm</label>
                            <input type="text" name="product_name" class="form-control" value="<?= htmlspecialchars($row['product_name']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label>Tổng tiền</label>
                            <input type="number" name="total_bill" class="form-control" value="<?= $row['total_bill'] ?>" required>
                        </div>
                        <div class="mb-3">
                            <label>Số lượng</label>
                            <input type="number" name="quantity" class="form-control" value="<?= $row['quantity'] ?>" required>
                        </div>
                        <div class="mb-3">
                            <label>SĐT</label>
                            <input type="text" name="phone" class="form-control" value="<?= htmlspecialchars($row['phone']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label>Địa chỉ</label>
                            <input type="text" name="address" class="form-control" value="<?= htmlspecialchars($row['address']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label>Ngày đặt</label>
                            <input type="date" name="date_order" class="form-control" value="<?= $row['date_order'] ?>" required>
                        </div>
                        <div class="mb-3">
                            <label>Tình trạng</label>
                            <select name="status" class="form-control">
                                <option value="0" <?= $row['status'] == 0 ? 'selected' : '' ?>>Đang chờ duyệt</option>
                                <option value="1" <?= $row['status'] == 1 ? 'selected' : '' ?>>Đang vận chuyển</option>
                                <option value="2" <?= $row['status'] == 2 ? 'selected' : '' ?>>Hoàn thành</option>
                                <option value="3" <?= $row['status'] == 3 ? 'selected' : '' ?>>Hủy đơn</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" name="update" class="btn btn-primary">Cập nhật</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

        <?php
            endwhile;
        } else {
            echo "<script type='text/javascript'>
                    alert('Không tìm thấy đơn hàng nào');
                    window.location.href = 'xulydonhang.php';  // Quay lại trang chủ
                </script>";
        }
        ?>
    </tbody>
        <!-- Modal thêm hóa đơn -->
        <div class="modal fade" id="addOrderModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="POST">
                        <div class="modal-header">
                            <h5 class="modal-title">Thêm hóa đơn</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label>Mã hóa đơn</label>
                                <input type="text" name="id_bill" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label>Họ tên</label>
                                <input type="text" name="fullname" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label>Tên sản phẩm</label>
                                <input type="text" name="product_name" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label>Tổng tiền</label>
                                <input type="number" name="total_bill" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label>Số lượng</label>
                                <input type="number" name="quantity" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label>SĐT</label>
                                <input type="text" name="phone" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label>Địa chỉ</label>
                                <input type="text" name="address" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label>Ngày đặt</label>
                                <input type="date" name="date_order" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label>Tình trạng</label>
                                <select name="status" class="form-control">
                                    <option value="0">Đang chờ duyệt</option>
                                    <option value="1">Đang vận chuyển</option>
                                    <option value="2">Hoàn thành</option>
                                    <option value="3">Hủy đơn</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                            <button type="submit" name="add" class="btn btn-primary">Thêm</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
