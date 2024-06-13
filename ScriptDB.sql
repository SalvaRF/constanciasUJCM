
CREATE TABLE institucion
(
	id                   int NOT NULL AUTO_INCREMENT,
	nombre               VARCHAR(120) NULL,
	ruc                  VARCHAR(11) NULL,
	telefono             VARCHAR(15) NULL,
	anio                 VARCHAR(120) NULL,
	logo                 VARCHAR(50) NULL,
	firma1               VARCHAR(50) NULL,
	firma2               VARCHAR(50) NULL,
    PRIMARY KEY (id)
);


CREATE TABLE tipos_constancia
(
	id                   int NOT NULL AUTO_INCREMENT,
	tipo                 VARCHAR(30) NULL,
    PRIMARY KEY (id)
);


CREATE TABLE estudiantes
(
	id                   int NOT NULL AUTO_INCREMENT,
	nombres              VARCHAR(50) NULL,
	apepaterno           VARCHAR(50) NULL,
	apematerno           VARCHAR(50) NULL,
	carrera              VARCHAR(120) NULL,
	codigo               VARCHAR(15) NULL,
	dni                  VARCHAR(10) NULL,
	sede                 VARCHAR(20) NULL,
	facultad             VARCHAR(100) NULL,
    PRIMARY KEY (id)
);

CREATE TABLE constancias
(
	id                   int NOT NULL AUTO_INCREMENT,
	numero               VARCHAR(20) NULL,
	fecha                DATE NULL,
	url                  VARCHAR(100) NULL,
	id_estudiante        int NULL,
	recibo               VARCHAR(50) NULL,
	observacion          VARCHAR(100) NULL,
	semestre             VARCHAR(15) NULL,
	id_tipo              int NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (id_estudiante) REFERENCES estudiantes (id),
    FOREIGN KEY (id_tipo) REFERENCES tipos_constancia (id)
);



CREATE TABLE deudas
(
	id                   int NOT NULL AUTO_INCREMENT,
	concepto             VARCHAR(100) NULL,
	monto                DECIMAL(19,2) NULL,
	interes              DECIMAL(19,2) NULL,
	recargo              DECIMAL(19,2) NULL,
	total                DECIMAL(19,2) NULL,
	fecha_vence          DATE NULL,
	id_estudiante        int NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (id_estudiante) REFERENCES estudiantes (id)
);

CREATE TABLE pagos
(
	id                   int NOT NULL AUTO_INCREMENT,
	concepto             VARCHAR(100) NULL,
	monto                DECIMAL(19,2) NULL,
	numero               VARCHAR(50) NULL,
	id_estudiante        int NULL,
	PRIMARY KEY (id),
	FOREIGN KEY (id_estudiante) REFERENCES estudiantes (id)
);

INSERT INTO tipos_constancia
VALUES (1,'CONSTANCIA ECONÓMICA'),
(2, 'CONSTANCIA NO ADEUDO');


INSERT INTO institucion
VALUES 
(1,'UNIVERSIDAD JOSÉ CARLOS MARIÁTEGUI','20200848048','953722901',
'Año del Bicentenario, de la consolidación de nuestra Independencia, y de la conmemoración de las heroicas batallas de Junín y Ayacucho',
'ujcm.png','firma1.png','firma2.png'
);
