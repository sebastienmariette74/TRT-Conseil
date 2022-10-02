-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : dim. 02 oct. 2022 à 12:24
-- Version du serveur : 8.0.28
-- Version de PHP : 8.1.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `trt_conseil`
--

-- --------------------------------------------------------

--
-- Structure de la table `administrator`
--

DROP TABLE IF EXISTS `administrator`;
CREATE TABLE IF NOT EXISTS `administrator` (
  `id` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `administrator`
--

INSERT INTO `administrator` (`id`) VALUES
(14),
(21);

-- --------------------------------------------------------

--
-- Structure de la table `application`
--

DROP TABLE IF EXISTS `application`;
CREATE TABLE IF NOT EXISTS `application` (
  `job_offer_id` int NOT NULL,
  `candidate_id` int NOT NULL,
  `is_activated` tinyint(1) NOT NULL,
  `id` int NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  KEY `IDX_A45BDDC13481D195` (`job_offer_id`),
  KEY `IDX_A45BDDC191BD8781` (`candidate_id`)
) ENGINE=InnoDB AUTO_INCREMENT=66 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `application`
--

INSERT INTO `application` (`job_offer_id`, `candidate_id`, `is_activated`, `id`) VALUES
(17, 1, 1, 49),
(18, 1, 1, 50),
(19, 1, 1, 51),
(20, 1, 1, 52),
(14, 1, 1, 53),
(8, 2, 1, 54),
(2, 3, 1, 55),
(25, 3, 1, 56),
(26, 3, 1, 57),
(27, 3, 1, 58),
(28, 3, 1, 59),
(7, 7, 1, 60),
(13, 11, 1, 61),
(21, 11, 1, 62),
(23, 11, 1, 63),
(22, 11, 1, 64),
(24, 11, 1, 65);

-- --------------------------------------------------------

--
-- Structure de la table `candidate`
--

DROP TABLE IF EXISTS `candidate`;
CREATE TABLE IF NOT EXISTS `candidate` (
  `id` int NOT NULL,
  `firstname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lastname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cv` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `candidate`
--

INSERT INTO `candidate` (`id`, `firstname`, `lastname`, `cv`) VALUES
(1, 'jean', 'MICHEL', 'CV-SEBASTIEN-MARIETTE-DEV-633721cf6bd2a.pdf'),
(2, 'Jules', 'Machin', 'CV SEBASTIEN MARIETTE DEV.pdf'),
(3, 'Sylvie', 'DUPONT', 'CV SEBASTIEN MARIETTE DEV.pdf'),
(7, 'René', 'Nuphar', 'CV SEBASTIEN MARIETTE DEV.pdf'),
(11, 'Louis', 'Daure', 'CV SEBASTIEN MARIETTE DEV.pdf');

-- --------------------------------------------------------

--
-- Structure de la table `consultant`
--

DROP TABLE IF EXISTS `consultant`;
CREATE TABLE IF NOT EXISTS `consultant` (
  `id` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `consultant`
--

INSERT INTO `consultant` (`id`) VALUES
(5),
(8),
(20),
(22);

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

DROP TABLE IF EXISTS `doctrine_migration_versions`;
CREATE TABLE IF NOT EXISTS `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20220919102006', '2022-09-19 10:20:23', 2706),
('DoctrineMigrations\\Version20220919102325', '2022-09-19 10:23:32', 634),
('DoctrineMigrations\\Version20220919102739', '2022-09-19 10:27:43', 566),
('DoctrineMigrations\\Version20220919111411', '2022-09-19 13:04:57', 2206),
('DoctrineMigrations\\Version20220919130722', '2022-09-19 13:07:53', 1033),
('DoctrineMigrations\\Version20220921161657', '2022-09-21 16:17:10', 834),
('DoctrineMigrations\\Version20220921165917', '2022-09-21 16:59:22', 764),
('DoctrineMigrations\\Version20220922064402', '2022-09-22 06:44:14', 947),
('DoctrineMigrations\\Version20220924112821', '2022-09-24 11:28:38', 2350),
('DoctrineMigrations\\Version20220928064642', '2022-09-28 06:47:01', 6003);

-- --------------------------------------------------------

--
-- Structure de la table `job_offer`
--

DROP TABLE IF EXISTS `job_offer`;
CREATE TABLE IF NOT EXISTS `job_offer` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_activated` tinyint(1) NOT NULL,
  `recruiter_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_288A3A4E156BE243` (`recruiter_id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `job_offer`
--

INSERT INTO `job_offer` (`id`, `title`, `city`, `description`, `is_activated`, `recruiter_id`) VALUES
(2, 'Plongeur en restauration (H/F)', 'Annecy', '<div>Au sein d\'une équipe de plongeur, vous assurez la plonge d\'un établissement recevant des sportifs de haut niveau et organisant des évènements.&nbsp;<br>&nbsp;Le site n\'est pas accessible en transport en commun.</div>', 1, 4),
(7, 'Pâtissier (H/F)', 'Annecy', '<ul><li>Fabrication de viennoiseries et d\'autres produits en respectant le processus de fabrication,</li><li>Application des recettes,</li><li>Respect des normes d’hygiène et de sécurité au travail,</li><li>Entretient du poste de travail,</li><li>Gestion des stocks de matières premières, effectuer des commandes,</li></ul><div><br>&nbsp;<strong>Rémunération :&nbsp;</strong></div><ul><li>A déterminer</li></ul><div><strong>Le profil</strong></div><div>Vous avez une première expérience dans le domaine ?<br>&nbsp;Vous êtes une personne sérieuse et motivée ?<br>&nbsp;<br>&nbsp;Alors postulez !</div>', 1, 4),
(8, 'Femme de chambre/Valet (H/F)', 'Annecy', '<div>Vous réaliserez le nettoyage et état des lieux des Gîtes de la conciergerie après le départ des locataire.<br>&nbsp;<br>&nbsp;Vous suivrez la procédure de ménage mis en place par le client pour suivre les tâches a effectuer.<br>&nbsp;<br>&nbsp;Vous utiliserez votre véhicule afin de vous déplacer de gîtes en gîtes sur un trajet à réaliser avec des indemnité kilométrique.<br>&nbsp;<br>&nbsp;&nbsp;</div><div><strong>Le profil</strong></div><ul><li>Dynamique</li><li>Rigoureux</li><li>Organisé</li><li>Débutant accepté</li></ul><div>Travailler pour Manpower, c\'est également bénéficier de son <strong>comité d\'entreprise</strong> (cinéma, chèque vacances, location vacances...). Vous pouvez également placer vos <strong>Indemnités de Fin de Mission</strong> pour vous constituer une <strong>épargne </strong>tous les mois à un<strong> taux jusqu\'à 8%</strong>&nbsp;</div>', 1, 4),
(13, 'Serveur (H/F)', 'Annecy', '<div>Vous serez en charge d\'accueillir les clients et de réaliser leurs prises de commandes, tous en les conseillant sur les produits à la carte.&nbsp;<br>&nbsp;<br>&nbsp;Dynamisme et sens du contact sont des qualités requises pour ce poste&nbsp;<br><br></div><div><strong>Le profil<br></strong><br></div><div>Une formation de base dans le domaine de la restauration est appréciée pour ce poste, mais ce poste est aussi ouvert à des débutants ayant l\'envie de découvrir&nbsp; et s\'investir dans un nouveau métier.<br>&nbsp;<br>&nbsp;Ce poste vous correspond, alors n\'hésitez pas à postuler de suite !</div>', 1, 4),
(14, 'Cuisinier ou aide cuisinier (H/F)', 'Annecy', '<div>Sous la responsabilité du chef de cuisine il faudra préparer les repas chauds du midi ainsi que du soir (selon les semaines) tout en :</div><ul><li>Nettoyant votre poste de travail</li><li>Respecter les règles d’hygiène et de sécurité</li><li>Contrôler le bon fonctionnement du matériel de cuisine</li><li>Passer les commandes des denrées alimentaires&nbsp;</li><li>Aide au nettoyage de la cuisine</li></ul><div>​<br>&nbsp;35h/semaines lissé en rythme : une semaine que de midi et une semaine midi + soir.<br>&nbsp;1/2 week-end.<br>&nbsp;Intérim longue durée</div><div>Le profil</div><div>Titulaire d’un BEP/BAC dans le domaine de la restauration, vous bénéficiez d’une première expérience réussie dans le domaine.<br>&nbsp;<br>&nbsp;Vous avez à cœur de faire plaisir aux clients, vous êtes créatif, vous faites preuve d’adaptation et de professionnalisme.<br>&nbsp;<br>&nbsp;<strong>En bref, la recette du plaisir, c’est vous qui l’avez ?<br>&nbsp;Ce poste est fait pour vous !</strong></div>', 1, 6),
(17, 'Chef cuisinier ou cuisinier (H/F)', 'Annecy', '<div>Vous êtes passionnés par la cuisine : <strong>expérience en cuisine de collectivité ou cuisine traditionnelle,</strong> ce poste est fait pour vous alors ne tardez pas à postuler !</div><div>Les missions</div><div>&nbsp;<strong>&nbsp;Vous serez amener à :</strong><br> - Elaborer des produits<br> - Suivre les cuissons<br> - Faire l\'assemblage des aliments/plats<br> - Réaliser la présentation et le conditionnement des plats cuisinés<br> <br> <strong>Conditions de travail :</strong><br> Travail en équipe<br> Horaires du lundi au vendredi 6h30-14h00 avec 30 minutes (35H/semaine)<br> 70 couverts/service<br> Respect des règles d\'hygiène et de sécurité.<br> &nbsp;</div><div>Le profil</div><div>Nous recherchons<strong> un chef cuisinier H/F avec une expérience en cuisine traditionnelle et/ou collectivité</strong> de 1 an minimum. Nous attendons de vous que vous soyez <strong>sérieux, impliqué et motivé, sur le long terme</strong>.</div>', 1, 4),
(18, 'Cuisinier (H/F)', 'Nice', '<p>Fort d&#39;une 1&egrave;re exp&eacute;rience r&eacute;ussie en tant que cuisinier, vous serez charge&nbsp;de finaliser la pr&eacute;paration des repas dans le respect des r&egrave;gles d&#39;hygi&egrave;ne et des r&eacute;gimes et contraintes (mix&eacute;, mix&eacute; liss&eacute;, h&acirc;ch&eacute;...) en toute autonomie.<br />\r\n<br />\r\nVous travaillez seul sur ce poste en alternance avec un coll&egrave;gue.&nbsp;<br />\r\nVous travaillez sur la base de journ&eacute;e de 10h de 8h30 &agrave; 20h15 (avec une pause de 14h30 &agrave; 16h15) sur un rythme de 3 jours de travail - 2 jours de repos - 2 jours de travail - 3 jours de repos.&nbsp;<br />\r\n<br />\r\nSalaire selon grille.&nbsp;</p>\r\n\r\n<p>Le profil</p>\r\n\r\n<p>Sur ce poste, vos comp&eacute;tences en cuisine sont un pr&eacute;-requis.&nbsp;<br />\r\nVotre autonomie sera appr&eacute;ci&eacute;e. Elle vous permettra &eacute;galement d&#39;&eacute;voluer en toute s&eacute;r&eacute;nit&eacute;.&nbsp;</p>', 1, 9),
(19, 'Cuisinier (H/F)', 'Bordeaux', '<p><u>Rattach&eacute;(e) &agrave; la production, votre mission en tant que Cuisinier&nbsp; :&nbsp;</u></p>\r\n\r\n<ul>\r\n	<li>&nbsp;Approvisionner et pr&eacute;parer les ingr&eacute;dients n&eacute;cessaires &agrave; la recette.</li>\r\n	<li>Fabriquer des garnitures, jutages, sauces, cuisson des viandes et des l&eacute;gumes et toutes pr&eacute;parations culinaires dans le respect des &laquo;&nbsp;fiches recettes&nbsp;&raquo;.</li>\r\n	<li>Effectuer gr&acirc;ce &agrave; ses connaissances culinaires les contr&ocirc;les qualit&eacute; des produits (visuels, physiques, gustatives, &hellip;).</li>\r\n	<li>G&eacute;rer la fin d&rsquo;activit&eacute; de son poste, retours des mati&egrave;res non-utilis&eacute;es, compl&eacute;ter les documents de production, &hellip;</li>\r\n	<li>Travailler en &eacute;quipe et coordonner l&rsquo;activit&eacute; de commis de cuisine/op&eacute;rateurs cuisine.</li>\r\n</ul>\r\n\r\n<p>Le poste n&eacute;cessite une connaissance des bases de la cuisine mais aussi une capacit&eacute; d&rsquo;adaptation pour une fabrication &agrave; l&rsquo;&eacute;chelle industrielle.&nbsp;<br />\r\n<br />\r\n<strong><u>Sp&eacute;cifi&eacute; du poste&nbsp; :</u></strong></p>\r\n\r\n<ul>\r\n	<li>Travail en 2x8</li>\r\n</ul>\r\n\r\n<p><strong><u>Avantages&nbsp;:</u></strong></p>\r\n\r\n<ul>\r\n	<li>CSE (Comit&eacute; d&rsquo;entreprise)</li>\r\n	<li>Int&eacute;ressement</li>\r\n	<li>Participation</li>\r\n	<li>Primes variables (panier/tickets restaurant, heures de nuit, prime transport,&hellip;)</li>\r\n</ul>\r\n\r\n<p>Le profil</p>\r\n\r\n<p><strong>Vous partagez les valeurs :&nbsp;&nbsp;professionnalisme, diff&eacute;renciation, consid&eacute;ration et respect.</strong><br />\r\n<br />\r\nVous &ecirc;tes autonome, rigoureux, appr&eacute;ciez le travail en &eacute;quipe et souhaitez &eacute;voluer dans une entreprise &agrave; taille humaine.</p>\r\n\r\n<ul>\r\n	<li>Dipl&ocirc;me (CAP/BEP m&eacute;tiers de l&rsquo;alimentation) et/ou exp&eacute;rience significative en restauration traditionnelle ou collective</li>\r\n	<li>Ma&icirc;trise de l&rsquo;outil informatique est un plus</li>\r\n</ul>\r\n\r\n<p><strong>Comp&eacute;tences :</strong></p>\r\n\r\n<ul>\r\n	<li>Travail d&#39;&eacute;quipe</li>\r\n	<li>Autonomie</li>\r\n	<li>Informatique</li>\r\n</ul>\r\n\r\n<p>Cette offre vous int&eacute;resse&nbsp;? rejoignez-nous&nbsp;! Pour postuler, plusieurs solutions&nbsp;:<br />\r\n- T&eacute;l&eacute;charger gratuitement l&rsquo;application Manpower<br />\r\n- Rendez-vous sur Manpower.fr<br />\r\n- Pr&eacute;sentez-vous &agrave; l&rsquo;agence de Concarneau, ouverte du lundi&nbsp;au vendredi de 8h &agrave; 12h puis de 14h &agrave; 18h&nbsp;</p>', 1, 17),
(20, 'Cuisinier (H/F)', 'Paris', '<div>Sous la responsabilité du chef de cuisine ici il faut préparer les repas chauds du midi ainsi que du soir avec des produits frais, de saison et locaux, tout en :<br><br></div><ul><li>•Veillant au respect des différents régimes alimentaires des patients de l’entreprise en réalisant des recettes à l’aide de fiches techniques.</li><li>Nettoyant votre poste de travail / Respect des règles d’hygiène et de sécurité</li><li>Contrôlant le bon fonctionnement du matériel de cuisine</li><li>Passant les commandes des denrées alimentaires&nbsp;</li></ul><div>Le profil<br><br></div><div>Titulaire d’un BEP/BAC dans le domaine de la restauration, vous bénéficiez d’une expérience de 2 à 5 ans dans une structure qui aime prendre soins de ses patients.<br><br>Vous avez à cœur de faire plaisir aux résidents, vous êtes créatif, vous faites preuve d’adaptation et vous savez porter de petites attentions.<br><br>En bref, la recette du plaisir, c’est vous qui l’avez ?<br>Ce poste est fait pour vous !<br><br>Contrat : CDD<br>Salaire mensuel : 1890€Brut + 206 € Prime SEGUR = 2096€ Brut mensuel<br>Horaire : 3 jours par semaine<br>7h30 / 13h45 – 16h / 19h45<br>Deux dimanche par mois<br>Prise de poste : Immédiate<br><br></div>', 1, 19),
(21, 'Serveur (H/F)', 'Annecy', '<div>Vous serez en charge d\'accueillir les clients et de réaliser leurs prises de commandes, tous en les conseillant sur les produits à la carte.&nbsp;<br><br>Dynamisme et sens du contact sont des qualités requises pour ce poste&nbsp;&nbsp;<br><br></div><div>Le profil<br><br></div><div>Une formation de base dans le domaine de la restauration est appréciée pour ce poste, mais ce poste est aussi ouvert à des débutants ayant l\'envie de découvrir&nbsp; et s\'investir dans un nouveau métier.<br><br></div>', 1, 6),
(22, 'Serveur pour EXTRA (H/F)', 'Nice', '<div>En tant que serveur , <strong>vous serez chargé d\'effectuer différentes missions:</strong></div><ul><li>Prise de commande</li><li>Servir en table</li><li>Effectuer la mise en place des tables et les débarrasser</li><li>Accueillir la clientèle et les installer</li><li>Appliquer les règles d\'hygiène et de sécurité</li></ul><div>Le profil<br><br></div><div>Vous avez idéalement une expérience équivalente et/ou vous bénéficiez d\'une première expérience dans le domaine de la restauration?<br>Vous êtes <strong>TRES disponible</strong> pour des missions la semaine et le weekend.<br><br>Votre aisance relationnelle , votre discrétion et votre organisation seront de véritables atouts pour ce poste.<br>Vous êtes aimable, accueillant/e et avez le sens du contact client?!<br>​<br>N\'hésitez pas à postuler !!!</div>', 1, 9),
(23, 'Serveur (H/F)', 'Bordeaux', '<div><strong>En tant que serveuse, vous serez en charge d\'effectuer les missions suivantes :&nbsp;</strong></div><ul><li>Epluchage ;&nbsp;</li><li>Dresser les tables ;&nbsp;</li><li>Service ;&nbsp;</li><li>Nettoyer les salles ;&nbsp;</li><li>Autres...</li></ul><div>Le profil<br><br></div><div>Le restaurants comprend entre 35 et 50 couverts <br><br>Horaires : lundi et mardi : 9h30-15h/ mercredi et jeudi : 10h-15h/ vendredi : 9h30-16h<br><br>Vous avez de l\'expérience en tant que serveuse, commis de cuisine, autres...<br><br>Poste sur un 25h <br><br>Fermer le week-end, <br><br><strong>N\'hésitez plus, postulez !!</strong></div>', 1, 17),
(24, 'Serveur en restauration polyvalent (H/F)', 'Paris', '<div><strong>En tant que serveur, vous serez chargé d\'effectuer différentes missions :<br></strong><br></div><ul><li>Prise de commande</li><li>Servir en table</li><li>Effectuer la mise en place des tables et les débarrasser,</li><li>Accueillir la clientèle et les installer,</li><li>Effectuer le règlement,</li><li>Appliquer les règles d’hygiène et de sécurité.</li></ul><div>Le profil<br><br></div><div>Vous avez idéalement un BAC PRO / BTS Hôtellerie-Restauration ou une expérience équivalente et/ou vous bénéficiez d\'une première expérience dans le domaine de la restauration ?<br><br>Votre aisance relationnelle, votre discrétion et votre organisation seront de véritables atouts pour ce poste.&nbsp;<br><br>Vous êtes aimable, accueillant/e et avez le sens du contact client ?!<br><br></div>', 1, 19),
(25, 'Plongeur en restauration (H/F)', 'Annecy', '<div>Le <strong>plongeur</strong> assure le nettoyage de vaisselle (hormis la verrerie), le nettoyage des ustensiles de cuisine (plonge batterie), la propreté de la cuisine et l\'entretien des locaux.</div><div>Le profil<br><br></div><div>Vous avez une expérience dans ce domaine et une motivation d\'enfer !!<br><br>La rigueur, la capacité d\'être à l\'écoute, la réactivité, l\'organisation, l\'autonomie et la capacité de travailler en équipe font partie de vos exigences alors n\'hésitez plus.<br><br>Le client a besoin de vous sur des amplitudes horaires bien larges sur des vacations diverses tous les jours de la semaine, le week-end et les jours féries.<br><br>Quelles que soient vos disponibilités, nous aurons une mission à vous proposer !!</div>', 1, 6),
(26, 'Plongeur en restauration (H/F)', 'Nice', '<div><strong>En tant que plongeur en restauration, vous serez chargé d\'effectuer différentes missions :<br></strong><br></div><ul><li>Nettoyer la vaisselle&nbsp;</li><li>Entretenir le matériel de cuisine&nbsp;</li><li>Participer aux règles d\'hygiène et sécurité</li><li>Savoir utiliser les produits nettoyants</li><li>Rangement du matériel de cuisine</li></ul><div>Le profil<br><br></div><div>Vous possédez idéalement une première expérience réussie dans ce domaine ?!<br><br>Vous êtes respectueux(se) des règles de sécurité ?!<br><br>​Vous êtes reconnu(e) pour votre dynamisme, votre esprit d\'équipe, votre engagement et votre savoir-être.<br><br>​<strong>N\'hésitez plus, postulez !!<br></strong><br></div>', 1, 9),
(27, 'Plongeur en restauration collective (H/F)', 'Bordeaux', '<div>Bonjour ! Un plouf vous tente ? Le maillot on oublie, on prend le liquide vaisselle !<br><br>Vous serez en charge de réaliser la plonge des différents ustensiles de cuisine, de les ranger et les conditionner afin qu\'ils soient réutilisés. Mais vous aurez aussi en charge la vaisselle des couverts et des assiettes.<br>Le nettoyage du sol sera à votre charge également.<br>Tout cela en respectant les règles d\'hygiène qui vous seront indiquées et&nbsp; suivre les protocoles de nettoyage imposés.<br>Etudiants... bienvenus!<br><br>Horaires décalés / midi et soir<br>du lundi au dimanche avec 2 jours de congés en semaine</div><div>Le profil<br><br></div><div>Vous êtes déjà notre Talent !<br><br>Rigueur<br>Organisation<br>Esprit d\'équipe<br><br>Débutants acceptés !</div>', 1, 17),
(28, 'Plongeur en restauration (H/F)', 'Paris', '<div><em>Vous êtes intéressé/e par le secteur de la restauration ? Avec ou sans expérience cette mission est faite pour vous !! Postulez. </em><br><br>Sous l\'autorité du chef de cuisine ou du responsable de restaurant, et dans le respect des règles d\'hygiène et de sécurité, vous assurez le nettoyage et la désinfection des différents matériels et ustensiles utilisés en cuisine pour la fabrication et le service des repas.<br><br>Vous êtes également responsable de l\'entretien des locaux, appareils et installations de l\'atelier \"plonge\".<br><br></div><div>Le profil<br><br></div><div>Horaires : 7H00 14H40 du lundi au vendredi<br><br>Salaire : 11.07 euros bruts de l\'heure<br><br>Vous êtes véhiculé(e) pour vous rendre à Ternay car la zone est non desservie par les TCL<br><br>Le travail s\'effectue debout et en mouvement.<br>Vous êtes rapide, autonome et adaptable. Vous êtes rigoureux et aimez travailler en équipe. <br><br><strong>Ce poste vous intéresse ? Alors postulez directement à cette annonce avec un cv actualisé !<br></strong><br></div>', 1, 19);

-- --------------------------------------------------------

--
-- Structure de la table `recruiter`
--

DROP TABLE IF EXISTS `recruiter`;
CREATE TABLE IF NOT EXISTS `recruiter` (
  `id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zipcode` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `recruiter`
--

INSERT INTO `recruiter` (`id`, `name`, `address`, `zipcode`, `city`) VALUES
(4, 'Le Reste Aux Autres', '1 avenue Prince', '74000', 'ANNECY'),
(6, 'L\'Auberge In', '82 rue du Pinson', '74100', 'ANNECY'),
(9, 'le  resto bio', '15 rue du Pré', '06100', 'Nice'),
(17, 'Le Resto Rend Heureux', '26 rue de la Bastille', '33000', 'Bordeaux'),
(19, 'Le Grand Restaurant', '1 place de l\'église', '75000', 'PARIS'),
(54, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_verified` tinyint(1) NOT NULL,
  `is_activated` tinyint(1) NOT NULL,
  `reset_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `email`, `roles`, `password`, `type`, `is_verified`, `is_activated`, `reset_token`) VALUES
(1, 'candidat1@gmail.com', '[\"ROLE_CANDIDATE\"]', '$2y$13$BNBHyWLDSGvhlAK3CKY4puuvEu.rIpaAfu5gBd3Jmg5Ug5FwBM7bm', 'candidate', 1, 1, ''),
(2, 'candidat2@gmail.com', '[\"ROLE_CANDIDATE\"]', '$2y$13$HMnhIKAw9eR5SL4SuOeet.9qox528bkcIf9OwT2IzvOtTBkixkVtO', 'candidate', 1, 1, NULL),
(3, 'candidat3@gmail.com', '[\"ROLE_CANDIDATE\"]', '$2y$13$9UAKhuCbDCDDSyaZNnpeHOszJHvOzzkSslZ/4pA2vwXZ4sA.WHnti', 'candidate', 1, 1, NULL),
(4, 'recruteur1@gmail.com', '[\"ROLE_RECRUITER\"]', '$2y$13$nHPS7TVQoZBsHGISR20cPO1gGG2T0BSbevW9G1cOWugSilH0wTmKS', 'recruiter', 1, 1, NULL),
(5, 'consultant1@gmail.com', '[\"ROLE_CONSULTANT\"]', '$2y$13$m0tFmJ0AszgB440cDJLGn.g/UTVYODu9MZTGbC4gV2vdI/UWldRMC', 'consultant', 1, 1, ''),
(6, 'recruteur2@gmail.com', '[\"ROLE_RECRUITER\"]', '$2y$13$cCeUNtsj4jhVIxwFm5eSbevSmKlakkaZVKa.gy7UEFrciVe2wTxC2', 'recruiter', 1, 1, NULL),
(7, 'candidat4@gmail.com', '[\"ROLE_CANDIDATE\"]', '$2y$13$pvmUpwX30qJmjbxwjH7Q8eldRclt2WKyd7bo1cwz6mstvGke257Hq', 'candidate', 1, 1, NULL),
(8, 'consultant2@gmail.com', '[\"ROLE_CONSULTANT\"]', '$2y$13$EcxlFOP3hlhHPJYSAHP39e3NvaS0SNwJCOVLQovhUkmaBeYYYTf5y', 'consultant', 1, 1, NULL),
(9, 'recruteur3@gmail.com', '[\"ROLE_RECRUITER\"]', '$2y$13$3U2kvQuaTQrZcKw6apNQ..0X6kSmnpSBjtITuXhlEaI2/7FzysZOa', 'recruiter', 1, 1, NULL),
(11, 'candidat5@gmail.com', '[\"ROLE_CANDIDATE\"]', '$2y$13$updnwIjTCSRRqw.y.PZUGOakV6YoUKlLyyb5p3x.wk0rpPxcXNbny', 'candidate', 1, 1, NULL),
(14, 'admin2@gmail.com', '[\"ROLE_ADMIN\"]', '$2y$13$SgC0./4.gAS2a.lfkbnjIuDeIzlO9E5QXfvlHrz.WGTyQbT5PJjTm', 'administrator', 1, 1, NULL),
(17, 'recruteur4@gmail.com', '[\"ROLE_RECRUITER\"]', '$2y$13$GNOiqvMr20NVC5IR/5i6t.4uxNgmwT2yeMy6KPyFf8kCgnK2gf43q', 'recruiter', 1, 1, NULL),
(19, 'recruteur5@gmail.com', '[\"ROLE_RECRUITER\"]', '$2y$13$aBP2RpqxIay2rFEBKBdqLe4Jnvl30O6tSaS9H9D0jfgsKU4jgP81q', 'recruiter', 1, 1, NULL),
(20, 'consultant3@gmail.com', '{\"1\": \"ROLE_CONSULTANT\"}', '$2y$13$PvzKp1s/KD7pKHVkePMnveqESkSA.8.IVoz1yzB1MFHX9wNOW9RbK', 'consultant', 1, 1, NULL),
(21, 'admin@gmail.com', '{\"1\": \"ROLE_ADMIN\"}', '$2y$13$mnqtBYVfmsn9xeGsdhef2eMK9JtVzh76XUpXwOssWkF4jGmb3l5hu', 'administrator', 1, 1, NULL),
(22, 'consultant4@gmail.com', '{\"1\": \"ROLE_CONSULTANT\"}', '$2y$13$nPe.mvLkucYDaGo9S/RF/.rDjOMDFyi367V9ygveeXrqQoznwRz8C', 'consultant', 1, 1, NULL),
(54, 'recruteur6@gmail.com', '[\"ROLE_RECRUITER\"]', '$2y$13$8aUfNiH2bz6cZG5TaG01buDgz.8CjIvZFjwk/mkC3On2z405B3AXG', 'recruiter', 1, 1, NULL);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `administrator`
--
ALTER TABLE `administrator`
  ADD CONSTRAINT `FK_58DF0651BF396750` FOREIGN KEY (`id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `application`
--
ALTER TABLE `application`
  ADD CONSTRAINT `FK_A45BDDC13481D195` FOREIGN KEY (`job_offer_id`) REFERENCES `job_offer` (`id`),
  ADD CONSTRAINT `FK_A45BDDC191BD8781` FOREIGN KEY (`candidate_id`) REFERENCES `candidate` (`id`);

--
-- Contraintes pour la table `candidate`
--
ALTER TABLE `candidate`
  ADD CONSTRAINT `FK_C8B28E44BF396750` FOREIGN KEY (`id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `consultant`
--
ALTER TABLE `consultant`
  ADD CONSTRAINT `FK_441282A1BF396750` FOREIGN KEY (`id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `job_offer`
--
ALTER TABLE `job_offer`
  ADD CONSTRAINT `FK_288A3A4E156BE243` FOREIGN KEY (`recruiter_id`) REFERENCES `recruiter` (`id`);

--
-- Contraintes pour la table `recruiter`
--
ALTER TABLE `recruiter`
  ADD CONSTRAINT `FK_DE8633D8BF396750` FOREIGN KEY (`id`) REFERENCES `user` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
