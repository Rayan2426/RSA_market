SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


CREATE TABLE `Annunci` (
  `ID` int NOT NULL,
  `nome` varchar(50) NOT NULL,
  `descrizione` varchar(255) DEFAULT NULL,
  `user_email` varchar(128) NOT NULL,
  `stato` varchar(30) NOT NULL,
  `tipologia` varchar(30) NOT NULL
);

CREATE TABLE `Foto` (
  `ID` int NOT NULL,
  `urlImg` varchar(255) DEFAULT NULL,
  `Annuncio_ID` int NOT NULL
);

CREATE TABLE `Proposte` (
  `ID` int NOT NULL,
  `valore` int NOT NULL,
  `time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `Annuncio_ID` int NOT NULL,
  `Stato` varchar(30) NOT NULL,
  `User_email` varchar(128) DEFAULT NULL
);

CREATE TABLE `Stati` (
  `nome` varchar(30) NOT NULL
);

CREATE TABLE `Tipologie` (
  `nome` varchar(30) NOT NULL,
  `descrizione` varchar(255) DEFAULT NULL
);

CREATE TABLE `UserLogs` (
  `ID` int NOT NULL,
  `logTime` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `User_email` varchar(128) DEFAULT NULL
);

INSERT INTO `UserLogs` (`ID`, `logTime`, `User_email`) VALUES
(1, '2024-05-11 17:35:00', 'rayan@mohd.com'),
(2, '2024-05-11 17:52:05', 'rayan@mohd.com'),
(3, '2024-05-12 11:39:54', 'rayan@mohd.com'),
(4, '2024-05-13 10:08:25', 'rayan@mohd.com'),
(5, '2024-05-13 10:08:34', 'rayan@mohd.com'),
(6, '2024-05-13 10:25:31', 'rayan@mohd.com');

CREATE TABLE `Users` (
  `username` varchar(50) NOT NULL,
  `email` varchar(128) NOT NULL,
  `password` varchar(256) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `cognome` varchar(50) NOT NULL,
  `dataNascita` date NOT NULL,
  `fotoProfilo` varchar(255) DEFAULT NULL
);

INSERT INTO `Users` (`username`, `email`, `password`, `nome`, `cognome`, `dataNascita`, `fotoProfilo`) VALUES
('rayan2426', 'rayan@mohd.com', '4f8f70f9b4ff19d00e9db7363acd688d233d4857b75db321f197f9a8e69f0813', 'Rayan', 'Mohd', '2005-07-21', NULL),
('admin', 'admin@admin.com', 'ae394e2cb425bbd7c99a087028a20ab47bf33488ad45ec1ba59fcf30f7042667', 'admin', 'admin', '2024-05-13', NULL);


ALTER TABLE `Annunci`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `user_email` (`user_email`),
  ADD KEY `stato` (`stato`),
  ADD KEY `tipologia` (`tipologia`);

ALTER TABLE `Foto`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Annuncio_ID` (`Annuncio_ID`);

ALTER TABLE `Proposte`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `User_email` (`User_email`),
  ADD KEY `Stato` (`Stato`),
  ADD KEY `Annuncio_ID` (`Annuncio_ID`);

ALTER TABLE `Stati`
  ADD PRIMARY KEY (`nome`);

ALTER TABLE `Tipologie`
  ADD PRIMARY KEY (`nome`);

ALTER TABLE `UserLogs`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `logTime` (`logTime`,`User_email`),
  ADD KEY `User_email` (`User_email`);

ALTER TABLE `Users`
  ADD PRIMARY KEY (`email`),
  ADD UNIQUE KEY `username` (`username`);


ALTER TABLE `Annunci`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `Foto`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `Proposte`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `UserLogs`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
