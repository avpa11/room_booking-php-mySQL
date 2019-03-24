DROP DATABASE IF EXISTS test;
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

CREATE TABLE room (
  room_id int(2) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  type VARCHAR(15) NOT NULL,
  capacity INT(2) NOT NULL,
  floor INT(1) NOT NULL,
  room_number VARCHAR(10) NOT NULL,
  CONSTRAINT room CHECK ( type='study' OR type='collaboration' OR type='group' AND floor<6)
);

CREATE TABLE reservation (
  reservation_id INT(5) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  stud_id INT(11) NOT NULL,
  room_id INT(2) NOT NULL,
  description VARCHAR(50),
  number_of_people INT(1) NOT NULL,
  date TIMESTAMP NOT NULL,
  start_time TIME NOT NULL,
  end_time TIME NOT NULL,
  CONSTRAINT reservation_ch CHECK (number_of_people<=6),
  CONSTRAINT reservation_stud FOREIGN KEY (stud_id)
    REFERENCES students(id),
  CONSTRAINT reservation_room FOREIGN KEY (room_id)
    REFERENCES room(room_id) 
);

INSERT INTO students (username, password) VALUES ("user1", "1234");

INSERT INTO librarians (lib_username, lib_password) VALUES ("lib1", "1234");

INSERT INTO room (type, capacity, floor, room_number) VALUES ("study", 2, 2, "N2341");
INSERT INTO room (type, capacity, floor, room_number) VALUES ("collaboration", 5, 2, "N2345");
INSERT INTO room (type, capacity, floor, room_number) VALUES ("group", 10, 3, "N3341");

INSERT INTO reservation (stud_id, room_id, description, number_of_people, date, start_time, end_time) VALUES (1, 2, "DB II Group Project meeting", 3, "2019-03-23", "9:00:00", "11:00:00");
INSERT INTO reservation (stud_id, room_id, description, number_of_people, date, start_time, end_time) VALUES (1, 2, "DB II Group Project presentation discussion", 3, "2019-03-30", "12:00:00", "14:00:00");
