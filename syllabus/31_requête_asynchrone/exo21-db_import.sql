-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 26, 2020 at 10:59 AM
-- Server version: 5.7.26
-- PHP Version: 7.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `4ipdw_sample`
--

-- --------------------------------------------------------

--
-- Table structure for table `t_deal`
--

DROP TABLE IF EXISTS `t_deal`;
CREATE TABLE IF NOT EXISTS `t_deal` (
  `id_dea` int(11) NOT NULL AUTO_INCREMENT,
  `name_dea` varchar(63) NOT NULL,
  `is_active_dea` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id_dea`)
) ENGINE=MyISAM AUTO_INCREMENT=35 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t_deal`
--

INSERT INTO `t_deal` (`id_dea`, `name_dea`, `is_active_dea`) VALUES
(1, 'entre amis', 1),
(2, 'entre coll&egrave;gues', 1),
(3, 'ISFCE', 1);

-- --------------------------------------------------------

--
-- Table structure for table `t_player`
--

DROP TABLE IF EXISTS `t_player`;
CREATE TABLE IF NOT EXISTS `t_player` (
  `id_pla` int(11) NOT NULL AUTO_INCREMENT,
  `name_pla` varchar(63) NOT NULL,
  `fk_team_pla` int(11) NOT NULL,
  PRIMARY KEY (`id_pla`),
  KEY `fk_team_pla` (`fk_team_pla`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t_player`
--

INSERT INTO `t_player` (`id_pla`, `name_pla`, `fk_team_pla`) VALUES
(1, 'Alex', 1),
(2, 'Bertrand', 2),
(3, 'Cédric', 2),
(4, 'Damien', 1);

-- --------------------------------------------------------

--
-- Table structure for table `t_score`
--

DROP TABLE IF EXISTS `t_score`;
CREATE TABLE IF NOT EXISTS `t_score` (
  `id_sco` int(11) NOT NULL AUTO_INCREMENT,
  `score_sco` int(11) NOT NULL,
  `date_sco` datetime DEFAULT NULL,
  `fk_player_sco` int(11) NOT NULL,
  `fk_deal_sco` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_sco`),
  KEY `fk_player_sco` (`fk_player_sco`),
  KEY `fk_deal_sco` (`fk_deal_sco`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t_score`
--

INSERT INTO `t_score` (`id_sco`, `score_sco`, `date_sco`, `fk_player_sco`, `fk_deal_sco`) VALUES
(1, 100, NULL, 1, 1),
(2, 182, NULL, 2, 1),
(3, 197, NULL, 2, 3);

-- --------------------------------------------------------

--
-- Table structure for table `t_team`
--

DROP TABLE IF EXISTS `t_team`;
CREATE TABLE IF NOT EXISTS `t_team` (
  `id_tea` int(11) NOT NULL AUTO_INCREMENT,
  `name_tea` varchar(63) NOT NULL,
  PRIMARY KEY (`id_tea`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t_team`
--

INSERT INTO `t_team` (`id_tea`, `name_tea`) VALUES
(1, 'Ixelles'),
(2, 'Etterbeek');

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_player_score_partie`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `v_player_score_partie`;
CREATE TABLE IF NOT EXISTS `v_player_score_partie` (
`name_pla` varchar(63)
,`score` decimal(32,0)
,`partie` varchar(63)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_player_team`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `v_player_team`;
CREATE TABLE IF NOT EXISTS `v_player_team` (
`player` varchar(63)
,`team` varchar(63)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_team_score`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `v_team_score`;
CREATE TABLE IF NOT EXISTS `v_team_score` (
`name` varchar(63)
,`score` decimal(32,0)
);

-- --------------------------------------------------------

--
-- Structure for view `v_player_score_partie`
--
DROP TABLE IF EXISTS `v_player_score_partie`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_player_score_partie`  AS  select `t_player`.`name_pla` AS `name_pla`,sum(`t_score`.`score_sco`) AS `score`,`t_deal`.`name_dea` AS `partie` from ((`t_score` join `t_player` on((`t_score`.`fk_player_sco` = `t_player`.`id_pla`))) join `t_deal` on((`t_deal`.`id_dea` = `t_score`.`fk_deal_sco`))) group by `t_player`.`name_pla`,`t_deal`.`name_dea` ;

-- --------------------------------------------------------

--
-- Structure for view `v_player_team`
--
DROP TABLE IF EXISTS `v_player_team`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_player_team`  AS  select `t_player`.`name_pla` AS `player`,`t_team`.`name_tea` AS `team` from (`t_player` join `t_team` on((`t_player`.`fk_team_pla` = `t_team`.`id_tea`))) ;

-- --------------------------------------------------------

--
-- Structure for view `v_team_score`
--
DROP TABLE IF EXISTS `v_team_score`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_team_score`  AS  select `t_team`.`name_tea` AS `name`,sum(`t_score`.`score_sco`) AS `score` from ((`t_score` join `t_player` on((`t_score`.`fk_player_sco` = `t_player`.`id_pla`))) join `t_team` on((`t_team`.`id_tea` = `t_player`.`fk_team_pla`))) group by `t_team`.`name_tea` ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
