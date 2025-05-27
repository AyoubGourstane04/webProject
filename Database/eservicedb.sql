-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mar. 27 mai 2025 à 05:03
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
