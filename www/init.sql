CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    firstname VARCHAR(100) NOT NULL,
    lastname VARCHAR(100) NOT NULL,
    phone VARCHAR(20),
    office VARCHAR(100),
    description TEXT,
    password VARCHAR(255) NOT NULL,
    role ENUM('User', 'Administrator') DEFAULT 'User'
);

INSERT INTO users (email, firstname, lastname, phone, office, description, password, role) VALUES
('admin@example.com', 'Jan', 'Novák', '+420777888999', 'A101', 'Hlavní správce systému', 'heslo', 'Administrator'),
('petra.dvorakova@example.com', 'Petra', 'Dvořáková', '+420777111222', 'B202', 'Marketing specialista', 'heslo', 'User'),
('tomas.svoboda@example.com', 'Tomáš', 'Svoboda', '+420777333444', 'C303', 'Vývojář', 'heslo', 'User'),
('jana.kolarova@example.com', 'Jana', 'Kolářová', '+420777555666', 'B205', 'HR manažer', 'heslo', 'User'),
('martin.horak@example.com', 'Martin', 'Horák', '+420777777888', 'A105', 'Účetní', 'heslo', 'User'),
('lucie.prochazkova@example.com', 'Lucie', 'Procházková', '+420777999000', 'C301', 'Projektový manažer', 'heslo', 'User'),
('david.kral@example.com', 'David', 'Král', '+420777123456', 'B201', 'Obchodní zástupce', 'heslo', 'User'),
('eva.maskova@example.com', 'Eva', 'Mašková', '+420777234567', 'A102', 'Asistentka', 'heslo', 'User'),
('jiri.vesely@example.com', 'Jiří', 'Veselý', '+420777345678', 'C304', 'Technik', 'heslo', 'User'),
('katerina.benesova@example.com', 'Kateřina', 'Benešová', '+420777456789', 'B203', 'Analytik', 'heslo', 'User');

