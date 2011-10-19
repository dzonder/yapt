-- Copyright (c) 2011 Michal Olech
-- YAPT

CREATE TABLE `pastes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `timesent` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `flags` set('ENC_3DES','ENC_PLAIN') NOT NULL,
  `language` varchar(10) NOT NULL DEFAULT 'none',
  `code` blob NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=128 DEFAULT CHARSET=utf8;
