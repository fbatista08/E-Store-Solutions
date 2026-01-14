ALTER TABLE `users`
ADD COLUMN `phone` VARCHAR(20) NULL AFTER `email`,
ADD COLUMN `cpf` VARCHAR(14) NULL AFTER `phone`,
ADD COLUMN `address` VARCHAR(255) NULL AFTER `password`,
ADD COLUMN `number` VARCHAR(10) NULL AFTER `address`,
ADD COLUMN `complement` VARCHAR(255) NULL AFTER `number`,
ADD COLUMN `neighborhood` VARCHAR(255) NULL AFTER `complement`,
ADD COLUMN `city` VARCHAR(255) NULL AFTER `neighborhood`,
ADD COLUMN `state` VARCHAR(2) NULL AFTER `city`,
ADD COLUMN `zip_code` VARCHAR(10) NULL AFTER `state`;

