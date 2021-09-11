<?php if (!empty($errors[$fieldName])): ?>
    <?php foreach ($errors[$fieldName] as $message): ?>
        <small class="text-danger"><?= $message ?></small><br>
    <?php endforeach; ?>
<?php endif; ?>