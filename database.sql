-- =============================================
--  AutoPark — Script de création de la base
-- =============================================

CREATE DATABASE IF NOT EXISTS db_voiture
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE db_voiture;

CREATE TABLE IF NOT EXISTS voiture (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    marque      VARCHAR(100)  NOT NULL,
    modele      VARCHAR(100)  NOT NULL,
    annee       YEAR          NOT NULL,
    couleur     VARCHAR(50),
    carburant   ENUM('Essence','Diesel','Électrique','Hybride','GPL') DEFAULT 'Essence',
    kilometrage INT UNSIGNED  DEFAULT 0,
    prix        DECIMAL(10,2) NOT NULL,
    description TEXT,
    image       VARCHAR(255),
    created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Données de test
INSERT INTO voiture (marque, modele, annee, couleur, carburant, kilometrage, prix, description) VALUES
('Renault', 'Clio',      2020, 'Blanc',    'Essence',     45000, 12500.00, 'Très bon état, entretien à jour.'),
('Peugeot', '308',       2019, 'Gris',     'Diesel',      62000, 14800.00, 'Finition Allure, toit panoramique.'),
('Toyota',  'Corolla',   2022, 'Bleu',     'Hybride',     18000, 22000.00, 'Hybride, économique et fiable.'),
('BMW',     'Série 3',   2021, 'Noir',     'Essence',     30000, 38500.00, 'Pack M Sport, intérieur cuir.'),
('Tesla',   'Model 3',   2023, 'Rouge',    'Électrique',   8000, 45000.00, 'Autopilot, autonomie 500 km.');
