-- TABLES --

CREATE TABLE All_Users(
	username VARCHAR(16) PRIMARY KEY,
	password VARCHAR(30) NOT NULL);
CREATE TABLE Regular_User(
	username VARCHAR(16) PRIMARY KEY,
	profile_picture VARCHAR(70),
	FOREIGN KEY (username) REFERENCES All_Users(username));
CREATE TABLE Admin(
	username VARCHAR(16) PRIMARY KEY,
	name VARCHAR(70),
	role VARCHAR(70),
	email VARCHAR(70) UNIQUE NOT NULL,
    admin_ID INTEGER UNIQUE NOT NULL,
	FOREIGN KEY (username) REFERENCES All_Users(username));


CREATE TABLE Activity(
	name VARCHAR(70) PRIMARY KEY,
	type VARCHAR(70),
	num_dollar_signs INTEGER CHECK (num_dollar_signs IN (0, 1, 2, 3)),
	description VARCHAR(280));
CREATE TABLE Location(
	id  INTEGER	PRIMARY KEY,
	country  VARCHAR(70) NOT NULL,
	province  VARCHAR(70),
	city  VARCHAR(70) NOT NULL,
	CONSTRAINT UC_Location UNIQUE (country, city));
CREATE TABLE Trip_In(
	title VARCHAR(70),
	trip_id INTEGER PRIMARY KEY,
	location_id INTEGER NOT NULL,
   	duration VARCHAR(15) CHECK (duration IN ('daytrip', '1 week trip', '2 weeks+ trip')),
	description VARCHAR(280),
	FOREIGN KEY (location_id) REFERENCES Location(id));
CREATE TABLE Restaurant(
	name  VARCHAR(70)  PRIMARY KEY,
	cuisine_type  VARCHAR(70),
	num_dollar_signs  INTEGER CHECK (num_dollar_signs IN (1, 2, 3)));


CREATE TABLE Media(
	post_id INTEGER PRIMARY KEY,
	date DATE);
CREATE TABLE Photo(
	post_id INTEGER PRIMARY KEY,
	caption VARCHAR(280),
	file_path VARCHAR(70),
	FOREIGN KEY (post_id) REFERENCES Media(post_id));
CREATE TABLE Video(
	post_id INTEGER PRIMARY KEY,
	url VARCHAR(70),
	FOREIGN KEY (post_id) REFERENCES Media(post_id));
CREATE TABLE Text(
	post_id INTEGER PRIMARY KEY,
	words VARCHAR(280),
	language VARCHAR(30),
	FOREIGN KEY (post_id) REFERENCES Media (post_id));


CREATE TABLE Posts(
	post_id INTEGER,
	trip_id INTEGER,
	PRIMARY KEY (post_id, trip_id),
	FOREIGN KEY (post_id) REFERENCES Media(post_id),
	FOREIGN KEY (trip_id) REFERENCES Trip_In(trip_id));
CREATE TABLE Tags(
	post_id  INTEGER,
	location_id  INTEGER,
	PRIMARY KEY (post_id, location_id),
	FOREIGN KEY (post_id) REFERENCES Media(post_id),
	FOREIGN KEY (location_id) REFERENCES Location(id));
CREATE TABLE IsAt(
	activity_name  VARCHAR(70),
	location_id  INTEGER,
	PRIMARY KEY (activity_name, location_id),
	FOREIGN KEY (activity_name) REFERENCES Activity(name),
	FOREIGN KEY (location_id) REFERENCES Location(id));
CREATE TABLE Includes(
	trip_id  INTEGER,
	activity_name  VARCHAR(70),
	PRIMARY KEY (trip_id, activity_name),
	FOREIGN KEY (trip_id) REFERENCES Trip_In(trip_id),
	FOREIGN KEY (activity_name) REFERENCES Activity(name));
CREATE TABLE OperatesAt(
	restaurant_name VARCHAR(70),
	location_id INTEGER,
	PRIMARY KEY (restaurant_name, location_id),
	FOREIGN KEY (restaurant_name) REFERENCES Restaurant(name),
	FOREIGN KEY (location_id) REFERENCES Location(id));
CREATE TABLE Attraction_In(
	attr_name VARCHAR(70),
	location_id INTEGER,
	type VARCHAR(70),
	description VARCHAR(280),
	num_dollar_signs INTEGER CHECK (num_dollar_signs IN (0, 1, 2, 3)),
	PRIMARY KEY (attr_name, location_id),
	FOREIGN KEY (location_id) REFERENCES Location(id));
CREATE TABLE Plans(
	username VARCHAR(16),
	trip_id INTEGER,
	PRIMARY KEY (username, trip_id),
	FOREIGN KEY (username) REFERENCES All_Users(username),
	FOREIGN KEY (trip_id) REFERENCES Trip_In(trip_id));
