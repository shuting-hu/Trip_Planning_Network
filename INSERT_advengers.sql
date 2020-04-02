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

INSERT INTO Regular_User(username, profile_picture) VALUES('ironman', '/Users/stark/Desktop/IMG_123.png');
INSERT INTO Regular_User(username, profile_picture) VALUES('spidey', '/Users/pparker/Desktop/me.jpg');
INSERT INTO Regular_User(username, profile_picture) VALUES('blackwidow', '/Users/natrom/Desktop/phase4.jpg');
INSERT INTO Regular_User(username, profile_picture) VALUES('hawkeye', '/Users/cbart/Desktop/arrow.jpg');
INSERT INTO Regular_User(username, profile_picture) VALUES('ppotts', '/Users/potts/Desktop/dp.jpg');
INSERT INTO Regular_User(username, profile_picture) VALUES('slang', '/Users/scott/Desktop/me-n-peanut.jpg');
INSERT INTO Regular_User(username, profile_picture) VALUES('redwitch', '/Users/wanda/Desktop/IMG_456.png');
INSERT INTO Regular_User(username, profile_picture) VALUES('gen.okoye', '/Users/ok/Desktop/sbux.jpg');
INSERT INTO Regular_User(username, profile_picture) VALUES('starlord', '/Users/starlord/Desktop/goodvibes.jpg');
INSERT INTO Regular_User(username, profile_picture) VALUES('than0s', '/Users/thanos/Desktop/IMG_666.png');

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

INSERT INTO Media(post_id, date) VALUES (1, '2020-03-27');
INSERT INTO Media(post_id, date) VALUES (2, '2020-03-27');
INSERT INTO Media(post_id, date) VALUES (3, '2020-03-27');
INSERT INTO Media(post_id, date) VALUES (4, '2020-03-27');
INSERT INTO Media(post_id, date) VALUES (5, '2020-03-27');
INSERT INTO Media(post_id, date) VALUES (6, '2020-03-27');
INSERT INTO Media(post_id, date) VALUES (7, '2020-03-27');
INSERT INTO Media(post_id, date) VALUES (8, '2020-03-27');
INSERT INTO Media(post_id, date) VALUES (9, '2020-03-27');
INSERT INTO Media(post_id, date) VALUES (10, '2020-03-27');
INSERT INTO Media(post_id, date) VALUES (11, '2020-03-27');
INSERT INTO Media(post_id, date) VALUES (12, '2020-03-27');
INSERT INTO Media(post_id, date) VALUES (13, '2020-03-27');
INSERT INTO Media(post_id, date) VALUES (14, '2020-03-27');
INSERT INTO Media(post_id, date) VALUES (15, '2020-03-27');
INSERT INTO Media(post_id, date) VALUES (16, '2020-03-27');
INSERT INTO Media(post_id, date) VALUES (17, '2020-03-27');
INSERT INTO Media(post_id, date) VALUES (18, '2020-03-27');
INSERT INTO Media(post_id, date) VALUES (19, '2020-03-27');
INSERT INTO Media(post_id, date) VALUES (20, '2020-03-27');
INSERT INTO Media(post_id, date) VALUES (21, '2020-03-27');
INSERT INTO Media(post_id, date) VALUES (22, '2020-03-27');
INSERT INTO Media(post_id, date) VALUES (23, '2020-03-27');
INSERT INTO Media(post_id, date) VALUES (24, '2020-03-27');
INSERT INTO Media(post_id, date) VALUES (25, '2020-03-27');
INSERT INTO Media(post_id, date) VALUES (26, '2020-03-27');
INSERT INTO Media(post_id, date) VALUES (27, '2020-03-27');
INSERT INTO Media(post_id, date) VALUES (28, '2020-03-27');
INSERT INTO Media(post_id, date) VALUES (29, '2020-03-27');
INSERT INTO Media(post_id, date) VALUES (30, '2020-03-27');
INSERT INTO Media(post_id, date) VALUES (31, '2020-03-27');

INSERT INTO Photo(post_id, caption, file_path) VALUES (1, 'Pleasure doing business.', '/Users/avengers/Desktop/avengersforever.jpg');
INSERT INTO Photo(post_id, caption, file_path) VALUES (2, 'POV: you''re THANOS', '/Users/avengers/Desktop/squad.jpg');
INSERT INTO Photo(post_id, caption, file_path) VALUES (3, 'Vienna, wow', '/Users/avengers/Desktop/architecture.jpg');
INSERT INTO Photo(post_id, caption, file_path) VALUES (4, 'Mastering the art of meditation in the comfort of my own home', '/Users/avengers/Desktop/room.jpg');
INSERT INTO Photo(post_id, caption, file_path) VALUES (5, 'Bug fixes ;)', '/Users/avengers/Desktop/tinkering.jpg');
INSERT INTO Photo(post_id, caption, file_path) VALUES (6, 'her.', '/Users/avengers/Desktop/london0.jpg');
INSERT INTO Photo(post_id, caption, file_path) VALUES (7, NULL, '/Users/avengers/Desktop/london1.jpg');
INSERT INTO Photo(post_id, caption, file_path) VALUES (8, NULL, '/Users/avengers/Desktop/tokyo.jpg');
INSERT INTO Photo(post_id, caption, file_path) VALUES (9, NULL, '/Users/avengers/Desktop/beach.jpg');
INSERT INTO Photo(post_id, caption, file_path) VALUES (10, 'Finally at peace.', '/Users/avengers/Desktop/happyfarmer.jpg');
INSERT INTO Photo(post_id, caption, file_path) VALUES (31, NULL, '/Users/avengers/Desktop/hiding.jpg');

INSERT INTO Video(post_id, url) VALUES(11, 'www.youtube.com/watch?v=3uZ7r-dpk_g');
INSERT INTO Video(post_id, url) VALUES(12, 'www.youtube.com/watch?v=aaaaaaaaaaaa6');
INSERT INTO Video(post_id, url) VALUES(13, 'www.youtube.com/watch?v=dQw4w9WgXcQ');
INSERT INTO Video(post_id, url) VALUES(14, 'www.youtube.com/watch?v=aaaaaaaaaaa11');
INSERT INTO Video(post_id, url) VALUES(15, 'www.youtube.com/watch?v=aaaaaaaaaaa12');
INSERT INTO Video(post_id, url) VALUES(16, 'www.youtube.com/watch?v=aaaaaaaaaaa12');
INSERT INTO Video(post_id, url) VALUES(17, 'https://www.youtube.com/watch?v=zNs3o4P4s1A');
INSERT INTO Video(post_id, url) VALUES(18, 'https://www.youtube.com/watch?v=ybji16u608U');
INSERT INTO Video(post_id, url) VALUES(19, 'https://www.youtube.com/watch?v=LXUSzXfdq_0');
INSERT INTO Video(post_id, url) VALUES(20, 'https://www.youtube.com/watch?v=9FkQ8I9DjlQ');

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
