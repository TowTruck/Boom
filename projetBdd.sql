DROP DATABASE IF EXISTS PROJETWEB;

CREATE DATABASE IF NOT EXISTS PROJETWEB;
USE PROJETWEB;
# -----------------------------------------------------------------------------
#       TABLE : RANG
# -----------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS RANG
 (
   ID_RANG INTEGER(4) NOT NULL AUTO_INCREMENT ,
   NOM CHAR(255) NULL  ,
   LEVEL INTEGER(4) NULL  
   , PRIMARY KEY (ID_RANG) 
 ) 
 comment = "";

# -----------------------------------------------------------------------------
#       TABLE : QUESTIONS
# -----------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS QUESTIONS
 (
   ID_QUESTIONS INTEGER(4) NOT NULL AUTO_INCREMENT  ,
   ID_QCM INTEGER(4) NOT NULL  ,
   INTITULE VARCHAR(255) NULL  
   , PRIMARY KEY (ID_QUESTIONS) 
 ) 
 comment = "";

# -----------------------------------------------------------------------------
#       INDEX DE LA TABLE QUESTIONS
# -----------------------------------------------------------------------------


CREATE  INDEX I_FK_QUESTIONS_QCM
     ON QUESTIONS (ID_QCM ASC);

# -----------------------------------------------------------------------------
#       TABLE : GROUPE
# -----------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS GROUPE
 (
   ID_GROUPE INTEGER(4) NOT NULL AUTO_INCREMENT  ,
   ID_USERS INTEGER(4) NOT NULL  ,
   NOM CHAR(255) NULL  
   , PRIMARY KEY (ID_GROUPE) 
 ) 
 comment = "";

# -----------------------------------------------------------------------------
#       INDEX DE LA TABLE GROUPE
# -----------------------------------------------------------------------------


CREATE  INDEX I_FK_GROUPE_USERS
     ON GROUPE (ID_USERS ASC);

# -----------------------------------------------------------------------------
#       TABLE : REPONSES
# -----------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS REPONSES
 (
   ID_REPONSES INTEGER(4) NOT NULL AUTO_INCREMENT  ,
   ID_QUESTIONS INTEGER(4) NOT NULL  ,
   NOM CHAR(255) NULL  ,
   VALEUR BOOL NULL  
   , PRIMARY KEY (ID_REPONSES) 
 ) 
 comment = "";

# -----------------------------------------------------------------------------
#       INDEX DE LA TABLE REPONSES
# -----------------------------------------------------------------------------


CREATE  INDEX I_FK_REPONSES_QUESTIONS
     ON REPONSES (ID_QUESTIONS ASC);

# -----------------------------------------------------------------------------
#       TABLE : QCM
# -----------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS QCM
 (
   ID_QCM INTEGER(4) NOT NULL AUTO_INCREMENT  ,
   ID_THEME INTEGER(4)  ,
   ID_USERS INTEGER(4) NOT NULL  ,
   INTITULE CHAR(255) NULL  ,
   NOTE BOOL NULL  ,
   TYPES INTEGER(4)  
   , PRIMARY KEY (ID_QCM) 
 ) 
 comment = "";

# -----------------------------------------------------------------------------
#       INDEX DE LA TABLE QCM
# -----------------------------------------------------------------------------


CREATE  INDEX I_FK_QCM_THEME
     ON QCM (ID_THEME ASC);

CREATE  INDEX I_FK_QCM_USERS
     ON QCM (ID_USERS ASC);

# -----------------------------------------------------------------------------
#       TABLE : USERS
# -----------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS USERS
 (
   ID_USERS INTEGER(4) NOT NULL AUTO_INCREMENT  ,
   ID_RANG INTEGER(4) NOT NULL  ,
   LOGIN VARCHAR(255) NULL  ,
   NOM CHAR(255) NULL  ,
   PRENOM CHAR(255) NULL  ,
   MDP VARCHAR(255) NULL  ,
   VALIDE VARCHAR(255) NULL  ,
   MAIL VARCHAR(255) NULL  
   , PRIMARY KEY (ID_USERS) 
 ) 
 comment = "";

# -----------------------------------------------------------------------------
#       INDEX DE LA TABLE USERS
# -----------------------------------------------------------------------------


CREATE  INDEX I_FK_USERS_RANG
     ON USERS (ID_RANG ASC);

# -----------------------------------------------------------------------------
#       TABLE : THEME
# -----------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS THEME
 (
   ID_THEME INTEGER(4) NOT NULL AUTO_INCREMENT  ,
   NOM CHAR(255) NULL  
   , PRIMARY KEY (ID_THEME) 
 ) 
 comment = "";

# -----------------------------------------------------------------------------
#       TABLE : FONT_PARTIE
# -----------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS FONT_PARTIE
 (
   ID_USERS INTEGER(4) NOT NULL  ,
   ID_GROUPE INTEGER(4) NOT NULL  
   , PRIMARY KEY (ID_USERS,ID_GROUPE) 
 ) 
 comment = "";

# -----------------------------------------------------------------------------
#       INDEX DE LA TABLE FONT_PARTIE
# -----------------------------------------------------------------------------


CREATE  INDEX I_FK_FONT_PARTIE_USERS
     ON FONT_PARTIE (ID_USERS ASC);

CREATE  INDEX I_FK_FONT_PARTIE_GROUPE
     ON FONT_PARTIE (ID_GROUPE ASC);

# -----------------------------------------------------------------------------
#       TABLE : LIAISON
# -----------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS LIAISON
 (
   ID_QCM INTEGER(4) NOT NULL  ,
   ID_GROUPE INTEGER(4)   
   , PRIMARY KEY (ID_QCM,ID_GROUPE) 
 ) 
 comment = "";

# -----------------------------------------------------------------------------
#       INDEX DE LA TABLE LIAISON
# -----------------------------------------------------------------------------


CREATE  INDEX I_FK_LIAISON_QCM
     ON LIAISON (ID_QCM ASC);

CREATE  INDEX I_FK_LIAISON_GROUPE
     ON LIAISON (ID_GROUPE ASC);

# -----------------------------------------------------------------------------
#       TABLE : REPOND
# -----------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS REPOND
 (
   ID_USERS INTEGER(4) NOT NULL  ,
   ID_QCM INTEGER(4) NOT NULL ,
   NOTE INTEGER(4) NOT NULL 
   , PRIMARY KEY (ID_USERS,ID_QCM) 
 ) 
 comment = "";

# -----------------------------------------------------------------------------
#       INDEX DE LA TABLE REPOND
# -----------------------------------------------------------------------------


CREATE  INDEX I_FK_REPOND_USERS
     ON REPOND (ID_USERS ASC);

CREATE  INDEX I_FK_REPOND_QCM
     ON REPOND (ID_QCM ASC);


# -----------------------------------------------------------------------------
#       CREATION DES REFERENCES DE TABLE
# -----------------------------------------------------------------------------


ALTER TABLE QUESTIONS 
  ADD FOREIGN KEY FK_QUESTIONS_QCM (ID_QCM)
      REFERENCES QCM (ID_QCM) ;


ALTER TABLE GROUPE 
  ADD FOREIGN KEY FK_GROUPE_USERS (ID_USERS)
      REFERENCES USERS (ID_USERS) ;


ALTER TABLE REPONSES 
  ADD FOREIGN KEY FK_REPONSES_QUESTIONS (ID_QUESTIONS)
      REFERENCES QUESTIONS (ID_QUESTIONS) ;


ALTER TABLE QCM 
  ADD FOREIGN KEY FK_QCM_THEME (ID_THEME)
      REFERENCES THEME (ID_THEME) ;


ALTER TABLE QCM 
  ADD FOREIGN KEY FK_QCM_USERS (ID_USERS)
      REFERENCES USERS (ID_USERS) ;


ALTER TABLE USERS 
  ADD FOREIGN KEY FK_USERS_RANG (ID_RANG)
      REFERENCES RANG (ID_RANG) ;


ALTER TABLE FONT_PARTIE 
  ADD FOREIGN KEY FK_FONT_PARTIE_USERS (ID_USERS)
      REFERENCES USERS (ID_USERS) ;


ALTER TABLE FONT_PARTIE 
  ADD FOREIGN KEY FK_FONT_PARTIE_GROUPE (ID_GROUPE)
      REFERENCES GROUPE (ID_GROUPE) ;


ALTER TABLE LIAISON 
  ADD FOREIGN KEY FK_LIAISON_QCM (ID_QCM)
      REFERENCES QCM (ID_QCM) ;


ALTER TABLE LIAISON 
  ADD FOREIGN KEY FK_LIAISON_GROUPE (ID_GROUPE)
      REFERENCES GROUPE (ID_GROUPE) ;


ALTER TABLE REPOND 
  ADD FOREIGN KEY FK_REPOND_USERS (ID_USERS)
      REFERENCES USERS (ID_USERS) ;


ALTER TABLE REPOND 
  ADD FOREIGN KEY FK_REPOND_QCM (ID_QCM)
      REFERENCES QCM (ID_QCM) ;

