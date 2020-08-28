-- phpMyAdmin SQL Dump
-- version 4.5.4.1
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Ven 28 Août 2020 à 08:49
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
  `id` int(11) NOT NULL,
  `numeroChapitre` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` longtext NOT NULL,
  `date` datetime NOT NULL,
  `slug` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `chapters`
--

INSERT INTO `chapters` (`id`, `numeroChapitre`, `title`, `content`, `date`, `slug`, `image`) VALUES
(1, 0, 'Voyage en raquettes', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum pellentesque, sapien in aliquam suscipit, enim ipsum tincidunt arcu, a aliquet sapien enim vel magna. Maecenas quis velit et est varius tincidunt eu in risus. Maecenas non rhoncus augue, non convallis turpis. Integer rhoncus ultricies lorem. Duis sit amet erat turpis. Pellentesque a risus pellentesque, sollicitudin dui ut, venenatis lacus. Praesent enim ipsum, euismod sit amet ultricies id, suscipit a sem.\r\n\r\nPraesent in nibh id ex fringilla faucibus. Curabitur sed vehicula nisi, semper imperdiet mauris. Phasellus in nunc orci. Vivamus ut dui ex. Proin mollis dolor id massa ultricies tempor. Nam quis tortor euismod, aliquet tortor non, porta velit. Vivamus semper euismod nunc, fermentum tempus felis vestibulum a. Suspendisse ac sem rutrum, condimentum lacus semper, interdum ipsum.', '2019-09-22 00:00:00', 'voyage-en-raquettes', 'randonnee-raquettes.jpg'),
(3, 1, 'Parc National', '&lt;p&gt;Phasellus in nunc orci. Vivamus ut dui ex. Proin mollis dolor id massa ultricies tempor. Nam quis tortor euismod, aliquet tortor non, porta velit. Vivamus semper euismod nunc, fermentum tempus felis vestibulum a. Suspendisse ac sem rutrum, condimentum lacus semper, interdum ipsum.vff DDDDDvg&lt;/p&gt;', '2020-07-26 18:26:02', 'parc-national', 'parc national.jpg'),
(4, 3, 'Le Climat', '&lt;p&gt;Lglfbf Phasellus in nunc AAAAAAA&lt;/p&gt;', '2020-08-25 09:19:13', 'le-climat', 'leclimat.jpg'),
(21, 12, 'vertu du froid en hiver', '&lt;p style=&quot;margin: 0px 0px 15px; padding: 0px; text-align: justify; font-family: &#039;Open Sans&#039;, Arial, sans-serif; font-size: 14px; background-color: #ffffff;&quot;&gt;Rutrum facilisis blandit. Duis pellentesque sollicitudin odio, sit amet mattis ligula. Donec auctor ipsum eget placerat pharetra. Nam neque arcu, scelerisque vestibulum metus a, semper euismod lacus. Suspendisse pharetra volutpat commodo. Aliquam rutrum dictum orci, et consectetur nulla. Donec vel arcu sit amet nulla finibus vulputate ac quis magna. Praesent eget quam quis risus convallis iaculis. In pretium leo eget tempor aliquam. Sed at interdum massa. Etiam metus augue, rhoncus eu pharetra eu, sagittis vitae libero.&lt;/p&gt;\r\n&lt;p style=&quot;margin: 0px 0px 15px; padding: 0px; text-align: justify; font-family: &#039;Open Sans&#039;, Arial, sans-serif; font-size: 14px; background-color: #ffffff;&quot;&gt;In sed consequat ipsum. Suspendisse congue dolor in nibh posuere imperdiet. Curabitur placerat dui ac arcu tincidunt, et lacinia elit dictum. In sed magna nulla. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nullam vitae odio finibus, gravida nulla vel, eleifend ligula. Etiam molestie congue metus, vel blandit est efficitur et. In hac habitasse platea dictumst. Suspendisse rhoncus aliquet efficitur. Phasellus dolor odio, rhoncus at urna eu, iaculis dictum eros. Morbi accumsan sit amet turpis vel dictum. Duis luctus odio metus, eu lacinia nisi ullamcorper vel. Nullam bibendum ligula justo, ut tristique sem rutrum in. Cras non mauris justo. Nulla sollicitudin augue mauris, eget placerat erat dictum vitae.&lt;/p&gt;', '2020-07-26 12:26:43', 'vertu-du-froid-en-hiver', 'froid.jpg'),
(57, 21, 'CF', '&lt;p&gt;cccxx&lt;/p&gt;', '2020-08-27 22:56:22', 'cf', ''),
(56, 3, 'FGGGFF', '&lt;p&gt;CVVVvvv&lt;/p&gt;', '2020-08-25 20:38:30', 'fgggff', ''),
(58, 88, 'DDDF', '&lt;p&gt;CCC&lt;/p&gt;', '2020-08-27 22:56:44', 'dddf', '');

-- --------------------------------------------------------

--
-- Structure de la table `comments`
--

CREATE TABLE `comments` (
  `ID` int(11) NOT NULL,
  `author` varchar(255) NOT NULL,
  `comment` text NOT NULL,
  `date` date NOT NULL,
  `idPost` int(11) NOT NULL,
  `state` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `comments`
--

INSERT INTO `comments` (`ID`, `author`, `comment`, `date`, `idPost`, `state`) VALUES
(1, 'Florence', 'entièrement d\'accord', '2019-02-04', 1, 1),
(2, 'Paul', 'Je trouve l\'article très bien', '2019-02-09', 1, 3),
(3, 'Jean luc', 'ah d\'accord...', '2020-02-13', 2, 1),
(4, 'Maude', 'je suis complètement d\'accord', '2020-02-18', 2, 3),
(5, 'Christophe', 'Vraiment très bien', '2020-03-18', 3, 1),
(7, 'Mathilde', 'J\'aime beaucoup cette région', '2020-03-18', 3, 3),
(8, 'Etienne', 'parfait j\'adore', '2020-02-13', 2, 1),
(11, 'Josiane ', 'Moi aussi', '2020-04-23', 19, 1),
(12, 'Hubert', 'Pas tout j&#039;aime le chocolat', '2020-04-23', 19, 1),
(13, 'virginie', 'bof', '2020-04-30', 29, 1),
(14, 'virginie', 'j&#039;aime bcp', '2020-04-30', 32, 0),
(18, 'ffgfgf', 'fvfvvfb', '2020-06-11', 21, 3),
(33, 'jacques', 'tr&egrave;s bien', '2020-06-11', 21, 0),
(37, 'Charlie', 'J&#039;aime bcp cette article', '2020-07-26', 20, 1),
(38, 'Bénédicte', 'Tr&egrave;s bon article', '2020-07-26', 3, 0),
(39, 'thierry', 'test', '2020-07-26', 3, 1),
(43, 'cf', 'ffff', '2020-08-17', 44, 1),
(45, 'CVCVVC', 'C C C CCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCC', '2020-08-17', 51, 1),
(46, 'ddd', 'ccc', '2020-08-24', 4, 2),
(48, '', '', '2020-08-25', 4, 0);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `nom` varchar(40) NOT NULL,
  `prenom` varchar(40) NOT NULL,
  `login` varchar(40) NOT NULL,
  `pass` varchar(64) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

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
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`ID`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;
--
-- AUTO_INCREMENT pour la table `comments`
--
ALTER TABLE `comments`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;
--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
