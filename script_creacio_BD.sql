START TRANSACTION;

-- --------------------------------------------------------
-- 1. Insertar fotos de perfil
-- --------------------------------------------------------
INSERT INTO foto_perfil_usuarios (id, nombre, ruta_archivo, mime_tipo, tamano) VALUES
(1, 'Default Avatar', './uploads/avatars/default-avatar.png', 'image/png', 10240);


-- --------------------------------------------------------
-- 2. Insertar usuarios (1 Admin, 1 Estándar y 1 adicional para interactuar)
-- --------------------------------------------------------
INSERT INTO usuarios (id, nombre, tipo, email, contrasena, foto_perfil_id) VALUES
(1, 'Admin', 'admin', 'admin@ejemplo.com', '12345Abcde', 1),
(2, 'Usuario', 'estandar', 'juan@ejemplo.com', '12345Abcde', 1);

-- --------------------------------------------------------
-- 3. Insertar categorías de preguntas
-- --------------------------------------------------------
INSERT INTO categorias_preguntas (id, nombre, slug) VALUES
(1, 'Programación Web', 'programacion-web'),
(2, 'Bases de Datos', 'bases-de-datos'),
(3, 'Sistemas Operativos', 'sistemas-operativos');

-- --------------------------------------------------------
-- 4. Insertar preguntas
-- --------------------------------------------------------
INSERT INTO preguntas (id, usuario_id, titulo, contenido, estado, misma_pregunta, categoria_pregunta_id) VALUES
(1, 2, '¿Cómo optimizar consultas SQL en MySQL?', 'Tengo una tabla con más de 1 millón de registros y las consultas van muy lentas. ¿Qué índices debería crear?', 'abierta', 3, 2),
(2, 1, '¿Diferencia entre VARCHAR y TEXT?', 'No tengo claro cuándo debería usar VARCHAR(1000) o pasar directamente a un campo de tipo TEXT.', 'cerrada', 1, 2),
(3, 1, 'Mantenimiento del servidor programado', 'El próximo domingo realizaremos tareas de mantenimiento en el servidor principal de 02:00 a 04:00 AM.', 'abierta', 0, 3);

-- --------------------------------------------------------
-- 5. Insertar respuestas
-- --------------------------------------------------------
INSERT INTO respuestas (id, pregunta_id, usuario_id, contenido, puntuacion, seleccionada) VALUES
(1, 1, 1, 'Asegúrate de agregar índices en las columnas que usas con frecuencia en la cláusula WHERE y JOIN. También revisa la ejecución con EXPLAIN.', 12, 1),
(2, 1, 1, 'Yo suelo usar EXPLAIN SELECT para ver si está usando los índices correctamente.', 4, 0),
(3, 2, 2, 'Usa VARCHAR cuando conozcas una longitud máxima razonable. Usa TEXT para textos largos sin límite definido.', 8, 1);

-- --------------------------------------------------------
-- 6. Insertar archivos adjuntos
-- --------------------------------------------------------
INSERT INTO archivos (id, pregunta_id, respuesta_id, nombre, ruta_archivo, mime_tipo, tamano) VALUES
(1, 1, NULL, 'ejemplo_query.sql', 'uploads/adjuntos/ejemplo_query.sql', 'text/plain', 2048),
(2, NULL, 1, 'explain_plan.png', 'uploads/adjuntos/explain_plan.png', 'image/png', 45000);

-- --------------------------------------------------------
-- 7. Insertar notificaciones
-- --------------------------------------------------------
INSERT INTO notificaciones (id, usuario_id_p, usuario_id_r, pregunta_id, respuesta_id) VALUES
(1, 2, 1, 1, 1), -- Notificación a Juan (creador de pregunta 1) sobre la respuesta de Admin
(2, 1, 2, 2, 1); -- Notificación a Maria (creadora de pregunta 2) sobre la respuesta de Juan

-- --------------------------------------------------------
-- 8. Insertar preguntas destacadas (favoritas)
-- --------------------------------------------------------
INSERT INTO preguntas_destacadas (pregunta_id, usuario_id) VALUES
(1, 2),
(1, 1),
(2, 1);

-- --------------------------------------------------------
-- 9. Insertar respuestas votadas
-- --------------------------------------------------------
INSERT INTO respuestas_votadas (respuesta_id, usuario_id) VALUES
(1, 2),
(1, 1),
(2, 1);

COMMIT;