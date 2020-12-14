-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 15, 2020 at 11:04 AM
-- Server version: 10.4.6-MariaDB
-- PHP Version: 7.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bintangkelindocemerlang`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin2`
--

CREATE TABLE `admin2` (
  `IDadmin` char(6) NOT NULL,
  `NAMAadmin` char(25) NOT NULL,
  `PASSWORDadmin` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `admin2`
--

INSERT INTO `admin2` (`IDadmin`, `NAMAadmin`, `PASSWORDadmin`, `role`) VALUES
('ADM001', 'admin', 'ac43724f16e9241d990427ab7c8f4228', ''),
('ADM002', 'fico', '81dc9bdb52d04dc20036dbd8313ed055', 'admin'),
('ADM003', 'henry', 'd0970714757783e6cf17b26fb8e2298f', 'user1'),
('ADM004', 'steven', 'd0970714757783e6cf17b26fb8e2298f', 'user2');

-- --------------------------------------------------------

--
-- Table structure for table `bahanbaku`
--

CREATE TABLE `bahanbaku` (
  `id` int(11) NOT NULL,
  `bahanbakuKODE` char(6) NOT NULL,
  `bahanbakuNAMA` varchar(255) NOT NULL,
  `qty` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `totalprice` int(11) NOT NULL,
  `lastUPDATE` datetime NOT NULL,
  `adminKODE` char(6) NOT NULL,
  `partnerKODE` char(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bahanbaku`
--

INSERT INTO `bahanbaku` (`id`, `bahanbakuKODE`, `bahanbakuNAMA`, `qty`, `price`, `totalprice`, `lastUPDATE`, `adminKODE`, `partnerKODE`) VALUES
(1, 'BBB001', 'Karet bahan', 4, 10000, 40000, '2020-10-24 11:24:42', 'ADM004', 'PRT002'),
(2, 'BBB002', 'Karet', 4, 10000, 40000, '2020-10-24 11:26:07', 'ADM003', 'PRT002');

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `id` int(11) NOT NULL,
  `barangKODE` varchar(6) NOT NULL,
  `barangNAMA` varchar(255) DEFAULT NULL,
  `karton` int(11) DEFAULT NULL,
  `isi` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `harga` int(11) DEFAULT NULL,
  `totalHARGA` int(11) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `lastUPDATE` datetime NOT NULL,
  `adminKODE` char(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`id`, `barangKODE`, `barangNAMA`, `karton`, `isi`, `quantity`, `harga`, `totalHARGA`, `foto`, `lastUPDATE`, `adminKODE`) VALUES
(1, 'BTG111', 'Mobil Truk', 110, 3, 330, 10000, 3300000, 'WhatsApp Image 2020-09-25 at 16.57.04.jpeg', '2020-11-15 17:00:26', 'ADM003');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `customerKODE` varchar(6) NOT NULL DEFAULT '0',
  `customerNAME` varchar(30) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `phoneNUMBER1` varchar(20) DEFAULT NULL,
  `phoneNUMBER2` varchar(20) DEFAULT NULL,
  `address` mediumtext DEFAULT NULL,
  `lastUPDATE` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`customerKODE`, `customerNAME`, `email`, `phoneNUMBER1`, `phoneNUMBER2`, `address`, `lastUPDATE`) VALUES
('CST004', 'henry', 'henry@gmail.com', '2147483647', '0', 'Jalan Mangga', '0000-00-00 00:00:00'),
('CST005', 'Friederich Gang', 'friederich@gmail.co.', '+6281285158530', '0', 'Kelapa Gading', '0000-00-00 00:00:00'),
('CST008', 'Friederich', 'friederich@gmail.com', '+6281285158530', '+6281285158530', 'jl angklung', '0000-00-00 00:00:00'),
('CST009', 'Friederichsss', 'henry@gmail.com', '+6281285158530', '+6281285158530', 'jl angklung', '2020-10-03 14:21:21');

--
-- Triggers `customer`
--
DELIMITER $$
CREATE TRIGGER `customer_log_delete` AFTER DELETE ON `customer` FOR EACH ROW BEGIN
  INSERT INTO customer_log 
  VALUES('Delete', NOW(), OLD.customerKODE, OLD.customerNAME, OLD.email, OLD.phoneNUMBER1, OLD.phoneNUMBER2 , OLD.address);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `customer_log_insert` AFTER INSERT ON `customer` FOR EACH ROW BEGIN
  INSERT INTO customer_log 
  VALUES('Insert', NOW(), NEW.customerKODE, NEW.customerNAME, NEW.email, NEW.phoneNUMBER1, NEW.phoneNUMBER2 , NEW.address);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `customer_log_update` AFTER UPDATE ON `customer` FOR EACH ROW BEGIN
  INSERT INTO customer_log 
  VALUES('Update', NOW(), NEW.customerKODE, NEW.customerNAME, NEW.email, NEW.phoneNUMBER1, NEW.phoneNUMBER2 , NEW.address);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `tg_customer_insert` BEFORE INSERT ON `customer` FOR EACH ROW BEGIN
  INSERT INTO customer_seq VALUES (NULL);
  SET NEW.customerKODE = CONCAT('CST', LPAD(LAST_INSERT_ID(), 3, '0'));
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `customer_log`
--

CREATE TABLE `customer_log` (
  `action` varchar(255) DEFAULT NULL,
  `action_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `customerKODE` varchar(6) DEFAULT NULL,
  `customerNAME` varchar(30) DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `phoneNUMBER1` varchar(20) DEFAULT NULL,
  `phoneNUMBER2` varchar(20) DEFAULT NULL,
  `address` mediumtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer_log`
--

INSERT INTO `customer_log` (`action`, `action_time`, `customerKODE`, `customerNAME`, `email`, `phoneNUMBER1`, `phoneNUMBER2`, `address`) VALUES
('Delete', '2020-09-27 10:19:01', 'CST006', 'Test2', 'henry@gmail.com', '+6281285158530', '+6281285158530', 'jl angklung'),
('Insert', '2020-10-03 07:14:13', 'CST008', 'Friederich', 'friederich@gmail.com', '+6281285158530', '+6281285158530', 'jl angklung'),
('Insert', '2020-10-03 07:21:21', 'CST009', 'Friederichsss', 'henry@gmail.com', '+6281285158530', '+6281285158530', 'jl angklung');

-- --------------------------------------------------------

--
-- Table structure for table `customer_seq`
--

CREATE TABLE `customer_seq` (
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer_seq`
--

INSERT INTO `customer_seq` (`id`) VALUES
(1),
(2),
(3),
(4),
(5),
(6),
(7),
(8),
(9);

-- --------------------------------------------------------

--
-- Table structure for table `detailorder`
--

CREATE TABLE `detailorder` (
  `detailorderKODE` varchar(6) NOT NULL DEFAULT '0',
  `barangKODE` char(6) DEFAULT NULL,
  `karton` int(11) DEFAULT NULL,
  `totalprice` int(11) DEFAULT NULL,
  `pesananKODE` char(6) DEFAULT NULL,
  `adminKODE` char(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `detailorder`
--

INSERT INTO `detailorder` (`detailorderKODE`, `barangKODE`, `karton`, `totalprice`, `pesananKODE`, `adminKODE`) VALUES
('DOR007', 'BTG111', 4, 40000, 'ORD002', ''),
('DOR008', 'BTG111', 2, 20000, 'ORD002', ''),
('DOR009', 'BTG111', 2, 20000, 'ORD002', ''),
('DOR010', 'BTG111', 1, 10000, 'ORD002', ''),
('DOR011', 'BTG111', 2, 20000, 'ORD002', ''),
('DOR012', 'BTG111', 2, 20000, 'ORD002', ''),
('DOR013', 'BTG111', 3, 30000, 'ORD003', '');

--
-- Triggers `detailorder`
--
DELIMITER $$
CREATE TRIGGER `tg_detailorder_insert` BEFORE INSERT ON `detailorder` FOR EACH ROW BEGIN
  INSERT INTO detailorder_seq VALUES (NULL);
  SET NEW.detailorderKODE = CONCAT('DOR', LPAD(LAST_INSERT_ID(), 3, '0'));
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `detailorder_seq`
--

CREATE TABLE `detailorder_seq` (
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `detailorder_seq`
--

INSERT INTO `detailorder_seq` (`id`) VALUES
(1),
(2),
(3),
(4),
(5),
(6),
(7),
(8),
(9),
(10),
(11),
(12),
(13),
(14);

-- --------------------------------------------------------

--
-- Table structure for table `detailpembelian`
--

CREATE TABLE `detailpembelian` (
  `detailpembelianKODE` varchar(6) NOT NULL DEFAULT '0',
  `bahanbakuKODE` char(6) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `totalprice` int(11) DEFAULT NULL,
  `pembelianKODE` char(6) DEFAULT NULL,
  `adminKODE` char(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `detailpembelian`
--

INSERT INTO `detailpembelian` (`detailpembelianKODE`, `bahanbakuKODE`, `qty`, `totalprice`, `pembelianKODE`, `adminKODE`) VALUES
('DPE002', 'BBB001', 5, 50000, 'BUY001', 'ADM002');

--
-- Triggers `detailpembelian`
--
DELIMITER $$
CREATE TRIGGER `tg_detailpembelian_insert` BEFORE INSERT ON `detailpembelian` FOR EACH ROW BEGIN
  INSERT INTO detailpembelian_seq VALUES (NULL);
  SET NEW.detailpembelianKODE = CONCAT('DPE', LPAD(LAST_INSERT_ID(), 3, '0'));
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `detailpembelian_seq`
--

CREATE TABLE `detailpembelian_seq` (
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `detailpembelian_seq`
--

INSERT INTO `detailpembelian_seq` (`id`) VALUES
(1),
(2);

-- --------------------------------------------------------

--
-- Table structure for table `detailreturpenj`
--

CREATE TABLE `detailreturpenj` (
  `drpKODE` varchar(6) NOT NULL DEFAULT '0',
  `drpKARTON` int(11) DEFAULT NULL,
  `drpTOTALHARGA` int(11) DEFAULT NULL,
  `returpenjualanKODE` char(6) DEFAULT NULL,
  `barangKODE` char(6) DEFAULT NULL,
  `keterangan` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `detailreturpenj`
--

INSERT INTO `detailreturpenj` (`drpKODE`, `drpKARTON`, `drpTOTALHARGA`, `returpenjualanKODE`, `barangKODE`, `keterangan`) VALUES
('DRP001', 2, 20000, 'REP001', 'BTG111', 'rusak');

--
-- Triggers `detailreturpenj`
--
DELIMITER $$
CREATE TRIGGER `tg_detailreturpenj_insert` BEFORE INSERT ON `detailreturpenj` FOR EACH ROW BEGIN
  INSERT INTO detailreturpenj_seq VALUES (NULL);
  SET NEW.drpKODE = CONCAT('DRP', LPAD(LAST_INSERT_ID(), 3, '0'));
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `detailreturpenj_seq`
--

CREATE TABLE `detailreturpenj_seq` (
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `detailreturpenj_seq`
--

INSERT INTO `detailreturpenj_seq` (`id`) VALUES
(1);

-- --------------------------------------------------------

--
-- Table structure for table `jenispartner`
--

CREATE TABLE `jenispartner` (
  `jenispartnerKODE` varchar(6) NOT NULL DEFAULT '0',
  `jenispartnerNAME` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jenispartner`
--

INSERT INTO `jenispartner` (`jenispartnerKODE`, `jenispartnerNAME`) VALUES
('JPR001', 'Customer'),
('JPR002', 'Supplier');

--
-- Triggers `jenispartner`
--
DELIMITER $$
CREATE TRIGGER `tg_jenispartner_insert` BEFORE INSERT ON `jenispartner` FOR EACH ROW BEGIN
  INSERT INTO jenispartner_seq VALUES (NULL);
  SET NEW.jenispartnerKODE = CONCAT('JPR', LPAD(LAST_INSERT_ID(), 3, '0'));
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `jenispartner_seq`
--

CREATE TABLE `jenispartner_seq` (
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jenispartner_seq`
--

INSERT INTO `jenispartner_seq` (`id`) VALUES
(1),
(2),
(4);

-- --------------------------------------------------------

--
-- Table structure for table `karyawan`
--

CREATE TABLE `karyawan` (
  `karyawanKODE` varchar(6) NOT NULL DEFAULT '0',
  `karyawanNAMA` varchar(30) DEFAULT NULL,
  `email` varchar(30) DEFAULT NULL,
  `phoneNUMBER1` varchar(30) DEFAULT NULL,
  `phoneNUMBER2` varchar(30) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `role` varchar(30) DEFAULT NULL,
  `adminKODE` char(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `karyawan`
--

INSERT INTO `karyawan` (`karyawanKODE`, `karyawanNAMA`, `email`, `phoneNUMBER1`, `phoneNUMBER2`, `address`, `role`, `adminKODE`) VALUES
('KRY001', 'Friederich', 'friederich@gmail.coms', '+6281285158532', '+6281285158531', 'jl angklung', 'Sales', 'ADM003');

--
-- Triggers `karyawan`
--
DELIMITER $$
CREATE TRIGGER `tg_karyawan_insert` BEFORE INSERT ON `karyawan` FOR EACH ROW BEGIN
  INSERT INTO karyawan_seq VALUES (NULL);
  SET NEW.karyawanKODE = CONCAT('KRY', LPAD(LAST_INSERT_ID(), 3, '0'));
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `karyawan_seq`
--

CREATE TABLE `karyawan_seq` (
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `karyawan_seq`
--

INSERT INTO `karyawan_seq` (`id`) VALUES
(1);

-- --------------------------------------------------------

--
-- Table structure for table `partner`
--

CREATE TABLE `partner` (
  `partnerKODE` char(6) NOT NULL,
  `partnerNAME` varchar(255) NOT NULL,
  `partnerADDRESS` varchar(255) NOT NULL,
  `partnerEMAIL` varchar(50) NOT NULL,
  `partnerPHONE` varchar(20) NOT NULL,
  `jenispartnerKODE` char(6) NOT NULL,
  `adminKODE` char(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `partner`
--

INSERT INTO `partner` (`partnerKODE`, `partnerNAME`, `partnerADDRESS`, `partnerEMAIL`, `partnerPHONE`, `jenispartnerKODE`, `adminKODE`) VALUES
('PRT002', 'henry', 'Jl Mangga', 'full.name@gmail.com', '0808080808', 'JPR002', 'ADM003');

--
-- Triggers `partner`
--
DELIMITER $$
CREATE TRIGGER `tg_partner_insert` BEFORE INSERT ON `partner` FOR EACH ROW BEGIN
  INSERT INTO partner_seq VALUES (NULL);
  SET NEW.partnerKODE = CONCAT('PRT', LPAD(LAST_INSERT_ID(), 3, '0'));
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `partner_seq`
--

CREATE TABLE `partner_seq` (
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `partner_seq`
--

INSERT INTO `partner_seq` (`id`) VALUES
(1),
(2);

-- --------------------------------------------------------

--
-- Table structure for table `pembelian`
--

CREATE TABLE `pembelian` (
  `pembelianKODE` varchar(6) NOT NULL DEFAULT '0',
  `partnerKODE` char(6) DEFAULT NULL,
  `tanggalORDER` date DEFAULT NULL,
  `grandtotal` int(11) DEFAULT NULL,
  `adminKODE` char(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pembelian`
--

INSERT INTO `pembelian` (`pembelianKODE`, `partnerKODE`, `tanggalORDER`, `grandtotal`, `adminKODE`) VALUES
('BUY001', 'PRT002', '2020-09-10', 50000, 'ADM003');

--
-- Triggers `pembelian`
--
DELIMITER $$
CREATE TRIGGER `tg_pembelian_insert` BEFORE INSERT ON `pembelian` FOR EACH ROW BEGIN
  INSERT INTO pembelian_seq VALUES (NULL);
  SET NEW.pembelianKODE = CONCAT('BUY', LPAD(LAST_INSERT_ID(), 3, '0'));
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `pembelian_seq`
--

CREATE TABLE `pembelian_seq` (
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pembelian_seq`
--

INSERT INTO `pembelian_seq` (`id`) VALUES
(1);

-- --------------------------------------------------------

--
-- Table structure for table `pesanan`
--

CREATE TABLE `pesanan` (
  `orderKODE` varchar(6) NOT NULL DEFAULT '0',
  `customerKODE` char(6) DEFAULT NULL,
  `tanggalORDER` date DEFAULT NULL,
  `grandtotal` int(11) NOT NULL,
  `paymentdue` int(11) NOT NULL,
  `karyawanKODE` char(6) NOT NULL,
  `adminKODE` char(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pesanan`
--

INSERT INTO `pesanan` (`orderKODE`, `customerKODE`, `tanggalORDER`, `grandtotal`, `paymentdue`, `karyawanKODE`, `adminKODE`) VALUES
('ORD002', 'PRT001', '2020-01-10', 130000, 45, 'KRY001', 'ADM003');

--
-- Triggers `pesanan`
--
DELIMITER $$
CREATE TRIGGER `tg_pesanan_insert` BEFORE INSERT ON `pesanan` FOR EACH ROW BEGIN
  INSERT INTO pesanan_seq VALUES (NULL);
  SET NEW.orderKODE = CONCAT('ORD', LPAD(LAST_INSERT_ID(), 3, '0'));
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `pesanan_seq`
--

CREATE TABLE `pesanan_seq` (
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pesanan_seq`
--

INSERT INTO `pesanan_seq` (`id`) VALUES
(1),
(2),
(3),
(4),
(5),
(6),
(7);

-- --------------------------------------------------------

--
-- Table structure for table `returpenjualan`
--

CREATE TABLE `returpenjualan` (
  `returpenjualanKODE` char(6) NOT NULL DEFAULT '0',
  `returDATE` date DEFAULT NULL,
  `returTOTALHARGA` int(11) DEFAULT NULL,
  `orderKODE` char(6) DEFAULT NULL,
  `adminKODE` char(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `returpenjualan`
--

INSERT INTO `returpenjualan` (`returpenjualanKODE`, `returDATE`, `returTOTALHARGA`, `orderKODE`, `adminKODE`) VALUES
('REP001', '2020-04-11', 20000, 'ORD002', 'ADM003');

--
-- Triggers `returpenjualan`
--
DELIMITER $$
CREATE TRIGGER `tg_returpenjualan_insert` BEFORE INSERT ON `returpenjualan` FOR EACH ROW BEGIN
  INSERT INTO returpenjualan_seq VALUES (NULL);
  SET NEW.returpenjualanKODE = CONCAT('REP', LPAD(LAST_INSERT_ID(), 3, '0'));
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `returpenjualan_seq`
--

CREATE TABLE `returpenjualan_seq` (
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `returpenjualan_seq`
--

INSERT INTO `returpenjualan_seq` (`id`) VALUES
(1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin2`
--
ALTER TABLE `admin2`
  ADD PRIMARY KEY (`IDadmin`) USING BTREE;

--
-- Indexes for table `bahanbaku`
--
ALTER TABLE `bahanbaku`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_bahanbaku_adminkode` (`adminKODE`);

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_barang_adminkode` (`adminKODE`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`customerKODE`);

--
-- Indexes for table `customer_seq`
--
ALTER TABLE `customer_seq`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `detailorder`
--
ALTER TABLE `detailorder`
  ADD PRIMARY KEY (`detailorderKODE`);

--
-- Indexes for table `detailorder_seq`
--
ALTER TABLE `detailorder_seq`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `detailpembelian`
--
ALTER TABLE `detailpembelian`
  ADD PRIMARY KEY (`detailpembelianKODE`);

--
-- Indexes for table `detailpembelian_seq`
--
ALTER TABLE `detailpembelian_seq`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `detailreturpenj`
--
ALTER TABLE `detailreturpenj`
  ADD PRIMARY KEY (`drpKODE`);

--
-- Indexes for table `detailreturpenj_seq`
--
ALTER TABLE `detailreturpenj_seq`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jenispartner`
--
ALTER TABLE `jenispartner`
  ADD PRIMARY KEY (`jenispartnerKODE`);

--
-- Indexes for table `jenispartner_seq`
--
ALTER TABLE `jenispartner_seq`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `karyawan`
--
ALTER TABLE `karyawan`
  ADD PRIMARY KEY (`karyawanKODE`);

--
-- Indexes for table `karyawan_seq`
--
ALTER TABLE `karyawan_seq`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `partner`
--
ALTER TABLE `partner`
  ADD PRIMARY KEY (`partnerKODE`);

--
-- Indexes for table `partner_seq`
--
ALTER TABLE `partner_seq`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pembelian`
--
ALTER TABLE `pembelian`
  ADD PRIMARY KEY (`pembelianKODE`);

--
-- Indexes for table `pembelian_seq`
--
ALTER TABLE `pembelian_seq`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`orderKODE`);

--
-- Indexes for table `pesanan_seq`
--
ALTER TABLE `pesanan_seq`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `returpenjualan`
--
ALTER TABLE `returpenjualan`
  ADD PRIMARY KEY (`returpenjualanKODE`);

--
-- Indexes for table `returpenjualan_seq`
--
ALTER TABLE `returpenjualan_seq`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bahanbaku`
--
ALTER TABLE `bahanbaku`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `barang`
--
ALTER TABLE `barang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `customer_seq`
--
ALTER TABLE `customer_seq`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `detailorder_seq`
--
ALTER TABLE `detailorder_seq`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `detailpembelian_seq`
--
ALTER TABLE `detailpembelian_seq`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `detailreturpenj_seq`
--
ALTER TABLE `detailreturpenj_seq`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `jenispartner_seq`
--
ALTER TABLE `jenispartner_seq`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `karyawan_seq`
--
ALTER TABLE `karyawan_seq`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `partner_seq`
--
ALTER TABLE `partner_seq`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pembelian_seq`
--
ALTER TABLE `pembelian_seq`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pesanan_seq`
--
ALTER TABLE `pesanan_seq`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `returpenjualan_seq`
--
ALTER TABLE `returpenjualan_seq`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bahanbaku`
--
ALTER TABLE `bahanbaku`
  ADD CONSTRAINT `FK_bahanbaku_adminkode` FOREIGN KEY (`adminKODE`) REFERENCES `admin2` (`IDadmin`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `barang`
--
ALTER TABLE `barang`
  ADD CONSTRAINT `FK_barang_adminkode` FOREIGN KEY (`adminKODE`) REFERENCES `admin2` (`IDadmin`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
