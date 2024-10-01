/*
	Nathan Guhéneuf-Le Brec - Septembre 2024
	Permet de créer une base de données
	Cette base de données est utilisée pour le projet Sport Track
*/

-- ============================================================================= 
-- Propriétés de la base de données
-- ============================================================================= 
PRAGMA foreign_keys = ON;
PRAGMA encoding = 'UTF-8';

-- ============================================================================= 
-- Suppression des tables
-- ============================================================================= 
DROP TABLE IF EXISTS Data;
DROP TABLE IF EXISTS Activity;
DROP TABLE IF EXISTS User;

-- ============================================================================= 
-- Création des tables
-- ============================================================================= 
CREATE TABLE IF NOT EXISTS User (
	idUser INTEGER 
		CONSTRAINT pk_User PRIMARY KEY AUTOINCREMENT,
	emailUser TEXT 
		CONSTRAINT uq_User_emailUser UNIQUE 
		CONSTRAINT nn_User_emailUser NOT NULL
		CONSTRAINT ck_User_emailUser CHECK (emailUser LIKE '%_@_%._%'),
	nameUser TEXT
		CONSTRAINT nn_User_nameUser NOT NULL,
	firstNameUser TEXT 
		CONSTRAINT nn_User_firstNameUser NOT NULL,
	birthdateUser DATE
		CONSTRAINT nn_User_birthdateUser NOT NULL
		CONSTRAINT ck_User_birthdateUser1 CHECK (birthdateUser BETWEEN '1900-01-01' AND CURRENT_DATE)
		CONSTRAINT ck_User_birthdateUser2 CHECK (birthdateUser IS strftime('%Y-%m-%d', birthdateUser)),
	genderUser TEXT 
		CONSTRAINT nn_User_genderUser NOT NULL
		CONSTRAINT ck_User_genderUSER CHECK (genderUser IN ("Homme", "Femme", "Autre", "Ne souhaite pas partager")),
	heightUser INTEGER 
		CONSTRAINT nn_User_heightUser NOT NULL
		CONSTRAINT ck_User_heightUser CHECK (heightUser > 0),
	weightUser INTEGER 
		CONSTRAINT nn_User_weightUser NOT NULL
		CONSTRAINT ck_User_weightUser CHECK (weightUser > 0),
	passwordUser TEXT 
		CONSTRAINT nn_User_passwordUser NOT NULL
		CONSTRAINT ck_User_passwordUser CHECK (length(passwordUser) >= 8)
);

CREATE TABLE IF NOT EXISTS Activity (
	idActivity INTEGER 
		CONSTRAINT pk_Activity PRIMARY KEY AUTOINCREMENT,
	dateActivity TEXT 
		CONSTRAINT nn_Activity_dateActivity NOT NULL
		CONSTRAINT ck_Activity_dateActivity1 CHECK (dateActivity BETWEEN '01/01/1900' AND CURRENT_DATE),
	descriptionActivity TEXT 
		CONSTRAINT nn_Activity_descriptionActivity NOT NULL
		CONSTRAINT ck_Activity_descriptionActivity1 CHECK (length(descriptionActivity) >= 1)
		CONSTRAINT ck_Activity_descriptionActivity2 CHECK (length(descriptionActivity) <= 250),
	idUser INTEGER
		CONSTRAINT nn_Activity_idUser NOT NULL,
		CONSTRAINT fk_Activity_User FOREIGN KEY (idUser) REFERENCES User(idUser) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS Data (
	idData INTEGER 
		CONSTRAINT pk_Data PRIMARY KEY AUTOINCREMENT,
	timeData TEXT 
		CONSTRAINT nn_Data_timeData NOT NULL
		CONSTRAINT ck_Data_timeData1 CHECK (timeData IS strftime('%H:%M:%S', timeData))
		CONSTRAINT ck_Data_timeData2 CHECK (time(timeData) BETWEEN time('00:00:00') AND time('24:00:00')),
	cardioData INTEGER 
		CONSTRAINT nn_Data_cardioData NOT NULL
		CONSTRAINT ck_Data_cardioData CHECK (cardioData > 0),
	latitudeData REAL 
		CONSTRAINT nn_Data_latitudeData NOT NULL,
	longitudeData REAL 
		CONSTRAINT nn_Data_longitudeData NOT NULL,
	altitudeData INTEGER 
		CONSTRAINT nn_Data_altitudeData NOT NULL,
	idActivity INTEGER
		CONSTRAINT nn_Data_idActivity NOT NULL,
		CONSTRAINT fk_Data_Activity FOREIGN KEY (idActivity) REFERENCES Activity(idActivity) ON DELETE CASCADE
);
