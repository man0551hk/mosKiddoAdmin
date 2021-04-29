-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 19, 2021 at 01:56 PM
-- Server version: 5.7.32
-- PHP Version: 7.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `sq_shcc`
--

-- --------------------------------------------------------

--
-- Table structure for table `album`
--

CREATE TABLE `album` (
  `albumId` int(11) NOT NULL,
  `categoryId` int(11) NOT NULL,
  `albumName` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `album`
--

INSERT INTO `album` (`albumId`, `categoryId`, `albumName`) VALUES
(1, 1, 'Test Album'),
(2, 1, 'Test Album 2');

-- --------------------------------------------------------

--
-- Table structure for table `albumcategory`
--

CREATE TABLE `albumcategory` (
  `categoryId` int(11) NOT NULL,
  `categoryName` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `albumcategory`
--

INSERT INTO `albumcategory` (`categoryId`, `categoryName`) VALUES
(1, 'Testing Album Category 1');

-- --------------------------------------------------------

--
-- Table structure for table `blog`
--

CREATE TABLE `blog` (
  `blogId` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `message` varchar(2000) NOT NULL,
  `status` int(11) NOT NULL,
  `createdDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `blog`
--

INSERT INTO `blog` (`blogId`, `name`, `message`, `status`, `createdDate`) VALUES
(1, 'Test name', 'Testing name', 0, '2021-03-26 12:04:00');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `categoryId` int(11) NOT NULL,
  `categoryName` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`categoryId`, `categoryName`) VALUES
(1, '160th Souvenir'),
(2, 'School Souvenir'),
(3, 'Test Album category 2');

-- --------------------------------------------------------

--
-- Table structure for table `gallery`
--

CREATE TABLE `gallery` (
  `galleryId` int(11) NOT NULL,
  `categoryId` int(11) NOT NULL,
  `albumId` int(11) NOT NULL,
  `type` int(1) NOT NULL,
  `caption` varchar(300) DEFAULT NULL,
  `filePath` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `gallery`
--

INSERT INTO `gallery` (`galleryId`, `categoryId`, `albumId`, `type`, `caption`, `filePath`) VALUES
(1, 1, 1, 1, 'Testing Caption', '1_1_iKAjpS4sY7Fp8ZnT.jpg'),
(2, 1, 1, 1, 'Testing Caption 3', '1_1_INMlahCFljO4kzMJ.jpg'),
(3, 1, 1, 1, 'Caption 5', '1_1_JK4eBBqwqQ9YlL2d.png'),
(4, 1, 1, 1, NULL, '1_1_FALPnmGMEKcDNVe5.png'),
(5, 1, 1, 1, NULL, '1_1_Mg0zS4lfDh5XJAKY.png'),
(7, 1, 1, 2, NULL, '0_mOnifxdCpHiV7VTx.mov');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `orderId` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `mobile` varchar(50) NOT NULL,
  `delivery` int(11) NOT NULL,
  `totalAmount` int(11) NOT NULL,
  `data` json NOT NULL,
  `status` int(1) NOT NULL,
  `createdDate` datetime NOT NULL,
  `updatedDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `productId` int(11) NOT NULL,
  `categoryId` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `data` json NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`productId`, `categoryId`, `status`, `data`) VALUES
(1, 1, 1, '{\"size\": [\"L\", \"XL\", \"W\"], \"color\": [\"black\", \"white\"], \"price\": \"100\", \"imageList\": [\"0_h4Am4YB4t2NKdwyO.jpg\"], \"categoryid\": \"1\", \"updateDate\": \"2021-04-19\", \"description\": \"Test<br/>Test<br/>Test\", \"productname\": \"Test product 3\", \"totalquantity\": \"1000\", \"maxqtyperorder\": \"1\"}'),
(2, 1, 1, '{\"size\": [\"L\", \"XL\", \"W\"], \"color\": [\"black\", \"white\"], \"price\": \"100\", \"imageList\": [\"0_ISPOwu1OqmA9J8Sy.jpg\"], \"categoryid\": \"1\", \"updateDate\": \"2021-04-19\", \"description\": \"Test<br/>Test<br/>Test\", \"productname\": \"Test product 2\", \"totalquantity\": \"1\", \"maxqtyperorder\": \"1\"}'),
(3, 1, 1, '{\"size\": [\"L\", \"XL\", \"W\"], \"color\": [\"black\", \"white\"], \"price\": \"100\", \"imageList\": [\"0_gdFbF2ql5rL14lw2.jpg\"], \"categoryid\": \"1\", \"updateDate\": \"2021-04-19\", \"description\": \"Test<br/>Test<br/>Test\", \"productname\": \"Test product 1\", \"totalquantity\": \"1\", \"maxqtyperorder\": \"1\"}');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `countryCode` int(11) NOT NULL,
  `mobile` int(11) NOT NULL,
  `loginName` varchar(50) NOT NULL,
  `password` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `countryCode`, `mobile`, `loginName`, `password`) VALUES
(1, 'Administrator', 852, 60538205, 'admin', '9RcGsomh0mj+iwckTfKXVux5GU+oX9AdwNCUzoODaHne1S24oS0SaGfJydLK5L6EXAp/15RbvIlM8N0SO8y5KA==');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `album`
--
ALTER TABLE `album`
  ADD PRIMARY KEY (`albumId`);

--
-- Indexes for table `albumcategory`
--
ALTER TABLE `albumcategory`
  ADD PRIMARY KEY (`categoryId`);

--
-- Indexes for table `blog`
--
ALTER TABLE `blog`
  ADD PRIMARY KEY (`blogId`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`categoryId`);

--
-- Indexes for table `gallery`
--
ALTER TABLE `gallery`
  ADD PRIMARY KEY (`galleryId`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`orderId`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`productId`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `album`
--
ALTER TABLE `album`
  MODIFY `albumId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `albumcategory`
--
ALTER TABLE `albumcategory`
  MODIFY `categoryId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `blog`
--
ALTER TABLE `blog`
  MODIFY `blogId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `categoryId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `gallery`
--
ALTER TABLE `gallery`
  MODIFY `galleryId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `orderId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `productId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
