USE medicoredb;

--
-- Table structure for table `transport`
--

DROP TABLE IF EXISTS `transport`;
CREATE TABLE `transport` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `name` varchar(25) NOT NULL COMMENT 'Transport',
    `compensation` float(2,2) unsigned NOT NULL COMMENT 'Compensation per km',
    PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
--
-- Table structure for table `employees`
--

DROP TABLE IF EXISTS `employees`;
CREATE TABLE `employees` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `employee` varchar(50) NOT NULL COMMENT 'Employee',
    `transport_id` int(11) NOT NULL COMMENT 'Transport',
    `distance` int(11) unsigned NOT NULL COMMENT 'Distance (km/one way)',
    `workdays` float(11,2) unsigned NOT NULL COMMENT 'Workdays per week',
    PRIMARY KEY (`id`),
    KEY `transport_id` (`transport_id`),
    CONSTRAINT `fk_transport` FOREIGN KEY (`transport_id`) REFERENCES `transport`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT

) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Table structure for table `compensation`
--

DROP TABLE IF EXISTS `compensation`;
CREATE TABLE `compensation` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `employee_id` int(11) NOT NULL,
    `date` date NOT NULL,
    `value` float(5,2) NOT NULL,
    PRIMARY KEY (`id`),
    KEY `employee_id` (`employee_id`),
    CONSTRAINT `fk_employee` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `transport`
--

INSERT INTO `transport` VALUES (1,'Bike',0.50),(2,'Bus',0.25),(3,'Train',0.25),(4,'Car',0.10);

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` VALUES 
(1,'Paul',4,60,5.00),
(2,'Martin',2,8,4.00),
(3,'Jeroen',1,9,5.00),
(4,'Tineke',1,4,3.00),
(5,'Arnout',3,23,5.00),
(6,'Matthijs',1,11,4.50),
(7,'Rens',4,12,5.00),
(8,'Tester',1,9,3.50);
