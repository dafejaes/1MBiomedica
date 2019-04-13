-- SE CARGAN USUARIOS
INSERT INTO `biome1m_usuarios` (`usuarios_id`, `usuarios_cedula`, `usuarios_nombres`, `usuarios_apellidos`, `usuarios_correo`, `usuarios_contrasena`, `usuarios_nacimiento`, `usuarios_ciudad`, `usuarios_departamento`, `usuarios_direccion`, `usuarios_lineacorreo`, `usuarios_correosespeciales`, `usuarios_borrado`, `usuarios_fechamodifi`, `usuarios_ingeniero`) VALUES
(1, 1234, 'prueba', 'prueba prueba', 'prueba@correo.com', '95B490918894B85EB280AF6B54DB9DBF811ED3D7', NOW(), 'CIUDAD', 'DEPARTAMENTO', 'DIRECCION', 1, 1, 0, NOW(), 1);

-- SE CARGAN PERFILES
INSERT INTO `biome1m_perfiles` (`perf_id`, `perf_nombre`, `perf_descripcion`) VALUES
(1, 'Usuarios - Ver', NULL),
(2, 'Usuarios - Crear', NULL),
(3, 'Usuarios - Editar', NULL),
(4, 'Usuarios - Permisos', NULL);

-- SE INICIALIZAN PERFILES
INSERT INTO biome1m_usuarios_has_biome1m_perfiles (biome1m_usuarios_usuarios_id, biome1m_perfiles_perf_id) VALUES
('1', '1'),
('1', '2'),
('1', '3'),
('1', '4');
