/*
SQLyog Ultimate v11.11 (64 bit)
MySQL - 5.5.5-10.4.17-MariaDB : Database - bsmxsite_energyopening
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`bsmxsite_energyopening` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

USE `bsmxsite_energyopening`;

/*Table structure for table `configuracion` */

DROP TABLE IF EXISTS `configuracion`;

CREATE TABLE `configuracion` (
  `tipo` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `valor` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`tipo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `configuracion` */

insert  into `configuracion`(`tipo`,`valor`,`created_at`,`updated_at`) values ('encuesta','https://docs.google.com/forms/d/e/1FAIpQLSdL71umC2eJyVvw_f4lMduYsn8pOpgt62J2RDgTcYorQBMOsA/viewform4',NULL,'2021-06-15 12:55:53');

/*Table structure for table `direcciones` */

DROP TABLE IF EXISTS `direcciones`;

CREATE TABLE `direcciones` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) DEFAULT NULL,
  `codigo_postal` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `estado` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `municipio` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `colonia` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `calle` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `numero_exterior` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `numero_interior` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  `flete` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `importe_flete` double NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `direcciones` */

insert  into `direcciones`(`id`,`user_id`,`codigo_postal`,`estado`,`municipio`,`colonia`,`calle`,`numero_exterior`,`numero_interior`,`flete`,`importe_flete`,`created_at`,`updated_at`,`deleted_at`) values (10,12,'82123','Sinaloa','Mazatlan','Gilberto Melendrez 16','El Venadillo','16',NULL,'Prueba',0.02,'2021-06-25 16:41:12','2021-06-25 16:41:12',NULL);

/*Table structure for table `pedidos` */

DROP TABLE IF EXISTS `pedidos`;

CREATE TABLE `pedidos` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `direccion_id` bigint(20) NOT NULL,
  `direccion` varchar(500) NOT NULL,
  `fecha_entrega` date NOT NULL,
  `observaciones` varchar(500) DEFAULT NULL,
  `flete` varchar(200) NOT NULL,
  `importe_flete` double NOT NULL,
  `total_flete` double NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'pendiente',
  `total` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2162 DEFAULT CHARSET=utf8mb4;

/*Data for the table `pedidos` */

insert  into `pedidos`(`id`,`user_id`,`direccion_id`,`direccion`,`fecha_entrega`,`observaciones`,`flete`,`importe_flete`,`total_flete`,`status`,`total`,`created_at`,`updated_at`,`deleted_at`) values (2160,12,10,'El Venadillo 16 - Col. Gilberto Melendrez 16 - Mazatlan, Sinaloa. C.P: 82123','2021-06-27',NULL,'',0,0,'pendiente',220200,'2021-06-25 16:43:13','2021-06-25 16:43:13',NULL),(2161,12,10,'El Venadillo 16 - Col. Gilberto Melendrez 16 - Mazatlan, Sinaloa. C.P: 82123','2021-06-28',NULL,'Prueba',0.02,300,'pendiente',315300,'2021-06-25 17:44:28','2021-06-25 17:47:39',NULL);

/*Table structure for table `pedidos_documentacion` */

DROP TABLE IF EXISTS `pedidos_documentacion`;

CREATE TABLE `pedidos_documentacion` (
  `pedido_id` bigint(20) NOT NULL,
  `folio_carta_porte` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tracking` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_factura` date DEFAULT NULL,
  `folio_factura` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `litros_totales` double DEFAULT NULL,
  `total_factura` double DEFAULT NULL,
  `pdf_factura` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `folio_nota_credito` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `litros_totales_nc` double DEFAULT NULL,
  `total_nota_credito` double DEFAULT NULL,
  `pdf_nota_credito` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `bol_carga` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `observaciones_facturacion` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `operador` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tractor` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tanque` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `densidad` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `bascula` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `veeder` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `observaciones_descarga` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `pedidos_documentacion` */

insert  into `pedidos_documentacion`(`pedido_id`,`folio_carta_porte`,`tracking`,`fecha_factura`,`folio_factura`,`litros_totales`,`total_factura`,`pdf_factura`,`folio_nota_credito`,`litros_totales_nc`,`total_nota_credito`,`pdf_nota_credito`,`bol_carga`,`observaciones_facturacion`,`operador`,`tractor`,`tanque`,`densidad`,`bascula`,`veeder`,`observaciones_descarga`,`created_at`,`updated_at`) values (2161,NULL,NULL,NULL,NULL,1,2,NULL,NULL,3,4,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-06-25 17:47:24','2021-06-29 02:25:39');

/*Table structure for table `productos` */

DROP TABLE IF EXISTS `productos`;

CREATE TABLE `productos` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `precio_base` double NOT NULL,
  `precio_a` double NOT NULL,
  `precio_b` double NOT NULL,
  `precio_c` double NOT NULL,
  `precio_d` double NOT NULL,
  `precio_e` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=646 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `productos` */

insert  into `productos`(`id`,`nombre`,`precio_base`,`precio_a`,`precio_b`,`precio_c`,`precio_d`,`precio_e`,`created_at`,`updated_at`,`deleted_at`) values (645,'Diesel',22,22.06,22.1,22.2,22.3,22.4,'2021-06-25 16:42:33','2021-06-25 16:42:33',NULL);

/*Table structure for table `productos_pedido` */

DROP TABLE IF EXISTS `productos_pedido`;

CREATE TABLE `productos_pedido` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `pedido_id` bigint(20) NOT NULL,
  `producto` varchar(500) NOT NULL,
  `cantidad` double NOT NULL,
  `costo` double NOT NULL,
  `total` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=50897 DEFAULT CHARSET=utf8mb4;

/*Data for the table `productos_pedido` */

insert  into `productos_pedido`(`id`,`pedido_id`,`producto`,`cantidad`,`costo`,`total`,`created_at`,`updated_at`,`deleted_at`) values (50894,2160,'Diesel',10000,22,220000,'2021-06-25 16:43:13','2021-06-25 16:43:13',NULL),(50896,2161,'Diesel',15000,21,315000,'2021-06-25 17:46:45','2021-06-29 02:25:39',NULL);

/*Table structure for table `unidades` */

DROP TABLE IF EXISTS `unidades`;

CREATE TABLE `unidades` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `unidad` varchar(60) NOT NULL,
  `abreviacion` varchar(10) NOT NULL,
  `fraccionario` tinyint(1) DEFAULT 0,
  `status` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4;

/*Data for the table `unidades` */

/*Table structure for table `user_producto` */

DROP TABLE IF EXISTS `user_producto`;

CREATE TABLE `user_producto` (
  `user_id` bigint(20) DEFAULT NULL,
  `producto_id` bigint(20) DEFAULT NULL,
  `tipo_precio` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `precio` double DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_producto` */

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telefono` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `foto` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tipo_usuario` int(11) NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `users` */

insert  into `users`(`id`,`email`,`password`,`nombre`,`telefono`,`foto`,`tipo_usuario`,`remember_token`,`created_at`,`updated_at`,`deleted_at`) values (1,'energyopening.pedidos@gmail.com','$2y$10$KzMlpj5StUgWAZ1FGTgX.eGC7vu7alcdt16lqQtMun2gpUzvoVi2y','Admin','',NULL,1,'uT4YrEj8oa874MGFsLJTCzzXzPl2gsiRLpYKnDnRmMc9JJrPrdsYM302X4dn',NULL,'2021-01-14 10:36:30',NULL),(12,'alexis.chiw@gmail.com','$2y$10$pCn3CVjIeWrrGkmr11OJa.bKupamAaupxtV/owzis4M2iv8UcZuFW','Alexis Chiw','6695333469',NULL,2,'6W32k35tTYyBQNW8ZYrLFScVXg069WturorxwRhzMrrRRUa8Hj2l9abDsMmR','2021-06-25 16:40:25','2021-06-25 16:40:25',NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
