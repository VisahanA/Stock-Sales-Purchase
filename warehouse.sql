-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Aug 01, 2016 at 06:01 AM
-- Server version: 5.6.16
-- PHP Version: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `warehouse`
--

-- --------------------------------------------------------

--
-- Table structure for table `log_sup_delete`
--

CREATE TABLE IF NOT EXISTS `log_sup_delete` (
  `s_id` varchar(20) NOT NULL,
  `s_name` varchar(30) NOT NULL,
  `sd_date` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `t_brand`
--

CREATE TABLE IF NOT EXISTS `t_brand` (
  `c_id` varchar(10) NOT NULL,
  `b_id` varchar(10) NOT NULL,
  `b_name` varchar(300) NOT NULL,
  PRIMARY KEY (`b_id`),
  KEY `c_id` (`c_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t_brand`
--

INSERT INTO `t_brand` (`c_id`, `b_id`, `b_name`) VALUES
('C0002', 'B0001', 'HP'),
('C0002', 'B0002', 'Asus'),
('C0002', 'B0003', 'Samsung'),
('C0002', 'B0004', 'Dell'),
('C0002', 'B0005', 'Sony'),
('C0001', 'B0006', 'Infocus'),
('C0001', 'B0007', 'Nokia'),
('C0001', 'B0008', 'Samsung'),
('C0001', 'B0009', 'Sony'),
('C0001', 'B0010', 'Micromax'),
('C0003', 'B0011', 'Micromax'),
('C0003', 'B0012', 'Sony'),
('C0003', 'B0013', 'Karbonn'),
('C0003', 'B0014', 'Lenovo'),
('C0003', 'B0015', 'HTC'),
('C0004', 'B0016', 'Sony'),
('C0004', 'B0017', 'Nikon'),
('C0004', 'B0018', 'Canon'),
('C0004', 'B0019', 'Kodak'),
('C0005', 'B0020', 'Apple'),
('C0005', 'B0021', 'Lenovo'),
('C0005', 'B0022', 'Micromax'),
('C0005', 'B0023', 'Nokia'),
('C0006', 'B0024', 'Samsung'),
('C0006', 'B0025', 'Sony'),
('C0006', 'B0026', 'Reviera'),
('C0007', 'B0028', 'Toshiba'),
('C0007', 'B0029', 'Lenovo'),
('C0007', 'B0030', 'Dell'),
('C0007', 'B0031', 'HP'),
('C0007', 'B0032', 'Asus'),
('C0008', 'B0033', 'Philips'),
('C0008', 'B0034', 'Intex'),
('C0008', 'B0035', 'Sony'),
('C0009', 'B0036', 'Ricoh'),
('C0009', 'B0037', 'Canon'),
('C0009', 'B0038', 'Hitachi'),
('C0009', 'B0039', 'Lenovo'),
('C0010', 'B0040', 'Aerial'),
('C0010', 'B0041', 'Coda'),
('C0010', 'B0042', 'Dakiom');

-- --------------------------------------------------------

--
-- Table structure for table `t_category`
--

CREATE TABLE IF NOT EXISTS `t_category` (
  `c_id` varchar(30) NOT NULL,
  `c_name` varchar(30) NOT NULL,
  PRIMARY KEY (`c_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t_category`
--

INSERT INTO `t_category` (`c_id`, `c_name`) VALUES
('C0001', 'Mobile Phone'),
('C0002', 'Laptop'),
('C0003', 'Tablet'),
('C0004', 'Digital Camera'),
('C0005', 'iPod'),
('C0006', 'Headphone'),
('C0007', 'Battery'),
('C0008', 'Portable Speaker'),
('C0009', 'Printer'),
('C0010', 'Stereo and Hifi');

-- --------------------------------------------------------

--
-- Table structure for table `t_dealer`
--

CREATE TABLE IF NOT EXISTS `t_dealer` (
  `d_id` varchar(50) NOT NULL,
  `d_name` varchar(50) NOT NULL,
  `d_pswd` varchar(50) NOT NULL,
  `d_email` varchar(50) NOT NULL,
  `d_comp` varchar(100) NOT NULL,
  `d_phno` varchar(10) NOT NULL,
  `d_regdate` varchar(20) NOT NULL,
  PRIMARY KEY (`d_email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t_dealer`
--

INSERT INTO `t_dealer` (`d_id`, `d_name`, `d_pswd`, `d_email`, `d_comp`, `d_phno`, `d_regdate`) VALUES
('DEA0002', 'Archana', '123', 'archu@gmail.com', 'Infocus', '1234556789', '07/Jul/2016'),
('DEA0001', 'Monalisa ', '123', 'mona@gmail.com', 'Samsung', '1234567890', '07/Jun/2016'),
('DEA0003', 'Priya', '123', 'priya@gmail.com', 'Asus', '9874664562', '07/Jul/2016');

-- --------------------------------------------------------

--
-- Table structure for table `t_model`
--

CREATE TABLE IF NOT EXISTS `t_model` (
  `c_id` varchar(10) NOT NULL,
  `b_id` varchar(10) NOT NULL,
  `m_id` varchar(10) NOT NULL,
  `m_name` varchar(300) NOT NULL,
  PRIMARY KEY (`m_id`),
  KEY `c_id` (`c_id`),
  KEY `b_id` (`b_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t_model`
--

INSERT INTO `t_model` (`c_id`, `b_id`, `m_id`, `m_name`) VALUES
('C0002', 'B0001', 'M0001', 'HP 14 inch Notebook 14-AF117AU'),
('C0002', 'B0001', 'M0002', 'HP 15.6 inch Notebook 15-AF163AU'),
('C0002', 'B0002', 'M0003', 'Asus Aspire 15.6 inch Notebook ES1-531'),
('C0002', 'B0002', 'M0004', 'Asus Aspire 15.6 inch Notebook ES2-PKL'),
('C0001', 'B0008', 'M0005', 'Samsung Galaxy Note J3'),
('C0001', 'B0008', 'M0006', 'Samsung Galaxy Core GTi8262'),
('C0001', 'B0006', 'M0007', 'Infocus M370i'),
('C0001', 'B0007', 'M0008', 'Nokia 5233'),
('C0001', 'B0009', 'M0009', 'Sony xperia z'),
('C0001', 'B0010', 'M0010', 'Micromax canvas turbo'),
('C0002', 'B0003', 'M0011', 'Samsung RV509'),
('C0002', 'B0003', 'M0012', 'Samsung NT805'),
('C0002', 'B0004', 'M0013', 'Dell inspiron 1545'),
('C0002', 'B0004', 'M0014', 'Dell inspiron 5521'),
('C0002', 'B0005', 'M0015', 'Sony Vaio Fit 15E-SVF15413SNB'),
('C0002', 'B0005', 'M0016', 'Sony Vaio 14-SVE14135CNB'),
('C0003', 'B0011', 'M0017', 'Micromax canvas spark'),
('C0003', 'B0011', 'M0018', 'Micromax canvas P480'),
('C0003', 'B0012', 'M0019', 'Sony Tablet S'),
('C0003', 'B0012', 'M0020', 'Sony Tablet P 3G'),
('C0003', 'B0013', 'M0021', 'karbon Smart Tab 2'),
('C0003', 'B0013', 'M0022', 'karbon Titanium S 15'),
('C0003', 'B0014', 'M0023', 'Lenovo Yoga tab 3'),
('C0003', 'B0014', 'M0024', 'Lenovo tab 2 A&-30'),
('C0003', 'B0015', 'M0025', 'HTC Me tablet'),
('C0003', 'B0015', 'M0026', 'HTC One M7'),
('C0004', 'B0016', 'M0027', 'Sony Cyber Shot'),
('C0004', 'B0016', 'M0028', 'Sony Dsc W830'),
('C0004', 'B0017', 'M0029', 'Nikon Coolpix A1'),
('C0004', 'B0017', 'M0030', 'Nikon Coolpix B500'),
('C0004', 'B0018', 'M0031', 'Canon Ixus 170'),
('C0004', 'B0018', 'M0032', 'Canon SX710 HS'),
('C0004', 'B0019', 'M0033', 'kodak C713'),
('C0004', 'B0019', 'M0034', 'Kodak pixpro'),
('C0005', 'B0020', 'M0035', 'Apple ipod Suffle'),
('C0005', 'B0020', 'M0036', 'Apple ipod Touch'),
('C0005', 'B0021', 'M0037', 'Lenovo IdeaTab S2110A'),
('C0005', 'B0021', 'M0038', 'Lenovo IdeaTab A1000'),
('C0005', 'B0022', 'M0039', 'Micromax Canvas P480'),
('C0005', 'B0022', 'M0040', 'Micromax Canvas Z460'),
('C0005', 'B0023', 'M0041', 'Nokia X200'),
('C0005', 'B0023', 'M0042', 'Nokia C3'),
('C0006', 'B0024', 'M0043', 'Samsung EH651'),
('C0006', 'B0024', 'M0045', 'Samsung beat DJ'),
('C0006', 'B0025', 'M0046', 'Sony MDR 110'),
('C0006', 'B0025', 'M0047', 'Sony Ex'),
('C0006', 'B0026', 'M0049', 'Riviera Stereo'),
('C0006', 'B0026', 'M0050', 'Riviera Super Bass'),
('C0007', 'B0028', 'M0051', 'Toshiba Satellite C840'),
('C0007', 'B0028', 'M0052', 'Toshiba Satellite L840D'),
('C0007', 'B0029', 'M0053', 'Lenovo G450'),
('C0007', 'B0029', 'M0054', 'Lenovo G530'),
('C0007', 'B0030', 'M0055', 'Dell Inspiron 1440'),
('C0007', 'B0030', 'M0056', 'Dell Inspiron N5010'),
('C0007', 'B0031', 'M0057', 'HP MU06'),
('C0007', 'B0031', 'M0058', 'HP MT06'),
('C0007', 'B0032', 'M0059', 'Battery Asus Vx6'),
('C0007', 'B0032', 'M0060', 'Battery Asus A32-K53'),
('C0008', 'B0033', 'M0061', 'Philips spa 50'),
('C0008', 'B0033', 'M0062', 'Philips Explode'),
('C0008', 'B0034', 'M0063', 'Intex It-shine'),
('C0008', 'B0034', 'M0064', 'Intex It-881U'),
('C0008', 'B0035', 'M0065', 'Sony srs X-2'),
('C0008', 'B0035', 'M0066', 'Sony srs-X11'),
('C0009', 'B0036', 'M0067', 'Ricoh Sp111'),
('C0009', 'B0036', 'M0068', 'Ricoh SP210SU'),
('C0009', 'B0037', 'M0069', 'Canon Pixma G 2000'),
('C0009', 'B0037', 'M0070', 'Canon Lasershot Mono'),
('C0009', 'B0038', 'M0071', 'Hitchi RX2 Series'),
('C0009', 'B0038', 'M0072', 'Hitachi Inkjet Printers'),
('C0009', 'B0039', 'M0073', 'Lenovo Deskjet J510a'),
('C0009', 'B0039', 'M0074', 'Lenovo Deskjet CA509'),
('C0010', 'B0040', 'M0075', 'Aerial Stereo Mono P'),
('C0010', 'B0040', 'M0076', 'Aerial Stereo Mono A1'),
('C0010', 'B0041', 'M0077', 'STEREO AMPLIFIER - S'),
('C0010', 'B0041', 'M0078', 'Stereo Amplifier S12.5'),
('C0010', 'B0042', 'M0079', 'DakiOm HR 203'),
('C0010', 'B0042', 'M0080', 'DakiOm R203');

-- --------------------------------------------------------

--
-- Table structure for table `t_product`
--

CREATE TABLE IF NOT EXISTS `t_product` (
  `p_id` varchar(50) NOT NULL,
  `p_name` varchar(50) NOT NULL,
  `p_desc` varchar(500) NOT NULL,
  `p_brand` varchar(500) NOT NULL,
  `p_cost` int(20) NOT NULL,
  `p_quantity` int(20) NOT NULL,
  `tot_cost` int(20) NOT NULL,
  PRIMARY KEY (`p_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t_product`
--

INSERT INTO `t_product` (`p_id`, `p_name`, `p_desc`, `p_brand`, `p_cost`, `p_quantity`, `tot_cost`) VALUES
('PRD0001', 'Laptop', 'Infocus M370i', 'Infocus', 50000, 3, 150000),
('PRD0005', 'Tablet', 'Sony Tablet P 3G', 'Sony', 40000, 3, 120000),
('PRD0006', 'Mobile Phone', 'Micromax canvas turbo', 'Micromax', 8999, 3, 26997),
('PRD0007', 'Stereo and Hifi', 'DakiOm R203', 'Dakiom', 20000, 3, 60000),
('PRD0010', 'Tablet', 'karbon Titanium S 15', 'Karbonn', 50000, 30, 1500000),
('PRD0011', 'Printer', 'Hitachi Inkjet Printers', 'Hitachi', 1000, 8, 8000),
('PRD0012', 'iPod', 'Micromax Canvas Z460', 'Micromax', 4866, 8, 38928);

-- --------------------------------------------------------

--
-- Table structure for table `t_purtrans`
--

CREATE TABLE IF NOT EXISTS `t_purtrans` (
  `p_id` varchar(50) NOT NULL,
  `s_email` varchar(50) NOT NULL,
  `p_tdate` varchar(20) NOT NULL,
  KEY `p_id` (`p_id`),
  KEY `s_id` (`s_email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t_purtrans`
--

INSERT INTO `t_purtrans` (`p_id`, `s_email`, `p_tdate`) VALUES
('PRD0001', 'dilraj@gmail.com', '10/Mar/2016'),
('PRD0005', 'rash@gmail.com', '07/Jul/2016'),
('PRD0006', 'rash@gmail.com', '07/Jul/2016'),
('PRD0007', 'dilraj@gmail.com', '07/Jul/2016'),
('PRD0010', 'ankita@gmail.com', '31/Jul/2016'),
('PRD0011', 'rash@gmail.com', '31/Jul/2016'),
('PRD0012', 'ankita@gmail.com', '31/Jul/2016');

-- --------------------------------------------------------

--
-- Table structure for table `t_saletrans`
--

CREATE TABLE IF NOT EXISTS `t_saletrans` (
  `p_sid` varchar(50) NOT NULL,
  `d_email` varchar(50) NOT NULL,
  `s_tdate` varchar(20) NOT NULL,
  KEY `p_id` (`p_sid`),
  KEY `d_id` (`d_email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `t_soldprd`
--

CREATE TABLE IF NOT EXISTS `t_soldprd` (
  `p_sid` varchar(10) NOT NULL,
  `p_sname` varchar(50) NOT NULL,
  `p_sdesc` varchar(50) NOT NULL,
  `p_sbrand` varchar(60) NOT NULL,
  `p_scost` varchar(10) NOT NULL,
  `p_squantity` varchar(10) NOT NULL,
  `p_stot_cost` varchar(10) NOT NULL,
  PRIMARY KEY (`p_sid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `t_supplier`
--

CREATE TABLE IF NOT EXISTS `t_supplier` (
  `s_id` varchar(50) NOT NULL,
  `s_name` varchar(50) NOT NULL,
  `s_pswd` varchar(50) NOT NULL,
  `s_email` varchar(100) NOT NULL,
  `s_phno` varchar(12) NOT NULL,
  `s_comp` varchar(100) NOT NULL,
  `s_regdate` varchar(20) NOT NULL,
  PRIMARY KEY (`s_email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t_supplier`
--

INSERT INTO `t_supplier` (`s_id`, `s_name`, `s_pswd`, `s_email`, `s_phno`, `s_comp`, `s_regdate`) VALUES
('SUP0003', 'Ankita', '123', 'ankita@gmail.com', '9001293922', 'Dell', '07/Jul/2016'),
('SUP0001', 'Dilraj', '123', 'dilraj@gmail.com', '1234567890', 'Infocus', '07/Jul/2016'),
('SUP0002', 'Rashmi', '123', 'rash@gmail.com', '1234567890', 'Samsung', '06/Jun/2016');

-- --------------------------------------------------------

--
-- Table structure for table `t_user`
--

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
('1', 'samita', 'samita@gmail.com', '123', '9831456781', 'samsung');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `t_brand`
--
ALTER TABLE `t_brand`
  ADD CONSTRAINT `t_brand_ibfk_1` FOREIGN KEY (`c_id`) REFERENCES `t_category` (`c_id`);

--
-- Constraints for table `t_model`
--
ALTER TABLE `t_model`
  ADD CONSTRAINT `t_model_ibfk_1` FOREIGN KEY (`c_id`) REFERENCES `t_category` (`c_id`),
  ADD CONSTRAINT `t_model_ibfk_2` FOREIGN KEY (`b_id`) REFERENCES `t_brand` (`b_id`);

--
-- Constraints for table `t_purtrans`
--
ALTER TABLE `t_purtrans`
  ADD CONSTRAINT `t_purtrans_ibfk_1` FOREIGN KEY (`p_id`) REFERENCES `t_product` (`p_id`),
  ADD CONSTRAINT `t_purtrans_ibfk_2` FOREIGN KEY (`s_email`) REFERENCES `t_supplier` (`s_email`);

--
-- Constraints for table `t_saletrans`
--
ALTER TABLE `t_saletrans`
  ADD CONSTRAINT `t_saletrans_ibfk_3` FOREIGN KEY (`p_sid`) REFERENCES `t_soldprd` (`p_sid`),
  ADD CONSTRAINT `t_saletrans_ibfk_2` FOREIGN KEY (`d_email`) REFERENCES `t_dealer` (`d_email`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
