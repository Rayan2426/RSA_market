SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


CREATE TABLE `Annunci` (
  `ID` int NOT NULL,
  `nome` varchar(50) NOT NULL,
  `descrizione` varchar(255) DEFAULT NULL,
  `user_email` varchar(128) NOT NULL,
  `stato` varchar(30) NOT NULL,
  `tipologia` varchar(30) NOT NULL,
  `data` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ;


INSERT INTO `Annunci` (`ID`, `nome`, `descrizione`, `user_email`, `stato`, `tipologia`, `data`) VALUES
(1, 'Gatto', 'gatto+peloso+ciccione%2C+non+lo+voglio+pi%C3%B9', 'rayan@mohd.com', 'available', 'toys', '2024-05-20 14:34:52'),
(2, 'Mouse', 'Mouse+gaming+8k+rgb+e+un+succi+in+regalo', 'rayan@mohd.com', 'available', 'electronics', '2024-05-20 17:44:44'),
(3, 'Fungo', 'dritto+da+super+mario', 'rayan@mohd.com', 'available', 'cooking', '2024-05-20 21:04:49'),
(4, 'Verifica+di+inglese', 'Verifica+fatta+bene+con+il+voto+9', 'prova@gmail.com', 'available', 'books', '2024-05-21 08:00:33'),
(20, 'Ciompo', 'tumultando', 'rayan@mohd.com', 'available', 'cooking', '2024-05-24 09:04:32'),
(19, 'annuncio', 'annuncio+prova', 'ciompo@ciompo.ciompo', 'available', 'beauty', '2024-05-24 08:56:24'),
(17, 'big+bunda', '%3Cb%3Ebunda%3C%2Fb%3E', 'culo@culo.culo', 'available', 'beauty', '2024-05-22 09:03:32'),
(18, '%3Cb%3Eculo%3C%2Fb%3E', '%3Cb%3Ebunda%3C%2Fb%3E', '<b>culo</b>@culo.culo', 'available', 'beauty', '2024-05-22 09:28:53');

CREATE TABLE `Foto` (
  `ID` int NOT NULL,
  `urlImg` varchar(255) DEFAULT NULL,
  `Annuncio_ID` int NOT NULL
) ;

INSERT INTO `Foto` (`ID`, `urlImg`, `Annuncio_ID`) VALUES
(1, 'uploads/saleimgs//1/1.jpg', 1),
(2, 'uploads/saleimgs//2/1.jpg', 2),
(3, 'uploads/saleimgs//2/2.png', 2),
(4, 'uploads/saleimgs//3/1.jpg', 3),
(5, 'uploads/saleimgs//4/1.jpg', 4),
(17, 'uploads/saleimgs//20/1.jpg', 20),
(16, 'uploads/saleimgs//19/1.jpg', 19),
(14, 'uploads/saleimgs//17/1.jpg', 17),
(15, 'uploads/saleimgs//18/1.jpg', 18);

CREATE TABLE `Proposte` (
  `ID` int NOT NULL,
  `valore` int NOT NULL,
  `time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `Annuncio_ID` int NOT NULL,
  `Stato` varchar(30) NOT NULL,
  `User_email` varchar(128) DEFAULT NULL
) ;

CREATE TABLE `Stati` (
  `nome` varchar(30) NOT NULL
) ;

INSERT INTO `Stati` (`nome`) VALUES
('available'),
('closed'),
('deleted'),
('waiting');

CREATE TABLE `Tipologie` (
  `nome` varchar(30) NOT NULL,
  `descrizione` varchar(255) DEFAULT NULL
) ;

INSERT INTO `Tipologie` (`nome`, `descrizione`) VALUES
('beauty', NULL),
('books', NULL),
('carpentry', NULL),
('cooking', NULL),
('electronics', NULL),
('music', NULL),
('science', NULL),
('toys', NULL);

CREATE TABLE `UserLogs` (
  `ID` int NOT NULL,
  `logTime` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `User_email` varchar(128) DEFAULT NULL
) ;

INSERT INTO `UserLogs` (`ID`, `logTime`, `User_email`) VALUES
(1, '2024-05-11 17:35:00', 'rayan@mohd.com'),
(2, '2024-05-11 17:52:05', 'rayan@mohd.com'),
(3, '2024-05-12 11:39:54', 'rayan@mohd.com'),
(4, '2024-05-13 10:08:25', 'rayan@mohd.com'),
(5, '2024-05-13 10:08:34', 'rayan@mohd.com'),
(6, '2024-05-13 10:25:31', 'rayan@mohd.com'),
(7, '2024-05-15 10:16:59', 'rayan@mohd.com'),
(8, '2024-05-15 12:17:39', 'rayan@mohd.com'),
(9, '2024-05-15 12:27:53', 'prova@gmail.com'),
(10, '2024-05-15 12:28:17', 'prova@gmail.com'),
(11, '2024-05-15 12:49:08', 'rayan@mohd.com'),
(12, '2024-05-15 16:09:14', 'rayan@mohd.com'),
(13, '2024-05-15 18:09:05', 'admin@admin.com'),
(14, '2024-05-15 18:32:30', 'rayan@mohd.com'),
(15, '2024-05-16 06:35:44', 'rayan@mohd.com'),
(16, '2024-05-16 06:38:33', 'rayan@mohd.com'),
(17, '2024-05-16 14:41:18', 'prova@gmail.com'),
(18, '2024-05-16 14:41:59', 'prova@gmail.com'),
(19, '2024-05-20 14:11:35', 'rayan@mohd.com'),
(20, '2024-05-21 07:58:51', 'prova@gmail.com'),
(21, '2024-05-21 15:55:53', 'x@x'),
(22, '2024-05-22 05:51:00', 'prova@gmail.com'),
(23, '2024-05-22 06:00:31', 'aldinucci.alessio05@gmail.com'),
(24, '2024-05-22 06:05:08', 'x@x'),
(25, '2024-05-22 08:40:00', 'rayan@mohd.com'),
(26, '2024-05-22 09:01:27', 'culo@culo.culo'),
(27, '2024-05-22 09:02:53', 'culo@culo.culo'),
(28, '2024-05-22 09:27:11', 'culo@culo.culo'),
(29, '2024-05-22 11:49:38', 'francesco@gmail.com'),
(30, '2024-05-22 14:12:50', 'rayan@mohd.com'),
(31, '2024-05-22 15:32:20', 'rayan@mohd.com'),
(32, '2024-05-22 15:33:19', 'rayan@mohd.com'),
(33, '2024-05-24 08:54:18', 'ciompo@ciompo.ciompo'),
(34, '2024-05-24 09:02:29', 'rayan@mohd.com'),
(35, '2024-05-25 10:37:44', 'admin@gmail.com');

-- --------------------------------------------------------

--
-- Struttura della tabella `Users`
--

CREATE TABLE `Users` (
  `username` varchar(50) NOT NULL,
  `email` varchar(128) NOT NULL,
  `password` varchar(256) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `cognome` varchar(50) NOT NULL,
  `dataNascita` date NOT NULL,
  `fotoProfilo` varchar(255) DEFAULT NULL
) ;

INSERT INTO `Users` (`username`, `email`, `password`, `nome`, `cognome`, `dataNascita`, `fotoProfilo`) VALUES
('rayan2426', 'rayan@mohd.com', '4f8f70f9b4ff19d00e9db7363acd688d233d4857b75db321f197f9a8e69f0813', 'Rayan', 'Mohd', '2005-07-21', 'uploads/profileimgs/rayan2426.jpg'),
('admin', 'admin@admin.com', 'ae394e2cb425bbd7c99a087028a20ab47bf33488ad45ec1ba59fcf30f7042667', 'admin', 'admin', '2024-05-13', NULL),
('sierra', 'email@cioap.cp', '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4', 'Mario', 'Armani', '2024-05-16', NULL),
('prova', 'prova@gmail.com', '6258a5e0eb772911d4f92be5b5db0e14511edbe01d1d0ddd1d5a2cb9db9a56ba', 'prova', 'prova', '2024-05-08', 'uploads/profileimgs/prova.jpg'),
('xxx', 'x@x', 'cd2eb0837c9b4c962c22d2ff8b5441b7b45805887f051d39bf133b583baf6860', 'xx', 'xx', '1999-12-12', NULL),
('Svavsg', 'aldinucci.alessio05@gmail.com', '77696c7a64e9bc7de8f7f65e22148af210e3a6204f877307f9c8df34220118ec', 'Alessio', 'Aldinucci', '2024-05-14', NULL),
('culo', '<b>culo</b>@culo.culo', '77696c7a64e9bc7de8f7f65e22148af210e3a6204f877307f9c8df34220118ec', 'culo', 'culo', '2024-05-07', NULL),
('francesco', 'francesco@gmail.com', 'a2cab1deca58c8353168310f520c3bb7e45466e6722d771bed19126077b58703', 'Francesco', 'Capezio', '1979-04-11', 'uploads/profileimgs/francesco.png'),
('ciompo', 'ciompo@ciompo.ciompo', 'ddaed44711777b445df5b14892f0377103156457e615217a39ac9263ec75e01d', 'ciompo', 'ciompo', '2024-05-04', NULL),
('AdminUser', 'admin@gmail.com', '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918', 'Admin', 'Admin', '2024-06-05', NULL);

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
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

ALTER TABLE `Foto`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

ALTER TABLE `Proposte`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `UserLogs`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;
COMMIT;