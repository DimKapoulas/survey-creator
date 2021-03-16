CREATE DATABASE surveys;
CREATE USER 'testUser'@'localhost' IDENTIFIED BY 'Test1234!';
GRANT ALL PRIVILEGES ON *.* to 'testUser'@'localhost';
