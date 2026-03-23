SET @OLD_UNIQUE_CHECKS = @@UNIQUE_CHECKS, UNIQUE_CHECKS = 0;
SET
    @OLD_FOREIGN_KEY_CHECKS = @@FOREIGN_KEY_CHECKS,
    FOREIGN_KEY_CHECKS = 0;
SET
    @OLD_SQL_MODE = @@SQL_MODE,
    SQL_MODE = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- INICIO DE LA MIGRACION

-- 1. Insertar el permiso para la nueva funcionalidad
INSERT  INTO `permiso` (`tipo`, `codename`, `nombre`) VALUES
('asistencia', 'asistencia_registrar', 'Registrar asistencia a eventos');

-- Usando el nombre correcto: perfil_tiene_permiso
INSERT  INTO `perfil_tiene_permiso` (`perfil_id`, `permiso_id`)
SELECT 1, id FROM `permiso` WHERE `codename` = 'asistencia_registrar';

-- 3. Registrar esta migración en la tabla de control
INSERT INTO `migraciones` (`tipo`, `nombre`, `descripcion`, `archivo`) 
VALUES ('DML', 'Permisos Asistencia', 'Permisos para el registro de asistencia y escaneo de barcodes', 'mig_020_dml_permisos_asistencia.sql');

-- FIN DE LA MIGRACION

SET SQL_MODE = @OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS = @OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS = @OLD_UNIQUE_CHECKS;
