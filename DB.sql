USE architech;

INSERT INTO building (id, name, phone, city, zipcode, address) VALUES (1 ,'HETIC', '0176361007', 'Montreuil', '93100', '27 bis rue du Progrès');
INSERT INTO manager (id, last_name, first_name, phone, gender) VALUES (1 , 'Sitterlé', 'Frédéric', '0671215007', 'male');
UPDATE building set manager_id = 1 where id = 1;

INSERT INTO classroom (id, name, floor, zone, building_id) VALUES (1 , '101', 1, 'A', 1);
INSERT INTO classroom (id, name, floor, zone, building_id) VALUES (2 , '102', 1, 'A', 1);
INSERT INTO classroom (id, name, floor, zone, building_id) VALUES (3 , '103', 1, 'A', 1);
INSERT INTO classroom (id, name, floor, zone, building_id) VALUES (4 , '104', 1, 'A', 1);
INSERT INTO classroom (id, name, floor, zone, building_id) VALUES (5 , '105', 2, 'A', 1);
INSERT INTO classroom (id, name, floor, zone, building_id) VALUES (6 , '202', 2, 'A', 1);
INSERT INTO classroom (id, name, floor, zone, building_id) VALUES (8 , '203', 2, 'A', 1);
INSERT INTO classroom (id, name, floor, zone, building_id) VALUES (9 , '204', 2, 'A', 1);
INSERT INTO classroom (id, name, floor, zone, building_id) VALUES (10 , '106', 1, 'B', 1);
INSERT INTO classroom (id, name, floor, zone, building_id) VALUES (11 , '107', 1, 'B', 1);
INSERT INTO classroom (id, name, floor, zone, building_id) VALUES (12 , '108', 1, 'B', 1);
INSERT INTO classroom (id, name, floor, zone, building_id) VALUES (13 , '109', 1, 'B', 1);
INSERT INTO classroom (id, name, floor, zone, building_id) VALUES (14 , '110', 1, 'B', 1);
INSERT INTO classroom (id, name, floor, zone, building_id) VALUES (15 , '205', 2, 'A', 1);
INSERT INTO classroom (id, name, floor, zone, building_id) VALUES (16 , '206', 2, 'A', 1);
INSERT INTO classroom (id, name, floor, zone, building_id) VALUES (17 , '207', 2, 'A', 1);
INSERT INTO classroom (id, name, floor, zone, building_id) VALUES (18 , '208', 2, 'A', 1);
INSERT INTO classroom (id, name, floor, zone, building_id) VALUES (19 , '209', 2, 'A', 1);
INSERT INTO classroom (id, name, floor, zone, building_id) VALUES (20 , '210', 2, 'A', 1);

