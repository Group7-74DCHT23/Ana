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
<!--ĐÂY LÀ PHẦN HEADER-->
    <?php include 'header.php'; ?>
<!--ĐÂY LÀ PHẦN BANNER-->
    <section class="banner ">
        <a href="#">
            <img class="banner-img" src="https://ananas.vn/wp-content/uploads/1920x960.jpg" alt="">
        </a>
    </section>
<!--ĐÂY LÀ NỘI DUNG CHÍNH-->
    <div id="main">
        <div class="inner-wrap">
            <div class="banner-collection">
                <div class="banner-product">
                    <div>
                        <a href="product.html"><img src="https://ananas.vn/wp-content/uploads/banner-phu%CC%A3_2m-600x320.jpg" alt=""></a>
                        <h3><a href="#">ALL BACK IN BLACK</a></h3>
                        <p>Mặc dù được ứng dụng rất nhiều, nhưng sắc đen lúc nào cũng toát lên một vẻ huyền bí không
                            nhàm chán</p>
                    </div>
                </div>
                <div class="banner-sale">
                    <img src="https://ananas.vn/wp-content/uploads/Banner_Sale-off-1.jpg" alt="">
                    <h3><a href="saleoff.html">OUTLET SALE</a></h3>
                    <p>Danh mục những sản phẩm bán tại "giá tốt hơn" chỉ được bán kênh online - Online Only, chúng đã
                        từng làm mưa làm gió một thời gian và hiện đang rơi vào tình trạng bể size, bể số. </p>
                </div>
            </div>
        </div>
        <!-- =======================================================NAV_BUYING============================================================= -->
        <div id="nav-buying" class="inner-wrap">
            <h3>DANH MỤC MUA HÀNG</h3>
            <div class="buying-list">
                <div class="men-shoe">
                    <img src="https://ananas.vn/wp-content/uploads/gi%C3%A0y-nam-e1720844745768.jpg" alt="Giày nam">
                    <div class="overlay"></div>
                    <h4><a href="product-list.php?gender=Nam">Giày nam</a></h4>
                    <ul>
                        <li><a href="product-list.php">New Arrivals</a></li>
                        <li><a href="product-list.php">Best Seller</a></li>
                        <li><a href="saleoff.php">Sale-off</a></li>
                    </ul>
                </div>
                <div class="women-shoe">
                    <img src="https://ananas.vn/wp-content/uploads/DSC6813-3-copy-e1720844894780.jpg" alt="Giày nữ">
                    <div class="overlay"></div>
                    <h4><a href="product-list.php?gender=Nữ">Giày nữ</a></h4>
                    <ul>
                        <li><a href="product-list.php">New Arrivals</a></li>
                        <li><a href="product-list.php">Best Seller</a></li>
                        <li><a href="saleoff.php">Sale-off</a></li>
                    </ul>
                </div>
                <div class="brand-product">
                    <img src="https://ananas.vn/wp-content/uploads/312051553_3195731920685758_2796978630271241540_n-e1720845005261.jpg" alt="Dòng sản phẩm">
                    <div class="overlay"></div>
                    <h4><a href="product-list.php">Dòng sản phẩm</a></h4>
                    <ul>
                        <li><a href="product-list.php?family=Basas">Basas</a></li>
                        <li><a href="product-list.php?family=Vintas">Vintas</a></li>
                        <li><a href="product-list.php?family=Urbas">Urbas</a></li>
                        <li><a href="product-list.php?family=Pattas">Pattas</a></li>
                        <li><a href="product-list.php?family=Track6">Track 6</a></li>

                    </ul>
                </div>
            </div>
        </div>
        
        
<!--ĐÂY LÀ PHẦN BANNER-->
    <div class="banner-2">
        <div><a href="#"><img src="https://ananas.vn/wp-content/uploads/Desktop_Homepage_Banner01.jpg" alt=""></a></div>
    </div>
<!--ĐÂY LÀ PHẦN FOOTER-->
    <?php include 'footer.php'; ?>
<!--ĐÂY LÀ PHẦN BÊN TAY PHẢI-->
<?php include 'cart_right.php'; ?>

</body>

</html>
