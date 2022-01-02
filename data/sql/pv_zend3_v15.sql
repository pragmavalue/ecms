-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Wersja serwera:               10.4.11-MariaDB - mariadb.org binary distribution
-- Serwer OS:                    Win64
-- HeidiSQL Wersja:              11.3.0.6295
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Zrzut struktury bazy danych ecms
CREATE DATABASE IF NOT EXISTS `ecms` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `ecms`;

-- Zrzut struktury tabela ecms.articles
CREATE TABLE IF NOT EXISTS `articles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(90) COLLATE utf8_polish_ci DEFAULT NULL,
  `naam` varchar(90) COLLATE utf8_polish_ci DEFAULT NULL,
  `content` mediumtext COLLATE utf8_polish_ci DEFAULT NULL,
  `navigation` int(11) DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `autor` varchar(50) COLLATE utf8_polish_ci DEFAULT NULL,
  `status` varchar(50) COLLATE utf8_polish_ci DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- Zrzucanie danych dla tabeli ecms.articles: ~3 rows (około)
/*!40000 ALTER TABLE `articles` DISABLE KEYS */;
REPLACE INTO `articles` (`id`, `title`, `naam`, `content`, `navigation`, `order`, `autor`, `status`, `date`) VALUES
	(1, 'Strona głowna', 'main', 'Witamy na stronie naszego, jeszcze nie ukończeonego, projektu w budowie (Będzińskie-Koło-Gospodarcze). Na początek będzie to spis firm z powiatu będzińskiego wraz z wizytówkami. Jeżeli projekt się rozwinie zostanie założone stowarzyszenie o w/w nazwie i wpisane do KRS.', 1, 1, 'Admin', '2', '2020-09-12 06:43:46'),
	(2, 'O mnie', 'zapas', 'MAMAMAMMAAM\r\n mamamamama\r\n', 2, 2, 'Admin', '2', '2021-07-18 09:39:14'),
	(3, 'Mój stack technologiczny', 'poboczna', 'Teoria (zainteresowania) do 2008\r\nteoria MES, algorytmy genetyczne, Fraktale, Falki (testy), RSA (szyfrowania), Blockchain (teoria).\r\nMogę o tym porozmawiać jednakże badań czy testów nie prowadzę.', 3, 3, 'mac the raver', '2', '2021-07-18 09:40:21');
/*!40000 ALTER TABLE `articles` ENABLE KEYS */;

-- Zrzut struktury tabela ecms.articles_tag
CREATE TABLE IF NOT EXISTS `articles_tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) DEFAULT NULL,
  `tag_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_key` (`post_id`,`tag_id`),
  KEY `post_id_key` (`post_id`),
  KEY `tag_id_key` (`tag_id`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8 COMMENT='utf8_general_ci';

-- Zrzucanie danych dla tabeli ecms.articles_tag: ~4 rows (około)
/*!40000 ALTER TABLE `articles_tag` DISABLE KEYS */;
REPLACE INTO `articles_tag` (`id`, `post_id`, `tag_id`) VALUES
	(32, 2, 24),
	(36, 2, 25),
	(33, 2, 26),
	(34, 3, 20),
	(35, 3, 22);
/*!40000 ALTER TABLE `articles_tag` ENABLE KEYS */;

-- Zrzut struktury tabela ecms.boxes
CREATE TABLE IF NOT EXISTS `boxes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Box1` text COLLATE utf8_polish_ci DEFAULT NULL,
  `Box2` text COLLATE utf8_polish_ci DEFAULT NULL,
  `Box3` text COLLATE utf8_polish_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- Zrzucanie danych dla tabeli ecms.boxes: ~2 rows (około)
/*!40000 ALTER TABLE `boxes` DISABLE KEYS */;
REPLACE INTO `boxes` (`id`, `Box1`, `Box2`, `Box3`) VALUES
	(1, 'mamamamama', 'wdewd3wdewd3ewd', 'ededecdxewxcrefvc4trgtrv'),
	(2, NULL, NULL, NULL);
/*!40000 ALTER TABLE `boxes` ENABLE KEYS */;

-- Zrzut struktury tabela ecms.comment
CREATE TABLE IF NOT EXISTS `comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL,
  `content` mediumtext CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `author` varchar(128) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `date_created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='utf8_general_ci';

-- Zrzucanie danych dla tabeli ecms.comment: ~4 rows (około)
/*!40000 ALTER TABLE `comment` DISABLE KEYS */;
REPLACE INTO `comment` (`id`, `post_id`, `content`, `author`, `date_created`) VALUES
	(1, 1, 'Ciekawy artykuł, trochę krótki, ale ciekawy', 'Gość', '2021-08-25 20:24:29'),
	(2, 1, 'Trochę nie aktualny, może w przyszłosci update', 'Admin', '0000-00-00 00:00:00'),
	(5, 1, 'ok', 'Gość', '2021-10-05 05:41:58'),
	(6, 2, 'rozwinąłbym ten temat, artykuł trochę nie spójny', 'Gość', '2021-10-05 07:34:38');
/*!40000 ALTER TABLE `comment` ENABLE KEYS */;

-- Zrzut struktury tabela ecms.counter
CREATE TABLE IF NOT EXISTS `counter` (
  `id` int(11) NOT NULL,
  `value` int(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- Zrzucanie danych dla tabeli ecms.counter: ~0 rows (około)
/*!40000 ALTER TABLE `counter` DISABLE KEYS */;
REPLACE INTO `counter` (`id`, `value`) VALUES
	(1, 1122);
/*!40000 ALTER TABLE `counter` ENABLE KEYS */;

-- Zrzut struktury tabela ecms.customers
CREATE TABLE IF NOT EXISTS `customers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(128) COLLATE utf8_polish_ci DEFAULT NULL,
  `full_name` varchar(512) COLLATE utf8_polish_ci DEFAULT NULL,
  `password` varchar(256) COLLATE utf8_polish_ci DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT NULL,
  `pwd_reset_token` varchar(256) COLLATE utf8_polish_ci DEFAULT NULL,
  `pwd_reset_token_creation_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- Zrzucanie danych dla tabeli ecms.customers: ~0 rows (około)
/*!40000 ALTER TABLE `customers` DISABLE KEYS */;
REPLACE INTO `customers` (`id`, `email`, `full_name`, `password`, `status`, `date_created`, `pwd_reset_token`, `pwd_reset_token_creation_date`) VALUES
	(1, 'bugs@pragmavalue.com', 'Admin', '$2y$10$97lgeDuRqixytbAdn3y3uu8FRKZjBwDJN9zqa2ZxTdN8i3JGt8Ae.', 1, '2021-08-23 13:49:50', NULL, NULL);
/*!40000 ALTER TABLE `customers` ENABLE KEYS */;

-- Zrzut struktury tabela ecms.permission
CREATE TABLE IF NOT EXISTS `permission` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) CHARACTER SET utf8 COLLATE utf8_polish_ci DEFAULT NULL,
  `description` varchar(1024) CHARACTER SET utf8 COLLATE utf8_polish_ci DEFAULT NULL,
  `date_created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

-- Zrzucanie danych dla tabeli ecms.permission: ~5 rows (około)
/*!40000 ALTER TABLE `permission` DISABLE KEYS */;
REPLACE INTO `permission` (`id`, `name`, `description`, `date_created`) VALUES
	(1, 'user.manage', 'Manage users', '2020-10-15 05:32:11'),
	(2, 'permission.manage', 'Manage permissions', '2020-10-15 05:32:11'),
	(3, 'role.manage', 'Manage roles', '2020-10-15 05:32:11'),
	(4, 'profile.any.view', 'View anyone\'s profile', '2020-10-15 05:32:11'),
	(5, 'profile.own.view', 'View own profile', '2020-10-15 05:32:11');
/*!40000 ALTER TABLE `permission` ENABLE KEYS */;

-- Zrzut struktury tabela ecms.post
CREATE TABLE IF NOT EXISTS `post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(512) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL DEFAULT '',
  `pict` varchar(50) NOT NULL DEFAULT 'blog/mini/brak.jpg',
  `content` mediumtext CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `autor` varchar(50) DEFAULT NULL,
  `status` int(11) NOT NULL,
  `date_created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COMMENT='utf8_general_ci';

-- Zrzucanie danych dla tabeli ecms.post: ~3 rows (około)
/*!40000 ALTER TABLE `post` DISABLE KEYS */;
REPLACE INTO `post` (`id`, `title`, `pict`, `content`, `autor`, `status`, `date_created`) VALUES
	(1, 'Alternatywne systemy operacyjne', 'haiku.jpg', 'Debian 9 – chyba najpopularniejszy Linux dla zaawansowanych, na nim oparty jest Ubuntu\r\n\r\nScientific Linux 7 GNoME – oprogramowanie na potrzeby CERN główne dla fizyków. Posiada bardzo dobrego firewall, który potrafi blokować nawet krypto waluty\r\n\r\nLinux CAE – Ostanie wydanie datowane na 2013 rok, zawiera dużo oprogramowania inżynierskiego, jednakże w większości są to programy, których napisanie zlecili profesorowie na różnych instytutach czy Uczelniach w ramach prac dyplomowych bądź zaliczeniowych.\r\n\r\nHaiku - Od jakiegoś czasu interesowałem się systemem operacyjnym HaikuOS jest to nieoficjalna kontynuacją BeOS\'a, projektu, który to został porzucony i zamknięty z różnych względów. HaikuOS jest próbą odtworzenia systemu BeOS za pomocą RE – inżynierii wstecznej (odwrotnej) oraz dodanie nowych funkcjonalności które powstały w świecie komputerów w ostatnim czasie.Podstawowym problem początkującego użytkownika jest fakt ze w miarę nową wersje HaikuOS otrzymujemy w postaci tzw. dystrybucji Nigthly. Na stronie haiku-os.org wciąż wisi release alfa-4 który, nijak to obrazuje poziom prac developerów nad tym systemem, a jest sporo nowości, głównie chodzi mi o HaikuDepot obsługujący tzw. Package Manager\'a, dzięki któremu mamy dostęp do większej ilości oprogramowania.UWAGA: Nie ma żadnych gwarancji że Nightly, nie uszkodzi ci komputera, robisz to na własną odpowiedzialność. Ten artykuł dedykowany jest dla średnio zaawansowanych użytkowników PCów, więc jeżeli nie jesteś pewien co robisz poproś kogoś z większym doświadczaniem o pomoc lub zrezygnuj z instalacji Haiku.', 'Admin', 2, '2018-04-11 13:01:00'),
	(2, 'Komputer kwantowy, mrzonka czy nadzieja dla przyszłości', 'kwant.jpg', 'Mechanika kwantowa spędza sen z powiek nie jednemu badaczowi, co gdyby szaloną XX wieczną teorie wykorzystać w budowie komputera. Czy komputer kwantowy wyprze stosowana dziś technologie? Moim zdaniem na obecnym etapie rozwoju cywilizacyjnego, nie. Ewentualnie pozwoli podejść do problemów w inny sposób niż wszechobecny 0/1 komputer o architekturze von Neumanna. Jest nadzieja dla problemów NP-trudnych i NP-zupełnych zwanych także, przez niektórych, problemami milenijnymi.\r\n\r\nW okolicach 2010 roku pojawił się komputer „kwantowy”, potrafiący liczyć coraz to większa ilość qubitów (stan kwantowy). Komputer ten wyprzedza obecne konstrukcje największej firmy komputerowej świata tej powstałej przed II wojną, która też próbuje swych sił w konstrukcji kwantowej. Natomiast dostawca najpopularniejszej wyszukiwarki w 2018 skonstruował 72 qubitowy procesor, dostarcza na niego open source\'owe oprogramowanie.\r\n\r\nProblemem w/w konstrukcji jest duża ilość błędów w obliczeniach, moim zdaniem spowodowane jest to brakiem interpolacji kwantowej. Można by zastosować krzywe, lecz moja wiedza na temat komputerów działających na wektorach lub krzywych jest w dużej mierze ograniczona (niedostępna). Przez ostatni okres czasu dowiedziałem że komputer wektorowy służy do przeszukiwania dużej ilości danych np. w procesie rozpoznawania twarzy czy odcisków palców, służą do tego celu specjalne algorytmy geometryczne.\r\n\r\nProblem „kwantowości” można rozpatrywać na wiele wymiarów (sposobów), gdzie nośnikiem informacji jest elektron, foton czy quark. Prędkość światła nie jest czymś nowym, ale potrzebnym medium do wyolbrzymienia „szybkosci” działania komputera. Niektórzy badacze widzą nadzieje w fotonie jako nośniku informacji, foton ma tą dobrą właściwość ze „szybko” znika, co wykorzystane jest w kryptografii kwantowej (światłowód).\r\n\r\nJednakże, trzeba zdać sobie sprawę ze napięcie (prąd), także ma prędkość porównywalną do prędkości światła i te 70 lat badań nad tranzystorem także przynosi współmierne efekty. Rozwój elektroniki, ciągła miniaturyzacja powoduje przełamywanie kolejnych barier.', 'Admin', 2, '2017-03-26 05:41:56'),
	(3, 'Pragmatyczny Model Matematyczny (eng. Pragmatic Model)', 'model.jpg', 'Model pragmatyczny (eng. Pragmatic Model)(~model uniwersalny)\r\njest to odpowiednio spreparowany abstrakcyjny model neuronowo-rozmyty osadzony w sandboxie.\r\n\r\nModel  z odpowiednimi ustawieniami powinien zastąpić\r\nmodel matematyczny - uogólniony model analityczny\r\nmodel biznesowy - głownie kalkulacja kosztów, być może ryzyka\r\nmodel heurystyczny - bot analityczno-lingwistyczny wykorzystujący nie konwencjonalne metody typu burza mózgów,\r\nwagi i rzut kostką (neuronowe), nazwa bota kartagina\r\nmodel logiczny - głownie techniki cyfrowe\r\nmodel predyktywny - Logika efektuacji to jest sposobem myślenia i działania typowym dla doświadczonych przedsiębiorców\r\n\r\nZastosowanie problemu optymalizacji (redukcji) modelu\r\n\r\nZauważyłem że na rynku pojawiły się firmy próbujące tworzyć własne modele głownie dotyczące ryzyka kredytowego. Oświadczam, że słowa (model pragmatyczny) tu zawarte zostały przez mnie wykoncypowane poprzez naukę i materiały ogólnie dostępne (internet), a złożone w całość w 2020 roku.', 'Admin', 2, '2020-10-12 06:35:09'),
	(4, 'Złamanie RSA, liczby pierwsze i zaprzyjaźnione', 'rsa.jpg', 'Zastosowanie liczb pierwszych do złamania szyfru RSA, pozwoliło zmniejszyć ilość obliczeń o 3/4.\r\nMetoda polega na wyliczaniu liczb pierwszych do pewnej spełnionej wartości. Bez podawania dokładnych liczb, zastosowano\r\nmetodę BRUTE FORCE, nie na zwykłych liczbach naturalnych tylko właśnie na liczbach pierwszych (wyliczonych wcześniej).\r\nIlość wystepowania (gęstość) liczb pierwszych powyżej liczby 30 mld jest w duzej mierze ograniczona, jedna liczba wystepuje co kilka milionów liczb,\r\ndlatego udało sie w 2008 roku złamać "tylko" a może aż RSA 768 Bit, tworząc prywatny klucz uniwersalny.\r\nTak, więc metoda łamania liczbami pierwszymi kodów jest już w dużej mierze wykorzystana do granic możliwości,\r\ndzięki temu wiemy ze RSA powyżej 1024 dalej pozostaje nie złamane, metodami sprytnymi, nie BRUTE FORCE.\r\nTa własność pozwala paradoksalnie na dalszy rozwój technologii blockchain, gdyż gwarantuje jej nie złamanie przez najbliższe lata.\r\nDlatego też jest możliwość kryptograficznego zabezpieczenia sztuki poprzez Tokieny NFT.\r\nAle wracając do tematu łamania kodów RSA, ludzkość z nadzieją patrzy na tzw. liczby zaprzyjaźnione, które \r\nhipotetycznie mogą pozwolić na dalsze odkrywanie szyfrów. Metoda jest podobna do ekstremów lokalnych, polega na lokalnym obliczaniu\r\nzbioru liczb "małych" i za pomocą przyjaźni (kolizji) liczb obliczanie mld części tej układanki. Jest jeden problem metoda ekstremum jest analogiczna z problemem Algorytmów Genetycznych, zastosowanych do łamania szyfrów. Moim zdaniem one nie nadają się do tego gdyż wykładniczo zwiększają liczbę obliczeń', 'Admin', 2, '2021-12-24 00:00:00');
/*!40000 ALTER TABLE `post` ENABLE KEYS */;

-- Zrzut struktury tabela ecms.post_tag
CREATE TABLE IF NOT EXISTS `post_tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) DEFAULT NULL,
  `tag_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `unique_key` (`post_id`,`tag_id`) USING BTREE,
  KEY `post_id_key` (`post_id`) USING BTREE,
  KEY `tag_id_key` (`tag_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='utf8_general_ci';

-- Zrzucanie danych dla tabeli ecms.post_tag: ~6 rows (około)
/*!40000 ALTER TABLE `post_tag` DISABLE KEYS */;
REPLACE INTO `post_tag` (`id`, `post_id`, `tag_id`) VALUES
	(49, 3, 27),
	(50, 3, 28),
	(51, 3, 29),
	(61, 4, 30),
	(62, 4, 31),
	(63, 4, 32);
/*!40000 ALTER TABLE `post_tag` ENABLE KEYS */;

-- Zrzut struktury tabela ecms.role
CREATE TABLE IF NOT EXISTS `role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `description` varchar(1024) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `date_created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

-- Zrzucanie danych dla tabeli ecms.role: ~2 rows (około)
/*!40000 ALTER TABLE `role` DISABLE KEYS */;
REPLACE INTO `role` (`id`, `name`, `description`, `date_created`) VALUES
	(1, 'Administrator', 'A person who manages users, roles, etc.', '2020-10-15 05:36:37'),
	(2, 'Guest', 'A person who can log in and view own profile.', '2020-10-15 05:36:37');
/*!40000 ALTER TABLE `role` ENABLE KEYS */;

-- Zrzut struktury tabela ecms.role_hierarchy
CREATE TABLE IF NOT EXISTS `role_hierarchy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_role_id` int(11) DEFAULT NULL,
  `child_role_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `role` (`parent_role_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Zrzucanie danych dla tabeli ecms.role_hierarchy: ~0 rows (około)
/*!40000 ALTER TABLE `role_hierarchy` DISABLE KEYS */;
/*!40000 ALTER TABLE `role_hierarchy` ENABLE KEYS */;

-- Zrzut struktury tabela ecms.role_permission
CREATE TABLE IF NOT EXISTS `role_permission` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) DEFAULT NULL,
  `permission_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `role` (`role_id`),
  KEY `permission` (`permission_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

-- Zrzucanie danych dla tabeli ecms.role_permission: ~5 rows (około)
/*!40000 ALTER TABLE `role_permission` DISABLE KEYS */;
REPLACE INTO `role_permission` (`id`, `role_id`, `permission_id`) VALUES
	(1, 1, 1),
	(2, 1, 2),
	(3, 1, 3),
	(4, 1, 4),
	(5, 2, 5);
/*!40000 ALTER TABLE `role_permission` ENABLE KEYS */;

-- Zrzut struktury tabela ecms.tag
CREATE TABLE IF NOT EXISTS `tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `naam` varchar(128) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_key` (`naam`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=257 DEFAULT CHARSET=utf8 COMMENT='utf8_general_ci';

-- Zrzucanie danych dla tabeli ecms.tag: ~13 rows (około)
/*!40000 ALTER TABLE `tag` DISABLE KEYS */;
REPLACE INTO `tag` (`id`, `naam`) VALUES
	(24, 'AWSB'),
	(32, 'Blockchain'),
	(23, 'komputer kwantowy'),
	(21, 'ktoś'),
	(31, 'liczby pierwsze'),
	(20, 'MES'),
	(27, 'MMD'),
	(29, 'Model'),
	(22, 'NP hard'),
	(25, 'PolŚl'),
	(28, 'Pragmatic'),
	(26, 'pvalue'),
	(30, 'RSA');
/*!40000 ALTER TABLE `tag` ENABLE KEYS */;

-- Zrzut struktury tabela ecms.user_role
CREATE TABLE IF NOT EXISTS `user_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

-- Zrzucanie danych dla tabeli ecms.user_role: ~0 rows (około)
/*!40000 ALTER TABLE `user_role` DISABLE KEYS */;
REPLACE INTO `user_role` (`id`, `user_id`, `role_id`) VALUES
	(1, 2, 1);
/*!40000 ALTER TABLE `user_role` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
