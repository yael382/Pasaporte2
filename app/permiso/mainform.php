<input type="hidden" name="pk" value="<?php if (isset($object)) { echo htmlspecialchars($object->pk ?? ''); } ?>" />

<div class="form-floating mb-3">
    <input type="text" required="required" class="form-control" id="tipo" name="tipo" placeholder="Tipo de permiso" value="<?php if(isset($object)) { echo htmlspecialchars($object->tipo ?? ''); } ?>" />
    <label for="tipo">Tipo de permiso</label>
</div>
<div class="form-floating mb-3">
    <input type="text" required="required" class="form-control" id="codename" name="codename" placeholder="Codename del permiso" value="<?php if(isset($object)) { echo htmlspecialchars($object->codename ?? ''); } ?>" />
    <label for="codename">Codename del permiso</label>
</div>
<div class="form-floating mb-3">
    <input type="text" required="required" class="form-control" id="nombre" name="nombre" placeholder="Nombre del permiso" value="<?php if(isset($object)) { echo htmlspecialchars($object->nombre ?? ''); } ?>" />
    <label for="nombre">Nombre del permiso</label>
</div>
