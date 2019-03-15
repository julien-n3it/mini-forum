-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  lun. 10 déc. 2018 à 15:11
-- Version du serveur :  5.7.17
-- Version de PHP :  5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `discussion`
--

-- --------------------------------------------------------

--
-- Structure de la table `tbldiscussions`
--

CREATE TABLE `tbldiscussions` (
  `id_dis` int(11) NOT NULL,
  `lnk_suj` int(11) NOT NULL,
  `lnk_ong` int(11) NOT NULL,
  `lnk_dis` int(11) NOT NULL,
  `dis_auteur` varchar(255) NOT NULL,
  `dis_texte` text NOT NULL,
  `dis_datetime` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='table pour stocker les discussions';

--
-- Déchargement des données de la table `tbldiscussions`
--

-- --------------------------------------------------------

--
-- Structure de la table `tblsujets`
--

CREATE TABLE `tblsujets` (
  `id_suj` int(11) NOT NULL,
  `suj_nom` text NOT NULL,
  `suj_datetime` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='table pour stocker les sujets';

--
-- Déchargement des données de la table `tblsujets`
--



--
-- Index pour les tables déchargées
--

--
-- Index pour la table `tbldiscussions`
--
ALTER TABLE `tbldiscussions`
  ADD PRIMARY KEY (`id_dis`);

--
-- Index pour la table `tblsujets`
--
ALTER TABLE `tblsujets`
  ADD PRIMARY KEY (`id_suj`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `tbldiscussions`
--
ALTER TABLE `tbldiscussions`
  MODIFY `id_dis` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT pour la table `tblsujets`
--
ALTER TABLE `tblsujets`
  MODIFY `id_suj` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
