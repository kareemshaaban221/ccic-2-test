<?php
    $messages = $_SESSION['done'] ?? [];
    unset($_SESSION['done']);    
?>

<?php if (! empty($messages)): ?>
    <div class="alert alert-success" style="
        display: fixed;
        top: 50px;
        width: 100%;
        position: absolute;
        z-index: 1000;
    ">
        <ul>
            <?php foreach ($messages as $message): ?>
                <li><?= $message ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>