insert into
    permiso (tipo, codename, nombre)
values (
        'evento',
        'add_evento_masivo',
        'Agregar eventos de forma masiva'
    );

ALTER TABLE `registro`
DROP FOREIGN KEY `fk_registro_evento`,
DROP FOREIGN KEY `fk_registro_usuario`;

ALTER TABLE `registro`
ADD CONSTRAINT `fk_registro_evento` FOREIGN KEY (`evento_id`) REFERENCES `evento` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
ADD CONSTRAINT `fk_registro_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;
