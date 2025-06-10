CREATE DATABASE IF NOT EXISTS sistema;
USE sistema;

DROP TABLE IF EXISTS usuarios;

CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(50) UNIQUE NOT NULL,
    senha_hash VARCHAR(255) NOT NULL,
    tipo ENUM('admin', 'user') DEFAULT 'user'
);

-- Senha original: admin123
INSERT INTO usuarios (email, senha_hash, tipo)
VALUES (
    'admin@admin.com',
    '$2y$10$jx9XThCZsLvIlMisHr5CDuEiL6VwQWnbsgwTWTwSEnN65ZDP2Y7Y.',
    'admin'
);
