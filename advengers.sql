DROP TABLE IF EXISTS Plans;
DROP TABLE IF EXISTS IncludesAttraction;
DROP TABLE IF EXISTS Attraction_In;
DROP TABLE IF EXISTS OperatesAt;
DROP TABLE IF EXISTS IncludesRestaurant;
DROP TABLE IF EXISTS IncludesActivity;
DROP TABLE IF EXISTS IsAt;
DROP TABLE IF EXISTS Tags;
DROP TABLE IF EXISTS Posts;
DROP TABLE IF EXISTS `Text`;
DROP TABLE IF EXISTS Video;
DROP TABLE IF EXISTS Photo;
DROP TABLE IF EXISTS Media;
DROP TABLE IF EXISTS Restaurant;
DROP TABLE IF EXISTS Trip_In;
DROP TABLE IF EXISTS `Location`;
DROP TABLE IF EXISTS Activity;
DROP TABLE IF EXISTS `Admin`;
DROP TABLE IF EXISTS Regular_User;
DROP TABLE IF EXISTS All_Users;
DROP VIEW IF EXISTS subposts;


-- TABLES --


CREATE TABLE All_Users(
	username VARCHAR(16) PRIMARY KEY,
	password VARCHAR(30) NOT NULL,
	name VARCHAR(70));
CREATE TABLE Regular_User(
	username VARCHAR(16) PRIMARY KEY,
	profile_picture VARCHAR(280),
	FOREIGN KEY (username) REFERENCES All_Users(username) ON DELETE CASCADE);
CREATE TABLE Admin(
	username VARCHAR(16) PRIMARY KEY,
	role VARCHAR(70),
	email VARCHAR(70) UNIQUE NOT NULL,
    admin_ID INTEGER UNIQUE NOT NULL,
	FOREIGN KEY (username) REFERENCES All_Users(username) ON DELETE CASCADE);


CREATE TABLE Activity(
	name VARCHAR(70) PRIMARY KEY,
	type VARCHAR(70),
	num_dollar_signs INTEGER CHECK (num_dollar_signs IN (0, 1, 2, 3)),
	description VARCHAR(280));
CREATE TABLE Location(
	id  INTEGER PRIMARY KEY AUTO_INCREMENT,
	country  VARCHAR(70) NOT NULL,
	province  VARCHAR(70),
	city  VARCHAR(70) NOT NULL,
	CONSTRAINT UC_Location UNIQUE (country, city));
CREATE TABLE Trip_In(
	title VARCHAR(70),
	trip_id INTEGER PRIMARY KEY AUTO_INCREMENT,
	location_id INTEGER NOT NULL,
   	duration VARCHAR(15) CHECK (duration IN ('daytrip', '1 week trip', '2 weeks+ trip')),
	description VARCHAR(280),
	FOREIGN KEY (location_id) REFERENCES Location(id));
CREATE TABLE Restaurant(
	name  VARCHAR(70)  PRIMARY KEY,
	cuisine_type  VARCHAR(70),
	num_dollar_signs  INTEGER CHECK (num_dollar_signs IN (1, 2, 3)));


CREATE TABLE Media(
	post_id INTEGER PRIMARY KEY AUTO_INCREMENT,
	date DATE,
	type INTEGER CHECK (type IN (1, 2, 3)));
CREATE TABLE Photo( -- 2
	post_id INTEGER PRIMARY KEY,
	caption VARCHAR(280),
	file_path VARCHAR(280) NOT NULL,
	FOREIGN KEY (post_id) REFERENCES Media(post_id) ON DELETE CASCADE);
CREATE TABLE Video( -- 3
	post_id INTEGER PRIMARY KEY,
	url VARCHAR(70) NOT NULL,
	FOREIGN KEY (post_id) REFERENCES Media(post_id) ON DELETE CASCADE);
CREATE TABLE Text( -- 1
	post_id INTEGER PRIMARY KEY,
	words VARCHAR(280),
	FOREIGN KEY (post_id) REFERENCES Media (post_id) ON DELETE CASCADE);


CREATE TABLE Posts(
	post_id INTEGER,
	trip_id INTEGER,
	PRIMARY KEY (post_id, trip_id),
	FOREIGN KEY (post_id) REFERENCES Media(post_id) ON DELETE CASCADE,
	FOREIGN KEY (trip_id) REFERENCES Trip_In(trip_id) ON DELETE CASCADE);
CREATE TABLE Tags(
	post_id  INTEGER,
	location_id  INTEGER,
	PRIMARY KEY (post_id, location_id),
	FOREIGN KEY (post_id) REFERENCES Media(post_id) ON DELETE CASCADE,
	FOREIGN KEY (location_id) REFERENCES Location(id) ON DELETE CASCADE);
CREATE TABLE IsAt(
	activity_name  VARCHAR(70),
	location_id  INTEGER,
	PRIMARY KEY (activity_name, location_id),
	FOREIGN KEY (activity_name) REFERENCES Activity(name) ON DELETE CASCADE,
	FOREIGN KEY (location_id) REFERENCES Location(id) ON DELETE CASCADE);

CREATE TABLE IncludesActivity(
	trip_id  INTEGER,
	activity_name  VARCHAR(70),
	PRIMARY KEY (trip_id, activity_name),
	FOREIGN KEY (trip_id) REFERENCES Trip_In(trip_id),
	FOREIGN KEY (activity_name) REFERENCES Activity(name) ON DELETE CASCADE);
CREATE TABLE IncludesRestaurant(
	trip_id  INTEGER,
	restaurant_name  VARCHAR(70),
	PRIMARY KEY (trip_id, restaurant_name),
	FOREIGN KEY (trip_id) REFERENCES Trip_In(trip_id),
	FOREIGN KEY (restaurant_name) REFERENCES Restaurant(name) ON DELETE CASCADE);

CREATE TABLE OperatesAt(
	restaurant_name VARCHAR(70),
	location_id INTEGER,
	PRIMARY KEY (restaurant_name, location_id),
	FOREIGN KEY (restaurant_name) REFERENCES Restaurant(name) ON DELETE CASCADE,
	FOREIGN KEY (location_id) REFERENCES Location(id) ON DELETE CASCADE);
CREATE TABLE Attraction_In( 
	attr_name VARCHAR(70),
	location_id INTEGER,
	type VARCHAR(70),
	description VARCHAR(280),
	num_dollar_signs INTEGER CHECK (num_dollar_signs IN (0, 1, 2, 3)),
	PRIMARY KEY (attr_name, location_id),
	FOREIGN KEY (location_id) REFERENCES Location(id) ON DELETE CASCADE);
CREATE TABLE IncludesAttraction(
	trip_id  INTEGER,
	attr_name  VARCHAR(70),
	location_id INTEGER,
	PRIMARY KEY (trip_id, attr_name, location_id),
	FOREIGN KEY (trip_id) REFERENCES Trip_In(trip_id) ON DELETE CASCADE,
	FOREIGN KEY (attr_name, location_id) REFERENCES Attraction_In(attr_name, location_id) ON DELETE CASCADE);
CREATE TABLE Plans(
	username VARCHAR(16),
	trip_id INTEGER,
	PRIMARY KEY (username, trip_id),
	FOREIGN KEY (username) REFERENCES All_Users(username) ON DELETE CASCADE,
	FOREIGN KEY (trip_id) REFERENCES Trip_In(trip_id) ON DELETE CASCADE);



-- INSERTS --
 

INSERT INTO All_Users(username, password, name) VALUES('ironman', 'iloveyou3000', 'Tony Stark');
INSERT INTO All_Users(username, password, name) VALUES('spidey', 'uncleben', 'Peter Parker');
INSERT INTO All_Users(username, password, name) VALUES('blackwidow', 'barton', 'Natasha Romanoff');
INSERT INTO All_Users(username, password, name) VALUES('hawkeye', 'romanoff', 'Clint Barton');
INSERT INTO All_Users(username, password, name) VALUES('ppotts', 'iloveyou3000', 'Pepper Potts');
INSERT INTO All_Users(username, password, name) VALUES('warmach', 'mrstank', 'James Rhodes');
INSERT INTO All_Users(username, password, name) VALUES('capUSA', 'april91921', 'Steve Rogers');
INSERT INTO All_Users(username, password, name) VALUES('shuri', 'smarterthanmybrother', 'Shuri');
INSERT INTO All_Users(username, password, name) VALUES('slang', 'iamantman', 'Scott Lang');
INSERT INTO All_Users(username, password, name) VALUES('redwitch', 'mindgames', 'Wanda Maximoff');
INSERT INTO All_Users(username, password, name) VALUES('than0s', 'perfectbalance', 'Thanos');
INSERT INTO All_Users(username, password, name) VALUES('starlord', 'awesomemixvol1', 'Peter Quill');
INSERT INTO All_Users(username, password, name) VALUES('gamora', 'whyisgamora', 'Gamora');
INSERT INTO All_Users(username, password, name) VALUES('rocket', 'guardinthefrickingalaxy', 'Rocket Racoon');
INSERT INTO All_Users(username, password, name) VALUES('gen.okoye', 'yibambe', 'Okoye');

INSERT INTO Regular_User(username, profile_picture) VALUES('ironman', 'images/pfp/ironman.png');
INSERT INTO Regular_User(username, profile_picture) VALUES('spidey', 'images/pfp/spidey.png');
INSERT INTO Regular_User(username, profile_picture) VALUES('blackwidow', 'images/pfp/blackwidow.png');
INSERT INTO Regular_User(username, profile_picture) VALUES('hawkeye', 'images/pfp/hawkeye.png');
INSERT INTO Regular_User(username, profile_picture) VALUES('ppotts', 'images/pfp/ppotts.png');
INSERT INTO Regular_User(username, profile_picture) VALUES('slang', 'images/pfp/slang.png');
INSERT INTO Regular_User(username, profile_picture) VALUES('redwitch', 'images/pfp/redwitch.png');
INSERT INTO Regular_User(username, profile_picture) VALUES('gen.okoye', 'images/pfp/gen.okoye.png');
INSERT INTO Regular_User(username, profile_picture) VALUES('starlord', 'images/pfp/starlord.png');
INSERT INTO Regular_User(username, profile_picture) VALUES('than0s', 'images/pfp/than0s.png');
INSERT INTO Regular_User(username, profile_picture) VALUES('capUSA', 'images/pfp/capUSA.png');
INSERT INTO Regular_User(username, profile_picture) VALUES('warmach', 'images/pfp/warmach.png');
INSERT INTO Regular_User(username, profile_picture) VALUES('shuri', 'images/pfp/shuri.png');
INSERT INTO Regular_User(username, profile_picture) VALUES('rocket', 'images/pfp/rocket.png');
INSERT INTO Regular_User(username, profile_picture) VALUES('gamora', 'images/pfp/gamora.png');

INSERT INTO Admin(username, role, email, admin_ID) VALUES('ironman', 'Moderator', 'imironman@stark.net', 1);
INSERT INTO Admin(username, role, email, admin_ID) VALUES('ppotts', 'Moderator', 'ceopotts@stark.net', 2);
INSERT INTO Admin(username, role, email, admin_ID) VALUES('warmach', 'Security', 'colonelrhodey@avengers.com', 3);
INSERT INTO Admin(username, role, email, admin_ID) VALUES('shuri', 'Engineer', 'wakandantech@gov.wa', 4);
INSERT INTO Admin(username, role, email, admin_ID) VALUES('capUSA', 'Announcer', 'steverogers1918@hotmail.com', 5);
INSERT INTO Admin(username, role, email, admin_ID) VALUES('than0s', 'Moderator', 'thanos@titans.net', 6);
INSERT INTO Admin(username, role, email, admin_ID) VALUES('starlord', 'Announcer', 'starlord@guardians.net', 7);
INSERT INTO Admin(username, role, email, admin_ID) VALUES('rocket', 'Engineer', 'rocket@guardians.net', 8);
INSERT INTO Admin(username, role, email, admin_ID) VALUES('gamora', 'Moderator', 'gamora@guardians.net', 9);
INSERT INTO Admin(username, role, email, admin_ID) VALUES('gen.okoye', 'Security', 'armygeneral@gov.wa', 10);

INSERT INTO Activity(name, type, num_dollar_signs, description) VALUES('Wine Tasting in Vienna', 'dining', 3, 'Featuring the top sommeliers of all time, learn to appreciate the complex flavors of wine');
INSERT INTO Activity(name, type, num_dollar_signs, description) VALUES('British Museum Tour', 'museum', 2, 'Take a guided tour of the museum with a historian');
INSERT INTO Activity(name, type, num_dollar_signs, description) VALUES('Spy Mission 888', 'business', 1, 'confidential');
INSERT INTO Activity(name, type, num_dollar_signs, description) VALUES('Skytree Heist', 'business', 2, 'confidential');
INSERT INTO Activity(name, type, num_dollar_signs, description) VALUES('Mexico Cruise', 'sightseeing', 3, 'Relax on board or go sightseeing at port stops');
INSERT INTO Activity(name, type, num_dollar_signs, description) VALUES('Iztaccíhuatl Hike', 'nature', 0, 'Discover the raw beauty of Mexico by hiking a dormant volcano with mythological roots');
INSERT INTO Activity(name, type, num_dollar_signs, description) VALUES('Pastry Tour', 'food', 3, 'A tour through Paris’s finest bakeries that will warm your heart and your stomach.');
INSERT INTO Activity(name, type, num_dollar_signs, description) VALUES('Malibu Meditation', 'relaxation', 0, 'Meditation in the comfort of your own home');
INSERT INTO Activity(name, type, num_dollar_signs, description) VALUES('Ginza Shopping', 'shopping', 3, 'Buy gifts for friends, family, and yourself');
INSERT INTO Activity(name, type, num_dollar_signs, description) VALUES('Farming', 'relaxation', 0, 'Yeehaw');

INSERT INTO Location(id, country, province, city) VALUES(1, 'Austria', NULL, 'Vienna');
INSERT INTO Location(id, country, province, city) VALUES(2, 'England', NULL, 'London');
INSERT INTO Location(id, country, province, city) VALUES(3, 'Russia', 'Volgograd Oblast', 'Volgograd');
INSERT INTO Location(id, country, province, city) VALUES(4, 'Japan', NULL, 'Tokyo');
INSERT INTO Location(id, country, province, city) VALUES(5, 'Mexico', NULL, 'Mexico City');
INSERT INTO Location(id, country, province, city) VALUES(6, 'US', 'California', 'Malibu');
INSERT INTO Location(id, country, province, city) VALUES(7, 'Germany', 'Brandenburg', 'Berlin');
INSERT INTO Location(id, country, province, city) VALUES(8, 'France', 'Île-de-France', 'Paris');
INSERT INTO Location(id, country, province, city) VALUES(9, 'Italy', 'Venezia', 'Venice');
INSERT INTO Location(id, country, province, city) VALUES(10, 'Australia', 'Queensland', 'Atherton');
INSERT INTO Location(id, country, province, city) VALUES(11, 'Canada', 'British Columbia', 'Vancouver');
INSERT INTO Location(id, country, province, city) VALUES(12, 'China', NULL, 'Shanghai');

INSERT INTO Trip_In(title, trip_id, location_id, duration, description) VALUES('Avengers Forever', 1, 1, '1 week trip', 'For work');
INSERT INTO Trip_In(title, trip_id, location_id, duration, description) VALUES('Far From Home', 2, 2, '1 week trip', 'School trip!');
INSERT INTO Trip_in(title, trip_id, location_id, duration, description) VALUES('Mission: Home', 3, 3, '2 weeks+ trip', 'Mission 3478912');
INSERT INTO Trip_in(title, trip_id, location_id, duration, description) VALUES('Who am I?', 4, 4, '1 week trip', 'Finding myself');
INSERT INTO Trip_in(title, trip_id, location_id, duration, description) VALUES('Zero Work, All Vacation', 5, 5, '2 weeks+ trip', 'Well deserved');
INSERT INTO Trip_in(title, trip_id, location_id, duration, description) VALUES('Staying Home', 6, 6, '2 weeks+ trip', 'quarantine');
INSERT INTO Trip_in(title, trip_id, location_id, duration, description) VALUES('Lowkey Civil War', 7, 7, 'daytrip', 'omg so cool, I mean not war but...');
INSERT INTO Trip_in(title, trip_id, location_id, duration, description) VALUES('Magnifique Paris', 8, 8, '2 weeks+ trip', 'oui');
INSERT INTO Trip_In(title, trip_id, location_id, duration, description) VALUES('Escape to Italy', 9, 9, '2 weeks+ trip', 'shh');
INSERT INTO Trip_In(title, trip_id, location_id, duration, description) VALUES('Happy Farmer Diaries', 10, 10, '2 weeks+ trip', 'Balance restored');

INSERT INTO Restaurant(name, cuisine_type, num_dollar_signs) VALUES('SHIELD Fine Dining', 'Magical', 3);
INSERT INTO Restaurant(name, cuisine_type, num_dollar_signs) VALUES('Fish & Chip Pub', 'British', 2);
INSERT INTO Restaurant(name, cuisine_type, num_dollar_signs) VALUES('Putin’s Poutine', 'Fast Food', 1);
INSERT INTO Restaurant(name, cuisine_type, num_dollar_signs) VALUES('Hello Kitty Cafe', 'Cafe', 2);
INSERT INTO Restaurant(name, cuisine_type, num_dollar_signs) VALUES('Taco food truck', 'Mexican', 1);
INSERT INTO Restaurant(name, cuisine_type, num_dollar_signs) VALUES('Stark Kitchen', 'Homemade', 3);
INSERT INTO Restaurant(name, cuisine_type, num_dollar_signs) VALUES('Berlin Burgers', 'German', 2);
INSERT INTO Restaurant(name, cuisine_type, num_dollar_signs) VALUES('Asakusa Okonomiyaki Sometaro', 'Japanese', 3);
INSERT INTO Restaurant(name, cuisine_type, num_dollar_signs) VALUES('Totti Candy Factory', 'Dessert', 2);
INSERT INTO Restaurant(name, cuisine_type, num_dollar_signs) VALUES('Bombay Spice', 'Indian', 2);

INSERT INTO Media(date, type) VALUES ('2020-03-27',2);
INSERT INTO Media(date, type) VALUES ('2020-03-27',2);
INSERT INTO Media(date, type) VALUES ('2020-03-27',2);
INSERT INTO Media(date, type) VALUES ('2020-03-27',2);
INSERT INTO Media(date, type) VALUES ('2020-03-27',2);
INSERT INTO Media(date, type) VALUES ('2020-03-27',2);
INSERT INTO Media(date, type) VALUES ('2020-03-27',2);
INSERT INTO Media(date, type) VALUES ('2020-03-27',2);
INSERT INTO Media(date, type) VALUES ('2020-03-27',2);
INSERT INTO Media(date, type) VALUES ('2020-03-27',2);
INSERT INTO Media(date, type) VALUES ('2020-03-27',3);
INSERT INTO Media(date, type) VALUES ('2020-03-27',3);
INSERT INTO Media(date, type) VALUES ('2020-03-27',3);
INSERT INTO Media(date, type) VALUES ('2020-03-27',3);
INSERT INTO Media(date, type) VALUES ('2020-03-27',3);
INSERT INTO Media(date, type) VALUES ('2020-03-27',3);
INSERT INTO Media(date, type) VALUES ('2020-03-27',3);
INSERT INTO Media(date, type) VALUES ('2020-03-27',3);
INSERT INTO Media(date, type) VALUES ('2020-03-27',3);
INSERT INTO Media(date, type) VALUES ('2020-03-27',3);
INSERT INTO Media(date, type) VALUES ('2020-03-27',1);
INSERT INTO Media(date, type) VALUES ('2020-03-27',1);
INSERT INTO Media(date, type) VALUES ('2020-03-27',1);
INSERT INTO Media(date, type) VALUES ('2020-03-27',1);
INSERT INTO Media(date, type) VALUES ('2020-03-27',1);
INSERT INTO Media(date, type) VALUES ('2020-03-27',1);
INSERT INTO Media(date, type) VALUES ('2020-03-27',1);
INSERT INTO Media(date, type) VALUES ('2020-03-27',1);
INSERT INTO Media(date, type) VALUES ('2020-03-27',1);
INSERT INTO Media(date, type) VALUES ('2020-03-27',1);
INSERT INTO Media(date, type) VALUES ('2020-03-27',2);

INSERT INTO Photo(post_id, caption, file_path) VALUES (1, 'Pleasure doing business.', 'images/posts/ironman/1.png');
INSERT INTO Photo(post_id, caption, file_path) VALUES (2, 'POV: you''re Thanos', 'images/posts/ironman/2.png');
INSERT INTO Photo(post_id, caption, file_path) VALUES (3, 'Vienna, wow', 'images/posts/ironman/3.png');
INSERT INTO Photo(post_id, caption, file_path) VALUES (4, 'Mastering the art of meditation in the comfort of my own home', 'images/posts/ironman/4.png');
INSERT INTO Photo(post_id, caption, file_path) VALUES (5, 'Bug fixes ;)', 'images/posts/ironman/5.png');
INSERT INTO Photo(post_id, caption, file_path) VALUES (6, 'her.', 'images/posts/spidey/6.png');
INSERT INTO Photo(post_id, caption, file_path) VALUES (7, NULL, 'images/posts/spidey/7.png');
INSERT INTO Photo(post_id, caption, file_path) VALUES (8, NULL, 'images/posts/hawkeye/8.png');
INSERT INTO Photo(post_id, caption, file_path) VALUES (9, NULL, 'images/posts/ppotts/9.png');
INSERT INTO Photo(post_id, caption, file_path) VALUES (10, 'Finally at peace.', 'images/posts/than0s/10.png');
INSERT INTO Photo(post_id, caption, file_path) VALUES (31, NULL, 'images/posts/redwitch/11.png');

INSERT INTO Video(post_id, url) VALUES(11, 'https://youtu.be/3uZ7r-dpk_g');
INSERT INTO Video(post_id, url) VALUES(12, 'https://youtu.be/2n4Xj2EkmcU');
INSERT INTO Video(post_id, url) VALUES(13, 'https://youtu.be/hliJp4Ig3uM');
INSERT INTO Video(post_id, url) VALUES(14, 'https://youtu.be/ybji16u608U');
INSERT INTO Video(post_id, url) VALUES(15, 'https://youtu.be/lTL3OZkVMHQ');
INSERT INTO Video(post_id, url) VALUES(16, 'https://youtu.be/NmJMeSECMzQ');
INSERT INTO Video(post_id, url) VALUES(17, 'https://youtu.be/zNs3o4P4s1A');
INSERT INTO Video(post_id, url) VALUES(18, 'https://youtu.be/S_dfq9rFWAE');
INSERT INTO Video(post_id, url) VALUES(19, 'https://youtu.be/6k7a8bw451M');
INSERT INTO Video(post_id, url) VALUES(20, 'https://youtu.be/9FkQ8I9DjlQ');

INSERT INTO Text(post_id, words) VALUES(21, 'I love you 3000 Morgan');
INSERT INTO Text(post_id, words) VALUES(22, 'J’taime 3000');
INSERT INTO Text(post_id, words) VALUES(23, 'Excellent tacos! Perfectly tender meat, salsa and guac made in house. Amazing churros too. 10/10');
INSERT INTO Text(post_id, words) VALUES(24, 'I needed this vacation so badly');
INSERT INTO Text(post_id, words) VALUES(25, 'Finally got a massage');
INSERT INTO Text(post_id, words) VALUES(26, '食物。 はい。');
INSERT INTO Text(post_id, words) VALUES(27, 'Making gadgets on the go, T’Challa could never');
INSERT INTO Text(post_id, words) VALUES(28, 'I');
INSERT INTO Text(post_id, words) VALUES(29, 'LOVE');
INSERT INTO Text(post_id, words) VALUES(30, 'FARMING');

INSERT INTO Posts(post_id, trip_id) VALUES(1, 1);
INSERT INTO Posts(post_id, trip_id) VALUES(2, 1);
INSERT INTO Posts(post_id, trip_id) VALUES(3, 1);
INSERT INTO Posts(post_id, trip_id) VALUES(4, 6);
INSERT INTO Posts(post_id, trip_id) VALUES(5, 6);
INSERT INTO Posts(post_id, trip_id) VALUES(6, 2);
INSERT INTO Posts(post_id, trip_id) VALUES(7, 2);
INSERT INTO Posts(post_id, trip_id) VALUES(8, 4);
INSERT INTO Posts(post_id, trip_id) VALUES(9, 5);
INSERT INTO Posts(post_id, trip_id) VALUES(10, 10);
INSERT INTO Posts(post_id, trip_id) VALUES(11, 7);
INSERT INTO Posts(post_id, trip_id) VALUES(12, 2);
INSERT INTO Posts(post_id, trip_id) VALUES(13, 2);
INSERT INTO Posts(post_id, trip_id) VALUES(14, 3);
INSERT INTO Posts(post_id, trip_id) VALUES(15, 3);
INSERT INTO Posts(post_id, trip_id) VALUES(16, 3);
INSERT INTO Posts(post_id, trip_id) VALUES(17, 3);
INSERT INTO Posts(post_id, trip_id) VALUES(18, 3);
INSERT INTO Posts(post_id, trip_id) VALUES(19, 4);
INSERT INTO Posts(post_id, trip_id) VALUES(20, 8);
INSERT INTO Posts(post_id, trip_id) VALUES(21, 6);
INSERT INTO Posts(post_id, trip_id) VALUES(22, 6);
INSERT INTO Posts(post_id, trip_id) VALUES(23, 5);
INSERT INTO Posts(post_id, trip_id) VALUES(24, 5);
INSERT INTO Posts(post_id, trip_id) VALUES(25, 5);
INSERT INTO Posts(post_id, trip_id) VALUES(26, 4);
INSERT INTO Posts(post_id, trip_id) VALUES(27, 8);
INSERT INTO Posts(post_id, trip_id) VALUES(28, 10);
INSERT INTO Posts(post_id, trip_id) VALUES(29, 10);
INSERT INTO Posts(post_id, trip_id) VALUES(30, 10);
INSERT INTO Posts(post_id, trip_id) VALUES(31, 9);

INSERT INTO Tags(post_id, location_id) VALUES(1, 1);
INSERT INTO Tags(post_id, location_id) VALUES(2, 1);
INSERT INTO Tags(post_id, location_id) VALUES(3, 1);
INSERT INTO Tags(post_id, location_id) VALUES(4, 6);
INSERT INTO Tags(post_id, location_id) VALUES(5, 6);
INSERT INTO Tags(post_id, location_id) VALUES(6, 2);
INSERT INTO Tags(post_id, location_id) VALUES(7, 2);
INSERT INTO Tags(post_id, location_id) VALUES(8, 4);
INSERT INTO Tags(post_id, location_id) VALUES(9, 5);
INSERT INTO Tags(post_id, location_id) VALUES(10, 10);
INSERT INTO Tags(post_id, location_id) VALUES(11, 7);
INSERT INTO Tags(post_id, location_id) VALUES(12, 2);
INSERT INTO Tags(post_id, location_id) VALUES(13, 2);
INSERT INTO Tags(post_id, location_id) VALUES(14, 3);
INSERT INTO Tags(post_id, location_id) VALUES(15, 3);
INSERT INTO Tags(post_id, location_id) VALUES(16, 3);
INSERT INTO Tags(post_id, location_id) VALUES(17, 3);
INSERT INTO Tags(post_id, location_id) VALUES(18, 3);
INSERT INTO Tags(post_id, location_id) VALUES(19, 4);
INSERT INTO Tags(post_id, location_id) VALUES(20, 8);
INSERT INTO Tags(post_id, location_id) VALUES(21, 6);
INSERT INTO Tags(post_id, location_id) VALUES(22, 6);
INSERT INTO Tags(post_id, location_id) VALUES(23, 5);
INSERT INTO Tags(post_id, location_id) VALUES(24, 5);
INSERT INTO Tags(post_id, location_id) VALUES(25, 5);
INSERT INTO Tags(post_id, location_id) VALUES(26, 4);
INSERT INTO Tags(post_id, location_id) VALUES(27, 8);
INSERT INTO Tags(post_id, location_id) VALUES(28, 10);
INSERT INTO Tags(post_id, location_id) VALUES(29, 10);
INSERT INTO Tags(post_id, location_id) VALUES(30, 10);
INSERT INTO Tags(post_id, location_id) VALUES(31, 9);

INSERT INTO IsAt(activity_name, location_id) VALUES('Wine Tasting in Vienna', 1);
INSERT INTO IsAt(activity_name, location_id) VALUES('British Museum Tour', 2);
INSERT INTO IsAt(activity_name, location_id) VALUES('Spy Mission 888', 3);
INSERT INTO IsAt(activity_name, location_id) VALUES('Skytree Heist', 4);
INSERT INTO IsAt(activity_name, location_id) VALUES('Mexico Cruise', 5);
INSERT INTO IsAt(activity_name, location_id) VALUES('Iztaccíhuatl Hike', 5);
INSERT INTO IsAt(activity_name, location_id) VALUES('Pastry Tour', 8);
INSERT INTO IsAt(activity_name, location_id) VALUES('Malibu Meditation', 6);
INSERT INTO IsAt(activity_name, location_id) VALUES('Ginza Shopping', 4);
INSERT INTO IsAt(activity_name, location_id) VALUES('Farming', 10);

INSERT INTO IncludesActivity(trip_id, activity_name) VALUES(1, 'Wine Tasting in Vienna');
INSERT INTO IncludesActivity(trip_id, activity_name) VALUES(2, 'British Museum Tour');
INSERT INTO IncludesActivity(trip_id, activity_name) VALUES(3, 'Spy Mission 888');
INSERT INTO IncludesActivity(trip_id, activity_name) VALUES(4, 'Skytree Heist');
INSERT INTO IncludesActivity(trip_id, activity_name) VALUES(5, 'Mexico Cruise');
INSERT INTO IncludesActivity(trip_id, activity_name) VALUES(5, 'Iztaccíhuatl Hike');
INSERT INTO IncludesActivity(trip_id, activity_name) VALUES(8, 'Pastry Tour');
INSERT INTO IncludesActivity(trip_id, activity_name) VALUES(6, 'Malibu Meditation');
INSERT INTO IncludesActivity(trip_id, activity_name) VALUES(4, 'Ginza Shopping');
INSERT INTO IncludesActivity(trip_id, activity_name) VALUES(10, 'Farming');

INSERT INTO IncludesRestaurant(trip_id, restaurant_name) VALUES(1, 'SHIELD Fine Dining');
INSERT INTO IncludesRestaurant(trip_id, restaurant_name) VALUES(2, 'Fish & Chip Pub');
INSERT INTO IncludesRestaurant(trip_id, restaurant_name) VALUES(3, 'Putin’s Poutine');
INSERT INTO IncludesRestaurant(trip_id, restaurant_name) VALUES(4, 'Hello Kitty Cafe');
INSERT INTO IncludesRestaurant(trip_id, restaurant_name) VALUES(5, 'Taco food truck');
INSERT INTO IncludesRestaurant(trip_id, restaurant_name) VALUES(6, 'Stark Kitchen');
INSERT INTO IncludesRestaurant(trip_id, restaurant_name) VALUES(7, 'Berlin Burgers');
INSERT INTO IncludesRestaurant(trip_id, restaurant_name) VALUES(4, 'Asakusa Okonomiyaki Sometaro');
INSERT INTO IncludesRestaurant(trip_id, restaurant_name) VALUES(4, 'Totti Candy Factory');
INSERT INTO IncludesRestaurant(trip_id, restaurant_name) VALUES(2, 'Bombay Spice');

-- subject to change (create)
INSERT INTO OperatesAt(restaurant_name, location_id) VALUES('SHIELD Fine Dining', 1);
INSERT INTO OperatesAt(restaurant_name, location_id) VALUES('Fish & Chip Pub', 2);
INSERT INTO OperatesAt(restaurant_name, location_id) VALUES('Putin’s Poutine', 3);
INSERT INTO OperatesAt(restaurant_name, location_id) VALUES('Hello Kitty Cafe', 4);
INSERT INTO OperatesAt(restaurant_name, location_id) VALUES('Taco food truck', 5);
INSERT INTO OperatesAt(restaurant_name, location_id) VALUES('Stark Kitchen', 6);
INSERT INTO OperatesAt(restaurant_name, location_id) VALUES('Berlin Burgers', 7);
INSERT INTO OperatesAt(restaurant_name, location_id) VALUES('Asakusa Okonomiyaki Sometaro', 4);
INSERT INTO OperatesAt(restaurant_name, location_id) VALUES('Totti Candy Factory', 4);
INSERT INTO OperatesAt(restaurant_name, location_id) VALUES('Bombay Spice', 2);

INSERT INTO Attraction_In(attr_name, location_id, type, description, num_dollar_signs) VALUES('Vienna International Centre', 1, 'Gov building', 'United Nations Vienna Office', 0);
INSERT INTO Attraction_In(attr_name, location_id, type, description, num_dollar_signs) VALUES('London Bridge', 2, 'Monument', 'A famous, scenic London bridge at the heart of the city', 0);
INSERT INTO Attraction_In(attr_name, location_id, type, description, num_dollar_signs) VALUES('The Motherland Calls', 3, 'Monument', 'An impressively tall statue of a woman dedicated to the heroes of the Battle of Stalingrad', 0);
INSERT INTO Attraction_In(attr_name, location_id, type, description, num_dollar_signs) VALUES('Skytree', 4, 'Shopping', 'A popular cosmopolitan shopping centre inside a tall tower overlooking Tokyo', 1);
INSERT INTO Attraction_In(attr_name, location_id, type, description, num_dollar_signs) VALUES('Gulf Coast beach', 5, 'Nature', 'Beautiful waters perfect for swimming and relaxing', 0);
INSERT INTO Attraction_In(attr_name, location_id, type, description, num_dollar_signs) VALUES('Stark Mansion', 6, 'Mansion', 'My house', 0);
INSERT INTO Attraction_In(attr_name, location_id, type, description, num_dollar_signs) VALUES('Berlin Wall', 7, 'History', NULL, 0);
INSERT INTO Attraction_In(attr_name, location_id, type, description, num_dollar_signs) VALUES('Louvre', 8, 'Museum', NULL, 2);
INSERT INTO Attraction_In(attr_name, location_id, type, description, num_dollar_signs) VALUES('Tour Eiffel', 8, 'Museum', NULL, 2);
INSERT INTO Attraction_In(attr_name, location_id, type, description, num_dollar_signs) VALUES('Thanos’s new farm', 10, 'Farm', 'Fulfilling lifelong dreams', 3);

INSERT INTO IncludesAttraction(trip_id, attr_name, location_id) VALUES(1, 'Vienna International Centre', 1);
INSERT INTO IncludesAttraction(trip_id, attr_name, location_id) VALUES(2, 'London Bridge', 2);
INSERT INTO IncludesAttraction(trip_id, attr_name, location_id) VALUES(3, 'The Motherland Calls', 3);
INSERT INTO IncludesAttraction(trip_id, attr_name, location_id) VALUES(4, 'Skytree', 4);
INSERT INTO IncludesAttraction(trip_id, attr_name, location_id) VALUES(5, 'Gulf Coast beach', 5);
INSERT INTO IncludesAttraction(trip_id, attr_name, location_id) VALUES(6, 'Stark Mansion', 6);
INSERT INTO IncludesAttraction(trip_id, attr_name, location_id) VALUES(7, 'Berlin Wall', 7);
INSERT INTO IncludesAttraction(trip_id, attr_name, location_id) VALUES(8, 'Louvre', 8);
INSERT INTO IncludesAttraction(trip_id, attr_name, location_id) VALUES(8, 'Tour Eiffel', 8);
INSERT INTO IncludesAttraction(trip_id, attr_name, location_id) VALUES(10, 'Thanos’s new farm', 10); 

INSERT INTO Plans(username, trip_id) VALUES('ironman', 1);
INSERT INTO Plans(username, trip_id) VALUES('spidey', 2);
INSERT INTO Plans(username, trip_id) VALUES('blackwidow', 3);
INSERT INTO Plans(username, trip_id) VALUES('hawkeye', 4);
INSERT INTO Plans(username, trip_id) VALUES('ppotts', 5);
INSERT INTO Plans(username, trip_id) VALUES('ironman', 6);
INSERT INTO Plans(username, trip_id) VALUES('spidey', 7);
INSERT INTO Plans(username, trip_id) VALUES('shuri', 8);
INSERT INTO Plans(username, trip_id) VALUES('redwitch', 9);
INSERT INTO Plans(username, trip_id) VALUES('than0s', 10);
