# noodle2.0

DB aufsetzen:


-- Tabelle für Rezepte erstellen
CREATE TABLE rezepte (
    RezeptID INT AUTO_INCREMENT PRIMARY KEY,
    Name VARCHAR(255) NOT NULL,
    Zubereitungstext TEXT NOT NULL
);

-- Tabelle für die Zutaten erstellen
CREATE TABLE zutaten (
    ZutatID INT AUTO_INCREMENT PRIMARY KEY,
    Zutat VARCHAR(255) NOT NULL
);

-- Tabelle für die Beziehung zwischen Rezepten und Zutaten erstellen
CREATE TABLE rezept_zutat (
    RezeptID INT,
    ZutatID INT,
    FOREIGN KEY (RezeptID) REFERENCES rezepte(RezeptID),
    FOREIGN KEY (ZutatID) REFERENCES zutaten(ZutatID)
);

--Tabelle fuer Einkaufslistenitems
CREATE TABLE items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    item_name VARCHAR(255) NOT NULL,
    item_quantity INT NOT NULL
);
-- Tabelle fuer User
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL
);
