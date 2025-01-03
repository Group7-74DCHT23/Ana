<?php
require('connect.php');

// Thêm sản phẩm
$image_path = "";
if (isset($_POST['add'])) {
    $name = $_POST['name'];
    $price = intval($_POST['price']);
    $quantity = $_POST['quantity'];
    $size = $_POST['size'];
    $info = $_POST['info'];
    $upload_dir = 'images/';
    $upload_file = $upload_dir . basename($_FILES["img"]["name"]);
    $imageFileType = strtolower(pathinfo($upload_file, PATHINFO_EXTENSION));

    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
        $message = "Chỉ nhận tệp có định dạng JPG, JPEG, PNG";
        echo "<script type='text/javascript'>alert('$message');</script>";
    } else {
        if (move_uploaded_file($_FILES["img"]["tmp_name"], $upload_file)) {
            $sql = "INSERT INTO `sanpham` (`name`, `price`, `quantity`, `size`, `img`, `info`) 
                    VALUES ('$name', '$price', '$quantity', '$size', '$upload_file', '$info')";
            if ($conn->query($sql) === TRUE) {
                $image_path = $upload_file;
                $message = "Thêm sản phẩm thành công";
                echo "<script type='text/javascript'>alert('$message');</script>";
            }
        }
    }
}

// Xử lý sửa sản phẩm
$product_to_edit = null;
if (isset($_GET['id']) && isset($_GET['action']) && $_GET['action'] == 'edit') {
    $id = intval($_GET['id']);
    $sql = "SELECT * FROM sanpham WHERE id=$id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $product_to_edit = $result->fetch_assoc();
    } else {
        echo "<script>alert('Sản phẩm không tồn tại'); window.location.href='xulysanpham.php';</script>";
        exit;
    }
}

// Xử lý cập nhật sản phẩm
if (isset($_POST['update'])) {
    $id = intval($_POST['id']);
    $name = $_POST['name'];
    $price = intval($_POST['price']);
    $quantity = intval($_POST['quantity']);
    $size = $_POST['size'];
    $info = $_POST['info'];
    $upload_dir = 'images/';
    $upload_file = '';
    $imageFileType = '';

    if (!empty($_FILES["img"]["name"])) {
        $upload_file = $upload_dir . basename($_FILES["img"]["name"]);
        $imageFileType = strtolower(pathinfo($upload_file, PATHINFO_EXTENSION));

        if (!in_array($imageFileType, ['jpg', 'jpeg', 'png'])) {
            echo "<script>alert('Chỉ nhận tệp JPG, JPEG, PNG');</script>";
        } else {
            move_uploaded_file($_FILES["img"]["tmp_name"], $upload_file);
        }
    }

    $sql = !empty($upload_file)
        ? "UPDATE sanpham SET name='$name', price='$price', quantity='$quantity', size='$size', info='$info', img='$upload_file' WHERE id=$id"
        : "UPDATE sanpham SET name='$name', price='$price', quantity='$quantity', size='$size', info='$info' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Sửa sản phẩm thành công'); window.location.href='xulysanpham.php';</script>";
    } else {
        echo "<script>alert('Sửa sản phẩm thất bại');</script>";
    }
}

// Xử lý xóa số lượng sản phẩm
if (isset($_GET['action']) && $_GET['action'] == 'delete') {
    $id = (int) $_GET['id'];
    $quantity_to_delete = isset($_POST['quantity_to_delete']) ? intval($_POST['quantity_to_delete']) : 0;

    // Lấy thông tin sản phẩm
    $sql = "SELECT * FROM sanpham WHERE id=$id";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    if ($row) {
        $new_quantity = $row['quantity'] - $quantity_to_delete;
        if ($new_quantity < 0) $new_quantity = 0; // Đảm bảo số lượng không âm

        // Cập nhật lại số lượng sản phẩm
        $sql1 = "UPDATE sanpham SET quantity=$new_quantity WHERE id=$id";
        $kq = $conn->query($sql1);
        
        if ($kq) {
            echo "<script>alert('Cập nhật số lượng sản phẩm thành công'); window.location.href='xulysanpham.php';</script>";
        } else {
            echo "<script>alert('Cập nhật số lượng sản phẩm thất bại');</script>";
        }
    }
}
// Xử lý xóa sản phẩm hoàn toàn
if (isset($_GET['action']) && $_GET['action'] == 'delete_all') {
    $id = (int) $_GET['id'];

    // Lấy thông tin sản phẩm
    $sql = "SELECT * FROM sanpham WHERE id=$id";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    if ($row) {
        // Xóa ảnh nếu có
        if (file_exists($row['img'])) {
            unlink($row['img']);
        }

        // Xóa sản phẩm khỏi cơ sở dữ liệu
        $sql_delete = "DELETE FROM sanpham WHERE id=$id";
        if ($conn->query($sql_delete) === TRUE) {
            echo "<script>alert('Xóa sản phẩm thành công'); window.location.href='xulysanpham.php';</script>";
        } else {
            echo "<script>alert('Xóa sản phẩm thất bại');</script>";
        }
    }
}


// Tìm kiếm sản phẩm
$search = '';
if (isset($_GET['search'])) {
    $search = $_GET['search'];
}
$sql = "SELECT * FROM sanpham WHERE name LIKE '%$search%'";
$result = $conn->query($sql);

// Số lượng sản phẩm hiển thị trên mỗi trang
$limit = 10; 
// Lấy số trang hiện tại từ URL (mặc định là 1)
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
// Tính vị trí bắt đầu
$start = ($page - 1) * $limit;
// Lấy từ khóa tìm kiếm từ người dùng (nếu có)
$search = isset($_GET['search']) ? $_GET['search'] : '';
// Lấy tổng số bản ghi (sản phẩm) phù hợp với điều kiện tìm kiếm
$total_result = $conn->query("SELECT COUNT(*) AS total FROM sanpham WHERE id LIKE '%$search%'");
$total = $total_result->fetch_assoc()['total'];
// Tính tổng số trang
$total_pages = ceil($total / $limit);
// Lấy dữ liệu sản phẩm cho trang hiện tại
$sql = "SELECT * FROM sanpham 
        WHERE id LIKE '%$search%'
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
    <title>Quản lý sản phẩm</title>
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
    <div class="quanlysanpham">
        <h1 class="mb-5 mt-2 text-center">QUẢN LÝ SẢN PHẨM</h1>
        
        <div class="d-flex justify-content-center">
            <form method="GET" class="d-flex justify-content-between w-75 mb-3">
                <input type="text" name="search" class="form-control me-2 w-75" placeholder="Nhập tên sản phẩm để tìm kiếm..." value="<?= htmlspecialchars($search) ?>">
                <button type="submit" class="btn btn-secondary w-25">
                    <i class="bi bi-search"></i> Tìm kiếm
                </button>
            </form>
        </div>


        <div class="d-flex justify-content-between mb-3">
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addProductModal">
                <i class="bi bi-person-plus"></i> Thêm sản phẩm
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

        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Tên sản phẩm</th>
                    <th>Giá</th>
                    <th>Số lượng</th>
                    <th>Size</th>
                    <th>Ảnh</th>
                    <th>Thông tin</th>
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
                <td><?= htmlspecialchars($row['name']) ?></td>
                <td><?= $row['price'] ?></td>
                <td><?= $row['quantity'] ?></td>
                <td><?= $row['size'] ?></td>
                <td><img src="<?= $row['img'] ?>" width="50"></td>
                <td><?= htmlspecialchars($row['info']) ?></td>
                <td>
                    <a href="xulysanpham.php?id=<?= $row['id'] ?>&action=edit" class="btn btn-warning mb-1" data-bs-toggle="modal" data-bs-target="#editProductModal<?= $row['id'] ?>">
                    <i class='bi bi-pencil'></i> Sửa</a>
                    <a href="xulysanpham.php?id=<?= $row['id'] ?>&action=delete_all" class="btn btn-danger mb-1" onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này không?');">
                    <i class='bi bi-trash'></i> Xóa</a>
                    <a href="xulysanpham.php?id=<?= $row['id'] ?>&action=xoasoluong" class="btn btn-info mb-1" data-bs-toggle="modal" data-bs-target="#xoasoluongProductModal<?= $row['id'] ?>">
                    <i class='bi bi-list-check'></i> Cập nhật số lượng</a>
                 </td>
            </tr>
                  
            <!-- Modal sửa sản phẩm -->
            <div class="modal fade" id="editProductModal<?= $row['id'] ?>" tabindex="-1" aria-labelledby="editProductModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editProductModalLabel">Sửa Sản Phẩm</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form method="post" enctype="multipart/form-data">
                            <div class="modal-body">
                                <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Tên sản phẩm</label>
                                    <input type="text" class="form-control" name="name" value="<?= htmlspecialchars($row['name']) ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="price" class="form-label">Giá</label>
                                    <input type="number" class="form-control" name="price" value="<?= $row['price'] ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="quantity" class="form-label">Số lượng</label>
                                    <input type="number" class="form-control" name="quantity" value="<?= $row['quantity'] ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="size" class="form-label">Size</label>
                                    <select class="form-select" name="size" required>
                                        <option value="35" <?= $row['size'] == '35' ? 'selected' : '' ?>>35</option>
                                        <option value="36" <?= $row['size'] == '36' ? 'selected' : '' ?>>36</option>
                                        <option value="36.5" <?= $row['size'] == '36.5' ? 'selected' : '' ?>>36.5</option>
                                        <option value="37" <?= $row['size'] == '37' ? 'selected' : '' ?>>37</option>
                                        <option value="38" <?= $row['size'] == '38' ? 'selected' : '' ?>>38</option>
                                        <option value="38.5" <?= $row['size'] == '38.5' ? 'selected' : '' ?>>38.5</option>
                                        <option value="39" <?= $row['size'] == '39' ? 'selected' : '' ?>>39</option>
                                        <option value="40" <?= $row['size'] == '40' ? 'selected' : '' ?>>40</option>
                                        <option value="40.5" <?= $row['size'] == '40.5' ? 'selected' : '' ?>>40.5</option>
                                        <option value="41" <?= $row['size'] == '41' ? 'selected' : '' ?>>41</option>
                                        <option value="42" <?= $row['size'] == '42' ? 'selected' : '' ?>>42</option>
                                        <option value="42.5" <?= $row['size'] == '42.5' ? 'selected' : '' ?>>42.5</option>
                                        <option value="43" <?= $row['size'] == '43' ? 'selected' : '' ?>>43</option>
                                        <option value="44" <?= $row['size'] == '44' ? 'selected' : '' ?>>44</option>
                                        <option value="44.5" <?= $row['size'] == '44.5' ? 'selected' : '' ?>>44.5</option>
                                        <option value="45" <?= $row['size'] == '45' ? 'selected' : '' ?>>45</option>
                                        <option value="46" <?= $row['size'] == '46' ? 'selected' : '' ?>>46</option>

                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="info" class="form-label">Thông tin sản phẩm</label>
                                    <textarea class="form-control" name="info"><?= htmlspecialchars($row['info']) ?></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="img" class="form-label">Hình ảnh</label>
                                    <input type="file" class="form-control" name="img">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                <button type="submit" class="btn btn-primary" name="update">Cập nhật</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Modal xóa sản phẩm -->
            <div class="modal fade" id="xoasoluongProductModal<?= $row['id'] ?>" tabindex="-1" aria-labelledby="xoasoluongProductModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="xoasoluongProductModalLabel">Xóa sản phẩm</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form method="POST" action="xulysanpham.php?id=<?= $row['id'] ?>&action=delete">
                            <div class="modal-body">
                                <label for="quantity_to_delete" class="form-label">Nhập số lượng cần xóa</label>
                                <input type="number" class="form-control" name="quantity_to_delete" min="1" max="<?= $row['quantity'] ?>" required>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                <button type="submit" class="btn btn-danger">Xóa</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        <?php
            endwhile;
        } else {
            echo "<script type='text/javascript'>
                    alert('Không tìm thấy sản phẩm nào');
                    window.location.href = 'xulysanpham.php';  // Quay lại trang chủ
                </script>";
        }
        ?>
            </tbody>
        </table>
    </div>
</div>


<!-- Modal thêm sản phẩm -->
<div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addProductModalLabel">Thêm Sản Phẩm</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Tên sản phẩm</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Giá</label>
                        <input type="number" class="form-control" name="price" required>
                    </div>
                    <div class="mb-3">
                        <label for="quantity" class="form-label">Số lượng</label>
                        <input type="number" class="form-control" name="quantity" required>
                    </div>
                    <div class="mb-3">
                        <label for="size" class="form-label">Size</label>
                        <select class="form-select" name="size" required>
                            <option value="35">35</option>
                            <option value="36">36</option>
                            <option value="36.5">36.5</option>
                            <option value="37">37</option>
                            <option value="38">38</option>
                            <option value="38.5">38.5</option>
                            <option value="39">39</option>
                            <option value="40">40</option>
                            <option value="40.5">40.5</option>
                            <option value="41">41</option>
                            <option value="42">42</option>
                            <option value="42.5">42.5</option>
                            <option value="43">43</option>
                            <option value="44">44.5</option>
                            <option value="45">45</option>
                            <option value="46">46</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="info" class="form-label">Thông tin sản phẩm</label>
                        <textarea class="form-control" name="info" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="img" class="form-label">Hình ảnh</label>
                        <input type="file" class="form-control" name="img" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-success" name="add">Thêm sản phẩm</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
