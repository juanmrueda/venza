<section class="home-venza-hoy">
    <div class="container">
        <h2 class="section-title">Venza hoy</h2>
        <p class="home-venza-hoy__subtitle">Más todas las novedades que Venza tiene para ti</p>
        <div class="venza-hoy-grid">
            <?php
            $items = get_posts([
                'post_type'      => ['noticia', 'post'],
                'posts_per_page' => 3,
                'post_status'    => 'publish',
                'orderby'        => 'date',
                'order'          => 'DESC',
            ]);
            // Placeholders si aún no hay contenido
            if (empty($items)) :
                $placeholders = [
                    ['titulo' => 'Nuevos Lanzamientos',   'desc' => 'Descubre la nueva línea de cuidado personal Venza.'],
                    ['titulo' => 'Activaciones Venza',    'desc' => 'Conoce nuestras actividades y el lado Venza del deporte.'],
                    ['titulo' => 'Repositorio Sensorial', 'desc' => 'Lleva la cotidianidad a otro nivel con Jabones Venza.'],
                ];
                foreach ($placeholders as $ph) : ?>
                    <article class="venza-hoy-card">
                        <div class="venza-hoy-card__img-wrap">
                            <div class="venza-hoy-card__placeholder"></div>
                        </div>
                        <div class="venza-hoy-card__body">
                            <h3><?php echo esc_html($ph['titulo']); ?></h3>
                            <p><?php echo esc_html($ph['desc']); ?></p>
                            <a href="#" class="btn btn--primary">Conoce más</a>
                        </div>
                    </article>
                <?php endforeach;
            else :
                foreach ($items as $item) : ?>
                    <article class="venza-hoy-card">
                        <div class="venza-hoy-card__img-wrap">
                            <?php if (has_post_thumbnail($item->ID)) : ?>
                                <?php echo get_the_post_thumbnail($item->ID, 'noticia-card', ['class' => 'venza-hoy-card__img']); ?>
                            <?php else : ?>
                                <div class="venza-hoy-card__placeholder"></div>
                            <?php endif; ?>
                        </div>
                        <div class="venza-hoy-card__body">
                            <h3><?php echo esc_html($item->post_title); ?></h3>
                            <p><?php echo esc_html(wp_trim_words($item->post_excerpt ?: $item->post_content, 15)); ?></p>
                            <a href="<?php echo get_permalink($item->ID); ?>" class="btn btn--primary">Conoce más</a>
                        </div>
                    </article>
                <?php endforeach;
            endif; ?>
        </div>
    </div>
</section>
