-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Feb 22, 2023 at 06:25 PM
-- Server version: 10.10.2-MariaDB
-- PHP Version: 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lakeperformancebd`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `idCategorie` int(11) NOT NULL AUTO_INCREMENT,
  `categorie` varchar(25) NOT NULL,
  PRIMARY KEY (`idCategorie`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`idCategorie`, `categorie`) VALUES
(1, 'tout'),
(2, 'canoe'),
(3, 'kayak'),
(4, 'paddle');

-- --------------------------------------------------------

--
-- Table structure for table `messenger_messages`
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
-- Table structure for table `produits`
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
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `produits`
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
(11, 'Malibu 11.5 - Ahi Kayak', 399.99, 2, 'Have a blast atop our Malibu solo series! It’s all about fun and comfort—and if you like to control your own destiny, we’ve got options. These compact, stackable, easy-to-paddle, agile solo kayaks will turn heads as you master the waves with ease on our super-stable 9.5’ and 11.5’ sit-on-top hull designs. Comfort comes easy on the Malibu, thanks to a newly designed AirGo™ molded-in seat and seat pad with an adjustable AirComfort™ backrest. No matter your size enjoy comfortable leg room with calf rests and molded-on foot wells. And don’t forget your beverages! The Malibu 9.5 comes equipped with three cup holders.', 'kayak5.jpg'),
(12, 'Inflatable kayak', 545.23, 0, 'The Hudson is for intermediate thrill seekers, whereas the Ottowa is for the pro\'s. Both are inflatable and can therefore fit easily in your car so you can travel to your destination with ease.\r\n\r\nThe deluxe waterproof sea kayak is available in two sizes; single kayak or double kayak. Both the single and tandem options are extremely durable and stable on water. Made with high-quality materials, ensuring longevity and elite performance.', 'imageNonDispo.png'),
(13, 'Rotational molded kayak', 999.99, 6, 'Canadian Coast Guard Approved, CE Certified, United States Coast Guard Approved.\r\n\r\nAbrasion Resistant, Ergonomic, Fade Resistant, UV Resistant', 'kayak6.jpg'),
(14, 'Blue North TORRENT Kayak', 680.15, 2, 'The 10 ft long  TORRENT is a single sit inside Kayak with recessed fishing rod holders, a hatch and a back storage compartment\r\n\r\nBlue North kayaks are chosen for their rugged construction and simplistic look, which is perfect for rentals and commercial use.\r\n\r\nSingle sit inside\r\nIncludes one hatch\r\nRecessed fishing rod holders\r\nStorage compartment on the back\r\nPadded seat optional\r\nLength: 10′\r\nWidth: 2.5′\r\nWeight: 44 lbs\r\nCapacity: 286 lbs\r\nAvailable in green, blue, yellow, and red.', 'kayak7.jpg'),
(15, 'Ottertail Paddle', 143.2, 5, 'As H&H’s longest paddle, the Ottertail is perfect for days spent traversing deep lakes. Our Ottertail design is well-balanced and very responsive thanks to the elongated spine throughout the blade. This makes it ideal for experienced stern or solo paddlers who enjoy a longer blade that pushes a lot of water. It is also a great choice for bow paddlers looking for a smooth, effortless cadence.\r\n\r\nSolid cherry wood construction with a hand rubbed oil finish.\r\n\r\nHandcrafted by Hunter & Harris in Ontario, Canada.', 'paddle1.jpg'),
(16, 'Beavertail Canoe Paddle', 165.2, 10, 'This beautiful, dual-wood canoe paddle may look like your grandfather’s paddle, but with layered construction and a protective rock guard, the Beavertail Paddle has more than classic good looks; it craves action.', 'paddle2.jpg'),
(17, 'NRS PTE Economy Paddle', 36.95, 20, 'Your best, most affordable choice for a recreational rafting and canoeing paddle. The 20″ x 7 3/4″ ABS blade provides ample surface area for a full-bodied, powerful stroke. The 1″ aluminum shaft provides durability and is fully sheathed in polyethylene for a comfortable grip.\r\n\r\nWeight (at 60″): 28 oz.\r\n\r\nAvailable Paddle Sizes: 48″, 54″, 57″ 60″, 66″', 'paddle3.jpg'),
(18, 'Double Bladed Paddle', 84.99, 4, 'A double-bladed kayak paddle for your paddle board that also works as a single bladed paddle', 'paddle4.png'),
(19, 'PAGAIE ELITE RACE ', 329.99, 2, 'The Elite Race fixed paddle from REDWOODPADDLE is rigid and dynamic with its round tube and 100% Carbon composition. This is our stiffest paddle. With its excellent performance, it is specially designed for sporty rides. You will not suffer any loss of energy, powerful and light it will be a real asset for the most competitors.\r\n\r\nFor use on sports rides, we advise you to have it cut between +20cm and +23cm in relation to your height. Blade width 17.7cm - length 45cm - area 534cm2 • Blade inclination: 10° • Rigidity index 8/10 • Weight (+/-6%): 615 g uncut.', 'paddle5.jpg'),
(20, 'Emergency Paddle', 29.99, 30, 'Telescopic Emergency Paddle\r\nIdeal for dinghies & liferafts. The paddle blade and palm grip are made of bright orange plastic to be easily visible.\r\n\r\nAnodised 22-25mm alloy shaft\r\nOnly 53cm long when collapsed\r\n2 position - extends to either 79cm or 107cm', 'paddle6.jpg');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
