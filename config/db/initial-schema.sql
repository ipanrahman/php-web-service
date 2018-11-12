CREATE DATABASE uts_web_service;

USE uts_web_service;

CREATE TABLE users(
  id VARCHAR(36),
  first_name VARCHAR(20),
  last_name VARCHAR(50),
  gender ENUM('MALE','FEMALE','OTHER'),
  birth_date DATE,
  place_of_birth VARCHAR(30),
  email VARCHAR(30),
  phone_number VARCHAR(15),
  created_date TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  updated_date TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY(id)
);