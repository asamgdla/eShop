/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

# Dump of table products
# ------------------------------------------------------------

DROP TABLE IF EXISTS `products`;

CREATE TABLE `products` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '',
  `image_url` varchar(255) DEFAULT NULL,
  `price` decimal(8,2) unsigned NOT NULL,
  `stock` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;

INSERT INTO `products` (`id`, `name`, `image_url`, `price`, `stock`)
VALUES
	(1,'Apple iPhone 5S','http://cf4.souqcdn.com/item/2013/10/22/57/54/74/2/item_M_5754742_3518911.jpg',5499.00,10),
	(2,'Apple iPad Air','http://cf3.souqcdn.com/item/2013/10/23/62/76/31/2/item_M_6276312_3528682.jpg',5151.00,7),
	(3,'Apple Macbook Air','http://cf2.souqcdn.com/item/40/81/27/9/item_M_4081279_942036.jpg',10000.00,12),
	(4,'Apple MacBook Pro With Retina Display','http://cf3.souqcdn.com/item/2013/11/13/63/28/21/4/item_M_6328214_3621445.jpg',23899.00,3),
	(5,'Apple iPhone Bluetooth','http://cf2.souqcdn.com/item/2014/01/14/65/08/41/9/item_M_6508419_3983072.jpg',138.00,25),
	(6,'85W Adapter Power Charger for Apple MacBook Pro','http://cf3.souqcdn.com/item/2014/05/17/69/44/28/2/item_M_6944282_4718816.jpg',450.00,9),
	(7,'Apple Magic Mouse','http://cf3.souqcdn.com/item/65/82/36/item_M_658236_556136.jpg',699.00,1),
	(8,'Apple Earpods With Remote And Mic','http://cf3.souqcdn.com/item/2013/08/28/56/75/40/3/item_M_5675403_2783321.jpg',44.74,0);

/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
