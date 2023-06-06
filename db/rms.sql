-- Adminer 4.8.1 MySQL 8.0.32 dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `tbl_setting_contact`;
CREATE TABLE `tbl_setting_contact` (
  `SetCon_ID` int NOT NULL AUTO_INCREMENT,
  `SetConLocation` varchar(99) NOT NULL,
  `SetConEmail` varchar(99) NOT NULL,
  `SetConContactNo` varchar(99) NOT NULL,
  PRIMARY KEY (`SetCon_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `tbl_setting_contact` (`SetCon_ID`, `SetConLocation`, `SetConEmail`, `SetConContactNo`) VALUES
(1,	'sample',	'sample@email.com',	'123123123');

DROP TABLE IF EXISTS `tblaccomodation`;
CREATE TABLE `tblaccomodation` (
  `ACCOMID` int NOT NULL AUTO_INCREMENT,
  `ACCOMODATION` varchar(30) NOT NULL,
  `ACCOMDESC` varchar(90) NOT NULL,
  `max_person_included` int NOT NULL,
  `price` double NOT NULL,
  PRIMARY KEY (`ACCOMID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `tblaccomodation` (`ACCOMID`, `ACCOMODATION`, `ACCOMDESC`, `max_person_included`, `price`) VALUES
(16,	'Whole resort',	'WHOLE RESORT FOR 1 DAY',	50,	25000),
(18,	'Barkada Package',	'1 Cottage and all commodities(max 15pax)',	15,	1500),
(20,	'Per head',	'Entrance Fee',	1,	100),
(22,	'Cottage 2',	'2nd cottage 500',	5,	1000),
(23,	'Cottage 1',	'1st cottage 500 desc',	10,	1500);

DROP TABLE IF EXISTS `tblauto`;
CREATE TABLE `tblauto` (
  `autoid` int NOT NULL AUTO_INCREMENT,
  `start` int NOT NULL,
  `end` int NOT NULL,
  PRIMARY KEY (`autoid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `tblauto` (`autoid`, `start`, `end`) VALUES
(1,	11241,	1);

DROP TABLE IF EXISTS `tblfirstpartition`;
CREATE TABLE `tblfirstpartition` (
  `FirstPID` int NOT NULL AUTO_INCREMENT,
  `FirstPTitle` text NOT NULL,
  `FirstPImage` varchar(99) NOT NULL,
  `FirstPSubTitle` text NOT NULL,
  `FirstPDescription` text NOT NULL,
  PRIMARY KEY (`FirstPID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `tblfirstpartition` (`FirstPID`, `FirstPTitle`, `FirstPImage`, `FirstPSubTitle`, `FirstPDescription`) VALUES
(1,	'Welcome to Dragon House',	'5page-img1.png',	'In our Hotel',	'Located on the hills of Nice, a short distance from the famous Promenade des Anglais, Hotel Anis is one of the hotels in the Costa Azzurra (or Blue Coast) able to satisfy the different needs of its guests with comfort and first rate services. It is only 2 km from the airport and from highway exits. The hotel has a large parking area , a real luxury in a city like Nice.');

DROP TABLE IF EXISTS `tblguest`;
CREATE TABLE `tblguest` (
  `GUESTID` int NOT NULL AUTO_INCREMENT,
  `REFNO` int NOT NULL,
  `G_FNAME` varchar(30) NOT NULL,
  `G_LNAME` varchar(30) NOT NULL,
  `G_CITY` varchar(90) NOT NULL,
  `G_ADDRESS` varchar(90) NOT NULL,
  `DBIRTH` date NOT NULL,
  `G_PHONE` varchar(20) NOT NULL,
  `G_NATIONALITY` varchar(30) NOT NULL,
  `G_COMPANY` varchar(90) NOT NULL,
  `G_CADDRESS` varchar(90) NOT NULL,
  `G_TERMS` tinyint NOT NULL,
  `G_EMAIL` varchar(99) NOT NULL,
  `G_UNAME` varchar(255) NOT NULL,
  `G_PASS` varchar(255) NOT NULL,
  `ZIP` int NOT NULL,
  `LOCATION` varchar(125) NOT NULL,
  PRIMARY KEY (`GUESTID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `tblguest` (`GUESTID`, `REFNO`, `G_FNAME`, `G_LNAME`, `G_CITY`, `G_ADDRESS`, `DBIRTH`, `G_PHONE`, `G_NATIONALITY`, `G_COMPANY`, `G_CADDRESS`, `G_TERMS`, `G_EMAIL`, `G_UNAME`, `G_PASS`, `ZIP`, `LOCATION`) VALUES
(11122,	0,	'Receptionist',	'',	'',	'nueva vizcaya',	'2022-07-01',	'092929292921',	'Filipino',	'ewww',	'bambang',	1,	'sample@gmail.com',	'User',	'8cb2237d0679ca88db6464eac60da96345513964',	1233,	'guest/photos/shiro2.jpg');

DROP TABLE IF EXISTS `tblmeal`;
CREATE TABLE `tblmeal` (
  `MealID` int NOT NULL AUTO_INCREMENT,
  `MealType` varchar(90) NOT NULL,
  `MealPrice` double NOT NULL,
  PRIMARY KEY (`MealID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `tblmeal` (`MealID`, `MealType`, `MealPrice`) VALUES
(4,	'Lunch',	10),
(7,	'HB',	10);

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `tblpay`;
CREATE TABLE `tblpay` (
  `id` int NOT NULL AUTO_INCREMENT,
  `confirmation_code` varchar(50) NOT NULL,
  `payment` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `tblpay` (`id`, `confirmation_code`, `payment`) VALUES
(3,	'e6z77jvg',	200),
(4,	'e6z77jvg',	1000),
(7,	'e6z77jvg',	50),
(8,	'e6z77jvg',	1500),
(9,	'z7i2w2md',	50),
(10,	'z7i2w2md',	200);

DROP TABLE IF EXISTS `tblpayment`;
CREATE TABLE `tblpayment` (
  `SUMMARYID` int NOT NULL AUTO_INCREMENT,
  `TRANSDATE` datetime NOT NULL,
  `CONFIRMATIONCODE` varchar(30) NOT NULL,
  `PQTY` int NOT NULL,
  `GUESTID` int NOT NULL,
  `SPRICE` double NOT NULL,
  `MSGVIEW` tinyint(1) NOT NULL,
  `STATUS` varchar(30) NOT NULL,
  `client_name` varchar(50) NOT NULL,
  `number` varchar(100) NOT NULL,
  `address` varchar(1000) NOT NULL,
  PRIMARY KEY (`SUMMARYID`),
  UNIQUE KEY `CONFIRMATIONCODE` (`CONFIRMATIONCODE`),
  KEY `GUESTID` (`GUESTID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `tblpayment` (`SUMMARYID`, `TRANSDATE`, `CONFIRMATIONCODE`, `PQTY`, `GUESTID`, `SPRICE`, `MSGVIEW`, `STATUS`, `client_name`, `number`, `address`) VALUES
(108,	'2023-06-01 09:22:19',	'p0isjedw',	1,	11122,	1000,	0,	'Confirmed',	'awd sdasd',	'093231823232',	'buag'),
(109,	'2023-06-01 09:23:52',	'i2yvxgsm',	1,	11122,	1000,	0,	'Confirmed',	'aaron domingo',	'8327123726',	'buag'),
(110,	'2023-06-01 09:29:12',	'gfmjjkwp',	1,	11122,	25000,	0,	'Checkedin',	'right now',	'09832712326',	'buag');

DROP TABLE IF EXISTS `tblreservation`;
CREATE TABLE `tblreservation` (
  `RESERVEID` int NOT NULL AUTO_INCREMENT,
  `CONFIRMATIONCODE` varchar(50) NOT NULL,
  `TRANSDATE` date NOT NULL,
  `ACCOMOID` int NOT NULL,
  `ARRIVAL` datetime NOT NULL,
  `DEPARTURE` datetime NOT NULL,
  `RPRICE` double NOT NULL,
  `GUESTID` int NOT NULL,
  `PRORPOSE` varchar(30) NOT NULL,
  `STATUS` varchar(11) NOT NULL,
  `BOOKDATE` datetime NOT NULL ON UPDATE CURRENT_TIMESTAMP,
  `REMARKS` text NOT NULL,
  `accom_qty` int NOT NULL DEFAULT '1',
  `USERID` int NOT NULL,
  `client_name` varchar(50) NOT NULL,
  `mnumber` bigint NOT NULL,
  `address` varchar(100) NOT NULL,
  `paid` tinyint NOT NULL DEFAULT '0',
  PRIMARY KEY (`RESERVEID`),
  KEY `ROOMID` (`ACCOMOID`),
  KEY `GUESTID` (`GUESTID`),
  KEY `CONFIRMATIONCODE` (`CONFIRMATIONCODE`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `tblreservation` (`RESERVEID`, `CONFIRMATIONCODE`, `TRANSDATE`, `ACCOMOID`, `ARRIVAL`, `DEPARTURE`, `RPRICE`, `GUESTID`, `PRORPOSE`, `STATUS`, `BOOKDATE`, `REMARKS`, `accom_qty`, `USERID`, `client_name`, `mnumber`, `address`, `paid`) VALUES
(159,	'e6z77jvg',	'2023-06-05',	22,	'2023-06-05 00:00:00',	'2023-06-06 00:00:00',	1000,	0,	'Travel',	'Checkedout',	'2023-06-05 16:55:26',	'',	1,	0,	'Ad Do',	938212372,	'buag',	1),
(160,	'e6z77jvg',	'2023-06-05',	23,	'2023-06-05 00:00:00',	'2023-06-06 00:00:00',	1500,	0,	'Travel',	'Checkedout',	'2023-06-05 16:54:38',	'additional',	1,	0,	'Ad Do',	938212372,	'buag',	0),
(161,	'e6z77jvg',	'2023-06-05',	20,	'2023-06-05 00:00:00',	'2023-06-06 00:00:00',	100,	0,	'Travel',	'Checkedout',	'2023-06-05 16:54:38',	'additional',	1,	0,	'Ad Do',	938212372,	'buag',	0),
(162,	'e6z77jvg',	'2023-06-05',	20,	'2023-06-05 00:00:00',	'2023-06-06 00:00:00',	100,	0,	'Travel',	'Checkedout',	'2023-06-05 16:54:38',	'additional',	1,	0,	'Ad Do',	938212372,	'buag',	0),
(163,	'z7i2w2md',	'2023-06-05',	16,	'2023-06-06 00:00:00',	'2023-06-07 00:00:00',	25000,	0,	'Travel',	'Pending',	'2023-06-05 17:12:53',	'',	1,	0,	'WAwa  wew wawewe',	938212372,	'buag',	0),
(164,	'oejr8roa',	'2023-06-05',	18,	'2023-06-05 00:00:00',	'2023-06-06 00:00:00',	1500,	0,	'Travel',	'Pending',	'2023-06-05 09:22:45',	'',	1,	0,	'Aaron Do',	938212372,	'buag',	0);

DROP TABLE IF EXISTS `tblroom`;
CREATE TABLE `tblroom` (
  `ROOMID` int NOT NULL AUTO_INCREMENT,
  `ROOMNUM` int NOT NULL,
  `ACCOMID` int NOT NULL,
  `ROOM` varchar(30) NOT NULL,
  `ROOMDESC` varchar(255) NOT NULL,
  `NUMPERSON` int NOT NULL,
  `PRICE` double NOT NULL,
  `ROOMIMAGE` varchar(255) NOT NULL,
  `OROOMNUM` int NOT NULL,
  `RoomTypeID` int NOT NULL,
  PRIMARY KEY (`ROOMID`),
  KEY `ACCOMID` (`ACCOMID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `tblroom` (`ROOMID`, `ROOMNUM`, `ACCOMID`, `ROOM`, `ROOMDESC`, `NUMPERSON`, `PRICE`, `ROOMIMAGE`, `OROOMNUM`, `RoomTypeID`) VALUES
(17,	-7,	12,	'Cootage 1',	'SAmple',	5,	1500,	'rooms/202207231346_7.jpg',	-4,	0),
(18,	-2,	12,	'sample',	'asd',	5,	200,	'rooms/202207241619_home.jpg',	1,	0),
(19,	-39,	16,	'WHOLE RESORT',	'RENT FOR PARTY',	50,	25000,	'rooms/202207281525_home.jpg',	1,	0),
(21,	-1,	19,	'Cottage Fee',	'per Rent',	5,	1000,	'rooms/202207281530_home.jpg',	1,	0),
(26,	-10,	22,	'cottage 2',	'max of 5',	5,	1000,	'rooms/202302171338_2.jpg',	0,	0),
(27,	-6,	23,	'cottage 1',	'max of 10',	10,	1500,	'rooms/202302171339_1.jpg',	1,	0),
(28,	-7,	20,	'Fee per Person',	'Fee per Person',	1,	100,	'rooms/202302171339_1.png',	0,	0),
(29,	-18,	18,	'Barkada Package',	'1 cottage and commodities',	15,	1500,	'rooms/202302171339_3.jpg',	1,	0);

DROP TABLE IF EXISTS `tblroomtype`;
CREATE TABLE `tblroomtype` (
  `RoomTypeID` int NOT NULL AUTO_INCREMENT,
  `RoomType` varchar(30) NOT NULL,
  PRIMARY KEY (`RoomTypeID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `tblslideshow`;
CREATE TABLE `tblslideshow` (
  `SlideID` int NOT NULL AUTO_INCREMENT,
  `SlideImage` text NOT NULL,
  `SlideCaption` text NOT NULL,
  PRIMARY KEY (`SlideID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `tblslideshow` (`SlideID`, `SlideImage`, `SlideCaption`) VALUES
(15,	'images.jpg',	''),
(16,	'slide-image-3.jpg',	''),
(17,	'header-bg1.jpg',	''),
(18,	'slide-image-3.jpg',	''),
(19,	'Desert.jpg',	''),
(20,	'Koala.jpg',	'');

DROP TABLE IF EXISTS `tbltitle`;
CREATE TABLE `tbltitle` (
  `TItleID` int NOT NULL AUTO_INCREMENT,
  `Title` text NOT NULL,
  `Subtitle` text NOT NULL,
  PRIMARY KEY (`TItleID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `tbltitle` (`TItleID`, `Title`, `Subtitle`) VALUES
(1,	'Sample',	'24hrs.');

DROP TABLE IF EXISTS `tbluseraccount`;
CREATE TABLE `tbluseraccount` (
  `USERID` int NOT NULL AUTO_INCREMENT,
  `UNAME` varchar(30) NOT NULL,
  `USER_NAME` varchar(30) NOT NULL,
  `UPASS` varchar(90) NOT NULL,
  `ROLE` varchar(30) NOT NULL,
  `PHONE` int NOT NULL,
  PRIMARY KEY (`USERID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `tbluseraccount` (`USERID`, `UNAME`, `USER_NAME`, `UPASS`, `ROLE`, `PHONE`) VALUES
(3,	'Admin',	'admin',	'649060c518b8de3292aed1127000b9c93e4ff1eb',	'Administrator',	123456789);

-- 2023-06-06 02:00:30
