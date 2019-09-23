--
-- Tabla1
--
CREATE TABLE `c_nivel1` (
  `nivel1_id` int auto_increment,
  `nivel1_nombre` varchar(30) DEFAULT NULL,
  `nivel1_tipo` varchar(30) DEFAULT NULL,
PRIMARY KEY (`nivel1_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


INSERT INTO `c_nivel1` (`nivel1_id`, `nivel1_nombre`,`nivel1_tipo`) VALUES (	1	,'Awá','Nacionalidad');
INSERT INTO `c_nivel1` (`nivel1_id`, `nivel1_nombre`,`nivel1_tipo`) VALUES (	2	,'Chachi','Nacionalidad');
INSERT INTO `c_nivel1` (`nivel1_id`, `nivel1_nombre`,`nivel1_tipo`) VALUES (	3	,'Épera','Nacionalidad');
INSERT INTO `c_nivel1` (`nivel1_id`, `nivel1_nombre`,`nivel1_tipo`) VALUES (	4	,'Tsa´chila','Nacionalidad');
INSERT INTO `c_nivel1` (`nivel1_id`, `nivel1_nombre`,`nivel1_tipo`) VALUES (	5	,'Achuar','Nacionalidad');
INSERT INTO `c_nivel1` (`nivel1_id`, `nivel1_nombre`,`nivel1_tipo`) VALUES (	6	,'Andoa','Nacionalidad');
INSERT INTO `c_nivel1` (`nivel1_id`, `nivel1_nombre`,`nivel1_tipo`) VALUES (	7	,'Cofán','Nacionalidad');
INSERT INTO `c_nivel1` (`nivel1_id`, `nivel1_nombre`,`nivel1_tipo`) VALUES (	8	,'Sapara','Nacionalidad');
INSERT INTO `c_nivel1` (`nivel1_id`, `nivel1_nombre`,`nivel1_tipo`) VALUES (	9	,'Sekoya','Nacionalidad');
INSERT INTO `c_nivel1` (`nivel1_id`, `nivel1_nombre`,`nivel1_tipo`) VALUES (	10	,'Shiwiar','Nacionalidad');
INSERT INTO `c_nivel1` (`nivel1_id`, `nivel1_nombre`,`nivel1_tipo`) VALUES (	11	,'Shuar','Nacionalidad');
INSERT INTO `c_nivel1` (`nivel1_id`, `nivel1_nombre`,`nivel1_tipo`) VALUES (	12	,'Siona','Nacionalidad');
INSERT INTO `c_nivel1` (`nivel1_id`, `nivel1_nombre`,`nivel1_tipo`) VALUES (	13	,'Waorani','Nacionalidad');
INSERT INTO `c_nivel1` (`nivel1_id`, `nivel1_nombre`,`nivel1_tipo`) VALUES (	14	,'Kichwa','Nacionalidad');
INSERT INTO `c_nivel1` (`nivel1_id`, `nivel1_nombre`,`nivel1_tipo`) VALUES (	15	,'	Afroecuatoriano	','Pueblo');
INSERT INTO `c_nivel1` (`nivel1_id`, `nivel1_nombre`,`nivel1_tipo`) VALUES (	16	,'	Montuvios	','Pueblo');
INSERT INTO `c_nivel1` (`nivel1_id`, `nivel1_nombre`,`nivel1_tipo`) VALUES (	17	,'	Huancavilca 	','Pueblo');
INSERT INTO `c_nivel1` (`nivel1_id`, `nivel1_nombre`,`nivel1_tipo`) VALUES (	18	,'	Manta	','Pueblo');


--
-- Tabla2`
--

CREATE TABLE `c_nivel2` (
  `nivel2_id` int auto_increment,
  `nivel2_nombre` varchar(30) DEFAULT NULL,
  `nivel2_tipo` varchar(30) DEFAULT NULL,
  `nivel1_id` int,
PRIMARY KEY (`nivel2_id`),
  KEY `FK_C_NIVEL1` (`nivel1_id`),
  CONSTRAINT `FK_C_NIVEL1` FOREIGN KEY (`nivel1_id`) REFERENCES `c_nivel1` (`nivel1_id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;



INSERT INTO `c_nivel2` (`nivel2_id`, `nivel2_nombre`,`nivel2_tipo`, `nivel1_id`) VALUES (	1	,'Chibuleo','Pueblo',14);
INSERT INTO `c_nivel2` (`nivel2_id`, `nivel2_nombre`,`nivel2_tipo`, `nivel1_id`) VALUES (	2	,'Kañari','Pueblo',14);
INSERT INTO `c_nivel2` (`nivel2_id`, `nivel2_nombre`,`nivel2_tipo`, `nivel1_id`) VALUES (	3	,'Karanki','Pueblo',14);
INSERT INTO `c_nivel2` (`nivel2_id`, `nivel2_nombre`,`nivel2_tipo`, `nivel1_id`) VALUES (	4	,'Kayambi','Pueblo',14);
INSERT INTO `c_nivel2` (`nivel2_id`, `nivel2_nombre`,`nivel2_tipo`, `nivel1_id`) VALUES (	5	,'Kisapincha','Pueblo',14);
INSERT INTO `c_nivel2` (`nivel2_id`, `nivel2_nombre`,`nivel2_tipo`, `nivel1_id`) VALUES (	6	,'Kitu Kara','Pueblo',14);
INSERT INTO `c_nivel2` (`nivel2_id`, `nivel2_nombre`,`nivel2_tipo`, `nivel1_id`) VALUES (	7	,'Natabuela','Pueblo',14);
INSERT INTO `c_nivel2` (`nivel2_id`, `nivel2_nombre`,`nivel2_tipo`, `nivel1_id`) VALUES (	8	,'Otavalo','Pueblo',14);
INSERT INTO `c_nivel2` (`nivel2_id`, `nivel2_nombre`,`nivel2_tipo`, `nivel1_id`) VALUES (	9	,'Panzaleo','Pueblo',14);
INSERT INTO `c_nivel2` (`nivel2_id`, `nivel2_nombre`,`nivel2_tipo`, `nivel1_id`) VALUES (	10	,'Puruwá','Pueblo',14);
INSERT INTO `c_nivel2` (`nivel2_id`, `nivel2_nombre`,`nivel2_tipo`, `nivel1_id`) VALUES (	11	,'Salasaka','Pueblo',14);
INSERT INTO `c_nivel2` (`nivel2_id`, `nivel2_nombre`,`nivel2_tipo`, `nivel1_id`) VALUES (	12	,'Saraguro','Pueblo',14);
INSERT INTO `c_nivel2` (`nivel2_id`, `nivel2_nombre`,`nivel2_tipo`, `nivel1_id`) VALUES (	13	,'Tomabela','Pueblo',14);
INSERT INTO `c_nivel2` (`nivel2_id`, `nivel2_nombre`,`nivel2_tipo`, `nivel1_id`) VALUES (	14	,'Waranka','Pueblo',14);
INSERT INTO `c_nivel2` (`nivel2_id`, `nivel2_nombre`,`nivel2_tipo`, `nivel1_id`) VALUES (	15	,'Pasto','Pueblo',14);
INSERT INTO `c_nivel2` (`nivel2_id`, `nivel2_nombre`,`nivel2_tipo`, `nivel1_id`) VALUES (	16	,'Palta','Pueblo',14);
INSERT INTO `c_nivel2` (`nivel2_id`, `nivel2_nombre`,`nivel2_tipo`, `nivel1_id`) VALUES (	17	,'Kichwa de Amazonia','Pueblo',14);


--
-- Primera consulta para dar a elegir al usuario mostrando las opciones a primer nivel que no se subdividen
-- El usuario tendria solo 1 dato dependiendo del tipo (nacionalidad o pueblo)
select nivel1_id, nivel1_tipo, nivel1_nombre  from c_nivel1

--
-- Muestra concatenado el tipo y el nombre y agrega el id para hacer la busqueda en la siguiente consulta
-- 

SELECT nivel1_id,CONCAT( CONCAT(nivel1_tipo,' '), nivel1_nombre) As nombre FROM c_nivel1

--
-- segunda consulta solo al entrar a esta opcion el usuario tendria datos Nacionalidad y pueblo 
-- id 14 es la unica devicion Kichwa ( Permite que otras naciones tambien se subdividan)

select nivel2_tipo, nivel2_nombre  from c_nivel2 where nivel1_id = 14


SELECT nivel2_id,CONCAT( CONCAT(nivel2_tipo,' '), nivel2_nombre) As nombre FROM c_nivel2 where nivel1_id = 14
