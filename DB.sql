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

INSERT INTO incident (id, classroom_id, title, date, type, status) VALUES (1,1,'incident salle A101', '2021-7-4 14:13:54','high_humidity', 'assign');
INSERT INTO incident (id, classroom_id, title, date, type, status) VALUES (2,5,'incident salle A105', '2021-1-14 12:45:26','defective_air_conditioning', 'in_progress');
INSERT INTO incident (id, classroom_id, title, date, type, status) VALUES (3,10,'incident salle B106', '2021-7-7 08:05:06','heat_leak', 'finish');
INSERT INTO incident (id, classroom_id, title, date, type, status) VALUES (4,20,'incident salle A210', '2021-5-6 17:25:56','defective_air_conditioning', 'assign');
INSERT INTO incident (id, classroom_id, title, date, type, status) VALUES (5,14,'incident salle B110', '2021-3-16 18:55:56','heat_leak', 'assign');

INSERT INTO intervention (id, incident_id, datetime, company) VALUES (1, 1, '2021-8-16 14:00:00', 'Humidity Controller');
INSERT INTO intervention (id, incident_id, datetime, company) VALUES (2, 3, '2021-7-8 10:00:00', 'Solar');
INSERT INTO intervention (id, incident_id, datetime, company) VALUES (3, 4, '2021-5-18 09:00:00', 'Breath of the wild');
INSERT INTO intervention (id, incident_id, datetime, company) VALUES (4, 5, '2021-7-8 16:00:00', 'Solar');
