-- phpMyAdmin SQL Dump
-- version 4.2.12deb2+deb8u2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 21, 2017 at 06:00 PM
-- Server version: 5.6.30-1~bpo8+1
-- PHP Version: 5.6.30-0+deb8u1

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
  `name` varchar(50) NOT NULL,
  `add1` varchar(50) NOT NULL,
  `city` varchar(50) NOT NULL,
  `gstno` varchar(14) NOT NULL,
  `from_date` date NOT NULL,
  `to_date` date NOT NULL
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
  `discount` int(11) NOT NULL,
  `cashdisc` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `details`
--

INSERT INTO `details` (`id`, `summary_id`, `item_id`, `quantity`, `discount`, `cashdisc`) VALUES
(1, 1, 4, 1, 0, 0),
(2, 1, 4, 1, 0, 0);

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
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `item`
--

INSERT INTO `item` (`id`, `cat_id`, `code`, `rate`, `title`, `party_id`, `hsn`, `grate`) VALUES
(4, 1, 'AA100', '25.00', 'LIFE OF SRI RAMAKRISHNA-CHANGED-AGAIN-BACK1', 895, '48102211', '0.00'),
(10, 1, 'BGM002', '12.00', 'ELI EDDELI', 866, '45214587', '10.00'),
(33, 1, 'aa101', '25.00', 'LIFE OF RAMAKRISHNA', 880, '142547', '11.00');

-- --------------------------------------------------------

--
-- Table structure for table `item_cat`
--

CREATE TABLE IF NOT EXISTS `item_cat` (
`id` int(11) NOT NULL,
  `code` varchar(3) NOT NULL,
  `name` varchar(30) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `item_cat`
--

INSERT INTO `item_cat` (`id`, `code`, `name`) VALUES
(1, 'B', 'Books'),
(2, 'R', 'Articles');

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE IF NOT EXISTS `locations` (
`id` int(11) NOT NULL,
  `code` varchar(5) NOT NULL,
  `description` varchar(30) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `locations`
--

INSERT INTO `locations` (`id`, `code`, `description`) VALUES
(1, 'ASHR', 'Fort Ashrama'),
(2, 'RLY', 'Railway Station Counter'),
(3, 'TC', 'Town Center');

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
  `state` varchar(20) NOT NULL,
  `pin` varchar(6) NOT NULL,
  `email` varchar(50) NOT NULL,
  `i_e` varchar(1) NOT NULL,
  `st` varchar(1) NOT NULL,
  `gstno` varchar(14) NOT NULL,
  `remark` varchar(50) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1048 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `party`
--

INSERT INTO `party` (`id`, `code`, `name`, `add1`, `add2`, `city`, `state`, `pin`, `email`, `i_e`, `st`, `gstno`, `remark`) VALUES
(1, 'RKM-AA', 'Advaita Ashrama', '5 DEHI ENTALLY ROAD', 'TEST', 'KOLKATA', 'WB', '111111', 'DFSDFFSD@GMAIL.COM', 'E', 'O', '12345678901234', 'TEST'),
(856, 'ADVT', 'ADVAITA ASHRAMA, KOLKATA', '5 DEHI ENTALLY ROAD', '', 'KOLKATA1', 'WB', '', '', 'E', 'O', '19AAATR3497GAZ', ''),
(864, 'BGLKT', 'RAMAKRISHNA VIVEKANANDA ASHRAMA -BGLKT', 'NEAR ENGINEERING COLLEGE', ' STAFF QUARTERS, VIDYAGIRI,', 'BAGALKOTE', '', '587102', '', 'E', '', '', ''),
(865, 'BGM', 'RAMAKRISHNA MISSION ASHRAMA, BELAGAVI', 'FORT,', 'BELGAUM-590016', 'BELAGAVI', '', '590016', '', 'I', 'I', '', ''),
(866, 'BGMS', 'RAMAKRISHNA MISSION ASHRAMA-SUB CEN BGM', '', '', '        BELGAUM', '', '', '', 'I', '', '', ''),
(868, 'BHATI', 'BHATI TRADERS', '#626,KALMATH ROAD', 'BELGAUM', 'BELGAUM', '', '590001', '', 'E', 'I', '', ''),
(876, 'CHAMUN', 'SRI CHAMUNDESHWARI ENTERPRISES, BANGALOR', '#569, 3RD CROSS', 'SRINIVASANAGAR 2ND STAGE', 'BANGALORE', '', '560050', '', 'E', 'I', '', ''),
(880, 'CHN', 'SRI RAMAKRISHNA MATH  CHENNAI', 'Ramakrishna math road', 'MYLAPORE ,CHENNAI', 'CHENNAI', '', '600004', '', 'I', 'O', '33AAATR3497G1Z', ''),
(895, 'DR JAL', '      DR M V JALI', '  MEDICAL DIRECTOR KLE HOSPIT-', 'AL NEHARUNAGAR', 'BELGAUM', '', '590016', '', 'E', '', '', ''),
(896, 'DR KEL', '    DR CHANDRASHEKAR S KELAGAR', 'COSULTING EYE SURGEON', '1ST FLOOR KELAGAR MEDICAL CEN', 'RANEBENNUR', '', '581115', '', 'E', 'I', '', ''),
(897, 'DVNR', 'RAGHAVENDRAKRUPA ASHRAMA', 'PUNYASTALA. 577 551', 'DAVANAGERE :DIST', 'DAVANAGERE', '', '577551', '', 'E', '', '', ''),
(898, 'DWD', 'RAMAKRISHNA VIVEKANANDA ASHRAMA, DWD', 'CHANNABASAVESWAR NAGAR', 'HALIYAL ROAD', '  DHARWAD', '', '', '', 'E', 'I', '', ''),
(899, 'ELEG', 'ELEGANT PRINTING WORKS', '#74 SOUTH END RD-BASAVANAGUDI', 'BANGALORE- 4', 'BANGALOR - 4', '', '', '', 'E', '', '', ''),
(900, 'GAD', 'PRABHU BURBURE', 'MY FOOD VEG, OPP TO', 'NAGARA ABHIVRIDDHI, STATION', 'GADAG', '', '582101', '', 'E', '', '', ''),
(901, 'GADAG', 'RAMAKRISHNA VIVEKANANDA ASHRAMA, GADAG', 'A P M C YARD', 'GADAG -582 101', 'GADAG-582 101', '', '', '', 'E', 'I', '', ''),
(902, 'GEE BH', '    GEETHA BHARATHI BANGALORE', 'KESHAVA SHILPA', 'KEMPEGOWDA NAGAR', 'BANGALORE', '', '560019', '', 'E', '', '', ''),
(903, 'GIFT', '      M/S SUNIRYAT OVERSEAS', 'CHANDRESHNAGAR MAIN ROAD', 'NR MAYANI CHOWK', ' RAJKOT', '', '360001', '', 'E', '', '', ''),
(904, 'GKCOMP', 'SHIVALINGAPPA K KABADAGI', 'SW VIVEKANANDA CAREER ACADEMY', 'OPP COURT, BASVESHWARA CIRCLE', '', '', '591307', '', 'E', '', '', ''),
(905, 'GOA', '    SHARADA INDUSTRIES', 'PH 9422592311', '', 'GOA', '', '', '', 'E', '', '', ''),
(906, 'GOA SA', '    RAMAKRISHNA VIVEKANANDA SEVA SAMITI', '1139, VIDYANAGAR', 'MADGAON - GOA', 'MADGAON - GOA', '', '', '', 'E', '', '', ''),
(907, 'GOKAK', '    MATAJI SHIVAMAYI', 'SHRI SHARADA SHAKTI PITA', 'LAXMI TEMPLE ROAD', 'GOKAK   8123639289', '', '591307', '', 'E', '', '', ''),
(908, 'GULBA', '    SRI RAMAKRISHNA VIVEKANANDA ASHRAMA', 'KUSANARARA ROAD, RAJAPURA', 'KALBURGI', 'GULBUGA', '', '', '', 'E', '', '', ''),
(909, 'GULBAR', '    VIVEKANANDA KENDRA GULBARGA', 'C/O ENG SRI S V MAHULKAR', 'SHABHAVI VENKATADRI', 'GULBUGA', '', '585102', '', 'E', '', '', ''),
(910, 'GUPTA', '    M/S GUPTA ELECTRICAL INDUSTIRIES', 'NO 158 10TH MAIN 3RD PHASE', 'PEENYA INDUSTRIAL AREA', 'BANGALORE', '', '560058', '', 'E', '', '', ''),
(911, 'GURU', 'SHRI RAMAKRISHNA SATSANGA KENDRA', 'JAGADDHATRI,#3268,', '4TH CROSS, GAYATRI NAGAR', 'BANGALORE', '', '560021', '', 'I', '', '', ''),
(912, 'GURURJ', '    SRI RAMAKRISHNA SATASANGA KENDRA', 'JAGADDATRI #3268 4TH CROSS', 'GAYATRI NAGAR- BANGALORE-21', 'BANGALORE-560 021', '', '560021', '', 'E', '', '', ''),
(913, 'GUWA', 'RAMAKRISHNA MISSION ASHRAMA', 'ULUBARI, GUWHATI', '', 'GUWHATI', '', '781007', '', 'I', '', '', ''),
(914, 'HARI', 'SRI RAMAKRISHNA VIVEKANANDA ASHRAMA', 'SRI RAMA KRUPA', '1ST MAIN 1ST CROSS J C EXT', 'HARIHAR  MOB-9844062', '', '577601', '', 'E', '', '', ''),
(915, 'HARYA', '    SWAMI VIVEKANANDA PUBLIC SCHOOL', 'SECTOR-17,HUDA', 'JAGADHRI-135003', 'JAGADADRI', '', '135003', '', 'E', '', '', ''),
(916, 'HOSPET', '    SRI RAMAKRISHNA GEETHA ASHRAMA', 'BELLARY ROAD HOSPET', 'MOBBILE8892963465', 'HOSPET', '', '583201', '', 'E', '', '', ''),
(917, 'HQ', 'RAMAKRISHNA MISSION', 'P.O: BELUR MATH. DT: HOWRAH', 'WEST BENGAL - 711 202', 'BELUR MATH', '', '711202', '', 'I', '', '', ''),
(918, 'HRYR', 'SHREE SHARDASHARAMA, HIRIYOOR', 'HULIYAR ROAD', 'HIRIYOOR', 'HIRIYOOR', '', '572143', '', 'E', 'I', '', ''),
(919, 'HSSA', 'SRI MATA SHARADASHRAMA , HOSAKOTE', '', '', 'HOSAKOTE', '', '', '', 'E', '', '', ''),
(920, 'HUBL', 'RAMAKRISHNA VIVEKANANDA ASHRAMA, HUBLI', '3RD CROSS,5TH MAIN', 'KALYANA NAGAR,BEHI HAMSA HOTEL', '', '', '580031', '', 'E', 'I', '', ''),
(921, 'HV', 'H.V VISHVANATHA', '', '', 'BANGALORE', '', '', '', 'E', '', '', ''),
(922, 'HYD', 'RAMAKRISHNA MATH, HYDERABAD', 'DOMALGUDA', '', 'HYDERABAD-29', '', '', '', 'E', 'O', '36AAATR3497G1Z', ''),
(923, 'ICHAL', 'RAMAKRISHNA SATSANGHA MANDALI', 'TEACHER GALLI ICHALKARANJI', '', 'ICAHLKARANJI', '', '', '', 'E', '', '', ''),
(924, 'INDOR', 'RAMAKRISHNA MISSION', 'RAMAKRISHNA ASHRAMA MARG', 'KILA MAIDAN', 'INDORE', '', '452006', '', 'I', '', '', ''),
(925, 'JAGO', 'RASTRA SHAKTI PUSTHAK TERU', 'NO4115 OLDNO969 2ND MAIN', '11TH CROSS SBM COLONY', 'REF T RAJESH', '', '560050', '', 'E', '', '', ''),
(926, 'JAMMU', 'RAMAKRISHNA MISSION', 'RAMAKRISHNA VIHAR', 'UDHOWALA, JAMMU -180002', 'JAMMU', '', '180002', '', 'I', '', '', ''),
(927, 'JB', 'JYOTI TASGAONKAR', '', '', 'BELGAUM', '', '', '', 'E', '', '', ''),
(928, 'JMKD', 'RAMAKRISHNA VIVEKANANDA ASHRAMA', 'BEHIND GLBC.SHARADA NAGARA', 'JAMAKHANDI-587301', 'JAMAKHANDI', '', '587301', '', 'E', '', '', ''),
(929, 'K PH', 'KANTHI PHOTOS', '#11/1 2 ND MAIN ROAD', 'GAVIPURAM EXTN', 'BANGALORE', '', '560019', '', 'E', '', '', ''),
(930, 'KANCHI', '    RAMAKRISHNA MATH', 'OPP.GOVT.CANCER HOSPITAL', 'P.O.KARAIPETTAI.KANCHIPURAM', 'KANCHIPURAM', '', '631552', '', 'I', '', '', ''),
(931, 'KANK', 'RAMAKRISHNA MATH', 'P.O.KANKHAL.  DIST: HARDWAR', 'HARDWAR - 249408', 'KANKHAL', '', '249408', '', 'E', '', '', ''),
(932, 'KARAVA', '      KARAVALI PRAKASHANA', 'KADAPA MAIDANA AVARANA', 'KALABHAVANA-DHARWAD', 'DHARAWADA', '', '580001', '', 'E', '', '', ''),
(933, 'KEB', '    KALKUR ENTERPRISES , BANGALORE', 'NO 13 6TH CROSS KATRIGUPPE', 'VILAAGE VIVEKANANDA NAGAR', 'BANGALORE 560085', '', '560085', '', 'E', '', '', ''),
(934, 'KEY', '    SHREE BALAJI BHAVAN BOOK STALL', 'THIRUNILAYAM LIBERT X ROAD', 'HIMAYATNAGAR HYDERABAD-500029', '', '', '500029', '', 'E', '', '', ''),
(935, 'KLE', 'MEDICAL DIRECTOR, KLE HOSPITAL', 'K.L.E. HOSPITAL', '', 'BELGAUM', '', '', '', 'E', 'I', '', ''),
(936, 'KOLHA', 'RAMAKRISHNA VIVEKANANDA ADHYATMIK KENDRA', 'PANJARPOL,SHAHU MILL COLONY', ' KOLHAPUR.', '  KOLHAPUR', '', '', '', 'E', '', '', ''),
(937, 'KOPPAL', '    RAMAKRISHNA VIVEKANANDA ASHRAMA.', 'NEAR GOURI SHANKAR TEMPLE', 'GADAG ROAD', '    KOPPAL', '', '583231', '', 'E', '', '', ''),
(938, 'KRIP', 'KRIPAMAYI SHARADASHRAMA', 'GYANI COLONY BEHIND LIC OFFICE', '', 'BIJAPUR', '', '586104', '', 'E', '', '', ''),
(939, 'KRVR', 'SRI RAMAKRISHNA ASHRAMA', 'KARAWAR - 581 301', 'PH: 08382 -226 824', 'KARWAR', '', '581301', '', 'E', '', '', ''),
(940, 'KUVP', 'KUVEMPU BHASHA BHARATHI PRADHIKARA', 'KALAAGRAMA,JNANABHARATHI,', 'BEHIND BANGLR UNIVSTY', 'BANGALORE', '', '560056', '', 'E', '', '', ''),
(941, 'LAH', 'LAHARI RECORDING COMPANY', 'TTMC/BMTC BUILDING  4TH FLOOR', 'YESHAVANTAPURA CIRCLE', 'BANGALORE', '', '560022', '', 'E', '', '', ''),
(942, 'LAMI', 'OM PHOTO LAMINATION', '1918 RADESH COMPLEX SHOP NO6', 'BURUD GALLI KADOLKAR GALLI', 'MOB 916314334', '', '', '', 'I', '', '29amxpk4616m1z', ''),
(943, 'LKSU', 'SRI LAKSHMIKESHAVA UPADHYA', '', '', '', '', '', '', 'E', '', '', ''),
(944, 'MADHU', 'SRI MADHUSUDHAN MAHARAJ', 'RAMAKRISHNA VIDYASHALA', 'MYSORE', '', '', '570020', '', 'E', '', '', ''),
(945, 'MADURA', '     RAMAKRISHNA MATH', 'RESERVE LINES,', 'NEW NATHAM ROAD,', '    MADURAI', '', '625014', '', 'I', '', '', ''),
(946, 'MEGHA', 'RAMAKRISHNA MISSION ASHRAMA', 'PO CHERRABAZAR,', 'EAST KHASI HILLS,', 'MEGHALAYA', '', '793111', '', 'I', '', '', ''),
(947, 'MRM', 'RAMAKRISHNA MATH, MANGALORE', 'MANGALADEVI ROAD', '', 'MANGALORE', '', '', '', 'I', 'I', '29AAATR3497G2Z', ''),
(948, 'MURUGA', '    SRI MURUGAN KHADAR STORES', '49 KAMACHIAMMAN KOIL STREET', 'TIRPUR-641604', 'TIRUPUR', '', '641604', '', 'E', '', '', ''),
(949, 'MYS', 'SRI RAMAKRISHNA ASHRAMA,MYSORE', 'Yadavagiri', 'MYSORE - 570020', 'MYSORE', '', '570020', '', 'I', 'I', '29AAATR3497G3Z', ''),
(950, 'NAGP', 'RAMAKRISHNA MATH, NAGAPUR', 'DHANTOLI', '', 'NAGAPUR-440012', '', '', '', 'E', 'O', '', ''),
(951, 'NAREN', 'RAMAKRISHNA MISSION LOKASHIKSHA PARISHAD', 'P.O:NARENDRAPUR', 'KOLKATA -700103', 'KOLKATA', '', '700103', '', 'I', '', '', ''),
(952, 'NG', 'NIRMALA GOANKAR', '', '', 'ANKOLA', '', '', '', 'E', '', '', ''),
(953, 'NIPPAI', '    RAMAKRISHNA VIVEKANANDA SEVA SAMITI', 'NIPPANI', '', 'NIPPANI', '', '', '', 'E', '', '', ''),
(954, 'NREDDY', '    NIVEDITA REDDYY BANGALORE', 'BANGALORE', '', 'BANGALORE', '', '560019', '', 'E', '', '', ''),
(955, 'OHSPET', '    HAMSAMBA SHARADASHRAMA', 'BEHIND ASHWINI EYE HOSPITAL', 'A.C. OFFICE ROAD,', 'HOSPET', '', '     3', '', 'E', '', '', ''),
(956, 'OOTY', 'RAMAKRISHNA MATH  OOTACMUND', 'RAMAKRISHNA PURAM', 'OOTACMUND DIST NILGIRIS', '', '', '643001', '', 'I', '', '', ''),
(957, 'OTHER', 'OTHERS PUBLISHERS', 'OTHERS PUBLISHER', 'SAMATA,RAJKOT,S MATH,UDBODHAN,', '', '', '', '', 'E', 'I', '', ''),
(958, 'PAB', 'PRASANNA AITHAL D P', '', '', 'BANGALORE', '', '', '', 'E', '', '', ''),
(959, 'PAI', 'PAI ENGNEERING LTD', '', 'BELGAUM', '', '', '', '', 'E', '', '', ''),
(960, 'PALAI', 'RAMAKRISHNA MATH             PALAI', 'ARUNAPURAM, PALAI. DT:KOTTAYAM', 'PALAI - 686574', 'PALAI', '', '686574', '', 'I', '', '', ''),
(961, 'PATIL', '    SRI P K PATIL, GADAG', ' (PRABHU BURBURE)', ' PH- 9448326129', '    GADAG', '', '', '', 'E', '', '', ''),
(962, 'PATNA', 'RAMAKRISHNA MISSION ASHRAMA, PATNA', 'RAMAKRISHNA AVENUE', 'PATNA -800 004', 'PATNA', '', '800004', '', 'I', 'O', '', ''),
(963, 'PATSON', '   PATSON ELECTRICALS & CONTROLS', 'SURVEY #14, MATOSHRI ESTATE', 'SHOP #5, NANDED PHATA,', 'PUNE - 411 041', '', '411041', '', 'E', '', '', ''),
(964, 'PHOTO', 'SRI D B PATIL DIGITAL PHOTO STUDIO', '3495/A NARVEKAR GALLI', 'BELAGAVI  MOB 9448963874', '', '', '590002', '', 'E', '', '', ''),
(965, 'PONNAM', '    RAMAKRISHNA SARADASHRMA', 'POST PONNAMPET', 'DIST KODAGU', '    PONNAMPET', '', '571216', '', 'I', '', '', ''),
(966, 'PRASAN', ' PRASANNA RAGHAVENDRA TARUN MITRA MANDAL', 'C/O SRI SHUBANG,', 'NEAR RAGHAVENDRA MUTT', ' DISPATCH TO JAMKHAN', '', '', '', 'E', '', '', ''),
(967, 'PRM', 'RAMAKRISHNA MISSION PALLIMANGAL', '', '', 'PALLIMANGAL', '', '', '', 'I', '', '', ''),
(968, 'PRSM', 'PRISM BOOKS PVT LTD', '# 1865, 32ND CROSS 10TH MAIN', 'BSK 2ND STAGE,  BENGALURU- 70', 'BENGALURU', '', '560070', '', 'E', '', '', ''),
(969, 'PURULI', '    RAMAKRISHNA MATH', 'VILL & PO BAGDA,', 'DIST-PURULIA, WEST BENGAL', 'BAGDA, DIST - PURULI', '', '723151', '', 'I', '', '', ''),
(970, 'RAIL', '    CENTRAL RLY ST BOOKSTALL CHENNAI', 'MADHU, C/O KRISHNA REDDY', 'BF3,GURU RAGAVENDRA APARTMENTS', 'CHENNAI PH-984052562', '', '600068', '', 'E', '', '', ''),
(971, 'RAJESH', '    SRI RAJESHWARI VIDYA NIKETAN', 'PHONE 9880513880 OF RAINEKAR', '', 'HULAKOTI', '', '', '', 'E', '', '', ''),
(972, 'RAKE', 'RAKESH KUMAR', 'G-4,SECTOR-3', 'NOIDA, UTTAR PRADESH', '', '', '201301', '', 'E', '', '', ''),
(973, 'RANCHI', '    RAMAKRISHNA MISSION ASHRAMA', 'SWAMI VIVEKANANDA ROAD', 'MORABADI-RANCHI 834008', 'RANCHI', '', '834008', '', 'I', '', '', ''),
(974, 'RANE', 'RAMAKRISHNA VIVEKANANDA ASHRAMA, RNBR', '1ST CROSS.3RD CROSS', 'GOURISHANKAR NAGAR RANEBENNUR', 'RANEBENNUR', '', '581115', '', 'E', 'I', '', ''),
(975, 'RAR', 'SRI RAMAKRISHNA ASHRAMA , RAJKOT', 'DR YAGNIK ROAD', 'RAJKOT- 360001', 'RAJKOT', '', '360001', '', 'I', '', '', ''),
(976, 'RASHTR', '    RASTOTTANA SAHITYA K G NAGAR BR', 'KESHAVA SHILPA KEMPEGOUDANAGAR', 'BANGALORE-560019', 'BANGALORE', '', '560079', '', 'E', '', '', ''),
(977, 'RIMSE', '   RAMAKRISHNA INSTITUTE MORAL& SPIRITUA', ' EDUCATION            YADAVAGI', '', 'MYSORE', '', '570020', '', 'I', '', '', ''),
(978, 'RJMDR', 'RAMAKRISHNA MATH', 'RAMAKRISHNA VIVEKANANDA NAGAR', 'RAJAHMUNDRY -533 105', 'RAJAHMUNDRY', '', '533105', '', 'E', '', '', ''),
(979, 'RK Y', 'RAMAKRISHNA MATH ( YOGODYAN)', '#7YOGODYANA LANE, KANKURGANCHI', 'KOLKATA - 700 054', 'KOLKATA', '', '700054', '', 'E', '', '', ''),
(980, 'RKMM', 'RAMAKRISHNA MATH, MUMBAI', '12TH ROAD', 'KHAR(WEST)', 'MUMBAI', '', '400052', '', 'I', 'O', '27AAATR3497G1Z', ''),
(982, 'RKMP', 'RAMAKRISHNA MATH, PUNE', '131/1 A , NEAR DANDEKAR BRIDGE', '', 'PUNE', '', '411030', '', 'I', 'O', '27AAATR3497G1Z', ''),
(983, 'RLY', 'VIVEKANANDA BOOK STORE -BGM RAILWAY STN', 'RAMAKRISHNA MISSION ASHRAMA', 'FORT, BELGAUM - 590 016', 'RAILWAY STATION - BE', '', '590001', '', 'I', '', '', ''),
(984, 'RPR', 'RAMAKRISHNA MISSION VIVEKANANDA ASHRAMA', 'P.O. VIVEKANANDA ASHRAMA', 'RAIPUR - 492 001', 'RAIPUR', '', '492001', '', 'E', '', '', ''),
(985, 'RUDRA', '   GARWAL HANDICRAFT AND GEMS SALES UNI', 'NEAR ANAND DHAM TAPOVAN SARAI', 'TEHRI GARHWAL-249192', '', '', '249192', '', 'E', '', '', ''),
(986, 'SAGAR', 'RAMAKRISHNA VIVEKANANDA ASHRAMA', '3 CROSS,B K ROAD KHB COLONY', 'GANDHINAGARA SAGARA SHIVMOGGA', 'SAGARA', '', '577401', '', 'E', '', '', ''),
(987, 'SAHA', 'SAHASRAMANA PRAKASHANA, G.J.MEHANDALI', '#625,9THCROSS, 4TH MAIN RD', '3RD BLOCK,RAJAJINAGAR,EXTN,', 'BANGALORE', '', '560097', '', 'E', '', '', ''),
(988, 'SALEM', 'RAMAKRISHNA MISSION ASHRAMA', '17,RAMAKRISHNA ROAD', 'SALEM -636 007', 'SALEM', '', '636007', '', 'I', '', '', ''),
(989, 'SAMAJ', 'SAMAJ BOOK DEPOT DHARWAD', 'SHIVAJI STREET DHARWAD -1', '', 'DHARWAD -1', '', '', '', 'E', '', '', ''),
(990, 'SAN', 'RAMAKRISHNA VIVEKANANDA SEVA SAMSTHA', 'SUVRTHA,TULJAINAGAR.', 'KUPWAD PHATA. NEAR VEERSAHIVA', 'SANGLI    PH:0942204', '', '416416', '', 'E', '', '', ''),
(991, 'SARA', 'RAMAKRISHNA MISSION SARADAPITHA', 'POST BELURMATH DT HOWRAH', 'PIN 711202', 'HOWRAH', '', '711202', '', 'I', '', '', ''),
(992, 'SARAD', '    SRI SARADA MATH', '44/2,  NANDI DURGA ROAD', 'BANGALORE - 560046', 'BANGALORE', '', '560046', '', 'E', '', '', ''),
(993, 'SARASW', '    THE SOUVENIR COMPANY', 'MANGHARAM HOUSE 528/B 12TH', 'CROSS RMV EXTENSION BANGALORE', 'BANGALORE', '', '560080', '', 'I', '', '', ''),
(994, 'SAVIT', '    SAVITHRI SURESH', '#569, 3RD CROSS.', 'SRINIVASANAGARA 2ND STAGE', 'BANGALORE', '', '560050', '', 'E', '', '', ''),
(995, 'SBV', 'SRI SARADA BOOK HOUSE', 'HOUSE OF A.S.PRAKASARA RAO', 'IST FLOOR FLOT#3 IST CROSS RD', 'VIJAYAWADA', '', '520008', '', 'E', '', '', ''),
(996, 'SEDAM', 'C N MATH', 'VIKAS ACADEMY', 'OPP AIWAN-E-SHAHI GUEST HOUSE', ' 08472-273810,MOB-96', '', '585102', '', 'E', '', '', ''),
(997, 'SEVASR', 'SHARADA SEVASHRAMA, BANGALORE', 'SY.130,B 101/102', 'VINAYAKA NAGAR', 'BANGALORE  PH 080 26', '', '560085', '', 'E', 'I', '', ''),
(998, 'SGURU', '    SRI S. GURURAJ', 'MYSORE', '', 'MYSORE', '', '570020', '', 'E', '', '', ''),
(999, 'SHIKA', '     BR MALLIKARJUNA', 'SHREE RAMAKRISHNA KUTEER', 'C/O CHETAN.H.P, M.G. ROAD,', '', '', '577427', '', 'E', '', '', ''),
(1000, 'SHIVA', 'RAMAKRISHNA VIVEKANANDA ASHRAMA', 'ABBALAGERE POST,KALLAGANGURU', 'EMAIL:RVASHRAMASHIMOGA@GMAIL.C', 'SHIVAMOGGA', '', '577225', '', 'E', '', '', ''),
(1001, 'SM H', 'SHRIMATA ASHRAMA   - HUBLI', 'PLOT # 14, BEHIND NEW BUSSTAND', 'DOLLAR''S COLONY GOKUL ROAD', 'HUBLI', '', '580030', '', 'E', '', '', ''),
(1002, 'SQUARE', '    SQUARE ENGINEERING WORKS', '#130/6B PHETE CHINNAPPA', 'INDUSTRIAL ESTATE, MAGADI ROAD', 'BANGALORE', '', '560079', '', 'E', '', '', ''),
(1003, 'SRI MA', '    SRI MA TRUST', '579, SECTOR 18 - B', 'CHANDIGARH - 160018', 'CHANDIGARH', '', '160018', '', 'E', '', '', ''),
(1004, 'SRIMA', '    SHREEMA ENTERPRISES', '#211, BLDG#2 2ND FLOOR', 'NEWSONAL LINK INDL ESTATE', 'MUMBAI-400 064', '', '400064', '', 'E', '', '', ''),
(1005, 'SRINI', '    SRI.K.V. SRINIVAS-BANGALORE', '', 'MB# 9964699663', 'BANGALORE', '', '', '', 'E', '', '', ''),
(1006, 'SRIRAJ', '    SRI RAJESHWARI VIDYANIKETAN', 'GADAG', 'OFFICE PH 08372289057', 'HULAKOTI', '', '582205', '', 'E', '', '', ''),
(1007, 'SSRCH', 'SHREE SHARADASHRAMA', '3RD CROSS VASAVI COLONY', 'BANGALORE ROAD- CHALLAKERE', 'CHELLEKERE', '', '577522', '', 'E', '', '', ''),
(1008, 'SVC', 'SVC ASSOCIATES,', '#100, 17TH MAIN ROAD,', '2ND B CROSS, MUNESHWARA BLOCK,', 'BENGALURU', '', '560026', '', 'E', '', '', ''),
(1009, 'T NAGR', 'RAMAKRISHNA MISSION ASHRAMA, T NAGAR', '3,MAHARAJAPURAM,SANTHANAM', 'SALAI,TYAGARAYANAGAR', 'CHENNAI', '', '600017', '', 'I', 'O', '33AAAAR1077P4Z', ''),
(1010, 'TIRPUR', '    SHREE VIVEKANANDA SEVALAYAM', '# 61, KASTURIBAI STREET', 'AMMA PALAYAM', 'TIRUPUR', '', '641652', '', 'E', '', '', ''),
(1011, 'TRISSU', '    RAMAKRISHNA MATH THRISSUR', 'POST PURANATTUKARA', 'DIST THRISSUR-680551', 'THRISSHUR', '', '680551', '', 'I', '', '', ''),
(1012, 'TRIVE', 'RAMAKRISHNA ASHRAMA  SASTHAMANGALAM', 'THIRUVANANTHAPURAM 695010', '0471-2722125', 'SASTAMANGALAM,THIRUV', '', '695010', '', 'I', '', '', ''),
(1013, 'TRSS', 'RAMAKRISHNA MATH', 'VILANAGAN, P.O: PURANATTUKARA', 'DT:THRISSUR - 680 551', 'TRISSUR', '', '680551', '', 'E', '', '', ''),
(1014, 'TRUST', 'VR DESHPANDE MEMORIAL TRUST, HALIYAL', '08951568032', 'REF: SHASHANK PRABHU', 'HALIYAL', '', '', '', 'E', '', '', ''),
(1015, 'TT', 'TEMPLE TREES', 'MANGARAM HOUSE.528 B 12TH CR', 'RMV EXTENSION BANGALORE', 'BANGALORE -80', '', '560080', '', 'E', '', '', ''),
(1016, 'TUMKUR', '    RAMAKRISHNA VIVEKANANDA ASHRAMA', 'RAMAKRISHNA NAGAR,', 'KUNIGAL ROAD', 'TUMAKURU', '', '572105', '', 'E', '', '', ''),
(1017, 'UDUPI', '     UDUPI STORES', 'GUNDOPANTH STREET', 'BEHIND SKR MARKET', 'BANGALORE', '', '56002', '', 'E', '', '', ''),
(1018, 'ULSUR', 'RAMAKRISHNA MATH, ULSOOR', 'SWAMI VIVEKANANDA ROAD', 'ULSOOR  BANGALURU', 'BANGALORE -560008', '', '560008', '', 'I', 'I', '29AAATR3497G4Z', ''),
(1019, 'UNIV', 'MAHILA UNIVERSITY BIJAPUR', '', '', 'BIJAPUR', '', '', '', '', '', '', ''),
(1020, 'UNIVER', '    RAMAKRISHNA MISSION VI UNIVERSITY', 'VIVEKANANDA UNIVERSITY', 'P O BELUR MATH', '', '', '711202', '', 'I', '', '', ''),
(1021, 'VADODA', 'RAMAKRISHNA MISSION, VADODARA', 'SWAMI VIVEKANANDA MEMORIAL', 'DILARAM BUNGALOW', 'VADODARA-390 007', '', '390007', '', 'I', 'O', '24AAAAR1077P3Z', ''),
(1022, 'VHS', 'VIVEKHAMSA PRAKASHANA, BANGALORE', '#569,3rd CROSS,SRINIVASANAGAR', 'MYSORE BANK COLONY,', 'BANGALORE-50', '', '', '', 'E', 'I', '', ''),
(1023, 'VIDYA', '    SHRI RAMAKRISSHNA VIDHYASHALA', 'YADAVAGIRI, MYSORE -572020', '0821- 2514000 / 2515000', 'MYSORE', '', '572020', '', 'E', '', '', ''),
(1024, 'VIJAYA', '    RAMAKRISHNA MISSION VIJAYAWADA', 'SITANAGARAM VILLAGE', 'TADEPALLI MANDAL', 'VIJAYAWADA', '', '522501', '', 'I', '', '', ''),
(1025, 'VIJD', 'RAGHAVENDRA BOOK STALL', 'NEHARU BUS STATION', 'VIJAYWADA', 'VIJAYAWADA', '', '', '', 'E', '', '', ''),
(1026, 'VIRAJ', 'SRI VIRAJ MANGALGE', 'MIG-3 3RD PHASE ADARSH NAGAR', 'GULBUGA-585105', 'GULBURGA', '', '585105', '', 'E', '', '', ''),
(1027, 'VISHK', 'RAMAKRISHNA MISSION ASHRAMA', 'RAMAKRISHNA BEACH', 'VISAKHAPATNAM -530 003', 'VISAKHAPATNAM', '', '530003', '', 'I', '', '', ''),
(1028, 'VK CH', 'VIVEKANANDA KENDRA -CHENNAI', 'NO 5 SINGARACHARI STREET', 'TRIPLICANE -CHENNAI', 'CHENNAI', '', '600005', '', 'E', '', '', ''),
(1029, 'VKDWD', 'VIVEKANANDA KENDRA DHARAWAD', '"GURUKRIPA" SRIPAD NAGAR', '(R C NAGAR )', 'DHARAWAD', '', '580007', '', 'E', '', '', ''),
(1030, 'VKK', 'VIVEKANANDA KENDRA, KANYAKUMARI', 'VIVEKANANDAPURAM', 'KANYAKUMARI -629 702', 'KANYAKUMARI', '', '629702', '', 'E', '', '', ''),
(1031, 'VKMY', 'VIVEKANANDA KENDRA, MYSORE BRANCH', '2830 1ST MAIN PAMPAPATI ROAD', 'JAYANAGAR MYSORE-570014', 'MYSORE', '', '570014', '', 'E', '', '', ''),
(1032, 'VKPT', 'VIVEKANANDA KENDRA PRAKASHAN TRUST, CHN', '', '', 'CHENNAI', '', '', '', 'E', 'O', '', ''),
(1033, 'VKPUNE', '    VIVEKANANDA KENDRA   PUNE', 'VIBHAG VISHWAKARMA SUR NO529/3', 'OPP COSMOS BANK SINHAGAD ROAD', 'PUNE', '', '411030', '', 'E', '', '', ''),
(1034, 'VKSP', 'VIVEKANANDA KENDRA SHIKSHA PRASAR VIBHAG', 'SURESH BAGARIA SMRITI BHAVAN', 'NIKAMUL TEZPUR 784001', '', '', '784001', '', 'I', '', '', ''),
(1035, 'VPITA', 'RAMAKRISHNA MISSION VIDYAPITH', 'RAMAKRISHNA MISSION VIV COLLG', '70&72 P S SIVASWAMI SALAI,', 'CHENNAI', '', '600004', '', 'I', '', '', ''),
(1036, 'WP', 'WORDPOWER', 'BHANDARI CAPITAL 1ST FLOOR', 'ABOVE COSMOS BANK', 'BELGAUM', '', '590006', '', 'E', '', '', ''),
(1037, 'YADGIR', '    RAMAKRISHNA VIVEKANANDA ASHRAMA', 'YADGIRI', '', 'YADGIRI', '', '', '', 'E', '', '', ''),
(1038, 'YRBL', 'YARBAL PRINT - PACK PVT LTD', 'C-88, D-79, KSSIDC', 'INDUSTRIAL ESTATE', 'BELGAUM', '', '590008', '', 'E', '', '', ''),
(1039, 'RKM-BLR', 'Ramakrishna Math, Bangalore', '', '', 'Bangalore', '', '', '', 'E', 'I', '', ''),
(1042, 'RKM-AA1', 'Advaita Ashrama', '', '', 'Kolkata', '', '', '', 'E', 'O', '', ''),
(1043, 'RKM-ULSOOR', 'RAMAKRISHNA MATH', 'ULSOOR', '', 'BANGALORE', '', '', '', 'E', 'I', '', ''),
(1044, 'RKM-MYSORE', 'RAMAKRISHNA ASHRAMA', 'YADAVGIRI', 'SOMEPLACE', 'MYSORE', 'KARNATAKA', '', '', 'E', 'I', '', ''),
(1045, 'ULSUR1', 'RKM', '', '', 'ULSUUR', '', '', '', 'E', 'I', '', ''),
(1046, 'NEW CODE', 'NEW PARTY', '', '', 'SOME CITY', '', '', '', 'E', 'I', '', ''),
(1047, 'TEST NEW', 'NEW SECOND PARTY', '', '', 'NEW CITY', '', '', '', 'I', 'O', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `proforma_details`
--

CREATE TABLE IF NOT EXISTS `proforma_details` (
`id` int(11) NOT NULL,
  `p_sum_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `proforma_summary`
--

CREATE TABLE IF NOT EXISTS `proforma_summary` (
`id` int(11) NOT NULL,
  `date` date NOT NULL,
  `party_id` int(11) NOT NULL,
  `o_i` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  `remark` varchar(30) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `summary`
--

INSERT INTO `summary` (`id`, `tran_type_id`, `tr_code`, `tr_no`, `date`, `party_id`, `expenses`, `remark`) VALUES
(1, 1, 'CS', 1, '2017-01-23', 1, '10.00', 'test'),
(6, 5, '1CS', 1, '2017-10-07', 895, '0.00', ''),
(9, 1, 'CS', 2, '2017-10-07', 932, '10.00', ''),
(10, 5, '1CS', 2, '2017-10-07', 902, '0.00', ''),
(11, 1, 'CS', 3, '2017-10-07', 953, '0.00', ''),
(12, 5, '1CS', 3, '2017-10-07', 930, '0.00', ''),
(13, 1, 'CS', 4, '2017-10-07', 1016, '0.00', ''),
(14, 5, '1CS', 4, '2017-10-07', 969, '0.00', ''),
(15, 5, '1CS', 5, '2017-10-09', 895, '0.00', ''),
(16, 1, 'CS', 5, '2017-10-10', 932, '0.00', ''),
(17, 5, '1CS', 6, '2017-10-11', 895, '10.00', ''),
(18, 1, 'CS', 6, '2017-10-12', 999, '0.00', ''),
(19, 7, '1CR', 1, '2017-10-10', 945, '21.00', ''),
(20, 7, '1CR', 2, '2017-10-11', 945, '17.00', 'date to 11, exp 17'),
(21, 6, '2CS', 1, '2017-10-13', 932, '37.00', ''),
(23, 6, '2CS', 2, '2017-10-02', 895, '0.00', ''),
(24, 6, '2CS', 3, '2017-10-10', 895, '0.00', ''),
(25, 6, '2CS', 4, '2017-10-16', 895, '0.00', ''),
(26, 5, '1CS', 7, '2017-10-10', 895, '0.00', ''),
(27, 5, '1CS', 8, '2017-10-31', 895, '0.00', ''),
(28, 5, '1CS', 9, '2017-10-02', 895, '10.00', ''),
(29, 6, '2CS', 5, '2017-10-03', 966, '11.00', ''),
(30, 6, '2CS', 6, '2017-10-02', 907, '21.00', ''),
(31, 7, '1CR', 3, '2017-10-01', 896, '10.00', ''),
(32, 7, '1CR', 4, '2017-10-01', 896, '10.00', ''),
(33, 7, '1CR', 5, '2017-10-01', 896, '10.00', ''),
(34, 7, '1CR', 6, '2017-10-01', 896, '10.00', ''),
(35, 7, '1CR', 7, '2017-10-01', 896, '10.00', ''),
(36, 5, '1CS', 10, '2017-10-02', 895, '0.00', ''),
(37, 5, '1CS', 11, '2017-10-02', 895, '0.00', ''),
(38, 5, '1CS', 12, '2017-10-02', 895, '0.00', ''),
(39, 5, '1CS', 13, '2017-10-02', 895, '0.00', '');

-- --------------------------------------------------------

--
-- Table structure for table `temp_details`
--

CREATE TABLE IF NOT EXISTS `temp_details` (
`id` int(11) NOT NULL,
  `summary_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `quantity` int(10) NOT NULL,
  `discount` int(11) NOT NULL,
  `cashdisc` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `temp_details`
--

INSERT INTO `temp_details` (`id`, `summary_id`, `item_id`, `quantity`, `discount`, `cashdisc`) VALUES
(18, 0, 4, 1, 0, 0),
(19, 0, 33, 2, 0, 0);

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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tran_type`
--

INSERT INTO `tran_type` (`id`, `tr_code`, `descrip_1`, `descrip_2`, `remark`, `location`) VALUES
(1, 'CS', 'cash', 'sales', 0, 'Fort Ashrama'),
(5, '1CS', 'Cash', 'Sales', NULL, 'Fort Ashrama'),
(6, '2CS', 'Cash', 'Sales', NULL, 'Railway Station Counter'),
(7, '1CR', 'Credit', 'Sales', NULL, 'Fort Ashrama');

-- --------------------------------------------------------

--
-- Table structure for table `trnf_details`
--

CREATE TABLE IF NOT EXISTS `trnf_details` (
  `summ_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `trnf_summary`
--

CREATE TABLE IF NOT EXISTS `trnf_summary` (
`id` int(11) NOT NULL,
  `date` date NOT NULL,
  `from_id` int(11) NOT NULL,
  `to_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

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
 ADD KEY `item_id` (`item_id`), ADD KEY `summ_id` (`summ_id`);

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
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `item`
--
ALTER TABLE `item`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=34;
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
-- AUTO_INCREMENT for table `party`
--
ALTER TABLE `party`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1048;
--
-- AUTO_INCREMENT for table `proforma_details`
--
ALTER TABLE `proforma_details`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `proforma_summary`
--
ALTER TABLE `proforma_summary`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `summary`
--
ALTER TABLE `summary`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=40;
--
-- AUTO_INCREMENT for table `temp_details`
--
ALTER TABLE `temp_details`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `tran_type`
--
ALTER TABLE `tran_type`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `trnf_summary`
--
ALTER TABLE `trnf_summary`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
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
