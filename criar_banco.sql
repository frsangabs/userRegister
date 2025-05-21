
CREATE DATABASE IF NOT EXISTS login_app;
USE login_app;

CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    login VARCHAR(50) UNIQUE NOT NULL,
    senha_hash VARCHAR(255) NOT NULL,
    tipo ENUM('adm', 'user') DEFAULT 'user'
);

INSERT INTO usuarios (login, senha_hash, tipo)
VALUES ('admin', 'admin123', '$2b$12$n645v/O40SfjQ9QTs7aRUul4N4CXpbiPdGAhsh4L3OR0QB8DXHHb2', 'adm');
