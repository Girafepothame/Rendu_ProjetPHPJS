
DROP TABLE IF EXISTS `upgrade_loadout`;
DROP TABLE IF EXISTS `loadout`;
DROP TABLE IF EXISTS `restriction`;
DROP TABLE IF EXISTS `bonus`;
DROP TABLE IF EXISTS `side`;
DROP TABLE IF EXISTS `upgrade`;
DROP TABLE IF EXISTS `force`;
DROP TABLE IF EXISTS `charge`;
DROP TABLE IF EXISTS `pilot`;
DROP TABLE IF EXISTS `action`;
DROP TABLE IF EXISTS `stat`;
DROP TABLE IF EXISTS `maneuver`;
DROP TABLE IF EXISTS `dial`;
DROP TABLE IF EXISTS `ship`;
DROP TABLE IF EXISTS `faction`;




CREATE TABLE `faction` (
  `id_faction` int PRIMARY KEY,
  `name` varchar(255),
  `xws` varchar(255),
  `icon` varchar(255)
);

CREATE TABLE `ship` (
  `id_ship` int PRIMARY KEY,
  `name` varchar(255),
  `xws` varchar(255),
  `size` varchar(255),
  `icon` varchar(255),
  `id_faction` int
);

CREATE TABLE `dial` (
  `id_dial` int PRIMARY KEY,
  `dialCodes` varchar(255),
  `id_ship` int
);

CREATE TABLE `maneuver` (
  `id_maneuver` int PRIMARY KEY,
  `code` varchar(255),
  `id_dial` int
);

CREATE TABLE `stat` (
  `id_stat` int PRIMARY KEY,
  `arc` varchar(255),
  `type` varchar(255),
  `value` varchar(255),
  `recovers` varchar(255),
  `id_ship` int
);

CREATE TABLE `action` (
  `id_action` int PRIMARY KEY,
  `difficulty` varchar(255),
  `type` varchar(255),
  `id_ship` int,
  `id_linked` int
);

CREATE TABLE `pilot` (
  `id_pilot` int PRIMARY KEY,
  `xws` varchar(255),
  `name` varchar(255),
  `caption` varchar(255),
  `initiative` int,
  `limited` int,
  `cost` int,
  `loadout` int,
  `ability` text,
  `image` varchar(255),
  `artwork` varchar(255),
  `shipAbility` text,
  `keywords` varchar(255),
  `slots` varchar(255),
  `id_ship` int
);

-- Fin des entity créées

CREATE TABLE `charge` (
  `id_charge` int PRIMARY KEY,
  `value` int,
  `recovers` int,
  `id_pilot` int
);

CREATE TABLE `force` (
  `id_force` int PRIMARY KEY,
  `value` int,
  `recovers` int,
  `side` varchar(255),
  `id_pilot` int
);

CREATE TABLE `upgrade` (
  `id_upgrade` int PRIMARY KEY,
  `xws` varchar(255),
  `type` varchar(255),
  `name` varchar(255),
  `limited` int,
  `cost` int
);

CREATE TABLE `side` (
  `id_side` int PRIMARY KEY,
  `title` varchar(255),
  `ability` text,
  `image` varchar(255),
  `artwork` varchar(255),
  `slots` varchar(255),
  `id_upgrade` int
);

CREATE TABLE `bonus` (
  `id_bonus` int PRIMARY KEY,
  `type` varchar(255),
  `value` varchar(255),
  `id_side` int
);

CREATE TABLE `restriction` (
  `id_restriction` int PRIMARY KEY,
  `type` varchar(255),
  `value` varchar(255),
  `id_upgrade` int
);

CREATE TABLE `loadout` (
  `id_loadout` int PRIMARY KEY,
  `max` int,
  `total` int,
  `id_pilot` int
);

CREATE TABLE `upgrade_loadout` (
  `id_upgrade` int,
  `id_loadout` int,
  PRIMARY KEY (`id_upgrade`, `id_loadout`)
);

ALTER TABLE `ship` ADD FOREIGN KEY (`id_faction`) REFERENCES `faction` (`id_faction`);

ALTER TABLE `dial` ADD FOREIGN KEY (`id_ship`) REFERENCES `ship` (`id_ship`);

ALTER TABLE `maneuver` ADD FOREIGN KEY (`id_dial`) REFERENCES `dial` (`id_dial`);

ALTER TABLE `stat` ADD FOREIGN KEY (`id_ship`) REFERENCES `ship` (`id_ship`);

ALTER TABLE `action` ADD FOREIGN KEY (`id_ship`) REFERENCES `ship` (`id_ship`);

ALTER TABLE `action` ADD FOREIGN KEY (`id_linked`) REFERENCES `action` (`id_action`);

ALTER TABLE `pilot` ADD FOREIGN KEY (`id_ship`) REFERENCES `ship` (`id_ship`);

ALTER TABLE `charge` ADD FOREIGN KEY (`id_pilot`) REFERENCES `pilot` (`id_pilot`);

ALTER TABLE `force` ADD FOREIGN KEY (`id_pilot`) REFERENCES `pilot` (`id_pilot`);

ALTER TABLE `side` ADD FOREIGN KEY (`id_upgrade`) REFERENCES `upgrade` (`id_upgrade`);

ALTER TABLE `bonus` ADD FOREIGN KEY (`id_side`) REFERENCES `side` (`id_side`);

ALTER TABLE `restriction` ADD FOREIGN KEY (`id_upgrade`) REFERENCES `upgrade` (`id_upgrade`);

ALTER TABLE `loadout` ADD FOREIGN KEY (`id_pilot`) REFERENCES `pilot` (`id_pilot`);

ALTER TABLE `upgrade_loadout` ADD FOREIGN KEY (`id_upgrade`) REFERENCES `upgrade` (`id_upgrade`);

ALTER TABLE `upgrade_loadout` ADD FOREIGN KEY (`id_loadout`) REFERENCES `loadout` (`id_loadout`);
