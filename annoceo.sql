-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : jeu. 09 mars 2023 à 11:39
-- Version du serveur : 8.0.31
-- Version de PHP : 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `annoceo`
--

-- --------------------------------------------------------

--
-- Structure de la table `annonce`
--

DROP TABLE IF EXISTS `annonce`;
CREATE TABLE IF NOT EXISTS `annonce` (
  `id_annonce` int NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `description_courte` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `description_longue` text COLLATE utf8mb4_general_ci NOT NULL,
  `prix` int NOT NULL,
  `photo` varchar(200) COLLATE utf8mb4_general_ci NOT NULL,
  `pays` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `ville` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `adresse` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `cp` int NOT NULL,
  `membre_id` int DEFAULT NULL,
  `photo_id` int DEFAULT NULL,
  `categorie_id` int DEFAULT NULL,
  `date_enregistrement` datetime NOT NULL,
  PRIMARY KEY (`id_annonce`),
  UNIQUE KEY `photo_id` (`photo_id`),
  KEY `membre_id` (`membre_id`) USING BTREE,
  KEY `categorie_id` (`categorie_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=79 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `annonce`
--

INSERT INTO `annonce` (`id_annonce`, `titre`, `description_courte`, `description_longue`, `prix`, `photo`, `pays`, `ville`, `adresse`, `cp`, `membre_id`, `photo_id`, `categorie_id`, `date_enregistrement`) VALUES
(17, 'Formulaire', 'Formulaire', 'Formulaire', 12500, '_jquery.png', 'Formulaire', 'Formulaire', 'Formulaire', 45200, 1, NULL, NULL, '2023-03-08 09:27:00'),
(26, 'Tire', 'Tire', 'Tire', 1550, '_portfolio-bruce.jpg', 'Tire', 'Tire', '25 ereg', 12500, 1, NULL, 9, '2023-03-08 09:48:29'),
(28, 'Annnonce 555', 'Annnonce 555', 'Annnonce 555', 1240, '640852c9bcfa1_boutique.jpg', 'France', 'Paris', '25 rue de', 20201, 1, 2, 3, '2023-03-08 10:18:01'),
(34, 'Mi casa', 'Mi casa es tu casa', 'Mi casa es tu casa 2', 12500, '6408af99c90cf_last-portfolio.jpg', 'France', 'Paris', '25 rue camille', 92500, 1, 8, NULL, '2023-03-08 16:54:01'),
(50, 'Description longue', 'Description longue', 'Description longue', 12500, '6408b35e5b775_html.png', 'Description longue', 'Description longue', 'Description longue', 92500, 1, 24, 2, '2023-03-08 17:10:06'),
(78, 'Mustang', 'Ford Mustang blanc', 'Capable d’atteindre 100 km/h en seulement 4,4 secondes, la Nouvelle Ford Mustang Mach 1 offre des performances à couper le souffle. Son nouveau système de refroidissement, sa direction précise et son châssis dernière génération vous garantissent une expérience de conduite incomparable.', 58500, '64090603152e0_voiture_blanc_princ.jpg', 'France', 'Paris', '50 rue de la liberté', 75005, 3, 58, 2, '2023-03-08 23:02:43');

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

DROP TABLE IF EXISTS `categorie`;
CREATE TABLE IF NOT EXISTS `categorie` (
  `id_categorie` int NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `motscles` text COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id_categorie`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `categorie`
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
-- Structure de la table `commentaire`
--

DROP TABLE IF EXISTS `commentaire`;
CREATE TABLE IF NOT EXISTS `commentaire` (
  `id_commentaire` int NOT NULL AUTO_INCREMENT,
  `membre_id` int DEFAULT NULL,
  `annonce_id` int DEFAULT NULL,
  `commentaire` text COLLATE utf8mb4_general_ci NOT NULL,
  `date_enregistrement` datetime NOT NULL,
  PRIMARY KEY (`id_commentaire`),
  UNIQUE KEY `membre_id` (`membre_id`),
  UNIQUE KEY `annonce_id` (`annonce_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `membre`
--

DROP TABLE IF EXISTS `membre`;
CREATE TABLE IF NOT EXISTS `membre` (
  `id_membre` int NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `mdp` varchar(60) COLLATE utf8mb4_general_ci NOT NULL,
  `nom` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `prenom` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `telephone` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `civilite` enum('homme','femme') COLLATE utf8mb4_general_ci NOT NULL,
  `statut` int NOT NULL,
  `date_enregistrement` datetime NOT NULL,
  PRIMARY KEY (`id_membre`),
  UNIQUE KEY `pseudo` (`pseudo`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `membre`
--

INSERT INTO `membre` (`id_membre`, `pseudo`, `mdp`, `nom`, `prenom`, `telephone`, `email`, `civilite`, `statut`, `date_enregistrement`) VALUES
(1, 'keke_123', '$2y$10$rOkyjIl6qbD3cx7sqQRjMesAJ4Owh6RZlGExW5Q8XSypcXj43NQja', 'suarez', 'keke', '0715245123', 'keke@gmail.com', 'homme', 1, '2023-03-07 13:26:09'),
(2, 'perfil-test', '$2y$10$41kKrJdxEmnDrdzuco.P5.v4NMJJ/fWaeAla7fEPyFhQKZWm0ohdi', 'perfil', 'test', '0152456989', 'perfil-test@gmail.com', 'homme', 0, '2023-03-07 21:22:14'),
(3, 'meghan.stanley', '$2y$10$9eIeP/f7JOBADbcZRuaOXe/xPV2pYMB9jrA4Rh5ByzGDdnH.6sKAi', 'Stanley', 'Meghan', '0768514232', 'meghan.stanley@example.com', 'femme', 0, '2023-03-08 22:15:58'),
(4, 'louella.rodriguez', '$2y$10$nOxS2LjJ1SjMV.ZQVcCNbev0BFtJ6gyoi7elCakCL0GtnNIWPAypW', 'Rodriguez', 'Rodriguez', '0752145265', 'louella.rodriguez@example.com', 'femme', 0, '2023-03-09 12:23:47');

-- --------------------------------------------------------

--
-- Structure de la table `note`
--

DROP TABLE IF EXISTS `note`;
CREATE TABLE IF NOT EXISTS `note` (
  `id_note` int NOT NULL AUTO_INCREMENT,
  `membre_id1` int DEFAULT NULL,
  `membre_id2` int DEFAULT NULL,
  `note` int NOT NULL,
  `avis` int NOT NULL,
  `date_enregistrement` datetime NOT NULL,
  PRIMARY KEY (`id_note`),
  UNIQUE KEY `membre_id1` (`membre_id1`),
  UNIQUE KEY `membre_id2` (`membre_id2`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `photo`
--

DROP TABLE IF EXISTS `photo`;
CREATE TABLE IF NOT EXISTS `photo` (
  `id_photo` int NOT NULL AUTO_INCREMENT,
  `photo1` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `photo2` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `photo3` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `photo4` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `photo5` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id_photo`)
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `photo`
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
(58, '6409060315612_voiture_blanc_1.jpg', '640906031595a_voiture_blanc_2.jpg', '6409060315bcb_voiture_blanc_3.jpg', '6409060315ebe_voiture_blanc_4.jpg', '640906031638a_voiture_blanc_princ.jpg');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `annonce`
--
ALTER TABLE `annonce`
  ADD CONSTRAINT `annonce_ibfk_1` FOREIGN KEY (`categorie_id`) REFERENCES `categorie` (`id_categorie`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `annonce_ibfk_2` FOREIGN KEY (`photo_id`) REFERENCES `photo` (`id_photo`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `annonce_ibfk_3` FOREIGN KEY (`membre_id`) REFERENCES `membre` (`id_membre`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `commentaire`
--
ALTER TABLE `commentaire`
  ADD CONSTRAINT `commentaire_ibfk_1` FOREIGN KEY (`membre_id`) REFERENCES `membre` (`id_membre`) ON DELETE SET NULL ON UPDATE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
