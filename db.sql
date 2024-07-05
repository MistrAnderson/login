USE loginDB;

-- Delete tables 
DROP TABLE IF EXISTS AccountAuthorizations;
DROP TABLE IF EXISTS Authorizations;
DROP TABLE IF EXISTS OTP;
DROP TABLE IF EXISTS Attempts;
DROP TABLE IF EXISTS Tokens;
DROP TABLE IF EXISTS Users;
DROP TABLE IF EXISTS Accounts;

CREATE TABLE Accounts (
	id_account INT AUTO_INCREMENT PRIMARY KEY,
	email VARCHAR(50) NOT NULL,
	pwd_hash VARCHAR(128) NOT NULL,
	salt VARCHAR(50) NOT NULL
);

CREATE TABLE Users (
	id_user INT AUTO_INCREMENT PRIMARY KEY,
	id_account INT,
	name VARCHAR(50),
	FOREIGN KEY (id_account) REFERENCES Accounts(id_account) ON DELETE CASCADE
);

CREATE TABLE Tokens (
	id_token INT AUTO_INCREMENT PRIMARY KEY,
	id_account INT,
	token VARCHAR(255) NOT NULL,
	validity TIMESTAMP,
	FOREIGN KEY (id_account) REFERENCES Accounts(id_account) ON DELETE CASCADE
);

CREATE TABLE Attempts (
	id_attempt INT AUTO_INCREMENT PRIMARY KEY,
	id_account INT,
	number INT,
	at_time TIMESTAMP,
	FOREIGN KEY (id_account) REFERENCES Accounts(id_account) ON DELETE CASCADE
);

CREATE TABLE OTP (
	id_otp INT AUTO_INCREMENT PRIMARY KEY,
	id_account INT,
	otp INT,
	validity TIMESTAMP,
	FOREIGN KEY (id_account) REFERENCES Accounts(id_account) ON DELETE CASCADE
);

CREATE TABLE Authorizations (
	id_auth INT AUTO_INCREMENT PRIMARY KEY,
	id_account INT,
	web_service VARCHAR(255),
	FOREIGN KEY (id_account) REFERENCES Accounts(id_account) ON DELETE CASCADE
);

CREATE TABLE AccountAuthorizations (
	id_auth INT,
	id_account INT,
	PRIMARY KEY(id_auth, id_account),
	FOREIGN KEY (id_auth) REFERENCES Authorizations(id_auth) ON DELETE CASCADE,
	FOREIGN KEY (id_account) REFERENCES Accounts(id_account) ON DELETE CASCADE
);
