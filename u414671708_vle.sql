/*
 Navicat Premium Data Transfer

 Source Server         : localhost_3306
 Source Server Type    : MySQL
 Source Server Version : 80036
 Source Host           : localhost:3306
 Source Schema         : vle

 Target Server Type    : MySQL
 Target Server Version : 80036
 File Encoding         : 65001

 Date: 06/09/2024 09:06:29
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for tb_announcement
-- ----------------------------
DROP TABLE IF EXISTS `tb_announcement`;
CREATE TABLE `tb_announcement`  (
  `EntryID` int NOT NULL AUTO_INCREMENT,
  `Title` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `Description` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL,
  `AnnouncementType` int NULL DEFAULT NULL,
  `createdOn` datetime(0) NULL DEFAULT NULL,
  `updatedOn` datetime(0) NULL DEFAULT NULL,
  `entry_by` int NULL DEFAULT NULL,
  `is_active` int NULL DEFAULT NULL,
  `is_del` int NULL DEFAULT NULL,
  PRIMARY KEY (`EntryID`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 19 CHARACTER SET = utf8mb3 COLLATE = utf8mb3_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tb_announcement
-- ----------------------------
INSERT INTO `tb_announcement` VALUES (17, 'Contribution Name: genshin', 'samm. Corresponding Contribution Amount: 100000.  ', 1, '2024-03-31 14:14:00', NULL, 1, 1, 0);
INSERT INTO `tb_announcement` VALUES (18, 'Contribution Name: Tulong Dunong Project', 'asasasa. Corresponding Contribution Amount: 10000.  ', 1, '2024-07-13 04:43:44', NULL, 1, 1, 0);

-- ----------------------------
-- Table structure for tb_attendance
-- ----------------------------
DROP TABLE IF EXISTS `tb_attendance`;
CREATE TABLE `tb_attendance`  (
  `EntryID` int NOT NULL AUTO_INCREMENT,
  `Name` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `Fines` float NULL DEFAULT NULL,
  `Description` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL,
  `DateSchedule` date NULL DEFAULT NULL,
  `is_active` int NULL DEFAULT NULL,
  `createdOn` datetime(0) NULL DEFAULT NULL,
  `updatedON` datetime(0) NULL DEFAULT NULL,
  `entry_by` int NULL DEFAULT NULL,
  `is_del` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`EntryID`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb3 COLLATE = utf8mb3_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tb_attendance
-- ----------------------------

-- ----------------------------
-- Table structure for tb_attendance_details
-- ----------------------------
DROP TABLE IF EXISTS `tb_attendance_details`;
CREATE TABLE `tb_attendance_details`  (
  `EntryID` int NOT NULL AUTO_INCREMENT,
  `AttendanceID` int NULL DEFAULT NULL,
  `ProfileID` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `Remarks` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `createdOn` datetime(0) NULL DEFAULT NULL,
  `updatedON` datetime(0) NULL DEFAULT NULL,
  `is_del` int NULL DEFAULT NULL,
  `entry_by` int NULL DEFAULT NULL,
  PRIMARY KEY (`EntryID`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb3 COLLATE = utf8mb3_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tb_attendance_details
-- ----------------------------

-- ----------------------------
-- Table structure for tb_chart_of_account
-- ----------------------------
DROP TABLE IF EXISTS `tb_chart_of_account`;
CREATE TABLE `tb_chart_of_account`  (
  `ChartID` int NOT NULL AUTO_INCREMENT,
  `ChartCode` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `ChartName` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `ChartDesc` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `InitialAmount` double NULL DEFAULT NULL,
  `is_active` int NULL DEFAULT NULL,
  `is_del` int NULL DEFAULT NULL,
  `createdON` datetime(0) NULL DEFAULT NULL,
  `updatedON` datetime(0) NULL DEFAULT NULL,
  `entry_by` int NULL DEFAULT NULL,
  PRIMARY KEY (`ChartID`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb3 COLLATE = utf8mb3_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tb_chart_of_account
-- ----------------------------
INSERT INTO `tb_chart_of_account` VALUES (1, 'CT', 'Contribution', 'Contribution', NULL, NULL, NULL, NULL, NULL, NULL);

-- ----------------------------
-- Table structure for tb_contribution
-- ----------------------------
DROP TABLE IF EXISTS `tb_contribution`;
CREATE TABLE `tb_contribution`  (
  `EntryID` int NOT NULL AUTO_INCREMENT,
  `Name` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `BalanceFee` float NULL DEFAULT NULL,
  `Description` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `is_active` int NULL DEFAULT NULL,
  `createdOn` datetime(0) NULL DEFAULT NULL,
  `updatedON` datetime(0) NULL DEFAULT NULL,
  `entry_by` int NULL DEFAULT NULL,
  `is_del` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`EntryID`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb3 COLLATE = utf8mb3_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tb_contribution
-- ----------------------------
INSERT INTO `tb_contribution` VALUES (3, 'genshin', 100000, 'samm', 1, '2024-03-31 14:14:00', NULL, 1, '0');
INSERT INTO `tb_contribution` VALUES (4, 'Tulong Dunong Project', 10000, 'asasasa', 1, '2024-07-13 04:43:44', NULL, 1, '0');

-- ----------------------------
-- Table structure for tb_contribution_account
-- ----------------------------
DROP TABLE IF EXISTS `tb_contribution_account`;
CREATE TABLE `tb_contribution_account`  (
  `EntryID` int NOT NULL AUTO_INCREMENT,
  `ContributionID` int NULL DEFAULT NULL,
  `ProfileID` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `Remarks` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `Debit` float NULL DEFAULT NULL,
  `Credit` float NULL DEFAULT NULL,
  `BalanceFee` float NULL DEFAULT NULL,
  `createdOn` datetime(0) NULL DEFAULT NULL,
  `updatedON` datetime(0) NULL DEFAULT NULL,
  `is_active` int NULL DEFAULT NULL,
  `is_del` int NULL DEFAULT NULL,
  `entry_by` int NULL DEFAULT NULL,
  PRIMARY KEY (`EntryID`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb3 COLLATE = utf8mb3_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tb_contribution_account
-- ----------------------------
INSERT INTO `tb_contribution_account` VALUES (3, 3, '101011', NULL, 0, 100000, 100000, '2024-03-31 14:14:00', NULL, 1, 0, 1);
INSERT INTO `tb_contribution_account` VALUES (4, 4, '10205982', NULL, 0, 10000, 10000, '2024-07-13 04:43:44', NULL, 1, 0, 1);

-- ----------------------------
-- Table structure for tb_groups
-- ----------------------------
DROP TABLE IF EXISTS `tb_groups`;
CREATE TABLE `tb_groups`  (
  `group_id` mediumint NOT NULL AUTO_INCREMENT,
  `name` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `description` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `level` int NULL DEFAULT NULL,
  `entry_by` int NULL DEFAULT NULL,
  `createdOn` datetime(0) NULL DEFAULT CURRENT_TIMESTAMP(0),
  `updatedOn` datetime(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`group_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb3 COLLATE = utf8mb3_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tb_groups
-- ----------------------------
INSERT INTO `tb_groups` VALUES (1, 'superadmin', NULL, NULL, NULL, '2024-03-22 00:57:31', '2024-03-28 14:37:13');
INSERT INTO `tb_groups` VALUES (2, 'admin', NULL, NULL, NULL, '2024-03-22 00:57:42', '2024-03-28 14:37:18');
INSERT INTO `tb_groups` VALUES (3, 'user', NULL, NULL, NULL, '2024-03-22 00:57:52', '2024-03-30 13:49:50');
INSERT INTO `tb_groups` VALUES (4, 'cashier', NULL, NULL, NULL, '2024-03-22 00:57:55', '2024-03-28 14:38:20');
INSERT INTO `tb_groups` VALUES (5, 'encoder', NULL, NULL, NULL, '2024-03-28 14:37:07', '2024-03-30 13:49:54');

-- ----------------------------
-- Table structure for tb_journal
-- ----------------------------
DROP TABLE IF EXISTS `tb_journal`;
CREATE TABLE `tb_journal`  (
  `EntryID` int NOT NULL AUTO_INCREMENT,
  `ProfileID` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `TransactionTypeID` int NULL DEFAULT NULL,
  `ReferenceID` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `ChartAccountID` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `Description` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `Payor` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `PayorID` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `Debit` float NULL DEFAULT NULL,
  `Credit` float NULL DEFAULT NULL,
  `Discount` float NULL DEFAULT NULL,
  `BalanceFee` float NULL DEFAULT NULL,
  `ActualPayment` float NULL DEFAULT NULL,
  `PaymentDiscount` float NULL DEFAULT NULL,
  `TransRefNo` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `Nonledger` int NULL DEFAULT NULL,
  `entry_by` int NULL DEFAULT NULL,
  `is_del` int NULL DEFAULT NULL,
  `createdOn` datetime(0) NULL DEFAULT NULL,
  `updatedON` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`EntryID`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 16 CHARACTER SET = utf8mb3 COLLATE = utf8mb3_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tb_journal
-- ----------------------------
INSERT INTO `tb_journal` VALUES (14, '101011', 1, '3', '1', 'Contribution: genshin', NULL, NULL, 0, 100000, NULL, 100000, NULL, NULL, NULL, NULL, 1, 0, '2024-03-31 14:14:00', NULL);
INSERT INTO `tb_journal` VALUES (15, '10205982', 1, '4', '1', 'Contribution: Tulong Dunong Project', NULL, NULL, 0, 10000, NULL, 10000, NULL, NULL, NULL, NULL, 1, 0, '2024-07-13 04:43:44', NULL);

-- ----------------------------
-- Table structure for tb_officialreceipts
-- ----------------------------
DROP TABLE IF EXISTS `tb_officialreceipts`;
CREATE TABLE `tb_officialreceipts`  (
  `int` bigint NOT NULL AUTO_INCREMENT,
  `ORNo` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `Date` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `PayorID` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `PayorName` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `AmountDue` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `CashReceive` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `Change` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `Discount` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `IsVoid` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `updatedON` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `entry_by` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `CashierID` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `TransType` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `RefNo` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `SupervisorID` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `CreatedBy` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `createdOn` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `AmountinWords` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`int`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb3 COLLATE = utf8mb3_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tb_officialreceipts
-- ----------------------------

-- ----------------------------
-- Table structure for tb_officialreceipts_details
-- ----------------------------
DROP TABLE IF EXISTS `tb_officialreceipts_details`;
CREATE TABLE `tb_officialreceipts_details`  (
  `EntryID` int NOT NULL AUTO_INCREMENT,
  `ProfileID` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `TransactionTypeID` int NULL DEFAULT NULL,
  `ReferenceID` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `ChartAccountID` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `Description` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `Payor` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `PayorID` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `Debit` float NULL DEFAULT NULL,
  `Credit` float NULL DEFAULT NULL,
  `Discount` float NULL DEFAULT NULL,
  `BalanceFee` float NULL DEFAULT NULL,
  `ActualPayment` float NULL DEFAULT NULL,
  `PaymentDiscount` float NULL DEFAULT NULL,
  `TransRefNo` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `entry_by` int NULL DEFAULT NULL,
  `createdOn` datetime(0) NULL DEFAULT NULL,
  `updatedON` datetime(0) NULL DEFAULT NULL,
  `is_del` int NULL DEFAULT NULL,
  PRIMARY KEY (`EntryID`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb3 COLLATE = utf8mb3_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tb_officialreceipts_details
-- ----------------------------

-- ----------------------------
-- Table structure for tb_payment
-- ----------------------------
DROP TABLE IF EXISTS `tb_payment`;
CREATE TABLE `tb_payment`  (
  `TransactionID` int NOT NULL,
  `DateTransacted` datetime(0) NULL DEFAULT NULL,
  `PayorID` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `PayorName` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `AmountDue` float NULL DEFAULT NULL,
  `CashReceived` float NULL DEFAULT NULL,
  `AmountingWord` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `Change` float NULL DEFAULT NULL,
  `Discount` float NULL DEFAULT NULL,
  `CashierID` int NULL DEFAULT NULL,
  `TransactionTypeID` int NULL DEFAULT NULL,
  `ReferenceID` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `createdOn` datetime(0) NULL DEFAULT NULL,
  `updatedOn` datetime(0) NULL DEFAULT NULL,
  `entry_by` int NULL DEFAULT NULL,
  PRIMARY KEY (`TransactionID`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb3 COLLATE = utf8mb3_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for tb_payment_details
-- ----------------------------
DROP TABLE IF EXISTS `tb_payment_details`;
CREATE TABLE `tb_payment_details`  (
  `EntryID` int NOT NULL AUTO_INCREMENT,
  `ProfileID` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `TransactionTypeID` int NULL DEFAULT NULL,
  `ReferenceID` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `ChartAccountID` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `Description` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `Payor` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `PayorID` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `Debit` float NULL DEFAULT NULL,
  `Credit` float NULL DEFAULT NULL,
  `BalanceFee` float NULL DEFAULT NULL,
  `entry_by` int NULL DEFAULT NULL,
  `createdOn` datetime(0) NULL DEFAULT NULL,
  `updatedON` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`EntryID`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb3 COLLATE = utf8mb3_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tb_payment_details
-- ----------------------------

-- ----------------------------
-- Table structure for tb_profile
-- ----------------------------
DROP TABLE IF EXISTS `tb_profile`;
CREATE TABLE `tb_profile`  (
  `ProfileID` bigint NOT NULL AUTO_INCREMENT,
  `avatar` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `UniqueID` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `FirstName` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `MiddleName` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `LastName` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `NameExtension` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `Suffix` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `createdOn` datetime(0) NULL DEFAULT CURRENT_TIMESTAMP(0),
  `updatedOn` datetime(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0),
  `entry_by` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `is_active` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `is_del` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `home_purok` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `home_baranggay` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `home_muncity` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `home_province` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `zipcode` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `sex` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `dateofbirth` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `placeofbirth` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `bloodtype` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `Country` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `contactno` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `faxno` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `homeno` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `officeno` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `Occupation` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `Education` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `Employment` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `EmploymentAddress` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `familykin` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `familyrelation` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `familyaddress` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `familynokids` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `familykidsname` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `recordStat` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `LodgeNo` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `LodgeName` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `MasonDistrict` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `initiated` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `passed` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `raised` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `memberstatus` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`ProfileID`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb3 COLLATE = utf8mb3_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tb_profile
-- ----------------------------
INSERT INTO `tb_profile` VALUES (1, NULL, '202409050001', 'First Name', NULL, 'Last Name', NULL, NULL, 'comodaneps@gmail.com', '2024-09-05 08:06:27', NULL, '0', '1', '0', 'Home/Blkd', 'Province', 'Municipality/City', 'Barangay', 'ZipCode', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `tb_profile` VALUES (2, NULL, '202409050002', 'First Name', NULL, 'Last Name', NULL, NULL, 'sss@sss.com', '2024-09-05 21:26:21', NULL, '0', '1', '0', 'Home Address', 'Province', 'Municipality/City', 'Barangay', 'ZipCode', 'M', '2024-09-05', 'ZipCode', 'q', 'Country', 'Contact No', 'Fax No', 'Home Number', 'Office Number', 'Occupation', 'Education', 'Employment', 'Address', 'Kin', 'Relation', 'Address', '10', 'Name of Kids', 'undefined', 'undefined', 'undefined', 'undefined', '2024-09-05', '2024-09-05', '2024-09-05', 'Died');

-- ----------------------------
-- Table structure for tb_transaction_type
-- ----------------------------
DROP TABLE IF EXISTS `tb_transaction_type`;
CREATE TABLE `tb_transaction_type`  (
  `TransactionTypeID` int NOT NULL AUTO_INCREMENT,
  `TransactionCode` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `TransactionName` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `Remarks` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `is_active` int NULL DEFAULT NULL,
  `is_del` int NULL DEFAULT NULL,
  `createdOn` datetime(0) NULL DEFAULT NULL,
  `updateOn` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`TransactionTypeID`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb3 COLLATE = utf8mb3_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tb_transaction_type
-- ----------------------------
INSERT INTO `tb_transaction_type` VALUES (1, 'CT', 'Contribution', 'Contribution', 1, 0, NULL, NULL);
INSERT INTO `tb_transaction_type` VALUES (2, 'OR', 'Cash Receipt Book', 'Payment', 1, 0, NULL, NULL);

-- ----------------------------
-- Table structure for tb_users
-- ----------------------------
DROP TABLE IF EXISTS `tb_users`;
CREATE TABLE `tb_users`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `group_id` int NULL DEFAULT NULL COMMENT 'foreign key of tbl_group',
  `ProfileID` varchar(15) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL COMMENT 'category of user account',
  `username` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `password` varchar(64) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `email` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `first_name` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `middle_name` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `last_name` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `avatar` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `active` tinyint UNSIGNED NULL DEFAULT NULL,
  `login_attempt_date` datetime(0) NULL DEFAULT NULL,
  `login_attempt` tinyint NULL DEFAULT 0,
  `last_login` datetime(0) NULL DEFAULT NULL,
  `createdOn` timestamp(0) NULL DEFAULT CURRENT_TIMESTAMP(0),
  `updatedOn` timestamp(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0),
  `reminder` varchar(64) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `activation` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `entry_by` varchar(30) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `reset` int NULL DEFAULT NULL,
  `verify` tinyint(1) NULL DEFAULT NULL,
  `is_lock` int NULL DEFAULT NULL,
  `change_email_status` int NULL DEFAULT NULL,
  `to_way_auth_status` varchar(3) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `to_way_auth_method` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `to_way_auth_code` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `to_way_auth_expiry` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `is_del` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `unique_email`(`email`) USING BTREE,
  UNIQUE INDEX `username`(`username`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb3 COLLATE = utf8mb3_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tb_users
-- ----------------------------
INSERT INTO `tb_users` VALUES (1, 1, NULL, 'aa', 'a03d1759c32da8bc271cd44b0f92b926', 'assd@ss.com', '', NULL, '', NULL, 1, NULL, 0, NULL, NULL, '2024-03-31 00:57:57', NULL, '1', NULL, '1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0);
INSERT INTO `tb_users` VALUES (2, 3, '1', '101011', 'f7a0800bed644022a43e9c47dd9dbe24', 'djbudoykokey@gmail.com', 'Neptune', NULL, 'Comoda', NULL, 1, NULL, 0, NULL, '2024-03-30 18:36:55', '2024-03-30 21:52:20', NULL, NULL, NULL, '1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0);
INSERT INTO `tb_users` VALUES (3, 3, '2', '10205982', '383c404e3f125f8e145e6935b3d13bef', 'comodaneps@gmail.com', 'john', NULL, 'doe', NULL, 1, NULL, 0, NULL, '2024-07-13 12:42:31', '2024-07-13 12:42:31', NULL, NULL, NULL, '1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0);
INSERT INTO `tb_users` VALUES (4, 3, '202409040001', '202409040001', '687927d46d642225eae87a5ccf7f8d52', 's@s.com', 's@s.com', NULL, 's@s.com', NULL, 1, NULL, 0, NULL, '2024-09-04 21:25:18', '2024-09-04 21:25:18', NULL, NULL, NULL, '0', NULL, 1, NULL, NULL, '0', NULL, NULL, NULL, 0);

-- ----------------------------
-- View structure for getdatafordashboard
-- ----------------------------
DROP VIEW IF EXISTS `getdatafordashboard`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `getdatafordashboard` AS select `tba`.`Title` AS `AnnouncementTitle`,`tba`.`Description` AS `Description`,`tba`.`createdOn` AS `date posted` from `tb_announcement` `tba` order by `tba`.`EntryID` desc limit 0,10;

-- ----------------------------
-- View structure for viewannouncementlist
-- ----------------------------
DROP VIEW IF EXISTS `viewannouncementlist`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `viewannouncementlist` AS select `tba`.`EntryID` AS `EntryID`,`tba`.`Title` AS `Title`,`tba`.`Description` AS `Description`,`tba`.`createdOn` AS `DateCreated`,`tba`.`updatedOn` AS `DateUpdated`,`tbu`.`username` AS `username`,(case when (`tba`.`is_del` = 0) then 'Not Deleted' when (`tba`.`is_del` = 1) then 'Record deleted' else 'Undefined record' end) AS `RecordDeleted`,(case when (`tba`.`is_active` = 1) then 'Record active' when (`tba`.`is_active` = 0) then 'Not active' else 'Undefined status report' end) AS `RecordStatus` from (`tb_announcement` `tba` left join `tb_users` `tbu` on((`tba`.`entry_by` = `tbu`.`id`)));

-- ----------------------------
-- View structure for viewattendancelist
-- ----------------------------
DROP VIEW IF EXISTS `viewattendancelist`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `viewattendancelist` AS select `tb_attendance`.`EntryID` AS `EntryID`,`tb_attendance`.`Name` AS `Name`,`tb_attendance`.`Fines` AS `Fines`,`tb_attendance`.`Description` AS `Description`,`tb_attendance`.`is_active` AS `IsActive`,`tb_attendance`.`createdOn` AS `createdOn`,`tb_attendance`.`updatedON` AS `updatedON`,`tb_attendance`.`is_del` AS `is_del`,`tb_users`.`username` AS `username`,`tb_attendance`.`DateSchedule` AS `DateScheduleofActivity` from (`tb_attendance` left join `tb_users` on((`tb_attendance`.`entry_by` = `tb_users`.`id`)));

-- ----------------------------
-- View structure for viewchartaccountprofile
-- ----------------------------
DROP VIEW IF EXISTS `viewchartaccountprofile`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `viewchartaccountprofile` AS select `tb_chart_of_account`.`ChartID` AS `ChartID`,`tb_chart_of_account`.`ChartCode` AS `ChartCode`,`tb_chart_of_account`.`ChartName` AS `ChartName`,`tb_chart_of_account`.`ChartDesc` AS `ChartDesc`,`tb_chart_of_account`.`InitialAmount` AS `InitialAmount`,`tb_chart_of_account`.`is_active` AS `is_active`,`tb_chart_of_account`.`is_del` AS `is_del`,`tb_chart_of_account`.`createdON` AS `createdON`,`tb_chart_of_account`.`updatedON` AS `updatedON`,`tb_chart_of_account`.`entry_by` AS `entry_by` from `tb_chart_of_account`;

-- ----------------------------
-- View structure for viewcontribution
-- ----------------------------
DROP VIEW IF EXISTS `viewcontribution`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `viewcontribution` AS select `tbc`.`EntryID` AS `EntryID`,`tbc`.`Name` AS `Name`,`tbc`.`BalanceFee` AS `BalanceFee`,`tbc`.`Description` AS `Description`,`tbc`.`createdOn` AS `DateCreated`,`tbc`.`updatedON` AS `DateUpdated`,(case when (`tbc`.`is_active` = 1) then 'Record active' when (`tbc`.`is_active` = 0) then 'Inactive Record' else 'Unknown Status' end) AS `RecordStatus`,(case when (`tbc`.`is_del` = 1) then 'Record deleted' when (`tbc`.`is_del` = 0) then '' else 'Unknown Status' end) AS `RecordDeleted`,`tu`.`username` AS `username` from (`tb_contribution` `tbc` left join `tb_users` `tu` on((`tbc`.`entry_by` = `tu`.`id`)));

-- ----------------------------
-- View structure for viewcontributionsummary
-- ----------------------------
DROP VIEW IF EXISTS `viewcontributionsummary`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `viewcontributionsummary` AS select `tbc`.`EntryID` AS `EntryID`,`tbc`.`Name` AS `Name`,`tbc`.`BalanceFee` AS `BalanceFee`,`tbc`.`Description` AS `Description`,round(sum(`tbca`.`Debit`),2) AS `TotalDebit`,round(sum(`tbca`.`Credit`),2) AS `TotalCredit` from (`tb_contribution` `tbc` left join `tb_contribution_account` `tbca` on((`tbc`.`EntryID` = `tbca`.`ContributionID`))) group by `tbc`.`EntryID`,`tbc`.`Name`,`tbc`.`BalanceFee`,`tbc`.`Description` order by `tbc`.`EntryID`,`tbc`.`EntryID`,`tbc`.`Name`,`tbc`.`BalanceFee`,`tbc`.`Description`;

-- ----------------------------
-- View structure for viewcontributionsummaryprofile
-- ----------------------------
DROP VIEW IF EXISTS `viewcontributionsummaryprofile`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `viewcontributionsummaryprofile` AS select concat(`tp`.`LastName`,', ',`tp`.`FirstName`,' ',`tp`.`NameExtension`) AS `Fullname`,`tp`.`UniqueID` AS `ProfileID`,`tp`.`Suffix` AS `Suffix`,`tba`.`ContributionID` AS `ContributionID`,round(sum(`tba`.`Debit`),2) AS `TotalDebit`,round(sum(`tba`.`Credit`),2) AS `TotalCredit`,`tba`.`BalanceFee` AS `BalanceFee` from (`tb_contribution_account` `tba` join `tb_profile` `tp` on((`tp`.`UniqueID` = `tba`.`ProfileID`))) group by `tp`.`UniqueID`,`tp`.`LastName`,`tp`.`FirstName`,`tp`.`NameExtension`,`tp`.`Suffix`,`tba`.`ContributionID`;

-- ----------------------------
-- View structure for viewprofile
-- ----------------------------
DROP VIEW IF EXISTS `viewprofile`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `viewprofile` AS select `tb_profile`.`ProfileID` AS `ProfileID`,`tb_profile`.`UniqueID` AS `UserID`,`tb_profile`.`FirstName` AS `FirstName`,`tb_profile`.`MiddleName` AS `MiddleName`,`tb_profile`.`LastName` AS `LastName`,`tb_profile`.`NameExtension` AS `NameExtension`,`tb_profile`.`Suffix` AS `Suffix`,concat(`tb_profile`.`LastName`,', ',`tb_profile`.`FirstName`,(case when ((`tb_profile`.`MiddleName` is not null) and (`tb_profile`.`MiddleName` <> '')) then concat(' ',substr(`tb_profile`.`MiddleName`,1,1),'.',' ') else ' ' end),`tb_profile`.`NameExtension`) AS `Fullname`,`tb_profile`.`email` AS `Email`,(case when (`tb_profile`.`is_del` = 0) then 'Not Deleted' when (`tb_profile`.`is_del` = 1) then 'Record deleted' else 'Undefined record' end) AS `RecordDeleted`,(case when (`tb_profile`.`is_active` = 1) then 'Record active' when (`tb_profile`.`is_active` = 0) then 'Not active' else 'Undefined status report' end) AS `RecordStatus` from `tb_profile`;

-- ----------------------------
-- View structure for viewuserprofile
-- ----------------------------
DROP VIEW IF EXISTS `viewuserprofile`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `viewuserprofile` AS select `tbu`.`id` AS `UserID`,`tbg`.`group_id` AS `GroupID`,`tbg`.`name` AS `GroupName`,`tbp`.`UniqueID` AS `ProfileUserID`,`tbp`.`ProfileID` AS `ProfileID`,coalesce(`tbu`.`first_name`,'') AS `FirstName`,coalesce(`tbu`.`middle_name`,'') AS `MiddleName`,coalesce(`tbu`.`last_name`,'') AS `LastName`,coalesce(`tbu`.`email`,'') AS `email`,coalesce(`tbu`.`username`,'') AS `UserName`,coalesce(`tbu`.`avatar`,'') AS `avatar`,`tbu`.`last_login` AS `last_login`,(case when ((`tbu`.`is_lock` = 0) or (`tbu`.`is_lock` is null)) then '' when (`tbu`.`is_lock` = 1) then 'Account Lock' else 'Undefined record' end) AS `AccountLock`,`tbu`.`reset` AS `reset`,`tbu`.`verify` AS `verify`,`tbu`.`change_email_status` AS `change_email_status`,`tbu`.`to_way_auth_status` AS `to_way_auth_status`,`tbu`.`createdOn` AS `DateCreated`,`tbu`.`updatedOn` AS `DateUpdated`,`tbu`.`reset` AS `AccountPasswordReset`,`tbuu`.`username` AS `Encoder`,(case when (`tbu`.`is_del` = 0) then 'Not Deleted' when (`tbu`.`is_del` = 1) then 'Record deleted' else 'Undefined record' end) AS `RecordDeleted`,(case when (`tbu`.`active` = 1) then 'Record active' when (`tbu`.`active` = 0) then 'Not active' else 'Undefined status report' end) AS `RecordStatus` from (((`tb_users` `tbu` left join `tb_profile` `tbp` on((`tbu`.`ProfileID` = `tbp`.`ProfileID`))) left join `tb_groups` `tbg` on((`tbu`.`group_id` = `tbg`.`group_id`))) left join `tb_users` `tbuu` on((`tbu`.`id` = `tbuu`.`id`)));

-- ----------------------------
-- Procedure structure for AddNewPayment
-- ----------------------------
DROP PROCEDURE IF EXISTS `AddNewPayment`;
delimiter ;;
CREATE PROCEDURE `AddNewPayment`(IN `typePayment` VARCHAR(10), IN `v_EntryID` VARCHAR(255), IN `v_ProfileID` VARCHAR(255), IN `p_EntryBy` VARCHAR(255), IN `p_Name` VARCHAR(255))
BEGIN
DECLARE v_ContributionID INT;
	IF typePayment = 'CONT' THEN
		 -- Insert data into tb_contribution_account for each valid tb_profile entry
		 INSERT INTO tb_contribution_account (ContributionID, ProfileID, BalanceFee, Debit, Credit, is_active, is_del, entry_by)
            VALUES (v_EntryID, v_ProfileID, 0,  0, 0, 1, 0, p_EntryBy);
						 SET v_ContributionID = LAST_INSERT_ID();
			-- Insert data into tb_journal
            INSERT INTO tb_journal (ProfileID, TransactionTypeID, ReferenceID, ChartAccountID, Description,Debit,  Credit, BalanceFee, entry_by)
            VALUES (v_ProfileID, 1, v_ContributionID, 1, concat('Contribution: ',  p_Name ), 0,0,0,p_EntryBy);
	
	
	end if;
	
	-- Select success message and v_ContributionID
    SELECT 'success' AS SuccessMessage, v_ContributionID AS ContributionID;
END
;;
delimiter ;

-- ----------------------------
-- Procedure structure for changePassword
-- ----------------------------
DROP PROCEDURE IF EXISTS `changePassword`;
delimiter ;;
CREATE PROCEDURE `changePassword`(IN `accountID` VARCHAR(50), IN `newpassword` VARCHAR(50))
BEGIN
    DECLARE compare VARCHAR(50);

    -- Check if the provided new password is at least 8 characters
    IF CHAR_LENGTH(newpassword) < 8 THEN
        SELECT 'error: Password must be at least 8 characters' AS ErrorMessage;
    ELSE
        -- Check if the account exists
        SELECT id INTO compare FROM tb_users WHERE id = accountID;
        
        -- If no rows were found, the account does not exist
        IF compare IS NULL THEN
            SELECT 'error: Account does not exist' AS ErrorMessage;
        ELSE
            -- Proceed to update the account's password
            UPDATE tb_users
            SET password = newpassword
            WHERE id = accountID;

            -- Check if the update was successful
            IF ROW_COUNT() > 0 THEN
                SELECT 'success' AS SuccessMessage;
            ELSE
                SELECT 'error: Failed to change password' AS ErrorMessage;
            END IF;
        END IF;
    END IF;
END
;;
delimiter ;

-- ----------------------------
-- Procedure structure for CheckIfORNumberExists
-- ----------------------------
DROP PROCEDURE IF EXISTS `CheckIfORNumberExists`;
delimiter ;;
CREATE PROCEDURE `CheckIfORNumberExists`(IN `ORNumber` VARCHAR(255))
BEGIN
    DECLARE ORNumberExists INT;
		DECLARE v_SuccessMessage NVARCHAR(255);

    -- Check if the provided columnNameOrNumber exists in the dataset
    SELECT COUNT(*)
    INTO ORNumberExists
    FROM tb_officialreceipts
    WHERE ORNo = ORNumber ;

    -- Display appropriate message based on the result
    IF ORNumberExists > 0 THEN
        SET v_SuccessMessage = "exist";
    ELSE
        SET v_SuccessMessage = "not exist";
    END IF;
		
		SELECT v_SuccessMessage AS SuccessMessage;
END
;;
delimiter ;

-- ----------------------------
-- Procedure structure for DeleteRecordProcedure
-- ----------------------------
DROP PROCEDURE IF EXISTS `DeleteRecordProcedure`;
delimiter ;;
CREATE PROCEDURE `DeleteRecordProcedure`(IN `tableName` VARCHAR(255), IN `columnName` VARCHAR(100), IN `columnNameValue` VARCHAR(255), IN `columnNameToUpdate` VARCHAR(100), IN `newValue` VARCHAR(255), IN `permanentDelete` VARCHAR(255), IN `primaryIdColumn` VARCHAR(255))
BEGIN
    DECLARE tableExists INT;
    DECLARE columnExists INT;
    DECLARE columnToUpdateExists INT;
    DECLARE validFlag INT;
    DECLARE primaryIds VARCHAR(1000); -- Assuming primary key is a string
    DECLARE messageDetails VARCHAR(255); -- Output message details
    
    -- Check if the table exists
    SELECT COUNT(*)
    INTO tableExists
    FROM information_schema.tables
    WHERE table_name = tableName;

    -- Check if the column to search exists in the table
    SELECT COUNT(*)
    INTO columnExists
    FROM information_schema.columns
    WHERE table_name = tableName AND column_name = columnName;

    -- Check if the column to update exists in the table
    SELECT COUNT(*)
    INTO columnToUpdateExists
    FROM information_schema.columns
    WHERE table_name = tableName AND column_name = columnNameToUpdate;

    -- Check if permanentDelete parameter is valid (either '1' or '0')
    SET validFlag = 0;
    IF permanentDelete = '1' OR permanentDelete = '0' THEN
        SET validFlag = 1;
    END IF;

    IF tableExists > 0 AND columnExists > 0 AND columnToUpdateExists > 0 AND validFlag = 1 THEN
        IF permanentDelete = '1' THEN
            -- Query primary IDs before deletion
            SET @sql = CONCAT('SELECT GROUP_CONCAT(`', primaryIdColumn, '`) INTO @primaryIds FROM ', tableName, ' WHERE `', columnName, '` = ''', columnNameValue, '''');
            PREPARE stmt FROM @sql;
            EXECUTE stmt;
            DEALLOCATE PREPARE stmt;

            -- Perform deletion
            SET @sql = CONCAT('DELETE FROM ', tableName, ' WHERE `', columnName, '` = ''', columnNameValue, '''');
            PREPARE stmt FROM @sql;
            EXECUTE stmt;
            DEALLOCATE PREPARE stmt;

            IF @primaryIds IS NULL THEN
                SET primaryIds = 'No records found';
            END IF;

            SET messageDetails = CONCAT('Record(s) with ', columnName, '=', columnNameValue, ' and primary IDs: ', IFNULL(primaryIds, 'No records found'), ' permanently deleted.');
        ELSE
            -- Update the column with the new value
            SET @sql = CONCAT('UPDATE ', tableName, ' SET `', columnNameToUpdate, '` = ''', newValue, ''' WHERE `', columnName, '` = ''', columnNameValue, '''');
            PREPARE stmt FROM @sql;
            EXECUTE stmt;
            DEALLOCATE PREPARE stmt;
            
            -- Query primary IDs after update
            SET @sql = CONCAT('SELECT GROUP_CONCAT(`', primaryIdColumn, '`) INTO @primaryIds FROM ', tableName, ' WHERE `', columnName, '` = ''', columnNameValue, '''');
            PREPARE stmt FROM @sql;
            EXECUTE stmt;
            DEALLOCATE PREPARE stmt;
            
            IF @primaryIds IS NULL THEN
                SET primaryIds = 'No records found';
            END IF;

            SET messageDetails = CONCAT('Column ', columnNameToUpdate, ' updated successfully for record(s) with ', columnName, '=', columnNameValue, '. Primary IDs: ', IFNULL(primaryIds, 'No records found'));
        END IF;
    ELSE
        SET messageDetails = 'Invalid data transaction';
    END IF;

    SELECT IF(messageDetails = 'Invalid data transaction', 'Invalid data transaction', 'success') AS SuccessMessage,
           IF(messageDetails = 'Invalid data transaction', 'Invalid data transaction', messageDetails) AS MessageDetails,
           IFNULL(@primaryIds, 'No records found') AS CurrentID;
END
;;
delimiter ;

-- ----------------------------
-- Procedure structure for GetAssestmentEntries
-- ----------------------------
DROP PROCEDURE IF EXISTS `GetAssestmentEntries`;
delimiter ;;
CREATE PROCEDURE `GetAssestmentEntries`(IN `ProfileID` VARCHAR(255))
BEGIN
    SELECT
        tbj.createdOn AS DateTransacted,
        tbj.updatedON AS DateModified,
        tbj.EntryID,
        tbj.ProfileID,
        tbtt.TransactionCode,
        tbj.ReferenceID,
        tbcoa.ChartCode,
        tbcoa.ChartName,
        tbj.Description,
        tbj.Description AS Remarks,
        COALESCE(tbj.Debit, 0) AS Debit,
        COALESCE(tbj.Credit, 0) AS Credit,
        COALESCE(tbj.Discount, 0) AS Discount,
        COALESCE(tbj.BalanceFee, 0) AS BalanceFee,
        COALESCE(tbj.ActualPayment, 0) AS ActualPayment,
        COALESCE(tbj.PaymentDiscount, 0) AS PaymentDiscount 
    FROM
        tb_journal AS tbj
        LEFT JOIN tb_transaction_type AS tbtt ON tbj.TransactionTypeID = tbtt.TransactionTypeID
        LEFT JOIN tb_chart_of_account AS tbcoa ON tbj.ChartAccountID = tbcoa.ChartID 
    WHERE
       ( tbj.ProfileID = ProfileID 
        AND tbtt.TransactionTypeID <> 2) and tbj.is_del != 1 ;
END
;;
delimiter ;

-- ----------------------------
-- Procedure structure for GetAttendanceDetailsBySearch
-- ----------------------------
DROP PROCEDURE IF EXISTS `GetAttendanceDetailsBySearch`;
delimiter ;;
CREATE PROCEDURE `GetAttendanceDetailsBySearch`(IN `AttendanceID` INT, IN `search_term` VARCHAR(255))
BEGIN
    IF search_term IS NOT NULL AND search_term != '' THEN
        SELECT
            tb_profile.UniqueID, 
            tb_profile.FirstName, 
            tb_profile.MiddleName, 
            tb_profile.LastName, 
            tb_attendance_details.Remarks, 
            tb_attendance_details.AttendanceID
        FROM
            tb_profile
        LEFT JOIN
            tb_attendance_details
        ON 
            tb_profile.ProfileID = tb_attendance_details.ProfileID
        WHERE
            (tb_attendance_details.AttendanceID = 1 OR tb_attendance_details.AttendanceID IS NULL)
            AND (
                tb_profile.UniqueID LIKE CONCAT('%', search_term, '%')
                OR tb_profile.FirstName LIKE CONCAT('%', search_term, '%')
                OR tb_profile.MiddleName LIKE CONCAT('%', search_term, '%')
                OR tb_profile.LastName LIKE CONCAT('%', search_term, '%')
                OR tb_attendance_details.Remarks LIKE CONCAT('%', search_term, '%')
            );
    ELSE
        -- Return all records when search_term is empty
        SELECT
            tb_profile.UniqueID, 
            tb_profile.FirstName, 
            tb_profile.MiddleName, 
            tb_profile.LastName, 
            tb_attendance_details.Remarks, 
            tb_attendance_details.AttendanceID
        FROM
            tb_profile
        LEFT JOIN
            tb_attendance_details
        ON 
            tb_profile.ProfileID = tb_attendance_details.ProfileID
        WHERE
            tb_attendance_details.AttendanceID = 1 OR tb_attendance_details.AttendanceID IS NULL limit 1000;
    END IF;
END
;;
delimiter ;

-- ----------------------------
-- Procedure structure for getAttendancePersonneList
-- ----------------------------
DROP PROCEDURE IF EXISTS `getAttendancePersonneList`;
delimiter ;;
CREATE PROCEDURE `getAttendancePersonneList`(IN `AttendanceID` INT, IN `search_term` VARCHAR(255))
BEGIN
    IF search_term IS NOT NULL AND search_term != '' THEN
        SELECT
            tb_profile.UniqueID, 
            tb_profile.FirstName, 
            tb_profile.MiddleName, 
            tb_profile.LastName, 
						CONCAT(tb_profile.LastName,', ',tb_profile.FirstName ) as Fullname,
            tb_attendance_details.Remarks, 
            tb_attendance_details.AttendanceID
        FROM
            tb_profile
        LEFT JOIN
            tb_attendance_details
        ON 
            tb_profile.ProfileID = tb_attendance_details.ProfileID
        WHERE
            (tb_attendance_details.AttendanceID = 1 OR tb_attendance_details.AttendanceID IS NULL)
            AND (
                tb_profile.UniqueID LIKE CONCAT('%', search_term, '%')
                OR tb_profile.FirstName LIKE CONCAT('%', search_term, '%')
                OR tb_profile.MiddleName LIKE CONCAT('%', search_term, '%')
                OR tb_profile.LastName LIKE CONCAT('%', search_term, '%')
                OR tb_attendance_details.Remarks LIKE CONCAT('%', search_term, '%')
            );
    ELSE
        -- Return all records when search_term is empty
        SELECT
            tb_profile.UniqueID, 
            tb_profile.FirstName, 
            tb_profile.MiddleName, 
            tb_profile.LastName, 
						CONCAT(tb_profile.LastName,', ',tb_profile.FirstName ) as Fullname,
            tb_attendance_details.Remarks, 
            tb_attendance_details.AttendanceID
        FROM
            tb_profile
        LEFT JOIN
            tb_attendance_details
        ON 
            tb_profile.ProfileID = tb_attendance_details.ProfileID
        WHERE
            tb_attendance_details.AttendanceID = 1 OR tb_attendance_details.AttendanceID IS NULL limit 1000;
    END IF;
END
;;
delimiter ;

-- ----------------------------
-- Procedure structure for GetContributionSummary
-- ----------------------------
DROP PROCEDURE IF EXISTS `GetContributionSummary`;
delimiter ;;
CREATE PROCEDURE `GetContributionSummary`(IN `p_SearchName` NVARCHAR(255), IN `p_SearchBalanceFee` DECIMAL(10,2), IN `p_SearchDescription` NVARCHAR(255))
BEGIN
    SELECT
        tbc.EntryID,
        tbc.`Name`,
        tbc.BalanceFee,
        tbc.Description,
        SUM(tbca.Debit) AS TotalDebit,
        SUM(tbca.Credit) AS TotalCredit
    FROM
        tb_contribution AS tbc
    LEFT JOIN
        tb_contribution_account AS tbca ON tbc.EntryID = tbca.ContributionID
    WHERE
        (p_SearchName IS NULL OR tbc.`Name` LIKE CONCAT('%', p_SearchName, '%'))
        AND (p_SearchBalanceFee IS NULL OR tbc.BalanceFee = p_SearchBalanceFee)
        AND (p_SearchDescription IS NULL OR tbc.Description LIKE CONCAT('%', p_SearchDescription, '%'))
    GROUP BY
        tbc.EntryID, tbc.`Name`, tbc.BalanceFee, tbc.Description
    ORDER BY
        tbc.EntryID, tbc.EntryID, tbc.`Name`, tbc.BalanceFee, tbc.Description;
END
;;
delimiter ;

-- ----------------------------
-- Procedure structure for GetLedgerEntries
-- ----------------------------
DROP PROCEDURE IF EXISTS `GetLedgerEntries`;
delimiter ;;
CREATE PROCEDURE `GetLedgerEntries`(IN `ProfileID` INT)
BEGIN
    SELECT
		tbj.createdOn as DateTransacted, 
        tbj.EntryID, 
        tbj.ProfileID, 
        tbtt.TransactionCode, 
        tbj.ReferenceID, 
        tbcoa.ChartCode, 
				tbcoa.ChartName,
        tbj.Description, 
				tbj.Description as Remarks, 
        COALESCE(tbj.Debit, 0) AS Debit, 
        COALESCE(tbj.Credit, 0) AS Credit, 
        COALESCE(tbj.Discount, 0) AS Discount, 
        COALESCE(tbj.BalanceFee, 0) AS BalanceFee, 
        COALESCE(tbj.ActualPayment, 0) AS ActualPayment, 
        COALESCE(tbj.PaymentDiscount, 0) AS PaymentDiscount
    FROM
        tb_journal AS tbj
        LEFT JOIN
        tb_transaction_type AS tbtt ON tbj.TransactionTypeID = tbtt.TransactionTypeID
        LEFT JOIN
        tb_chart_of_account AS tbcoa ON tbj.ChartAccountID = tbcoa.ChartID
    WHERE
        tbj.ProfileID = ProfileID
    
    UNION ALL
    
    SELECT
		tbj.createdOn as DateTransacted,
        tbj.EntryID, 
        tbj.ProfileID, 
        tbtt.TransactionCode, 
        tbj.ReferenceID, 
        tbcoa.ChartCode, 
				tbcoa.ChartName,
        CONCAT('Discount',' ') AS Description, 
				CONCAT('Discount',' ') AS Remarks, 
        COALESCE(tbj.Discount, 0) AS Debit, 
        0 AS Credit, 
        0 AS Discount, 
        0 AS BalanceFee, 
        0 AS ActualPayment, 
        0 AS PaymentDiscount
    FROM
        tb_journal AS tbj
        LEFT JOIN
        tb_transaction_type AS tbtt ON tbj.TransactionTypeID = tbtt.TransactionTypeID
        LEFT JOIN
        tb_chart_of_account AS tbcoa ON tbj.ChartAccountID = tbcoa.ChartID
    WHERE
        tbj.ProfileID = ProfileID
        AND tbj.Discount IS NOT NULL
        AND tbj.Discount > 0;
END
;;
delimiter ;

-- ----------------------------
-- Procedure structure for getListofPayment
-- ----------------------------
DROP PROCEDURE IF EXISTS `getListofPayment`;
delimiter ;;
CREATE PROCEDURE `getListofPayment`(IN `p_userID` VARCHAR(255))
BEGIN
    SELECT
        tbcoa.ChartCode, 
        tbcoa.ChartName, 
        tbj.Debit, 
        tbj.EntryID, 
        tbj.Credit as CreditOrig, 
        tbp.UniqueID, tbj.BalanceFee as Credit,tbj.ActualPayment,tbj.PaymentDiscount,
        
        tbp.FirstName, 
        tbp.MiddleName, 
        tbp.LastName, 
        tbp.NameExtension, 
        tbp.Suffix
    FROM
        tb_journal AS tbj
    INNER JOIN
        tb_profile AS tbp ON tbj.ProfileID = tbp.UniqueID
    INNER JOIN
        tb_chart_of_account AS tbcoa ON tbj.ChartAccountID = tbcoa.ChartID
    WHERE
        tbp.UniqueID = p_userID AND tbj.BalanceFee > 0;
END
;;
delimiter ;

-- ----------------------------
-- Procedure structure for getListofPaymenttoAdd
-- ----------------------------
DROP PROCEDURE IF EXISTS `getListofPaymenttoAdd`;
delimiter ;;
CREATE PROCEDURE `getListofPaymenttoAdd`(IN `typePayment` VARCHAR(10), IN `searchvalue` VARCHAR(100))
BEGIN
    IF typePayment = 'CONT' THEN
        -- Query for typePayment CONT
        IF searchvalue = '' THEN
            SELECT
                tbc.EntryID,
                tbc.`Name`,
                tbc.BalanceFee AS TotalPayment,
                tbc.Description,
                tbc.createdOn AS DateCreated 
            FROM
                tb_contribution AS tbc WHERE is_active = 1 AND is_del = 0
            ORDER BY createdOn DESC LIMIT 100;
        ELSE
            SET @sql = CONCAT('
                SELECT
                    tbc.EntryID,
                    tbc.`Name`,
                    tbc.BalanceFee AS TotalPayment,
                    tbc.Description,
                    tbc.createdOn AS DateCreated 
                FROM
                    tb_contribution AS tbc
                WHERE
                    (tbc.`Name` LIKE ? 
                    OR tbc.Description LIKE ?) AND is_active = 1 AND is_del = 0 ORDER BY createdOn DESC LIMIT 100');
            PREPARE stmt FROM @sql;
            SET @searchPattern = CONCAT('%', searchvalue, '%');
            EXECUTE stmt USING @searchPattern, @searchPattern;
            DEALLOCATE PREPARE stmt;
        END IF;
    ELSEIF typePayment = 'ATDNC' THEN
        -- Query for typePayment ATDNC
        IF searchvalue = '' THEN
            SELECT
                tba.EntryID, 
                tba.`Name`, 
                tba.Fines AS TotalPayment, 
                tba.Description, 
                tba.createdOn AS DateCreated
            FROM
                tb_attendance AS tba WHERE is_active = 1 AND is_del = 0
            ORDER BY createdOn DESC LIMIT 100;
        ELSE
            SET @sql = CONCAT('
                SELECT
                    tba.EntryID, 
                    tba.`Name`, 
                    tba.Fines AS TotalPayment, 
                    tba.Description, 
                    tba.createdOn AS DateCreated
                FROM
                    tb_attendance AS tba
                WHERE
                    (tba.`Name` LIKE ? 
                    OR tba.Description LIKE ?) AND is_active = 1 AND is_del = 0 ORDER BY createdOn DESC LIMIT 100');
            PREPARE stmt FROM @sql;
            SET @searchPattern = CONCAT('%', searchvalue, '%');
            EXECUTE stmt USING @searchPattern, @searchPattern;
            DEALLOCATE PREPARE stmt;
        END IF;
    ELSE
        -- Return an empty result set if typePayment doesn't match CONT or ATDNC
        SELECT
            NULL AS EntryID,
            NULL AS Name,
            NULL AS TotalPayment,
            NULL AS Description,
            NULL AS DateCreated
        WHERE 1 = 0; -- Ensure the query returns an empty result set
    END IF;
END
;;
delimiter ;

-- ----------------------------
-- Procedure structure for getListofPaymenttoAdd_1
-- ----------------------------
DROP PROCEDURE IF EXISTS `getListofPaymenttoAdd_1`;
delimiter ;;
CREATE PROCEDURE `getListofPaymenttoAdd_1`(IN `typePayment` VARCHAR(10), IN `searchvalue` VARCHAR(100))
BEGIN
    IF typePayment = 'CONT' THEN
        -- Query for typePayment CONT
        IF searchvalue = '' THEN
            SELECT
                tbc.EntryID,
                tbc.`Name`,
                tbc.BalanceFee AS TotalPayment,
                tbc.Description,
                tbc.createdOn AS DateCreated 
            FROM
                tb_contribution AS tbc where is_active='1' and is_del='0'
            ORDER BY createdOn DESC LIMIT 100;
        ELSE
            SET @sql = CONCAT('
                SELECT
                    tbc.EntryID,
                    tbc.`Name`,
                    tbc.BalanceFee AS TotalPayment,
                    tbc.Description,
                    tbc.createdOn AS DateCreated 
                FROM
                    tb_contribution AS tbc
                WHERE
                   ( tbc.`Name` LIKE ? 
                    OR tbc.Description LIKE ? ) where is_active=1 and is_del=0 ORDER BY createdOn DESC LIMIT 100');
            PREPARE stmt FROM @sql;
            SET @searchPattern = CONCAT('%', searchvalue, '%');
            EXECUTE stmt USING @searchPattern, @searchPattern;
            DEALLOCATE PREPARE stmt;
        END IF;
    ELSEIF typePayment = 'ATDNC' THEN
        -- Query for typePayment ATDNC
        IF searchvalue = '' THEN
            SELECT
                tba.EntryID, 
                tba.`Name`, 
                tba.Fines AS TotalPayment, 
                tba.Description, 
                tba.createdOn AS DateCreated
            FROM
                tb_attendance AS tba where is_active='1' and is_del='0'
            ORDER BY createdOn DESC LIMIT 100;
        ELSE
            SET @sql = CONCAT('
                SELECT
                    tba.EntryID, 
                    tba.`Name`, 
                    tba.Fines AS TotalPayment, 
                    tba.Description, 
                    tba.createdOn AS DateCreated
                FROM
                    tb_attendance AS tba
                WHERE
                    (tba.`Name` LIKE ? 
                    OR tba.Description LIKE ?) where is_active=1 and is_del=0  ORDER BY createdOn DESC LIMIT 100');
            PREPARE stmt FROM @sql;
            SET @searchPattern = CONCAT('%', searchvalue, '%');
            EXECUTE stmt USING @searchPattern, @searchPattern;
            DEALLOCATE PREPARE stmt;
        END IF;
    ELSE
        -- Return an empty result set if typePayment doesn't match CONT or ATDNC
        SELECT
            NULL AS EntryID,
            NULL AS Name,
            NULL AS TotalPayment,
            NULL AS Description,
            NULL AS DateCreated
        WHERE 1 = 0; -- Ensure the query returns an empty result set
    END IF;
END
;;
delimiter ;

-- ----------------------------
-- Procedure structure for getUserAccount
-- ----------------------------
DROP PROCEDURE IF EXISTS `getUserAccount`;
delimiter ;;
CREATE PROCEDURE `getUserAccount`(IN `EmailAddress` VARCHAR(255))
BEGIN
	SELECT * from tb_users where email=EmailAddress and active=1 and is_del=0;
END
;;
delimiter ;

-- ----------------------------
-- Procedure structure for InsertAnnouncement
-- ----------------------------
DROP PROCEDURE IF EXISTS `InsertAnnouncement`;
delimiter ;;
CREATE PROCEDURE `InsertAnnouncement`(IN `p_titlename` NVARCHAR(255), IN `p_description` NVARCHAR(255), IN `p_entry_by` NVARCHAR(255))
BEGIN
    DECLARE v_ProfileID INT;
    DECLARE v_SuccessMessage NVARCHAR(255);

    BEGIN
        -- Insert data into tb_profile
        INSERT INTO tb_announcement(Title, Description,  entry_by,is_active,is_del)
        VALUES (p_titlename, p_description, p_entry_by,1,0);

        -- Get the generated ProfileID
        SET v_ProfileID = LAST_INSERT_ID();

        -- Set success message
        SET v_SuccessMessage = 'success';
    END;

    SELECT v_SuccessMessage AS SuccessMessage, v_ProfileID AS ProfileID;

END
;;
delimiter ;

-- ----------------------------
-- Procedure structure for InsertAttendance
-- ----------------------------
DROP PROCEDURE IF EXISTS `InsertAttendance`;
delimiter ;;
CREATE PROCEDURE `InsertAttendance`(IN `p_Name` NVARCHAR(255), IN `p_Description` NVARCHAR(255), IN `p_Fines` FLOAT, IN `p_DATESCHEDULE` VARCHAR(50))
BEGIN
    DECLARE v_ProfileID INT;
    DECLARE v_SuccessMessage NVARCHAR(255);

    -- Insert data into tb_profile
    INSERT INTO tb_attendance (`Name`, Description, Fines, DateSchedule)
    VALUES (p_Name, p_Description, p_Fines,p_DATESCHEDULE);

    -- Get the generated ProfileID
    SET v_ProfileID = LAST_INSERT_ID();

    -- Set success message
    SET v_SuccessMessage = 'success';

    SELECT v_SuccessMessage AS SuccessMessage, v_ProfileID AS ProfileID;

END
;;
delimiter ;

-- ----------------------------
-- Procedure structure for InsertAttendanceDetails
-- ----------------------------
DROP PROCEDURE IF EXISTS `InsertAttendanceDetails`;
delimiter ;;
CREATE PROCEDURE `InsertAttendanceDetails`(`p_AttendanceID` INT, `p_ProfileID` VARCHAR(255), `p_Remarks` VARCHAR(255))
BEGIN
    DECLARE exit_status INT DEFAULT 0;

    BEGIN
        -- Check if the AttendanceID and ProfileID already exist
        IF EXISTS (
            SELECT 1
            FROM tb_attendance_details
            WHERE AttendanceID = p_AttendanceID AND ProfileID = p_ProfileID
        ) THEN
            -- If exists, update Remarks to 1
            UPDATE tb_attendance_details
            SET Remarks = 1
            WHERE AttendanceID = p_AttendanceID AND ProfileID = p_ProfileID;

            SET exit_status = 1;
        ELSE
            -- If not exists, insert a new record
            INSERT INTO tb_attendance_details (AttendanceID, ProfileID, Remarks)
            VALUES (p_AttendanceID, p_ProfileID, p_Remarks);

            SET exit_status = 1;
        END IF;
    END;

    IF exit_status = 1 THEN
        SELECT LAST_INSERT_ID() AS PrimaryID, 'success' AS SuccessMessage;
    ELSE
        SELECT NULL AS PrimaryID, 'Transaction failed.' AS SuccessMessage;
    END IF;
END
;;
delimiter ;

-- ----------------------------
-- Procedure structure for InsertContributionProfile
-- ----------------------------
DROP PROCEDURE IF EXISTS `InsertContributionProfile`;
delimiter ;;
CREATE PROCEDURE `InsertContributionProfile`(IN `p_Name` NVARCHAR(255), IN `p_BalanceFee` DECIMAL(10,2), IN `p_Description` NVARCHAR(255), IN `p_Active` INT, IN `p_IsDeleted` INT, IN `p_EntryBy` NVARCHAR(255))
BEGIN
    DECLARE v_ContributionID INT;
    DECLARE v_SuccessMessage NVARCHAR(255);

    BEGIN
        -- Insert data into tb_contribution
        INSERT INTO tb_contribution (Name, BalanceFee, Description, is_active, is_del, entry_by)
        VALUES (p_Name, p_BalanceFee, p_Description, p_Active, p_IsDeleted, p_EntryBy);

        -- Get the generated ContributionID
        SET v_ContributionID = LAST_INSERT_ID();

        -- Set success message
         SET v_SuccessMessage = 'success';
    END;

    SELECT v_SuccessMessage AS SuccessMessage, v_ContributionID AS ContributionID;

END
;;
delimiter ;

-- ----------------------------
-- Procedure structure for InsertContributionProfileAuto
-- ----------------------------
DROP PROCEDURE IF EXISTS `InsertContributionProfileAuto`;
delimiter ;;
CREATE PROCEDURE `InsertContributionProfileAuto`(IN `p_Name` NVARCHAR(255), IN `p_BalanceFee` DECIMAL(10,2), IN `p_Description` NVARCHAR(255), IN `p_Active` INT, IN `p_IsDeleted` INT, IN `p_EntryBy` NVARCHAR(255))
BEGIN
    DECLARE v_ContributionID INT;
    DECLARE v_ProfileUniqueID NVARCHAR(255);
    DECLARE v_ContributionAccountID INT;  -- Added variable to store ContributionAccountID
    DECLARE done BOOLEAN DEFAULT FALSE;
    DECLARE cur CURSOR FOR
        SELECT UniqueID
        FROM tb_profile
        WHERE is_active = 1 AND is_del = 0 AND UniqueID IS NOT NULL;

    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;

    BEGIN
        -- Insert data into tb_contribution
        INSERT INTO tb_contribution (Name, BalanceFee, Description, is_active, is_del, entry_by)
        VALUES (p_Name, p_BalanceFee, p_Description, p_Active, p_IsDeleted, p_EntryBy);

        -- Get the generated ContributionID
        SET v_ContributionID = LAST_INSERT_ID();

        -- Use cursor to iterate through tb_profile
        OPEN cur;
        read_loop: LOOP
            FETCH cur INTO v_ProfileUniqueID;

            IF done THEN
                LEAVE read_loop;
            END IF;

            -- Insert data into tb_contribution_account for each valid tb_profile entry
            INSERT INTO tb_contribution_account (ContributionID, ProfileID, BalanceFee, Debit, Credit, is_active, is_del, entry_by)
            VALUES (v_ContributionID, v_ProfileUniqueID, p_BalanceFee,  0, p_BalanceFee, 1, 0, p_EntryBy);

            -- Get the generated ContributionAccountID
            SET v_ContributionAccountID = LAST_INSERT_ID();

            -- Insert data into tb_journal
            INSERT INTO tb_journal (ProfileID, TransactionTypeID, ReferenceID, ChartAccountID, Description,Debit,  Credit, BalanceFee, entry_by, is_del)
            VALUES (v_ProfileUniqueID, 1, v_ContributionAccountID, 1, concat('Contribution: ',  p_Name ), 0,p_BalanceFee,p_BalanceFee,p_EntryBy,0);

        END LOOP;

        CLOSE cur;
    END;

    -- Select success message and v_ContributionID
    SELECT 'success' AS SuccessMessage, v_ContributionID AS ContributionID;

END
;;
delimiter ;

-- ----------------------------
-- Procedure structure for InsertProfile
-- ----------------------------
DROP PROCEDURE IF EXISTS `InsertProfile`;
delimiter ;;
CREATE PROCEDURE `InsertProfile`(IN `p_UniqueID` NVARCHAR(255), IN `p_FirstName` NVARCHAR(255), IN `p_MiddleName` NVARCHAR(255), IN `p_LastName` NVARCHAR(255), IN `p_NameExtension` NVARCHAR(255), IN `p_email` NVARCHAR(255))
BEGIN
    DECLARE v_ProfileID INT;
    DECLARE v_SuccessMessage NVARCHAR(255);

    BEGIN
        -- Insert data into tb_profile
        INSERT INTO tb_profile (UniqueID, FirstName, MiddleName, LastName, NameExtension,  email,is_active,is_del)
        VALUES (p_UniqueID, p_FirstName, p_MiddleName, p_LastName, p_NameExtension, p_email,1,0);

        -- Get the generated ProfileID
        SET v_ProfileID = LAST_INSERT_ID();

        -- Set success message
        SET v_SuccessMessage = 'success';
    END;

    SELECT v_SuccessMessage AS SuccessMessage, v_ProfileID AS ProfileID;

END
;;
delimiter ;

-- ----------------------------
-- Procedure structure for InsertUser
-- ----------------------------
DROP PROCEDURE IF EXISTS `InsertUser`;
delimiter ;;
CREATE PROCEDURE `InsertUser`(IN `p_Username` NVARCHAR(255), IN `p_Password` NVARCHAR(255), IN `p_Email` NVARCHAR(255), IN `p_GroupID` INT, IN `p_ProfileID` NVARCHAR(255), IN `p_FirstName` NVARCHAR(255), IN `p_LastName` NVARCHAR(255), IN `p_Active` INT, IN `p_EntryBy` NVARCHAR(255))
BEGIN
    DECLARE v_UserID INT;
    DECLARE v_SuccessMessage NVARCHAR(255);

    BEGIN
        -- Insert data into tb_users
        INSERT INTO tb_users (Username, Password, Email, group_id, ProfileID, first_name, last_name, active, entry_by, is_del)
        VALUES (p_Username, p_Password, p_Email, p_GroupID, p_ProfileID, p_FirstName, p_LastName, p_Active, p_EntryBy,0);

        -- Get the generated UserID
        SET v_UserID = LAST_INSERT_ID();

        -- Set success message
        SET v_SuccessMessage = CONCAT('success');
    END;

    SELECT v_SuccessMessage AS SuccessMessage, v_UserID AS UserID;

END
;;
delimiter ;

-- ----------------------------
-- Procedure structure for InsertUserwProfileID
-- ----------------------------
DROP PROCEDURE IF EXISTS `InsertUserwProfileID`;
delimiter ;;
CREATE PROCEDURE `InsertUserwProfileID`(IN p_Username NVARCHAR(255),







    IN p_Password NVARCHAR(255),







    IN p_Email NVARCHAR(255),







    IN p_GroupID INT,







    IN p_FirstName NVARCHAR(255),







	







    IN p_LastName NVARCHAR(255),









    IN p_EntryBy NVARCHAR(255),







		IN p_IsDelIndicator NVARCHAR(255),







    IN p_Active NVARCHAR(255),





		





		IN p_EmailVerified NVARCHAR(255),







		IN p_AuthStatus NVARCHAR(255),

		IN p_ProfileID NVARCHAR(100))
BEGIN







    DECLARE v_UserID INT;







    DECLARE v_SuccessMessage NVARCHAR(255);















    BEGIN







        -- Insert data into tb_users







        INSERT INTO tb_users (Username, Password, Email, group_id, first_name, last_name,  entry_by, is_del, active,verify,to_way_auth_status, ProfileID)







        VALUES (p_Username, p_Password, p_Email, p_GroupID,  p_FirstName,p_LastName, p_EntryBy,p_IsDelIndicator,p_Active,  p_EmailVerified, p_AuthStatus, p_ProfileID );















        -- Get the generated UserID







        SET v_UserID = LAST_INSERT_ID();















        -- Set success message







        SET v_SuccessMessage = CONCAT('success');







    END;















    SELECT v_SuccessMessage AS SuccessMessage, v_UserID AS UserID;















END
;;
delimiter ;

-- ----------------------------
-- Procedure structure for newAnnouncement
-- ----------------------------
DROP PROCEDURE IF EXISTS `newAnnouncement`;
delimiter ;;
CREATE PROCEDURE `newAnnouncement`(IN `TitleText` TEXT, IN `DescriptionText` TEXT, IN `EntryByID` INT)
begin
	INSERT into tb_announcement (Title, Description,AnnouncementType, entry_by, is_active, is_del) values (TitleText, DescriptionText,1,EntryByID,1,0);
	SELECT LAST_INSERT_ID() AS PrimaryID, 'success' AS SuccessMessage;
END
;;
delimiter ;

-- ----------------------------
-- Procedure structure for SaveTransactionPayment
-- ----------------------------
DROP PROCEDURE IF EXISTS `SaveTransactionPayment`;
delimiter ;;
CREATE PROCEDURE `SaveTransactionPayment`(IN `p_ORNumber` VARCHAR(255), IN `p_Date` DATE, IN `p_PayorID` TEXT, IN `p_PayorName` VARCHAR(255), IN `p_AmountDue` DECIMAL(10,2), IN `p_CashReceive` DECIMAL(10,2), IN `p_ChangeAmount` DECIMAL(10,2), IN `p_Discount` DECIMAL(10,2), IN `p_AmountinWords` VARCHAR(255), IN `p_CashierID` TEXT, IN `p_entry_by` VARCHAR(255))
BEGIN
    DECLARE v_CurrentId INT;

    -- Insert data into the table
    INSERT INTO tb_officialreceipts (ORNo, Date, PayorID, PayorName, AmountDue, CashReceive, `Change`, Discount, AmountinWords, CashierID, entry_by)
    VALUES (p_ORNumber,p_Date, p_PayorID, p_PayorName, p_AmountDue, p_CashReceive, p_ChangeAmount, p_Discount, p_AmountinWords, p_CashierID, p_entry_by);

    -- Get the last inserted ID
    SET v_CurrentId = LAST_INSERT_ID();

    -- Return the current primary ID and success message
    SELECT v_CurrentId AS CurrentID, 'success' AS SuccessMessage;
END
;;
delimiter ;

-- ----------------------------
-- Procedure structure for SaveTransactionPaymentDetails
-- ----------------------------
DROP PROCEDURE IF EXISTS `SaveTransactionPaymentDetails`;
delimiter ;;
CREATE PROCEDURE `SaveTransactionPaymentDetails`(IN `_EntryID` INT, IN `_TransactionTypeID` INT, IN `_ReferenceID` INT, IN `_ChartAccountID` INT, IN `_Description` TEXT, IN `_AmountPaid` DOUBLE, IN `_Payor` TEXT, IN `_PayorID` TEXT, IN `_Discount` DOUBLE, IN `_TransRefNo` VARCHAR(100), IN `_entryBy` VARCHAR(100))
BEGIN
    -- Declare variables to store data retrieved from tb_journals
    DECLARE _ActualPayment DOUBLE;
    DECLARE _BalanceFee DOUBLE;
		DECLARE _PaymentDiscount DOUBLE;

    -- Retrieve ActualPayment and BalanceFee from tb_journals using EntryID
    SELECT COALESCE(ActualPayment, 0), COALESCE(BalanceFee, 0), COALESCE(PaymentDiscount, 0)
    INTO _ActualPayment, _BalanceFee, _PaymentDiscount
    FROM tb_journal
    WHERE EntryID = _EntryID;

    -- Insert the provided parameters into tb_transaction_payment_details
		INSERT INTO tb_officialreceipts_details (TransactionTypeID, ReferenceID, ChartAccountID, Description, debit, Payor, PayorID, Discount, TransRefNo,ProfileID,is_del,entry_by)
    VALUES (_TransactionTypeID, _ReferenceID, _ChartAccountID, _Description, _AmountPaid, _Payor, _PayorID, _Discount, _TransRefNo,_PayorID,0,_entryBy);
		 -- Insert the provided parameters into tb_journal
    INSERT INTO tb_journal (TransactionTypeID, ReferenceID, ChartAccountID, Description, debit, Payor, PayorID, Discount, TransRefNo,ProfileID,is_del, entry_by)
    VALUES (_TransactionTypeID, _ReferenceID, _ChartAccountID, _Description, _AmountPaid, _Payor, _PayorID, _Discount, _TransRefNo,_PayorID,0,_entryBy);

    -- Update tb_journal with the provided parameters
    UPDATE tb_journal
    SET ActualPayment = COALESCE(_ActualPayment, 0) + (_AmountPaid - _Discount),
        BalanceFee = COALESCE(_BalanceFee, 0) - _AmountPaid,
				PaymentDiscount = COALESCE(_PaymentDiscount, 0) + _Discount
    WHERE EntryID = _EntryID;

    -- Optionally, you can perform additional actions or validations here
    
    -- Print a message indicating success
    SELECT 'success' AS Message;
END
;;
delimiter ;

-- ----------------------------
-- Procedure structure for unlockAccount
-- ----------------------------
DROP PROCEDURE IF EXISTS `unlockAccount`;
delimiter ;;
CREATE PROCEDURE `unlockAccount`(IN `accountID` VARCHAR(50), IN `statusval` VARCHAR(50))
BEGIN
    DECLARE compare VARCHAR(50);

    -- Check if the provided statusval is valid
    IF statusval != '0' THEN
        SELECT 'error' AS ErrorMessage;
    ELSE
        -- Check if the account exists
        SELECT is_lock INTO compare FROM tb_users WHERE id = accountID;
        
        -- If no rows were found, the account does not exist
        IF compare IS NULL THEN
            SELECT 'error' AS ErrorMessage;
        ELSE
            -- Check if the current state matches the desired state
            IF compare = statusval THEN
                SELECT 'error' AS SuccessMessage;
            ELSE
                -- Otherwise, proceed to update the account status
                UPDATE tb_users
                SET is_lock = statusval
                WHERE id = accountID;

                -- Check if the update was successful
                IF ROW_COUNT() > 0 THEN
                    SELECT 'success' AS SuccessMessage;
                ELSE
                    SELECT 'error' AS ErrorMessage;
                END IF;
            END IF;
        END IF;
    END IF;
END
;;
delimiter ;

-- ----------------------------
-- Procedure structure for updateAnnouncement
-- ----------------------------
DROP PROCEDURE IF EXISTS `updateAnnouncement`;
delimiter ;;
CREATE PROCEDURE `updateAnnouncement`(IN `profile_id` VARCHAR(50), IN `new_title_name` VARCHAR(50), IN `new_description_name` VARCHAR(50))
BEGIN
    UPDATE tb_announcement
    SET Title = new_title_name,
        Description = new_description_name
    WHERE EntryID = profile_id;

    IF ROW_COUNT() > 0 THEN
        SELECT 'success' AS SuccessMessage;
    ELSE
        SELECT 'No profile found for the given ID' AS SuccessMessage;
    END IF;
END
;;
delimiter ;

-- ----------------------------
-- Procedure structure for UpdateCreditonJournal
-- ----------------------------
DROP PROCEDURE IF EXISTS `UpdateCreditonJournal`;
delimiter ;;
CREATE PROCEDURE `UpdateCreditonJournal`(IN `p_entryid` INT, IN `p_new_credit` DECIMAL(65,2), IN `p_new_remarks` VARCHAR(50))
BEGIN
 DECLARE v_SuccessMessage NVARCHAR(255); 
    UPDATE tb_journal
    SET credit = p_new_credit, Description = p_new_remarks
    WHERE entryid = p_entryid;
		
		IF ROW_COUNT() > 0 THEN
		
			SET v_SuccessMessage = 'success';
			
			else 
			SET v_SuccessMessage = 'error';
			end if;
			SELECT v_SuccessMessage AS SuccessMessage;
END
;;
delimiter ;

-- ----------------------------
-- Procedure structure for updateProfile
-- ----------------------------
DROP PROCEDURE IF EXISTS `updateProfile`;
delimiter ;;
CREATE PROCEDURE `updateProfile`(IN `profile_id` VARCHAR(50), IN `new_first_name` VARCHAR(50), IN `new_middle_name` VARCHAR(50), IN `new_last_name` VARCHAR(50), IN `new_suffix` VARCHAR(10), IN `new_email` VARCHAR(100))
BEGIN
    UPDATE tb_profile
    SET FirstName = new_first_name,
        MiddleName = new_middle_name,
        LastName = new_last_name,
        Suffix = new_suffix,
        Email = new_email
    WHERE UniqueID = profile_id;

    IF ROW_COUNT() > 0 THEN
        SELECT 'success' AS SuccessMessage;
    ELSE
        SELECT 'No profile found for the given ID' AS SuccessMessage;
    END IF;
END
;;
delimiter ;

-- ----------------------------
-- Procedure structure for updateSystemUsers
-- ----------------------------
DROP PROCEDURE IF EXISTS `updateSystemUsers`;
delimiter ;;
CREATE PROCEDURE `updateSystemUsers`(IN `profile_id` VARCHAR(50), IN `new_first_name` VARCHAR(50), IN `new_middle_name` VARCHAR(50), IN `new_last_name` VARCHAR(50), IN `new_email` VARCHAR(100), IN `GroupID` VARCHAR(100))
BEGIN
    UPDATE tb_users
    SET first_name = new_first_name,
        middle_name = new_middle_name,
        last_name = new_last_name,
        email = new_email, 
        group_id = GroupID
    WHERE id = profile_id;

    IF ROW_COUNT() > 0 THEN
        SELECT 'success' AS SuccessMessage;
    ELSE
        SELECT 'No profile found for the given ID' AS SuccessMessage;
    END IF;
END
;;
delimiter ;

-- ----------------------------
-- Triggers structure for table tb_announcement
-- ----------------------------
DROP TRIGGER IF EXISTS `trg_announcement_createdOn`;
delimiter ;;
CREATE TRIGGER `trg_announcement_createdOn` BEFORE INSERT ON `tb_announcement` FOR EACH ROW BEGIN
    SET NEW.createdOn = CURRENT_TIMESTAMP();
END
;;
delimiter ;

-- ----------------------------
-- Triggers structure for table tb_announcement
-- ----------------------------
DROP TRIGGER IF EXISTS `trg_announcement_updatedOn`;
delimiter ;;
CREATE TRIGGER `trg_announcement_updatedOn` BEFORE UPDATE ON `tb_announcement` FOR EACH ROW BEGIN
    SET NEW.updatedOn = CURRENT_TIMESTAMP();
END
;;
delimiter ;

-- ----------------------------
-- Triggers structure for table tb_attendance
-- ----------------------------
DROP TRIGGER IF EXISTS `trg_insert_attendance`;
delimiter ;;
CREATE TRIGGER `trg_insert_attendance` BEFORE INSERT ON `tb_attendance` FOR EACH ROW BEGIN
    SET NEW.createdOn = NOW();
END
;;
delimiter ;

-- ----------------------------
-- Triggers structure for table tb_attendance
-- ----------------------------
DROP TRIGGER IF EXISTS `trg_update_attendance`;
delimiter ;;
CREATE TRIGGER `trg_update_attendance` BEFORE UPDATE ON `tb_attendance` FOR EACH ROW BEGIN
    SET NEW.updatedOn = NOW();
END
;;
delimiter ;

-- ----------------------------
-- Triggers structure for table tb_contribution
-- ----------------------------
DROP TRIGGER IF EXISTS `set_default_is_del`;
delimiter ;;
CREATE TRIGGER `set_default_is_del` BEFORE INSERT ON `tb_contribution` FOR EACH ROW BEGIN
    IF NEW.is_del IS NULL THEN
        SET NEW.is_del = 0;
    END IF;
		IF NEW.is_active IS NULL THEN
        SET NEW.is_active = 1;
    END IF;
END
;;
delimiter ;

-- ----------------------------
-- Triggers structure for table tb_contribution
-- ----------------------------
DROP TRIGGER IF EXISTS `trg_insert_contribution`;
delimiter ;;
CREATE TRIGGER `trg_insert_contribution` BEFORE INSERT ON `tb_contribution` FOR EACH ROW BEGIN
    SET NEW.createdOn = NOW();
END
;;
delimiter ;

-- ----------------------------
-- Triggers structure for table tb_contribution
-- ----------------------------
DROP TRIGGER IF EXISTS `trg_update_contribution`;
delimiter ;;
CREATE TRIGGER `trg_update_contribution` BEFORE UPDATE ON `tb_contribution` FOR EACH ROW BEGIN
    SET NEW.updatedOn = NOW();
END
;;
delimiter ;

-- ----------------------------
-- Triggers structure for table tb_contribution_account
-- ----------------------------
DROP TRIGGER IF EXISTS `trg_insert_contribution_account`;
delimiter ;;
CREATE TRIGGER `trg_insert_contribution_account` BEFORE INSERT ON `tb_contribution_account` FOR EACH ROW BEGIN
    SET NEW.createdOn = NOW();
END
;;
delimiter ;

-- ----------------------------
-- Triggers structure for table tb_contribution_account
-- ----------------------------
DROP TRIGGER IF EXISTS `trg_update_contribution_account`;
delimiter ;;
CREATE TRIGGER `trg_update_contribution_account` BEFORE UPDATE ON `tb_contribution_account` FOR EACH ROW BEGIN
    SET NEW.updatedOn = NOW();
END
;;
delimiter ;

-- ----------------------------
-- Triggers structure for table tb_journal
-- ----------------------------
DROP TRIGGER IF EXISTS `trg_insert_journal`;
delimiter ;;
CREATE TRIGGER `trg_insert_journal` BEFORE INSERT ON `tb_journal` FOR EACH ROW BEGIN
    SET NEW.createdOn = NOW();
END
;;
delimiter ;

-- ----------------------------
-- Triggers structure for table tb_journal
-- ----------------------------
DROP TRIGGER IF EXISTS `trg_update_journal`;
delimiter ;;
CREATE TRIGGER `trg_update_journal` BEFORE UPDATE ON `tb_journal` FOR EACH ROW BEGIN
    SET NEW.updatedOn = NOW();
END
;;
delimiter ;

-- ----------------------------
-- Triggers structure for table tb_journal
-- ----------------------------
DROP TRIGGER IF EXISTS `update_balancefee_trigger`;
delimiter ;;
CREATE TRIGGER `update_balancefee_trigger` BEFORE UPDATE ON `tb_journal` FOR EACH ROW BEGIN
    IF NEW.credit <> OLD.credit THEN
        SET NEW.balancefee = NEW.credit - (NEW.ActualPayment + NEW.paymentdiscount);
    END IF;
END
;;
delimiter ;

-- ----------------------------
-- Triggers structure for table tb_officialreceipts_details
-- ----------------------------
DROP TRIGGER IF EXISTS `trg_insert_officialreceipts_details`;
delimiter ;;
CREATE TRIGGER `trg_insert_officialreceipts_details` BEFORE INSERT ON `tb_officialreceipts_details` FOR EACH ROW BEGIN
    SET NEW.createdOn = NOW();
END
;;
delimiter ;

-- ----------------------------
-- Triggers structure for table tb_officialreceipts_details
-- ----------------------------
DROP TRIGGER IF EXISTS `trg_update_officialreceipts_details`;
delimiter ;;
CREATE TRIGGER `trg_update_officialreceipts_details` BEFORE UPDATE ON `tb_officialreceipts_details` FOR EACH ROW BEGIN
    SET NEW.updatedOn = NOW();
END
;;
delimiter ;

-- ----------------------------
-- Triggers structure for table tb_profile
-- ----------------------------
DROP TRIGGER IF EXISTS `before_insert_tb_profile`;
delimiter ;;
CREATE TRIGGER `before_insert_tb_profile` BEFORE INSERT ON `tb_profile` FOR EACH ROW BEGIN
    IF NEW.uniqueID IS NULL OR NEW.uniqueID = '' THEN
        -- Generate the current date in YYYYmmdd format
        SET @current_date = DATE_FORMAT(NOW(), '%Y%m%d');

        -- Find the current maximum increment for the day
        SELECT IFNULL(MAX(CAST(SUBSTRING(uniqueID, 9, 4) AS UNSIGNED)), 0) + 1 INTO @max_id
        FROM tb_profile
        WHERE uniqueID LIKE CONCAT(@current_date, '%');

        -- Generate the new uniqueID
        SET NEW.uniqueID = CONCAT(@current_date, LPAD(@max_id, 4, '0'));
    END IF;
END
;;
delimiter ;

-- ----------------------------
-- Triggers structure for table tb_users
-- ----------------------------
DROP TRIGGER IF EXISTS `trg_insert_users`;
delimiter ;;
CREATE TRIGGER `trg_insert_users` BEFORE INSERT ON `tb_users` FOR EACH ROW BEGIN
    SET NEW.createdOn = NOW();
    SET NEW.updatedOn = NOW();
END
;;
delimiter ;

-- ----------------------------
-- Triggers structure for table tb_users
-- ----------------------------
DROP TRIGGER IF EXISTS `trg_update_users`;
delimiter ;;
CREATE TRIGGER `trg_update_users` BEFORE UPDATE ON `tb_users` FOR EACH ROW BEGIN
    SET NEW.updatedOn = NOW();
END
;;
delimiter ;

SET FOREIGN_KEY_CHECKS = 1;
