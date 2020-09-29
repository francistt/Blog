-- phpMyAdmin SQL Dump
-- version 4.5.4.1
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Mar 29 Septembre 2020 à 08:04
-- Version du serveur :  5.7.11
-- Version de PHP :  7.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `blog`
--

-- --------------------------------------------------------

--
-- Structure de la table `chapters`
--

CREATE TABLE `chapters` (
  `id` int(11) UNSIGNED NOT NULL,
  `numeroChapitre` int(11) NOT NULL,
  `title` varchar(255) CHARACTER SET latin1 NOT NULL,
  `content` longtext CHARACTER SET latin1 NOT NULL,
  `date` datetime NOT NULL,
  `slug` varchar(255) CHARACTER SET latin1 NOT NULL,
  `image` varchar(255) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `chapters`
--

INSERT INTO `chapters` (`id`, `numeroChapitre`, `title`, `content`, `date`, `slug`, `image`) VALUES
(1, 2, 'Voyage en raquettes', '&lt;p&gt;LoremvUU ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum pellentesque, sapien in aliquam suscipit, enim ipsum tincidunt arcu, a aliquet sapien enim vel magna. Maecenas quis velit et est varius tincidunt eu in risus. Maecenas non rhoncus augue, non convallis turpis. Integer rhoncus ultricies lorem. Duis sit amet erat turpis. Pellentesque a risus pellentesque, sollicitudin dui ut, venenatis lacus. Praesent enim ipsum, euismod sit amet ultricies id, suscipit a sem. Praesent in nibh id ex fringilla faucibus. Curabitur sed vehicula nisi, semper imperdiet mauris. Phasellus in nunc orci. Vivamus ut dui ex. Proin mollis dolor id massa ultricies tempor. Nam quis tortor euismod, aliquet tortor non, porta velit. Vivamus semper euismod nunc, fermentum tempus felis vestibulum a. Suspendisse ac sem rutrum, condimentum lacus semper, interdum ipsum.&lt;/p&gt;', '2020-09-26 12:18:25', 'voyage-en-raquettes', 'randonnee-raquettes.jpg'),
(3, 1, 'Parc National', '&lt;p&gt;Phasellus DDin nunc orci. Vivamus ut dui ex. Proin mollis dolor id massa ultricies tempor. Nam quis tortor euismod, aliquet tortor non, porta velit. Vivamus semper euismod nunc, fermentum tempus felis vestibulum a. Suspendisse ac sem rutrum, condimenvvvtum lacus semper, interdum ipsum.vff DDDDDvg&lt;/p&gt;', '2020-09-26 11:53:50', 'parc-national', 'parc national.jpg'),
(21, 3, 'vertu du froid en hiver', '&lt;p style=&quot;margin: 0px 0px 15px; padding: 0px; text-align: justify; font-family: &#039;Open Sans&#039;, Arial, sans-serif; font-size: 14px; background-color: #ffffff;&quot;&gt;Rutrum facilisis blandit. Duis pellentesque sollicitudin odio, sit amet mattis ligula. Donec auctor ipsum eget placerat pharetra. Nam neque arcu, scelerisque vestibulum metus a, semper euismod lacus. Suspendisse pharetra volutpat commodo. Aliquam rutrum dictum orci, et consectetur nulla. Donec vel arcu sit amet nulla finibus vulputate ac quis magna. Praesent eget quam quis risus convallis iaculis. In pretium leo eget tempor aliquam. Sed at interdum massa. Etiam metus augue, rhoncus eu pharetra eu, sagittis vitae libero.&lt;/p&gt;\r\n&lt;p style=&quot;margin: 0px 0px 15px; padding: 0px; text-align: justify; font-family: &#039;Open Sans&#039;, Arial, sans-serif; font-size: 14px; background-color: #ffffff;&quot;&gt;In sed consequat ipsum. Suspendisse congue dolor in nibh posuere imperdiet. Curabitur placerat dui ac arcu tincidunt, et lacinia elit dictum. In sed magna nulla. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nullam vitae odio finibus, gravida nulla vel, eleifend ligula. Etiam molestie congue metus, vel blandit est efficitur et. In hac habitasse platea dictumst. Suspendisse rhoncus aliquet efficitur. Phasellus dolor odio, rhoncus at urna eu, iaculis dictum eros. Morbi accumsan sit amet turpis vel dictum. Duis luctus odio metus, eu lacinia nisi ullamcorper vel. Nullam bibendum ligula justo, ut tristique sem rutrum in. Cras non mauris justo. Nulla sollicitudin augue mauris, eget placerat erat dictum vitae.&lt;/p&gt;', '2020-07-26 12:26:43', 'vertu-du-froid-en-hiver', 'froid.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `comments`
--

CREATE TABLE `comments` (
  `ID` int(11) UNSIGNED NOT NULL,
  `author` varchar(255) NOT NULL,
  `comment` text NOT NULL,
  `date` date NOT NULL,
  `idPost` int(11) UNSIGNED NOT NULL,
  `state` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `comments`
--

INSERT INTO `comments` (`ID`, `author`, `comment`, `date`, `idPost`, `state`) VALUES
(55, 'virginie', 'j aime', '2020-08-28', 3, 1),
(60, 'XD', 'CCC\r\nC\r\n\r\nCCCC', '2020-08-28', 3, 1),
(87, 'Josiane ', 'je\r\n\r\nsuis\r\n\r\n\r\nbien', '2020-08-28', 3, 1),
(88, 'ffgfgf', 'ccc\r\n\r\nxcc', '2020-08-28', 3, 1),
(89, 'Hubert', 'ccc\r\n\r\nvvv\r\n\r\n\r\nbbb', '2020-08-28', 3, 1),
(90, 'francis', 'je\r\n\r\nsuis \r\n\r\nbon', '2020-08-28', 3, 1),
(96, 'eric', 'dfbfbfb\r\n\r\nddggdd', '2020-08-30', 3, 1),
(97, 'faustine', 'test \r\n\r\n\r\ntest   et encore', '2020-08-30', 3, 2),
(98, 'voila', '&lt;h5&gt;voila&lt;/h5&gt;', '2020-09-17', 1, 1),
(99, 'gérald', '&lt;h1&gt; voila&lt;/h1&gt;', '2020-09-22', 1, 1),
(100, 'virginie', '&lt;h1&gt;voila et pourquoi&lt;/h1&gt;', '2020-09-22', 1, 1),
(101, 'fred', '&lt;h1&gt;test&lt;/h1&gt;', '2020-09-25', 1, 1),
(102, 'sss', '&lt;h1 style=&quot;color:red;&quot;&gt;&lt;u&gt;test&lt;/u&gt;&lt;/h1&gt;', '2020-09-25', 1, 1),
(107, 'JOSé', '&lt;h1 style=&quot;color:red;&quot;&gt;&lt;u&gt;test 2&lt;/u&gt;&lt;/h1&gt;', '2020-09-26', 1, 1),
(108, 'ddd', 'cc', '2020-09-26', 1, 1),
(110, 'ffff', 'http://localhost/xss.php?keyword=&lt;script&gt;alert(&quot;Coucou tu veux voir ma&hellip; faille XSS ?&quot;);&lt;/script&gt;', '2020-09-29', 1, 1),
(113, 'hrhtht', 'http://localhost/xss.php?keyword=&#60;script&#62;alert(&#34;test test&#34;);&#60;/script&#62;', '2020-09-29', 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `nom` varchar(40) CHARACTER SET latin1 NOT NULL,
  `prenom` varchar(40) CHARACTER SET latin1 NOT NULL,
  `login` varchar(40) CHARACTER SET latin1 NOT NULL,
  `pass` varchar(64) CHARACTER SET latin1 NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`id`, `date`, `nom`, `prenom`, `login`, `pass`) VALUES
(1, '2020-08-17 17:43:46', 'T', 'Francis', 'francis', 'a028ff5a6905082ce3c94f4da153e6a27e11975bc6bb7202b575ccd63e24760f');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `chapters`
--
ALTER TABLE `chapters`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `numeroChapitre` (`numeroChapitre`);

--
-- Index pour la table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `state` (`state`),
  ADD KEY `idPost` (`idPost`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `chapters`
--
ALTER TABLE `chapters`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT pour la table `comments`
--
ALTER TABLE `comments`
  MODIFY `ID` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=114;
--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`idPost`) REFERENCES `chapters` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
