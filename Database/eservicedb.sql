-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 16, 2025 at 04:20 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `eservicedb`
--

-- --------------------------------------------------------

--
-- Table structure for table `chefs`
--

CREATE TABLE `chefs` (
  `id_chef` int(11) NOT NULL,
  `id_departement` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `coordinateurs`
--

CREATE TABLE `coordinateurs` (
  `id_coordinateur` int(11) NOT NULL,
  `id_filiere` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `coordinateurs`
--

INSERT INTO `coordinateurs` (`id_coordinateur`, `id_filiere`) VALUES
(5, 2);

-- --------------------------------------------------------

--
-- Table structure for table `departement`
--

CREATE TABLE `departement` (
  `id` int(11) NOT NULL,
  `departement_name` varchar(150) NOT NULL,
  `acronym` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `departement`
--

INSERT INTO `departement` (`id`, `departement_name`, `acronym`) VALUES
(1, 'Mathématiques et Informatique', 'MI'),
(2, 'Génie Civil Energétique et Environnement', 'GCEE'),
(3, 'none', '-');

-- --------------------------------------------------------

--
-- Table structure for table `emploi`
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
-- Table structure for table `filieres`
--

CREATE TABLE `filieres` (
  `id` int(11) NOT NULL,
  `label` varchar(100) NOT NULL,
  `acronym` varchar(10) NOT NULL,
  `id_departement` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `filieres`
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
-- Table structure for table `groupes`
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
-- Table structure for table `newusers`
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

--
-- Dumping data for table `newusers`
--

INSERT INTO `newusers` (`id`, `firstName`, `lastName`, `CIN`, `Birthdate`, `email`, `speciality`) VALUES
(8, 'Youssef', 'El Amrani', 'CD789012', '1993-03-14', 'youssef.amrani@example.com', 'Génie Civil'),
(9, 'Nadia', 'Kabbaj', 'EF345678', '1990-11-02', 'nadia.kabbaj@example.com', 'Télécommunications'),
(10, 'Omar', 'Zahidi', 'GH901234', '1998-01-25', 'omar.zahidi@example.com', 'Électronique'),
(11, 'Fatima', 'Maaroufi', 'IJ567890', '1996-06-10', 'fatima.maaroufi@example.com', 'Mathématiques Appliquées');

-- --------------------------------------------------------

--
-- Table structure for table `notes`
--

CREATE TABLE `notes` (
  `id_prof` int(11) NOT NULL,
  `id_unit` int(11) NOT NULL,
  `semestre` varchar(2) NOT NULL,
  `session` varchar(15) NOT NULL,
  `anneeUniversitaire` varchar(12) NOT NULL,
  `Notes` varchar(255) NOT NULL,
  `date_upload` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `id_utilisateur` int(11) NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `professeur`
--

CREATE TABLE `professeur` (
  `id_professeur` int(11) NOT NULL,
  `id_unit` int(11) NOT NULL,
  `Volume_horr` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `id` int(11) NOT NULL,
  `role_label` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id`, `role_label`) VALUES
(1, 'Administrateur'),
(2, 'Enseignant'),
(3, 'Chef de département'),
(4, 'Coordonnateur de filière'),
(5, 'Vacataire');

-- --------------------------------------------------------

--
-- Table structure for table `tempunits`
--

CREATE TABLE `tempunits` (
  `id_prof` int(11) NOT NULL,
  `id_unit` int(11) NOT NULL,
  `demande` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `units`
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
-- Table structure for table `userroles`
--

CREATE TABLE `userroles` (
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `userroles`
--

INSERT INTO `userroles` (`user_id`, `role_id`) VALUES
(1, 1),
(2, 2),
(3, 3),
(3, 2),
(4, 2),
(5, 2),
(5, 4),
(6, 5);

-- --------------------------------------------------------

--
-- Table structure for table `utilisateurs`
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
-- Dumping data for table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `firstName`, `lastName`, `CIN`, `Birthdate`, `email`, `password`, `speciality`, `id_departement`, `creation_date`, `must_change_password`) VALUES
(1, 'Ayoub', 'Gourstane', 'JC49250', '2004-09-25', 'ayoubgourstan@gmail.com', '$2y$10$bGjVMkqOgBWCLiKEWpUFOe0hssGgyMYLd4CjC13qR1DRIAaiL3I3e', 'none', 3, '2025-04-19 14:10:42', 0),
(2, 'John', 'Doe', 'EF34599', '2004-04-08', 'zoomenter2020@gmail.com', '$2y$10$jU1KliaVxmQbu6PpLmfhVeGVsjrXkBWHnhAmxrZervwULSZX/qMy6', 'Data science', 1, '2025-04-29 12:06:25', 0),
(3, 'jane', 'Doe', 'EF34566', '1995-05-01', 'rhdsp04@gmail.com', '$2y$10$I62TFtVM8vLqt1K8H2ULfOf85f76dj3jtiZIIZDjp5CCyxMRd0qZm', 'Mathématique et informatique', 1, '2025-05-03 01:18:03', 0),
(4, 'Yahya', 'Azalmat', 'UB11058', '2003-02-16', 'yahyazahra451@gmail.com', '$2y$10$I6LxzsJgnm3LZaw/amvk6ei/CVmCa2jpZ.STz7y456htY6HVFcVpa', 'AI', 1, '2025-05-05 15:34:17', 0),
(5, 'Coordinateur', 'filiere', 'JC649259', '1990-05-24', 'ayoubgourstane78@gmail.com', '$2y$10$Oy5H/PqCai/mVoeLTOAzQ.O7rNt7iPW8sUsBCB61UC5B0NzyLHI6W', 'programming essentiels', 1, '2025-05-08 15:07:17', 0),
(6, 'vacataire', 'am', 'KN339944', '1998-03-15', 'here.there.everywhere2004@gmail.com', '$2y$10$Rnatb0ITzFAslgtmVfeImOylY49O.iByLPGefiCB2ZgVlIRbdxMEq', 'machine learning', 1, '2025-05-14 00:00:06', 0);

-- --------------------------------------------------------

--
-- Table structure for table `volumehorraire`
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
-- Dumping data for table `volumehorraire`
--

INSERT INTO `volumehorraire` (`id_unit`, `Cours`, `TD`, `TP`, `Autre`, `Evaluation`) VALUES
(1, 20, 10, 15, 0, 5);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chefs`
--
ALTER TABLE `chefs`
  ADD KEY `id_chef` (`id_chef`),
  ADD KEY `id_departement` (`id_departement`);

--
-- Indexes for table `coordinateurs`
--
ALTER TABLE `coordinateurs`
  ADD KEY `id_coordinateur` (`id_coordinateur`),
  ADD KEY `id_filiere` (`id_filiere`);

--
-- Indexes for table `departement`
--
ALTER TABLE `departement`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `emploi`
--
ALTER TABLE `emploi`
  ADD KEY `id_coordinateur` (`id_coordinateur`),
  ADD KEY `id_filiere` (`id_filiere`);

--
-- Indexes for table `filieres`
--
ALTER TABLE `filieres`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_departement` (`id_departement`);

--
-- Indexes for table `groupes`
--
ALTER TABLE `groupes`
  ADD KEY `id_coordinateur` (`id_coordinateur`),
  ADD KEY `id_filiere` (`id_filiere`);

--
-- Indexes for table `newusers`
--
ALTER TABLE `newusers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `notes`
--
ALTER TABLE `notes`
  ADD KEY `id_prof` (`id_prof`),
  ADD KEY `id_unit` (`id_unit`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `professeur`
--
ALTER TABLE `professeur`
  ADD KEY `id_professeur` (`id_professeur`),
  ADD KEY `id_unit` (`id_unit`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tempunits`
--
ALTER TABLE `tempunits`
  ADD KEY `id_prof` (`id_prof`),
  ADD KEY `id_unit` (`id_unit`);

--
-- Indexes for table `units`
--
ALTER TABLE `units`
  ADD PRIMARY KEY (`id`),
  ADD KEY `departement_id` (`departement_id`),
  ADD KEY `id_filiere` (`id_filiere`);

--
-- Indexes for table `userroles`
--
ALTER TABLE `userroles`
  ADD KEY `role_id` (`role_id`),
  ADD KEY `user_Id` (`user_id`);

--
-- Indexes for table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `CIN` (`CIN`),
  ADD KEY `id_departement` (`id_departement`);

--
-- Indexes for table `volumehorraire`
--
ALTER TABLE `volumehorraire`
  ADD KEY `id_unit` (`id_unit`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `departement`
--
ALTER TABLE `departement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `filieres`
--
ALTER TABLE `filieres`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `newusers`
--
ALTER TABLE `newusers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `units`
--
ALTER TABLE `units`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `chefs`
--
ALTER TABLE `chefs`
  ADD CONSTRAINT `chefs_ibfk_1` FOREIGN KEY (`id_chef`) REFERENCES `utilisateurs` (`id`),
  ADD CONSTRAINT `chefs_ibfk_2` FOREIGN KEY (`id_departement`) REFERENCES `departement` (`id`);

--
-- Constraints for table `coordinateurs`
--
ALTER TABLE `coordinateurs`
  ADD CONSTRAINT `coordinateurs_ibfk_1` FOREIGN KEY (`id_coordinateur`) REFERENCES `utilisateurs` (`id`),
  ADD CONSTRAINT `coordinateurs_ibfk_2` FOREIGN KEY (`id_filiere`) REFERENCES `filieres` (`id`);

--
-- Constraints for table `emploi`
--
ALTER TABLE `emploi`
  ADD CONSTRAINT `emploi_ibfk_1` FOREIGN KEY (`id_coordinateur`) REFERENCES `coordinateurs` (`id_coordinateur`),
  ADD CONSTRAINT `emploi_ibfk_2` FOREIGN KEY (`id_filiere`) REFERENCES `filieres` (`id`);

--
-- Constraints for table `filieres`
--
ALTER TABLE `filieres`
  ADD CONSTRAINT `filieres_ibfk_1` FOREIGN KEY (`id_departement`) REFERENCES `departement` (`id`);

--
-- Constraints for table `groupes`
--
ALTER TABLE `groupes`
  ADD CONSTRAINT `groupes_ibfk_1` FOREIGN KEY (`id_coordinateur`) REFERENCES `utilisateurs` (`id`),
  ADD CONSTRAINT `groupes_ibfk_2` FOREIGN KEY (`id_filiere`) REFERENCES `filieres` (`id`);

--
-- Constraints for table `notes`
--
ALTER TABLE `notes`
  ADD CONSTRAINT `notes_ibfk_1` FOREIGN KEY (`id_prof`) REFERENCES `utilisateurs` (`id`),
  ADD CONSTRAINT `notes_ibfk_2` FOREIGN KEY (`id_unit`) REFERENCES `units` (`id`);

--
-- Constraints for table `professeur`
--
ALTER TABLE `professeur`
  ADD CONSTRAINT `professeur_ibfk_1` FOREIGN KEY (`id_professeur`) REFERENCES `utilisateurs` (`id`),
  ADD CONSTRAINT `professeur_ibfk_2` FOREIGN KEY (`id_unit`) REFERENCES `units` (`id`);

--
-- Constraints for table `tempunits`
--
ALTER TABLE `tempunits`
  ADD CONSTRAINT `tempunits_ibfk_1` FOREIGN KEY (`id_prof`) REFERENCES `utilisateurs` (`id`),
  ADD CONSTRAINT `tempunits_ibfk_2` FOREIGN KEY (`id_unit`) REFERENCES `units` (`id`);

--
-- Constraints for table `units`
--
ALTER TABLE `units`
  ADD CONSTRAINT `units_ibfk_1` FOREIGN KEY (`departement_id`) REFERENCES `departement` (`id`),
  ADD CONSTRAINT `units_ibfk_2` FOREIGN KEY (`id_filiere`) REFERENCES `filieres` (`id`);

--
-- Constraints for table `userroles`
--
ALTER TABLE `userroles`
  ADD CONSTRAINT `userroles_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`),
  ADD CONSTRAINT `userroles_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `utilisateurs` (`id`);

--
-- Constraints for table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD CONSTRAINT `utilisateurs_ibfk_1` FOREIGN KEY (`id_departement`) REFERENCES `departement` (`id`);

--
-- Constraints for table `volumehorraire`
--
ALTER TABLE `volumehorraire`
  ADD CONSTRAINT `volumehorraire_ibfk_1` FOREIGN KEY (`id_unit`) REFERENCES `units` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
