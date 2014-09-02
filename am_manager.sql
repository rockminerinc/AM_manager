-- Adminer 4.0.3 MySQL dump

SET NAMES utf8;
SET foreign_key_checks = 0;
SET time_zone = '+08:00';
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `commands`;
CREATE TABLE `commands` (
  `cid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `content` varchar(255) NOT NULL,
  `event_time` int(11) NOT NULL,
  `tid` int(11) NOT NULL,
  `server` varchar(255) NOT NULL,
  PRIMARY KEY (`cid`),
  KEY `tid` (`tid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `groups`;
CREATE TABLE `groups` (
  `gid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `rack` varchar(255) NOT NULL,
  `start` int(11) NOT NULL,
  `end` int(11) NOT NULL,
  PRIMARY KEY (`gid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `miners`;
CREATE TABLE `miners` (
  `mid` int(11) NOT NULL AUTO_INCREMENT,
  `groups` int(11) NOT NULL DEFAULT '0',
  `ip_address` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `ipint` bigint(20) NOT NULL,
  `mac_address` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `macint` bigint(20) NOT NULL,
  `dev_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `asc_mhs_av` float NOT NULL,
  `asc_mhs_5s` decimal(15,0) NOT NULL,
  `asc_mhs_5m` float NOT NULL,
  `asc_mhs_15m` float NOT NULL,
  `asc_last_share_time` int(11) NOT NULL,
  `event_time` int(11) NOT NULL,
  `dev_num` tinyint(4) DEFAULT '0',
  `temperature` tinyint(4) NOT NULL,
  `asc_elapsed` int(11) NOT NULL,
  `add_time` int(11) NOT NULL,
  `memo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`mid`),
  KEY `location` (`groups`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `t1miners`;
CREATE TABLE `t1miners` (
  `tid` int(11) NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(255) NOT NULL,
  `ipint` bigint(20) NOT NULL,
  `dev_num` mediumint(9) NOT NULL,
  `hash` int(11) NOT NULL,
  `efi` float NOT NULL,
  `hws` float NOT NULL,
  `event_time` int(11) NOT NULL,
  `server` varchar(255) NOT NULL,
  `pool` varchar(255) NOT NULL,
  PRIMARY KEY (`tid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


-- 2014-09-02 21:16:49
