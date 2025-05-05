-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 05, 2025 at 04:35 PM
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

-- --------------------------------------------------------

--
-- Table structure for table `professeur`
--

CREATE TABLE `professeur` (
  `id_professeur` int(11) NOT NULL,
  `id_unit` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `professeur`
--

INSERT INTO `professeur` (`id_professeur`, `id_unit`) VALUES
(2, 3),
(2, 1);

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
  `unit_name` varchar(100) NOT NULL,
  `description` varchar(255) NOT NULL,
  `Hours` int(11) NOT NULL,
  `credits` int(11) NOT NULL,
  `departement_id` int(11) NOT NULL,
  `id_filiere` int(11) NOT NULL,
  `statut` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `units`
--

INSERT INTO `units` (`id`, `unit_name`, `description`, `Hours`, `credits`, `departement_id`, `id_filiere`, `statut`) VALUES
(1, 'POO C++', 'programmation oriente objet en c++', 21, 14, 1, 2, 1),
(2, 'Mécanique des fluides', 'mécanique des fluides couvrant tous les aspects de la physique liés aux mouvements et aux flux des fluides', 21, 14, 2, 6, 0),
(3, 'Web technologies', 'Learn the essential building blocks of the web. Master HTML for structure, CSS for styling, and introductory JavaScript for interactivity to create your first websites.', 22, 14, 1, 2, 1);

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
(4, 2);

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
(4, 'Yahya', 'Azalmat', 'UB11058', '2003-02-16', 'yahyazahra451@gmail.com', '$2y$10$K6/ePjSU0.T3/0aM2Fc7gOrxNNcf1arsGTyD4mgZKbJR/IIFPlDuO', 'AI', 1, '2025-05-05 15:34:17', 1);

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
-- Indexes for table `filieres`
--
ALTER TABLE `filieres`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_departement` (`id_departement`);

--
-- Indexes for table `newusers`
--
ALTER TABLE `newusers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `units`
--
ALTER TABLE `units`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
-- Constraints for table `filieres`
--
ALTER TABLE `filieres`
  ADD CONSTRAINT `filieres_ibfk_1` FOREIGN KEY (`id_departement`) REFERENCES `departement` (`id`);

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
