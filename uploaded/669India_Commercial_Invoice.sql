-- phpMyAdmin SQL Dump
-- version 4.0.10.10
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 18, 2015 at 06:46 AM
-- Server version: 5.6.27
-- PHP Version: 5.4.45

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `trackingsystem`
--

-- --------------------------------------------------------

--
-- Table structure for table `consignment_details`
--

CREATE TABLE IF NOT EXISTS `consignment_details` (
  `consignment_id` int(11) NOT NULL AUTO_INCREMENT,
  `cust_po_number` varchar(100) DEFAULT NULL,
  `port_of_discharge` varchar(100) DEFAULT NULL,
  `require_date` varchar(20) DEFAULT NULL,
  `shipped_quantity` varchar(100) DEFAULT NULL,
  `customer_num` varchar(100) DEFAULT NULL,
  `org_id` int(11) DEFAULT NULL,
  `delivery_id` varchar(100) DEFAULT NULL,
  `item_description` varchar(100) DEFAULT NULL,
  `commercial_invoice` varchar(50) DEFAULT NULL,
  `shipping_status` varchar(100) DEFAULT NULL,
  `shipment_value` varchar(100) DEFAULT NULL,
  `order_status` varchar(100) DEFAULT NULL,
  `schedule_ship_date` varchar(50) DEFAULT NULL,
  `delivery_details_id` varchar(100) DEFAULT NULL,
  `freight_terms_code` varchar(100) DEFAULT NULL,
  `created_date` timestamp(6) NULL DEFAULT NULL,
  `consignment_address` varchar(100) DEFAULT NULL,
  `mode_of_shipment` varchar(100) DEFAULT NULL,
  `vessel_name` varchar(100) DEFAULT NULL,
  `etd_date` varchar(20) DEFAULT NULL,
  `container_number` varchar(100) DEFAULT NULL,
  `shipped_on_board` varchar(100) DEFAULT NULL,
  `transhipment_port` varchar(100) DEFAULT NULL,
  `transhipment_vessel_name` varchar(100) DEFAULT NULL,
  `custom_clearance_date` varchar(20) DEFAULT NULL,
  `arrival_date` varchar(20) DEFAULT NULL,
  `agent` varchar(100) DEFAULT NULL,
  `eta_date` varchar(20) DEFAULT NULL,
  `custom_clearance` varchar(10) DEFAULT NULL,
  `delivered_cutomer_loaction` varchar(20) DEFAULT NULL,
  `remark` varchar(500) DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL,
  `customer_name` varchar(100) DEFAULT NULL,
  `account_number` varchar(50) DEFAULT NULL,
  `order_number` varchar(100) DEFAULT NULL,
  `ordered_item_id` varchar(100) DEFAULT NULL,
  `unit_selling_price` double DEFAULT NULL,
  `order_quantity_uom` varchar(100) DEFAULT NULL,
  `ordered_quantity` int(11) DEFAULT NULL,
  `amount` decimal(10,0) DEFAULT NULL,
  `request_date` varchar(50) DEFAULT NULL,
  `order_date` varchar(50) DEFAULT NULL,
  `shipment_terms` varchar(100) DEFAULT NULL,
  `sailing_date` varchar(20) DEFAULT NULL,
  `update_status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`consignment_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4385 ;

-- --------------------------------------------------------

--
-- Table structure for table `document_detatils`
--

CREATE TABLE IF NOT EXISTS `document_detatils` (
  `document_details_id` int(11) NOT NULL AUTO_INCREMENT,
  `service_provider` varchar(100) DEFAULT NULL,
  `shipping_document_details` varchar(500) DEFAULT NULL,
  `document_name` varchar(100) DEFAULT NULL,
  `shipping_document` varchar(100) DEFAULT NULL,
  `shipping_document_update` varchar(20) DEFAULT NULL,
  `commercial_invoice` varchar(100) DEFAULT NULL,
  `commercial_invoice_update` varchar(20) DEFAULT NULL,
  `india_commercial_invoice` varchar(100) DEFAULT NULL,
  `india_commercial_invoice_update` varchar(200) DEFAULT NULL,
  `created_date` varchar(20) DEFAULT NULL,
  `consignment_id` int(11) DEFAULT NULL,
  `insert_date` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`document_details_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- Table structure for table `entity`
--

CREATE TABLE IF NOT EXISTS `entity` (
  `entity_id` int(11) NOT NULL AUTO_INCREMENT,
  `entity_name` varchar(100) NOT NULL,
  PRIMARY KEY (`entity_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Table structure for table `logistic_view`
--

CREATE TABLE IF NOT EXISTS `logistic_view` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `CUST_PO_NUMBER` varchar(250) NOT NULL,
  `FREIGHT_TERMS_CODE` varchar(50) NOT NULL,
  `SHIPPED_QUANTITY` int(10) NOT NULL,
  `CUSTOMER_NUM` varchar(100) NOT NULL,
  `ORG_ID` varchar(50) NOT NULL,
  `DELIVERY_ID` int(10) NOT NULL,
  `DESCRIPTION` varchar(250) NOT NULL,
  `INVOICE_NUMBER` varchar(100) NOT NULL,
  `PORT_OF_DISCHARGE` varchar(200) NOT NULL,
  `SHIPPING_STATUS` varchar(10) NOT NULL,
  `SHIPPING_VALUE_INR` varchar(250) NOT NULL,
  `ORDER_STATUS` varchar(10) NOT NULL,
  `SHIPPED_DATE` varchar(25) NOT NULL,
  `DELIVERY_DETAIL_ID` int(10) NOT NULL,
  `REQUIRE_DATE_DESTINATION` varchar(25) NOT NULL,
  `HEADER_LUD` varchar(25) NOT NULL,
  `LINE_LUD` varchar(25) NOT NULL,
  `WSH_LUD` varchar(25) NOT NULL,
  `WDD_LUD` varchar(25) NOT NULL,
  `WND_LUD` varchar(25) NOT NULL,
  `EMP_LUD` varchar(25) NOT NULL,
  `EML_LUD` varchar(25) NOT NULL,
  `JAI_LUD` varchar(25) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `DELIVERY_DETAIL_ID` (`DELIVERY_DETAIL_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4385 ;

-- --------------------------------------------------------

--
-- Table structure for table `org_map`
--

CREATE TABLE IF NOT EXISTS `org_map` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `org_id` int(11) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_registration`
--

CREATE TABLE IF NOT EXISTS `user_registration` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `email_id` varchar(100) DEFAULT NULL,
  `password` varchar(20) DEFAULT NULL,
  `address` varchar(200) DEFAULT NULL,
  `role_id` int(20) DEFAULT NULL,
  `login_date` varchar(20) DEFAULT NULL,
  `created_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` varchar(20) DEFAULT NULL,
  `entity_id` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=85 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

CREATE TABLE IF NOT EXISTS `user_role` (
  `role_id` int(11) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(100) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
