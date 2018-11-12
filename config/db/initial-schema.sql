CREATE DATABASE uts_web_service;

USE uts_web_service;

CREATE TABLE users(
  id VARCHAR(36),
  first_name VARCHAR(20),
  last_name VARCHAR(50),
  email VARCHAR(30),
  phone_number VARCHAR(15),
  created_date TIMESTAMP,
  updated_date TIMESTAMP,
  PRIMARY KEY(id)
);

INSERT INTO users(id,first_name,last_name,email,phone_number) VALUES(uuid(),'Ipan','Taupik Rahman','ipantaupik97@gmail.com','082117200903');