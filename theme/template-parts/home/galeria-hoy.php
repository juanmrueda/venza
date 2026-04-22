<section class="home-venza-hoy">
    <div class="container">
        <h2 class="section-title">Venza hoy</h2>
        <p class="section-subtitle"><?php echo esc_html(venza_field('venza_hoy_subtitulo', 'option')); ?></p>
        <div class="venza-hoy-grid">
            <?php
            $items = venza_field('venza_hoy_items', 'option');
            if ($items) :
                foreach ($items as $item) : ?>
                    <article class="venza-hoy-card">
                        <?php echo wp_get_attachment_image($item['imagen']['ID'], 'noticia-card'); ?>
                        <div class="venza-hoy-card__content">
                            <h3><?php echo esc_html($item['titulo']); ?></h3>
                            <p><?php echo esc_html($item['descripcion']); ?></p>
                            <a href="<?php echo esc_url($item['enlace']); ?>" class="btn btn--outline">Conoce más</a>
                        </div>
                    </article>
                <?php endforeach;
            endif; ?>
        </div>
    </div>
</section>
