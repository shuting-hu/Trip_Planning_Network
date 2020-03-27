INSERT INTO Follows VALUES ('ironman', 'ppotts');
INSERT INTO Follows VALUES ('spidey', 'ironman');
INSERT INTO Follows VALUES ('blackwidow', 'hawkeye');
INSERT INTO Follows VALUES ('hawkeye', 'blackwidow');
INSERT INTO Follows VALUES ('ironman', 'spidey');

INSERT INTO Plans VALUES ('ironman', 1, '2020-05-02');
INSERT INTO Plans VALUES ('spidey', 2, '2020-06-01');
INSERT INTO Plans VALUES ('blackwidow', 3, '2020-04-24');
INSERT INTO Plans VALUES ('hawkeye', 4, '2020-04-24');
INSERT INTO Plans VALUES ('ppotts', 5, '2020-04-04');

INSERT INTO Takes VALUES (1, 'plane', 7000);
INSERT INTO Takes VALUES (2, 'plane', 6000);
INSERT INTO Takes VALUES (3, 'boat', 1000);
INSERT INTO Takes VALUES (4, 'plane', 11000);
INSERT INTO Takes VALUES (5, 'car', 800);

INSERT INTO Posts VALUES (1, 1, '2020-05-02');
INSERT INTO Posts VALUES (2, 2, '2020-06-01');
INSERT INTO Posts VALUES (3, 3, '2020-04-24');
INSERT INTO Posts VALUES (4, 4, '2020-04-24');
INSERT INTO Posts VALUES (5, 5, '2020-04-04');
INSERT INTO Posts VALUES (6, 2, '2020-06-01');
INSERT INTO Posts VALUES (7, 2, '2020-06-01');
INSERT INTO Posts VALUES (8, 5, '2020-04-04');
INSERT INTO Posts VALUES (9, 2, '2020-06-01');
INSERT INTO Posts VALUES (10, 4, '2020-04-24');
INSERT INTO Posts VALUES (11, 4, '2020-04-24');
INSERT INTO Posts VALUES (12, 3, '2020-04-24');
INSERT INTO Posts VALUES (13, 1, '2020-05-02');
INSERT INTO Posts VALUES (14, 5, '2020-04-04');
INSERT INTO Posts VALUES (15, 2, '2020-06-01');

INSERT INTO Tags VALUES (1, 1);
INSERT INTO Tags VALUES (2, 2);
INSERT INTO Tags VALUES (3, 3);
INSERT INTO Tags VALUES (4, 4);
INSERT INTO Tags VALUES (5, 5);

INSERT INTO IsAt VALUES ('Wine tasting', 1);
INSERT INTO IsAt VALUES ('Museum tour', 2);
INSERT INTO IsAt VALUES ('Spy mission', 3);
INSERT INTO IsAt VALUES ('Shopping', 4);
INSERT INTO IsAt VALUES ('Cruise', 5);

INSERT INTO Includes VALUES (1, 'Wine tasting');
INSERT INTO Includes VALUES (2, 'Museum tour');
INSERT INTO Includes VALUES (3, 'Spy mission');
INSERT INTO Includes VALUES (4, 'Shopping');
INSERT INTO Includes VALUES (5, 'Cruise');

