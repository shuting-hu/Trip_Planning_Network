drop table Users;
drop table Regular_User_Rankings;
drop table Regular_User;
drop table Admin;
drop table Follows;
drop table Distance;
drop table Activity;
drop table time_zone;
drop table Location;
drop table Trip_In;
drop table Restaurant;
drop table Media;
drop table Photo;
drop table Video;
drop table Text;
drop table Takes;
drop table Posts;
drop table Tags;
drop table IsAt;
drop table Includes;
drop table OperatesAt;
drop table Attraction_In;
drop table Plans;



-- TABLES --


CREATE TABLE Users(
	username CHAR(16) PRIMARY KEY,
	password CHAR(30));
CREATE TABLE Regular_User_Rankings(
	date_joined DATE PRIMARY KEY,
	rank INTEGER);
CREATE TABLE Regular_User(
	username CHAR(16) PRIMARY KEY,
	date_joined DATE,
	profile_picture CHAR(70),
	FOREIGN KEY (username) REFERENCES Users(username));
CREATE TABLE Admin(
	username CHAR(16) PRIMARY KEY,
	name CHAR(70),
	role CHAR(70),
	email CHAR(70) UNIQUE NOT NULL,
    	admin_ID INTEGER UNIQUE NOT NULL,
	FOREIGN KEY (username) REFERENCES Users(username));
CREATE TABLE Follows(
	follower_username CHAR(16),
	following_username CHAR(16),
	PRIMARY KEY (follower_username, following_username),
	FOREIGN KEY (follower_username) REFERENCES Users(username),
	FOREIGN KEY (following_username) REFERENCES Users(username));


CREATE TABLE Distance(
    	transportation CHAR(70),
	km REAL,
	PRIMARY KEY (transportation, km));
CREATE TABLE Activity(
	name CHAR(70) PRIMARY KEY,
	type CHAR(70),
	num_dollar_signs INTEGER,
	description CHAR(120));
CREATE TABLE Timezones(
	country  CHAR(70),
	province  CHAR(70),
	time_zone  CHAR(5),
	PRIMARY KEY (country, province));
CREATE TABLE Location(
	id  INTEGER	PRIMARY KEY,
	country  CHAR(70) NOT NULL,
	province  CHAR(70) NOT NULL,
    	city  CHAR(70) NOT NULL,
postal_code  CHAR(6),
address  CHAR(70) NOT NULL,
UNIQUE (country, province, city, address));
CREATE TABLE Trip_In
	(title CHAR(70),
    	trip_id INTEGER PRIMARY KEY,
    	location_id INTEGER NOT NULL,
    	hotel CHAR(50),
   	duration INTEGER,
    	description CHAR(120),
    	FOREIGN KEY (location_id) REFERENCES Location(id));
CREATE TABLE Restaurant(
	name  CHAR(70)  PRIMARY KEY,
	cuisine_type  CHAR(70),
    	num_dollar_signs  INTEGER);


CREATE TABLE Media
	(title CHAR(70),
	post_id INTEGER PRIMARY KEY,
	description CHAR(120));
CREATE TABLE Photo
	(post_id INTEGER PRIMARY KEY,
	file_path CHAR(70),
    	FOREIGN KEY (post_id) REFERENCES Media(post_id));
CREATE TABLE Video
	(post_id INTEGER PRIMARY KEY,
	url CHAR(70),
    	FOREIGN KEY (post_id) REFERENCES Media(post_id));
CREATE TABLE Text(
	post_id INTEGER PRIMARY KEY,
	words CHAR(120),
	word_count INTEGER,
    	language CHAR(30),
	FOREIGN KEY (post_id) REFERENCES Media (post_id));



CREATE TABLE Takes(
	location_id INTEGER,
	transportation CHAR(70),
	km REAL,
	PRIMARY KEY (location_id, transportation, km),
	FOREIGN KEY (location_id) REFERENCES Location(id),
	FOREIGN KEY (transportation,km) REFERENCES Distance(transportation,km));
CREATE TABLE Posts(
	post_id INTEGER,
	trip_id INTEGER,
	date DATE,
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
    	activity_name  CHAR(70),
    	location_id  INTEGER,
    	PRIMARY KEY (activity_name, location_id),
    	FOREIGN KEY (activity_name) REFERENCES Activity(name),
    	FOREIGN KEY (location_id) REFERENCES Location(id));
CREATE TABLE Includes(
    	trip_id  INTEGER,
    	activity_name  CHAR(70),
    	PRIMARY KEY (trip_id, activity_name),
    	FOREIGN KEY (trip_id) REFERENCES Trip_In(trip_id),
    	FOREIGN KEY (activity_name) REFERENCES Activity(name));
CREATE TABLE OperatesAt(
	restaurant_name CHAR(70),
    	location_id INTEGER,
    	PRIMARY KEY (restaurant_name, location_id),
    	FOREIGN KEY (restaurant_name) REFERENCES Restaurant(name),
    	FOREIGN KEY (location_id) REFERENCES Location(id));
CREATE TABLE Attraction_In(
    	attr_name CHAR(70),
    	location_id INTEGER,
    	type CHAR(70),
    	description CHAR(120),
    	num_dollar_signs INTEGER,
    	PRIMARY KEY (attr_name, location_id),
    	FOREIGN KEY (location_id) REFERENCES Location(id));
CREATE TABLE Plans(
	username CHAR(16),
	trip_id INTEGER,
	date DATE,
	PRIMARY KEY (username, trip_id),
	FOREIGN KEY (username) REFERENCES Users(username),
    	FOREIGN KEY (trip_id) REFERENCES Trip_In(trip_id));



-- INSERTS --
 
-- Users


-- Regular_User_Rankings