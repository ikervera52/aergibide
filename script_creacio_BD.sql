START TRANSACTION;

-- --------------------------------------------------------
-- Tabla: foto_perfil_usuarios
-- --------------------------------------------------------
CREATE TABLE foto_perfil_usuarios (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(255) NOT NULL,
  ruta_archivo VARCHAR(255) NOT NULL UNIQUE,
  mime_tipo VARCHAR(127) NOT NULL,
  tamano BIGINT NOT NULL
) ENGINE=InnoDB;

-- --------------------------------------------------------
-- Tabla: usuarios
-- --------------------------------------------------------
CREATE TABLE usuarios (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(50) NOT NULL,
  tipo VARCHAR(50) NOT NULL,
  email VARCHAR(50) NOT NULL UNIQUE,
  contrasena VARCHAR(255) NOT NULL,
  datetime TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  foto_perfil_id INT NULL DEFAULT 1,
  CONSTRAINT fk_usuario_foto_perfil 
    FOREIGN KEY (foto_perfil_id) REFERENCES foto_perfil_usuarios (id) 
    ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB;

-- --------------------------------------------------------
-- Tabla: preguntas
-- --------------------------------------------------------
CREATE TABLE preguntas (
  id INT AUTO_INCREMENT PRIMARY KEY,
  usuario_id INT NOT NULL,
  titulo VARCHAR(100) NOT NULL,
  contenido VARCHAR(1000) NOT NULL,
  datetime TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  estado VARCHAR(20) NOT NULL DEFAULT 'abierta',
  misma_pregunta INT NOT NULL DEFAULT 0,
  categoria_pregunta_id INT NOT NULL,
  CONSTRAINT fk_categoria_pregunta 
    FOREIGN KEY (categoria_pregunta_id) REFERENCES categorias_preguntas (id)
    ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT fk_preguntas_usuario 
    FOREIGN KEY (usuario_id) REFERENCES usuarios (id) 
) ENGINE=InnoDB;

-- --------------------------------------------------------
-- Tabla: respuestas
-- --------------------------------------------------------
CREATE TABLE respuestas (
  id INT AUTO_INCREMENT PRIMARY KEY,
  pregunta_id INT NOT NULL,
  usuario_id INT NOT NULL,
  contenido VARCHAR(1000) NOT NULL,
  puntuacion INT NOT NULL DEFAULT 0,
  seleccionada TINYINT NOT NULL DEFALUT 0,
  datetime TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_respuestas_pregunta 
    FOREIGN KEY (pregunta_id) REFERENCES preguntas (id) 
    ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT fk_respuestas_usuario 
    FOREIGN KEY (usuario_id) REFERENCES usuarios (id) 
) ENGINE=InnoDB;

-- --------------------------------------------------------
-- Tabla: archivos
-- --------------------------------------------------------
CREATE TABLE archivos (
  id INT AUTO_INCREMENT PRIMARY KEY,
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
) ENGINE=InnoDB;

-- --------------------------------------------------------
-- Tabla: notificaciones
-- --------------------------------------------------------
CREATE TABLE notificaciones (
  id INT AUTO_INCREMENT PRIMARY KEY,
  usuario_id_p INT NOT NULL,
  usuario_id_r INT NOT NULL,
  pregunta_id INT NOT NULL,
  respuesta_id INT NOT NULL,
  CONSTRAINT fk_notif_respuesta
    FOREIGN KEY (respuesta_id) REFERENCES respuestas (id)
    ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT fk_notif_pregunta 
    FOREIGN KEY (pregunta_id) REFERENCES preguntas (id) 
    ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT fk_notif_usuario_p 
    FOREIGN KEY (usuario_id_p) REFERENCES usuarios (id) 
    ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT fk_notif_usuario_r 
    FOREIGN KEY (usuario_id_r) REFERENCES usuarios (id) 
    ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

-- --------------------------------------------------------
-- Tabla: preguntas_destacadas
-- --------------------------------------------------------
CREATE TABLE preguntas_destacadas (
    pregunta_id INT NOT NULL,
    usuario_id INT NOT NULL,
    PRIMARY KEY (pregunta_id, usuario_id),
    FOREIGN KEY (pregunta_id) REFERENCES preguntas(id) ON DELETE CASCADE,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
);

-- --------------------------------------------------------
-- Tabla: respuestas votadas
-- --------------------------------------------------------
CREATE TABLE respuestas_votadas (
    respuesta_id INT NOT NULL,
    usuario_id INT NOT NULL,
    PRIMARY KEY (respuesta_id, usuario_id),
    FOREIGN KEY (respuesta_id) REFERENCES respuestas(id) ON DELETE CASCADE,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
);

CREATE TABLE categorias_preguntas (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100) NOT NULL,
  slug VARCHAR (120) NOT NULL,
  PRIMARY KEY (id)
)

COMMIT;