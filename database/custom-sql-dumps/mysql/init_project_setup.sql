-- Create database
CREATE DATABASE muy_parking;
-- Create user and password
CREATE USER 'muy'@'localhost' IDENTIFIED BY 'muy2020';
-- Set privileges to user for muy_parking database
GRANT ALL PRIVILEGES ON muy_parking.* TO 'muy'@'localhost';