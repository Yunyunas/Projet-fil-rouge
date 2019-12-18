DROP DATABASE IF EXISTS MLR1;

CREATE DATABASE IF NOT EXISTS MLR1;
ALTER DATABASE MLR1 CHARACTER SET utf8 COLLATE utf8_general_ci;
USE MLR1;

# -----------------------------------------------------------------------------
#       TABLE : PARAMETRE (création de la table paramètre)
# -----------------------------------------------------------------------------
# CREATE TABLE  Parametre
# (
#   duree_annonce VARCHAR (2) NOT NULL  
# ) ENGINE=INNODB DEFAULT CHARSET=utf8;
 
# -----------------------------------------------------------------------------
#       TABLE : IMAGE
# -----------------------------------------------------------------------------
# CREATE TABLE  Image
# (
#   id_image BIGINT (30) AUTO_INCREMENT NOT NULL ,
#   id_annonce BIGINT (50) NOT NULL  ,
#   HREF VARCHAR (650) NOT NULL  
#   , PRIMARY KEY (id_image) 
# ) ENGINE=INNODB DEFAULT CHARSET=utf8;
 
# -----------------------------------------------------------------------------
#       INDEX DE LA TABLE IMAGE
# -----------------------------------------------------------------------------
# CREATE INDEX I_FK_IMAGE_ANNONCE ON Image (id_annonce ASC);

# -----------------------------------------------------------------------------
#       TABLE : UTILISATEUR
# -----------------------------------------------------------------------------
CREATE TABLE  Utilisateur
 (
   id_utilisateur BIGINT (50) AUTO_INCREMENT NOT NULL  ,
   mdp_utilisateur VARCHAR (256) NOT NULL ,
   nom_utilisateur VARCHAR (20) NOT NULL  ,
   prenom_utilisateur VARCHAR (20) NOT NULL  ,
   mail_utilisateur VARCHAR (32) UNIQUE NOT NULL  ,
   admin TINYINT NOT NULL  
   , PRIMARY KEY (id_utilisateur) 
 ) ENGINE=INNODB DEFAULT CHARSET=utf8;

# -----------------------------------------------------------------------------
#       TABLE : RUBRIQUE
# -----------------------------------------------------------------------------
CREATE TABLE  Rubrique
 (
   id_rubrique BIGINT (20) AUTO_INCREMENT NOT NULL  ,
   libelle_rubrique VARCHAR (30) UNIQUE NOT NULL  
#   url_image VARCHAR (650) NOT NULL
   , PRIMARY KEY (id_rubrique) 
 ) ENGINE=INNODB DEFAULT CHARSET=utf8;

# -----------------------------------------------------------------------------
#       TABLE : ANNONCE
# -----------------------------------------------------------------------------
CREATE TABLE  Annonce
 (
   id_annonce BIGINT (100) AUTO_INCREMENT NOT NULL ,
   id_utilisateur BIGINT (50) NOT NULL ,
   id_rubrique BIGINT (20) NOT NULL  ,
   en_tete_annonce VARCHAR (80) NOT NULL  ,
   corps_annonce VARCHAR (1000) NOT NULL  ,
   date_depot DATE NOT NULL  ,
   date_validite DATE NOT NULL 
   #url_image VARCHAR (650) NOT NULL
   , PRIMARY KEY (id_annonce)
 ) ENGINE=INNODB DEFAULT CHARSET=utf8;
 
# -----------------------------------------------------------------------------
#       INDEX DE LA TABLE ANNONCE
# -----------------------------------------------------------------------------
CREATE INDEX I_FK_ANNONCE_UTILISATEUR ON Annonce (id_utilisateur ASC);
CREATE INDEX I_FK_ANNONCE_RUBRIQUE ON Annonce (id_rubrique ASC);

# -----------------------------------------------------------------------------
#       CREATION DES REFERENCES DE TABLE
# -----------------------------------------------------------------------------

#ALTER TABLE Image 
#  ADD FOREIGN KEY FK_IMAGE_ANNONCE (id_annonce) REFERENCES Annonce (id_annonce) ;

ALTER TABLE Annonce 
  ADD FOREIGN KEY FK_ANNONCE_UTILISATEUR (id_utilisateur) REFERENCES Utilisateur (id_utilisateur) ;

ALTER TABLE Annonce 
  ADD FOREIGN KEY FK_ANNONCE_RUBRIQUE (id_rubrique) REFERENCES Rubrique (id_rubrique) ;
 
/* Stockage de la procédure pour afficher les annonce d'un utilisateur enfonction de son nom et de son prenom*/
DELIMITER |

CREATE PROCEDURE info_utilisateur (IN nom VARCHAR(20), IN prenom VARCHAR(20))
BEGIN
	SELECT nom_utilisateur, prenom utilisateur, libelle_rubrique, en_tete_annonce, corps_annonce
	FROM utilisateur
	INNER JOIN annonce ON annonce.id_utilisateur = utilisateur.id_utilisateur
	INNER JOIN rubrique ON rubrique.id_rubrique = annonce.id_rubrique
	WHERE nom_utilisateur = nom
	AND prenom_utilisateur = prenom;
END |

DELIMITER ;

/* création trigger pour date_depot et date_validite automatique*/
DELIMITER $$

	USE `MLR1`$$
	
CREATE
/*!50017 DEFINER = 'root'@'localhost' */
	TRIGGER `tr_annonce_insert` BEFORE INSERT ON `annonce`
FOR EACH ROW BEGIN
	IF (NEW.date_depot IS NULL) THEN
	SET NEW.date_depot = NOW();
END IF;
	IF (NEW.date_validite IS NULL) THEN
	SET NEW.date_validite = ADDDATE(CURDATE(), INTERVAL 21 DAY);
END IF;
END$$

DELIMITER ;


/* Trigger cryptage mdp auto*/
DELIMITER $$

USE mlr1$$

CREATE
 
    TRIGGER crypt_sha2 BEFORE INSERT ON utilisateur 
    FOR EACH ROW 
    SET new.mdp_utilisateur =SHA2(new.mdp_utilisateur, 256);
$$

DELIMITER ;

