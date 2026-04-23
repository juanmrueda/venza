<section class="home-venza-hoy">
    <div class="container">
        <h2 class="section-title section-title--lined">Venza hoy</h2>
    </div>

    <div class="home-venza-hoy__video-wrap">
        <img class="home-venza-hoy__video" src="<?php echo esc_url(VENZA_URI . '/assets/images/banners/bannerhomedemo.svg'); ?>" alt="Banner Venza hoy">
    </div>

    <div class="home-venza-hoy__news">
        <div class="container">
            <p class="home-venza-hoy__pill">Mira todas las novedades que Venza tiene para ti</p>

            <div class="venza-hoy-grid">
                <?php
                $items = get_posts([
                    'post_type'      => ['noticia', 'post'],
                    'posts_per_page' => 3,
                    'post_status'    => 'publish',
                    'orderby'        => 'date',
                    'order'          => 'DESC',
                ]);

                if (empty($items)) :
                    $placeholders = [
                        ['titulo' => 'Descubre el nuevo jabon Venza Crema Humectante', 'desc' => 'Elimina eficazmente bacterias y germenes, brindando una limpieza profunda que protege tu piel en cada uso.'],
                        ['titulo' => 'Fuerza, Bienestar y Empoderamiento este dia de la Mujer Hondurena', 'desc' => 'Elimina eficazmente bacterias y germenes, brindando una limpieza profunda que protege tu piel en cada uso.'],
                        ['titulo' => 'Venza lanza su nuevo aroma Manzana Fresh', 'desc' => 'Elimina eficazmente bacterias y germenes, brindando una limpieza profunda que protege tu piel en cada uso.'],
                    ];

                    foreach ($placeholders as $ph) : ?>
                        <article class="venza-hoy-card">
                            <div class="venza-hoy-card__img-wrap">
                                <div class="venza-hoy-card__placeholder"></div>
                            </div>
                            <div class="venza-hoy-card__body">
                                <h3><?php echo esc_html($ph['titulo']); ?></h3>
                                <p><?php echo esc_html($ph['desc']); ?></p>
                                <a href="#" class="btn btn--primary">Conoce mas</a>
                            </div>
                        </article>
                    <?php endforeach;
                else :
                    foreach ($items as $item) :
                        $desc = wp_strip_all_tags(wp_trim_words($item->post_excerpt ?: $item->post_content, 22));
                        ?>
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
                                <p><?php echo esc_html($desc); ?></p>
                                <a href="<?php echo esc_url(get_permalink($item->ID)); ?>" class="btn btn--primary">Conoce mas</a>
                            </div>
                        </article>
                    <?php endforeach;
                endif; ?>
            </div>
        </div>
    </div>
</section>
