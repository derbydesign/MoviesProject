-- USE THIS FILE TO CREATE movies_project DB

-- drop db
DROP DATABASE IF EXISTS `movies_project`;

-- create db
CREATE DATABASE `movies_project`;

USE `movies_project`;

-- create tables
CREATE TABLE `actors` (
	`id` int NOT NULL AUTO_INCREMENT,
	`first_name` varchar(30) NOT NULL,
	`last_name` varchar(30) NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE `movies` (
	`id` int NOT NULL AUTO_INCREMENT,
	`title` varchar(100) NOT NULL,
	`pc_id` int NOT NULL,
	`revenue` DECIMAL(11,2) NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE `production_companies` (
	`id` int NOT NULL AUTO_INCREMENT,
	`name` varchar(100) NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE `movie_actors` (
	`movie_id` int NOT NULL,
	`actor_id` int NOT NULL,
	`character_name` varchar(50) NOT NULL,
	`actor_base_salary` DECIMAL(10,2) NOT NULL,
	`actor_revenue_share` DECIMAL(3,2) NOT NULL,
	PRIMARY KEY (`movie_id`,`actor_id`)
);

ALTER TABLE `movies` ADD CONSTRAINT `movies_fk0` FOREIGN KEY (`pc_id`) REFERENCES `production_companies`(`id`);

ALTER TABLE `movie_actors` ADD CONSTRAINT `MovieActors_fk0` FOREIGN KEY (`movie_id`) REFERENCES `movies`(`id`);

ALTER TABLE `movie_actors` ADD CONSTRAINT `movie_actors_fk1` FOREIGN KEY (`actor_id`) REFERENCES `actors`(`id`);
