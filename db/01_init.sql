-- SE CARGAN USUARIOS
INSERT INTO `biome1m_usuarios` (`usuarios_id`, `usuarios_cedula`, `usuarios_nombres`, `usuarios_apellidos`, `usuarios_correo`, `usuarios_contrasena`, `usuarios_nacimiento`, `usuarios_ciudad`, `usuarios_departamento`, `usuarios_direccion`, `usuarios_lineacorreo`, `usuarios_correosespeciales`, `usuarios_borrado`, `usuarios_fechamodifi`, `usuarios_ingeniero`) VALUES
(1, 1234, 'prueba', 'prueba prueba', 'prueba@correo.com', '95B490918894B85EB280AF6B54DB9DBF811ED3D7', NOW(), 'CIUDAD', 'DEPARTAMENTO', 'DIRECCION', 1, 1, 0, NOW(), 1);

-- SE CARGAN PERFILES
INSERT INTO `dmt_perfiles` (`prf_id`, `prf_nombre`, `prf_descripcion`) VALUES
(1, 'Clientes - Ver', NULL),
(2, 'Clientes - Crear', NULL),
(3, 'Clientes - Editar', NULL),
(4, 'Clientes - Eliminar', NULL),
(5, 'Usuarios - Ver', NULL),
(6, 'Usuarios - Crear', NULL),
(7, 'Usuarios - Editar', NULL),
(8, 'Usuarios - Eliminar', NULL),
(9, 'Usuarios - Permisos', NULL);

-- SE INICIALIZAN PERFILES
INSERT INTO dmt_usuario_has_dmt_perfiles (dmt_usuario_usr_id, dmt_perfiles_prf_id, dtcreate) VALUES 
('1', '1', NOW()),
('1', '2', NOW()),
('1', '3', NOW()),
('1', '4', NOW()),
('1', '5', NOW()),
('1', '6', NOW()),
('1', '7', NOW()),
('1', '8', NOW()),
('1', '9', NOW());

INSERT INTO dmt_usuario_has_dmt_perfiles (dmt_usuario_usr_id, dmt_perfiles_prf_id, dtcreate) VALUES 
('2', '1', NOW()),
('2', '2', NOW()),
('2', '3', NOW()),
('2', '4', NOW()),
('2', '5', NOW()),
('2', '6', NOW()),
('2', '7', NOW()),
('2', '8', NOW()),
('2', '9', NOW());
