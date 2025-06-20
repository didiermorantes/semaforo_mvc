
CREATE DATABASE IF NOT EXISTS semaforo_db;
USE semaforo_db;

-- Tabla de compromisos
CREATE TABLE IF NOT EXISTS compromisos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    compromiso_especifico TEXT NOT NULL,
    direccion_responsable VARCHAR(100) NOT NULL,
    finalizado TINYINT(1) DEFAULT 0,
    pdf_finalizacion VARCHAR(255), -- Ruta del PDF de finalización
    fecha_creacion DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Tabla de avances de compromiso (historial de resúmenes y finalización)
CREATE TABLE IF NOT EXISTS avances (
    id INT AUTO_INCREMENT PRIMARY KEY,
    compromiso_id INT NOT NULL,
    resumen TEXT NOT NULL,
    usuario VARCHAR(100) NOT NULL,
    fecha_avance DATETIME DEFAULT CURRENT_TIMESTAMP,
    es_finalizacion TINYINT(1) DEFAULT 0, -- 0: avance, 1: es la finalización
    pdf_finalizacion VARCHAR(255),        -- Solo se llena si es_finalizacion = 1
    FOREIGN KEY (compromiso_id) REFERENCES compromisos(id)
);

-- Tabla de bitácora (ya existente, ahora con "Finalizado" como acción posible)
CREATE TABLE IF NOT EXISTS bitacora (
    id INT AUTO_INCREMENT PRIMARY KEY,
    compromiso_id INT NOT NULL,
    direccion_responsable VARCHAR(100) NOT NULL,
    accion VARCHAR(50) NOT NULL,
    fecha DATETIME DEFAULT CURRENT_TIMESTAMP
);