-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 24, 2019 at 07:23 PM
-- Server version: 5.7.23
-- PHP Version: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `consultas`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_consulta`
--

DROP TABLE IF EXISTS `tb_consulta`;
CREATE TABLE IF NOT EXISTS `tb_consulta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipo_consulta` varchar(250) NOT NULL,
  `proxima` date NOT NULL,
  `paciente` int(11) NOT NULL,
  `prof_saude` int(11) NOT NULL,
  `sintomas` varchar(250) NOT NULL,
  `utilizador` varchar(50) NOT NULL,
  `data_registo` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_consulta`
--

INSERT INTO `tb_consulta` (`id`, `tipo_consulta`, `proxima`, `paciente`, `prof_saude`, `sintomas`, `utilizador`, `data_registo`) VALUES
(1, 'Neurocirurgia', '2020-11-24', 3, 2, 'Dores na cabeca', 'freelancer', '2019-11-24'),
(2, 'Normal', '2019-11-24', 4, 3, 'Mau estar', 'freelancer', '2019-11-24'),
(3, 'Normal', '2019-11-24', 5, 3, 'Nausias ...', 'freelancer', '2019-11-24');

-- --------------------------------------------------------

--
-- Table structure for table `tb_doenca`
--

DROP TABLE IF EXISTS `tb_doenca`;
CREATE TABLE IF NOT EXISTS `tb_doenca` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(200) NOT NULL,
  `alerta` int(11) NOT NULL,
  `utilizador` varchar(50) NOT NULL,
  `data_registo` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_especialidade`
--

DROP TABLE IF EXISTS `tb_especialidade`;
CREATE TABLE IF NOT EXISTS `tb_especialidade` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(100) NOT NULL,
  `utilizador` varchar(150) NOT NULL,
  `data_registo` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_hospital`
--

DROP TABLE IF EXISTS `tb_hospital`;
CREATE TABLE IF NOT EXISTS `tb_hospital` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(250) NOT NULL,
  `provincia` varchar(50) NOT NULL,
  `cidade` varchar(50) NOT NULL,
  `contacto` varchar(14) NOT NULL,
  `utilizador` varchar(50) NOT NULL,
  `data_registo` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_paciente`
--

DROP TABLE IF EXISTS `tb_paciente`;
CREATE TABLE IF NOT EXISTS `tb_paciente` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `apelido` varchar(100) NOT NULL,
  `nome` varchar(200) NOT NULL,
  `n_bi` varchar(23) DEFAULT NULL,
  `morada` varchar(150) NOT NULL,
  `contacto` varchar(14) NOT NULL,
  `data_nasc` date DEFAULT NULL,
  `data_registo` datetime NOT NULL,
  `utilizador` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_paciente`
--

INSERT INTO `tb_paciente` (`id`, `apelido`, `nome`, `n_bi`, `morada`, `contacto`, `data_nasc`, `data_registo`, `utilizador`) VALUES
(3, 'Matavele', 'Amilcar Joaquim Joao', '1273498009J', 'Maputo-Matola', '8456762323', '1917-10-03', '2019-11-20 09:31:55', 'freelancer'),
(4, 'Macuacua', 'Daniel David', '4548878976D', 'Alto mae', '854697813', '1980-08-01', '2019-11-20 00:00:00', 'freelancer'),
(5, 'Amosse', 'Alcidio', '72853259635R', 'Bagamoio', '859541263', '1989-08-01', '2019-11-20 00:00:00', 'freelancer'),
(6, 'Uamusse', 'Stelio', '3255697451F', 'Mulotana-Bile', '8945613205', '1989-04-25', '2019-11-20 00:00:00', 'freelancer'),
(7, 'Cossa', 'Almiro', '8456134984D', 'Liberdade', '865421389', '1988-02-28', '2019-11-20 00:00:00', 'freelancer'),
(8, 'Sitoe', 'Rosalina Adamo', '4512669845U', 'Matola 700', '867461396', '1995-10-10', '2019-11-20 00:00:00', 'freelancer'),
(14, 'Mabote', 'Zacarias Joao', '5694356394H', 'Machava Sede', '8745135236', '2019-11-24', '2019-11-24 13:36:36', 'freelancer'),
(13, 'Silva', 'Joao Carlos', '3294835659H', 'Belo Horizonte', '874561253', '2019-11-14', '2019-11-23 00:00:00', 'freelancer');

-- --------------------------------------------------------

--
-- Table structure for table `tb_post_atend`
--

DROP TABLE IF EXISTS `tb_post_atend`;
CREATE TABLE IF NOT EXISTS `tb_post_atend` (
  `id` int(11) NOT NULL,
  `nome` int(11) NOT NULL,
  `provincia` int(11) NOT NULL,
  `cidade` int(11) NOT NULL,
  `contacto` int(11) NOT NULL,
  `utilizador` int(11) NOT NULL,
  `data_registo` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_prescri_medica`
--

DROP TABLE IF EXISTS `tb_prescri_medica`;
CREATE TABLE IF NOT EXISTS `tb_prescri_medica` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(200) NOT NULL,
  `consulta` int(11) NOT NULL,
  `medicacao` varchar(200) NOT NULL,
  `medicacao_altern` varchar(200) DEFAULT NULL,
  `desc_medicao` varchar(250) NOT NULL,
  `desc_medica_altern` varchar(250) DEFAULT NULL,
  `data_fim` date NOT NULL,
  `utilizador` varchar(50) NOT NULL,
  `data_registo` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_prof_saude`
--

DROP TABLE IF EXISTS `tb_prof_saude`;
CREATE TABLE IF NOT EXISTS `tb_prof_saude` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `apelido` varchar(100) NOT NULL,
  `nome` varchar(200) NOT NULL,
  `contacto` varchar(14) NOT NULL,
  `morada` varchar(150) NOT NULL,
  `utilizador` varchar(50) NOT NULL,
  `data_registo` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_prof_saude`
--

INSERT INTO `tb_prof_saude` (`id`, `apelido`, `nome`, `contacto`, `morada`, `utilizador`, `data_registo`) VALUES
(1, 'Langa', 'Enoque Zacarias', '8452123256', 'Machava Sede', 'freelancer', '2019-11-24'),
(2, 'Macamo', 'Nelta Adma', '87458965', 'Machava Sede', 'freelancer', '2019-11-24'),
(3, 'Aly', 'Dalma Santos', '855445185', 'Machava Sede', 'freelancer', '2019-11-24');

-- --------------------------------------------------------

--
-- Table structure for table `tb_prof_saude_especial`
--

DROP TABLE IF EXISTS `tb_prof_saude_especial`;
CREATE TABLE IF NOT EXISTS `tb_prof_saude_especial` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `prof_saude` int(11) NOT NULL,
  `especialidade` int(11) NOT NULL,
  `utilizador` varchar(50) NOT NULL,
  `data_registo` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
