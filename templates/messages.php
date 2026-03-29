<?php if(isset($errors)): ?>
<?php foreach ($errors as $error): ?>
    <div class="alert alert-danger" role="alert">
        <?php echo htmlspecialchars($error); ?>
    </div>
<?php endforeach; ?>
<?php endif; ?>
