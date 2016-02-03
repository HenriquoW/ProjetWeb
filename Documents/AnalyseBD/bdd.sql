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
        Id_Utilisateur  Numeric ,
        PRIMARY KEY (Id_Adherent ) ,
        UNIQUE (NumeroLicence )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Competiteur
#------------------------------------------------------------

CREATE TABLE Competiteur(
        Id_Competiteur Numeric NOT NULL ,
        Id_Adherent    Numeric ,
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
        PRIMARY KEY (Id_Specialite )
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
        Nom                 Varchar (25) ,
        Lieu                Varchar (25) ,
        Annee               Date ,
        Id_Sexe             Numeric ,
        Id_Type_Competition Numeric ,
        PRIMARY KEY (Id_Competition )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Categorie
#------------------------------------------------------------

CREATE TABLE Categorie(
        Id_Categorie Numeric NOT NULL ,
        Nom          Varchar (25) ,
        PRIMARY KEY (Id_Categorie )
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
        Id_Role        Numeric NOT NULL ,
        Titre          Varchar (25) ,
        Id_Utilisateur Numeric ,
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

CREATE TABLE Type_Competiion(
        Id_Type_Competition Numeric NOT NULL ,
        Nom                 Varchar (25) ,
        Selectif            Bool ,
        PRIMARY KEY (Id_Type_Competition )
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
        Id_Voyage      Numeric NOT NULL ,
        Id_Competition Numeric ,
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
# Table: Charger
#------------------------------------------------------------

CREATE TABLE Charger(
        Id_Voyage      Numeric NOT NULL ,
        Id_Utilisateur Numeric NOT NULL ,
        Id_Role        Numeric NOT NULL ,
        PRIMARY KEY (Id_Voyage ,Id_Utilisateur ,Id_Role )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: ParticipeVoyage
#------------------------------------------------------------

CREATE TABLE ParticipeVoyage(
        Autoriser             Bool ,
        Id_Voyage             Numeric NOT NULL ,
        Id_Competiteur        Numeric NOT NULL ,
        Id_Voyage_Type_Voyage Numeric NOT NULL ,
        Id_Utilisateur        Numeric NOT NULL ,
        PRIMARY KEY (Id_Voyage ,Id_Competiteur ,Id_Voyage_Type_Voyage ,Id_Utilisateur )
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

ALTER TABLE Utilisateur ADD CONSTRAINT FK_Utilisateur_Id_Sexe FOREIGN KEY (Id_Sexe) REFERENCES Sexe(Id_Sexe);
ALTER TABLE Adherent ADD CONSTRAINT FK_Adherent_Id_Utilisateur FOREIGN KEY (Id_Utilisateur) REFERENCES Utilisateur(Id_Utilisateur);
ALTER TABLE Competiteur ADD CONSTRAINT FK_Competiteur_Id_Adherent FOREIGN KEY (Id_Adherent) REFERENCES Adherent(Id_Adherent);
ALTER TABLE Competiteur ADD CONSTRAINT FK_Competiteur_Id_Specialite FOREIGN KEY (Id_Specialite) REFERENCES Specialite(Id_Specialite);
ALTER TABLE Competiteur ADD CONSTRAINT FK_Competiteur_Id_Objectif FOREIGN KEY (Id_Objectif) REFERENCES Objectif(Id_Objectif);
ALTER TABLE Competiteur ADD CONSTRAINT FK_Competiteur_Id_Categorie FOREIGN KEY (Id_Categorie) REFERENCES Categorie(Id_Categorie);
ALTER TABLE Competition ADD CONSTRAINT FK_Competition_Id_Sexe FOREIGN KEY (Id_Sexe) REFERENCES Sexe(Id_Sexe);
ALTER TABLE Competition ADD CONSTRAINT FK_Competition_Id_Type_Competition FOREIGN KEY (Id_Type_Competition) REFERENCES Type_Competiion(Id_Type_Competition);
ALTER TABLE Role ADD CONSTRAINT FK_Role_Id_Utilisateur FOREIGN KEY (Id_Utilisateur) REFERENCES Utilisateur(Id_Utilisateur);
ALTER TABLE Palmares ADD CONSTRAINT FK_Palmares_Id_Competition FOREIGN KEY (Id_Competition) REFERENCES Competition(Id_Competition);
ALTER TABLE Voyage ADD CONSTRAINT FK_Voyage_Id_Competition FOREIGN KEY (Id_Competition) REFERENCES Competition(Id_Competition);
ALTER TABLE ParticipeCompetitionEquipe ADD CONSTRAINT FK_ParticipeCompetitionEquipe_Id_equipe FOREIGN KEY (Id_equipe) REFERENCES Equipe(Id_equipe);
ALTER TABLE ParticipeCompetitionEquipe ADD CONSTRAINT FK_ParticipeCompetitionEquipe_Id_Competition FOREIGN KEY (Id_Competition) REFERENCES Competition(Id_Competition);
ALTER TABLE Participant_Equipe ADD CONSTRAINT FK_Participant_Equipe_Id_Competiteur FOREIGN KEY (Id_Competiteur) REFERENCES Competiteur(Id_Competiteur);
ALTER TABLE Participant_Equipe ADD CONSTRAINT FK_Participant_Equipe_Id_equipe FOREIGN KEY (Id_equipe) REFERENCES Equipe(Id_equipe);
ALTER TABLE Envoie ADD CONSTRAINT FK_Envoie_Id_Utilisateur FOREIGN KEY (Id_Utilisateur) REFERENCES Utilisateur(Id_Utilisateur);
ALTER TABLE Envoie ADD CONSTRAINT FK_Envoie_Id_Message FOREIGN KEY (Id_Message) REFERENCES Message(Id_Message);
ALTER TABLE Recois ADD CONSTRAINT FK_Recois_Id_Message FOREIGN KEY (Id_Message) REFERENCES Message(Id_Message);
ALTER TABLE Recois ADD CONSTRAINT FK_Recois_Id_Utilisateur FOREIGN KEY (Id_Utilisateur) REFERENCES Utilisateur(Id_Utilisateur);
ALTER TABLE Charger ADD CONSTRAINT FK_Charger_Id_Voyage FOREIGN KEY (Id_Voyage) REFERENCES Voyage(Id_Voyage);
ALTER TABLE Charger ADD CONSTRAINT FK_Charger_Id_Utilisateur FOREIGN KEY (Id_Utilisateur) REFERENCES Utilisateur(Id_Utilisateur);
ALTER TABLE Charger ADD CONSTRAINT FK_Charger_Id_Role FOREIGN KEY (Id_Role) REFERENCES Role(Id_Role);
ALTER TABLE ParticipeVoyage ADD CONSTRAINT FK_ParticipeVoyage_Id_Voyage FOREIGN KEY (Id_Voyage) REFERENCES Voyage(Id_Voyage);
ALTER TABLE ParticipeVoyage ADD CONSTRAINT FK_ParticipeVoyage_Id_Competiteur FOREIGN KEY (Id_Competiteur) REFERENCES Competiteur(Id_Competiteur);
ALTER TABLE ParticipeVoyage ADD CONSTRAINT FK_ParticipeVoyage_Id_Voyage_Type_Voyage FOREIGN KEY (Id_Voyage_Type_Voyage) REFERENCES Type_Voyage(Id_Voyage);
ALTER TABLE ParticipeVoyage ADD CONSTRAINT FK_ParticipeVoyage_Id_Utilisateur FOREIGN KEY (Id_Utilisateur) REFERENCES Utilisateur(Id_Utilisateur);
ALTER TABLE Palmares_Equipe ADD CONSTRAINT FK_Palmares_Equipe_Id_equipe FOREIGN KEY (Id_equipe) REFERENCES Equipe(Id_equipe);
ALTER TABLE Palmares_Equipe ADD CONSTRAINT FK_Palmares_Equipe_Id_Palmares FOREIGN KEY (Id_Palmares) REFERENCES Palmares(Id_Palmares);
ALTER TABLE Palmares_Competiteur ADD CONSTRAINT FK_Palmares_Competiteur_Id_Competiteur FOREIGN KEY (Id_Competiteur) REFERENCES Competiteur(Id_Competiteur);
ALTER TABLE Palmares_Competiteur ADD CONSTRAINT FK_Palmares_Competiteur_Id_Palmares FOREIGN KEY (Id_Palmares) REFERENCES Palmares(Id_Palmares);
ALTER TABLE ParticipeCompetitionSolo ADD CONSTRAINT FK_ParticipeCompetitionSolo_Id_Competition FOREIGN KEY (Id_Competition) REFERENCES Competition(Id_Competition);
ALTER TABLE ParticipeCompetitionSolo ADD CONSTRAINT FK_ParticipeCompetitionSolo_Id_Competiteur FOREIGN KEY (Id_Competiteur) REFERENCES Competiteur(Id_Competiteur);