CREATE TABLE Messagerie(
   IdSession INT,
   Message VARCHAR(50),
   PRIMARY KEY(IdSession)
);

CREATE TABLE Visiteur(
   IdTemp VARCHAR(50),
   PRIMARY KEY(IdTemp)
);

CREATE TABLE Administrateur(
   IdAdm INT,
   NomAdm VARCHAR(50),
   PrenomAdm VARCHAR(50),
   PRIMARY KEY(IdAdm)
);

CREATE TABLE LaDate(
   Jour BYTE,
   Mois SMALLINT,
   Annee INT,
   Heure VARCHAR(50),
   PRIMARY KEY(Jour, Mois, Annee)
);

CREATE TABLE Calendrier(
   HeureDepart TIME,
   PRIMARY KEY(HeureDepart)
);

CREATE TABLE Jour(
   JourDépart DATE,
   JourArrivée DATE,
   Semaine INT,
   PRIMARY KEY(JourDépart, JourArrivée, Semaine)
);

CREATE TABLE Boutique(
   IdCadeau VARCHAR(50),
   NomCadeau VARCHAR(50),
   DescriptionCadeau VARCHAR(50),
   PointsNécessaires VARCHAR(50),
   PRIMARY KEY(IdCadeau)
);

CREATE TABLE Escale(
   IdLieu VARCHAR(50),
   NomRue VARCHAR(50),
   NumRue VARCHAR(50),
   CodePostal VARCHAR(50),
   Accessibilté VARCHAR(50),
   PRIMARY KEY(IdLieu)
);

CREATE TABLE Historique(
   IdHistorique VARCHAR(50),
   PRIMARY KEY(IdHistorique)
);

CREATE TABLE Utilisateur(
   IdUtilisateur INT,
   Mail VARCHAR(50),
   MotdePasse VARCHAR(50),
   NomUtilisateur VARCHAR(50),
   PrenomUtilisateur VARCHAR(50),
   NotePassager VARCHAR(50),
   LangueParlée1 VARCHAR(50),
   LangueParlée2 VARCHAR(50),
   Sexe LOGICAL,
   Tel INT,
   Fumeur VARCHAR(50),
   Handicap LOGICAL,
   Jour BYTE NOT NULL,
   Mois SMALLINT NOT NULL,
   Annee INT NOT NULL,
   PRIMARY KEY(IdUtilisateur),
   FOREIGN KEY(Jour, Mois, Annee) REFERENCES LaDate(Jour, Mois, Annee)
);

CREATE TABLE Conducteur(
   NumPermis VARCHAR(50),
   Points VARCHAR(50),
   NoteConducteur VARCHAR(50),
   IdUtilisateur INT NOT NULL,
   PRIMARY KEY(NumPermis),
   FOREIGN KEY(IdUtilisateur) REFERENCES Utilisateur(IdUtilisateur)
);

CREATE TABLE Voiture(
   Matricule VARCHAR(50),
   Marque VARCHAR(50),
   Modèle VARCHAR(50),
   Type VARCHAR(50),
   Couleur VARCHAR(50),
   NbPlace BYTE,
   Carburant VARCHAR(50),
   NumPermis VARCHAR(50) NOT NULL,
   PRIMARY KEY(Matricule),
   FOREIGN KEY(NumPermis) REFERENCES Conducteur(NumPermis)
);

CREATE TABLE Trajet(
   IdTrajet INT,
   VilleDepart VARCHAR(50),
   CodePostalDepart VARCHAR(50),
   NomRueDepart VARCHAR(50),
   NumRueDepart VARCHAR(50),
   VilleArrivée VARCHAR(50),
   CodePostalArrivée VARCHAR(50),
   NomRueArrivée VARCHAR(50),
   NumRueArrivée VARCHAR(50),
   CommentaireTrajetConducteur VARCHAR(50),
   PlaceDispo BYTE,
   Matricule VARCHAR(50) NOT NULL,
   NumPermis VARCHAR(50) NOT NULL,
   PRIMARY KEY(IdTrajet),
   FOREIGN KEY(Matricule) REFERENCES Voiture(Matricule),
   FOREIGN KEY(NumPermis) REFERENCES Conducteur(NumPermis)
);

CREATE TABLE Reservation(
   IdRes INT,
   Status VARCHAR(50),
   NumPermis VARCHAR(50),
   IdTrajet INT,
   PRIMARY KEY(IdRes),
   FOREIGN KEY(NumPermis) REFERENCES Conducteur(NumPermis),
   FOREIGN KEY(IdTrajet) REFERENCES Trajet(IdTrajet)
);

CREATE TABLE Envoyer(
   IdSession INT,
   IdUtilisateur INT,
   Jour BYTE,
   Mois SMALLINT,
   Annee INT,
   PRIMARY KEY(IdSession, IdUtilisateur, Jour, Mois, Annee),
   FOREIGN KEY(IdSession) REFERENCES Messagerie(IdSession),
   FOREIGN KEY(IdUtilisateur) REFERENCES Utilisateur(IdUtilisateur),
   FOREIGN KEY(Jour, Mois, Annee) REFERENCES LaDate(Jour, Mois, Annee)
);

CREATE TABLE Recevoir(
   IdSession INT,
   IdUtilisateur INT,
   Jour BYTE,
   Mois SMALLINT,
   Annee INT,
   PRIMARY KEY(IdSession, IdUtilisateur, Jour, Mois, Annee),
   FOREIGN KEY(IdSession) REFERENCES Messagerie(IdSession),
   FOREIGN KEY(IdUtilisateur) REFERENCES Utilisateur(IdUtilisateur),
   FOREIGN KEY(Jour, Mois, Annee) REFERENCES LaDate(Jour, Mois, Annee)
);

CREATE TABLE Supprimer(
   IdUtilisateur INT,
   IdAdm INT,
   Jour BYTE,
   Mois SMALLINT,
   Annee INT,
   PRIMARY KEY(IdUtilisateur, IdAdm, Jour, Mois, Annee),
   FOREIGN KEY(IdUtilisateur) REFERENCES Utilisateur(IdUtilisateur),
   FOREIGN KEY(IdAdm) REFERENCES Administrateur(IdAdm),
   FOREIGN KEY(Jour, Mois, Annee) REFERENCES LaDate(Jour, Mois, Annee)
);

CREATE TABLE Reserver(
   IdUtilisateur INT,
   IdRes INT,
   PRIMARY KEY(IdUtilisateur, IdRes),
   FOREIGN KEY(IdUtilisateur) REFERENCES Utilisateur(IdUtilisateur),
   FOREIGN KEY(IdRes) REFERENCES Reservation(IdRes)
);

CREATE TABLE AnnulerR(
   IdUtilisateur INT,
   IdRes INT,
   PRIMARY KEY(IdUtilisateur, IdRes),
   FOREIGN KEY(IdUtilisateur) REFERENCES Utilisateur(IdUtilisateur),
   FOREIGN KEY(IdRes) REFERENCES Reservation(IdRes)
);

CREATE TABLE Rechercher(
   IdUtilisateur INT,
   IdTemp VARCHAR(50),
   IdTrajet INT,
   PRIMARY KEY(IdUtilisateur, IdTemp, IdTrajet),
   FOREIGN KEY(IdUtilisateur) REFERENCES Utilisateur(IdUtilisateur),
   FOREIGN KEY(IdTemp) REFERENCES Visiteur(IdTemp),
   FOREIGN KEY(IdTrajet) REFERENCES Trajet(IdTrajet)
);

CREATE TABLE Départ(
   IdTrajet INT,
   HeureDepart TIME,
   JourDépart DATE,
   JourArrivée DATE,
   Semaine INT,
   HeureArrivee TIME,
   PRIMARY KEY(IdTrajet, HeureDepart, JourDépart, JourArrivée, Semaine),
   FOREIGN KEY(IdTrajet) REFERENCES Trajet(IdTrajet),
   FOREIGN KEY(HeureDepart) REFERENCES Calendrier(HeureDepart),
   FOREIGN KEY(JourDépart, JourArrivée, Semaine) REFERENCES Jour(JourDépart, JourArrivée, Semaine)
);

CREATE TABLE CommenterReservation(
   IdUtilisateur INT,
   IdRes INT,
   CommentairePassager VARCHAR(50),
   NoteTrajet BYTE,
   PRIMARY KEY(IdUtilisateur, IdRes),
   FOREIGN KEY(IdUtilisateur) REFERENCES Utilisateur(IdUtilisateur),
   FOREIGN KEY(IdRes) REFERENCES Reservation(IdRes)
);

CREATE TABLE MettreJour(
   IdUtilisateur INT,
   IdUtilisateur_1 INT,
   Jour BYTE,
   Mois SMALLINT,
   Annee INT,
   PRIMARY KEY(IdUtilisateur, IdUtilisateur_1, Jour, Mois, Annee),
   FOREIGN KEY(IdUtilisateur) REFERENCES Utilisateur(IdUtilisateur),
   FOREIGN KEY(IdUtilisateur_1) REFERENCES Utilisateur(IdUtilisateur),
   FOREIGN KEY(Jour, Mois, Annee) REFERENCES LaDate(Jour, Mois, Annee)
);

CREATE TABLE Interdire(
   IdAdm INT,
   Jour BYTE,
   Mois SMALLINT,
   Annee INT,
   NumPermis VARCHAR(50),
   PRIMARY KEY(IdAdm, Jour, Mois, Annee, NumPermis),
   FOREIGN KEY(IdAdm) REFERENCES Administrateur(IdAdm),
   FOREIGN KEY(Jour, Mois, Annee) REFERENCES LaDate(Jour, Mois, Annee),
   FOREIGN KEY(NumPermis) REFERENCES Conducteur(NumPermis)
);

CREATE TABLE AnnulerT(
   IdTrajet INT,
   NumPermis VARCHAR(50),
   PRIMARY KEY(IdTrajet, NumPermis),
   FOREIGN KEY(IdTrajet) REFERENCES Trajet(IdTrajet),
   FOREIGN KEY(NumPermis) REFERENCES Conducteur(NumPermis)
);

CREATE TABLE SeConnecter(
   IdUtilisateur INT,
   IdTemp VARCHAR(50),
   PRIMARY KEY(IdUtilisateur, IdTemp),
   FOREIGN KEY(IdUtilisateur) REFERENCES Utilisateur(IdUtilisateur),
   FOREIGN KEY(IdTemp) REFERENCES Visiteur(IdTemp)
);

CREATE TABLE Acheter(
   NumPermis VARCHAR(50),
   IdCadeau VARCHAR(50),
   PRIMARY KEY(NumPermis, IdCadeau),
   FOREIGN KEY(NumPermis) REFERENCES Conducteur(NumPermis),
   FOREIGN KEY(IdCadeau) REFERENCES Boutique(IdCadeau)
);

CREATE TABLE Contient(
   IdTrajet INT,
   IdLieu VARCHAR(50),
   PRIMARY KEY(IdTrajet, IdLieu),
   FOREIGN KEY(IdTrajet) REFERENCES Trajet(IdTrajet),
   FOREIGN KEY(IdLieu) REFERENCES Escale(IdLieu)
);

CREATE TABLE Consulter(
   NumPermis VARCHAR(50),
   IdCadeau VARCHAR(50),
   PRIMARY KEY(NumPermis, IdCadeau),
   FOREIGN KEY(NumPermis) REFERENCES Conducteur(NumPermis),
   FOREIGN KEY(IdCadeau) REFERENCES Boutique(IdCadeau)
);

CREATE TABLE CommenterPassager(
   IdRes INT,
   NumPermis VARCHAR(50),
   CommentaireConducteur VARCHAR(50),
   NoteReservation VARCHAR(50),
   PRIMARY KEY(IdRes, NumPermis),
   FOREIGN KEY(IdRes) REFERENCES Reservation(IdRes),
   FOREIGN KEY(NumPermis) REFERENCES Conducteur(NumPermis)
);

CREATE TABLE Voir(
   IdUtilisateur INT,
   IdHistorique VARCHAR(50),
   PRIMARY KEY(IdUtilisateur, IdHistorique),
   FOREIGN KEY(IdUtilisateur) REFERENCES Utilisateur(IdUtilisateur),
   FOREIGN KEY(IdHistorique) REFERENCES Historique(IdHistorique)
);
