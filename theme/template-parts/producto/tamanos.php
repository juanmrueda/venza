<?php
$tamanos = venza_field('producto_tamanos');
if (!$tamanos) return;
?>
<section class="producto-tamanos">
    <div class="container">
        <h2 class="section-title">Tamaños</h2>
        <div class="tamanos-grid">
            <?php foreach ($tamanos as $t) : ?>
                <div class="tamano-item">
                    <?php echo wp_get_attachment_image($t['imagen']['ID'], 'producto-thumb'); ?>
                    <h3><?php echo esc_html($t['nombre']); ?></h3>
                    <p><?php echo esc_html($t['descripcion']); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
