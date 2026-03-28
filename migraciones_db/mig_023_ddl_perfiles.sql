INSERT INTO perfil (nombre)
SELECT 'admin' WHERE NOT EXISTS ( SELECT 1 FROM perfil WHERE nombre = 'admin' );

INSERT INTO perfil (nombre)
SELECT 'profesor' WHERE NOT EXISTS ( SELECT 1 FROM perfil WHERE nombre = 'profesor' );

INSERT INTO perfil (nombre)
SELECT 'qa' WHERE NOT EXISTS ( SELECT 1 FROM perfil WHERE nombre = 'qa' );

INSERT INTO perfil (nombre)
SELECT 'dev' WHERE NOT EXISTS ( SELECT 1 FROM perfil WHERE nombre = 'dev' );

ALTER TABLE asistencia DROP FOREIGN KEY fk_asistencia_evento;
ALTER TABLE asistencia DROP FOREIGN KEY fk_asistencia_staff;
ALTER TABLE asistencia DROP FOREIGN KEY fk_asistencia_usuario;

ALTER TABLE registro DROP FOREIGN KEY fk_registro_evento;
ALTER TABLE registro DROP FOREIGN KEY fk_registro_usuario;

ALTER TABLE asistencia
ADD CONSTRAINT fk_asistencia_evento FOREIGN KEY  (`evento_id`) REFERENCES `evento` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT;

ALTER TABLE asistencia
ADD CONSTRAINT fk_asistencia_staff FOREIGN KEY  (`registrado_por`) REFERENCES `usuario` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE asistencia
ADD CONSTRAINT fk_asistencia_usuario FOREIGN KEY  (`usuario_id`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT;

ALTER TABLE registro
ADD CONSTRAINT fk_registro_evento FOREIGN KEY (`evento_id`) REFERENCES `evento` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE registro
ADD CONSTRAINT fk_registro_usuario FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
