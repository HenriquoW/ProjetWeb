#------------------------------------------------------------
#        Script MySQL.
#------------------------------------------------------------


#------------------------------------------------------------
# Table: Utilisateur
#------------------------------------------------------------

CREATE TABLE Utilisateur(
        Id_Utilisateur Numeric NOT NULL ,
        Nom            Varchar (25) ,
        Prenom         Varchar (25) ,
        DateNaissance  Date ,
        Adresse        Varchar (25) ,
        Mail           Varchar (25) ,
        Telephone      Varchar (25) ,
        Id_Sexe        Numeric ,
        PRIMARY KEY (Id_Utilisateur )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Adhérent
#------------------------------------------------------------

CREATE TABLE Adherent(
        Id_Adherent     Numeric NOT NULL ,
        NumeroLicence   Numeric ,
        DateInscription Date ,
        Id_Utilisateur  Numeric NOT NULL ,
        PRIMARY KEY (Id_Adherent ) ,
        UNIQUE (NumeroLicence )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Competiteur
#------------------------------------------------------------

CREATE TABLE Competiteur(
        Id_Competiteur Numeric NOT NULL ,
        Id_Adherent    Numeric NOT NULL ,
        Id_Specialite  Numeric ,
        Id_Objectif    Numeric ,
        Id_Categorie   Numeric ,
        PRIMARY KEY (Id_Competiteur )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Sexe
#------------------------------------------------------------

CREATE TABLE Sexe(
        Id_Sexe Numeric NOT NULL ,
        Type    Varchar (1) ,
        PRIMARY KEY (Id_Sexe ) ,
        UNIQUE (Type )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Specialite
#------------------------------------------------------------

CREATE TABLE Specialite(
        Id_Specialite Numeric NOT NULL ,
        Nom           Varchar (25) ,
        PRIMARY KEY (Id_Specialite ) ,
        UNIQUE (Nom )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Objectif
#------------------------------------------------------------

CREATE TABLE Objectif(
        Id_Objectif Numeric NOT NULL ,
        Type        Varchar (25) ,
        PRIMARY KEY (Id_Objectif )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Competition
#------------------------------------------------------------

CREATE TABLE Competition(
        Id_Competition      Numeric NOT NULL ,
        Lieu                Varchar (25) ,
        DateCompetition     Date ,
        Id_Sexe             Numeric ,
        Id_Type_Competition Numeric NOT NULL,
        Id_Categorie        Numeric NOT NULL,
        Id_Specialite       Numeric NOT NULL,
        Id_Club_Organisateur Numeric NOT NULL,
        PRIMARY KEY (Id_Competition )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Club_Organisateur
#------------------------------------------------------------

CREATE TABLE Club_Organisateur(
        ID_Club_Organisateur Numeric NOT NULL ,
        Nom                  Varchar (25) ,
        President            Varchar (25) ,
        PRIMARY KEY (ID_Club_Organisateur ) ,
        UNIQUE (Nom )
)ENGINE=InnoDB;

#------------------------------------------------------------
# Table: Categorie
#------------------------------------------------------------

CREATE TABLE Categorie(
        Id_Categorie Numeric NOT NULL ,
        Nom          Varchar (25) ,
        PRIMARY KEY (Id_Categorie ) ,
        UNIQUE (Nom )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Equipe
#------------------------------------------------------------

CREATE TABLE Equipe(
        Id_equipe Numeric NOT NULL ,
        PRIMARY KEY (Id_equipe )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Role
#------------------------------------------------------------

CREATE TABLE Role(
        Id_Role Numeric NOT NULL ,
        Titre   Varchar (25) ,
        PRIMARY KEY (Id_Role ) ,
        UNIQUE (Titre )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Message
#------------------------------------------------------------

CREATE TABLE Message(
        Id_Message Numeric NOT NULL ,
        Sujet      Varchar (100) ,
        Corps      Varchar (500) ,
        PRIMARY KEY (Id_Message )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Type_Competiion
#------------------------------------------------------------

CREATE TABLE Type_Competition(
        Id_Type_Competition Numeric NOT NULL ,
        Nom                 Varchar (25) ,
        Selectif            Bool ,
        PRIMARY KEY (Id_Type_Competition ) ,
        UNIQUE (Nom )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Palmares
#------------------------------------------------------------

CREATE TABLE Palmares(
        Id_Palmares    Numeric NOT NULL ,
        Classement     Numeric ,
        Id_Competition Numeric ,
        PRIMARY KEY (Id_Palmares )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Voyage
#------------------------------------------------------------

CREATE TABLE Voyage(
        Id_Voyage         Numeric NOT NULL ,
        Transport_Propose Varchar (25) ,
        Hebergement       Varchar (25) ,
        Id_Competition    Numeric ,
        PRIMARY KEY (Id_Voyage )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Type_Voyage
#------------------------------------------------------------

CREATE TABLE Type_Voyage(
        Id_Voyage Numeric NOT NULL ,
        Nom       Varchar (25) ,
        PRIMARY KEY (Id_Voyage )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Droit_Acces
#------------------------------------------------------------

CREATE TABLE Droit_Acces(
        Id_Droit_Acces Numeric NOT NULL ,
        Nom            Varchar (25) ,
        PRIMARY KEY (Id_Droit_Acces ) ,
        UNIQUE (Nom )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: ParticipeCompetitionEquipe
#------------------------------------------------------------

CREATE TABLE ParticipeCompetitionEquipe(
        Id_equipe      Numeric NOT NULL ,
        Id_Competition Numeric NOT NULL ,
        PRIMARY KEY (Id_equipe ,Id_Competition )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Participant_Equipe
#------------------------------------------------------------

CREATE TABLE Participant_Equipe(
        Id_Competiteur Numeric NOT NULL ,
        Id_equipe      Numeric NOT NULL ,
        PRIMARY KEY (Id_Competiteur ,Id_equipe )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Envoie
#------------------------------------------------------------

CREATE TABLE Envoie(
        Id_Utilisateur Numeric NOT NULL ,
        Id_Message     Numeric NOT NULL ,
        PRIMARY KEY (Id_Utilisateur ,Id_Message )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Recois
#------------------------------------------------------------

CREATE TABLE Recois(
        Id_Message     Numeric NOT NULL ,
        Id_Utilisateur Numeric NOT NULL ,
        PRIMARY KEY (Id_Message ,Id_Utilisateur )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Tache
#------------------------------------------------------------

CREATE TABLE Tache(
        Id_Tache Numeric NOT NULL ,
        Nom          Varchar (100) ,
        PRIMARY KEY (Id_Tache ) ,
        UNIQUE (Nom )
)ENGINE=InnoDB;

#------------------------------------------------------------
# Table: Charger
#------------------------------------------------------------

CREATE TABLE Charger(
        Id_Voyage      Numeric NOT NULL ,
        Id_Utilisateur Numeric NOT NULL ,
        Id_Role        Numeric ,
        Id_Tache       Numeric ,
        PRIMARY KEY (Id_Voyage ,Id_Utilisateur )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: ParticipeVoyage
#------------------------------------------------------------

CREATE TABLE ParticipeVoyage(
        Autoriser             Bool ,
        Id_Voyage             Numeric NOT NULL ,
        Id_Competiteur        Numeric NOT NULL ,
        Id_Voyage_Type_Voyage Numeric NOT NULL ,
        Id_Utilisateur        Numeric ,
        PRIMARY KEY (Id_Voyage ,Id_Competiteur ,Id_Voyage_Type_Voyage)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Palmares_Equipe
#------------------------------------------------------------

CREATE TABLE Palmares_Equipe(
        Id_equipe   Numeric NOT NULL ,
        Id_Palmares Numeric NOT NULL ,
        PRIMARY KEY (Id_equipe ,Id_Palmares )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Palmares_Competiteur
#------------------------------------------------------------

CREATE TABLE Palmares_Competiteur(
        Id_Competiteur Numeric NOT NULL ,
        Id_Palmares    Numeric NOT NULL ,
        PRIMARY KEY (Id_Competiteur ,Id_Palmares )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: ParticipeCompetitionSolo
#------------------------------------------------------------

CREATE TABLE ParticipeCompetitionSolo(
        Id_Competition Numeric NOT NULL ,
        Id_Competiteur Numeric NOT NULL ,
        PRIMARY KEY (Id_Competition ,Id_Competiteur )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Droits
#------------------------------------------------------------

CREATE TABLE Droits(
        Id_Droit_Acces Numeric NOT NULL ,
        Id_Adherent    Numeric NOT NULL ,
        PRIMARY KEY (Id_Droit_Acces ,Id_Adherent )
)ENGINE=InnoDB;

ALTER TABLE Utilisateur ADD CONSTRAINT FK_Utilisateur_Id_Sexe
FOREIGN KEY (Id_Sexe) REFERENCES Sexe(Id_Sexe);

ALTER TABLE Adherent ADD CONSTRAINT FK_Adherent_Id_Utilisateur
FOREIGN KEY (Id_Utilisateur) REFERENCES Utilisateur(Id_Utilisateur);

ALTER TABLE Competiteur ADD CONSTRAINT FK_Competiteur_Id_Adherent
FOREIGN KEY (Id_Adherent) REFERENCES Adherent(Id_Adherent);

ALTER TABLE Competiteur ADD CONSTRAINT FK_Competiteur_Id_Specialite
FOREIGN KEY (Id_Specialite) REFERENCES Specialite(Id_Specialite);

ALTER TABLE Competiteur ADD CONSTRAINT FK_Competiteur_Id_Objectif
FOREIGN KEY (Id_Objectif) REFERENCES Objectif(Id_Objectif);

ALTER TABLE Competiteur ADD CONSTRAINT FK_Competiteur_Id_Categorie
FOREIGN KEY (Id_Categorie) REFERENCES Categorie(Id_Categorie);

ALTER TABLE Competition ADD CONSTRAINT FK_Competition_Id_Sexe
FOREIGN KEY (Id_Sexe) REFERENCES Sexe(Id_Sexe);

ALTER TABLE Competition ADD CONSTRAINT FK_Competition_Id_Type_Competition
FOREIGN KEY (Id_Type_Competition) REFERENCES Type_Competition(Id_Type_Competition);

ALTER TABLE Competition ADD CONSTRAINT FK_Competition_Id_Categorie
FOREIGN KEY (Id_Categorie) REFERENCES Categorie(Id_Categorie);

ALTER TABLE Competition ADD CONSTRAINT FK_Competition_Id_Specialite
FOREIGN KEY (Id_Specialite) REFERENCES Specialite(Id_Specialite);

ALTER TABLE Competition ADD CONSTRAINT FK_Competition_Id_Club_Organisateur
FOREIGN KEY (Id_Club_Organisateur) REFERENCES Club_Organisateur(Id_Club_Organisateur);

ALTER TABLE Palmares ADD CONSTRAINT FK_Palmares_Id_Competition
FOREIGN KEY (Id_Competition) REFERENCES Competition(Id_Competition);

ALTER TABLE Voyage ADD CONSTRAINT FK_Voyage_Id_Competition
FOREIGN KEY (Id_Competition) REFERENCES Competition(Id_Competition);

ALTER TABLE ParticipeCompetitionEquipe ADD CONSTRAINT FK_ParticipeCompetitionEquipe_Id_equipe
FOREIGN KEY (Id_equipe) REFERENCES Equipe(Id_equipe);

ALTER TABLE ParticipeCompetitionEquipe ADD CONSTRAINT FK_ParticipeCompetitionEquipe_Id_Competition
FOREIGN KEY (Id_Competition) REFERENCES Competition(Id_Competition);

ALTER TABLE Participant_Equipe ADD CONSTRAINT FK_Participant_Equipe_Id_Competiteur
FOREIGN KEY (Id_Competiteur) REFERENCES Competiteur(Id_Competiteur);

ALTER TABLE Participant_Equipe ADD CONSTRAINT FK_Participant_Equipe_Id_equipe
FOREIGN KEY (Id_equipe) REFERENCES Equipe(Id_equipe);

ALTER TABLE Envoie ADD CONSTRAINT FK_Envoie_Id_Utilisateur
FOREIGN KEY (Id_Utilisateur) REFERENCES Utilisateur(Id_Utilisateur);

ALTER TABLE Envoie ADD CONSTRAINT FK_Envoie_Id_Message
FOREIGN KEY (Id_Message) REFERENCES Message(Id_Message);

ALTER TABLE Recois ADD CONSTRAINT FK_Recois_Id_Message
FOREIGN KEY (Id_Message) REFERENCES Message(Id_Message);

ALTER TABLE Recois ADD CONSTRAINT FK_Recois_Id_Utilisateur
FOREIGN KEY (Id_Utilisateur) REFERENCES Utilisateur(Id_Utilisateur);

ALTER TABLE Charger ADD CONSTRAINT FK_Charger_Id_Voyage
FOREIGN KEY (Id_Voyage) REFERENCES Voyage(Id_Voyage);

ALTER TABLE Charger ADD CONSTRAINT FK_Charger_Id_Utilisateur
FOREIGN KEY (Id_Utilisateur) REFERENCES Utilisateur(Id_Utilisateur);

ALTER TABLE Charger ADD CONSTRAINT FK_Charger_Id_Role
FOREIGN KEY (Id_Role) REFERENCES Role(Id_Role);

ALTER TABLE Charger ADD CONSTRAINT FK_Charger_Id_Tache
FOREIGN KEY (Id_Tache) REFERENCES Tache(Id_Tache);

ALTER TABLE ParticipeVoyage ADD CONSTRAINT FK_ParticipeVoyage_Id_Voyage
FOREIGN KEY (Id_Voyage) REFERENCES Voyage(Id_Voyage);

ALTER TABLE ParticipeVoyage ADD CONSTRAINT FK_ParticipeVoyage_Id_Competiteur
FOREIGN KEY (Id_Competiteur) REFERENCES Competiteur(Id_Competiteur);

ALTER TABLE ParticipeVoyage ADD CONSTRAINT FK_ParticipeVoyage_Id_Voyage_Type_Voyage
FOREIGN KEY (Id_Voyage_Type_Voyage) REFERENCES Type_Voyage(Id_Voyage);

ALTER TABLE ParticipeVoyage ADD CONSTRAINT FK_ParticipeVoyage_Id_Utilisateur
FOREIGN KEY (Id_Utilisateur) REFERENCES Utilisateur(Id_Utilisateur);

ALTER TABLE Palmares_Equipe ADD CONSTRAINT FK_Palmares_Equipe_Id_equipe
FOREIGN KEY (Id_equipe) REFERENCES Equipe(Id_equipe);

ALTER TABLE Palmares_Equipe ADD CONSTRAINT FK_Palmares_Equipe_Id_Palmares
FOREIGN KEY (Id_Palmares) REFERENCES Palmares(Id_Palmares);

ALTER TABLE Palmares_Competiteur ADD CONSTRAINT FK_Palmares_Competiteur_Id_Competiteur
FOREIGN KEY (Id_Competiteur) REFERENCES Competiteur(Id_Competiteur);

ALTER TABLE Palmares_Competiteur ADD CONSTRAINT FK_Palmares_Competiteur_Id_Palmares
FOREIGN KEY (Id_Palmares) REFERENCES Palmares(Id_Palmares);

ALTER TABLE ParticipeCompetitionSolo ADD CONSTRAINT FK_ParticipeCompetitionSolo_Id_Competition
FOREIGN KEY (Id_Competition) REFERENCES Competition(Id_Competition);

ALTER TABLE ParticipeCompetitionSolo ADD CONSTRAINT FK_ParticipeCompetitionSolo_Id_Competiteur
FOREIGN KEY (Id_Competiteur) REFERENCES Competiteur(Id_Competiteur);

ALTER TABLE Droits ADD CONSTRAINT FK_Droits_Id_Droit_Acces
FOREIGN KEY (Id_Droit_Acces) REFERENCES Droit_Acces(Id_Droit_Acces);

ALTER TABLE Droits ADD CONSTRAINT FK_Droits_Id_Adherent
FOREIGN KEY (Id_Adherent) REFERENCES Adherent(Id_Adherent);

#------------------------------------------------------------
# View: Uiilisateur
#------------------------------------------------------------
CREATE VIEW V_Utilisateur AS
SELECT Id_Utilisateur,Nom,Prenom,DateNaissance,Adresse,Mail,Telephone,Sexe.Type "Sexe"
FROM Utilisateur JOIN Sexe
ON Utilisateur.Id_Sexe = Sexe.Id_Sexe;

#------------------------------------------------------------
# View: Adherent
#------------------------------------------------------------
CREATE VIEW V_Adherent AS
SELECT Id_Adherent,V_Utilisateur.Nom,V_Utilisateur.Prenom,V_Utilisateur.DateNaissance,V_Utilisateur.Adresse,V_Utilisateur.Mail,V_Utilisateur.Telephone,V_Utilisateur.Sexe,NumeroLicence,DateInscription
FROM Adherent JOIN V_Utilisateur
ON Adherent.Id_Utilisateur = V_Utilisateur.Id_Utilisateur;

#------------------------------------------------------------
# View: Competiteur
#------------------------------------------------------------
CREATE VIEW V_Competiteur AS
SELECT Id_Competiteur,V_Adherent.Nom,V_Adherent.Prenom,V_Adherent.DateNaissance,V_Adherent.Adresse,V_Adherent.Mail,V_Adherent.Telephone,V_Adherent.Sexe,V_Adherent.NumeroLicence,V_Adherent.DateInscription, Specialite.Nom "Specialite", Categorie.Nom "Categorie", Objectif.Type "Objectif"
FROM Competiteur JOIN V_Adherent
ON Competiteur.Id_Adherent = V_Adherent.Id_Adherent
JOIN Specialite
ON Competiteur.Id_Specialite = Specialite.Id_Specialite
JOIN Categorie
ON Competiteur.Id_Categorie = Categorie.Id_Categorie
JOIN Objectif
ON Competiteur.Id_Objectif = Objectif.Id_Objectif;

#------------------------------------------------------------
# View: Competition
#------------------------------------------------------------
CREATE VIEW V_Competition AS
SELECT Id_Competition,Lieu,DateCompetition,Type_Competition.Nom "Nom",Type_Competition.Selectif,Sexe.Type "Restriction",Categorie.Nom "Categorie", Specialite.Nom "Specialite"
FROM Competition JOIN Type_Competition
ON Competition.Id_Type_Competition = Type_Competition.Id_Type_Competition
JOIN Sexe
ON Competition.Id_Sexe = Sexe.Id_Sexe
JOIN Categorie
ON Competition.Id_Categorie = Categorie.Id_Categorie
JOIN Specialite
ON Competition.Id_Specialite = Specialite.Id_Specialite;

#------------------------------------------------------------
# Insertion: Sexe
#------------------------------------------------------------
INSERT INTO Sexe VALUES(0,'M'),(1,'F'),(2,'O');

#------------------------------------------------------------
# Insertion: Specialite
#------------------------------------------------------------
INSERT INTO Specialite VALUES(0,"Canoe"),(1,"Kayak");

#------------------------------------------------------------
# Insertion: Categorie
#------------------------------------------------------------
INSERT INTO Categorie VALUES(0,"Minime"),(1,"Cadet"),(2,"Junior"),(3,"Senior"),(4,"Veteran");

#------------------------------------------------------------
# Insertion: Role
#------------------------------------------------------------
INSERT INTO Role VALUES(0,"Responsable officiel"),(1,"Juge"),(2,"Entraineur"),(3,"Benevole");

#------------------------------------------------------------
# Insertion: Tache
#------------------------------------------------------------
INSERT INTO Tache VALUES(0,"Reunion de confirmation des inscriptions"),(1,"Depot des reclamation"),(2,"Transport"),(3,"Gestion alimentation"),(4,"Gestion hebergement");

#------------------------------------------------------------
# Insertion: Droit_Acces
#------------------------------------------------------------
INSERT INTO Droit_Acces VALUES(0,"Administrateurs"),(1,"Entraineur"),(2,"Secretaire");

#------------------------------------------------------------
# Insertion: Type_Voyage
#------------------------------------------------------------
INSERT INTO Type_Voyage VALUES(0,"Club"),(1,"Autre");
