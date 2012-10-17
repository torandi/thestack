ALTER TABLE `purchases` CHANGE `resolved` `resolved` TIMESTAMP NULL DEFAULT NULL;
UPDATE `purchases` SET resolved=NULL;
