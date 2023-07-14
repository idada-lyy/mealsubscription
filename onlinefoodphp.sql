-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 14, 2023 at 06:48 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `onlinefoodphp`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `adm_id` int(222) NOT NULL,
  `username` varchar(222) NOT NULL,
  `password` varchar(222) NOT NULL,
  `email` varchar(222) NOT NULL,
  `code` varchar(222) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`adm_id`, `username`, `password`, `email`, `code`, `date`) VALUES
(1, 'admin', 'CAC29D7A34687EB14B37068EE4708E7B', 'admin@mail.com', '', '2022-05-27 13:21:52');

-- --------------------------------------------------------

--
-- Table structure for table `dishes`
--

CREATE TABLE `dishes` (
  `d_id` int(222) NOT NULL,
  `rs_id` int(222) NOT NULL,
  `title` varchar(222) NOT NULL,
  `slogan` varchar(222) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `img` varchar(222) NOT NULL,
  `allergies` text DEFAULT NULL,
  `diets` text DEFAULT NULL,
  `ingredients` text DEFAULT NULL,
  `rating` int(222) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `dishes`
--

INSERT INTO `dishes` (`d_id`, `rs_id`, `title`, `slogan`, `price`, `img`, `allergies`, `diets`, `ingredients`, `rating`) VALUES
(1, 1, 'Yorkshire Lamb Patties', 'Lamb patties which melt in your mouth, and are quick and easy to make. Served hot with a crisp salad.', 14.00, '62908867a48e4.jpg', 'milk', 'ketogenic', 'Lamb, Horseradish, Onion', 20),
(2, 1, 'Lobster Thermidor', 'Lobster Thermidor is a French dish of lobster meat cooked in a rich wine sauce, stuffed back into a lobster shell, and browned.', 36.00, '629089fee52b9.jpg', 'fish', 'pescatarian', 'Lobster, Wine, Heavy Cream', 5),
(4, 1, 'Stuffed Jacket Potatoes', 'Deep fry whole potatoes in oil for 8-10 minutes or coat each potato with little oil. Mix the onions, garlic, tomatoes and mushrooms. Add yoghurt, ginger, garlic, chillies, coriander', 8.00, '62908d393465b.jpg', 'fish', 'vegan', 'Potato, Cheese, Butter, Cream', 5),
(5, 2, 'Pink Spaghetti Gamberoni', 'Spaghetti with prawns in a fresh tomato sauce. This dish originates from Southern Italy and with the combination of prawns, garlic, chilli and pasta. Garnish each with remaining tablespoon parsley.', 21.00, '606d7491a9d13.jpg', 'peanuts', 'ketogenic', 'Cherry tomato, Shrimp', 0),
(6, 2, 'Cheesy Mashed Potato', 'Deliciously Cheesy Mashed Potato. The ultimate mash for your Thanksgiving table or the perfect accompaniment to vegan sausage casserole. Everyone will love it\'s fluffy, cheesy.', 5.00, '606d74c416da5.jpg', '', 'vegan', 'Potato, Cheese', 2),
(7, 2, 'Crispy Chicken Strips', 'Fried chicken strips, served with special honey mustard sauce.', 8.00, '606d74f6ecbbb.jpg', 'shellfish', 'gluten-free', 'Chicken, Honey Mustard Sauce', 5),
(8, 2, 'Lemon Grilled Chicken And Pasta', 'Marinated rosemary grilled chicken breast served with mashed potatoes and your choice of pasta.', 11.00, '606d752a209c3.jpg', 'eggs', 'ketogenic', 'Chicken, Rosemary, Potato', 5),
(9, 3, 'Vegetable Fried Rice', 'Chinese rice wok with cabbage, beans, carrots, and spring onions.', 5.00, '606d7575798fb.jpg', 'eggs', 'vegan', 'Carrot, Potato, Chickpea', 0),
(10, 3, 'Prawn Crackers', '12 pieces deep-fried prawn crackers', 7.00, '606d75a7e21ec.jpg', 'shellfish', 'pescatarian', 'Prawn', 5),
(11, 3, 'Spring Rolls', 'Lightly seasoned shredded cabbage, onion and carrots, wrapped in house made spring roll wrappers, deep fried to golden brown.', 6.00, '606d75ce105d0.jpg', 'eggs', 'vegan', 'Rice paper, Vegetable', 0),
(13, 4, 'Buffalo Wings', 'Fried chicken wings tossed in spicy Buffalo sauce served with crisp celery sticks and Blue cheese dip.', 11.00, '606d765f69a19.jpg', 'celery', 'ketogenic', 'Chicken, Celery', 3),
(14, 4, 'Mac N Cheese Bites', 'Served with our traditional spicy queso and marinara sauce.', 9.00, '606d768a1b2a1.jpg', 'wheat', 'ketogenic', 'Cheese, Pasta, Flour', 0),
(15, 4, 'Signature Potato Twisters', 'Spiral sliced potatoes, topped with our traditional spicy queso, Monterey Jack cheese, pico de gallo, sour cream and fresh cilantro.', 6.00, '606d76ad0c0cb.jpg', 'tree-nuts', 'ketogenic', 'Potato, Cheese, Cilantro', 0),
(16, 4, 'Meatballs Penne Pasta', 'Garlic-herb beef meatballs tossed in our house-made marinara sauce and penne pasta topped with fresh parsley.', 10.00, '606d76eedbb99.jpg', 'wheat', 'ketogenic', 'Red wine vinegar, Pasta, Tomato', 2);

-- --------------------------------------------------------

--
-- Table structure for table `remark`
--

CREATE TABLE `remark` (
  `id` int(11) NOT NULL,
  `frm_id` int(11) NOT NULL,
  `status` varchar(255) NOT NULL,
  `remark` mediumtext NOT NULL,
  `remarkDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `remark`
--

INSERT INTO `remark` (`id`, `frm_id`, `status`, `remark`, `remarkDate`) VALUES
(1, 2, 'in process', 'none', '2022-05-01 05:17:49'),
(2, 3, 'in process', 'none', '2022-05-27 11:01:30'),
(3, 2, 'closed', 'thank you for your order!', '2022-05-27 11:11:41'),
(4, 3, 'closed', 'none', '2022-05-27 11:42:35'),
(5, 4, 'in process', 'none', '2022-05-27 11:42:55'),
(6, 1, 'rejected', 'none', '2022-05-27 11:43:26'),
(7, 7, 'in process', 'none', '2022-05-27 13:03:24'),
(8, 8, 'in process', 'none', '2022-05-27 13:03:38'),
(9, 9, 'rejected', 'thank you', '2022-05-27 13:03:53'),
(10, 7, 'closed', 'thank you for your ordering with us', '2022-05-27 13:04:33'),
(11, 8, 'closed', 'thanks ', '2022-05-27 13:05:24'),
(12, 5, 'closed', 'none', '2022-05-27 13:18:03'),
(13, 14, 'closed', 'your order is delivered, enjoy!\r\n', '2023-07-13 15:31:20'),
(14, 16, 'closed', '', '2023-07-14 01:16:31'),
(15, 17, 'closed', '', '2023-07-14 01:16:48'),
(16, 18, 'closed', '', '2023-07-14 01:17:03'),
(17, 20, 'closed', '', '2023-07-14 01:17:18'),
(18, 19, 'closed', '', '2023-07-14 01:17:33'),
(19, 22, 'closed', '', '2023-07-14 01:48:27'),
(20, 23, 'closed', '', '2023-07-14 01:58:33'),
(21, 24, 'closed', '', '2023-07-14 02:00:24'),
(22, 24, 'closed', '', '2023-07-14 02:02:39'),
(23, 25, 'closed', '', '2023-07-14 02:03:02'),
(24, 26, 'closed', '', '2023-07-14 02:05:50'),
(25, 27, 'closed', '', '2023-07-14 02:07:19'),
(26, 29, 'closed', '', '2023-07-14 02:41:56'),
(27, 30, 'closed', '', '2023-07-14 02:42:06'),
(28, 30, 'in process', '', '2023-07-14 02:46:33'),
(29, 31, 'in process', '', '2023-07-14 03:27:30'),
(30, 31, 'closed', '', '2023-07-14 03:33:53');

-- --------------------------------------------------------

--
-- Table structure for table `restaurant`
--

CREATE TABLE `restaurant` (
  `rs_id` int(222) NOT NULL,
  `c_id` int(222) NOT NULL,
  `title` varchar(222) NOT NULL,
  `email` varchar(222) NOT NULL,
  `phone` varchar(222) NOT NULL,
  `url` varchar(222) NOT NULL,
  `o_hr` varchar(222) NOT NULL,
  `c_hr` varchar(222) NOT NULL,
  `o_days` varchar(222) NOT NULL,
  `address` text NOT NULL,
  `image` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `restaurant`
--

INSERT INTO `restaurant` (`rs_id`, `c_id`, `title`, `email`, `phone`, `url`, `o_hr`, `c_hr`, `o_days`, `address`, `image`, `date`) VALUES
(1, 1, 'North Street Tavern', 'nthavern@mail.com', '3547854700', 'www.northstreettavern.com', '8am', '8pm', 'mon-sat', '1128 North St, White Plains', '6290877b473ce.jpg', '2022-05-27 08:10:35'),
(2, 2, 'Eataly', 'eataly@gmail.com', '0557426406', 'www.eataly.com', '11am', '9pm', 'Mon-Sat', '800 Boylston St, Boston', '606d720b5fc71.jpg', '2022-05-27 08:06:41'),
(3, 3, 'Nan Xiang Xiao Long Bao', 'nanxiangbao45@mail.com', '1458745855', 'www.nanxiangbao45.com', '9am', '8pm', 'mon-sat', 'Queens, New York', '6290860e72d1e.jpg', '2022-05-27 08:04:30'),
(4, 4, 'Highlands Bar & Grill', 'hbg@mail.com', '6545687458', 'www.hbg.com', '7am', '8pm', 'mon-sat', '812 Walter Street', '6290af6f81887.jpg', '2022-05-27 11:01:03'),
(5, 1, 'Holy Guacamole', 'thamkwang123@gmail.com', '0123456789', 'holyguacamole.com', '11am', '12am', 'Mon-Thu', 'jalan rambai 3', '64b01d2b3b262.jpg', '2023-07-13 15:50:03');

-- --------------------------------------------------------

--
-- Table structure for table `res_category`
--

CREATE TABLE `res_category` (
  `c_id` int(222) NOT NULL,
  `c_name` varchar(222) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `res_category`
--

INSERT INTO `res_category` (`c_id`, `c_name`, `date`) VALUES
(1, 'Continental', '2022-05-27 08:07:35'),
(2, 'Italian', '2021-04-07 08:45:23'),
(3, 'Chinese', '2021-04-07 08:45:25'),
(4, 'American', '2021-04-07 08:45:28');

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE `review` (
  `id` int(11) NOT NULL,
  `o_id` int(11) NOT NULL,
  `u_id` int(11) NOT NULL,
  `d_id` int(11) NOT NULL,
  `msg` text NOT NULL,
  `rating` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `review`
--

INSERT INTO `review` (`id`, `o_id`, `u_id`, `d_id`, `msg`, `rating`, `date`) VALUES
(1, 14, 8, 4, 'best potatos!!', 5, '2023-07-13 16:27:52'),
(2, 18, 9, 16, 'meatballs still raw...', 1, '2023-07-14 01:19:01'),
(3, 17, 9, 8, 'very good i love it', 5, '2023-07-14 01:19:20'),
(4, 19, 9, 13, 'not salty enough', 3, '2023-07-14 01:19:44'),
(5, 11, 5, 8, 'not as good as expected\r\n', 1, '2023-07-14 01:21:45'),
(7, 4, 5, 6, 'Not so good, seasoning was ok', 2, '2023-07-14 01:29:42'),
(8, 5, 5, 16, 'Good meatballs, good penne', 4, '2023-07-14 01:30:12'),
(11, 21, 9, 2, 'Very good, would buy again for family dinner', 5, '2023-07-14 01:37:06'),
(15, 10, 8, 1, 'Seasoning: great!\r\nMeat: great!\r\nTaste: great!\r\n10/10!!!', 5, '2023-07-14 01:44:50'),
(17, 22, 9, 1, 'THE BEST OF ALL TIME', 5, '2023-07-14 01:48:55'),
(18, 23, 9, 1, 'Second time order! Still good', 5, '2023-07-14 01:58:53'),
(20, 27, 10, 3, 'I love it, will order more for my family', 5, '2023-07-14 02:07:45'),
(21, 30, 11, 10, 'THE BEST', 5, '2023-07-14 02:43:00'),
(22, 29, 11, 12, 'the food is ok but kinda raw', 4, '2023-07-14 02:43:21'),
(23, 31, 12, 1, 'very good', 5, '2023-07-14 03:47:26');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `u_id` int(222) NOT NULL,
  `username` varchar(222) NOT NULL,
  `f_name` varchar(222) NOT NULL,
  `l_name` varchar(222) NOT NULL,
  `email` varchar(222) NOT NULL,
  `phone` varchar(222) NOT NULL,
  `password` varchar(222) NOT NULL,
  `address` text NOT NULL,
  `status` int(222) NOT NULL DEFAULT 1,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`u_id`, `username`, `f_name`, `l_name`, `email`, `phone`, `password`, `address`, `status`, `date`) VALUES
(1, 'eric', 'Eric', 'Lopez', 'eric@mail.com', '1458965547', 'a32de55ffd7a9c4101a0c5c8788b38ed', '87 Armbrester Drive', 1, '2022-05-27 08:40:36'),
(2, 'harry', 'Harry', 'Holt', 'harryh@mail.com', '3578545458', 'bc28715006af20d0e961afd053a984d9', '33 Stadium Drive', 1, '2022-05-27 08:41:07'),
(3, 'james', 'James', 'Duncan', 'james@mail.com', '0258545696', '58b2318af54435138065ee13dd8bea16', '67 Hiney Road', 1, '2022-05-27 08:41:37'),
(4, 'christine', 'Christine', 'Moore', 'christine@mail.com', '7412580010', '5f4dcc3b5aa765d61d8327deb882cf99', '114 Test Address', 1, '2022-05-01 05:14:42'),
(5, 'scott', 'Scott', 'Miller', 'scott@mail.com', '7896547850', '5f4dcc3b5aa765d61d8327deb882cf99', '63 Charack Road', 1, '2022-05-27 10:53:51'),
(6, 'liamoore', 'Liam', 'Moore', 'liamoore@mail.com', '7896969696', '5f4dcc3b5aa765d61d8327deb882cf99', '122 Bleck Street', 1, '2022-05-27 12:57:00'),
(7, 'test', 'test', 'test', 'test@mail.com', '7896969696', 'e10adc3949ba59abbe56e057f20f883e', '122 Bleck Street', 1, '2022-05-27 12:57:00'),
(8, 'ida', 'ida', 'loh', 'ida@email.com', '0123456789', '670b14728ad9902aecba32e22fa4f6bd', 'jalan rambai 5', 1, '2023-07-12 15:43:16'),
(9, 'weijun', 'wei', 'jun', 'weijun@gmail.com', '0123456789', '670b14728ad9902aecba32e22fa4f6bd', 'lorong slim', 1, '2023-07-14 01:14:29'),
(10, 'junhong', 'jun', 'hong', 'jh@gmail.com', '0123456789', '670b14728ad9902aecba32e22fa4f6bd', '23, jalan macallum', 1, '2023-07-14 02:04:49'),
(11, 'disern', 'di', 'sern', 'ds@gmail.com', '0123456789', '670b14728ad9902aecba32e22fa4f6bd', 'balik pulau', 1, '2023-07-14 02:37:26'),
(12, 'jasmine', 'jasmine', 'chan', 'jasmine@gmail.com', '0123456789', '670b14728ad9902aecba32e22fa4f6bd', '23, jalan macallum', 1, '2023-07-14 03:14:55');

-- --------------------------------------------------------

--
-- Table structure for table `users_orders`
--

CREATE TABLE `users_orders` (
  `o_id` int(222) NOT NULL,
  `u_id` int(222) NOT NULL,
  `title` varchar(222) NOT NULL,
  `quantity` int(222) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `status` varchar(222) DEFAULT NULL,
  `subscription` varchar(222) DEFAULT NULL,
  `receiveDatetime` timestamp NULL DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users_orders`
--

INSERT INTO `users_orders` (`o_id`, `u_id`, `title`, `quantity`, `price`, `status`, `subscription`, `receiveDatetime`, `date`) VALUES
(1, 4, 'Spring Rolls', 2, 6.00, 'rejected', NULL, '2022-05-27 12:43:26', '2022-05-27 11:43:26'),
(2, 4, 'Prawn Crackers', 1, 7.00, 'closed', NULL, '2022-05-27 12:11:41', '2022-05-27 11:11:41'),
(3, 5, 'Chicken Madeira', 1, 23.00, 'closed', NULL, '2022-05-27 12:42:35', '2022-05-27 11:42:35'),
(4, 5, 'Cheesy Mashed Potato', 1, 5.00, 'in process', NULL, '2022-05-27 12:42:55', '2022-05-27 11:42:55'),
(5, 5, 'Meatballs Penne Pasta', 1, 10.00, 'closed', NULL, '2022-05-27 14:18:03', '2022-05-27 13:18:03'),
(6, 5, 'Yorkshire Lamb Patties', 1, 14.00, NULL, NULL, '2022-05-27 12:40:51', '2022-05-27 11:40:51'),
(7, 6, 'Yorkshire Lamb Patties', 1, 14.00, 'closed', NULL, '2022-05-27 14:04:33', '2022-05-27 13:04:33'),
(8, 6, 'Lobster Thermidor', 1, 36.00, 'closed', NULL, '2022-05-27 14:05:24', '2022-05-27 13:05:24'),
(9, 6, 'Stuffed Jacket Potatoes', 1, 8.00, 'rejected', NULL, '2022-05-27 14:03:53', '2022-05-27 13:03:53'),
(10, 8, 'Yorkshire Lamb Patties', 1, 14.00, NULL, 'weekly', '2023-07-18 16:06:00', '2023-07-12 16:06:58'),
(11, 8, 'Lobster Thermidor', 1, 36.00, NULL, 'weekly', '2023-07-18 16:06:00', '2023-07-12 16:06:58'),
(12, 8, 'Stuffed Jacket Potatoes', 1, 8.00, NULL, 'weekly', '2023-07-18 16:06:00', '2023-07-12 16:06:58'),
(13, 8, 'Yorkshire Lamb Patties', 7, 14.00, NULL, '9 Month', NULL, '2023-07-12 16:12:14'),
(14, 8, 'Stuffed Jacket Potatoes', 10, 8.00, 'closed', '9 Month', NULL, '2023-07-13 15:31:20'),
(15, 8, 'Lobster Thermidor', 1, 36.00, NULL, NULL, '2023-07-28 08:31:00', '2023-07-13 16:27:31'),
(16, 9, 'Cheesy Mashed Potato', 1, 5.00, 'closed', NULL, NULL, '2023-07-14 01:16:31'),
(17, 9, 'Lemon Grilled Chicken And Pasta', 1, 11.00, 'closed', NULL, NULL, '2023-07-14 01:16:48'),
(18, 9, 'Meatballs Penne Pasta', 1, 10.00, 'closed', NULL, NULL, '2023-07-14 01:17:03'),
(19, 9, 'Buffalo Wings', 1, 11.00, 'closed', NULL, NULL, '2023-07-14 01:17:33'),
(20, 9, 'Chicken Madeira', 1, 23.00, 'closed', NULL, NULL, '2023-07-14 01:17:18'),
(21, 9, 'Lobster Thermidor', 1, 36.00, NULL, NULL, NULL, '2023-07-14 01:34:30'),
(22, 9, 'Yorkshire Lamb Patties', 1, 14.00, 'closed', NULL, NULL, '2023-07-14 01:48:27'),
(23, 9, 'Yorkshire Lamb Patties', 1, 14.00, 'closed', NULL, NULL, '2023-07-14 01:58:33'),
(24, 9, 'Chicken Madeira', 1, 23.00, 'closed', NULL, NULL, '2023-07-14 02:00:24'),
(25, 8, 'Lobster Thermidor', 1, 36.00, 'closed', NULL, NULL, '2023-07-14 02:03:02'),
(26, 10, 'Lobster Thermidor', 1, 36.00, 'closed', NULL, NULL, '2023-07-14 02:05:50'),
(27, 10, 'Chicken Madeira', 1, 23.00, 'closed', NULL, NULL, '2023-07-14 02:07:19'),
(29, 11, 'Manchurian Chicken', 1, 11.00, 'closed', NULL, '2023-07-16 04:41:00', '2023-07-14 02:41:56'),
(30, 11, 'Prawn Crackers', 1, 7.00, 'in process', NULL, '2023-07-16 04:41:00', '2023-07-14 02:46:33'),
(31, 12, 'Yorkshire Lamb Patties', 1, 14.00, 'closed', NULL, '2023-07-21 04:25:00', '2023-07-14 03:33:53');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`adm_id`);

--
-- Indexes for table `dishes`
--
ALTER TABLE `dishes`
  ADD PRIMARY KEY (`d_id`);

--
-- Indexes for table `remark`
--
ALTER TABLE `remark`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `restaurant`
--
ALTER TABLE `restaurant`
  ADD PRIMARY KEY (`rs_id`);

--
-- Indexes for table `res_category`
--
ALTER TABLE `res_category`
  ADD PRIMARY KEY (`c_id`);

--
-- Indexes for table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`u_id`);

--
-- Indexes for table `users_orders`
--
ALTER TABLE `users_orders`
  ADD PRIMARY KEY (`o_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `adm_id` int(222) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `dishes`
--
ALTER TABLE `dishes`
  MODIFY `d_id` int(222) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `remark`
--
ALTER TABLE `remark`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `restaurant`
--
ALTER TABLE `restaurant`
  MODIFY `rs_id` int(222) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `res_category`
--
ALTER TABLE `res_category`
  MODIFY `c_id` int(222) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `review`
--
ALTER TABLE `review`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `u_id` int(222) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users_orders`
--
ALTER TABLE `users_orders`
  MODIFY `o_id` int(222) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
