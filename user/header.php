<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="logo/Logo_Ananas.svg">
    <title>ANANAS</title>
    <!-- ====================================font-awesonme========= -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
        integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- ============css============== -->
    <link rel="stylesheet" href="css/home.css">
</head>

<body>
    <header id="header">
        <div id="menu">
            <a href="home.php" class="logo-ananas">
                <img src="logo/Logo_Ananas.svg" alt="Logo Ananas">
            </a>
            <ul>
                <li><a href="product-list.php">SẢN PHẨM</a>
                    <div class="dropdown-product">
                        <div class="menu-product inner-wrap">
                            <div>
                                <a href="product-list.php?gender=0,2"><img src="https://ananas.vn/wp-content/uploads/Dropmenu_nam.png" alt=""></a>
                                <a href="product-list.php?gender=0,2">CHO NAM</a>
                            </div>
                            <div>
                                <a href="product-list.php?gender=1,2"><img src="https://ananas.vn/wp-content/uploads/Frame-1304-1.png" alt=""></a>
                                <a href="product-list.php?gender=1,2">CHO NỮ</a>
                            </div>
                            <div>
                                <a href="saleoff.php"><img src="https://ananas.vn/wp-content/uploads/Group-1303-1.png"
                                        alt=""></a>
                                <a href="saleoff.php">OUTLET SALE</a>
                            </div>
                        </div>
                        <a href="#">MỌI NGƯỜI THƯỜNG GỌI CHÚNG TÔI LÀ <span>DỨA</span> !</a>
                    </div>
                </li>
                
                <li><a href="saleoff.php">sale off</a></li>
                <li><a href="article.html"><img src="logo/DiscoverYOU.svg" alt=""></a></li>
            </ul>
            <div class="header-search">
                <form action="product-list.php">
                    <div class="search-container">
                        <button type="submit" name="search" id="search"><img src="img/icon-search.png" alt="Search Icon" class="search-icon"></button>
                        <input type="text" id="noidung" name="noidung" placeholder="Tìm kiếm" required>
                    </div>
                </form>
            
                <div class="header-search_user">
                    <a href="login.php">
                        <i class="fas fa-user"></i>
                        <span>Đăng Nhập</span>
                    </a>
                </div>
                <div class="header-search_shop">
                    <a href="./shop/shop.php">
                        <i class="fas fa-shopping-cart"></i>
                        <span>Giỏ Hàng</span>
                    </a>
                </div>
            </div>
        </div>
    </header>
