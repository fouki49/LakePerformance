-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3307
-- Généré le : lun. 20 fév. 2023 à 18:29
-- Version du serveur : 10.10.2-MariaDB
-- Version de PHP : 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `lakeperformancebd`
--

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `idCategorie` int(11) NOT NULL AUTO_INCREMENT,
  `categorie` varchar(25) NOT NULL,
  PRIMARY KEY (`idCategorie`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`idCategorie`, `categorie`) VALUES
(1, 'tout'),
(2, 'canoe'),
(3, 'kayak'),
(4, 'paddle');

-- --------------------------------------------------------

--
-- Structure de la table `messenger_messages`
--

DROP TABLE IF EXISTS `messenger_messages`;
CREATE TABLE IF NOT EXISTS `messenger_messages` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `body` longtext NOT NULL,
  `headers` longtext NOT NULL,
  `queue_name` varchar(190) NOT NULL,
  `created_at` datetime NOT NULL,
  `available_at` datetime NOT NULL,
  `delivered_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  KEY `IDX_75EA56E016BA31DB` (`delivered_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `produits`
--

DROP TABLE IF EXISTS `produits`;
CREATE TABLE IF NOT EXISTS `produits` (
  `idProduit` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(25) NOT NULL,
  `prix` double NOT NULL,
  `quantiteEnStock` int(11) DEFAULT NULL,
  `description` varchar(1000) NOT NULL,
  `imagePath` varchar(100) NOT NULL,
  PRIMARY KEY (`idProduit`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `produits`
--

INSERT INTO `produits` (`idProduit`, `nom`, `prix`, `quantiteEnStock`, `description`, `imagePath`) VALUES
(1, 'Cedar canoe', 2699.99, 5, 'This cedar lake canoe offers you maximum lightness during your portage. In addition, its wooden design will amaze enthusiasts who will see you crossing from lake to lake. It\'s a very good choice if you want to stay zen with a canoe that was made with the wood of the cedars in the forests around you.', 'canoe1.jpg'),
(2, 'Pine canoe', 2215.99, 6, 'The real wood grain is absolutely mesmerizing. You won\'t be able to help but admire the craftsmanship, the rich tones of the hand-joined cedar strips, and the clear finish that really showcases the artistry of this piece. This 16\' canoe will transport you like never before. Designed for pleasure and beauty, it\'s built to last a lifetime. You will lose yourself in the day, as it is spent on water for whatever activity you enjoy the most. This is how the lake, stream or river was always meant to be walked. A canoe that took 500 hours to build must be an experience like no other.', 'canoe2.jpg'),
(3, 'Carbon canoe', 1899.99, 3, 'When the return on every dollar spent, every paddle stroke made, and every kilometre covered, matters most there’s only one choice.\r\n\r\nThe Carbon Nahanni is like no other composite Asymm model out there. As with all of our canoes, the moulds that produce these amazing hulls are completely redesigned every few years to make marked performance gains.\r\n\r\nSturdy full size gunwales, stainless hardware and  a light weight combination of Carbon components and stunning Spanish Cedar Bright Work.\r\n\r\nThis expedition proven design is made to slice through rough water while the spray rail peels water away from the hull.\r\nWater that leaves others resting on shore waiting out the weather, is no challenge for the Nahanni.  If you want to make it to your campsite effortlessly or blow your neighbours out of the water at the regatta you need a Nahanni.\r\n\r\nCome in for test paddle and feel the difference.', 'canoe3.jpg'),
(4, 'Plastic canoe', 549.99, 10, 'A 3-seater canoe, Stable and efficient with a practical and versatile interior layout.\r\n\r\nBuilt in single layer PE (48kg). Also available in 3 PE layers (40 kg).\r\n\r\nthe JALTA is at ease in lakes and gentle rivers.', 'canoe4.jpg'),
(5, ' Inflatable canoe', 699.99, 7, 'The World\'s First Patented High Pressure All Drop Stitch Inflatable Travel Canoe has arrived!\r\n\r\nSay goodbye to heavy, unstable, tippy, nearly impossible to store and transport canoes! The Sea Eagle Inflatable TC16 fits in a small car trunk or closet with plenty of room to spare and sets up in under 10 minutes!\r\n\r\nThe TC16 has accomplished feats well beyond reach of traditional canoes. It is a completely buoyant and unsinkable canoe, easy to upright and re-enter from the water, 33% lighter than comparable canoes, has incredible primary and secondary stability (stable to stand in), bow/stern molds that slice through the water, full length flat planing surface area for additional speed, designed to create lift and reduce drag, entire hull waterline length enabling paddling speeds up to 5 mph, full length double chine system and removable rear skeg to enhance tracking and increase stability, three separate air chambers for additional safety and is rated for up to Class IV whitewater.', 'canoe5.jpg'),
(6, 'Fiberglass canoe', 612.99, 3, 'The Chestnut Canoe Company designed the Cronje to be a fast, reliable canoe for people who have a destination in mind. The design is rich in history and is a very able performer. Our reproduction of this venerable canoe retains both the paddling characteristics and the tradition of the original.\r\n\r\nThe Cronje is ideally suited to paddlers who want to challenge big, open water by covering distance with ease. Fast lines and excellent tracking make it a joy to use. Cargo capacity isn’t compromised for speed and the canoe handles well both with a load and empty. Its lower profile means less wind drag on the water and lower weight on the portage trail. The Cronje is most at home in landscapes with large open lakes like the famed Boundary Waters or Algonquin Park.', 'canoe6.webp'),
(7, 'Sea kayak', 2199.99, 3, 'Le Virgo est un kayak de mer compact mais sans compromis pour les guerriers du week-end, d\'une longueur qui offre une vitesse de coque suffisante pour les trajets courts à moyens tout en maintenant le poids du bateau au minimum, ce qui le rend plus facile à manipuler depuis le levage de la voiture, à travers un voyage plein d\'expériences uniques, jusqu\'à le remonter sur la voiture à la fin d\'une grande aventure.\r\n\r\nLa conception compacte et un rail de sculpture défini se combinent pour offrir une maniabilité réactive pour explorer des environnements côtiers variés, et une grande stabilité vous permet également de vous aventurer dans l\'inconnu en toute confiance.', 'kayak1.jpg'),
(8, 'Pelican Argo 100X Kayak', 424.99, 15, 'Enjoy a fun day on the water using the Pelican Argo 100X 10 ft Recreational Sit-in Kayak, which has moulded footrests and an adjustable Ergofoam™ padded backrest to help keep you comfortable as you paddle. The front storage hatch and rear tank well provide ample space for accessories, and a cockpit table has a built-in bottle holder for added convenience. The Ram-X™ material is lightweight and easy to transport just about anywhere.\r\nFeatures and Benefits', 'kayak2.jpeg'),
(9, 'Double inflatable kayak', 2183.49, 1, 'The Seawave is a convertible 1 to 3-seater sea kayak when used without decks, designed for coastal cruising and long-distance hiking. A major advantage: its tubular floor whose thicker central flange forms a keel which limits lateral drift. For family outings and the basic open version, its length - 50cm longer than a Solar - makes it a real 3-seater adult.', 'kayak3.jpg'),
(10, 'Fishing kayak', 616.52, 6, 'Historically, the kayak was invented for fishing and hunting by the Inuit. Quiet and ideal for observing nature, the fishing kayak allows a different approach, making previously unreachable areas accessible. Even if the fishing kayak is the founding father of the practice of kayaking, it has experienced a revival in recent years due to the appearance of new forms of boats specifically adapted to modern fishing.', 'kayak4.webp'),
(11, 'Malibu 11.5 - Ahi Kayak', 399, 2, 'Have a blast atop our Malibu solo series! It’s all about fun and comfort—and if you like to control your own destiny, we’ve got options. These compact, stackable, easy-to-paddle, agile solo kayaks will turn heads as you master the waves with ease on our super-stable 9.5’ and 11.5’ sit-on-top hull designs. Comfort comes easy on the Malibu, thanks to a newly designed AirGo™ molded-in seat and seat pad with an adjustable AirComfort™ backrest. No matter your size enjoy comfortable leg room with calf rests and molded-on foot wells. And don’t forget your beverages! The Malibu 9.5 comes equipped with three cup holders.', 'kayak5.jpg'),
(12, 'Inflatable kayak', 545.23, 0, 'The Hudson is for intermediate thrill seekers, whereas the Ottowa is for the pro\'s. Both are inflatable and can therefore fit easily in your car so you can travel to your destination with ease.\r\n\r\nThe deluxe waterproof sea kayak is available in two sizes; single kayak or double kayak. Both the single and tandem options are extremely durable and stable on water. Made with high-quality materials, ensuring longevity and elite performance.', 'imageNonDispo.png');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
