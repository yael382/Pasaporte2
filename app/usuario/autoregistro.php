<?php
// Vista de autoregistro
// Esta vista recibe las siguientes variables:
// $eventos: array de eventos disponibles
// $userId: ID del usuario actual
?>

<?php if (empty($eventos)): ?>
    <p>No hay eventos pendientes disponibles para registro.</p>
<?php else: ?>
    <table class="table table-hover">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Fecha</th>
                <th>Lugar</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($eventos as $ev): ?>
                <tr>
                    <td><?php echo htmlspecialchars($ev['nombre']); ?></td>
                    <td><?php echo htmlspecialchars($ev['fecha_hora']); ?></td>
                    <td><?php echo htmlspecialchars($ev['lugar']); ?></td>
                    <td>
                        <form method="post" style="margin:0;display:inline;">
                            <input type="hidden" name="evento_id" value="<?php echo htmlspecialchars($ev['id']); ?>">
                            <button type="submit" class="btn btn-primary btn-sm">Registrar</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>
