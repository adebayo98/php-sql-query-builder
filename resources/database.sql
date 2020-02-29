# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Hôte: 62.210.16.27 (MySQL 5.7.17-log)
# Base de données: le-reseau
# Temps de génération: 2020-02-29 21:11:29 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Affichage de la table address
# ------------------------------------------------------------

DROP TABLE IF EXISTS `address`;

CREATE TABLE `address` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `continent` varchar(100) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `street` varchar(100) DEFAULT NULL,
  `zip_code` varchar(50) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `address` WRITE;
/*!40000 ALTER TABLE `address` DISABLE KEYS */;

INSERT INTO `address` (`id`, `continent`, `country`, `city`, `street`, `zip_code`, `user_id`)
VALUES
	(1,'europe','france','paris','4 rue sainte marthe','75011',1),
	(2,'europe','france','montreuil','27 Bis Rue du Progrès','93100',2),
	(3,'europe','france','montreuil','27 Bis Rue du Progrès','93100',3);

/*!40000 ALTER TABLE `address` ENABLE KEYS */;
UNLOCK TABLES;


# Affichage de la table article
# ------------------------------------------------------------

DROP TABLE IF EXISTS `article`;

CREATE TABLE `article` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `content` text,
  `user_id` int(11) DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `article` WRITE;
/*!40000 ALTER TABLE `article` DISABLE KEYS */;

INSERT INTO `article` (`id`, `title`, `content`, `user_id`, `created_at`, `updated_at`)
VALUES
	(1,'Qui veut être mon associé, l\'émission qui va doper l\'entrepreneuriat... et l\'investissement ?','Pari gagnant pour M6 qui souhaitait démocratiser l\'entrepreneuriat avec un concept résolument original. Qui veut être mon associé a contribué à donner une image positive des entrepreneurs mais aussi des investisseurs.',1,'2020-02-06','2020-02-06'),
	(2,'Ethique alimentaire : quand le \"bien manger\" change de définition','Au début des années 90, lorsque l’on demandait au grand public ce que représentait pour eux la notion de « bien manger », la grande majorité des réponses étaient liées à la satiété, au plaisir du ventre, au goût, et au plaisir du repas partagé, en famille et entre amis. Près de trente ans plus tard, les attentes ont complètement évoluées, les consommateurs veulent des aliments sains, frais, et bons pour la santé… mais pas que.',1,'2020-02-06','2020-02-06'),
	(3,'Manque de dynamisme dans les levées françaises, 80 millions d’euros seulement','Chaque semaine, Maddyness dresse le bilan des levées de fonds de la semaine qui vient de s’écouler. Cette semaine, 16 opérations ont permis aux startups françaises de lever tout juste 79,9 millions d’euros.',2,'2020-02-06','2020-02-06'),
	(4,'4 startups à découvrir : Edmond, Beesbusy, Comm’une opportunité et Tessan','Saviez-vous qu’il n’est pas possible pour une agence immobilère de recevoir ses honoraires avant que le notaire ne signe l’acte de vente ? Et cette signature n’arrive bien souvent pas avant deux à trois mois après le compromis de vente. Cette situation peut rendre très délicate la gestion de trésorerie des agences immobilières.',2,'2020-02-06','2020-02-06'),
	(5,'SXSW : Business France dévoile les 17 pépites qui l’accompagneront à Austin','Présenter la vision de l’industrie culturelle française\nPour soutenir et faire rayonner l’expertise et les idées françaises, Business France, agence nationale dédiée à l’internationalisation des entreprises, a choisi d’embarquer avec elle 17 startups pour les présenter sur le sol américain. Pour cette septième année, ses choix se sont focalisés sur « le caractère innovant des services ou des produits et la capacité des entreprises à utiliser l’événement comme tremplin » , indique l’agence. ',1,'2020-02-06','2020-02-06'),
	(6,'Grab, futur géant multi-sectoriel ?','Pour devenir « l’application de tous les jours« , Grab a annoncé mardi 25 février 2020 lever 850 millions de dollars auprès des investisseurs japonais Mitsubishi UFJ Financial Group (MUFG) et TIS. La start-up, qui a commencé en lançant des services de mobilité pour les personnes (VTC, covoiturage, taxi, moto-taxi) et de livraisons à domicile en Asie du Sud-Est, s’est diversifiée dans les services financiers.',3,'2020-02-06','2020-02-06'),
	(7,'3 informations pour bien commencer la journée : la Green Management School, les data et l’Expérience Lab','Audrey Pulvar, ancienne journaliste et ex-présidente de la fondation Nicolas Hulot, se lance dans l’éducation en ouvrant la Green Management School, une nouvelle branche de la Médiaschool. Cette école privée de l’enseignement supérieur offrait déjà une formation aux métiers de la communication, du numérique et des médias. La Green Management School sera accessible aux étudiants se trouvant dans un cycle équivalant à une première ou deuxième année de master. ',3,'2020-02-06','2020-02-06'),
	(8,'6 conseils pour passer de salarié à freelance sereinement','Cette diversité des compétences est applicable à tous les secteurs. Si vous tapez « RH » sur Malt, vous verrez que vous pouvez trouver des experts en paie, des « Head of talent », des « Coachs professionnels », des « responsables administratifs » avec des durées de missions et des rémunérations extrêmement variables.',1,'2020-02-06','2020-02-06'),
	(9,'Cinq offres d’emploi chez : Ocus, Autobonplan, Wibilong, Tiptoque et Mounki','Le pitch : Wibilong met à la disposition des entreprises une plateforme SaaS qui permet la création et l’activation rapide de communautés de consommateurs directement sollicitables depuis les fiches articles des produits/services. Wibilong remet l’expérience consommateur au centre de la stratégie marketing des entreprises et transforme des clients en prescripteurs.30 collectivités locales partenaires.',1,'2020-02-06','2020-02-06'),
	(10,'Différentiation, expérience client, tech… quels défis pour l’assurance en 2020 ?','Face à la mutation de l’écosystème assurantiel, l’année qui débute poussera les acteurs à poursuivre leur transformation et à continuer à se réinventer. Dans un contexte économique marqué par la baisse des taux, les enjeux majeurs concerneront la recherche de relais de croissance, la différentiation et l’expérience client. Les nouveaux usages de consommation des produits d’assurance couplés à la connaissance fine des clients sera le point de départ des évolutions pour adapter les offres, les services et la relation client.',2,'2020-02-06','2020-02-06'),
	(11,'Donnez du sens à votre stratégie de contenus…','Maddyness Studio éditorialise votre discours et produit des contenus singuliers, diffusés en marque blanche sur vos propres plateformes ou embarqués sur les canaux de Maddyness.\n\nNous possédons une expertise et une connaissance fine des médias autant que des formats optimums pour maximiser l’impact de votre message. Nous combinons le savoir-faire de notre équipe à la puissance de notre réseau, il ne manque plus que vous.',2,'2020-02-06','2020-02-06'),
	(12,'… avec des formats percutants et sur-mesure','Que ce soit via des vidéos, infographies, articles ou des livres blancs, Maddyness Studio vous accompagne dans la production de contenus en marque blanche et/ou embarqués faits pour répondre à vos objectifs.\n\nAvec plus de 10 millions de vues cumulées sur nos vidéos, plus de 800 articles produits en marque blanche et plus de 70 infographies réalisées, notre équipe de brand journalists, de vidéastes, de graphistes et de consultants conçoivent des formats sur-mesure pour porter le meilleur message auprès de votre audience.',3,'2020-02-06','2020-02-06'),
	(13,'Pourquoi le perfectionnisme est l’ennemi de la productivité','Vous travaillez sans cesse ? Ne faites aucune pause ? Vous n\'arrêtez pas de travailler une fois chez vous, refaites les présentations que d\'autres ont fait pour vous, vous vous documentez sans cesse ? Vous trouvez toute information importante, et ne savez pas aller à l’essentiel ? Attention au perfectionnisme qui peut mener au burnout !',1,'2020-02-06','2020-02-06'),
	(14,'La méritocratie n’existe pas, et croire l’inverse vous desservira','La méritocratie est devenue un idéal social de premier plan. Les politiques de tous bords répètent à qui veut l’entendre que les récompenses de la vie – admission à l’université, travail, argent, pouvoir – devraient être réparties en fonction des compétences et des efforts. La métaphore la plus courante est celle d’un « terrain de jeu équitable » où les joueurs pourraient se hisser à la position qui correspond à leur mérite. D’un point de vue conceptuel et moral, la méritocratie est présentée comme l’opposée de systèmes tels que l’aristocratie héréditaire, dans laquelle la position sociale d’un individu est déterminée par la loterie de la naissance. Dans un monde méritocratique, la richesse et les avantages constituent une rémunération de l’effort, et non une aubaine provenant d’événements extérieurs.',3,'2020-02-06','2020-02-06'),
	(15,'Futures startuppeuses : votre guide de survie dans la jungle de l’entrepreneuriat','Fondatrice de la plateforme Kazoart, Mathilde Le Roy partage son expérience, ses erreurs et ses bonnes pratiques pour survivre à l\'entrepreneuriat quand on est une femme. Et même mieux : réussir et créer une entreprise saine et prospère !',1,'2020-02-06','2020-02-06'),
	(16,'Le développement personnel : allié de l’entrepreneur·e','Le développement personnel a le vent en poupe. Et tandis qu’il suscite autant d’adeptes que de critiques acharnés, il occupe une place primordiale dans les projets entrepreneuriaux. Au-delà d’être un effet de mode, allier entrepreneuriat et amélioration de soi est indispensable à la réussite.\n',1,'2020-02-06','2020-02-06'),
	(17,'Pourquoi le développement personnel est une puissante ressource pour entreprendre','La plupart des entrepreneur·e·s passent d’abord par la case « salariat »  avant d’envisager de devenir chefs d’entreprise. La passerelle entre les deux demande un changement mental car on passe d’un statut d’exécutant dirigé par sa hiérarchie à un travail où – bien souvent les premiers temps – on est tant le créateur et le responsable du projet que l’exécutant.\n',2,'2020-02-06','2020-02-06');

/*!40000 ALTER TABLE `article` ENABLE KEYS */;
UNLOCK TABLES;


# Affichage de la table comment
# ------------------------------------------------------------

DROP TABLE IF EXISTS `comment`;

CREATE TABLE `comment` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `content` text,
  `article_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `article_id` (`article_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `comment` WRITE;
/*!40000 ALTER TABLE `comment` DISABLE KEYS */;

INSERT INTO `comment` (`id`, `content`, `article_id`, `user_id`, `created_at`, `updated_at`)
VALUES
	(1,'Le Lorem Ipsum est simplement du faux texte employé dans la composition et la mise en page avant impression.',1,1,'2020-02-26','2020-02-26'),
	(2,'Il a été popularisé dans les années 1960 grâce à la vente de feuilles Letraset contenant des passages du Lorem Ipsum.',1,2,'2020-02-26','2020-02-26'),
	(3,'On sait depuis longtemps que travailler avec du texte lisible et contenant du sens est source de distractions.',2,1,'2020-02-26','2020-02-26'),
	(4,'On sait depuis longtemps que travailler avec du texte lisible et contenant du sens est source de distractions.',2,1,'2020-02-26','2020-02-26');

/*!40000 ALTER TABLE `comment` ENABLE KEYS */;
UNLOCK TABLES;


# Affichage de la table like
# ------------------------------------------------------------

DROP TABLE IF EXISTS `like`;

CREATE TABLE `like` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `type` int(11) DEFAULT '1',
  `post_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `post_id` (`post_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `like` WRITE;
/*!40000 ALTER TABLE `like` DISABLE KEYS */;

INSERT INTO `like` (`id`, `type`, `post_id`)
VALUES
	(1,1,1);

/*!40000 ALTER TABLE `like` ENABLE KEYS */;
UNLOCK TABLES;


# Affichage de la table user
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `last_name` varchar(50) DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;

INSERT INTO `user` (`id`, `last_name`, `first_name`, `email`, `password`, `created_at`, `updated_at`)
VALUES
	(1,'HOUNTONDJI','Adebayo','hountondjigodwill@gmail.com','password','2020-02-06','2020-02-06'),
	(2,'VILDINA','Dimitri','Dimitri.vildina@gmail.com','password','2020-02-06','2020-02-06'),
	(3,'MOUETTE','Amandine','amandine.mouette@hetic.net','password','2020-02-06','2020-02-06');

/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
