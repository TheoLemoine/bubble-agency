-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le :  jeu. 28 mars 2019 à 14:07
-- Version du serveur :  10.1.37-MariaDB-1~jessie
-- Version de PHP :  5.6.39-0+deb8u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `basti1101767`
--

-- --------------------------------------------------------

--
-- Structure de la table `post`
--

CREATE TABLE `post` (
  `id` int(100) NOT NULL,
  `ram_id` int(50) NOT NULL,
  `titre` varchar(255) NOT NULL,
  `texte` text NOT NULL,
  `photo` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `post`
--

INSERT INTO `post` (`id`, `ram_id`, `titre`, `texte`, `photo`) VALUES
(11, 3, 'Bienvenue sur le site', 'Et oui ! Après plusieurs mois, nous avons lancé notre site.', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `ram`
--

CREATE TABLE `ram` (
  `id` int(50) NOT NULL,
  `mdp` varchar(255) NOT NULL,
  `login` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `ram`
--

INSERT INTO `ram` (`id`, `mdp`, `login`) VALUES
(3, '$2y$10$2oH6/bWYPA8a8yVqX2KX.OeyBnDbflSNVziumoKngQka4KniUD7zu', 'RAM de Bry-sur-marne'),
(4, '$2y$10$qQdBttVOXihTqtcRaigTq.YydQ8yjunQhPyhi47zsDqd2RL2jYow.', 'RAM de Vincennes');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(100) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `mdp` varchar(255) NOT NULL,
  `ram_id` int(50) NOT NULL,
  `validated` int(2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `nom`, `prenom`, `mail`, `mdp`, `ram_id`, `validated`) VALUES
(18, 'Rossignol', 'Bastien', 'bastos@gmail.com', '$2y$10$L22ylOLKz9Es789tBZlDEuycsiX7b7mNgzMCq6hjvvyTHNhJHxHqG', 3, 1),
(51, 'Bois', 'Valérie', 'valerie@gmail.com', '$2y$10$WUQZql9QrMwtBf9EC.UFMuNyDAhJmUWik7XI6KVNurz0LAsax86xW', 3, 1);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `ram`
--
ALTER TABLE `ram`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `post`
--
ALTER TABLE `post`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT pour la table `ram`
--
ALTER TABLE `ram`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
