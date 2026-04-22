<section class="home-beneficios">
    <div class="container">
        <h2 class="section-title">Beneficios</h2>
        <?php
        $items = venza_field('home_beneficios', 'option');
        if ($items) :
            foreach ($items as $item) : ?>
                <div class="home-beneficio-item">
                    <div class="home-beneficio-item__image">
                        <?php echo wp_get_attachment_image($item['imagen']['ID'], 'large'); ?>
                    </div>
                    <div class="home-beneficio-item__content">
                        <h3><?php echo esc_html($item['titulo']); ?></h3>
                        <p><?php echo esc_html($item['descripcion']); ?></p>
                    </div>
                </div>
            <?php endforeach;
        endif; ?>
    </div>
</section>
