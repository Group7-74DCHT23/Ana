<?php
require('connect.php');

// Mặc định hiển thị tất cả sản phẩm
$sql = "SELECT * FROM sanpham";

// Lọc theo giới tính (gender)
if (isset($_GET['gender'])) {
    $gender = $_GET['gender'];
    if ($gender === "All") {
        $sql = "SELECT * FROM sanpham WHERE gender IN (0, 1, 2)";
    } elseif ($gender === "Nam") {
        $sql = "SELECT * FROM sanpham WHERE gender = 0 OR gender = 2";
    } elseif ($gender === "Nữ") {
        $sql = "SELECT * FROM sanpham WHERE gender = 1 OR gender = 2";
    }
}

// Lọc theo tìm kiếm (search)
if (isset($_GET['search'])) {
    $noidung = $conn->real_escape_string($_GET['noidung']);
    $sql = "SELECT * FROM sanpham WHERE name LIKE '%$noidung%'";
}

// Lọc theo dòng sản phẩm (family)
if (isset($_GET['family'])) {
    $gender = $_GET['family'];
    if ($gender === "Basas") {
        $sql = "SELECT * FROM sanpham WHERE family = 0";
    } elseif ($gender === "Vintas") {
        $sql = "SELECT * FROM sanpham WHERE family = 1";
    } elseif ($gender === "Urbas") {
        $sql = "SELECT * FROM sanpham WHERE family = 2";   
    } elseif ($gender === "Pattas") {
        $sql = "SELECT * FROM sanpham WHERE family = 3";   
    } elseif ($gender === "Track6") {
        $sql = "SELECT * FROM sanpham WHERE family = 4";   
    }
}

// Thực thi câu truy vấn
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="logo/Logo_Ananas.svg">
    <title>PRODUCT</title>
    <link rel="stylesheet" href="./css/product-list.css">
</head>

<body>
    <!-- HEADER -->
    <?php include 'header.php'; ?>

    <!-- MAIN CONTENT -->
    <main class="main-content">
        <div class="container">
            <!-- Sidebar (Menu tùy chọn) -->
            <div class="product-nav">
                <h3>TÙY CHỌN</h3>
                    <div class="category">
                        <h4>DÀNH CHO</h4>
                        <ul>
                            <li><a href="?gender=All">Tất Cả</a></li>
                            <li><a href="?gender=Nam">Nam</a></li>
                            <li><a href="?gender=Nữ">Nữ</a></li>
                        </ul>
                    </div>
                    <div class="category">
                        <h4>DÒNG SẢN PHẨM</h4>
                        <ul>
                            <li><a href="?family=Basas">Basas</a></li>
                            <li><a href="?family=Vintas">Vintas</a></li>
                            <li><a href="?family=Urbas">Urbas</a></li>
                            <li><a href="?family=Pattas">Pattas</a></li>
                            <li><a href="?family=Track6">Track 6</a></li>
                        </ul>
                    </div>
            </div>

            <!-- Product List -->
            <div class="product-list">
                <?php while ($product = $result->fetch_assoc()): ?>
                    <div class="product-item">
                        <a href="product-detail.php?id=<?php echo $product['id'] ?>">
                            <img src="<?php echo $product['img'] ?>" alt="<?php echo $product['name'] ?>">
                        </a>
                        <h2 class="product-name">
                            <a href="product-detail.php?id=<?php echo $product['id'] ?>">
                                <?php echo $product['name'] ?>
                            </a>
                        </h2>
                        <p class="product-price"><?php echo number_format($product['price'], 0, ',', ',') . " VND"; ?></p>
                        <a href="detail-products.php?id=<?php echo $product['id'] ?>" class="product-button">Thêm vào giỏ hàng</a>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </main>

    <!-- FOOTER -->
    <?php include 'footer.php'; ?>
    <?php include 'cart_right.php'; ?>

</body>

</html>
