<section class="home-venza-hoy">
    <div class="container">
        <h2 class="section-title">Venza hoy</h2>
        <p class="section-subtitle">Más todas las novedades que Venza tiene para ti</p>
        <div class="venza-hoy-grid">
            <?php
            // Últimas 3 noticias o posts
            $items = get_posts([
                'post_type'      => ['noticia', 'post'],
                'posts_per_page' => 3,
                'post_status'    => 'publish',
                'orderby'        => 'date',
                'order'          => 'DESC',
            ]);
            if ($items) :
                foreach ($items as $item) :
            ?>
                <article class="venza-hoy-card">
                    <div class="venza-hoy-card__image">
                        <?php if (has_post_thumbnail($item->ID)) : ?>
                            <?php echo get_the_post_thumbnail($item->ID, 'noticia-card'); ?>
                        <?php else : ?>
                            <div class="venza-hoy-card__placeholder"></div>
                        <?php endif; ?>
                    </div>
                    <div class="venza-hoy-card__content">
                        <h3><?php echo esc_html($item->post_title); ?></h3>
                        <p><?php echo esc_html(wp_trim_words($item->post_excerpt ?: $item->post_content, 15)); ?></p>
                        <a href="<?php echo get_permalink($item->ID); ?>" class="btn btn--outline">Conoce más</a>
                    </div>
                </article>
            <?php
                endforeach;
            else :
            // Placeholders si no hay contenido aún
            $placeholders = [
                ['titulo' => 'Nuevos Lanzamientos', 'desc' => 'Descubre la nueva línea de cuidado personal Venza.'],
                ['titulo' => 'Activaciones Venza', 'desc' => 'Descubriendo el lado Venza del deporte y la vida.'],
                ['titulo' => 'Repositorio Sensorial', 'desc' => 'Lleva la cotidianidad a otro nivel con Venza.'],
            ];
            foreach ($placeholders as $ph) : ?>
                <article class="venza-hoy-card">
                    <div class="venza-hoy-card__image venza-hoy-card__placeholder"></div>
                    <div class="venza-hoy-card__content">
                        <h3><?php echo esc_html($ph['titulo']); ?></h3>
                        <p><?php echo esc_html($ph['desc']); ?></p>
                        <a href="#" class="btn btn--outline">Conoce más</a>
                    </div>
                </article>
            <?php endforeach;
            endif; ?>
        </div>
    </div>
</section>
