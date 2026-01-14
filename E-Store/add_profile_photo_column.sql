-- Adicionar coluna para foto de perfil na tabela users
ALTER TABLE `users` ADD COLUMN `profile_photo` VARCHAR(255) NULL AFTER `zip_code`;
