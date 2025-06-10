-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mar. 10 juin 2025 à 10:05
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `eservicedb`
--

-- --------------------------------------------------------

--
-- Structure de la table `coordinateurs`
--

CREATE TABLE `coordinateurs` (
  `id_coordinateur` int(11) NOT NULL,
  `id_filiere` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `coordinateurs`
--

INSERT INTO `coordinateurs` (`id_coordinateur`, `id_filiere`) VALUES
(5, 2);

-- --------------------------------------------------------

--
-- Structure de la table `departement`
--

CREATE TABLE `departement` (
  `id` int(11) NOT NULL,
  `departement_name` varchar(150) NOT NULL,
  `acronym` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `departement`
--

INSERT INTO `departement` (`id`, `departement_name`, `acronym`) VALUES
(1, 'Mathématiques et Informatique', 'MI'),
(2, 'Génie Civil Energétique et Environnement', 'GCEE'),
(3, 'none', '-');

-- --------------------------------------------------------

--
-- Structure de la table `emploi`
--

CREATE TABLE `emploi` (
  `id_coordinateur` int(11) NOT NULL,
  `id_filiere` int(11) NOT NULL,
  `semestre` varchar(2) NOT NULL,
  `anneeUniversitaire` varchar(12) NOT NULL,
  `Emploi` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `filieres`
--

CREATE TABLE `filieres` (
  `id` int(11) NOT NULL,
  `label` varchar(100) NOT NULL,
  `acronym` varchar(10) NOT NULL,
  `id_departement` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `filieres`
--

INSERT INTO `filieres` (`id`, `label`, `acronym`, `id_departement`) VALUES
(1, 'Cycle Préparatoire', 'CP', 3),
(2, 'Génie Informatique', 'GI', 1),
(3, 'Génie Civil', 'GC', 2),
(4, 'Génie de l\'eau et de l\'Environnement', 'GEE', 2),
(5, 'Génie énergétique et énergies renouvelables', 'GEER', 2),
(6, 'Génie Mécanique', 'GM', 2),
(7, 'Ingénierie des données', 'ID', 1),
(8, 'Transformation Digitale et Intelligence Artificielle', 'TDIA', 1);

-- --------------------------------------------------------

--
-- Structure de la table `groupes`
--

CREATE TABLE `groupes` (
  `id_coordinateur` int(11) NOT NULL,
  `id_filiere` int(11) NOT NULL,
  `type` varchar(2) NOT NULL,
  `semestre` varchar(2) NOT NULL,
  `anneeUniversitaire` varchar(12) NOT NULL,
  `groupes_file` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `historiques`
--

CREATE TABLE `historiques` (
  `id` int(11) NOT NULL,
  `id_utilisateur` int(11) NOT NULL,
  `id_unite` int(11) NOT NULL,
  `annee` varchar(20) NOT NULL,
  `date_cr` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `newusers`
--

CREATE TABLE `newusers` (
  `id` int(11) NOT NULL,
  `firstName` varchar(50) NOT NULL,
  `lastName` varchar(75) NOT NULL,
  `CIN` varchar(10) NOT NULL,
  `Birthdate` date NOT NULL,
  `email` varchar(50) NOT NULL,
  `speciality` varchar(70) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `notes`
--

CREATE TABLE `notes` (
  `id_prof` int(11) NOT NULL,
  `id_unit` int(11) NOT NULL,
  `semestre` varchar(2) NOT NULL,
  `session` varchar(15) NOT NULL,
  `anneeUniversitaire` varchar(20) NOT NULL,
  `Notes` varchar(255) NOT NULL,
  `date_upload` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `id_utilisateur` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `professeur`
--

CREATE TABLE `professeur` (
  `id_professeur` int(11) NOT NULL,
  `id_unit` int(11) NOT NULL,
  `Volume_horr` int(11) NOT NULL,
  `anneeUniversitaire` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `role`
--

CREATE TABLE `role` (
  `id` int(11) NOT NULL,
  `role_label` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `role`
--

INSERT INTO `role` (`id`, `role_label`) VALUES
(1, 'Administrateur'),
(2, 'Enseignant'),
(3, 'Chef de département'),
(4, 'Coordonnateur de filière'),
(5, 'Vacataire');

-- --------------------------------------------------------

--
-- Structure de la table `tempunits`
--

CREATE TABLE `tempunits` (
  `id_prof` int(11) NOT NULL,
  `id_unit` int(11) NOT NULL,
  `demande` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `units`
--

CREATE TABLE `units` (
  `id` int(11) NOT NULL,
  `code_module` varchar(10) NOT NULL,
  `intitule` varchar(100) NOT NULL,
  `semestre` varchar(2) NOT NULL,
  `credits` decimal(11,2) NOT NULL,
  `speciality` varchar(50) NOT NULL,
  `departement_id` int(11) NOT NULL,
  `id_filiere` int(11) NOT NULL,
  `statut` tinyint(4) NOT NULL DEFAULT 0,
  `date_creation` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `units`
--

INSERT INTO `units` (`id`, `code_module`, `intitule`, `semestre`, `credits`, `speciality`, `departement_id`, `id_filiere`, `statut`, `date_creation`) VALUES
(1, 'M111', 'Architecture des ordinateurs', 'S1', 14.00, 'GI', 1, 2, 0, '2025-06-08 03:29:56'),
(2, 'M112', 'Langage C avancé et structures de données', 'S1', 14.00, 'GI', 1, 2, 0, '2025-06-08 03:29:56'),
(3, 'M113', 'Recherche opérationnelle et théorie des graphes', 'S1', 14.00, 'GI', 1, 2, 0, '2025-06-08 03:29:56'),
(4, 'M114', 'Systèmes d’Information et Bases de Données Relationnelles', 'S1', 14.00, 'GI', 1, 2, 0, '2025-06-08 03:29:56'),
(5, 'M115', 'Réseaux informatiques', 'S1', 14.00, 'GI', 1, 2, 0, '2025-06-08 03:29:56'),
(6, 'M116', 'Culture and Art skills', 'S1', 14.00, 'GI', 1, 2, 0, '2025-06-08 03:29:56'),
(7, 'M117.1', 'Langues Etrangéres (Français)', 'S1', 7.00, 'GI', 1, 2, 0, '2025-06-08 03:29:56'),
(8, 'M117.2', 'Langues Etrangéres (Anglais)', 'S1', 7.00, 'GI', 1, 2, 0, '2025-06-08 03:29:56'),
(9, 'M121', 'Architecture Logicielle et UML', 'S2', 14.00, 'GI', 1, 2, 0, '2025-06-08 03:29:56'),
(10, 'M122', 'Web1 : Technologies de Web et PHP5', 'S2', 14.00, 'GI', 1, 2, 0, '2025-06-08 03:29:56'),
(11, 'M123', 'Programmation Orientée Objet C++', 'S2', 14.00, 'GI', 1, 2, 0, '2025-06-08 03:29:56'),
(12, 'M124', 'Linux et programmation systéme', 'S2', 14.00, 'GI', 1, 2, 0, '2025-06-08 03:29:56'),
(13, 'M125', 'Algorithmique Avancée et complexité', 'S2', 14.00, 'GI', 1, 2, 0, '2025-06-08 03:29:56'),
(14, 'M126', 'Prompt ingeniering for developpers', 'S2', 14.00, 'GI', 1, 2, 0, '2025-06-08 03:29:56'),
(15, 'M127.1', 'Langues,Communication et TIC -fr', 'S2', 7.00, 'GI', 1, 2, 0, '2025-06-08 03:29:56'),
(16, 'M127.2', 'Langues,Communication et TIC- Ang', 'S2', 7.00, 'GI', 1, 2, 0, '2025-06-08 03:29:56'),
(17, 'M31', 'Python pour les sciences de données', 'S3', 16.00, 'GI', 1, 2, 0, '2025-06-08 03:29:56'),
(18, 'M32', 'Programmation Java Avancée', 'S3', 16.00, 'GI', 1, 2, 0, '2025-06-08 03:29:56'),
(19, 'M33.1', 'Langues et Communication -FR', 'S3', 5.00, 'GI', 1, 2, 0, '2025-06-08 03:29:56'),
(20, 'M33.2', 'Langues et Communication- Ang', 'S3', 5.00, 'GI', 1, 2, 0, '2025-06-08 03:29:56'),
(21, 'M33.3', 'Langues et Communication- Espagnol', 'S3', 5.00, 'GI', 1, 2, 0, '2025-06-08 03:29:56'),
(22, 'M34', 'Linux et programmation système', 'S3', 16.00, 'GI', 1, 2, 0, '2025-06-08 03:29:56'),
(23, 'M35', 'Administration des Bases de données Avancées', 'S3', 16.00, 'GI', 1, 2, 0, '2025-06-08 03:29:56'),
(24, 'M36', 'Administration réseaux et systèmes', 'S3', 16.00, 'GI', 1, 2, 0, '2025-06-08 03:29:56'),
(25, 'M41.1', 'Entreprenariat 2  - Contrôle gestion', 'S4', 8.00, 'GI', 1, 2, 0, '2025-06-08 03:29:56'),
(26, 'M41.2', 'Entreprenariat 2  -Marketing fondamental', 'S4', 8.00, 'GI', 1, 2, 0, '2025-06-08 03:29:56'),
(27, 'M42', 'Machine Learning', 'S4', 16.00, 'GI', 1, 2, 0, '2025-06-08 03:29:56'),
(28, 'M43.1', 'Gestion de projet', 'S4', 8.00, 'GI', 1, 2, 0, '2025-06-08 03:29:56'),
(29, 'M43.2', 'Génie logiciel', 'S4', 8.00, 'GI', 1, 2, 0, '2025-06-08 03:29:56'),
(30, 'M44.1', 'Crypto-systèmes', 'S4', 8.00, 'GI', 1, 2, 0, '2025-06-08 03:29:56'),
(31, 'M44.2', 'sécurité Informatique', 'S4', 8.00, 'GI', 1, 2, 0, '2025-06-08 03:29:56'),
(32, 'M45.1', 'Frameworks Java EE avancés', 'S4', 8.00, 'GI', 1, 2, 0, '2025-06-08 03:29:56'),
(33, 'M45.2', '.Net', 'S4', 8.00, 'GI', 1, 2, 0, '2025-06-08 03:29:56'),
(34, 'M46', 'Web 2 : Applications Web modernes', 'S4', 16.00, 'GI', 1, 2, 0, '2025-06-08 03:29:56'),
(35, 'M51', 'Système embarqué et temps réel', 'S5', 10.00, 'GI', 1, 2, 0, '2025-06-08 03:29:56'),
(36, 'M52', 'Développement des applications mobiles', 'S5', 10.00, 'GI', 1, 2, 0, '2025-06-08 03:29:56'),
(37, 'M53.1', 'Virtualisation', 'S5', 5.00, 'GI', 1, 2, 0, '2025-06-08 03:29:56'),
(38, 'M53.2', 'Cloud Computing', 'S5', 5.00, 'GI', 1, 2, 0, '2025-06-08 03:29:57'),
(39, 'M54', 'Analyse et conception des systèmes décisionnels', 'S5', 10.00, 'GI', 1, 2, 0, '2025-06-08 03:29:57'),
(40, 'M55', 'Enterprise Resource Planning ERP', 'S5', 10.00, 'GI', 1, 2, 0, '2025-06-08 03:29:57'),
(41, 'M56', 'Ingénierie logicielle, Qualité, Test et Intégration', 'S5', 10.00, 'GI', 1, 2, 0, '2025-06-08 03:29:57'),
(42, 'M57', 'Ingénierie de l’information et des connaissances', 'S5', 10.00, 'GI', 1, 2, 0, '2025-06-08 03:29:57'),
(43, 'M58', 'Business Intelligence & Veille Stratégique', 'S5', 10.00, 'GI', 1, 2, 0, '2025-06-08 03:29:57'),
(44, 'M59', 'Data Mining', 'S5', 10.00, 'GI', 1, 2, 0, '2025-06-08 03:29:57'),
(45, 'M510.1', 'Entreprenariat 3 -RH', 'S5', 5.00, 'GI', 1, 2, 0, '2025-06-08 03:29:57'),
(46, 'M510.2', 'Entreprenariat 3 - Gestion financiere', 'S5', 5.00, 'GI', 1, 2, 0, '2025-06-08 03:29:57');

-- --------------------------------------------------------

--
-- Structure de la table `userroles`
--

CREATE TABLE `userroles` (
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `userroles`
--

INSERT INTO `userroles` (`user_id`, `role_id`) VALUES
(1, 1),
(2, 2),
(3, 3),
(3, 2),
(5, 2),
(5, 4),
(6, 5);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `id` int(11) NOT NULL,
  `firstName` varchar(50) NOT NULL,
  `lastName` varchar(75) NOT NULL,
  `CIN` varchar(10) NOT NULL,
  `Birthdate` date NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `speciality` varchar(70) NOT NULL,
  `id_departement` int(11) NOT NULL,
  `creation_date` datetime NOT NULL DEFAULT current_timestamp(),
  `must_change_password` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `firstName`, `lastName`, `CIN`, `Birthdate`, `email`, `password`, `speciality`, `id_departement`, `creation_date`, `must_change_password`) VALUES
(1, 'Ayoub', 'Gourstane', 'JC49250', '2004-09-25', 'ayoubgourstan@gmail.com', '$2y$10$bGjVMkqOgBWCLiKEWpUFOe0hssGgyMYLd4CjC13qR1DRIAaiL3I3e', 'none', 3, '2025-04-19 14:10:42', 0),
(2, 'John', 'Doe', 'EF34599', '2004-04-08', 'zoomenter2020@gmail.com', '$2y$10$jU1KliaVxmQbu6PpLmfhVeGVsjrXkBWHnhAmxrZervwULSZX/qMy6', 'Data science', 1, '2025-04-29 12:06:25', 0),
(3, 'Chef', 'Dept', 'EF34566', '1995-05-01', 'rhdsp04@gmail.com', '$2y$10$I62TFtVM8vLqt1K8H2ULfOf85f76dj3jtiZIIZDjp5CCyxMRd0qZm', 'Mathématique et informatique', 1, '2025-05-03 01:18:03', 0),
(5, 'Coordinateur', 'filiere', 'JC649259', '1990-05-24', 'ayoubgourstane78@gmail.com', '$2y$10$Oy5H/PqCai/mVoeLTOAzQ.O7rNt7iPW8sUsBCB61UC5B0NzyLHI6W', 'programming essentiels', 1, '2025-05-08 15:07:17', 0),
(6, 'vacataire', 's', 'KJ664444', '1999-05-01', 'here.there.everywhere2004@gmail.com', '$2y$10$/lKSSzCn4qMOcXJaHUU8auGxCGbsIUwyNYURDQixcNYRkFPVTnLre', 'AI science', 1, '2025-05-18 02:23:34', 0);

-- --------------------------------------------------------

--
-- Structure de la table `vacataires`
--

CREATE TABLE `vacataires` (
  `id_vacataire` int(11) NOT NULL,
  `id_filiere` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `vacataires`
--

INSERT INTO `vacataires` (`id_vacataire`, `id_filiere`) VALUES
(6, 2);

-- --------------------------------------------------------

--
-- Structure de la table `volumehorraire`
--

CREATE TABLE `volumehorraire` (
  `id_unit` int(11) NOT NULL,
  `Cours` int(11) NOT NULL,
  `TD` int(11) NOT NULL,
  `TP` int(11) NOT NULL,
  `Autre` int(11) NOT NULL,
  `Evaluation` int(11) NOT NULL,
  `VolumeTotal` int(11) GENERATED ALWAYS AS (`Cours` + `TD` + `TP` + `Autre` + `Evaluation`) STORED
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `volumehorraire`
--

INSERT INTO `volumehorraire` (`id_unit`, `Cours`, `TD`, `TP`, `Autre`, `Evaluation`) VALUES
(1, 26, 16, 16, 4, 6),
(2, 26, 16, 18, 0, 6),
(3, 26, 24, 12, 0, 6),
(4, 26, 24, 12, 0, 6),
(5, 26, 18, 14, 4, 6),
(6, 26, 10, 0, 9, 3),
(7, 20, 6, 3, 0, 3),
(8, 20, 6, 3, 0, 3),
(9, 26, 16, 10, 10, 6),
(10, 26, 10, 16, 10, 6),
(11, 26, 16, 10, 10, 6),
(12, 26, 16, 10, 10, 6),
(13, 26, 26, 4, 6, 6),
(14, 26, 26, 6, 4, 6),
(15, 20, 6, 3, 0, 6),
(16, 20, 6, 3, 0, 6),
(17, 28, 0, 36, 0, 6),
(18, 24, 8, 32, 0, 6),
(19, 21, 0, 11, 0, 2),
(20, 21, 10, 0, 0, 2),
(21, 21, 10, 0, 0, 2),
(22, 21, 16, 27, 0, 6),
(23, 26, 4, 34, 0, 6),
(24, 27, 15, 22, 0, 6),
(25, 21, 18, 0, 0, 3),
(26, 25, 0, 0, 0, 3),
(27, 21, 20, 23, 0, 6),
(28, 16, 6, 16, 0, 3),
(29, 12, 6, 0, 8, 3),
(30, 15, 10, 4, 0, 3),
(31, 15, 10, 10, 0, 3),
(32, 15, 10, 4, 0, 0),
(33, 15, 10, 10, 0, 0),
(34, 21, 15, 28, 0, 6),
(35, 25, 25, 14, 0, 6),
(36, 28, 0, 36, 0, 6),
(37, 10, 4, 12, 0, 3),
(38, 12, 8, 18, 0, 3),
(39, 28, 12, 24, 0, 6),
(40, 22, 12, 30, 0, 6),
(41, 21, 18, 25, 0, 6),
(42, 28, 12, 24, 0, 6),
(43, 24, 16, 24, 0, 6),
(44, 26, 14, 24, 0, 6),
(45, 30, 0, 0, 0, 4),
(46, 18, 16, 0, 0, 2);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `coordinateurs`
--
ALTER TABLE `coordinateurs`
  ADD KEY `id_coordinateur` (`id_coordinateur`),
  ADD KEY `id_filiere` (`id_filiere`);

--
-- Index pour la table `departement`
--
ALTER TABLE `departement`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `emploi`
--
ALTER TABLE `emploi`
  ADD KEY `id_coordinateur` (`id_coordinateur`),
  ADD KEY `id_filiere` (`id_filiere`);

--
-- Index pour la table `filieres`
--
ALTER TABLE `filieres`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_departement` (`id_departement`);

--
-- Index pour la table `groupes`
--
ALTER TABLE `groupes`
  ADD KEY `id_coordinateur` (`id_coordinateur`),
  ADD KEY `id_filiere` (`id_filiere`);

--
-- Index pour la table `historiques`
--
ALTER TABLE `historiques`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_utilisateur` (`id_utilisateur`),
  ADD KEY `id_unite` (`id_unite`);

--
-- Index pour la table `newusers`
--
ALTER TABLE `newusers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Index pour la table `notes`
--
ALTER TABLE `notes`
  ADD KEY `id_prof` (`id_prof`),
  ADD KEY `id_unit` (`id_unit`);

--
-- Index pour la table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_utilisateur` (`id_utilisateur`);

--
-- Index pour la table `professeur`
--
ALTER TABLE `professeur`
  ADD KEY `id_professeur` (`id_professeur`),
  ADD KEY `id_unit` (`id_unit`);

--
-- Index pour la table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `tempunits`
--
ALTER TABLE `tempunits`
  ADD KEY `id_prof` (`id_prof`),
  ADD KEY `id_unit` (`id_unit`);

--
-- Index pour la table `units`
--
ALTER TABLE `units`
  ADD PRIMARY KEY (`id`),
  ADD KEY `departement_id` (`departement_id`),
  ADD KEY `id_filiere` (`id_filiere`);

--
-- Index pour la table `userroles`
--
ALTER TABLE `userroles`
  ADD KEY `role_id` (`role_id`),
  ADD KEY `user_Id` (`user_id`);

--
-- Index pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `CIN` (`CIN`),
  ADD KEY `id_departement` (`id_departement`);

--
-- Index pour la table `vacataires`
--
ALTER TABLE `vacataires`
  ADD KEY `id_vacataire` (`id_vacataire`),
  ADD KEY `id_filiere` (`id_filiere`);

--
-- Index pour la table `volumehorraire`
--
ALTER TABLE `volumehorraire`
  ADD KEY `id_unit` (`id_unit`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `departement`
--
ALTER TABLE `departement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `filieres`
--
ALTER TABLE `filieres`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `historiques`
--
ALTER TABLE `historiques`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `newusers`
--
ALTER TABLE `newusers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `role`
--
ALTER TABLE `role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `units`
--
ALTER TABLE `units`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `coordinateurs`
--
ALTER TABLE `coordinateurs`
  ADD CONSTRAINT `coordinateurs_ibfk_1` FOREIGN KEY (`id_coordinateur`) REFERENCES `utilisateurs` (`id`),
  ADD CONSTRAINT `coordinateurs_ibfk_2` FOREIGN KEY (`id_filiere`) REFERENCES `filieres` (`id`);

--
-- Contraintes pour la table `emploi`
--
ALTER TABLE `emploi`
  ADD CONSTRAINT `emploi_ibfk_1` FOREIGN KEY (`id_coordinateur`) REFERENCES `coordinateurs` (`id_coordinateur`),
  ADD CONSTRAINT `emploi_ibfk_2` FOREIGN KEY (`id_filiere`) REFERENCES `filieres` (`id`);

--
-- Contraintes pour la table `filieres`
--
ALTER TABLE `filieres`
  ADD CONSTRAINT `filieres_ibfk_1` FOREIGN KEY (`id_departement`) REFERENCES `departement` (`id`);

--
-- Contraintes pour la table `groupes`
--
ALTER TABLE `groupes`
  ADD CONSTRAINT `groupes_ibfk_1` FOREIGN KEY (`id_coordinateur`) REFERENCES `utilisateurs` (`id`),
  ADD CONSTRAINT `groupes_ibfk_2` FOREIGN KEY (`id_filiere`) REFERENCES `filieres` (`id`);

--
-- Contraintes pour la table `historiques`
--
ALTER TABLE `historiques`
  ADD CONSTRAINT `historiques_ibfk_1` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateurs` (`id`),
  ADD CONSTRAINT `historiques_ibfk_2` FOREIGN KEY (`id_unite`) REFERENCES `units` (`id`);

--
-- Contraintes pour la table `notes`
--
ALTER TABLE `notes`
  ADD CONSTRAINT `notes_ibfk_1` FOREIGN KEY (`id_prof`) REFERENCES `utilisateurs` (`id`),
  ADD CONSTRAINT `notes_ibfk_2` FOREIGN KEY (`id_unit`) REFERENCES `units` (`id`);

--
-- Contraintes pour la table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateurs` (`id`);

--
-- Contraintes pour la table `professeur`
--
ALTER TABLE `professeur`
  ADD CONSTRAINT `professeur_ibfk_1` FOREIGN KEY (`id_professeur`) REFERENCES `utilisateurs` (`id`),
  ADD CONSTRAINT `professeur_ibfk_2` FOREIGN KEY (`id_unit`) REFERENCES `units` (`id`);

--
-- Contraintes pour la table `tempunits`
--
ALTER TABLE `tempunits`
  ADD CONSTRAINT `tempunits_ibfk_1` FOREIGN KEY (`id_prof`) REFERENCES `utilisateurs` (`id`),
  ADD CONSTRAINT `tempunits_ibfk_2` FOREIGN KEY (`id_unit`) REFERENCES `units` (`id`);

--
-- Contraintes pour la table `units`
--
ALTER TABLE `units`
  ADD CONSTRAINT `units_ibfk_1` FOREIGN KEY (`departement_id`) REFERENCES `departement` (`id`),
  ADD CONSTRAINT `units_ibfk_2` FOREIGN KEY (`id_filiere`) REFERENCES `filieres` (`id`);

--
-- Contraintes pour la table `userroles`
--
ALTER TABLE `userroles`
  ADD CONSTRAINT `userroles_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`),
  ADD CONSTRAINT `userroles_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `utilisateurs` (`id`);

--
-- Contraintes pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD CONSTRAINT `utilisateurs_ibfk_1` FOREIGN KEY (`id_departement`) REFERENCES `departement` (`id`);

--
-- Contraintes pour la table `vacataires`
--
ALTER TABLE `vacataires`
  ADD CONSTRAINT `vacataires_ibfk_1` FOREIGN KEY (`id_vacataire`) REFERENCES `utilisateurs` (`id`),
  ADD CONSTRAINT `vacataires_ibfk_2` FOREIGN KEY (`id_filiere`) REFERENCES `filieres` (`id`);

--
-- Contraintes pour la table `volumehorraire`
--
ALTER TABLE `volumehorraire`
  ADD CONSTRAINT `volumehorraire_ibfk_1` FOREIGN KEY (`id_unit`) REFERENCES `units` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
