BEGIN;

-- --------------------------------------------------------
-- Tabla: foto_perfil_usuarios
-- --------------------------------------------------------
CREATE TABLE foto_perfil_usuarios (
  id INT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
  nombre VARCHAR(255) NOT NULL,
  ruta_archivo VARCHAR(255) NOT NULL UNIQUE,
  mime_tipo VARCHAR(127) NOT NULL,
  tamano BIGINT NOT NULL
);

-- --------------------------------------------------------
-- Tabla: usuarios
-- --------------------------------------------------------
CREATE TABLE usuarios (
  id INT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
  nombre VARCHAR(50) NOT NULL,
  tipo VARCHAR(50) NOT NULL,
  email VARCHAR(50) NOT NULL UNIQUE,
  contrasena VARCHAR(255) NOT NULL,
  datetime TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, -- Fecha y hora actual por defecto
  foto_perfil_id INT DEFAULT 1,
  CONSTRAINT fk_usuario_foto_perfil 
    FOREIGN KEY (foto_perfil_id) REFERENCES foto_perfil_usuarios (id) 
    ON DELETE SET NULL ON UPDATE CASCADE
);

-- --------------------------------------------------------
-- Tabla: preguntas
-- --------------------------------------------------------
CREATE TABLE preguntas (
  id INT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
  usuario_id INT NOT NULL,
  titulo VARCHAR(100) NOT NULL,
  contenido VARCHAR(1000) NOT NULL,
  datetime TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, -- Fecha y hora actual por defecto
  estado VARCHAR(20) NOT NULL,
  misma_pregunta INT NOT NULL,
  CONSTRAINT fk_preguntas_usuario 
    FOREIGN KEY (usuario_id) REFERENCES usuarios (id) 
    ON DELETE CASCADE ON UPDATE CASCADE
);

-- --------------------------------------------------------
-- Tabla: respuestas
-- --------------------------------------------------------
CREATE TABLE respuestas (
  id INT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
  pregunta_id INT NOT NULL,
  usuario_id INT NOT NULL,
  contenido VARCHAR(1000) NOT NULL,
  puntuacion INT NOT NULL,
  datetime TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, -- Fecha y hora actual por defecto
  seleccionada BOOLEAN NOT NULL,
  CONSTRAINT fk_respuestas_pregunta 
    FOREIGN KEY (pregunta_id) REFERENCES preguntas (id) 
    ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT fk_respuestas_usuario 
    FOREIGN KEY (usuario_id) REFERENCES usuarios (id) 
    ON DELETE CASCADE ON UPDATE CASCADE
);

-- --------------------------------------------------------
-- Tabla: archivos (adjuntos de preguntas/respuestas)
-- --------------------------------------------------------
CREATE TABLE archivos (
  id INT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
  pregunta_id INT DEFAULT NULL,
  respuesta_id INT DEFAULT NULL,
  nombre VARCHAR(255) NOT NULL,
  ruta_archivo VARCHAR(255) NOT NULL UNIQUE,
  mime_tipo VARCHAR(127) NOT NULL,
  tamano BIGINT NOT NULL,
  CONSTRAINT fk_adjunto_pregunta 
    FOREIGN KEY (pregunta_id) REFERENCES preguntas (id) 
    ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT fk_adjunto_respuesta 
    FOREIGN KEY (respuesta_id) REFERENCES respuestas (id) 
    ON DELETE CASCADE ON UPDATE CASCADE
);

-- --------------------------------------------------------
-- Tabla: notificaciones
-- --------------------------------------------------------
CREATE TABLE notificaciones (
  id INT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
  usuario_id_p INT NOT NULL,
  usuario_id_r INT NOT NULL,
  pregunta_id INT NOT NULL,
  CONSTRAINT fk_notif_pregunta 
    FOREIGN KEY (pregunta_id) REFERENCES preguntas (id) 
    ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT fk_notif_usuario_p 
    FOREIGN KEY (usuario_id_p) REFERENCES usuarios (id) 
    ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT fk_notif_usuario_r 
    FOREIGN KEY (usuario_id_r) REFERENCES usuarios (id) 
    ON DELETE CASCADE ON UPDATE CASCADE
);

-- --------------------------------------------------------
-- Tabla: preguntas_destacadas
-- --------------------------------------------------------
CREATE TABLE preguntas_destacadas (
  id INT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
  usuario_id INT NOT NULL,
  pregunta_id INT NOT NULL,
  CONSTRAINT uq_destacada UNIQUE (usuario_id, pregunta_id),
  CONSTRAINT fk_destacadas_pregunta 
    FOREIGN KEY (pregunta_id) REFERENCES preguntas (id) 
    ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT fk_destacadas_usuario 
    FOREIGN KEY (usuario_id) REFERENCES usuarios (id) 
    ON DELETE CASCADE ON UPDATE CASCADE
);

COMMIT;