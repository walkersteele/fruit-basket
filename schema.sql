CREATE DATABASE `fruitbasket` /*!40100 DEFAULT CHARACTER SET latin1 */;

CREATE TABLE `baskets` (
  `basket_id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `capacity` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`basket_id`),
  UNIQUE KEY `basket_id_UNIQUE` (`basket_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

CREATE TABLE `items` (
  `item_id` int(10) NOT NULL AUTO_INCREMENT,
  `item_type` varchar(255) NOT NULL,
  `weight` int(11) NOT NULL,
  `basket_id` int(10) NOT NULL,
  PRIMARY KEY (`item_id`,`basket_id`),
  UNIQUE KEY `item_id_UNIQUE` (`item_id`),
  KEY `fk-item-types_idx` (`item_type`),
  KEY `fk-item-basket_idx` (`basket_id`),
  CONSTRAINT `fk-item-basket` FOREIGN KEY (`basket_id`) REFERENCES `baskets` (`basket_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;
