<?php
$beneficios = venza_field('producto_beneficios_pills');
if (!$beneficios) return;
?>
<section class="producto-beneficios-pills">
    <div class="container">
        <h2 class="section-title">Beneficios principales:</h2>
        <div class="pills-grid">
            <?php foreach ($beneficios as $item) : ?>
                <div class="pill">
                    <?php if (!empty($item['icono'])) : ?>
                        <?php echo wp_get_attachment_image($item['icono']['ID'], 'thumbnail', false, ['class' => 'pill__icon']); ?>
                    <?php endif; ?>
                    <span><?php echo esc_html($item['texto']); ?></span>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
