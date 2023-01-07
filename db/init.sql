CREATE DATABASE IF NOT EXISTS polovniAutomobili;
USE polovniAutomobili;

DROP TABLE IF EXISTS polovniAutomobili.user;

CREATE TABLE user
(
    username      varchar(50)  NOT NULL PRIMARY KEY,
    email         varchar(50)  NOT NULL,
    moderator     boolean      NOT NULL,
    password_hash varchar(100) NOT NULL
);

DROP TABLE IF EXISTS polovniAutomobili.manufacturer;

CREATE TABLE manufacturer
(
    id           int         NOT NULL PRIMARY KEY auto_increment,
    name         varchar(50) NOT NULL
);

DROP TABLE IF EXISTS polovniAutomobili.car_body;

CREATE TABLE car_body
(
    id           int         NOT NULL PRIMARY KEY auto_increment,
    type         varchar(50) NOT NULL
);

CREATE TABLE fuel
(
    id           int         NOT NULL PRIMARY KEY auto_increment,
    type         varchar(50) NOT NULL
);

CREATE TABLE car_info
(
    id              int         NOT NULL PRIMARY KEY auto_increment,
    user            varchar(50) NOT NULL,
    fuel_id         int         NOT NULL,
    car_body_id     int         NOT NULL,
    manufacturer_id int         NOT NULL,
    model           varchar(50) NOT NULL,
    year            int         NOT NULL,
    price           float       NOT NULL,
    description     mediumtext  NOT NULL,
    is_new          boolean     NOT NULL,
    image_url       tinytext    NOT NULL,
    
    phone_number    int         NOT NULL,
    email           varchar(50),

    constraint fk_user_username
        foreign key (user)
            references user (username),

    constraint fk_fuel_id
            foreign key (fuel_id)
            references fuel (id),

     constraint fk_car_body_id
            foreign key (car_body_id)
            references car_body (id),

    constraint fk_manufacturer_id
            foreign key (manufacturer_id)
            references manufacturer (id)       
);