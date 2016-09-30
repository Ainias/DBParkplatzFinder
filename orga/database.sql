CREATE DATABASE IF NOT EXISTS parkplatzFinder;
USE parkplatzFinder;

CREATE TABLE `Occupancy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `siteId` int(11) NOT NULL,
  `category` int(11) NOT NULL,
  `timeSegment` datetime NOT NULL,
  `timestamp` datetime NOT NULL,
  PRIMARY KEY (`id`)
);