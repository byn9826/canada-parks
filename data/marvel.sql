-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 21, 2017 at 01:28 AM
-- Server version: 5.7.17-0ubuntu0.16.04.1
-- PHP Version: 7.0.15-0ubuntu0.16.04.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `marvel`
--

-- --------------------------------------------------------

--
-- Table structure for table `attitude`
--

CREATE TABLE `attitude` (
  `park_id` tinyint(2) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `attitude_rate` tinyint(1) UNSIGNED DEFAULT NULL,
  `attitude_back` tinyint(1) DEFAULT NULL,
  `attitude_worth` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `attitude`
--

INSERT INTO `attitude` (`park_id`, `user_id`, `attitude_rate`, `attitude_back`, `attitude_worth`) VALUES
(60, 13, 2, 0, 0),
(5, 137, 4, 0, 1),
(60, 146, 3, NULL, 1),
(68, 146, 4, NULL, 1),
(72, 146, 4, 1, NULL),
(77, 146, 3, 1, 1),
(105, 146, 2, NULL, 1),
(59, 202, 4, NULL, 1),
(60, 202, 3, 0, 0),
(68, 202, 4, 0, 1),
(77, 202, 5, 1, 1),
(100, 202, 4, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `footprints`
--

CREATE TABLE `footprints` (
  `footprint_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `park_id` int(11) NOT NULL,
  `date_visited` date NOT NULL,
  `user_story` text,
  `is_public` char(1) NOT NULL DEFAULT 'N',
  `created_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `footprints`
--

INSERT INTO `footprints` (`footprint_id`, `user_id`, `park_id`, `date_visited`, `user_story`, `is_public`, `created_on`) VALUES
(5, 9, 71, '2017-03-15', 'This is a test to add a footprint with some pictures.', 'Y', '2017-03-15 16:05:38'),
(6, 12, 100, '2017-03-12', 'I am adding a first footprint and some images to test the feature.', 'Y', '2017-03-15 16:08:44'),
(7, 12, 65, '2017-03-15', 'Adding a second footprint. Still doing some testing here.', 'N', '2017-03-15 16:12:05'),
(8, 9, 101, '2017-03-15', 'I have been to that park and it was such an amazing landscape out there...', 'Y', '2017-03-15 21:33:09'),
(9, 9, 86, '2017-03-15', 'Footprint folder should not be created', 'N', '2017-03-15 22:11:03'),
(10, 12, 105, '2017-03-09', 'A footprint without images', 'Y', '2017-03-15 22:17:51'),
(12, 12, 82, '2017-03-12', 'Just another post without pictures has been posted.', 'Y', '2017-03-15 22:23:12'),
(13, 13, 100, '2017-03-10', 'The adventure at canada parks svc has been so great today.', 'Y', '2017-03-16 14:29:56'),
(14, 13, 86, '2017-03-12', 'Just another great experience again.', 'N', '2017-03-16 14:33:14'),
(16, 12, 77, '2017-03-14', 'write something here', 'N', '2017-03-17 10:49:35'),
(25, 13, 73, '2017-04-02', 'Uploading images not working properly on heroku. Had to change hosting platform.', 'N', '2017-04-05 11:52:50'),
(40, 13, 80, '2017-04-07', 'NULL', 'N', '2017-04-08 00:25:31'),
(46, 146, 80, '2017-04-09', 'test test test -> Profile image corrected :)', 'Y', '2017-04-09 15:07:13'),
(47, 147, 80, '2017-04-10', 'Test', 'N', '2017-04-11 08:14:36'),
(50, 137, 80, '2017-04-15', 'Been here', 'Y', '2017-04-15 15:11:57'),
(59, 202, 77, '2017-04-20', 'Very beautiful', 'N', '2017-04-20 17:58:19');

-- --------------------------------------------------------

--
-- Table structure for table `footprint_images`
--

CREATE TABLE `footprint_images` (
  `footprint_id` int(11) NOT NULL,
  `image_id` int(11) NOT NULL,
  `image_src` varchar(256) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `footprint_images`
--

INSERT INTO `footprint_images` (`footprint_id`, `image_id`, `image_src`) VALUES
(5, 1, '2ce0760a7ab70f4cfd25ad6c0ce2d67fe795366a.JPG'),
(5, 2, '36b7f784445c552a8bd696e5f82760982bdbe21e.JPG'),
(6, 3, '6ccb52c1a78c0595eaa34e1166aa57e3cf1ccf3e.jpg'),
(6, 4, 'd4ced6ab2426d46a75a5f7837c1da5c93ba301ce.jpg'),
(6, 5, 'd40e85e3fbf58d734aee16262cf836a3e2aa9987.jpg'),
(6, 6, 'fe48068f118ba6ab43f7d019818fba286a9e6533.JPG'),
(6, 7, '5fcfd68a148ae30b3c9974a1750fcf0f4c4bc8ea.JPG'),
(7, 8, '91670648a0efb78e80dc32402932b1be3431acab.jpg'),
(7, 9, '4ac1a6370b053cfabb8291501c20c0649cb98252.jpg'),
(7, 10, 'c8818eeb53acf2d90c5bed0a3239c652ccb22105.jpg'),
(13, 11, 'b2e32764e86fbfdbe5c259c6c971cba27545e68e.jpg'),
(13, 12, '7bc3b0e5fe541dd88102b71049f0d941a60b0ec5.JPG'),
(13, 13, '82e7ae13f6f0af70bf598772894d8820948dedff.JPG'),
(14, 14, '20b581bd97e84568a7249969163f5afa200ba15b.jpg'),
(14, 15, '118b5794eeae46d212c7a6de0cbc444150ecef7c.jpg'),
(14, 16, '5f5cfdaa10c028f857fd69c8226a44136e496ab4.jpg'),
(14, 17, '7a0a89b183388209851332ea502bc4ddfe144035.jpg'),
(14, 18, '19107087f3140232f173e8360f6578109e213f1e.jpg'),
(14, 19, '07950f3903bc2defeab2b4d8978b54b615fa81b2.JPG'),
(16, 21, '0cd98b65a0e253b802c2bc8f6d15a6af2b777288.jpg'),
(16, 22, '25a6633c6684d7c37fe27612ec3ccb0511131db8.jpg'),
(16, 23, '4bf827ca15927963ea44042bde968848b6bdcc20.jpg'),
(16, 24, 'c7faded720b66c34eb17a316e038fbf4359ccb60.JPG'),
(25, 39, 'c50764b3b6c081a6465ec645ed32e0edbf97fbd6.JPG'),
(25, 40, 'a83eb03373ff4856c599664120f4b978154c4b89.JPG'),
(25, 47, '883f1a207a1ef531104bf190145866358d5a7b93.jpg'),
(47, 58, '54c888084175068e622e528ec4de53d24fbb57f1.jpg'),
(59, 65, 'c6aa8c571e7cc74ce358ba202646b291fd48be03.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `gallery`
--

CREATE TABLE `gallery` (
  `id` int(11) NOT NULL,
  `park_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `src` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `gallery`
--

INSERT INTO `gallery` (`id`, `park_id`, `name`, `src`) VALUES
(1, 63, 'img1', 'p1.jpg'),
(2, 63, 'img2', 'pp3.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `nav_header`
--

CREATE TABLE `nav_header` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `path` varchar(10) NOT NULL,
  `link` char(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `nav_header`
--

INSERT INTO `nav_header` (`id`, `path`, `link`) VALUES
(0, '', 'Home'),
(1, 'parks', 'Parks');

-- --------------------------------------------------------

--
-- Table structure for table `park`
--

CREATE TABLE `park` (
  `id` int(11) NOT NULL,
  `google_place_id` varchar(255) CHARACTER SET utf8 NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `banner` varchar(255) CHARACTER SET utf8 NOT NULL,
  `description` text CHARACTER SET utf8,
  `address` varchar(255) CHARACTER SET utf8 NOT NULL,
  `province` varchar(255) CHARACTER SET utf8 NOT NULL,
  `province_code` varchar(255) CHARACTER SET utf8 NOT NULL,
  `country` varchar(255) CHARACTER SET utf8 NOT NULL,
  `country_code` char(2) CHARACTER SET utf8 NOT NULL,
  `postal_code` char(10) CHARACTER SET utf8 NOT NULL,
  `latitude` varchar(255) CHARACTER SET utf8 NOT NULL,
  `longitude` varchar(255) CHARACTER SET utf8 NOT NULL,
  `phone_number` varchar(255) CHARACTER SET utf8 NOT NULL,
  `rating` double NOT NULL DEFAULT '0',
  `website` varchar(255) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `park`
--

INSERT INTO `park` (`id`, `google_place_id`, `name`, `banner`, `description`, `address`, `province`, `province_code`, `country`, `country_code`, `postal_code`, `latitude`, `longitude`, `phone_number`, `rating`, `website`) VALUES
(5, 'ChIJXzEnaPqUOogRVKzhpnCrzII', 'Point Pelee National Park', 'https://lh5.googleusercontent.com/-Q3EB1nLNp9U/WCN_Dgo-ydI/AAAAAAAAmIU/JN21ZMox15QwujTZyIg4IeeUxcWOhZtewCLIB/w1200-h1200-k/', 'A lush Carolinian forest oasis at the southern tip of Canada, Point Pelee National Park resounds with migrating song birds in the spring, hums with cicadas in the summer, flutters with Monarch butterflies in the fall and is a peaceful place of reflection in the winter.', '1118 Point Pelee Dr, Leamington, ON N8H 3V4, Canada', 'Ontario', 'ON', 'Canada', 'CA', 'N8H 3V4', '41.96277200000001', '-82.51844', '(519) 322-2365', 5, 'http://parkscanada.ca/pelee'),
(58, 'ChIJGZL18IEdK00RbaSpgKMwVpc', 'Georgian Bay Islands National Park', 'https://lh4.googleusercontent.com/-g1FzYvUbbYI/V6KIrzs2oKI/AAAAAAAAKwI/-BggQSUewKgOaxlJzJsruaYzR_vJENPiwCJkC/w1200-h1200-k/', 'The park is made up of fifty nine islands and islets in southern Georgian Bay. The area is a spectacular piece of the Canadian Shield. Accessible only by water, the park provides a wide variety of outdoor activities for its visitors but kayakers are the big winners here. Georgian Bay is Canada\'s foremost fresh water destination for paddlers. From here you can launch to several local campsites or head out for much longer excursions along the bay\'s shoreline.', '2611 Honey Harbour Rd, Honey Harbour, ON P0E 1E0, Canada', 'Ontario', 'ON', 'Canada', 'CA', 'P0E 1E0', '44.8743165', '-79.86995539999998', '(705) 527-7200', 0, 'http://pc.gc.ca/pn-np/on/georg/index'),
(59, 'ChIJybuQCDo94VMRoDoXiK4h0J4', 'Nahanni National Park Reserve of Canada', 'https://lh4.googleusercontent.com/-aDNNMOYSL00/VbxtgEyZFNI/AAAAAAAAAKM/rOssd-kd5KIvgclSG_aFAjmZvYjIKT4rQCJkC/s1600-w400/', 'Nahanni National Park Reserve of Canada protects a portion of the Mackenzie Mountains Natural Region offering the adventurous visitor a wilderness experience. A key feature of the park is the Naha Deh (South Nahanni River). Four great canyons line this spectacular whitewater river. At Nailicho (Virginia Falls) the river plunges in a thunderous plume. The park\'s sulphur hotsprings, alpine tundra, mountain ranges, and forests of spruce and aspen are home to many species of birds, fish and mammals. A visitor centre in Fort Simpson features displays on the history, culture and geography of the area. The park was inscribed on UNESCO\'s World Heritage List in 1978.', 'Fort Smith, Unorganized, NT X0E, Canada', 'Northwest Territories', 'NT', 'Canada', 'CA', 'X0E', '61.5006973', '-125.5004695', '+1 867-695-7750', 0, 'http://www.pc.gc.ca/pn-np/nt/nahanni/index.aspx'),
(60, 'ChIJMYch5Vblt1MRYCRaAt-2_t4', 'Wood Buffalo National Park of Canada', 'https://lh3.googleusercontent.com/-UzcioEkquVI/VWsfzsK4WEI/AAAAAAAAACA/dlx7drXwrrwp8mkXvTCIeUzvCa7XsPEuQCJkC/w1200-h1200-k/', 'As part of Canada\'s system of national parks and national historic sites, Wood Buffalo National Park of Canada is our country\'s largest national park and one of the largest in the world. It was established in 1922 to protect the last remaining herds of bison in northern Canada. Today, it protects an outstanding and representative example of Canada\'s Northern Boreal Plains.', 'Canada', 'Alberta', 'AB', 'Canada', 'CA', '', '59.4395031', '-112.8764021', '(867) 872-7960', 0, 'http://www.pc.gc.ca/pn-np/nt/woodbuffalo/index.aspx'),
(61, 'ChIJhYWQO4fqF1ERwNtHEkFUVG8', 'Ivvavik National Park', 'https://lh5.googleusercontent.com/-iVkA_p6gYAk/U9LoYwmQ7PI/AAAAAAAADyg/WMz6ivB0h7UYi5dO8jTCjVa1BHibc6niACJkC/w400-h300-k/', '', 'Ivvavik National Park, Unorganized, YT Y0B 1G0, Canada', 'Yukon Territory', 'YT', 'Canada', 'CA', 'Y0B 1G', '69.094186', '-139.833984', '(867) 777-8800', 0, 'http://www.pc.gc.ca/eng/pn-np/yt/ivvavik/index.aspx'),
(63, 'ChIJxWd-JkUIeVMRuQ7amxSgRPA', 'Glacier National Park of Canada', 'https://lh3.googleusercontent.com/-pSTzZVvKv5c/V9THsVLAkqI/AAAAAAAAAoY/wyJeMp8yPwAfEJ31bEmgQqPw1Il6DqcnwCJkC/s1600-w400/', NULL, 'Columbia-Shuswap A, BC V0A, Canada', 'British Columbia', 'BC', 'Canada', 'CA', 'V0A', '51.335289', '-117.5297595', '+1 250-837-7500', 0, 'http://www.pc.gc.ca/fra/pn-np/bc/glacier.aspx'),
(64, 'ChIJ86Tdw_oGV0sROLS0f6vC6C4', 'Kejimkujik National Park and National Historic Site', 'https://lh3.googleusercontent.com/-7P2NTMeMXfs/WC7aY2K1OII/AAAAAAAACBA/QhrHy2_itJkTCtnZt3vsKvo-4wHKFjNHgCLIB/w1200-h1200-k/', '', '3005 Kejimkujik Main Parkway, Maitland Bridge, NS B0T 1B0, Canada', 'Nova Scotia', 'NS', 'Canada', 'CA', 'B0T 1B0', '44.3763133', '-65.29553699999997', '(902) 682-2772', 0, 'http://pc.gc.ca/kejimkujik'),
(65, 'ChIJUxBJITveeVMRdW-P2NvpnPI', 'Yoho National Park', 'https://lh5.googleusercontent.com/-igdw27BIu9w/VDo-NFXp5sI/AAAAAAAAlQ8/LmAR0gmbJREhSDubiB4-r5gjjwLJo1uSwCLIB/s1600-w400/', 'Hii... this is Yoho National Park', 'Field, BC V0A 1G0, Canada', 'British Columbia', 'BC', 'Canada', 'CA', 'V0A 1G', '51.4666667', '-116.5833333', '+1 250-343-6783', 0, 'http://www.pc.gc.ca/eng/pn-np/bc/yoho/index.aspx'),
(66, 'ChIJg4PhzfUhrVYRSoSU7KO-MBA', 'Kluane National Park and Reserve', 'https://lh4.googleusercontent.com/-9QfzilHPWSE/VRBXNTUkmyI/AAAAAAAASaw/Zuj8cLr28ZUZ2fE-cdQQpaVU5tLncpnIwCJkC/s1600-w400/', NULL, 'Yukon, Unorganized, YT Y0B 1H0, Canada', 'Yukon Territory', 'YT', 'Canada', 'CA', 'Y0B 1H', '60.75', '-139.5', '+1 867-634-7207', 0, 'http://www.pc.gc.ca/eng/pn-np/yt/kluane/index.aspx'),
(67, 'ChIJv0mRixFDb1MRHFgDVHceYN8', 'Waterton Lakes National Park', 'https://lh5.googleusercontent.com/-HbrBPBKr1Po/V5Ak4IuuarI/AAAAAAAAAMY/zDB-Ss-jbUsdHUM6GBfYi6EvhCiB-SryACJkC/w1200-h1200-k/', '', 'Alberta 5, Waterton Park, AB T0K 2M0, Canada', 'Alberta', 'AB', 'Canada', 'CA', 'T0K 2M0', '49.0833333', '-113.91666670000001', '(403) 859-5133', 0, 'http://www.pc.gc.ca/eng/pn-np/ab/waterton/index.aspx'),
(68, 'ChIJUcquhthKFlMRXitl5L6viSE', 'Grasslands National Park of Canada', 'https://lh6.googleusercontent.com/-K9nSA0JP8hA/V-b67CS5ozI/AAAAAAAAFpw/9eTKQlKwBrMFoK-Be5PYK_1Km8lXFXM8gCLIB/w1200-h1200-k/', '', 'Val Marie, SK, Canada', 'Saskatchewan', 'SK', 'Canada', 'CA', 'S0N', '49.1250973', '-107.42133239999998', '(306) 298-2257', 0, 'http://www.pc.gc.ca/pn-np/sk/grasslands/index.aspx'),
(69, 'ChIJ_f9-6SYGelMRaZ4lDCFImk4', 'Kootenay National Park', 'https://lh6.googleusercontent.com/-0UNotOyvae4/V6J0_4IIX7I/AAAAAAAAD-U/4K2q9iX7XeweN8oDVaFUsDDSOziHn8BAACJkC/w1200-h1200-k/', '', 'British Columbia V0A, Canada', 'British Columbia', 'BC', 'Canada', 'CA', 'V0A', '50.9769367', '-115.9592101', '(250) 347-9505', 0, 'http://www.pc.gc.ca/kootenay'),
(70, 'ChIJOZd2A4h65lIRk9snPlKGjTs', 'Riding Mountain National Park', 'https://lh5.googleusercontent.com/-AjDM_vq84-k/V1WiSBxqAFI/AAAAAAAAFq4/-Gbw-aKaL9YGKuKC38X7ELIcWmtsMKfWACJkC/w1200-h1200-k/', '', '135 Wasagaming Dr, Onanole, MB R0J 1N0, Canada', 'Manitoba', 'MB', 'Canada', 'CA', 'R0J 1N0', '50.65829830000001', '-99.97145180000001', '(204) 848-7275', 0, 'http://www.pc.gc.ca/ridingmountain'),
(71, 'ChIJZWtoY7M3xU8RU_ErCKrn6uE', 'Quttinirpaaq National Park', 'https://lh6.googleusercontent.com/-iTEjDa4bC8M/WDNdJ4OZwTI/AAAAAAAADNI/go88JwWOC4Ujgf4uYePKXqoH6asVsTkVwCLIB/w1200-h1200-k/', '', 'Sirmilik National Parks Office, Pond Inlet, NU X0A 0H0, Canada', 'Nunavut', 'NU', 'Canada', 'CA', 'X0A 0H0', '81.4672471', '-72.10908280000001', '(867) 975-4673', 0, 'http://www.pc.gc.ca/quttinirpaaq'),
(72, 'ChIJg8GT7ObyelIR26fYaqzms5I', 'Wapusk National Park', 'https://lh4.googleusercontent.com/-fjQJVJCjRSc/V83NEoLJBBI/AAAAAAAAA44/5JkvMjqKrsoB-qyw-16thnsOVK0mH3xOwCJkC/w1200-h1200-k/', '', 'Wapusk National Park, Division No. 23, Unorganized, MB R0B 0E0, Canada', 'Manitoba', 'MB', 'Canada', 'CA', 'R0B 0E0', '57.786105', '-93.15803799999998', '(204) 675-8863', 0, 'http://www.pc.gc.ca/wapusk'),
(73, 'ChIJY3Vjo488fE4RT0YdgQj8iK8', 'Auyuittuq National Park', 'https://lh3.googleusercontent.com/-q9kQW7kJBE4/V6XelRDbNAI/AAAAAAAAats/GOoshvSyNcgdTP7rXgP5VQcU6Vw1vXNwwCJkC/w1200-h1200-k/', '', 'Auyuittuq National Park, Unorganized, NU X0A 0R0, Canada', 'Nunavut', 'NU', 'Canada', 'CA', 'X0A 0R0', '67.489532', '-66.05595900000003', '(867) 473-2500', 0, 'http://pc.gc.ca/auyuittuq'),
(74, 'ChIJaXziCBVgxkwRqUc_ok357xs', 'La Mauricie National Park', 'https://lh3.googleusercontent.com/-MvNPaHy7i2s/V-LbNd0yfqI/AAAAAAAAOPc/uFgmKXLw8588swdDIcpvwnp-KZkHQCztgCJkC/w1200-h1200-k/', '', 'Parc National de la Mauricie, Saint-Mathieu-du-Parc, QC G0X 1N0, Canada', 'QuÃ©bec', 'QC', 'Canada', 'CA', 'G0X 1N0', '46.6500272', '-72.96800150000001', '(819) 538-3232', 0, 'http://www.pc.gc.ca/pn-np/qc/mauricie/index.aspx'),
(75, 'ChIJm0cbnFsiRE0RZAlmNHsqfJQ', 'Pukaskwa National Park', 'https://lh5.googleusercontent.com/-d6LEmL68YYk/V5eQtA-Gs1I/AAAAAAAAACo/tyP23znHsnYKUvfIlpu2rAnXT4ljrg9NACJkC/w1200-h1200-k/', '', 'Heron Bay, ON P0T 1R0, Canada', 'Ontario', 'ON', 'Canada', 'CA', 'P0T 1R0', '48.2456784', '-85.8877814', '(807) 229-0801', 0, 'http://www.pc.gc.ca/pukaskwa'),
(76, 'ChIJ72vPHCBFeUsRdjmRPWNqdWU', 'Gros Morne National Park', 'https://lh6.googleusercontent.com/--xyQbofu1S0/Ui3hfT2vJHI/AAAAAAAAACw/AgosITSiFwYV5k5_JSAA_3jgWMx2UD-bgCJkC/w1200-h1200-k/', '', 'Newfoundland and Labrador, Canada', 'Newfoundland and Labrador', 'NL', 'Canada', 'CA', 'A0K', '49.652015', '-57.755758000000014', '(709) 458-2417', 0, 'http://www.pc.gc.ca/grosmorne'),
(77, 'ChIJV_FafvMELU0Rtqm9omn5Shw', 'Bruce Peninsula National Park', 'https://lh5.googleusercontent.com/-PiBDp-1uJ8o/V7Mn92RnI5I/AAAAAAAAnXo/nWyA4i4UbkAsjuVAKOdgl280xwLCjGeHwCJkC/w1200-h1200-k/', '', 'Bruce Peninsula National Park, Tobermory, ON N0H 2R0, Canada', 'Ontario', 'ON', 'Canada', 'CA', 'N0H 2R0', '45.216359', '-81.50398799999999', '(519) 596-2233', 0, 'http://www.pc.gc.ca/bruce'),
(78, 'ChIJ24GRAMFDzUwRoeRShcqbemM', 'Thousand Islands National Park', 'https://lh5.googleusercontent.com/-Y-ChLQFot-4/WOJktZsCJyI/AAAAAAAAId8/0fOqQCOayoAidNraEb6iFLBFkDrCOTgawCLIB/w1200-h1200-k/', '', 'Ontario, Canada', 'Ontario', 'ON', 'Canada', 'CA', 'K0E', '44.3425776', '-76.05093199999999', '(613) 923-5261', 0, 'http://www.pc.gc.ca/lawren'),
(79, 'ChIJvz5DI3NooFMRbSqByq7r8CM', 'Elk Island National Park', 'https://lh6.googleusercontent.com/-xzYk6Euju4U/V_XArd97iXI/AAAAAAAALLM/h34cz2b0yT4hPh6ByWrrE92Pzx6t7sbxwCJkC/w1200-h1200-k/', '', 'Elk Island National Park, Improvement District No. 13, AB T8G 2A6, Canada', 'Alberta', 'AB', 'Canada', 'CA', 'T8G 2A6', '53.58300699999999', '-112.83648900000003', '(780) 922-5790', 0, 'http://www.pc.gc.ca/elk'),
(80, 'ChIJQRH6qnwepVERqxVUxe_fkHc', 'Aulavik National Park', 'http://www.aquatic.uoguelph.ca/explorer/province/nwt/aulavik/pictures/aulavik4.jpg', '', 'Aulavik National Park, Unorganized, NT X0E 0Z0, Canada', 'Northwest Territories', 'NT', 'Canada', 'CA', 'X0E 0Z0', '73.60200999999999', '-119.404111', '(867) 690-3904', 0, 'http://pc.gc.ca/eng/pn-np/nt/aulavik/index.aspx'),
(81, 'ChIJyaLFSj48eVMRc4lvx8rhwJ0', 'Mount Revelstoke National Park', 'https://lh6.googleusercontent.com/-7Z1glwHO1No/WGUS0DkcWRI/AAAAAAAAIcQ/rVNbr7Ck2Ug1TQHKmEDLuVS1M7GY-o8CwCLIB/w1200-h1200-k/', '', 'Revelstoke, Columbia-Shuswap B, BC V0E 2S4, Canada', 'British Columbia', 'BC', 'Canada', 'CA', 'V0E 2S4', '51.083549', '-118.000043', '(250) 837-7500', 0, 'http://www.pc.gc.ca/montrevelstoke'),
(82, 'ChIJsfQ6Wg63F04RoglDDEzDQx4', 'Sirmilik National Park', 'https://lh5.googleusercontent.com/-Fy_w4ehPUQo/VXOzhKf8wLI/AAAAAAAAAkU/GHzQTdJTsl0-YB6lFn4UjuLsaJjqfWOHQCJkC/w1200-h1200-k/', '', 'Sirmilik National Parks Office, Pond Inlet, NU X0A 0A0, Canada', 'Nunavut', 'NU', 'Canada', 'CA', 'X0A 0A0', '72.9269304', '-80.95513679999999', '(867) 899-8092', 0, 'http://www.pc.gc.ca/sirmilik'),
(83, 'ChIJtxyScnvgOEwR2z0kWqNPfAo', 'Torngat Mountains National Park', 'https://farm2.staticflickr.com/1132/5104402675_41a18ee643_z.jpg', '', 'Torngat Mountains, Nain, NL A0P 1L0, Canada', 'Newfoundland and Labrador', 'NL', 'Canada', 'CA', 'A0P 1L', '59.2068982', '-64.1501212', '(709) 922-1290', 0, 'http://pc.gc.ca/eng/pn-np/nl/torngats/index.aspx'),
(84, 'ChIJ26LfMQm4X0sRhkMDcLeKSBQ', 'Prince Edward Island National Park', 'https://lh3.googleusercontent.com/-BCeH5eC0sI4/WAz1g0-SqMI/AAAAAAACDZo/hREzKdPsw6IBetYOyvWO-WRxJL3LWZrmwCLIB/w1200-h1200-k/', '', 'North Rustico, Dalvay by the Sea, PE C0A 1P0, Canada', 'Prince Edward Island', 'PE', 'Canada', 'CA', 'C0A 1P0', '46.41571400000001', '-63.073203000000035', '(902) 672-6350', 0, 'http://www.pc.gc.ca/pei'),
(85, 'ChIJCfzspQq3oUwRfTTH6GYFueo', 'Kouchibouguac National Park', 'https://lh5.googleusercontent.com/-SSp45NgqDJ8/WFk4uJlVOBI/AAAAAAAAqQ8/m-BFIgpkJ_UPFwUCWBEP_ptzGPYx18jbQCLIB/w1200-h1200-k/', '', 'Kouchibouguac National Park, Kent, NB E4X 1V2, Canada', 'New Brunswick', 'NB', 'Canada', 'CA', 'E4X 1V2', '46.7962314', '-64.96416820000002', '(506) 876-2443', 0, 'http://pc.gc.ca/Kouchibouguac'),
(86, 'ChIJlZGSjCtmd1MR5tfKrGjincA', 'Banff National Park', 'https://lh3.googleusercontent.com/-uCITuzR9p4o/V-SDEQWgOnI/AAAAAAAACCU/TC9q3AcweFAGdaGnPA33xfYhBUzTFgZZACLIB/w1200-h1200-k/', '', 'Alberta T0L, Canada', 'Alberta', 'AB', 'Canada', 'CA', 'T0L', '51.4968464', '-115.92805609999999', '(403) 762-1550', 0, 'http://www.pc.gc.ca/pn-np/ab/banff/index.aspx'),
(87, 'ChIJAWv-p-DtAFMResJnkF2paJQ', 'Prince Albert National Park', 'https://lh6.googleusercontent.com/-8tFITlTW_-U/V_2tNb8rnHI/AAAAAAAAAPk/ZVzV3Z0-_Esz7eG4-_jmNHW52LnEiycdQCJkC/w1200-h1200-k/', '', 'Prince Albert National Park, SK S0J 2Y0, Canada', 'Saskatchewan', 'SK', 'Canada', 'CA', 'S0J 2Y0', '53.943465', '-106.296918', '(306) 663-4522', 0, 'http://pc.gc.ca/princealbert'),
(88, 'ChIJw4o0QGlMB1IRUG1Sg0jjQKY', 'Ukkusiksalik National Park', 'https://lh5.googleusercontent.com/-YYg38FUC_lI/VOsvyk-IoQI/AAAAAAAAABY/ZLIq2BIfO2ki55bhgGpKJUalCFmiFiS-gCJkC/w1200-h1200-k/', '', 'Ukkusiksalik National Park, Unorganized, NU X0C 0H0, Canada', 'Nunavut', 'NU', 'Canada', 'CA', 'X0C 0H0', '66.043133', '-88.98658799999998', '(867) 462-4500', 0, 'http://www.pc.gc.ca/ukkusiksalik'),
(89, 'ChIJ7WTcy-aZdlERZ1sDLJPWVms', 'Tuktut Nogait National Park', 'https://www.hinzie.com/writer/media/image/44033_max.jpg', '', 'Inuvik, Unorganized, NT X0E 1N0, Canada', 'Northwest Territories', 'NT', 'Canada', 'CA', 'X0E 1N0', '68.818748', '-121.74899099999999', '(867) 580-3233', 0, 'http://www.pc.gc.ca/tuktutnogait'),
(90, 'ChIJG4dCkcspg1MRktGbzm1KcuE', 'Jasper National Park', 'https://lh4.googleusercontent.com/-jL1LSRXcT1g/UlURD-Apa_I/AAAAAAAAeSk/LjAK_5s67QsP1aDM2o-4ulyR4g9HibYywCJkC/w1200-h1200-k/', '', 'Jasper, AB T0E 1E0, Canada', 'Alberta', 'AB', 'Canada', 'CA', 'T0E 1E0', '52.873383', '-117.95429389999998', '(780) 852-6176', 0, 'http://www.pc.gc.ca/Jasper'),
(91, 'ChIJe4HS69cVX1ER_AZli524_B0', 'NÃ¡Ã¡ts\'ihch\'oh National Park Reserve', 'http://www.pc.gc.ca/~/media/pn-np/nt/naatsihchoh/gallery1/Black-Wolf-Creek-Valley-South-of-Grizzly-Lake-in-the-Proposed-Park.ashx', '', 'Fort Smith Region, Tulita, NT X0E, Canada', 'Northwest Territories', 'NT', 'Canada', 'CA', 'X0E', '62.6706', '-128.5439', '(819) 683-8675', 0, 'http://pc.gc.ca/fra/pn-np/nt/naatsihchoh/index.aspx'),
(92, 'ChIJhTSXOx4-iVQRwUoXx5Xv8ic', 'Pacific Rim National Park Reserve', 'https://lh3.googleusercontent.com/-sB1QwwkCydQ/WG-51onoGiI/AAAAAAAARFE/AMktmEJWR8cHyhmxL5JOrMuPXl2GeZzyACLIB/w1200-h1200-k/', '', 'British Columbia V0R 3A0, Canada', 'British Columbia', 'BC', 'Canada', 'CA', 'V0R 3A0', '48.79193129999999', '-125.15635900000001', '(250) 726-3500', 0, 'http://www.pc.gc.ca/eng/pn-np/bc/pacificrim/index.aspx'),
(93, 'ChIJm2oMuthdp0wRwWaSWuhWJMI', 'Fundy National Park', 'https://lh4.googleusercontent.com/-CVG1bJAcL0U/WC7f5TKkhuI/AAAAAAAACFk/7JkeUByiaisFfIoJt0zD-YK9Y7VkVpi6gCLIB/w1200-h1200-k/', '', 'Alma, NB, Canada', 'New Brunswick', 'NB', 'Canada', 'CA', 'E4H', '45.6137768', '-65.031631', '(506) 887-6000', 0, 'http://www.pc.gc.ca/fundy'),
(94, 'ChIJX2442K4DZ0sR08IIy8OUP1U', 'Cape Breton Highlands National Park', 'https://lh3.googleusercontent.com/-Kd2fZCVPRN8/WAj91Mx6PqI/AAAAAAAAAKU/fo_M9rFfJME0Qq-aJpjPoA5GcupW4d8DACLIB/w1200-h1200-k/', '', 'Nova Scotia, Canada', 'Nova Scotia', 'NS', 'Canada', 'CA', 'B0C', '46.7382854', '-60.65097709999998', '(902) 224-2306', 0, 'http://www.pc.gc.ca/breton'),
(95, 'ChIJvQltgqWWm0wR3wCWtX3CrxU', 'Forillon National Park', 'https://lh4.googleusercontent.com/-XrOt06V_alU/WMSKNOR7hEI/AAAAAAAALZ4/M9pZBkZbUxo1f8QYP27mRr603rZGo8oegCLIB/w1200-h1200-k/', '', 'GaspÃ© Peninsula, GaspÃ©, QC G4X 6L7, Canada', 'QuÃ©bec', 'QC', 'Canada', 'CA', 'G4X 6L7', '48.83191300000001', '-64.25139100000001', '(418) 368-5505', 0, 'http://www.pc.gc.ca/pn-np/qc/forillon/index.aspx'),
(96, 'ChIJfeNqiLxziVQRS8_izMJ4Rso', 'Pacific Rim National Park Reserve of Canada', 'https://images.trvl-media.com/media/content/shared/images/travelguides/destination/57274/Pacific-Rim-National-Park-Reserve-87908.jpg', '', '2040 Pacific Rim Hwy, Ucluelet, BC V0R 3A0, Canada', 'British Columbia', 'BC', 'Canada', 'CA', 'V0R 3A0', '49.0452782', '-125.50534800000003', '(250) 726-3500', 0, 'http://www.pc.gc.ca/eng/pn-np/bc/pacificrim/visit.aspx'),
(97, 'ChIJhxmiGzA-dEsRcCcXcYDfvYQ', 'Terra Nova National Park', 'https://lh3.googleusercontent.com/-9p6pocSIBhY/WGBabzuhpZI/AAAAAAAAgwI/P7L1xhy-ZK4mjgB3TKYwcWwMlOBFZRwAACLIB/w1200-h1200-k/', '', 'Terra Nova National Park, Mallorytown, NL A0C 1L0, Canada', 'Newfoundland and Labrador', 'NL', 'Canada', 'CA', 'A0C 1L0', '48.5113462', '-53.959825199999955', '(709) 533-2801', 0, 'http://pc.gc.ca/terranova'),
(98, 'ChIJI-z1FrBYhEwRzQtmig9WV2Q', 'Mingan Archipelago National Park Reserve', 'https://lh5.googleusercontent.com/-9wmj4432oI8/V3RdW9XJHwI/AAAAAAAATIE/mIE6PQniDvI5pnBpIUQpR1h_9Iwj-bdDwCJkC/s1600-w400/', NULL, '1340 Rue de la Digue, Havre-Saint-Pierre, QC G0G 1P0, Canada', 'QuÃ©bec', 'QC', 'Canada', 'CA', 'G0G 1P', '50.225861', '-63.553225', '+1 418-538-3331', 0, 'http://www.pc.gc.ca/eng/pn-np/qc/mingan/visit/visit1.aspx'),
(99, 'ChIJg_uzAN4FbFQRaIKfTg-OnOs', 'Gwaii Haanas National Park Reserve and Haida Heritage Site', 'https://tce-live2.s3.amazonaws.com/media/media/77c96547-25d5-4295-a540-5a07340acb6c.jpg', '', 'Queen Charlotte, BC V0T 1S0, Canada', 'British Columbia', 'BC', 'Canada', 'CA', 'V0T 1S0', '52.4682741', '-131.5582291', '(250) 559-8818', 0, 'http://www.pc.gc.ca/eng/pn-np/bc/gwaiihaanas/index.aspx'),
(100, 'ChIJU8KG2EP-1YkRvWq81eGrf6w', 'Canada Parks Svc', 'https://lh6.googleusercontent.com/-7nxQuSOkI7k/V8tY1umfy2I/AAAAAAAAAXM/CZ7uB7F_MnEA62KwG31gi3a_yiJC9YPMgCJkC/s1600-w400/', '', 'Hastings, ON K0L 1Y0, Canada', 'Ontario', 'ON', 'Canada', 'CA', 'K0L 1Y0', '44.3095848', '-77.9567596', '(705) 696-2864', 0, 'http://www.pc.gc.ca/'),
(101, 'ChIJD5E8bpdfj1QRSuz3CK9X4Uw', 'Gulf Islands National Park Reserve', 'https://farm3.staticflickr.com/2808/12370941704_4765d3d851_c.jpg', '', '2220 Harbour Rd, Sidney, BC V8L 2P6, Canada', 'British Columbia', 'BC', 'Canada', 'CA', 'V8L 2P', '48.7671599', '-123.27712700000001', '(866) 944-1744', 0, 'http://www.pc.gc.ca/eng/pn-np/bc/gulf/index.aspx'),
(102, 'ChIJJysPcVuePVERTvr4_mBPqt4', 'Vuntut National Park', 'http://www.travelyukon.com/sites/default/files/styles/listing_banner_crop/adaptive-image/public/listings/vuntut-national-park-october2013_0.jpg?itok=LpEDc7oS', '', 'Unorganized, YT Y0B 1N0, Canada', 'Yukon Territory', 'YT', 'Canada', 'CA', 'Y0B 1N0', '68.38494399999999', '-139.85803299999998', '(888) 773-8888', 0, 'http://pc.gc.ca/eng/pn-np/yt/vuntut/index.aspx'),
(103, 'ChIJy3QJT-0o1YkRW6ZsVqb3UW4', 'Rouge National Urban Park', 'https://lh6.googleusercontent.com/-u5kNt_daupk/V2QEjc73aqI/AAAAAAAAA1k/ZOPoIRcB72UWoitVja9HRdbxoG7zE64kQCJkC/s1600-w400/', NULL, '10725 Reesor Rd, Markham, ON L6B 1A8, Canada', 'Ontario', 'ON', 'Canada', 'CA', 'L6B 1A', '43.9376799', '-79.223147', '+1 416-264-2020', 0, 'http://www.pc.gc.ca/eng/progs/np-pn/cnpn-cnnp/rouge/index.aspx'),
(104, 'ChIJk6gOhhPBF1MRPkBSTUQXVzQ', 'Grasslands National Park of Canada', 'https://lh5.googleusercontent.com/-cAKUZmy5UN0/WIqKLwAbFjI/AAAAAAAAEEk/olJ7hCW6k6IUcM9FGXUOrzGj9KE53kalwCLIB/s1600-w400/', NULL, 'Parc national des Prairies, Val Marie, SK S0N 2T0, Canada', 'Saskatchewan', 'SK', 'Canada', 'CA', 'S0N 2T', '49.073832', '-106.68404', '+1 306-298-2257', 0, 'http://pc.gc.ca/fra/pn-np/sk/grasslands/index.aspx'),
(105, 'ChIJoclxo_MKLU0RAeTfEhj_gfc', 'Fathom Five National Marine Park', 'https://lh6.googleusercontent.com/-xZCMcJBI_vg/V4uvyOgEtjI/AAAAAAAABNI/TX5cl9z-kIsnrjQFl6UwI10SahehWo3qQCJkC/s1600-w400/', NULL, '120 Chi sin tib dek Rd, Tobermory, ON N0H 2R0, Canada', 'Ontario', 'ON', 'Canada', 'CA', 'N0H 2R', '45.2819305', '-81.7238682', '+1 519-596-2233', 0, 'http://www.pc.gc.ca/amnc-nmca/on/fathomfive/default.aspx');

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `role_id` int(11) NOT NULL,
  `role_name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`role_id`, `role_name`) VALUES
(0, 'User'),
(1, 'Admin'),
(2, 'Super Admin');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `user_name` varchar(10) NOT NULL,
  `user_password` varchar(40) NOT NULL,
  `user_email` varchar(50) NOT NULL,
  `user_reg` date NOT NULL,
  `google_id` char(21) DEFAULT NULL,
  `accept_term` tinyint(1) NOT NULL,
  `role_id` int(11) NOT NULL DEFAULT '0',
  `user_status` int(11) NOT NULL DEFAULT '0',
  `email_valid` text NOT NULL,
  `email_subscribed` tinyint(1) NOT NULL DEFAULT '0',
  `activation_code` varchar(50) DEFAULT NULL,
  `activation_date` date DEFAULT NULL,
  `forget_token` text,
  `cookie_token` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `user_name`, `user_password`, `user_email`, `user_reg`, `google_id`, `accept_term`, `role_id`, `user_status`, `email_valid`, `email_subscribed`, `activation_code`, `activation_date`, `forget_token`, `cookie_token`) VALUES
(13, 'IrfaanTest', '7523559c9ee792acdcb4c6b8b896e7c34bd471ce', 'test@marvelcanada.ca', '2017-03-05', NULL, 1, 1, 0, '1', 0, NULL, NULL, NULL, NULL),
(32, 'andy', '88ea39439e74fa27c09a4fc0bc8ebe6d00978392', 'canadanationalpark@gmail.com', '2017-03-05', NULL, 1, 1, 0, '1', 1, NULL, NULL, NULL, NULL),
(33, 'duc', '88ea39439e74fa27c09a4fc0bc8ebe6d00978392', 'n01201945@humbermail.ca', '2017-03-01', NULL, 1, 0, 0, '1', 1, NULL, NULL, NULL, NULL),
(99, 'lenoir', '88ea39439e74fa27c09a4fc0bc8ebe6d00978392', 'ndnduc@yahoo.com', '2017-01-01', NULL, 1, 2, 0, '1', 1, NULL, NULL, NULL, 'ndnduc@yahoo.comf3f5ba169423eb628d9cf2ef9f4c5bbb13ca629ede427aa502cc9a445f677a536acf2366'),
(137, 'Sam', '52e1e50e823767d4e300cea5dd1a187c534e235e', 'weisen.li@hotmail.com', '2017-03-22', NULL, 1, 1, 0, '1', 0, NULL, NULL, NULL, NULL),
(147, 'john doe', '7523559c9ee792acdcb4c6b8b896e7c34bd471ce', 'test@email.com', '2017-03-29', NULL, 1, 0, 0, '1', 0, NULL, NULL, NULL, NULL),
(148, 'batman', 'a346bc80408d9b2a5063fd1bddb20e2d5586ec30', 'singhtej955@gmail.com', '2017-01-01', NULL, 1, 0, 0, '1', 1, NULL, NULL, NULL, NULL),
(149, 'spiderman', 'a346bc80408d9b2a5063fd1bddb20e2d5586ec30', 'spiderman@mail.com', '2017-01-02', NULL, 1, 0, 0, '1', 1, NULL, NULL, NULL, NULL),
(150, 'antman', 'a346bc80408d9b2a5063fd1bddb20e2d5586ec30', 'antman@mail.com', '2017-02-02', NULL, 1, 0, 0, '1', 1, NULL, NULL, NULL, NULL),
(151, 'ironman', 'a346bc80408d9b2a5063fd1bddb20e2d5586ec30', 'ironman@mail.com', '2017-02-02', NULL, 1, 1, 0, '1', 0, NULL, NULL, NULL, NULL),
(152, 'superwoman', 'a346bc80408d9b2a5063fd1bddb20e2d5586ec30', 'superwoman@mail.com', '2017-01-03', NULL, 1, 1, 0, '1', 0, NULL, NULL, NULL, NULL),
(153, 'supergirl', 'a346bc80408d9b2a5063fd1bddb20e2d5586ec30', 'supergirl@mail.com', '2017-01-03', NULL, 1, 1, 0, '1', 0, NULL, NULL, NULL, NULL),
(154, 'hulkgreen', 'a346bc80408d9b2a5063fd1bddb20e2d5586ec30', 'hulkgreen@mail.com', '2017-01-04', NULL, 1, 1, 0, '1', 0, NULL, NULL, NULL, NULL),
(155, 'flashman', 'a346bc80408d9b2a5063fd1bddb20e2d5586ec30', 'flash@mail.com', '2017-04-04', NULL, 1, 1, 0, '1', 0, NULL, NULL, NULL, NULL),
(156, 'punisher', 'a346bc80408d9b2a5063fd1bddb20e2d5586ec30', 'punisher@mail.com', '2017-04-04', NULL, 1, 1, 0, '1', 0, NULL, NULL, NULL, NULL),
(158, 'drstrange', 'a346bc80408d9b2a5063fd1bddb20e2d5586ec30', 'drstrange@mail.com', '2017-04-04', NULL, 1, 1, 0, '1', 0, NULL, NULL, NULL, NULL),
(159, 'powerrang', 'a346bc80408d9b2a5063fd1bddb20e2d5586ec30', 'powerranger@mail.com', '2017-04-04', NULL, 1, 1, 0, '1', 0, NULL, NULL, NULL, NULL),
(160, 'songoku', 'a346bc80408d9b2a5063fd1bddb20e2d5586ec30', 'sogoku@mail.com', '2017-04-10', NULL, 1, 1, 0, '1', 0, NULL, NULL, NULL, NULL),
(162, 'bulmabeaty', 'a346bc80408d9b2a5063fd1bddb20e2d5586ec30', 'bulma@mail.com', '2017-04-10', NULL, 1, 1, 0, '1', 0, NULL, NULL, NULL, NULL),
(166, 'dwqdqwd', '618e02fc80fa3a0bd41d65f5b54a11fc50426d12', 'yinanbao@outlook.com', '2017-04-11', NULL, 1, 1, 0, 'UOYSuKboucgL8Oez9EDxprmG82EkuAw1EvN+WVEqFzoL5t/rr+ZilDKft6Ifo2vV', 0, NULL, NULL, NULL, NULL),
(167, 'dwqdqwd', '618e02fc80fa3a0bd41d65f5b54a11fc50426d12', 'yinanbao@outlook.com', '2017-04-11', NULL, 1, 0, 0, 'UOYSuKboucgL8Oez9EDxprmG82EkuAw1EvN+WVEqFzoL5t/rr+ZilDKft6Ifo2vV', 0, NULL, NULL, NULL, NULL),
(168, 'dwqdqwd', '618e02fc80fa3a0bd41d65f5b54a11fc50426d12', 'yinanbao@outlook.com', '2017-04-11', NULL, 1, 0, 0, 'UOYSuKboucgL8Oez9EDxprmG82EkuAw1EvN+WVEqFzoL5t/rr+ZilDKft6Ifo2vV', 0, NULL, NULL, NULL, NULL),
(169, 'dwqdqwd', '618e02fc80fa3a0bd41d65f5b54a11fc50426d12', 'yinanbao@outlook.com', '2017-04-11', NULL, 1, 0, 0, 'UOYSuKboucgL8Oez9EDxprmG82EkuAw1EvN+WVEqFzoL5t/rr+ZilDKft6Ifo2vV', 0, NULL, NULL, NULL, NULL),
(170, 'dwqdqwd', '618e02fc80fa3a0bd41d65f5b54a11fc50426d12', 'yinanbao@outlook.com', '2017-04-11', NULL, 1, 0, 0, 'UOYSuKboucgL8Oez9EDxprmG82EkuAw1EvN+WVEqFzoL5t/rr+ZilDKft6Ifo2vV', 0, NULL, NULL, NULL, NULL),
(171, 'dwqdqwd', '618e02fc80fa3a0bd41d65f5b54a11fc50426d12', 'yinanbao@outlook.com', '2017-04-11', NULL, 1, 0, 0, 'UOYSuKboucgL8Oez9EDxprmG82EkuAw1EvN+WVEqFzoL5t/rr+ZilDKft6Ifo2vV', 0, NULL, NULL, NULL, NULL),
(172, 'aaaaaaaaa', '618e02fc80fa3a0bd41d65f5b54a11fc50426d12', 'yinanbao@outlook.com', '2017-04-11', NULL, 1, 0, 0, 'bnANtPiReE47XrYa46aYhSLfe45KIUBm4iYKBgFVPvagO8XeMeqAizXgM9LQeKXF', 0, NULL, NULL, NULL, NULL),
(202, 'baozier', '0c5e08fcca1ea2ec1cb8dcf41a292bf1e67e7e8d', 'byn9826@gmail.com', '2017-04-12', '115287409657586066271', 1, 0, 0, '1', 1, NULL, NULL, '8d1857e66c1c9913fef05519d6e463c6e23cac0b', 'byn9826@gmail.comf3f5ba169423eb628d9cf2ef9f4c5bbb5c37b16d645a550845b0e20a00265d3142e1b05c'),
(203, 'asdsad', '618e02fc80fa3a0bd41d65f5b54a11fc50426d12', 'yinanbao@outlook.com', '2017-04-20', NULL, 1, 0, 0, '6wzEiX9pTcTP2jj6jFbFCzMhH9HYPj8d3l5lhDctBZ7j1K4gFwL3UVYby6BfRDf8', 0, NULL, NULL, NULL, NULL),
(204, 'asd', '618e02fc80fa3a0bd41d65f5b54a11fc50426d12', 'yinanbao@outlook.com', '2017-04-20', NULL, 1, 0, 0, 'sDjsoQb18/Hl9jBBLIwnprtju7UBWodnobCzltoyqffwGQraBCJCJSG1y/0/oX8c', 0, NULL, NULL, NULL, NULL),
(205, 'baobaobao', '618e02fc80fa3a0bd41d65f5b54a11fc50426d12', 'yinanbao@outlook.com', '2017-04-20', NULL, 1, 0, 0, 'rXOWhRFdmc8G2ojbliqIoyLfe45KIUBm4iYKBgFVPvagO8XeMeqAizXgM9LQeKXF', 0, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_details`
--

CREATE TABLE `user_details` (
  `user_id` int(11) NOT NULL,
  `first_name` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `last_name` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `gender` char(1) CHARACTER SET utf8 DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `address` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `city` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `province` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `nationality` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `phone_number` char(10) CHARACTER SET utf8 DEFAULT NULL,
  `last_trip` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `next_trip` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `favourite_places` text CHARACTER SET utf8,
  `joined_on` datetime DEFAULT NULL,
  `image_src` text CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_details`
--

INSERT INTO `user_details` (`user_id`, `first_name`, `last_name`, `gender`, `date_of_birth`, `address`, `city`, `province`, `nationality`, `phone_number`, `last_trip`, `next_trip`, `favourite_places`, `joined_on`, `image_src`) VALUES
(13, 'Irfaan', 'Test Acc', 'M', '2017-03-05', 'No street', 'Fail City', 'Ontario', 'Alien', NULL, 'Earth', 'Planet zoe', 'none', '2017-03-05 17:46:33', 'avatar_13.JPG'),
(32, 'Andy', 'Nguyen', 'M', '2017-03-05', 'No street yet', NULL, NULL, 'Alien', '0000000000', 'Earth', 'Planet zoe', 'none', '2017-03-05 17:46:33', 'avatar_13.jpg'),
(33, 'Duc', 'Nguyen', 'M', '2017-03-05', 'No street yet', NULL, NULL, 'Alien', '0000000000', 'Earth', 'Planet zoe', 'none', '2017-03-05 17:46:33', 'avatar_13.jpg'),
(99, 'Lenoir', 'Nguyen', 'M', NULL, 'Rockhill Rd', 'Mississauga', 'Ontario', 'Vietnam', NULL, NULL, 'To the unknown', NULL, '2017-01-01 23:23:23', 'avatar_99.jpg'),
(146, 'Paul', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2017-03-23 09:09:53', 'https://lh5.googleusercontent.com/-e6FtEanP7SY/AAAAAAAAAAI/AAAAAAAAG-c/NbSS25EXrBs/s96-c/photo.jpg'),
(147, 'Paul', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2017-03-29 13:16:29', 'https://lh5.googleusercontent.com/-e6FtEanP7SY/AAAAAAAAAAI/AAAAAAAAG-c/NbSS25EXrBs/s96-c/photo.jpg'),
(148, 'Bat', 'Man', 'F', NULL, NULL, 'Toronto', 'Ontario', 'Canada', NULL, NULL, NULL, NULL, '2017-01-01 00:00:00', ''),
(149, 'Spider', 'Man', 'M', NULL, NULL, 'Missisauga', 'Ontario', 'Canada', NULL, NULL, NULL, NULL, '2017-01-02 00:00:00', ''),
(150, 'Ant', 'Man', 'F', NULL, NULL, 'Missisauga', 'Ontario', 'Canada', NULL, NULL, NULL, NULL, '2017-02-02 00:00:00', ''),
(151, 'Iron', 'Man', 'F', NULL, NULL, 'Missisauga', 'Ontario', 'Canada', NULL, NULL, NULL, NULL, '2017-02-02 00:00:00', ''),
(152, 'Super', 'Woman', 'F', NULL, NULL, 'Valgh', 'Ontario', 'Canada', NULL, NULL, NULL, NULL, '2017-01-03 00:00:00', ''),
(153, 'Super', 'Girl', 'F', NULL, NULL, 'Valgh', 'Ontario', 'Canada', NULL, NULL, NULL, NULL, '2017-01-03 00:00:00', ''),
(154, 'Hulk', 'Green', 'M', NULL, NULL, 'Valgh', 'Ontario', 'Canada', NULL, NULL, NULL, NULL, '2017-01-04 00:00:00', ''),
(155, 'Flash', 'Man', 'M', NULL, NULL, 'Malton', 'Ontario', 'Canada', NULL, NULL, NULL, NULL, '2017-04-04 00:00:00', ''),
(156, 'Punisher', 'Man', 'M', NULL, NULL, 'Malton', 'Ontario', 'Canada', NULL, NULL, NULL, NULL, '2017-04-04 00:00:00', ''),
(158, 'Dr', 'Strange', 'M', NULL, NULL, 'Malton', 'Ontario', 'Canada', NULL, NULL, NULL, NULL, '2017-04-04 00:00:00', ''),
(159, 'Power', 'Ranger', '', NULL, NULL, 'Malton', 'Ontario', 'Canada', NULL, NULL, NULL, NULL, '2017-04-10 00:00:00', ''),
(160, 'Songoku', 'Monkey', 'M', NULL, NULL, 'Malton', 'Ontario', 'Canada', NULL, NULL, NULL, NULL, '2017-04-10 00:00:00', ''),
(162, 'Bulma', 'Beautiful', 'F', NULL, NULL, 'Malton', 'Ontario', 'Canada', NULL, NULL, NULL, NULL, '2017-04-10 00:00:00', ''),
(193, 'dasdasd', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2017-04-11 19:01:11', 'default.png'),
(199, 'qweqwe', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2017-04-11 19:24:21', 'default.png'),
(202, 'bao', NULL, 'M', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2017-04-12 05:13:42', 'avatar_202.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `wish_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `park_id` int(11) NOT NULL,
  `added_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `wishlist`
--

INSERT INTO `wishlist` (`wish_id`, `user_id`, `park_id`, `added_on`) VALUES
(2, 12, 59, '2017-03-13 22:09:03'),
(7, 12, 77, '2017-03-14 16:35:51'),
(8, 9, 60, '2017-03-14 17:52:13'),
(9, 9, 80, '2017-03-14 17:52:29'),
(10, 9, 95, '2017-03-14 17:52:37'),
(13, 65, 102, '2017-03-17 07:53:51'),
(14, 31, 103, '2017-03-21 19:36:27'),
(15, 99, 60, '2017-03-22 19:43:28'),
(16, 99, 64, '2017-03-22 19:43:30'),
(17, 99, 59, '2017-03-22 19:43:32'),
(18, 137, 5, '2017-03-22 18:49:36'),
(19, 137, 59, '2017-03-22 18:49:42'),
(20, 137, 70, '2017-03-22 18:49:48'),
(21, 12, 58, '2017-03-29 08:08:45'),
(22, 12, 5, '2017-03-29 08:08:51'),
(23, 99, 68, '2017-03-29 15:47:15'),
(25, 13, 5, '2017-04-05 11:16:14'),
(27, 13, 77, '2017-04-05 15:44:44'),
(40, 146, 79, '2017-04-09 20:06:04'),
(42, 99, 61, '2017-04-10 17:49:41');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attitude`
--
ALTER TABLE `attitude`
  ADD PRIMARY KEY (`user_id`,`park_id`);

--
-- Indexes for table `footprints`
--
ALTER TABLE `footprints`
  ADD PRIMARY KEY (`footprint_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `park_id` (`park_id`);

--
-- Indexes for table `footprint_images`
--
ALTER TABLE `footprint_images`
  ADD PRIMARY KEY (`image_id`),
  ADD KEY `footprint_id` (`footprint_id`);

--
-- Indexes for table `gallery`
--
ALTER TABLE `gallery`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `nav_header`
--
ALTER TABLE `nav_header`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `park`
--
ALTER TABLE `park`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_id` (`user_id`),
  ADD UNIQUE KEY `google_id` (`google_id`);

--
-- Indexes for table `user_details`
--
ALTER TABLE `user_details`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`wish_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `park_id` (`park_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `footprints`
--
ALTER TABLE `footprints`
  MODIFY `footprint_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;
--
-- AUTO_INCREMENT for table `footprint_images`
--
ALTER TABLE `footprint_images`
  MODIFY `image_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;
--
-- AUTO_INCREMENT for table `gallery`
--
ALTER TABLE `gallery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `nav_header`
--
ALTER TABLE `nav_header`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `park`
--
ALTER TABLE `park`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;
--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=206;
--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `wish_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `footprints`
--
ALTER TABLE `footprints`
  ADD CONSTRAINT `footprints_ibfk_2` FOREIGN KEY (`park_id`) REFERENCES `park` (`id`);

--
-- Constraints for table `footprint_images`
--
ALTER TABLE `footprint_images`
  ADD CONSTRAINT `footprint_images_ibfk_1` FOREIGN KEY (`footprint_id`) REFERENCES `footprints` (`footprint_id`);

--
-- Constraints for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD CONSTRAINT `wishlist_fk002` FOREIGN KEY (`park_id`) REFERENCES `park` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
