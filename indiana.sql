-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : dim. 09 mai 2021 à 18:42
-- Version du serveur :  10.4.18-MariaDB
-- Version de PHP : 8.0.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `indiana`
--

-- --------------------------------------------------------

--
-- Structure de la table `tracking`
--

CREATE TABLE `tracking` (
  `id` int(11) UNSIGNED NOT NULL,
  `id_user` int(10) UNSIGNED NOT NULL,
  `campagne` varchar(255) NOT NULL,
  `document` varchar(255) NOT NULL,
  `quantite` int(11) NOT NULL,
  `action_url` varchar(255) NOT NULL,
  `serial1` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `url` varchar(255) NOT NULL,
  `Active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `tracking`
--

INSERT INTO `tracking` (`id`, `id_user`, `campagne`, `document`, `quantite`, `action_url`, `serial1`, `created_at`, `url`, `Active`) VALUES
(12, 1, 'salon du tourisme', 'flyers', 1000, 'url site', 'ozbx1rmdPb', '2021-04-26 23:51:34', 'https://www.facebook.com', 1),
(13, 5, 'salon du tourisme', 'flyers', 1000, 'url site', 'AdRiEnBg', '2021-04-27 00:01:44', 'https://www.uxcorp.co', 1),
(14, 5, 'Salon du Kebab', 'flyers', 5000, 'url site', 'StEpHmDr', '2021-04-27 12:19:59', 'https://www.lequipe.com', 1),
(15, 1, 'Meeting', 'Brochure', 100, 'url site', 'MeEtInG', '2021-04-27 20:24:30', 'https://www.gacd.fr', 0),
(34, 0, 'Salon du poulet', 'Affiche', 2000, 'url site', 'OUe0ley5R6', '2021-04-29 00:43:03', 'http://www.google.fr', 1),
(91, 0, 'Salon du tourisme', 'Flyers', 1000, 'url site', 'xNQHAdI8sx', '2021-05-02 15:35:30', 'http://www.google.fr', 1);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `created_at`) VALUES
(1, 'stephane@indianastudio.fr', '$2y$10$CSWTkrI10uZWSiD/gEQOxeaccK7KJcvyUY/TfhnghoP13GHe4jzXG', '2021-04-26 21:07:13'),
(5, 's.aboukrat@free.fr', '$2y$10$mqQcoMksAmeew//h5TSqTetUr2TJeP8D1vMgcQZf6JW8R.J138CHK', '2021-04-27 22:04:19');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `tracking`
--
ALTER TABLE `tracking`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `tracking`
--
ALTER TABLE `tracking`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
