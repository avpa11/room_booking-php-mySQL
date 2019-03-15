CREATE DATABASE test;
use test

CREATE TABLE students (
  id        int(11)       NOT NULL PRIMARY KEY AUTO_INCREMENT,
  username  varchar(30)  NOT NULL,
  password  VARCHAR(20)  NOT NULL,
  created   TIMESTAMP     NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
); 

CREATE TABLE librarians (
  lib_id    int(11)       NOT NULL PRIMARY KEY AUTO_INCREMENT,
  lib_username  varchar(30)  NOT NULL,
  lib_password  VARCHAR(20)  NOT NULL,
  lib_created   TIMESTAMP     NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

INSERT INTO students (username, password) VALUES ("user1", "1234");

INSERT INTO librarians (lib_username, lib_password) VALUES ("lib1", "1234");
