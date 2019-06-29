-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  sam. 29 juin 2019 à 20:46
-- Version du serveur :  10.1.38-MariaDB
-- Version de PHP :  7.3.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `electroshop`
--

-- --------------------------------------------------------

--
-- Structure de la table `article`
--

CREATE TABLE `article` (
  `id_article` int(255) NOT NULL,
  `nom_article` varchar(50) NOT NULL,
  `id_categorie` int(255) NOT NULL,
  `stock_article` int(255) NOT NULL,
  `lien_image` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

CREATE TABLE `categorie` (
  `id_categorie` int(255) NOT NULL,
  `nom_categorie` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

CREATE TABLE `commande` (
  `id_commande` int(255) NOT NULL,
  `id_panier` int(255) NOT NULL,
  `statut_commande` varchar(20) NOT NULL,
  `total_commande` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `commentaires`
--

CREATE TABLE `commentaires` (
  `id_com` int(255) NOT NULL,
  `id_article` int(255) NOT NULL,
  `id_user` int(255) NOT NULL,
  `message` varchar(255) NOT NULL,
  `nb_etoile` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `panier`
--

CREATE TABLE `panier` (
  `id_panier` int(255) NOT NULL,
  `id_article` int(255) NOT NULL,
  `id_user` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `prix`
--

CREATE TABLE `prix` (
  `id_article` int(255) NOT NULL,
  `prix` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id_user` int(255) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(15) NOT NULL,
  `email` varchar(50) NOT NULL,
  `statut` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id_user`, `username`, `password`, `email`, `statut`) VALUES
(1, 'anthony', 'anthony', 'villedieu.anthony94@gmail.com', 1),
(29, 'axeloletozo', 'axelo', 'VILLEDIEU.ANTHONY@YAHOO.COM', 0);

-- --------------------------------------------------------

--
-- Structure de la table `validation`
--

CREATE TABLE `validation` (
  `id_user` int(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `statut` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `validation`
--

INSERT INTO `validation` (`id_user`, `token`, `statut`) VALUES
(29, '130b4617a7153697e9d1697b4a9b055d', 1);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `article`
--
ALTER TABLE `article`
  ADD PRIMARY KEY (`id_article`),
  ADD KEY `CAT-ART_idcategorie` (`id_categorie`);

--
-- Index pour la table `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`id_categorie`);

--
-- Index pour la table `commentaires`
--
ALTER TABLE `commentaires`
  ADD PRIMARY KEY (`id_com`),
  ADD KEY `ART-COMS_idarticle` (`id_article`),
  ADD KEY `USE-COMS_iduser` (`id_user`);

--
-- Index pour la table `panier`
--
ALTER TABLE `panier`
  ADD KEY `ART-PAN_id_article` (`id_article`),
  ADD KEY `USE-PAN_iduser` (`id_user`) USING BTREE;

--
-- Index pour la table `prix`
--
ALTER TABLE `prix`
  ADD KEY `ART-PRI_idarticle` (`id_article`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- Index pour la table `validation`
--
ALTER TABLE `validation`
  ADD KEY `id_user` (`id_user`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `article`
--
ALTER TABLE `article`
  MODIFY `id_article` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `categorie`
--
ALTER TABLE `categorie`
  MODIFY `id_categorie` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `commentaires`
--
ALTER TABLE `commentaires`
  MODIFY `id_com` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `article`
--
ALTER TABLE `article`
  ADD CONSTRAINT `CAT-ART_idcategorie` FOREIGN KEY (`id_categorie`) REFERENCES `categorie` (`id_categorie`);

--
-- Contraintes pour la table `commentaires`
--
ALTER TABLE `commentaires`
  ADD CONSTRAINT `ART-COMS_idarticle` FOREIGN KEY (`id_article`) REFERENCES `article` (`id_article`),
  ADD CONSTRAINT `USE-COMS_iduser` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`);

--
-- Contraintes pour la table `panier`
--
ALTER TABLE `panier`
  ADD CONSTRAINT `ART-PAN_id_article` FOREIGN KEY (`id_article`) REFERENCES `article` (`id_article`),
  ADD CONSTRAINT `USE-PAN_iduser` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`);

--
-- Contraintes pour la table `prix`
--
ALTER TABLE `prix`
  ADD CONSTRAINT `ART-PRI_idarticle` FOREIGN KEY (`id_article`) REFERENCES `article` (`id_article`);

--
-- Contraintes pour la table `validation`
--
ALTER TABLE `validation`
  ADD CONSTRAINT `id_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
