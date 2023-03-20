-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 20-03-2023 a las 18:48:41
-- Versión del servidor: 8.0.31
-- Versión de PHP: 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `annoceo2`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `annonce`
--

DROP TABLE IF EXISTS `annonce`;
CREATE TABLE IF NOT EXISTS `annonce` (
  `id_annonce` int NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `description_courte` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `description_longue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `prix` int NOT NULL,
  `photo` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `pays` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `ville` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `adresse` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `cp` int NOT NULL,
  `membre_id` int DEFAULT NULL,
  `photo_id` int DEFAULT NULL,
  `categorie_id` int DEFAULT NULL,
  `date_enregistrement` datetime NOT NULL,
  PRIMARY KEY (`id_annonce`),
  UNIQUE KEY `photo_id` (`photo_id`),
  KEY `membre_id` (`membre_id`) USING BTREE,
  KEY `categorie_id` (`categorie_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=91 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `annonce`
--

INSERT INTO `annonce` (`id_annonce`, `titre`, `description_courte`, `description_longue`, `prix`, `photo`, `pays`, `ville`, `adresse`, `cp`, `membre_id`, `photo_id`, `categorie_id`, `date_enregistrement`) VALUES
(78, 'Mustang', 'Ford Mustang blanc', 'Capable d’atteindre 100 km/h en seulement 4,4 secondes, la Nouvelle Ford Mustang Mach 1 offre des performances à couper le souffle. Son nouveau système de refroidissement, sa direction précise et son châssis dernière génération vous garantissent une expérience de conduite incomparable.', 58500, '64090603152e0_voiture_blanc_princ.jpg', 'France', 'Paris', '50 rue de la liberté', 75005, 3, 58, 2, '2023-03-08 23:02:43'),
(79, 'Tulipe', 'Bouquet de tulipes', 'bouquet de tulipes contenant 10 pièces, mélange des couleurs possible.', 25, '640ede6a339eb_pexels-lil-artsy-1917356.jpg', 'France', 'Grenoble', '73, avenue Ferdinand de Lesseps', 38000, 4, 59, 8, '2023-03-13 09:27:22'),
(80, 'Photographe de mariage', 'Photographe spécialisé dans les mariages', 'Session de photographie pour votre mariage, prix inclus 25 photos retouchés. \r\n\r\nPour plus d\'information n\'hésites pas a me contacter.', 350, '640ee0204cc34_pexels-danik-prihodko-15878603.jpg', 'France', 'Strasbourg', '94, rue Descartes', 67100, 5, 60, 8, '2023-03-13 09:34:40'),
(81, 'Maison bois', 'Montage des maison en bois', 'Montage des maison en bois solides en nature.\r\nContacte moi pour plus d\'information.', 20000, '640ee98e0a7d0_pexels-simon-berger-751546.jpg', 'France', 'Marseille', '22, cours Franklin Roosevelt', 13009, 6, 61, 7, '2023-03-13 10:14:54'),
(82, 'Iphone 6', 'Vend iphone 6', 'Je vend mon iPhone 6 comme neuf', 550, '640ef3660ab84_pexels-torsten-dettlaff-56904.jpg', 'France', 'Dijon', '5, rue des lieutemants Thomazo', 21000, 7, 62, 5, '2023-03-13 10:56:54'),
(83, 'TV vintage', 'Vente de téléviseurs vintages', 'Vente de téléviseurs vintages, différents couleurs, modelés et styles. Il sont personnalisables, idéaux pour votre des campagnes de visualisation, posters, évènements', 290, '6414540ccd899_pexels-koolshooters-6976094.jpg', 'France', 'Vienne', '48, Place du Jeu de Paume', 38200, 8, 63, 5, '2023-03-13 11:40:15'),
(84, 'Cadres photos', 'Cadres photo vintages', 'Vente de cadres photos vintages, personnalisables avec la taille, couleur et format de vous besoin.', 55, '640efef3ed49f_pexels-tom-balabaud-1579708.jpg', 'France', 'Vienne', '48, Place du Jeu de Paume', 38200, 8, 64, 7, '2023-03-13 11:46:11'),
(89, 'Drapeu', 'Obtenez votre drapeau préféré dès maintenant', 'Nous vous proposons une large sélection de drapeaux de haute qualité pour votre usage personnel ou professionnel. Nous avons une variété de drapeaux nationaux, drapeaux de l\'Union européenne, drapeaux régionaux, drapeaux sportifs et drapeaux de décoration pour répondre à tous vos besoins.', 35, '641568315b70b_pexels-engin-akyurt-15868933.jpg', 'France', 'Lormont', '37 Rue Hubert de Lisle', 33310, 13, 69, 7, '2023-03-17 20:46:56'),
(90, 'Bijouterie', 'Bijouterie chapé or', 'Nous sommes ravis de vous présenter notre collection de bijouteries de la marque Chapé Or. Les bijoux Chapé Or sont reconnus pour leur qualité exceptionnelle et leur design élégant.\r\n\r\nNotre collection comprend une variété de bijoux tels que des bagues, des colliers, des bracelets, des boucles d\'oreilles et des montres, qui peuvent être portés pour toutes les occasions. Que vous recherchiez un bijou classique pour votre tenue de travail ou un accessoire audacieux pour une soirée, nous avons ce qu\'il vous faut.\r\n\r\nTous nos bijoux sont fabriqués avec des matériaux de haute qualité tels que l\'or, l\'argent et les pierres précieuses pour assurer une longue durée de vie. Nous offrons également une garantie de satisfaction à 100%, ce qui signifie que si vous n\'êtes pas entièrement satisfait de votre achat, nous ferons tout notre possible pour trouver une solution.', 200, '6415664848d0f_pexels-lumn-4155253.jpg', 'France', 'Lormont', '37 Rue Hubert de Lisle', 33310, 13, 70, 10, '2023-03-18 08:20:40');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorie`
--

DROP TABLE IF EXISTS `categorie`;
CREATE TABLE IF NOT EXISTS `categorie` (
  `id_categorie` int NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `motscles` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id_categorie`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categorie`
--

INSERT INTO `categorie` (`id_categorie`, `titre`, `motscles`) VALUES
(1, 'Emploi', 'Offres d\'emploi'),
(2, 'Véhicule', 'Voitures, Motos, Bateaux, Vélos, Equipement'),
(3, 'Immobilier', 'Ventes, Locations, Colocations, Bureaux, Logement'),
(4, 'Vacances', 'Camping, Hôtels, Hôte'),
(5, 'Multimedia', 'Jeux vidéos, Informatique, Image, Son, Teléphone'),
(6, 'Loisir', 'Films, Musique, Livres'),
(7, 'Materiel', 'Outillage, Fournitures de Bureau, Matériel Agricole'),
(8, 'Services', 'Prestations de services, Evénements'),
(9, 'Maison', 'Ameublement, Electroménager, Bricolage, Jardinage'),
(10, 'Vétements', 'Jean, Chemise, Robe, Chaussure');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `commentaire`
--

DROP TABLE IF EXISTS `commentaire`;
CREATE TABLE IF NOT EXISTS `commentaire` (
  `id_commentaire` int NOT NULL AUTO_INCREMENT,
  `membre_id` int NOT NULL,
  `annonce_id` int NOT NULL,
  `commentaire` text COLLATE utf8mb4_general_ci NOT NULL,
  `date_enregistrement` datetime NOT NULL,
  PRIMARY KEY (`id_commentaire`),
  KEY `membre_id` (`membre_id`),
  KEY `annonce_id` (`annonce_id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `commentaire`
--

INSERT INTO `commentaire` (`id_commentaire`, `membre_id`, `annonce_id`, `commentaire`, `date_enregistrement`) VALUES
(9, 1, 81, 'Les maison sont incroyables', '2023-03-20 12:19:33'),
(10, 1, 90, 'faux bijoux', '2023-03-20 12:20:34'),
(11, 1, 89, 'Drapeaux basiques', '2023-03-20 12:21:07'),
(12, 1, 84, 'Cadres de toutes tailles', '2023-03-20 12:21:36'),
(13, 1, 83, 'Tv\'s vintages avec des coleurs incroyables', '2023-03-20 12:22:10'),
(14, 1, 82, 'Faux', '2023-03-20 12:22:19'),
(16, 1, 90, 'fsdgdsgds', '2023-03-20 17:37:14'),
(17, 1, 90, 'Jai fail', '2023-03-20 17:37:36'),
(18, 1, 90, 'sdfsdf', '2023-03-20 18:09:39'),
(19, 1, 84, 'ça va', '2023-03-20 18:12:47'),
(20, 1, 84, 'buu', '2023-03-20 18:13:16');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `membre`
--

DROP TABLE IF EXISTS `membre`;
CREATE TABLE IF NOT EXISTS `membre` (
  `id_membre` int NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `mdp` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nom` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `prenom` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `telephone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `civilite` enum('homme','femme') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `statut` int NOT NULL,
  `date_enregistrement` datetime NOT NULL,
  PRIMARY KEY (`id_membre`),
  UNIQUE KEY `pseudo` (`pseudo`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `membre`
--

INSERT INTO `membre` (`id_membre`, `pseudo`, `mdp`, `nom`, `prenom`, `telephone`, `email`, `civilite`, `statut`, `date_enregistrement`) VALUES
(1, 'keke_123', '$2y$10$rOkyjIl6qbD3cx7sqQRjMesAJ4Owh6RZlGExW5Q8XSypcXj43NQja', 'suarez', 'keke', '0715245145', 'keke@gmail.com', 'homme', 1, '2023-03-07 13:26:09'),
(3, 'meghan.stanley', '$2y$10$9eIeP/f7JOBADbcZRuaOXe/xPV2pYMB9jrA4Rh5ByzGDdnH.6sKAi', 'Stanley', 'Meghan', '0768514232', 'meghan.stanley@example.com', 'femme', 0, '2023-03-08 22:15:58'),
(4, 'louella.rodriguez', '$2y$10$nOxS2LjJ1SjMV.ZQVcCNbev0BFtJ6gyoi7elCakCL0GtnNIWPAypW', 'Rodriguez', 'Rodriguez', '0752145265', 'louella.rodriguez@example.com', 'femme', 0, '2023-03-09 12:23:47'),
(5, 'ArnaudLaramee', '$2y$10$.Wm5L7vcgmslCJd8CkBzTuqrQ7XvxOuqul60Odgkh9ABe7fNhuiw2', 'Laramée', 'Arnaud', '0621834080', 'ArnaudLaramee@jourrapide.com', 'homme', 0, '2023-03-13 09:28:44'),
(6, 'YvesCharrette', '$2y$10$7Kp1KWg3BER9O8sh1JVU8u4nIHRBM..Yv1ljj1dMfeaHE13Lsv/JW', 'Charrette', 'Yves', '0495240132', 'YvesCharrette@armyspy.com', 'homme', 0, '2023-03-13 10:12:38'),
(7, 'EmmanuelleTrudeau', '$2y$10$WXcRxGJbNEllQ7nAQSEQmO9Ek0ALMarh.cnxVd4QTw1rzalFDsDcW', 'Trudeau', 'Emmanuelle', '0732288091', 'EmmanuelleTrudeau@dayrep.com', 'femme', 0, '2023-03-13 10:28:39'),
(8, 'GermainPaquet', '$2y$10$dzUHb5IRan.uhi5nQZ0Ti.2mY8CZA7SZnTmvVmUbOYr5RFml3eQ7m', 'Paquet', 'Germain', '0758675215', 'GermainPaquet@rhyta.com', 'homme', 0, '2023-03-13 11:17:43'),
(9, 'MorganaFecteau', '$2y$10$21r1kujdzhEufPbqQ5gnjOAXXgP3amZyyvNmfda2.Ww4Hb.SEmZRC', 'Fecteau', 'Morgana', '0654952366', 'MorganaFecteau@rhyta.com', 'femme', 0, '2023-03-13 12:04:09'),
(10, 'perry.rodriquez', '$2y$10$pNv5noiDCnCywTi6mU/1UOfz0JanQPzXt71c9vNGCCVY6oeyJqEX6', 'Rodriquez', 'Perry', '0782546985', 'perry.rodriquez@example.com', 'homme', 0, '2023-03-17 14:01:29'),
(13, 'marion.jacobs', '$2y$10$zvCf5phYGcwBeXwkZdU5ZuDJLqqrDqksW1GlWRFd0nbBxbe42IhIe', 'Jacbos', 'Marion', '0754854570', 'marion.jacobs@example.com', 'homme', 0, '2023-03-17 19:41:46');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `note`
--

DROP TABLE IF EXISTS `note`;
CREATE TABLE IF NOT EXISTS `note` (
  `id_note` int NOT NULL AUTO_INCREMENT,
  `membre_id1` int NOT NULL,
  `membre_id2` int DEFAULT NULL,
  `note` enum('1','2','3','4','5') COLLATE utf8mb4_general_ci NOT NULL,
  `date_enregistrement` datetime NOT NULL,
  PRIMARY KEY (`id_note`),
  KEY `membre_id1` (`membre_id1`),
  KEY `membre_id2` (`membre_id2`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `note`
--

INSERT INTO `note` (`id_note`, `membre_id1`, `membre_id2`, `note`, `date_enregistrement`) VALUES
(1, 1, 8, '5', '2023-03-20 09:51:56'),
(2, 8, 1, '4', '2023-03-20 16:42:43'),
(3, 1, NULL, '3', '2023-03-20 18:03:58'),
(4, 1, NULL, '3', '2023-03-20 18:05:54'),
(5, 1, 13, '3', '2023-03-20 18:07:19'),
(6, 1, 13, '3', '2023-03-20 18:09:39'),
(7, 1, 8, '4', '2023-03-20 18:12:47'),
(8, 1, 8, '1', '2023-03-20 18:13:16');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `photo`
--

DROP TABLE IF EXISTS `photo`;
CREATE TABLE IF NOT EXISTS `photo` (
  `id_photo` int NOT NULL AUTO_INCREMENT,
  `photo1` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `photo2` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `photo3` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `photo4` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `photo5` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id_photo`)
) ENGINE=InnoDB AUTO_INCREMENT=71 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `photo`
--

INSERT INTO `photo` (`id_photo`, `photo1`, `photo2`, `photo3`, `photo4`, `photo5`) VALUES
(1, '64085209cccd3_bootstrap.png', '64085209ccf26_javascript.png', '64085209cd275_ifocop-logo.png', '64085209cd60a_last-portfolio.jpg', '64085209cd91e_parallax.jpg'),
(2, '640852c9bd2e6_bootstrap.png', '640852c9bd66c_javascript.png', '640852c9bdc30_ifocop-logo.png', '640852c9bdecd_last-portfolio.jpg', '640852c9be179_parallax.jpg'),
(3, '6408ae524b5db_javascript.png', '6408ae524ba81_css.png', '6408ae524bf33_html.png', '6408ae524c418_musique.jpg', '6408ae524c988_ifocop-logo.png'),
(4, '6408ae795b7ff_javascript.png', '6408ae795bace_css.png', '6408ae795be02_html.png', '6408ae795c2a1_musique.jpg', '6408ae795c815_ifocop-logo.png'),
(5, '6408aedca31b6_javascript.png', '6408aedca3434_css.png', '6408aedca3843_html.png', '6408aedca3bd8_musique.jpg', '6408aedca4129_ifocop-logo.png'),
(6, '6408af290b0df_javascript.png', '6408af290b580_css.png', '6408af290b81b_html.png', '6408af290bb45_musique.jpg', '6408af290be19_ifocop-logo.png'),
(7, '6408af3db2561_javascript.png', '6408af3db27fd_css.png', '6408af3db2b29_html.png', '6408af3db2ee1_musique.jpg', '6408af3db3319_ifocop-logo.png'),
(8, '6408af99c939e_javascript.png', '6408af99c965e_css.png', '6408af99c9861_html.png', '6408af99c9bbb_musique.jpg', '6408af99ca119_ifocop-logo.png'),
(9, '6408afa7dc34e_javascript.png', '6408afa7dc703_css.png', '6408afa7dcb09_html.png', '6408afa7df2b6_musique.jpg', '6408afa7df5a1_ifocop-logo.png'),
(10, '6408afb3522eb_javascript.png', '6408afb3525a4_css.png', '6408afb352994_html.png', '6408afb352be9_musique.jpg', '6408afb3552f4_ifocop-logo.png'),
(11, '6408afb837b7e_javascript.png', '6408afb83a3af_css.png', '6408afb83a663_html.png', '6408afb83a92c_musique.jpg', '6408afb83ac87_ifocop-logo.png'),
(12, '6408afe4da460_javascript.png', '6408afe4da762_css.png', '6408afe4daaa6_html.png', '6408afe4dad09_musique.jpg', '6408afe4db08f_ifocop-logo.png'),
(13, '6408afe605052_javascript.png', '6408afe6053a6_css.png', '6408afe605b29_html.png', '6408afe605ef2_musique.jpg', '6408afe6061f1_ifocop-logo.png'),
(14, '6408afe65841a_javascript.png', '6408afe65ab0a_css.png', '6408afe65ad6f_html.png', '6408afe65b15b_musique.jpg', '6408afe65ba4b_ifocop-logo.png'),
(15, '6408afe6a0c2c_javascript.png', '6408afe6a13c7_css.png', '6408afe6a16a8_html.png', '6408afe6a1940_musique.jpg', '6408afe6a1c47_ifocop-logo.png'),
(16, '6408afe6dfea0_javascript.png', '6408afe6e276b_css.png', '6408afe6e2a72_html.png', '6408afe6e2cf9_musique.jpg', '6408afe6e3086_ifocop-logo.png'),
(17, '6408afe72a133_javascript.png', '6408afe72a9c2_css.png', '6408afe72adbe_html.png', '6408afe72b2ef_musique.jpg', '6408afe72b713_ifocop-logo.png'),
(18, '6408afe7583db_javascript.png', '6408afe758673_css.png', '6408afe758993_html.png', '6408afe758c26_musique.jpg', '6408afe758f25_ifocop-logo.png'),
(19, '6408afe7873f0_javascript.png', '6408afe7876ad_css.png', '6408afe787a37_html.png', '6408afe787e0d_musique.jpg', '6408afe7881a6_ifocop-logo.png'),
(20, '6408afe7be930_javascript.png', '6408afe7bebf2_css.png', '6408afe7bf307_html.png', '6408afe7bf58a_musique.jpg', '6408afe7bf8d3_ifocop-logo.png'),
(21, '6408afe805015_javascript.png', '6408afe8052ca_css.png', '6408afe8055a6_html.png', '6408afe805ec3_musique.jpg', '6408afe806422_ifocop-logo.png'),
(22, '6408b15f0fa73_javascript.png', '6408b15f0fcd8_css.png', '6408b15f0ff77_html.png', '6408b15f10256_musique.jpg', '6408b15f1052f_ifocop-logo.png'),
(23, '6408b20a8fbba_bootstrap.png', '6408b20a8fe33_boutique.jpg', '6408b20a900a5_Couleurs2.png', '6408b20a91658_css.png', '6408b20a919ab_ifocop-logo.png'),
(24, '6408b35e5ba9e_bootstrap.png', '6408b35e5bd8a_boutique.jpg', '6408b35e5c040_Couleurs2.png', '6408b35e5e632_css.png', '6408b35e5e91f_ifocop-logo.png'),
(25, '640903b361745_voiture_blanc_1.jpg', '640903b3619bd_voiture_blanc_2.jpg', '640903b361c3c_voiture_blanc_3.jpg', '640903b3622aa_voiture_blanc_4.jpg', '640903b3627db_voiture_blanc_princ.jpg'),
(58, '6409060315612_voiture_blanc_1.jpg', '640906031595a_voiture_blanc_2.jpg', '6409060315bcb_voiture_blanc_3.jpg', '6409060315ebe_voiture_blanc_4.jpg', '640906031638a_voiture_blanc_princ.jpg'),
(59, '640ede6a33d25_pexels-kim-van-vuuren-1586498.jpg', '640ede6a33fd1_pexels-brigitte-tohm-350349.jpg', '640ede6a343d2_pexels-ylanite-koppens-1883385 (1).jpg', '640ede6a34691_pexels-lil-artsy-2058498.jpg', '640ede6a34a41_pexels-lil-artsy-1917356.jpg'),
(60, '640ee0204cedd_pexels-danik-prihodko-15878597.jpg', '640ee0204d194_pexels-danik-prihodko-15878602.jpg', '640ee0204d454_pexels-danik-prihodko-15878608.jpg', '640ee0204dc2f_pexels-danik-prihodko-15878592.jpg', '640ee0204dff5_pexels-danik-prihodko-15878616.jpg'),
(61, '640ee98e0ab23_pexels-asap-jpeg-10749014.jpg', '640ee98e0aeed_pexels-russ-petcoff-2559026.jpg', '640ee98e0b203_pexels-jonathan-petersson-436381.jpg', '640ee98e0b57c_pexels-rhubia-santos-9278503.jpg', '640ee98e0b92b_pexels-dids-7450360.jpg'),
(62, '640ef3660ae91_pexels-negative-space-48605.jpg', '640ef3660b1d8_pexels-jess-bailey-designs-788946.jpg', '640ef3660b4a4_pexels-freestocksorg-987585.jpg', '640ef3660bb9c_pexels-miesha-renae-maiden-429862.jpg', '640ef3660c0b9_pexels-freestocksorg-688963.jpg'),
(63, '640efd8f1e74c_pexels-burak-the-weekender-704555.jpg', '640efd8f1e992_pexels-huỳnh-đạt-2251206.jpg', '640efd8f1ec7c_pexels-cottonbro-studio-4842638.jpg', '640efd8f1efe3_pexels-anete-lusina-5721879.jpg', '640efd8f1f2a9_pexels-anete-lusina-5721905.jpg'),
(64, '640efef3ed80c_pexels-tom-balabaud-1579708.jpg', '640efef3edaef_pexels-mister-mister-2442904.jpg', '640efef3ede55_pexels-azra-tuba-demir-8483097.jpg', '640efef3ee1cf_pexels-beyzaa-yurtkuran-14471016.jpg', '640efef3ee4ab_pexels-sara-garnica-2011173.jpg'),
(65, '6414c23631ce1_pexels-engin-akyurt-15869113.jpg', '6414c2363201c_pexels-engin-akyurt-15652226.jpg', '6414c236323f8_pexels-engin-akyurt-15868916.jpg', '6414c23632741_pexels-engin-akyurt-15651883.jpg', '6414c23632ac3_pexels-engin-akyurt-15651835.jpg'),
(66, '6414c25f82df2_pexels-engin-akyurt-15869113.jpg', '6414c25f830bc_pexels-engin-akyurt-15652226.jpg', '6414c25f833c1_pexels-engin-akyurt-15868916.jpg', '6414c25f8376c_pexels-engin-akyurt-15651883.jpg', '6414c25f83ab3_pexels-engin-akyurt-15651835.jpg'),
(67, '6414c28e40217_pexels-engin-akyurt-15869113.jpg', '6414c28e40580_pexels-engin-akyurt-15652226.jpg', '6414c28e408d5_pexels-engin-akyurt-15868916.jpg', '6414c28e40c0d_pexels-engin-akyurt-15651883.jpg', '6414c28e40f35_pexels-engin-akyurt-15651835.jpg'),
(68, '6414c30e7a234_pexels-engin-akyurt-15869113.jpg', '6414c30e7a4ad_pexels-engin-akyurt-15652226.jpg', '6414c30e7a816_pexels-engin-akyurt-15868916.jpg', '6414c30e7ab32_pexels-engin-akyurt-15651883.jpg', '6414c30e7aec5_pexels-engin-akyurt-15651835.jpg'),
(69, '6414c3b023dfc_pexels-engin-akyurt-15869113.jpg', '6414c3b02419c_pexels-engin-akyurt-15652226.jpg', '6414c3b024552_pexels-engin-akyurt-15868916.jpg', '6414c3b02487f_pexels-engin-akyurt-15651883.jpg', '6414c3b024bc1_pexels-engin-akyurt-15651835.jpg'),
(70, '641566484901c_pexels-lumn-4155254.jpg', '64156648492d4_pexels-lumn-4155250.jpg', '641566484959a_pexels-lumn-4155249.jpg', '6415664849880_pexels-lumn-4155247.jpg', '6415664849b73_pexels-lumn-4155248.jpg');

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `annonce`
--
ALTER TABLE `annonce`
  ADD CONSTRAINT `annonce_ibfk_1` FOREIGN KEY (`categorie_id`) REFERENCES `categorie` (`id_categorie`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `annonce_ibfk_2` FOREIGN KEY (`photo_id`) REFERENCES `photo` (`id_photo`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `annonce_ibfk_3` FOREIGN KEY (`membre_id`) REFERENCES `membre` (`id_membre`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `commentaire`
--
ALTER TABLE `commentaire`
  ADD CONSTRAINT `commentaire_ibfk_1` FOREIGN KEY (`annonce_id`) REFERENCES `annonce` (`id_annonce`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `commentaire_ibfk_2` FOREIGN KEY (`membre_id`) REFERENCES `membre` (`id_membre`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `note`
--
ALTER TABLE `note`
  ADD CONSTRAINT `note_ibfk_1` FOREIGN KEY (`membre_id2`) REFERENCES `membre` (`id_membre`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `note_ibfk_2` FOREIGN KEY (`membre_id1`) REFERENCES `membre` (`id_membre`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
