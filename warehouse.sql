-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Aug 01, 2016 at 06:01 AM
-- Server version: 5.6.16
-- PHP Version: 5.5.11

-- SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
-- SET time_zone = "+00:00";


-- CREATE TABLE IF NOT EXISTS `warehouse_details` (
--   `product_id` bigint(20) NOT NULL,
--   `product_name` varchar(20) NOT NULL,
--   `quantity` bigint(20) NOT NULL,
--   PRIMARY KEY (`product_id`)
-- ) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- CREATE TABLE IF NOT EXISTS `product` (
--   `product_id` bigint(20) NOT NULL,
--   `product_name` varchar(20) NOT NULL,
--   PRIMARY KEY (`product_id`)
-- ) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- CREATE TABLE IF NOT EXISTS `productprice` (
--   `product_price_id` bigint(20) NOT NULL,
--   `date` date NOT NULL,
--   `product_id` bigint(20) NOT NULL,
--   `price` float(20) NOT NULL,
--   `quantity` bigint(20) NOT NULL,
--   PRIMARY KEY (`product_price_id`)
-- ) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- CREATE TABLE IF NOT EXISTS `restaurant` (
--   `restaurant_id` bigint(20) NOT NULL,
--   `restaurant_name` date NOT NULL,
--   `address`varchar(20) NOT NULL,
--   `mobile` varchar(20) NOT NULL,
--   `quantity` varchar(20) NOT NULL,
--   PRIMARY KEY (`restaurant_id`)
-- ) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- CREATE TABLE IF NOT EXISTS `restaurant_stock` (
--   `restaurant_product_id` bigint(20) NOT NULL,
--   `product_id` bigint(20) NOT NULL,
--   `quantity`bigint(20) NOT NULL,
--   `restaurant_id` bigint(20) NOT NULL,
--   `purchase_date` date NOT NULL,
--   PRIMARY KEY (`restaurant_product_id`)
-- ) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `t_user` (
  `a_id` varchar(50) NOT NULL,
  `a_name` varchar(50) NOT NULL,
  `a_email` varchar(50) NOT NULL,
  `a_pswd` varchar(30) NOT NULL,
  `a_phno` varchar(15) NOT NULL,
  `a_company` varchar(100) NOT NULL,
  PRIMARY KEY (`a_email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t_user`
--

INSERT INTO `t_user` (`a_id`, `a_name`, `a_email`, `a_pswd`, `a_phno`, `a_company`) VALUES
('1', 'visahan', 'sanstechno27@gmail.com', '123', '9831456781', 'Sanstechno');
