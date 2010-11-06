# phpMyAdmin MySQL-Dump
# version 2.4.0-rc2
# http://www.phpmyadmin.net/ (download page)
#
# Host: localhost
# Generation Time: Nov 28, 2003 at 03:51 PM
# Server version: 4.0.14
# PHP Version: 4.3.2
# Database : `devsite`
# --------------------------------------------------------

#
# Table structure for table `bookmarks`
#

DROP TABLE IF EXISTS `bookmarks`;
CREATE TABLE `bookmarks` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(50) NOT NULL default '',
  `href` varchar(255) NOT NULL default '',
  `uid` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `events`
#

DROP TABLE IF EXISTS `events`;
CREATE TABLE `events` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(50) NOT NULL default '',
  `t` varchar(10) NOT NULL default '',
  `uid` int(11) NOT NULL default '0',
  `pid` int(11) NOT NULL default '0',
  `description` longtext NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `fm_files`
#

DROP TABLE IF EXISTS `fm_files`;
CREATE TABLE `fm_files` (
  `id` int(11) NOT NULL auto_increment,
  `path` varchar(255) NOT NULL default '',
  `name` varchar(255) NOT NULL default '',
  `shortdesc` tinytext NOT NULL,
  `longdesc` longtext NOT NULL,
  `uid` int(11) NOT NULL default '0',
  `screenshot` longblob NOT NULL,
  `screenshot_type` varchar(10) NOT NULL default '',
  `pid` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `fm_folders`
#

DROP TABLE IF EXISTS `fm_folders`;
CREATE TABLE `fm_folders` (
  `path` varchar(255) NOT NULL default '',
  `name` varchar(255) NOT NULL default '',
  `shortdesc` tinytext NOT NULL,
  `uid` int(11) NOT NULL default '0',
  `pid` int(11) NOT NULL default '0'
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `forum`
#

DROP TABLE IF EXISTS `forum`;
CREATE TABLE `forum` (
  `id` int(11) NOT NULL auto_increment,
  `topic` varchar(100) NOT NULL default '',
  `body` longtext NOT NULL,
  `parent` int(11) NOT NULL default '0',
  `uid` int(11) NOT NULL default '0',
  `pid` int(11) NOT NULL default '0',
  `created` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `links`
#

DROP TABLE IF EXISTS `links`;
CREATE TABLE `links` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(50) NOT NULL default '',
  `href` varchar(255) NOT NULL default '',
  `pid` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `project_members`
#

DROP TABLE IF EXISTS `project_members`;
CREATE TABLE `project_members` (
  `pid` int(11) NOT NULL default '0',
  `uid` int(11) NOT NULL default '0',
  `rights` varchar(20) NOT NULL default ''
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `projects`
#

DROP TABLE IF EXISTS `projects`;
CREATE TABLE `projects` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(50) NOT NULL default '',
  `createdby` int(11) NOT NULL default '0',
  `created` datetime NOT NULL default '0000-00-00 00:00:00',
  `description` tinytext NOT NULL,
  `homepage` longtext NOT NULL,
  `updated` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `task_members`
#

DROP TABLE IF EXISTS `task_members`;
CREATE TABLE `task_members` (
  `taskid` int(11) NOT NULL default '0',
  `uid` int(11) NOT NULL default '0'
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `tasks`
#

DROP TABLE IF EXISTS `tasks`;
CREATE TABLE `tasks` (
  `id` int(11) NOT NULL auto_increment,
  `tid` int(11) NOT NULL default '0',
  `name` varchar(50) NOT NULL default '',
  `createdby` int(11) NOT NULL default '0',
  `created` datetime NOT NULL default '0000-00-00 00:00:00',
  `updated` datetime NOT NULL default '0000-00-00 00:00:00',
  `objective` tinytext NOT NULL,
  `body` longtext NOT NULL,
  `percent` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`id`,`id`)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `team_members`
#

DROP TABLE IF EXISTS `team_members`;
CREATE TABLE `team_members` (
  `tid` int(11) NOT NULL default '0',
  `uid` int(11) NOT NULL default '0',
  `rights` varchar(10) NOT NULL default '0',
  `job` varchar(30) NOT NULL default ''
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `teams`
#

DROP TABLE IF EXISTS `teams`;
CREATE TABLE `teams` (
  `id` int(11) NOT NULL auto_increment,
  `pid` int(11) NOT NULL default '0',
  `name` varchar(50) NOT NULL default '',
  `createdby` int(11) NOT NULL default '0',
  `created` datetime NOT NULL default '0000-00-00 00:00:00',
  `description` tinytext NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `users`
#

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL auto_increment,
  `handle` varchar(30) NOT NULL default '',
  `pass` varchar(32) NOT NULL default '',
  `first` varchar(30) NOT NULL default '',
  `last` varchar(30) NOT NULL default '',
  `country` varchar(30) NOT NULL default '',
  `email` varchar(80) NOT NULL default '',
  `created` datetime NOT NULL default '0000-00-00 00:00:00',
  `rights` varchar(20) NOT NULL default '',
  `last_date` datetime NOT NULL default '0000-00-00 00:00:00',
  `last_ip` varchar(20) NOT NULL default '',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

