INSERT INTO All_Users VALUES('ironman', 'iloveyou3000', 'Tony Stark');
INSERT INTO All_Users VALUES('spidey', 'uncleben', 'Peter Parker');
INSERT INTO All_Users VALUES('blackwidow', 'barton', 'Natasha Romanoff');
INSERT INTO All_Users VALUES('hawkeye', 'romanoff', 'Clint Barton');
INSERT INTO All_Users VALUES('ppotts', 'iloveyou3000', 'Pepper Potts');
INSERT INTO All_Users VALUES('warmach', 'mrstank', 'James Rhodes');
INSERT INTO All_Users VALUES('capUSA', 'april91921', 'Steve Rogers');
INSERT INTO All_Users VALUES('shuri', 'smarterthanmybrother', 'Shuri');
INSERT INTO All_Users VALUES('slang', 'iamantman', 'Scott Lang');
INSERT INTO All_Users VALUES('redwitch', 'mindgames', 'Wanda Maximoff');
INSERT INTO All_Users VALUES('than0s', 'perfectbalance', 'Thanos');
INSERT INTO All_Users VALUES('starlord', 'awesomemixvol1', 'Peter Quill');
INSERT INTO All_Users VALUES('gamora', 'whyisgamora', 'Gamora');
INSERT INTO All_Users VALUES('rocket', 'guardinthefrickingalaxy', 'Rocket Racoon');
INSERT INTO All_Users VALUES('gen.okoye', 'yibambe', 'Okoye');

INSERT INTO Regular_User VALUES('ironman', '/Users/stark/Desktop/IMG_123.png');
INSERT INTO Regular_User VALUES('spidey', '/Users/pparker/Desktop/me.jpg');
INSERT INTO Regular_User VALUES('blackwidow', '/Users/natrom/Desktop/phase4.jpg');
INSERT INTO Regular_User VALUES('hawkeye', '/Users/cbart/Desktop/arrow.jpg');
INSERT INTO Regular_User VALUES('ppotts', '/Users/potts/Desktop/dp.jpg');
INSERT INTO Regular_User VALUES('slang', '/Users/scott/Desktop/me-n-peanut.jpg');
INSERT INTO Regular_User VALUES('redwitch', '/Users/wanda/Desktop/IMG_456.png');
INSERT INTO Regular_User VALUES('gen.okoye', '/Users/ok/Desktop/sbux.jpg');
INSERT INTO Regular_User VALUES('starlord', '/Users/starlord/Desktop/goodvibes.jpg');
INSERT INTO Regular_User VALUES('than0s', '/Users/thanos/Desktop/IMG_666.png');

INSERT INTO Admin VALUES('ironman', 'Moderator', 'imironman@stark.net', 1);
INSERT INTO Admin VALUES('ppotts', 'Moderator', 'ceopotts@stark.net', 2);
INSERT INTO Admin VALUES('warmach', 'Security', 'colonelrhodey@avengers.com', 3);
INSERT INTO Admin VALUES('shuri', 'Engineer', 'wakandantech@gov.wa', 4);
INSERT INTO Admin VALUES('capUSA', 'Announcer', 'steverogers1918@hotmail.com', 5);
INSERT INTO Admin VALUES('than0s', 'Moderator', 'thanos@titans.net', 6);
INSERT INTO Admin VALUES('starlord', 'Announcer', 'starlord@guardians.net', 7);
INSERT INTO Admin VALUES('rocket', 'Engineer', 'rocket@guardians.net', 8);
INSERT INTO Admin VALUES('gamora', 'Moderator', 'gamora@guardians.net', 9);
INSERT INTO Admin VALUES('gen.okoye', 'Security', 'armygeneral@gov.wa', 10);

-- Activity

-- Location

INSERT INTO Trip_In VALUES('Avengers Forever', 1, 1, '1 week trip', 'For work');
INSERT INTO Trip_In VALUES('Far From Home', 2, 2, '1 week trip', 'School trip!');
INSERT INTO Trip_In VALUES('Mission: Home', 3, 3, '2 weeks+ trip', 'Mission 3478912');
INSERT INTO Trip_In VALUES('Who am I?', 4, 4, '1 week trip', 'Finding myself');
INSERT INTO Trip_In VALUES('Zero Work, All Vacation', 5, 5, '2 weeks+ trip', 'Well deserved');
INSERT INTO Trip_In VALUES('Staying Home', 6, 6, '2 weeks+ trip', 'quarantine');
INSERT INTO Trip_In VALUES('Lowkey Civil War', 7, 7, 'daytrip', 'omg so cool, I mean not war but...');
INSERT INTO Trip_In VALUES('Magnifique Paris', 8, 8, '2 weeks+ trip', 'oui');
INSERT INTO Trip_In VALUES('Escape to Italy', 9, 9, '2 weeks+ trip', 'shh');
INSERT INTO Trip_In VALUES('Happy Farmer Diaries', 10, 10, '2 weeks+ trip', 'Balance restored');

INSERT INTO Restaurant VALUES('SHIELD Fine Dining', 'Magical', 3);
INSERT INTO Restaurant VALUES('Fish & Chip Pub', 'British', 2);
INSERT INTO Restaurant VALUES('Putin’s Poutine', 'Fast Food', 1);
INSERT INTO Restaurant VALUES('Hello Kitty Cafe', 'Cafe', 2);
INSERT INTO Restaurant VALUES('Taco food truck', 'Mexican', 1);
INSERT INTO Restaurant VALUES('Stark Kitchen', 'Homemade', 3);
INSERT INTO Restaurant VALUES('Berlin Burgers', 'German', 2);
INSERT INTO Restaurant VALUES('Asakusa Okonomiyaki Sometaro', 'Japanese', 3);
INSERT INTO Restaurant VALUES('Totti Candy Factory', 'Dessert', 2);
INSERT INTO Restaurant VALUES('Bombay Spice', 'Indian', 2);

-- Media

-- Photo

-- Video

-- Text

INSERT INTO Posts VALUES(1, 1);
INSERT INTO Posts VALUES(2, 1);
INSERT INTO Posts VALUES(3, 1);
INSERT INTO Posts VALUES(4, 6);
INSERT INTO Posts VALUES(5, 6);
INSERT INTO Posts VALUES(6, 2);
INSERT INTO Posts VALUES(7, 2);
INSERT INTO Posts VALUES(8, 4);
INSERT INTO Posts VALUES(9, 5);
INSERT INTO Posts VALUES(10, 10);
INSERT INTO Posts VALUES(11, 7);
INSERT INTO Posts VALUES(12, 2);
INSERT INTO Posts VALUES(13, 2);
INSERT INTO Posts VALUES(14, 3);
INSERT INTO Posts VALUES(15, 3);
INSERT INTO Posts VALUES(16, 3);
INSERT INTO Posts VALUES(17, 3);
INSERT INTO Posts VALUES(18, 3);
INSERT INTO Posts VALUES(19, 4);
INSERT INTO Posts VALUES(20, 8);
INSERT INTO Posts VALUES(21, 6);
INSERT INTO Posts VALUES(22, 6);
INSERT INTO Posts VALUES(23, 5);
INSERT INTO Posts VALUES(24, 5);
INSERT INTO Posts VALUES(25, 5);
INSERT INTO Posts VALUES(26, 4);
INSERT INTO Posts VALUES(27, 8);
INSERT INTO Posts VALUES(28, 10);
INSERT INTO Posts VALUES(29, 10);
INSERT INTO Posts VALUES(30, 10);
INSERT INTO Posts VALUES(31, 9);

-- Tags

-- IsAt

INSERT INTO Includes VALUES(1, 'Wine Tasting in Vienna');
INSERT INTO Includes VALUES(2, 'British Museum Tour');
INSERT INTO Includes VALUES(3, 'Spy Mission 888');
INSERT INTO Includes VALUES(4, 'Skytree Heist');
INSERT INTO Includes VALUES(5, 'Mexico Cruise');
INSERT INTO Includes VALUES(6, 'Iztaccíhuatl Hike');
INSERT INTO Includes VALUES(7, 'Pastry Tour');
INSERT INTO Includes VALUES(8, 'Malibu Meditation');
INSERT INTO Includes VALUES(9, 'Ginza Shopping');
INSERT INTO Includes VALUES(10, 'Farming');

INSERT INTO OperatesAt VALUES('SHIELD Fine Dining', 1);
INSERT INTO OperatesAt VALUES('Fish & Chip Pub', 2);
INSERT INTO OperatesAt VALUES('Putin’s Poutine', 3);
INSERT INTO OperatesAt VALUES('Hello Kitty Cafe', 4);
INSERT INTO OperatesAt VALUES('Taco food truck', 5);
INSERT INTO OperatesAt VALUES('Stark Kitchen', 6);
INSERT INTO OperatesAt VALUES('Berlin Burgers', 7);
INSERT INTO OperatesAt VALUES('Asakusa Okonomiyaki Sometaro', 4);
INSERT INTO OperatesAt VALUES('Totti Candy Factory', 4);
INSERT INTO OperatesAt VALUES('Bombay Spice', 2);

-- Attraction_In

INSERT INTO Plans VALUES('ironman', 1);
INSERT INTO Plans VALUES('spidey', 2);
INSERT INTO Plans VALUES('blackwidow', 3);
INSERT INTO Plans VALUES('hawkeye', 4);
INSERT INTO Plans VALUES('ppotts', 5);
INSERT INTO Plans VALUES('ironman', 6);
INSERT INTO Plans VALUES('spidey', 7);
INSERT INTO Plans VALUES('shuri', 8);
INSERT INTO Plans VALUES('redwitch', 9);
INSERT INTO Plans VALUES('than0s', 10);
