CREATE DATABASE IF NOT EXISTS `ipeardb`;
USE `ipeardb`;

CREATE TABLE `customer` (
	`id` INT(4) NOT NULL AUTO_INCREMENT,
	`last_name` VARCHAR(32) NOT NULL,
	`first_name` VARCHAR(32) NOT NULL,
	`email` VARCHAR(64) NOT NULL,
	`password` VARCHAR(64) NOT NULL,
	`phone_number` VARCHAR(16) NOT NULL,
	`birth_date` DATE NOT NULL,
	`creation_date` DATE NOT NULL,
	`address` VARCHAR(64) NOT NULL,
	`city` VARCHAR(64) NULL DEFAULT NULL,
	`postal_code` INT(5) NULL DEFAULT NULL,
	PRIMARY KEY (`id`),
	UNIQUE INDEX `email` (`email`)
)
COMMENT='Table contenant les données client'
COLLATE='utf8_general_ci'
ENGINE=InnoDB
;

DELETE FROM `customer`;
ALTER TABLE `customer` AUTO_INCREMENT = 1;

CREATE TABLE `admin` (
	`id` INT(4) NOT NULL AUTO_INCREMENT,
	`login` VARCHAR(32) NULL DEFAULT NULL,
	`email` VARCHAR(64) NOT NULL,
	`password` VARCHAR(64) NOT NULL,
	PRIMARY KEY (`id`),
	UNIQUE INDEX `email` (`email`),
	UNIQUE INDEX `login` (`login`)
)
COMMENT='Table contenant les données admin'
COLLATE='utf8_general_ci'
ENGINE=InnoDB
;

DELETE FROM `admin`;
ALTER TABLE `admin` AUTO_INCREMENT = 1;

CREATE TABLE `product_category` (
	`id` INT(4) NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(16) NOT NULL,
	PRIMARY KEY (`id`)
)
COMMENT='Table contenant les catégories produit'
COLLATE='utf8_general_ci'
ENGINE=InnoDB
;

DELETE FROM `product_category`;
ALTER TABLE `product_category` AUTO_INCREMENT = 1;

CREATE TABLE `product` (
	`id` INT(4) NOT NULL AUTO_INCREMENT,
	`category_id` INT(4) NOT NULL,
	`name` VARCHAR(32) NOT NULL,
	`description` VARCHAR(512) NOT NULL,
	`price` FLOAT(8,2) NOT NULL,
	`picture` VARCHAR(256) NOT NULL,
	`stock` INT(8) NOT NULL DEFAULT 0,
	PRIMARY KEY (`id`),
	INDEX `category_id` (`category_id`),
	CONSTRAINT `product_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `product_category` (`id`) ON UPDATE CASCADE ON DELETE CASCADE
)
COMMENT='Table contenant les données produit'
COLLATE='utf8_general_ci'
ENGINE=InnoDB
;

DELETE FROM `product`;
ALTER TABLE `product` AUTO_INCREMENT = 1;


CREATE TABLE `order` (
	`id` INT(4) NOT NULL AUTO_INCREMENT,
	`customer_id` INT(4) NOT NULL,
	`date` DATE NOT NULL,
	`state` VARCHAR(16) NOT NULL DEFAULT 'Nouvelle',
	`total_price` FLOAT(16,2) NOT NULL DEFAULT 0,
	PRIMARY KEY (`id`),
	INDEX `customer_id` (`customer_id`),
	CONSTRAINT `order_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`) ON UPDATE CASCADE ON DELETE CASCADE
)
COMMENT='Table contenant les données commandes'
COLLATE='utf8_general_ci'
ENGINE=InnoDB
;

DELETE FROM `order`;
ALTER TABLE `order` AUTO_INCREMENT = 1;

CREATE TABLE `order_line` (
	`order_id` INT(4) NOT NULL,
	`product_id` INT(4) NOT NULL,
	`quantity` INT(2) NOT NULL,
	`total_price` FLOAT(16,2) NOT NULL DEFAULT 0,
	PRIMARY KEY (`order_id`,`product_id`),
	INDEX `order_id` (`order_id`),
	CONSTRAINT `order_line_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `order` (`id`) ON UPDATE CASCADE ON DELETE CASCADE,
	CONSTRAINT `order_line_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON UPDATE CASCADE ON DELETE CASCADE
)
COMMENT='Table contenant les éléments d''une commande'
COLLATE='utf8_general_ci'
ENGINE=InnoDB
;

DELETE FROM `order_line`;


INSERT INTO `customer`(`first_name`,`last_name`,`email`,`password`,`phone_number`,`birth_date`,`creation_date`,`address`) VALUES('Yoan','Guerineau','yg@mail.fr','$2y$10$9IIn9H.wsq3Zo3AHPXtPB.YMN1hv6a1sKsCgv/IP7wKHFBA/kSQr2','0612345678','0102-03-04',CURDATE(),'01 adresse bidon, 01010, ville bidon'); /* $2y$10$9IIn9H.wsq3Zo3AHPXtPB.YMN1hv6a1sKsCgv/IP7wKHFBA/kSQr2 -> pass*/
INSERT INTO `customer`(`first_name`,`last_name`,`email`,`password`,`phone_number`,`birth_date`,`creation_date`,`address`,`postal_code`,`city`) VALUES('Devon','Euphrosine','de@mail.fr','$2y$10$9IIn9H.wsq3Zo3AHPXtPB.YMN1hv6a1sKsCgv/IP7wKHFBA/kSQr2','0687654321','0506-07-08',CURDATE(), '32 Allee des Coucourelles', 13580, 'La Fare-les-Oliviers'); /* $2y$10$9IIn9H.wsq3Zo3AHPXtPB.YMN1hv6a1sKsCgv/IP7wKHFBA/kSQr2 -> pass*/

INSERT INTO `admin`(`login`,`email`,`password`) VALUES('yg','yg@mail.fr','$2y$10$9IIn9H.wsq3Zo3AHPXtPB.YMN1hv6a1sKsCgv/IP7wKHFBA/kSQr2'); /* $2y$10$9IIn9H.wsq3Zo3AHPXtPB.YMN1hv6a1sKsCgv/IP7wKHFBA/kSQr2 -> pass*/
INSERT INTO `admin`(`login`,`email`,`password`) VALUES('de','de@mail.fr','$2y$10$9IIn9H.wsq3Zo3AHPXtPB.YMN1hv6a1sKsCgv/IP7wKHFBA/kSQr2'); /* $2y$10$9IIn9H.wsq3Zo3AHPXtPB.YMN1hv6a1sKsCgv/IP7wKHFBA/kSQr2 -> pass*/

INSERT INTO `product_category`(`name`) VALUES('iPear');
INSERT INTO `product_category`(`name`) VALUES('iPed');
INSERT INTO `product_category`(`name`) VALUES('iWotch');

INSERT INTO `product`(`category_id`,`name`,`description`,`price`,`picture`) VALUES(1,'iPear 4S','iPear 4S est sorti en 2011. Il mesure 115.2 x 58.6 x 9.3 mm et pèse 140 g. Il dispose d''un écran LED-backlit IPS LCD de 3.5" pouces. La définition d''écran est de 640 x 960 et la résolution est de 330 ppi. Un appareil photo Unique de 0.3 MP est responsable des selfies et les appels vidéo.. L''appareil principal Unique est de 8 MP. L''appareil intègre un processeur Dual-core 1.0 GHz Cortex-A9 et de mémoire 8/16/32/64 GB, 512 MB RAM. Batterie de 1432 mAh.',199.99,'./asset/ressources/images/iPear4S.png');
INSERT INTO `product`(`category_id`,`name`,`description`,`price`,`picture`) VALUES(1,'iPear 8','iPear 8 est sorti en 2017. Il mesure 138.4 x 67.3 x 7.3 mm et pèse 148 g. Il dispose d''un écran LED-backlit IPS LCD de 4.7" pouces. La définition d''écran est de 750 x 1334 et la résolution est de 326 ppi. Un appareil photo Unique de 7 MP est responsable des selfies et les appels vidéo.. L''appareil principal Unique est de 12 MP. L''appareil intègre un processeur Hexa-core (2x Monsoon + 4x Mistral) et de mémoire 64/256 GB, 2 GB RAM. Batterie de 1821 mAh.',699.99,'./asset/ressources/images/iPear8.png');
INSERT INTO `product`(`category_id`,`name`,`description`,`price`,`picture`) VALUES(1,'iPear 11','iPear 11 est sorti en 2019. Il mesure 150.9 x 75.7 x 8.3 mm et pèse 194 g. Il dispose d''un écran IPS LCD de 6.1" pouces. La définition d''écran est de 828 x 1792 et la résolution est de 326 ppi. Un appareil photo Double de 12 MP est responsable des selfies et les appels vidéo.. L''appareil principal Double est de 12 MP. L''appareil intègre un processeur Hexa-core (2x2.65 GHz Lightning + 4x1.8 GHz Thunder) et de mémoire 64GB 4GB RAM, 128GB 4GB RAM, 256GB 4GB RAM. Batterie de 3110 mAh.',799.99,'./asset/ressources/images/iPear11.png');
INSERT INTO `product`(`category_id`,`name`,`description`,`price`,`picture`) VALUES(1,'iPear 12','iPear 12 est sorti en 2020. Il mesure 146.7 x 71.5 x 7.4 mm et pèse 164 g. Il dispose d''un écran Super Retina XDR OLED de 6.1" pouces. La définition d''écran est de 1170 x 2532 et la résolution est de 460 ppi. Un appareil photo Double de 12 MP est responsable des selfies et les appels vidéo.. L''appareil principal Double est de 12 MP. L''appareil intègre un processeur Hexa-core (2x3.1 GHz Firestorm + 4x1.8 GHz Icestorm) et de mémoire 64GB 4GB RAM, 128GB 4GB RAM, 256GB 4GB RAM. Batterie de 2815 mAh.',889.99,'./asset/ressources/images/iPear12.png');
INSERT INTO `product`(`category_id`,`name`,`description`,`price`,`picture`) VALUES(1,'iPear 12 Pro','iPear 12 Pro est sorti en 2020. Il mesure 146.7 x 71.5 x 7.4 mm et pèse 189 g. Il dispose d''un écran Super Retina XDR OLED de 6.1" pouces. La définition d''écran est de 1170 x 2532 et la résolution est de 460 ppi. Un appareil photo Double de 12 MP est responsable des selfies et les appels vidéo.. L''appareil principal Quadruple est de 12 MP. L''appareil intègre un processeur Hexa-core (2x3.1 GHz Firestorm + 4x1.8 GHz Icestorm) et de mémoire 128GB 6GB RAM, 256GB 6GB RAM, 512GB 6GB RAM. Batterie de 2815 mAh.',1189.99,'./asset/ressources/images/iPear12Pro.png');

INSERT INTO `product`(`category_id`,`name`,`description`,`price`,`picture`) VALUES(2,'iPed Air','iPed Air a été présenté à la rentrée 2013 avec son écran rétina de 9.7 pouces avec une résolution de 2048x1536, le tout dans un produit qui pèse 469 grammes pour 17.5 mm d''épaisseur et une autonomie d''environ 10h en utilisation continue. Le tout est propulsé par un processeur A7 qui saura vous apporter toute la puissance nécessaire au quotidien.',249.99,'./asset/ressources/images/iPedAir.png');
INSERT INTO `product`(`category_id`,`name`,`description`,`price`,`picture`) VALUES(2,'iPed Mini','iPed Mini est une tablette tactile au format 7.9 pouces. Elle fonctionne avec iOS 9 et intègre un processeur Apple A8 cadencé à 1.4 GHz. Elle est équipée d''un capteur photo dorsal de 8 mégapixels et d''un capteur frontal de 1.2 mégapixels. Elle offre une capacité de stockage interne de 128 Go.',449.99,'./asset/ressources/images/iPedMini.png');
INSERT INTO `product`(`category_id`,`name`,`description`,`price`,`picture`) VALUES(2,'iPed Pro','iPed Pro est une tablette tactile au format 12.9 pouces. Elle fonctionne avec iOS 9 et intègre un processeur Apple A9X. Elle est équipée d''un capteur photo dorsal de 8 mégapixels et d''un capteur frontal de 1.2 mégapixels. Elle offre une capacité de stockage interne de 128 Go sans possibilité d''extension via une carte microSD.',599.99,'./asset/ressources/images/iPedPro.png');

INSERT INTO `product`(`category_id`,`name`,`description`,`price`,`picture`) VALUES(3,'iWotch Series 3','iWotch Series 3 L''Apple Watch Series 3 est une montre connectée qui permet de mimer les fonctionnalités de l''iPhone sans avoir besoin de le sortir. Elle dispose d''un nouveau SoC et est compatible LTE.',169.99,'./asset/ressources/images/iWotchSeries3.png');
INSERT INTO `product`(`category_id`,`name`,`description`,`price`,`picture`) VALUES(3,'iWotch Series 6 Nike','iWotch Series 6 Nike avec son boitier en aluminium argent est dotée de technologies révolutionnaires pour la santé: effectuez un électrocardiogramme à tout moment, n''importe où, ou mesurez votre taux d''oxygène dans le sang. Ayez toujours les données d''activité à portée de main avec l''écran Retina toujours allumé. Cette montre vous aide à mener une vie saine et active et, bien sûr, connectée à tout ce qui compte pour vous.',429.99,'./asset/ressources/images/iWotchSeries6Nike.png');

INSERT INTO `order`(`customer_id`,`date`,`state`,`total_price`) VALUES(1,NOW(),'Nouvelle',2099.97);
INSERT INTO `order_line`(`order_id`,`product_id`,`quantity`,`total_price`) VALUES(1,2,3,2099.97);

INSERT INTO `order`(`customer_id`,`date`,`state`,`total_price`) VALUES(1,NOW(),'En cours',1789.98);
INSERT INTO `order_line`(`order_id`,`product_id`,`quantity`,`total_price`) VALUES(2,5,1,1189.99);
INSERT INTO `order_line`(`order_id`,`product_id`,`quantity`,`total_price`) VALUES(2,8,1,599.99);

INSERT INTO `order`(`customer_id`,`date`,`state`,`total_price`) VALUES(2,NOW(),'Annulée',20999.70);
INSERT INTO `order_line`(`order_id`,`product_id`,`quantity`,`total_price`) VALUES(3,2,30,20999.70);

INSERT INTO `order`(`customer_id`,`date`,`state`,`total_price`) VALUES(2,NOW(),'Terminée',1229.98);
INSERT INTO `order_line`(`order_id`,`product_id`,`quantity`,`total_price`) VALUES(4,3,1,799.99);
INSERT INTO `order_line`(`order_id`,`product_id`,`quantity`,`total_price`) VALUES(4,10,1,429.99);
