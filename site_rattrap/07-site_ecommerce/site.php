CREATE DATABASE IF NOT EXISTS boutique ;

CREATE TABLE membre (
id_membre INT(3) NOT NULL auto_increment,
pseudo VARCHAR(20) NOT NULL,
mdp VARCHAR(250) NOT NULL,
nom VARCHAR(20) NOT NULL,
prenom VARCHAR(20) NOT NULL,
email VARCHAR(50) NOT NULL,
civilite ENUM('m','f') NOT NULL,
ville VARCHAR (20) NOT NULL,
code_postal INT (50) NOT NULL,
adresse VARCHAR (50) NOT NULL,
statut INT(1) NOT NULL,
PRIMARY KEY (id_membre)
) ENGINE=InnoDB ;

CREATE TABLE produit (
id_produit INT(3) NOT NULL auto_increment,
reference VARCHAR(20) NOT NULL,
categorie VARCHAR(20) NOT NULL,
titre VARCHAR(100) NOT NULL,
description TEXT NOT NULL,
couleur VARCHAR(20) NOT NULL,
taille VARCHAR(5) NOT NULL,
public ENUM ('m','f','mixte') NOT NULL,
photo VARCHAR (250) NOT NULL,
prix INT (3) NOT NULL,
stock INT(3) NOT NULL,
PRIMARY KEY (id_produit)
) ENGINE=InnoDB ;

CREATE TABLE commande (
id_commande INT(3) NOT NULL auto_increment,
id_membre INT(3) NOT NULL,
montant INT(3) NOT NULL,
date_enregistrement DATETIME, 
etat ENUM('en cours de traitement','envoyé','livré') NOT NULL,
PRIMARY KEY (id_commande)
) ENGINE=InnoDB ;

CREATE TABLE details_commande (
id_details_commande INT(3) NOT NULL auto_increment,
id_commande INT(3) NOT NULL,
id_produit INT(3) NOT NULL,
quantite INT(3),
prix INT(4) NOT NULL,
PRIMARY KEY (id_details_commande)
) ENGINE=InnoDB ;