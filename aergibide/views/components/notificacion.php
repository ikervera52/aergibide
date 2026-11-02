<article class="notificacion" id="notificacion-<?= (int)$notificacion->id ?>">
    <a href="index.php?controller=RespuestaController&id=<?= (int)$notificacion->pregunta_id ?>">
        <h4><?= htmlspecialchars($notificacion->nombre) ?> ha respondido a tu pregunta</h4>
        <p>
            <?php if ($notificacion->contenido): ?>
                <?= mb_strimwidth($notificacion->contenido, 0, 30, "...") ?>
            <?php else: ?>
                <?= $notificacion->titulo ?>
            <?php endif; ?>
        </p>
    </a>
    <a href="javascript:eliminarNotificacion(<?= (int)$notificacion->id ?>)" class="eliminar-notificacion">Eliminar</a>
</article>