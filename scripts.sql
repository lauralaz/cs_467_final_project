drop table if exists `awards`;
drop table if exists `users`;
CREATE TABLE `users` (
  `email` varchar(100) NOT NULL,
  `password` varchar(256) NOT NULL,
  `user_name` varchar(256) DEFAULT NULL,
  `user_last_name` varchar(256) DEFAULT NULL,
  `security_word` varchar(256) DEFAULT NULL,
  `registration_time` timestamp NOT NULL default current_timestamp,
  `photo` varchar(256) DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

drop table if exists `award_types`;
CREATE TABLE `award_types` (
  `type_id` tinyint NOT NULL,
  `full_name` varchar(100) NOT NULL,
  PRIMARY KEY (`type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `award_types` (`type_id`, `full_name`) VALUES ('1', 'Employee of the Week');
INSERT INTO `award_types` (`type_id`, `full_name`) VALUES ('2', 'Employee of the Month');

drop table if exists `awards`;
CREATE TABLE `awards` (
  `id` int NOT NULL auto_increment,
  `awards_type` tinyint NOT NULL,
  `owner` varchar(100) NOT NULL,
  `owner_name` varchar(256) NOT NULL,
  `who_created` varchar(100) NOT NULL,
  `creation_time` timestamp NOT NULL default current_timestamp,
  PRIMARY KEY (`id`),
  KEY `fk_awards_type` (`awards_type`),
  KEY `fk_who_created` (`who_created`),
  CONSTRAINT `fk_awards_type` FOREIGN KEY (`awards_type`) 
	REFERENCES `award_types` (`type_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_who_created` FOREIGN KEY (`who_created`) 
	REFERENCES `users` (`email`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;