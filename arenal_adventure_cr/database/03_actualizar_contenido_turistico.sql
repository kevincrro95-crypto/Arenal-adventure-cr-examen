USE turismo_cr;

SET FOREIGN_KEY_CHECKS = 0;

-- Se usa DELETE en lugar de TRUNCATE porque MariaDB puede impedir
-- truncar tablas relacionadas por llaves foráneas.
DELETE FROM reservation_activities;
DELETE FROM reservations;
DELETE FROM activities;
DELETE FROM hotels;
DELETE FROM destinations;

ALTER TABLE reservation_activities AUTO_INCREMENT = 1;
ALTER TABLE reservations AUTO_INCREMENT = 1;
ALTER TABLE activities AUTO_INCREMENT = 1;
ALTER TABLE hotels AUTO_INCREMENT = 1;
ALTER TABLE destinations AUTO_INCREMENT = 1;

-- Actualiza solo el contenido turístico y conserva los usuarios existentes.
INSERT INTO destinations(name,province,description,image,latitude,longitude,status) VALUES
('La Fortuna','Alajuela','La Fortuna es uno de los principales destinos de aventura de Costa Rica. Ofrece vistas al Volcán Arenal, aguas termales, cataratas, senderos y recorridos de naturaleza.','assets/images/destino-la-fortuna.jpg',10.4678,-84.6427,1),
('Río Celeste','Alajuela','Río Celeste se encuentra en el Parque Nacional Volcán Tenorio y destaca por su agua turquesa, la catarata y los senderos rodeados de bosque tropical.','assets/images/destino-rio-celeste.jpg',10.7025,-84.9981,1),
('Monteverde','Puntarenas','Monteverde es reconocido por su bosque nuboso, puentes colgantes, reservas naturales y gran diversidad de flora y fauna.','assets/images/destino-monteverde.jpg',10.3000,-84.8167,1),
('Manuel Antonio','Puntarenas','Manuel Antonio combina playas del Pacífico, senderos y observación de fauna dentro y alrededor de su parque nacional.','assets/images/destino-manuel-antonio.jpg',9.3923,-84.1365,1),
('Playa Conchal','Guanacaste','Playa Conchal es conocida por su costa clara y arena formada por pequeños fragmentos de conchas. Es una opción popular para disfrutar Guanacaste.','assets/images/destino-playa-conchal.jpg',10.4005,-85.8086,1);

-- Hoteles reales de la zona. Los precios son valores académicos de referencia y se administran desde el sistema.
INSERT INTO hotels(destination_id,name,category,address,phone,email,price_per_night,rooms,description,image,status) VALUES
(1,'Arenal Manoa Hot Springs Resort',4,'La Palma, La Fortuna',NULL,NULL,98000,40,'Hospedaje rodeado de naturaleza con vistas al Volcán Arenal y espacios de aguas termales. Información incluida con fines académicos; la disponibilidad debe confirmarse con el hotel.','assets/images/hotel-arenal-manoa.webp',1),
(1,'Hotel Los Lagos Spa & Resort',4,'La Fortuna, San Carlos',NULL,NULL,85000,50,'Hotel de la zona de Arenal con piscinas, áreas termales y opciones para familias. El precio mostrado es una referencia para probar reservaciones.','assets/images/hotel-los-lagos.webp',1),
(1,'Arenal Observatory Lodge & Trails',4,'Parque Nacional Volcán Arenal',NULL,NULL,105000,35,'Lodge ubicado en un entorno natural con senderos, jardines y vistas del volcán y el bosque.','assets/images/hotel-arenal-observatory.jpg',1),
(1,'Volcano Lodge, Hotel & Thermal Experience',4,'La Palma, La Fortuna',NULL,NULL,92000,45,'Hotel con jardines tropicales, habitaciones con terraza y experiencia termal para huéspedes.','assets/images/hotel-volcano-lodge.jpg',1),
(1,'Hotel Magic Mountain',4,'La Fortuna centro',NULL,NULL,72000,36,'Opción cercana al centro de La Fortuna con acceso sencillo a comercios y actividades de la zona.','assets/images/hotel-magic-mountain.jpg',1),
(3,'Monteverde Country Lodge',3,'Santa Elena, Monteverde',NULL,NULL,58000,24,'Hospedaje de estilo rústico cerca de Santa Elena y de los atractivos naturales de Monteverde.','assets/images/hotel-monteverde-country-lodge.jpg',1),
(4,'Hotel Costa Verde',3,'Manuel Antonio, Quepos',NULL,NULL,78000,30,'Hospedaje rodeado de vegetación cerca de las playas y del Parque Nacional Manuel Antonio.','assets/images/hotel-costa-verde.jpg',1);

INSERT INTO activities(destination_id,name,type,description,price,duration,max_capacity,image,status) VALUES
(1,'Canopy con vista al Arenal','Canopy','Circuito de cables y plataformas en un entorno de bosque tropical.',32000,'3 horas',15,'https://images.unsplash.com/photo-1522163182402-834f871fd851?auto=format&fit=crop&w=1200&q=85',1),
(1,'Caminata a la Catarata La Fortuna','Senderismo','Recorrido por senderos y visita a la Catarata La Fortuna.',18000,'2 horas',20,'https://images.unsplash.com/photo-1432405972618-c60b0225b8f9?auto=format&fit=crop&w=1200&q=85',1),
(1,'Tour de aguas termales','Tours','Experiencia de descanso en aguas termales de la zona de Arenal.',28000,'4 horas',18,'https://images.unsplash.com/photo-1540555700478-4be289fbecef?auto=format&fit=crop&w=1200&q=85',1),
(1,'Rafting en el río Balsa','Rafting','Recorrido de aventura con guía y equipo de seguridad.',39000,'5 horas',12,'https://images.unsplash.com/photo-1530866495561-507c9faab2ed?auto=format&fit=crop&w=1200&q=85',1),
(2,'Sendero y Catarata Río Celeste','Senderismo','Caminata guiada por el Parque Nacional Volcán Tenorio.',24000,'4 horas',12,'assets/images/actividad-rio-celeste.jpg',1),
(3,'Puentes colgantes de Monteverde','Senderismo','Recorrido por puentes y senderos dentro del bosque nuboso.',26000,'3 horas',18,'assets/images/actividad-puentes-monteverde.jpg',1),
(4,'Tour de naturaleza en Manuel Antonio','Tours','Recorrido guiado para observar senderos, playas y fauna.',30000,'4 horas',15,'assets/images/destino-manuel-antonio.jpg',1),
(5,'Paseo en catamarán','Tours','Recorrido costero con vistas del Pacífico y tiempo para disfrutar el mar.',42000,'5 horas',20,'assets/images/actividad-catamaran.webp',1);

SET FOREIGN_KEY_CHECKS=1;
