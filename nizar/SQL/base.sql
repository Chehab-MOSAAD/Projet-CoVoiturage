
--création de la table messagerie -- testé et c'est bon 
CREATE TABLE Messagerie (
    IdSession INT ,
    Message TEXT,
    PRIMARY KEY(IdSession)
);
--création de la table visiteur -- testé et c'est bon 

CREATE TABLE Visiteur(
   IdTemp VARCHAR(50),
   PRIMARY KEY(IdTemp)
);
--création de la table admin  -- testé et c'est bon 

CREATE TABLE Administrateur(
   IdAdm INT,
   NomAdm VARCHAR(50),
   PrenomAdm VARCHAR(50),
   PRIMARY KEY(IdAdm)
);

--la table Date-- testé et c'est bon 
CREATE TABLE LaDate(
    Jour INT CHECK (Jour BETWEEN 1 AND 31),
    Mois INT CHECK (Mois BETWEEN 1 AND 12),
    Annee INT CHECK (Annee > 0),
    Heure TIME ,
   PRIMARY KEY(Jour, Mois, Annee)
);
--la table Calendrier-- testé et c'est bon 

CREATE TABLE Calendrier(
   HeureDepart TIME,
   PRIMARY KEY(HeureDepart)
);

--la table jour -- testé et c'est bon 
CREATE TABLE Jour(
  JourDepart INT NOT NULL CHECK (JourDepart BETWEEN 1 AND 7),
   JourArrivee INT NOT NULL CHECK (JourArrivee BETWEEN 1 AND 7),
   Semaine INT NOT NULL CHECK (Semaine BETWEEN 1 AND 52),
   PRIMARY KEY(JourDepart, JourArrivee, Semaine)
);

--la table boutique -- testé et c'est bon 

CREATE TABLE Boutique(
   IdCadeau INT,
   NomCadeau VARCHAR(100),
   DescriptionCadeau TEXT,
   PointsNecessaires INT CHECK (PointsNecessaires >= 0),
   PRIMARY KEY(IdCadeau)
);
--la table Escale -- testé et c'est bon 

CREATE TABLE Escale(
   IdLieu VARCHAR(50),
   NomRue VARCHAR(100) NOT NULL CHECK (NomRue ~ '^[A-Za-z ]+$'),
    NumRue INT NOT NULL CHECK (NumRue BETWEEN 1 AND 9999),
    CodePostal VARCHAR(5) NOT NULL CHECK (CodePostal ~ '^\d{5}$'),
    Accessibilite BOOLEAN NOT NULL,
   PRIMARY KEY(IdLieu)
);
--la table Historique -- testé et c'est bon 

CREATE TABLE Historique(
   IdHistorique INT,
   PRIMARY KEY(IdHistorique)
);


--création de la table utilisateur --  testé et c'est bon

CREATE TABLE Utilisateur(
    IdUtilisateur SERIAL PRIMARY KEY,
    Mail VARCHAR(100) UNIQUE NOT NULL CHECK (Mail SIMILAR TO '%@%\.%'),  -- Utilisation de SIMILAR TO pour la vérification d'email
    MotDePasse VARCHAR(100) NOT NULL CHECK (MotDePasse ~ '.*[a-z]+.*' AND MotDePasse ~ '.*[A-Z]+.*'),
    Nom VARCHAR(100) NOT NULL CHECK (Nom ~ '^[A-Za-z]+$'),
    Prenom VARCHAR(100) NOT NULL CHECK (Prenom ~ '^[A-Za-z]+$'),
    Sexe CHAR(1) NOT NULL CHECK (Sexe IN ('M', 'F')),
    Tel VARCHAR(10) NOT NULL CHECK (length(Tel) = 10 AND Tel ~ '^[0-9]+$' AND Tel LIKE '0%'),  -- Ajustement à 10 chiffres pour Tel
    Handicap BOOLEAN NOT NULL,
    NotePassager INT CHECK (NotePassager BETWEEN 0 AND 5),
    LangueParle1 VARCHAR(50) NOT NULL CHECK (LangueParle1 ~ '^[A-Za-z]+$'),
    LangueParle2 VARCHAR(50) CHECK (LangueParle2 ~ '^[A-Za-z]*$'),
    Fumeur BOOLEAN NOT NULL,
    Jour INT NOT NULL CHECK (Jour BETWEEN 1 AND 31),
    Mois INT NOT NULL CHECK (Mois BETWEEN 1 AND 12),
    Annee INT NOT NULL CHECK (Annee > 0)
    -- FOREIGN KEY (Jour, Mois, Annee) REFERENCES LaDate(Jour, Mois, Annee)  -- Supposé que la table LaDate existe et est correctement définie
);


--création de la table conducteur --  testé et c'est bon

CREATE TABLE Conducteur(
   NumPermis VARCHAR(50) NOT NULL,
   Points INT CHECK (Points BETWEEN 0 AND 15),
   NoteConducteur FLOAT,
   IdUtilisateur INT NOT NULL,
   PRIMARY KEY(NumPermis),
   FOREIGN KEY(IdUtilisateur) REFERENCES Utilisateur(IdUtilisateur)
);

--création de la table voiture --  testé et c'est bon

CREATE TABLE Voiture(
   Matricule VARCHAR(50) CHECK (Matricule ~ '^[A-Z0-9]+$'),
   Marque VARCHAR(50) NOT NULL CHECK (Marque ~ '^[A-Za-z0-9 ]+$'),
   Modele VARCHAR(50) NOT NULL CHECK (Modele ~ '^[A-Za-z0-9 ]+$'),
   Type VARCHAR(50) NOT NULL CHECK (Type IN ('SUV', 'Berline', 'Compacte', 'Monospace')) ,
   Couleur VARCHAR(50)  NOT NULL CHECK (Couleur IN ('bleu', 'violet', 'rose', 'rouge', 'orange', 'jaune', 'vert', 'noir', 'marron', 'gris', 'aluminium', 'argent', 'blanc')),
   NbrPlace INT NOT NULL CHECK (NbrPlace > 0 AND NbrPlace <= 100),
   Carburant VARCHAR(50) NOT NULL CHECK (Carburant IN ('essence', 'diesel', 'éthanol', 'gaz', 'électrique', 'hybride')),
   NumPermis VARCHAR(50) NOT NULL,
   PRIMARY KEY(Matricule),
   FOREIGN KEY(NumPermis) REFERENCES Conducteur(NumPermis)
);
--création de la table trajet  --  testé et c'est bon

CREATE TABLE Trajet(
   IdTrajet INT,
   VilleDepart VARCHAR(100)NOT NULL CHECK (VilleDepart ~ '^[A-Za-z ]+$'),
   CodePostalDepart VARCHAR(10) NOT NULL CHECK (CodePostalDepart ~ '^\d{5}$'),
   NomRueDepart VARCHAR(50) NOT NULL CHECK (NomRueDepart ~ '^[A-Za-z ]+$'),
   NumRueDepart INT NOT NULL CHECK (NumRueDepart BETWEEN 1 AND 9999),
   VilleArrivee VARCHAR(100) NOT NULL CHECK (VilleArrivee ~ '^[A-Za-z ]+$'),
   CodePostalArrivee VARCHAR(5) NOT NULL CHECK (CodePostalArrivee ~ '^\d{5}$'),
   NomRueArrivee VARCHAR(50) NOT NULL CHECK (NomRueArrivee ~ '^[A-Za-z ]+$'),
   NumRueArrivee INT NOT NULL CHECK (NumRueArrivee BETWEEN 1 AND 9999),
   CommentaireTrajetConducteur TEXT,
   PlaceDispo INT CHECK (PlaceDispo > 0 ),
   Matricule VARCHAR(50) NOT NULL,
   NumPermis VARCHAR(50) NOT NULL,
   PRIMARY KEY(IdTrajet),
   FOREIGN KEY(Matricule) REFERENCES Voiture(Matricule),
   FOREIGN KEY(NumPermis) REFERENCES Conducteur(NumPermis)
);
--création de la table Reservation  --  testé et c'est bon

CREATE TABLE Reservation(
   IdRes INT,
   Status VARCHAR(50),
   NumPermis VARCHAR(50),
   IdTrajet INT,
   PRIMARY KEY(IdRes),
   FOREIGN KEY(NumPermis) REFERENCES Conducteur(NumPermis),
   FOREIGN KEY(IdTrajet) REFERENCES Trajet(IdTrajet)
);
--création de la table envoyer  --  testé et c'est bon

CREATE TABLE Envoyer(
   IdSession INT,
   IdUtilisateur INT,
   Jour INT CHECK (Jour BETWEEN 1 AND 31) NOT NULL,
    Mois INT CHECK (Mois BETWEEN 1 AND 12) NOT NULL,
    Annee INT CHECK (Annee > 0) NOT NULL,
    PRIMARY KEY(IdSession, IdUtilisateur, Jour, Mois, Annee),
   FOREIGN KEY(IdSession) REFERENCES Messagerie(IdSession),
   FOREIGN KEY(IdUtilisateur) REFERENCES Utilisateur(IdUtilisateur),
   FOREIGN KEY(Jour, Mois, Annee) REFERENCES LaDate(Jour, Mois, Annee)
);
--création de la table recevoir  --  testé et c'est bon

CREATE TABLE Recevoir(
   IdSession INT,
   IdUtilisateur INT,
   Jour INT CHECK (Jour BETWEEN 1 AND 31) NOT NULL,
    Mois INT CHECK (Mois BETWEEN 1 AND 12) NOT NULL,
    Annee INT CHECK (Annee > 0) NOT NULL,
   PRIMARY KEY(IdSession, IdUtilisateur, Jour, Mois, Annee),
   FOREIGN KEY(IdSession) REFERENCES Messagerie(IdSession),
   FOREIGN KEY(IdUtilisateur) REFERENCES Utilisateur(IdUtilisateur),
   FOREIGN KEY(Jour, Mois, Annee) REFERENCES LaDate(Jour, Mois, Annee)
);
--création de la table supprimer  --  testé et c'est bon

CREATE TABLE Supprimer(
   IdUtilisateur INT,
   IdAdm INT,
   Jour INT CHECK (Jour BETWEEN 1 AND 31) NOT NULL,
    Mois INT CHECK (Mois BETWEEN 1 AND 12) NOT NULL,
    Annee INT CHECK (Annee > 0) NOT NULL,
   PRIMARY KEY(IdUtilisateur, IdAdm, Jour, Mois, Annee),
   FOREIGN KEY(IdUtilisateur) REFERENCES Utilisateur(IdUtilisateur),
   FOREIGN KEY(IdAdm) REFERENCES Administrateur(IdAdm),
   FOREIGN KEY(Jour, Mois, Annee) REFERENCES LaDate(Jour, Mois, Annee)
);
--création de la table reserver  --  testé et c'est bon

CREATE TABLE Reserver(
   IdUtilisateur INT,
   IdRes INT,
   PRIMARY KEY(IdUtilisateur, IdRes),
   FOREIGN KEY(IdUtilisateur) REFERENCES Utilisateur(IdUtilisateur),
   FOREIGN KEY(IdRes) REFERENCES Reservation(IdRes)
);
--création de la table annulerR  --  testé et c'est bon

CREATE TABLE AnnulerR(
   IdUtilisateur INT,
   IdRes INT,
   PRIMARY KEY(IdUtilisateur, IdRes),
   FOREIGN KEY(IdUtilisateur) REFERENCES Utilisateur(IdUtilisateur),
   FOREIGN KEY(IdRes) REFERENCES Reservation(IdRes)
);
--création de la table rerchercher  --  testé et c'est bon
CREATE TABLE Rechercher(
   IdUtilisateur INT,
   IdTemp VARCHAR(50),
   IdTrajet INT,
   PRIMARY KEY(IdUtilisateur, IdTemp, IdTrajet),
   FOREIGN KEY(IdUtilisateur) REFERENCES Utilisateur(IdUtilisateur),
   FOREIGN KEY(IdTemp) REFERENCES Visiteur(IdTemp),
   FOREIGN KEY(IdTrajet) REFERENCES Trajet(IdTrajet)
);
--création de la table départ   --  testé et c'est bon

CREATE TABLE Départ(
   IdTrajet INT,

   JourDepart INT NOT NULL CHECK (JourDepart BETWEEN 1 AND 7),
    JourArrivee INT NOT NULL CHECK (JourArrivee BETWEEN 1 AND 7),
    Semaine INT NOT NULL CHECK (Semaine BETWEEN 1 AND 52),
   HeureDepart TIME,
   HeureArrivee TIME,
   
   PRIMARY KEY(IdTrajet, HeureDepart, JourDepart, JourArrivee, Semaine),
   FOREIGN KEY(IdTrajet) REFERENCES Trajet(IdTrajet),
   FOREIGN KEY(HeureDepart) REFERENCES Calendrier(HeureDepart),
   FOREIGN KEY(JourDepart, JourArrivee, Semaine) REFERENCES Jour(JourDepart, JourArrivee, Semaine)
);

--création de la table CommenterReservation   --  testé et c'est bon
CREATE TABLE CommenterReservation(
   IdUtilisateur INT,
   IdRes INT,
   CommentairePassager TEXT,
   NoteTrajet INT CHECK (NoteTrajet BETWEEN 0 AND 5),
   PRIMARY KEY(IdUtilisateur, IdRes),
   FOREIGN KEY(IdUtilisateur) REFERENCES Utilisateur(IdUtilisateur),
   FOREIGN KEY(IdRes) REFERENCES Reservation(IdRes)
);

--création de la table MettreJour--  testé et c'est bon

CREATE TABLE MettreJour(
   IdUtilisateur INT,
   IdUtilisateur_1 INT,
   Jour INT CHECK (Jour BETWEEN 1 AND 31) NOT NULL,
    Mois INT CHECK (Mois BETWEEN 1 AND 12) NOT NULL,
    Annee INT CHECK (Annee > 0) NOT NULL,
   PRIMARY KEY(IdUtilisateur, IdUtilisateur_1, Jour, Mois, Annee),
   FOREIGN KEY(IdUtilisateur) REFERENCES Utilisateur(IdUtilisateur),
   FOREIGN KEY(IdUtilisateur_1) REFERENCES Utilisateur(IdUtilisateur),
   FOREIGN KEY(Jour, Mois, Annee) REFERENCES LaDate(Jour, Mois, Annee)
);

--création de la table Interdire --  testé et c'est bon

CREATE TABLE Interdire(
   IdAdm INT,
   Jour INT CHECK (Jour BETWEEN 1 AND 31) NOT NULL,
    Mois INT CHECK (Mois BETWEEN 1 AND 12) NOT NULL,
    Annee INT CHECK (Annee > 0) NOT NULL,
   NumPermis VARCHAR(50),
   PRIMARY KEY(IdAdm, Jour, Mois, Annee, NumPermis),
   FOREIGN KEY(IdAdm) REFERENCES Administrateur(IdAdm),
   FOREIGN KEY(Jour, Mois, Annee) REFERENCES LaDate(Jour, Mois, Annee),
   FOREIGN KEY(NumPermis) REFERENCES Conducteur(NumPermis)
);
--création de la table AnnulerT --  testé et c'est bon

CREATE TABLE AnnulerT(
   IdTrajet INT,
   NumPermis VARCHAR(50),
   PRIMARY KEY(IdTrajet, NumPermis),
   FOREIGN KEY(IdTrajet) REFERENCES Trajet(IdTrajet),
   FOREIGN KEY(NumPermis) REFERENCES Conducteur(NumPermis)
);
--création de la table seConnecter --  testé et c'est bon

CREATE TABLE SeConnecter(
   IdUtilisateur INT,
   IdTemp VARCHAR(50),
   PRIMARY KEY(IdUtilisateur, IdTemp),
   FOREIGN KEY(IdUtilisateur) REFERENCES Utilisateur(IdUtilisateur),
   FOREIGN KEY(IdTemp) REFERENCES Visiteur(IdTemp)
);
--création de la table acheter --  testé et c'est bon

CREATE TABLE Acheter(
   NumPermis VARCHAR(50),
   IdCadeau INT,
   PRIMARY KEY(NumPermis, IdCadeau),
   FOREIGN KEY(NumPermis) REFERENCES Conducteur(NumPermis),
   FOREIGN KEY(IdCadeau) REFERENCES Boutique(IdCadeau)
);
--création de la table Contient --  testé et c'est bon


CREATE TABLE Contient(
   IdTrajet INT,
   IdLieu VARCHAR(50),
   PRIMARY KEY(IdTrajet, IdLieu),
   FOREIGN KEY(IdTrajet) REFERENCES Trajet(IdTrajet),
   FOREIGN KEY(IdLieu) REFERENCES Escale(IdLieu)
);
--création de la table Consulter --  testé et c'est bon

CREATE TABLE Consulter(
   NumPermis VARCHAR(50),
   IdCadeau INT,
   PRIMARY KEY(NumPermis, IdCadeau),
   FOREIGN KEY(NumPermis) REFERENCES Conducteur(NumPermis),
   FOREIGN KEY(IdCadeau) REFERENCES Boutique(IdCadeau)
);
--création de la table CcommenterPassager --  testé et c'est bon

CREATE TABLE CommenterPassager(
   IdRes INT,
   NumPermis VARCHAR(50),
    CommentaireConducteur TEXT,
    NoteReservation INT,
   PRIMARY KEY(IdRes, NumPermis),
   FOREIGN KEY(IdRes) REFERENCES Reservation(IdRes),
   FOREIGN KEY(NumPermis) REFERENCES Conducteur(NumPermis)
);
--création de la table Voir --  testé et c'est bon
CREATE TABLE Voir(
   IdUtilisateur INT,
   IdHistorique INT,
   PRIMARY KEY(IdUtilisateur, IdHistorique),
   FOREIGN KEY(IdUtilisateur) REFERENCES Utilisateur(IdUtilisateur),
   FOREIGN KEY(IdHistorique) REFERENCES Historique(IdHistorique)
);


--insertion -- 

INSERT INTO LaDate (Jour, Mois, Annee)
VALUES
(1, 1, 1990),
(2, 2, 1992),
(1, 1, 2020),
(15, 5, 2021),
(23, 8, 2021),
(5, 12, 2021),
(1, 1, 2022),
(22, 3, 2022),
(30, 6, 2022),
(15, 11, 2022),
(10, 2, 2023),
(25, 7, 2023);
 

INSERT INTO Utilisateur (IdUtilisateur, Mail, MotDePasse, Nom, Prenom, Sexe, Tel, Handicap, NotePassager, LangueParle1, LangueParle2, Fumeur, Jour, Mois, Annee)
VALUES
(302, 'marieChimie@gmail.com', 'mARie66:', 'Curie', 'Marie', 'F', '0637868945', FALSE, 4, 'Russe', 'Anglais', FALSE, 1, 1, 1990),
(303, 'nizarslamas@gmail.com', 'Nizar7!', 'Slama', 'Nizar', 'M', '0487785210', FALSE, 5, 'Arabe', 'Italien', FALSE, 2, 2, 1992);


INSERT INTO Conducteur (NumPermis, Points, NoteConducteur, IdUtilisateur) VALUES
('PERMIS123', 12, 4.5, 302), 
('PERMIS456', 15, 4.7, 303); 

INSERT INTO Voiture (Matricule, Marque, Modele, Type, NbrPlace, Carburant, Couleur, NumPermis) VALUES
('AB123CD', 'Renault', 'Clio', 'Berline', 5, 'essence', 'rouge', 'PERMIS123'),
('EF456GH', 'Peugeot', '208', 'Compacte', 4, 'diesel', 'aluminium', 'PERMIS456');


INSERT INTO Trajet (IdTrajet, VilleDepart, CodePostalDepart, NomRueDepart, NumRueDepart, VilleArrivee, CodePostalArrivee, NomRueArrivee, NumRueArrivee, CommentaireTrajetConducteur, PlaceDispo, Matricule, NumPermis) VALUES
(801, 'Paris', '75001', 'Rue de Rivoli', 58, 'Lyon', '69002', 'Rue de la Republique', 1, 'Départ matinal, covoiturage convivial', 3, 'AB123CD', 'PERMIS123'),
(802, 'Marseille', '13002', 'Quai du Port', 17, 'Nice', '06000', 'Ave Jean Medecin', 2, 'Préférence non-fumeur, déplacement professionnel', 2, 'EF456GH', 'PERMIS456');


INSERT INTO Reservation (IdRes, Status, NumPermis, IdTrajet) VALUES
(901, 'Confirmed', 'PERMIS123', 801),
(902, 'Not_Confirmed', 'PERMIS456', 802);

INSERT INTO Reserver (IdUtilisateur, IdRes) VALUES
(302, 901),
(303, 902);

INSERT INTO CommenterReservation (IdRes, IdUtilisateur, CommentairePassager, NoteTrajet) VALUES
(901, 302, 'La conduite était un peu rapide à mon goût.', 3),
(902, 303, 'Conducteur sympathique et voiture confortable.', 4);

INSERT INTO Calendrier (HeureDepart) VALUES
('08:00:00'),
('08:30:00'),
('09:00:00'),
('09:30:00'),
('10:00:00'),
('10:30:00'),
('11:00:00'),
('11:30:00'),
('12:00:00'),
('12:30:00'),
('13:00:00'),
('13:30:00'),
('14:00:00'),
('14:30:00'),
('15:00:00');


INSERT INTO Jour (JourDepart, JourArrivee, Semaine) VALUES
(1, 2, 1),  
(3, 4, 10);

INSERT INTO Départ (IdTrajet, JourDepart, JourArrivee, Semaine, HeureDepart, HeureArrivee) VALUES
(801, 1, 2, 1, '08:00:00', '10:00:00'),
(802, 3, 4, 10, '09:00:00', '11:00:00');


INSERT INTO Messagerie (IdSession, Message) VALUES
(901, 'Hello, je suis arrivé.'),
(902, 'Bonjour, je serai là dans 2 minutes');

INSERT INTO Envoyer (IdSession, IdUtilisateur, Jour, Mois, Annee) VALUES
(901, 302, 25, 7, 2023),
(902, 303, 10, 2, 2023);







------------------------------------------------------------------------------------------




-- Check if user exists (Example SQL, modify according to actual IDs and fields needed)
SELECT * FROM Utilisateur WHERE IdUtilisateur = 7;

-- If the user doesn't exist, insert the user (Uncomment and modify if needed)
-- INSERT INTO Utilisateur (IdUtilisateur, Mail, MotDePasse, ...) VALUES (7, 'email@example.com', 'Password123!', ...);

-- Add Conductors
INSERT INTO Conducteur (NumPermis, Points, NoteConducteur, IdUtilisateur) VALUES
('PERMIS789', 12, 4.8, 7),
('PERMIS890', 14, 4.9, 7);

-- Commit if using transactions (Uncomment if applicable)
-- COMMIT;

-- Adding Vehicles
INSERT INTO Voiture (Matricule, Marque, Modele, Type, Couleur, NbrPlace, Carburant, NumPermis) VALUES
('XX789YZ', 'Toyota', 'Yaris', 'Compacte', 'bleu', 4, 'hybride', 'PERMIS789'),
('ZZ890XY', 'Honda', 'Civic', 'Berline', 'gris', 5, 'électrique', 'PERMIS890');

-- Additional operations
-- COMMIT;  -- Uncomment if transactions are used


-- Adding Past Trajets
INSERT INTO Trajet (IdTrajet, VilleDepart, CodePostalDepart, NomRueDepart, NumRueDepart, 
                    VilleArrivee, CodePostalArrivee, NomRueArrivee, NumRueArrivee, 
                    CommentaireTrajetConducteur, PlaceDispo, Matricule, NumPermis)
VALUES
(860, 'Toulouse', '31000', 'Allees Jean Jaures', 10, 'Carcassonne', '11000', 'Rue de Verdun', 15, 
 'Trajet tranquille avec vue sur la campagne', 3, 'XX789YZ', 'PERMIS789'),
(861, 'Grenoble', '38000', 'Boulevard Gambetta', 25, 'Lyon', '69001', 'Rue de la Republique', 120, 
 'Retour rapide après un événement', 2, 'ZZ890XY', 'PERMIS890');

-- Adding Future Trajets
INSERT INTO Trajet (IdTrajet, VilleDepart, CodePostalDepart, NomRueDepart, NumRueDepart, 
                    VilleArrivee, CodePostalArrivee, NomRueArrivee, NumRueArrivee, 
                    CommentaireTrajetConducteur, PlaceDispo, Matricule, NumPermis)
VALUES
(862, 'Nice', '06000', 'Promenade des Anglais', 50, 'Marseille', '13001', 'La Canebiere', 100, 
 'Départ matinal pour éviter le trafic', 4, 'XX789YZ', 'PERMIS789'),
(863, 'Strasbourg', '67000', 'Place Kleber', 30, 'Colmar', '68000', 'Rue des Clefs', 45, 
 'Voyage agreable en soiree', 3, 'ZZ890XY', 'PERMIS890');

-- Creating Reservations for Past and Future Trajets
INSERT INTO Reservation (IdRes, Status, NumPermis, IdTrajet) VALUES
(1007, 'Completed', 'PERMIS789', 860),
(1008, 'Completed', 'PERMIS890', 861),
(1009, 'Confirmed', 'PERMIS789', 862),
(1010, 'Pending', 'PERMIS890', 863);

-- Linking User 7 to These Reservations
INSERT INTO Reserver (IdUtilisateur, IdRes) VALUES
(7, 1007),
(7, 1008),
(7, 1009),
(7, 1010);
