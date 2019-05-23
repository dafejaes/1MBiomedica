-- SE CARGAN USUARIOS
INSERT INTO `biome1m_usuarios` (`usuarios_id`, `usuarios_cedula`, `usuarios_nombres`, `usuarios_apellidos`, `usuarios_correo`, `usuarios_contrasena`, `usuarios_nacimiento`, `usuarios_ciudad`, `usuarios_departamento`, `usuarios_direccion`, `usuarios_lineacorreo`, `usuarios_correosespeciales`, `usuarios_borrado`, `usuarios_fechamodifi`, `usuarios_ingeniero`) VALUES
(1, 1234, 'prueba', 'prueba prueba', 'prueba1@correo.com', '2057FCF0CB78F4F548394D68165A18F29D23DF40', NOW(), 'CIUDAD', 'DEPARTAMENTO', 'DIRECCION', 1, 1, 0, NOW(), 1),
(2, 1041611002, 'Daniel Felipe', 'Jaramillo Escobar', 'daniel.jaramilloe@udea.edu.co', '3A0759BF281D0CD71FEBA1B301F1A28045EDC6FC', '1993-07-27', 'Medellin', 'Antioquia', 'Cra 81 # 54a-55 Int 305', 1, 1, 0, NOW(), 1);

-- SE CARGAN PERFILES
INSERT INTO `biome1m_perfiles` (`perf_id`, `perf_nombre`, `perf_descripcion`) VALUES
(1, 'Usuarios - Ver', NULL),
(2, 'Usuarios - Crear', NULL),
(3, 'Usuarios - Editar', NULL),
(4, 'Usuarios - Eliminar', NULL),
(5, 'Usuarios - Permisos', NULL),
(6, 'Tipo Equipos - Ver', NULL),
(7, 'Tipo Equipos - Crear', NULL),
(8, 'Tipo Equipos - Editar', NULL),
(9, 'Tipo Equipos - Eliminar', NULL),
(10, 'Equipos - Ver', NULL),
(11, 'Equipos - Crear', NULL ),
(12, 'Equipos - Editar', NULL ),
(13, 'Equipos - Eliminar', NULL);

-- SE INICIALIZAN PERFILES
INSERT INTO biome1m_usuarios_has_biome1m_perfiles (biome1m_usuarios_usuarios_id, biome1m_perfiles_perf_id) VALUES
('1', '1'),
('1', '2'),
('1', '3'),
('1', '4'),
('1', '5'),
('1', '6'),
('1', '7'),
('1', '8'),
('1', '9'),
('1', '10'),
('1', '11'),
('1', '12'),
('1', '13'),
('2', '1'),
('2', '2'),
('2', '3'),
('2', '4'),
('2', '5'),
('2', '6'),
('2', '7'),
('2', '8'),
('2', '9'),
('2', '10'),
('2', '11'),
('2', '12'),
('2', '13');
