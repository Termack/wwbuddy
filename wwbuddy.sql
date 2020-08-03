-- MySQL dump 10.13  Distrib 5.7.31, for Linux (x86_64)
--
-- Host: localhost    Database: wwbuddy
-- ------------------------------------------------------
-- Server version	5.7.31-0ubuntu0.18.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `countries`
--

DROP TABLE IF EXISTS `countries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `countries` (
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`name`),
  UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `countries`
--

LOCK TABLES `countries` WRITE;
/*!40000 ALTER TABLE `countries` DISABLE KEYS */;
INSERT INTO `countries` VALUES ('Afghanistan'),('Albania'),('Algeria'),('American Samoa'),('Andorra'),('Angola'),('Anguilla'),('Antarctica'),('Antigua and Barbuda'),('Argentina'),('Armenia'),('Aruba'),('Australia'),('Austria'),('Azerbaijan'),('Bahamas'),('Bahrain'),('Bangladesh'),('Barbados'),('Belarus'),('Belgium'),('Belize'),('Benin'),('Bermuda'),('Bhutan'),('Bolivia'),('Bosnia and Herzegovina'),('Botswana'),('Bouvet Island'),('Brazil'),('British Antarctic Territory'),('British Indian Ocean Territory'),('British Virgin Islands'),('Brunei'),('Bulgaria'),('Burkina Faso'),('Burundi'),('Cambodia'),('Cameroon'),('Canada'),('Canton and Enderbury Islands'),('Cape Verde'),('Cayman Islands'),('Central African Republic'),('Chad'),('Chile'),('China'),('Christmas Island'),('Cocos [Keeling] Islands'),('Colombia'),('Comoros'),('Congo - Brazzaville'),('Congo - Kinshasa'),('Cook Islands'),('Costa Rica'),('Côte d’Ivoire'),('Croatia'),('Cuba'),('Cyprus'),('Czech Republic'),('Denmark'),('Djibouti'),('Dominica'),('Dominican Republic'),('Dronning Maud Land'),('East Germany'),('Ecuador'),('Egypt'),('El Salvador'),('Equatorial Guinea'),('Eritrea'),('Estonia'),('Ethiopia'),('Falkland Islands'),('Faroe Islands'),('Fiji'),('Finland'),('France'),('French Guiana'),('French Polynesia'),('French Southern and Antarctic Territories'),('French Southern Territories'),('Gabon'),('Gambia'),('Georgia'),('Germany'),('Ghana'),('Gibraltar'),('Greece'),('Greenland'),('Grenada'),('Guadeloupe'),('Guam'),('Guatemala'),('Guernsey'),('Guinea'),('Guinea-Bissau'),('Guyana'),('Haiti'),('Heard Island and McDonald Islands'),('Honduras'),('Hong Kong SAR China'),('Hungary'),('Iceland'),('India'),('Indonesia'),('Iran'),('Iraq'),('Ireland'),('Isle of Man'),('Israel'),('Italy'),('Jamaica'),('Japan'),('Jersey'),('Johnston Island'),('Jordan'),('Kazakhstan'),('Kenya'),('Kiribati'),('Kuwait'),('Kyrgyzstan'),('Laos'),('Latvia'),('Lebanon'),('Lesotho'),('Liberia'),('Libya'),('Liechtenstein'),('Lithuania'),('Luxembourg'),('Macau SAR China'),('Macedonia'),('Madagascar'),('Malawi'),('Malaysia'),('Maldives'),('Mali'),('Malta'),('Marshall Islands'),('Martinique'),('Mauritania'),('Mauritius'),('Mayotte'),('Metropolitan France'),('Mexico'),('Micronesia'),('Midway Islands'),('Moldova'),('Monaco'),('Mongolia'),('Montenegro'),('Montserrat'),('Morocco'),('Mozambique'),('Myanmar [Burma]'),('Namibia'),('Nauru'),('Nepal'),('Netherlands'),('Netherlands Antilles'),('Neutral Zone'),('New Caledonia'),('New Zealand'),('Nicaragua'),('Niger'),('Nigeria'),('Niue'),('Norfolk Island'),('North Korea'),('North Vietnam'),('Northern Mariana Islands'),('Norway'),('Oman'),('Pacific Islands Trust Territory'),('Pakistan'),('Palau'),('Palestinian Territories'),('Panama'),('Panama Canal Zone'),('Papua New Guinea'),('Paraguay'),('Peru'),('Philippines'),('Pitcairn Islands'),('Poland'),('Portugal'),('Puerto Rico'),('Qatar'),('Réunion'),('Romania'),('Russia'),('Rwanda'),('Saint Barthélemy'),('Saint Helena'),('Saint Kitts and Nevis'),('Saint Lucia'),('Saint Martin'),('Saint Pierre and Miquelon'),('Saint Vincent and the Grenadines'),('Samoa'),('San Marino'),('São Tomé and Príncipe'),('Saudi Arabia'),('Senegal'),('Serbia'),('Serbia and Montenegro'),('Seychelles'),('Sierra Leone'),('Singapore'),('Slovakia'),('Slovenia'),('Solomon Islands'),('Somalia'),('South Africa'),('South Georgia and the South Sandwich Islands'),('South Korea'),('Spain'),('Sri Lanka'),('Sudan'),('Suriname'),('Svalbard and Jan Mayen'),('Swaziland'),('Sweden'),('Switzerland'),('Syria'),('Taiwan'),('Tajikistan'),('Tanzania'),('Thailand'),('Timor-Leste'),('Togo'),('Tokelau'),('Tonga'),('Trinidad and Tobago'),('Tunisia'),('Turkey'),('Turkmenistan'),('Turks and Caicos Islands'),('Tuvalu'),('U.S. Minor Outlying Islands'),('U.S. Miscellaneous Pacific Islands'),('U.S. Virgin Islands'),('Uganda'),('Ukraine'),('Union of Soviet Socialist Republics'),('United Arab Emirates'),('United Kingdom'),('United States'),('Unknown or Invalid Region'),('Uruguay'),('Uzbekistan'),('Vanuatu'),('Vatican City'),('Venezuela'),('Vietnam'),('Wake Island'),('Wallis and Futuna'),('Western Sahara'),('Yemen'),('Zambia'),('Zimbabwe'),('Åland Islands');
/*!40000 ALTER TABLE `countries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sender` varchar(50) NOT NULL,
  `receiver` varchar(50) NOT NULL,
  `content` varchar(500) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `send_idx` (`sender`,`receiver`),
  KEY `receive_idx` (`receiver`),
  CONSTRAINT `receive` FOREIGN KEY (`receiver`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `send` FOREIGN KEY (`sender`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messages`
--

LOCK TABLES `messages` WRITE;
/*!40000 ALTER TABLE `messages` DISABLE KEYS */;
INSERT INTO `messages` VALUES (1,'fc18e5f4aa09bbbb7fdedf5e277dda00','fc18e5f4aa09bbbb7fdedf5e277dda00','Hello, welcome to World Wide Buddy, here you can make friends all around the world. Just look for someone\'s profile and there you will be able to send them a message, enjoy your stay! :D'),(2,'fc18e5f4aa09bbbb7fdedf5e277dda00','be3308759688f3008d01a7ab12041198','Hello, welcome to World Wide Buddy, here you can make friends all around the world. Just look for someone\'s profile and there you will be able to send them a message, enjoy your stay! :D'),(3,'fc18e5f4aa09bbbb7fdedf5e277dda00','b5ea6181006480438019e76f8100249e','Hello, welcome to World Wide Buddy, here you can make friends all around the world. Just look for someone\'s profile and there you will be able to send them a message, enjoy your stay! :D'),(4,'b5ea6181006480438019e76f8100249e','be3308759688f3008d01a7ab12041198','Hey dude'),(5,'be3308759688f3008d01a7ab12041198','b5ea6181006480438019e76f8100249e','?'),(6,'b5ea6181006480438019e76f8100249e','be3308759688f3008d01a7ab12041198','Well, i think you should change the default password for our accounts in SSH, the employee birthday isn\'t a secure password :p'),(7,'be3308759688f3008d01a7ab12041198','b5ea6181006480438019e76f8100249e','haven\'t you changed yours?'),(8,'b5ea6181006480438019e76f8100249e','be3308759688f3008d01a7ab12041198','I did, but maybe in the future when you hire more people this can be a problem'),(9,'be3308759688f3008d01a7ab12041198','b5ea6181006480438019e76f8100249e','I\'ll look into it'),(10,'b5ea6181006480438019e76f8100249e','be3308759688f3008d01a7ab12041198','Sooo, will you hire that girl i was talking about?'),(11,'be3308759688f3008d01a7ab12041198','b5ea6181006480438019e76f8100249e','yeah, she seems good'),(12,'b5ea6181006480438019e76f8100249e','be3308759688f3008d01a7ab12041198',':DDDDD'),(13,'b5ea6181006480438019e76f8100249e','be3308759688f3008d01a7ab12041198','She\'ll be sooo happy when she finds out!!'),(14,'b5ea6181006480438019e76f8100249e','fc18e5f4aa09bbbb7fdedf5e277dda00','Hi bot'),(15,'b5ea6181006480438019e76f8100249e','fc18e5f4aa09bbbb7fdedf5e277dda00','My password is password456'),(16,'be3308759688f3008d01a7ab12041198','fc18e5f4aa09bbbb7fdedf5e277dda00','My password is password123');
/*!40000 ALTER TABLE `messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `isadmin` tinyint(1) DEFAULT NULL,
  `country` varchar(50) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username_UNIQUE` (`username`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `countryK_idx` (`country`),
  CONSTRAINT `countryK` FOREIGN KEY (`country`) REFERENCES `countries` (`name`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES ('b5ea6181006480438019e76f8100249e','Roberto','$2y$10$PkHAZ8SVDtginjwpn9vGcekg2JxetyteoVRIOd7PnwZ0d4ekCCPBW',NULL,'Brazil','roberto@wwbuddy.com','1995-04-14','I\'m a Brazilian guy who likes to write code, full stack developer working for WWBuddy, open for new friendships :D'),('be3308759688f3008d01a7ab12041198','Henry','$2y$10$hNckZFqENkU3ujDPQaJcV.RuGvFZdv6TXLukTW3dEzRYyV0mFBZqW',NULL,'Afghanistan','aa@a.c','1212-12-12','hi'),('fc18e5f4aa09bbbb7fdedf5e277dda00','WWBuddy','$2y$10$pqFdCymqbfybDc2LcskjsuW7jw3fuRUYep8cncOQuCjOCYYGzLqdG',NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-08-03 18:25:49
