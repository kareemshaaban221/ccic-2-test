<?php
    $errors = $_SESSION['errors'] ?? [];
    unset($_SESSION['errors']);
?>

<?php if (! empty($errors)): ?>
    <div class="alert alert-danger">
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?= $error ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>