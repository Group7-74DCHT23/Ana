-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 02, 2025 at 07:18 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ql`
--

-- --------------------------------------------------------

--
-- Table structure for table `hoadon`
--

CREATE TABLE `hoadon` (
  `id` int(11) NOT NULL,
  `id_bill` int(11) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `total_bill` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` varchar(255) NOT NULL,
  `date_order` date NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hoadon`
--

INSERT INTO `hoadon` (`id`, `id_bill`, `fullname`, `product_name`, `total_bill`, `quantity`, `phone`, `address`, `date_order`, `status`) VALUES
(3, 55, 'nb', 'track 6', 50000, 5, '0393916176', 'Hà Nội', '2004-02-02', 0);

-- --------------------------------------------------------

--
-- Table structure for table `nguoidung`
--

CREATE TABLE `nguoidung` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` varchar(255) NOT NULL,
  `role` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `nguoidung`
--

INSERT INTO `nguoidung` (`id`, `username`, `password`, `fullname`, `email`, `phone`, `address`, `role`) VALUES
(1, 'dhrqur', 'vnkl2005', 'Ngọc Bích', 'nb@gmail.com', '0123456789', 'Hà Nội', 0);

-- --------------------------------------------------------

--
-- Table structure for table `sanpham`
--

CREATE TABLE `sanpham` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `size` int(11) NOT NULL,
  `img` varchar(255) NOT NULL,
  `info` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sanpham`
--

INSERT INTO `sanpham` (`id`, `name`, `price`, `quantity`, `size`, `img`, `info`) VALUES
(1, 'Basas Bumper Gum EXT NE - Low Top', 580000, 10, 35, 'images/SP1.jpg', 'Bumper Gum EXT (Extension) NE là bản nâng cấp được xếp vào dòng sản phẩm Basas, nhưng lại gây ấn tượng với diện mạo phá đi sự an toàn thường thấy. Với cách sắp xếp logo hoán đổi đầy ý tứ và mảng miếng da lộn (Suede) xuất hiện hợp lí trên chất vải canvas NE bền bỉ dày dặn nhấn nhá thêm bằng những sắc Gum dẻo dai. Tất cả làm nên 01 bộ sản phẩm với thiết kế đầy thoải mái trong trải nghiệm, đủ thanh lịch trong dáng vẻ.'),
(2, 'Basas Bumper Gum EXT NE - High Top', 650000, 10, 36, 'images/SP2.jpg', 'Bumper Gum EXT (Extension) NE là bản nâng cấp được xếp vào dòng sản phẩm Basas, nhưng lại gây ấn tượng với diện mạo phá đi sự an toàn thường thấy. Với cách sắp xếp logo hoán đổi đầy ý tứ và mảng miếng da lộn (Suede) xuất hiện hợp lí trên chất vải canvas NE bền bỉ dày dặn nhấn nhá thêm bằng những sắc Gum dẻo dai. Tất cả làm nên 01 bộ sản phẩm với thiết kế đầy thoải mái trong trải nghiệm, đủ thanh lịch trong dáng vẻ.'),
(3, 'Basas Day Slide - Slip On', 550000, 20, 37, 'images/SP3.jpg', 'Gender: Unisex\r\nSize run: 35 – 46\r\nUpper: Canvas\r\nOutsole: Rubber'),
(4, 'Basas Evergreen - Low Top', 580000, 20, 38, 'images/SP4.jpg', 'Gender: Unisex\r\nSize run: 35 – 46\r\nUpper: Canvas NE\r\nOutsole: Rubber\r\nCó thêm 01 bộ dây đi kèm'),
(5, 'Vintas Denim - High Top', 690000, 15, 39, 'images/SP5.jpg', 'Gender: Unisex\r\nSize run: 35 – 46\r\nUpper: Denim\r\nOutsole: Rubber'),
(6, 'Vintas Vivu - Low Top', 620000, 25, 38, 'images/SP6.jpeg', 'Gender: Unisex\r\nSize run: 35 – 46\r\nUpper: Canvas\r\nOutsole: Rubber'),
(7, 'Vintas Public 2000s - Low Top', 620000, 15, 39, 'images/SP7.jpg', 'Gender: Unisex\r\nSize run: 35 – 46\r\nUpper: Canvas\r\nOutsole: Rubber'),
(8, 'Vintas Jazico - High Top', 780000, 12, 39, 'images/SP8.jpeg', 'Gender: Unisex\r\nSize run: 35 – 46\r\nUpper: Canvas/Leather\r\nOutsole: Rubber'),
(9, 'Pattas Polka Dots - High Top', 390000, 5, 37, 'images/SP9.jpg', 'Gender: Unisex\r\nSize run: 35 – 46\r\nUpper: Canvas NE\r\nOutsole: Rubber'),
(11, 'Basas Bumper Gum NE - Mule', 390000, 7, 43, 'images/SP10.jpeg', 'Kết hợp thiết kế hở gót cùng quai dán, Basas Bumper Gum NE - Mule mang lại trải nghiệm tiện lợi tăng cấp so với phiên bản thắt dây truyền thống. Lên chân nhanh chóng trong tích tắc không cần chạm tay nhưng vẫn sở hữu diện mạo đầy tính thanh lịch, Basas Bumper Gum NE - Mule chính là lựa chọn toàn diện cho mọi dịp dạo chơi từ nhà ra phố của các tín đồ thời trang trẻ.'),
(12, 'Basas Bumper Gum NE - Mule', 520000, 7, 35, 'images/SP11.jpeg', 'Tiện lợi nhân đôi với quai dán đi cùng thiết kế hở gót độc đáo, Basas Hook’n Loop - Mule chính là đôi giày hoàn hảo cho cuộc sống nhộn nhịp, vội vã của giới trẻ. Phiên bản sở hữu chất liệu được nâng cấp gia tăng độ bền bỉ, cùng 2 lựa chọn màu sắc thân thiện bậc nhất cho mọi dáng hình phong cách. Basas Hook’n Loop - Mule chắc chắn sẽ là điểm nhấn đặc biệt và là một sự bổ sung xứng đáng cho tủ giày/dép của bạn.\r\n'),
(13, 'Track 6 Utility Gum Sole - Low Top', 1090000, 20, 42, 'images/SP12.jpg', 'Từ chất liệu da lộn (suede) quen thuộc, đặt nhẹ nhàng lên \"nền tảng\" cao su màu Gum nguyên khối, đem đến sự khác biệt mà vẫn hợp lý trên tổng thể. Tất cả chi tiết tạo nên một phiên bản Track 6 Utility Gum Sole cổ điển, đơn giản tiện dụng mà vẫn thu hút đối với những tín đồ thời trang khó tính nhất.'),
(14, 'Track 6 Triple White - Low Top', 990000, 25, 43, 'images/SP13.jpg', 'Với cảm hứng từ Retro Sneakers và âm nhạc giai đoạn 1970s, Ananas Track 6 ra đời với danh hiệu là mẫu giày Cold Cement đầu tiên của Ananas - một thương hiệu giày Vulcanized. Chất liệu Storm Leather đáng giá \"càn quét\" toàn bộ bề mặt upper cùng những chi tiết thiết kế đặc trưng và mang nhiều ý nghĩa. Chắc rằng, Track 6 sẽ đem đến cho bạn sự tự nhiên thú vị như chính thông điệp bài hát Let it be của huyền thoại The Beatles gửi gắm. Màu all white chắc nhiều bạn sẽ thích.'),
(15, 'Track 6 Class E - Low Top', 1990000, 35, 39, 'images/SP14.jpg', 'Sử dụng chất da bò Nappa có bề mặt nhẵn bóng, kết hợp cùng mesh và Suede (da lộn) thường xuất hiện ở các đôi Sneaker cao cấp. Track 6 Class E (Essential, Enthusiasm) ngoài thể hiện nét trang trọng và tinh tế qua từng mảng chất liệu, còn tập trung vào cách bố trí và sắp xếp màu sắc tạo điểm nhấn nhẹ nhàng cho tổng thể. Chi tiết màu “Botanist Green” đại diện cho rừng cây xanh ngát được cài cắm có chủ đích qua phần tem lưỡi gà và chất liệu da Suede phủ màu, tạo nét hút mắt thú vị và hợp lý cho phần Upper. Đây có thể xem là một mảnh ghép của bộ Track 6 Class E, một thiết kế dành riêng cho những ai yêu thích thiên nhiên và sắc xanh không thể thiếu trong đời sống cơ bản thường ngày.'),
(16, 'Basas Mono Black NE -  Low Top', 490000, 19, 38, 'images/SP15.jpg', 'Nâng cấp chất liệu vải mới bền màu ổn định, kết hợp cùng vẻ ngoài ton sur ton từ trên xuống dưới cùng sắc đen cá tính, giúp phiên bản Basas Mono Black NE trở nên quyến rũ và tiện dụng hơn bao giờ hết. Đây hứa hẹn sẽ là sản phẩm lọt vào danh sách cho những tín đồ thường coi màu đen là sự ưu tiên.\r\n');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `hoadon`
--
ALTER TABLE `hoadon`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `nguoidung`
--
ALTER TABLE `nguoidung`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sanpham`
--
ALTER TABLE `sanpham`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `hoadon`
--
ALTER TABLE `hoadon`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `nguoidung`
--
ALTER TABLE `nguoidung`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `sanpham`
--
ALTER TABLE `sanpham`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
