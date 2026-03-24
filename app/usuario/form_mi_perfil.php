<input type="hidden" name="pk" value="<?php echo htmlspecialchars($_SESSION['current_user']->pk ?? ''); ?>" />

<div class="row">
    <div class="col-sm-6">
        <div class="form-floating mb-3">
            <input type="text" required="required" class="form-control" id="nombre" name="nombre"
                placeholder="Nombre"
                value="<?php echo htmlspecialchars($_SESSION['current_user']->nombre ?? ''); ?>" />
            <label for="nombre">Nombre</label>
        </div>
        <div class="form-floating mb-3">
            <input type="text" required="required" class="form-control" id="apaterno" name="apaterno"
                placeholder="Apellido Paterno"
                value="<?php echo htmlspecialchars($_SESSION['current_user']->apaterno ?? ''); ?>" />
            <label for="apaterno">Apellido Paterno</label>
        </div>
        <div class="form-floating mb-3">
            <input type="text" class="form-control" id="amaterno" name="amaterno"
                placeholder="Apellido Materno"
                value="<?php echo htmlspecialchars($_SESSION['current_user']->amaterno ?? ''); ?>" />
            <label for="amaterno">Apellido Materno</label>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-floating mb-3">
            <input type="text" class="form-control" id="categoria" name="categoria"
                placeholder="Categoría"
                value="<?php echo htmlspecialchars($_SESSION['current_user']->categoria ?? ''); ?>" />
            <label for="categoria">Categoría</label>
        </div>
        <div class="form-floating mb-3">
            <input type="text" required="required" class="form-control" id="grupo" name="grupo"
                placeholder="Grupo"
                value="<?php echo htmlspecialchars($_SESSION['current_user']->grupo ?? ''); ?>" />
            <label for="grupo">Grupo</label>
        </div>
        <div class="form-floating mb-3">
            <input type="email" required="required" class="form-control" id="email" name="email"
                placeholder="E-Mail"
                value="<?php echo htmlspecialchars($_SESSION['current_user']->email ?? ''); ?>" />
            <label for="email">E-Mail</label>
        </div>
        <div class="form-floating mb-3">
            <input type="tel" required="required" class="form-control" id="whatsapp" name="whatsapp"
                placeholder="WhatsApp"
                value="<?php echo htmlspecialchars($_SESSION['current_user']->whatsapp ?? ''); ?>" />
            <label for="whatsapp">WhatsApp</label>
        </div>
    </div>
</div>
