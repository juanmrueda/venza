<?php
get_header();

$render_rich_text = static function ($text, $class = '') {
    $text = trim((string) $text);
    if ($text === '') {
        return;
    }

    $class_attr = $class !== '' ? ' class="' . esc_attr($class) . '"' : '';
    echo '<div' . $class_attr . '>' . wp_kses_post(wpautop($text)) . '</div>';
};

$get_image_id = static function ($key, $post_id) {
    $value = venza_get_meta_value($key, $post_id);
    $image_id = is_numeric($value) ? (int) $value : 0;

    if ($image_id <= 0 && is_array($value) && isset($value['ID'])) {
        $image_id = (int) $value['ID'];
    }

    return $image_id;
};

$get_featured_or_meta_image_id = static function ($key, $post_id) use ($get_image_id) {
    if (has_post_thumbnail($post_id)) {
        return (int) get_post_thumbnail_id($post_id);
    }

    return $get_image_id($key, $post_id);
};
?>
<main class="blog-single">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <?php
        $post_id = get_the_ID();
        $hero_image_id = $get_featured_or_meta_image_id('blog_hero_image_id', $post_id);
        $hero_intro = trim((string) venza_get_meta_value('blog_hero_intro', $post_id));
        if ($hero_intro === '') {
            $hero_intro = has_excerpt($post_id) ? get_the_excerpt($post_id) : venza_get_post_preview_text($post_id, 22);
        }

        $hero_body = trim((string) venza_get_meta_value('blog_hero_body', $post_id));
        if ($hero_body === '') {
            $hero_body = venza_get_post_preview_text($post_id, 34);
        }

        $fallback_texts = [
            'Estos pequenos momentos en los que <strong>te apartas de las pantallas o tareas y le das un respiro a tu cuerpo</strong> aunque solo sean <strong>5 o 10 minutos</strong>, no son poca cosa: son justo lo que tu cerebro necesita para mantenerse activo y rendir mejor.',
            '<strong>Estirate, respira con la tecnica 4-7-8</strong> (inhala durante 4 segundos, reten el aire por 7 segundos y exhala durante 8), ve a tu tienda favorita por un cafe o un te de hierbas, o simplemente date el gusto de un dulce.',
            'En esos momentos, tu cerebro tiene la oportunidad de <strong>desconectarse, liberar tensiones y reorganizar las ideas.</strong><br>Si haces de estos pequenos descansos un habito, no solo notaras el cambio en tu tranquilidad y te sentiras mas relajado, sino que tambien aumentaras tu productividad.',
            'Asi que, la proxima vez que te sientas abrumado, haz una pausa: <strong>estirate, toma agua, respira hondo... y vuelve con mas energia para terminar tu dia con exito.</strong>',
        ];
        ?>
        <article class="blog-single-page blog-single-page--type1">
            <section class="blog-t1-hero">
                <div class="container blog-t1-hero__container">
                    <div class="blog-t1-hero__copy">
                        <h1><?php the_title(); ?></h1>
                        <?php $render_rich_text($hero_intro, 'blog-t1-hero__intro'); ?>
                        <?php $render_rich_text($hero_body, 'blog-t1-hero__body'); ?>
                    </div>
                    <div class="blog-t1-hero__media">
                        <?php if ($hero_image_id > 0) : ?>
                            <?php echo wp_get_attachment_image($hero_image_id, 'blog-hero', false, ['loading' => 'eager']); ?>
                        <?php else : ?>
                            <span class="blog-t1-hero__placeholder"></span>
                        <?php endif; ?>
                    </div>
                </div>
            </section>

            <section class="blog-t1-blocks">
                <div class="blog-t1-grid">
                    <?php for ($i = 1; $i <= 4; $i++) : ?>
                        <?php
                        $block_image_id = $get_image_id('blog_t1_block_' . $i . '_image_id', $post_id);
                        if ($block_image_id <= 0) {
                            $block_image_id = $hero_image_id;
                        }
                        $block_text = trim((string) venza_get_meta_value('blog_t1_block_' . $i . '_text', $post_id));
                        if ($block_text === '') {
                            $block_text = $fallback_texts[$i - 1] ?? '';
                        }
                        $block_style = trim((string) venza_get_meta_value('blog_t1_block_' . $i . '_style', $post_id));
                        if (!in_array($block_style, ['light', 'blue'], true)) {
                            $block_style = in_array($i, [1, 3], true) ? 'blue' : 'light';
                        }
                        $overlay_image_id = $get_image_id('blog_t1_block_' . $i . '_overlay_image_id', $post_id);
                        $overlay_position = trim((string) venza_get_meta_value('blog_t1_block_' . $i . '_overlay_position', $post_id));
                        $allowed_overlay_positions = [
                            'top-left',
                            'top-center',
                            'top-right',
                            'center-left',
                            'center-right',
                            'bottom-left',
                            'bottom-center',
                            'bottom-right',
                        ];
                        if (!in_array($overlay_position, $allowed_overlay_positions, true)) {
                            $overlay_position = in_array($i, [1, 3], true) ? 'bottom-left' : 'top-right';
                        }

                        $image_cell = '<div class="blog-t1-cell blog-t1-cell--image">';
                        if ($block_image_id > 0) {
                            $image_cell .= wp_get_attachment_image($block_image_id, 'full', false, ['loading' => 'lazy']);
                        } else {
                            $image_cell .= '<span class="blog-t1-cell__placeholder"></span>';
                        }
                        $image_cell .= '</div>';

                        $text_cell = '<div class="blog-t1-cell blog-t1-cell--text blog-t1-cell--' . esc_attr($block_style) . '">'
                            . '<div class="blog-t1-cell__copy">' . wp_kses_post(wpautop($block_text)) . '</div>';

                        if ($overlay_image_id > 0) {
                            $text_cell .= '<div class="blog-t1-cell__overlay blog-t1-cell__overlay--' . esc_attr($overlay_position) . '">'
                                . wp_get_attachment_image($overlay_image_id, 'large', false, [
                                    'class'   => 'blog-t1-cell__overlay-img',
                                    'loading' => 'lazy',
                                ])
                                . '</div>';
                        }

                        $text_cell .= '</div>';
                        ?>
                        <?php
                        if ($i % 2 === 1) {
                            echo $image_cell; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                            echo $text_cell; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                        } else {
                            echo $text_cell; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                            echo $image_cell; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                        }
                        ?>
                    <?php endfor; ?>
                </div>
            </section>
        </article>
    <?php endwhile; endif; ?>
</main>
<?php get_footer(); ?>
