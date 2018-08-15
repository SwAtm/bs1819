-- phpMyAdmin SQL Dump
-- version 4.2.12deb2+deb8u2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 15, 2018 at 02:47 PM
-- Server version: 5.5.60-0+deb8u1
-- PHP Version: 5.6.33-0+deb8u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `bs1718`
--

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE IF NOT EXISTS `company` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `add1` varchar(50) NOT NULL,
  `city` varchar(50) NOT NULL,
  `gstno` varchar(14) NOT NULL,
  `from_date` date NOT NULL,
  `to_date` date NOT NULL,
  `Current` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `details`
--

CREATE TABLE IF NOT EXISTS `details` (
`id` int(11) NOT NULL,
  `summary_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `quantity` int(10) NOT NULL,
  `discount` decimal(11,2) NOT NULL,
  `cashdisc` decimal(11,2) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=596 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE IF NOT EXISTS `inventory` (
  `location_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `opbal` int(11) NOT NULL,
  `purchase` int(11) NOT NULL,
  `sreturn` int(11) NOT NULL,
  `sales` int(11) NOT NULL,
  `preturn` int(11) NOT NULL,
  `clbal` int(11) NOT NULL,
  `stock` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `item`
--

CREATE TABLE IF NOT EXISTS `item` (
`id` int(11) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `code` varchar(10) NOT NULL,
  `rate` decimal(10,2) NOT NULL,
  `title` varchar(50) NOT NULL,
  `party_id` int(11) NOT NULL,
  `hsn` varchar(8) NOT NULL,
  `grate` decimal(5,2) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `item_cat`
--

CREATE TABLE IF NOT EXISTS `item_cat` (
`id` int(11) NOT NULL,
  `code` varchar(3) NOT NULL,
  `name` varchar(30) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE IF NOT EXISTS `locations` (
`id` int(11) NOT NULL,
  `code` varchar(5) NOT NULL,
  `description` varchar(30) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `op_bal`
--

CREATE TABLE IF NOT EXISTS `op_bal` (
`id` int(11) NOT NULL,
  `location_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `cost` decimal(11,2) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `party`
--

CREATE TABLE IF NOT EXISTS `party` (
`id` int(11) NOT NULL,
  `code` varchar(10) NOT NULL,
  `name` varchar(40) NOT NULL,
  `add1` varchar(40) NOT NULL,
  `add2` varchar(40) NOT NULL,
  `city` varchar(20) NOT NULL,
  `pin` varchar(6) NOT NULL,
  `email` varchar(50) NOT NULL,
  `i_e` varchar(1) NOT NULL,
  `st` varchar(1) NOT NULL,
  `gstno` varchar(14) NOT NULL,
  `remark` varchar(50) NOT NULL,
  `status` varchar(4) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1051 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `proforma_details`
--

CREATE TABLE IF NOT EXISTS `proforma_details` (
`id` int(11) NOT NULL,
  `p_sum_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=240 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `proforma_summary`
--

CREATE TABLE IF NOT EXISTS `proforma_summary` (
`id` int(11) NOT NULL,
  `date` date NOT NULL,
  `party_id` int(11) NOT NULL,
  `o_i` varchar(4) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `stock`
--

CREATE TABLE IF NOT EXISTS `stock` (
  `location` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `summary`
--

CREATE TABLE IF NOT EXISTS `summary` (
`id` int(11) NOT NULL,
  `tran_type_id` int(11) NOT NULL,
  `tr_code` varchar(6) NOT NULL,
  `tr_no` int(5) NOT NULL,
  `date` date NOT NULL,
  `party_id` int(11) NOT NULL,
  `expenses` decimal(10,2) NOT NULL,
  `remark` varchar(30) NOT NULL,
  `p_status` varchar(4) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=223 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `temp_bill`
--

CREATE TABLE IF NOT EXISTS `temp_bill` (
  `grate` decimal(5,2) NOT NULL,
  `tr_val` decimal(10,2) NOT NULL,
  `val` decimal(10,2) NOT NULL,
  `gst` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `temp_billwise`
--

CREATE TABLE IF NOT EXISTS `temp_billwise` (
  `tr_code` varchar(6) NOT NULL,
  `tr_no` int(5) NOT NULL,
  `date` date NOT NULL,
  `code` varchar(10) NOT NULL,
  `name` varchar(40) NOT NULL,
  `city` varchar(20) NOT NULL,
  `expenses` decimal(10,2) NOT NULL,
  `amount_b` decimal(10,2) NOT NULL,
  `amount_r` decimal(10,2) NOT NULL,
  `igst` decimal(10,2) NOT NULL,
  `cgst` decimal(10,2) NOT NULL,
  `sgst` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `temp_details`
--

CREATE TABLE IF NOT EXISTS `temp_details` (
`id` int(11) NOT NULL,
  `summary_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `quantity` int(10) NOT NULL,
  `discount` decimal(11,2) NOT NULL,
  `cashdisc` decimal(11,2) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=128 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tran_type`
--

CREATE TABLE IF NOT EXISTS `tran_type` (
`id` int(11) NOT NULL,
  `tr_code` varchar(5) NOT NULL,
  `descrip_1` varchar(10) NOT NULL,
  `descrip_2` varchar(10) NOT NULL,
  `remark` int(11) DEFAULT NULL,
  `location` varchar(30) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `trnf_details`
--

CREATE TABLE IF NOT EXISTS `trnf_details` (
`id` int(11) NOT NULL,
  `summ_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=135 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `trnf_summary`
--

CREATE TABLE IF NOT EXISTS `trnf_summary` (
`id` int(11) NOT NULL,
  `date` date NOT NULL,
  `from_id` int(11) NOT NULL,
  `to_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `company`
--
ALTER TABLE `company`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `details`
--
ALTER TABLE `details`
 ADD PRIMARY KEY (`id`), ADD KEY `item_id` (`item_id`), ADD KEY `summary_id` (`summary_id`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
 ADD PRIMARY KEY (`item_id`), ADD KEY `location_id` (`location_id`);

--
-- Indexes for table `item`
--
ALTER TABLE `item`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `code_rate` (`code`,`rate`), ADD KEY `cat_id` (`cat_id`), ADD KEY `party_id` (`party_id`);

--
-- Indexes for table `item_cat`
--
ALTER TABLE `item_cat`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `code` (`code`);

--
-- Indexes for table `locations`
--
ALTER TABLE `locations`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `description` (`description`);

--
-- Indexes for table `op_bal`
--
ALTER TABLE `op_bal`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `loc_item` (`location_id`,`item_id`), ADD KEY `location_id` (`location_id`), ADD KEY `item_id` (`item_id`);

--
-- Indexes for table `party`
--
ALTER TABLE `party`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `code` (`code`);

--
-- Indexes for table `proforma_details`
--
ALTER TABLE `proforma_details`
 ADD PRIMARY KEY (`id`), ADD KEY `p_sum_id` (`p_sum_id`), ADD KEY `item_id` (`item_id`);

--
-- Indexes for table `proforma_summary`
--
ALTER TABLE `proforma_summary`
 ADD PRIMARY KEY (`id`), ADD KEY `party_id` (`party_id`);

--
-- Indexes for table `stock`
--
ALTER TABLE `stock`
 ADD KEY `location` (`location`,`item_id`), ADD KEY `item_id` (`item_id`);

--
-- Indexes for table `summary`
--
ALTER TABLE `summary`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `code_no` (`tr_code`,`tr_no`), ADD KEY `tr_code` (`tr_code`), ADD KEY `party_id` (`party_id`), ADD KEY `tran_type_id` (`tran_type_id`);

--
-- Indexes for table `temp_details`
--
ALTER TABLE `temp_details`
 ADD PRIMARY KEY (`id`), ADD KEY `item_id` (`item_id`), ADD KEY `summary_id` (`summary_id`);

--
-- Indexes for table `tran_type`
--
ALTER TABLE `tran_type`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `tr_code` (`tr_code`), ADD KEY `location` (`location`);

--
-- Indexes for table `trnf_details`
--
ALTER TABLE `trnf_details`
 ADD PRIMARY KEY (`id`), ADD KEY `item_id` (`item_id`), ADD KEY `summ_id` (`summ_id`);

--
-- Indexes for table `trnf_summary`
--
ALTER TABLE `trnf_summary`
 ADD PRIMARY KEY (`id`), ADD KEY `from_id` (`from_id`), ADD KEY `to_id` (`to_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `details`
--
ALTER TABLE `details`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=596;
--
-- AUTO_INCREMENT for table `item`
--
ALTER TABLE `item`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=38;
--
-- AUTO_INCREMENT for table `item_cat`
--
ALTER TABLE `item_cat`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `op_bal`
--
ALTER TABLE `op_bal`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `party`
--
ALTER TABLE `party`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1051;
--
-- AUTO_INCREMENT for table `proforma_details`
--
ALTER TABLE `proforma_details`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=240;
--
-- AUTO_INCREMENT for table `proforma_summary`
--
ALTER TABLE `proforma_summary`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=33;
--
-- AUTO_INCREMENT for table `summary`
--
ALTER TABLE `summary`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=223;
--
-- AUTO_INCREMENT for table `temp_details`
--
ALTER TABLE `temp_details`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=128;
--
-- AUTO_INCREMENT for table `tran_type`
--
ALTER TABLE `tran_type`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `trnf_details`
--
ALTER TABLE `trnf_details`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=135;
--
-- AUTO_INCREMENT for table `trnf_summary`
--
ALTER TABLE `trnf_summary`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=22;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `details`
--
ALTER TABLE `details`
ADD CONSTRAINT `details_ibfk_1` FOREIGN KEY (`summary_id`) REFERENCES `summary` (`id`),
ADD CONSTRAINT `details_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `item` (`id`);

--
-- Constraints for table `inventory`
--
ALTER TABLE `inventory`
ADD CONSTRAINT `inventory_ibfk_1` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`),
ADD CONSTRAINT `inventory_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `item` (`id`);

--
-- Constraints for table `item`
--
ALTER TABLE `item`
ADD CONSTRAINT `item_ibfk_1` FOREIGN KEY (`cat_id`) REFERENCES `item_cat` (`id`),
ADD CONSTRAINT `item_ibfk_2` FOREIGN KEY (`party_id`) REFERENCES `party` (`id`);

--
-- Constraints for table `op_bal`
--
ALTER TABLE `op_bal`
ADD CONSTRAINT `op_bal_ibfk_1` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`),
ADD CONSTRAINT `op_bal_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `item` (`id`);

--
-- Constraints for table `proforma_details`
--
ALTER TABLE `proforma_details`
ADD CONSTRAINT `proforma_details_ibfk_1` FOREIGN KEY (`p_sum_id`) REFERENCES `proforma_summary` (`id`),
ADD CONSTRAINT `proforma_details_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `item` (`id`);

--
-- Constraints for table `proforma_summary`
--
ALTER TABLE `proforma_summary`
ADD CONSTRAINT `proforma_summary_ibfk_1` FOREIGN KEY (`party_id`) REFERENCES `party` (`id`);

--
-- Constraints for table `stock`
--
ALTER TABLE `stock`
ADD CONSTRAINT `stock_ibfk_1` FOREIGN KEY (`location`) REFERENCES `locations` (`id`),
ADD CONSTRAINT `stock_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `item` (`id`);

--
-- Constraints for table `summary`
--
ALTER TABLE `summary`
ADD CONSTRAINT `summary_ibfk_2` FOREIGN KEY (`tr_code`) REFERENCES `tran_type` (`tr_code`),
ADD CONSTRAINT `summary_ibfk_3` FOREIGN KEY (`party_id`) REFERENCES `party` (`id`),
ADD CONSTRAINT `summary_ibfk_4` FOREIGN KEY (`tran_type_id`) REFERENCES `tran_type` (`id`);

--
-- Constraints for table `tran_type`
--
ALTER TABLE `tran_type`
ADD CONSTRAINT `tran_type_ibfk_1` FOREIGN KEY (`location`) REFERENCES `locations` (`description`);

--
-- Constraints for table `trnf_details`
--
ALTER TABLE `trnf_details`
ADD CONSTRAINT `trnf_details_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `item` (`id`),
ADD CONSTRAINT `trnf_details_ibfk_3` FOREIGN KEY (`summ_id`) REFERENCES `trnf_summary` (`id`);

--
-- Constraints for table `trnf_summary`
--
ALTER TABLE `trnf_summary`
ADD CONSTRAINT `trnf_summary_ibfk_1` FOREIGN KEY (`from_id`) REFERENCES `locations` (`id`),
ADD CONSTRAINT `trnf_summary_ibfk_2` FOREIGN KEY (`to_id`) REFERENCES `locations` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
