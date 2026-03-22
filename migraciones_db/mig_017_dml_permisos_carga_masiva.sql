insert into
    permiso (tipo, codename, nombre)
values (
        'usuario',
        'add_usuario_masivo',
        'Agregar usuarios de forma masiva'
    );

CREATE UNIQUE INDEX `idx_usuario_matricula` ON `usuario` (matricula) COMMENT '' ALGORITHM DEFAULT LOCK DEFAULT;

