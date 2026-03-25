<h2 class="text-secondary">
    <i class="fa-solid fa-key"></i>
    Restaurar Contraseña
</h2>

<div class="card shadow-sm">
    <div class="card-body">
        <form method="post" action="usuarios.php?accion=restaurar-pwd" id="main-form" autocomplete="off">
            <input type="hidden" name="accion" value="restaurar-pwd" />

            <div class="row justify-content-center">
                <div class="col-sm-6">
                    <div class="form-floating mb-3">
                        <input type="text" required="required" class="form-control" id="username" name="username"
                            placeholder="Buscar usuario" autocomplete="off"
                            value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>" />
                        <label for="username">Usuario, nombre completo, matrícula o email</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" required="required" class="form-control" id="password" name="password"
                            placeholder="Nueva contraseña" autocomplete="new-password"
                            value="<?php echo htmlspecialchars($_POST['password'] ?? ''); ?>" />
                        <label for="password">Nueva contraseña</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" required="required" class="form-control" id="password_confirm" name="password_confirm"
                            placeholder="Confirmar contraseña" autocomplete="new-password"
                            value="<?php echo htmlspecialchars($_POST['password_confirm'] ?? ''); ?>" />
                        <label for="password_confirm">Confirmar contraseña</label>
                    </div>
                </div>
            </div>

            <div class="mt-3">
                <button type="submit" class="btn btn-outline-primary">
                    <i class="fa-solid fa-key"></i>
                    Restaurar Contraseña
                </button>
                <a href="usuarios.php" class="btn btn-outline-secondary ms-2">
                    <i class="fa-regular fa-circle-xmark"></i>
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
