# noinspection SqlNoDataSourceInspectionForFile

CREATE TABLE IF NOT EXISTS `tina4_integration` (
  `id` int PRIMARY KEY,
  `name` varchar(255),
  `meta_key` varchar(255),
  `meta_value` varchar(255),
  `link_key` varchar(255),
  `link_value` varchar(255)
);