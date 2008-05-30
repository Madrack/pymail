-- phpMyAdmin SQL Dump
-- version 2.11.5.1
-- http://www.phpmyadmin.net
--
-- ����: localhost
-- ����� ��������: ��� 30 2008 �., 16:57
-- ������ �������: 4.1.20
-- ������ PHP: 5.1.2
SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
--
-- ���� ������: `birth_mail`
--
CREATE DATABASE `birth_mail` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
-- --------------------------------------------------------
--
-- ��������� ������� `people`
--
DROP TABLE IF EXISTS `birth_mail`.`people`;
CREATE TABLE IF NOT EXISTS `birth_mail`.`people` (
  `uID` int(10) unsigned NOT NULL auto_increment,
  `name` char(100) collate utf8_unicode_ci NOT NULL default '',
  `mail` char(100) collate utf8_unicode_ci NOT NULL default '',
  `birth` date NOT NULL default '0000-00-00',
  `sex` enum('m','f') collate utf8_unicode_ci NOT NULL default 'm',
  PRIMARY KEY  (`uID`),
  UNIQUE KEY `mail` (`mail`),
  KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;
--
-- ���� ������ ������� `people`
--
INSERT INTO `birth_mail`.`people` (`uID`, `name`, `mail`, `birth`, `sex`) VALUES
(1, '������ ���� ��������', 'IIvanov@pisem.net', '1980-10-10', 'm'),
(2, '������ ���� ��������', 'PPetrov@pisem.net', '1970-01-01', 'm'),
(3, '������ ���� ��������', 'IPetrov@pisem.net', '1969-04-16', 'm'),
(4, '������� ����� ���������', 'SSidorov@pisem.net', '1970-10-20', 'm'),
(6, '������� ���� ���������', 'ISidorov@pisem.net', '1970-10-20', 'm');

