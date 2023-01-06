CREATE DATABASE IF NOT EXISTS polovniAutomobili;
USE polovniAutomobili;

DROP TABLE IF EXISTS polovniAutomobili.user;

CREATE TABLE user(
    username      varchar(50)  NOT NULL PRIMARY KEY,
    email         varchar(50)  NOT NULL,
    moderator     boolean      NOT NULL,
    password_hash varchar(100) NOT NULL
);