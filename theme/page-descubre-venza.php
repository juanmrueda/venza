<?php
/*
 * Template Name: Descubre Venza
 */
get_header();

$get_image_id = static function ($key, $post_id) {
    $value = venza_get_meta_value($key, $post_id);
    $image_id = is_numeric($value) ? (int) $value : 0;

    if ($image_id <= 0 && is_array($value) && isset($value['ID'])) {
        $image_id = (int) $value['ID'];
    }

    return $image_id;
};

$get_image_url = static function ($image_id, $size = 'full') {
    $image_id = (int) $image_id;
    if ($image_id <= 0) {
        return '';
    }

    $url = wp_get_attachment_image_url($image_id, $size);
    return is_string($url) ? $url : '';
};

$get_file_url = static function ($file_id) {
    $file_id = (int) $file_id;
    if ($file_id <= 0) {
        return '';
    }

    $url = wp_get_attachment_url($file_id);
    return is_string($url) ? $url : '';
};

$get_video_type = static function ($file_id, $url = '') {
    $file_id = (int) $file_id;
    if ($file_id > 0) {
        $mime = get_post_mime_type($file_id);
        if (is_string($mime) && $mime !== '') {
            return $mime;
        }
    }

    $path = strtolower((string) wp_parse_url((string) $url, PHP_URL_PATH));
    if (str_ends_with($path, '.webm')) {
        return 'video/webm';
    }
    if (str_ends_with($path, '.mov')) {
        return 'video/quicktime';
    }

    return 'video/mp4';
};

$get_link_attrs = static function ($url) {
    $host = wp_parse_url(home_url(), PHP_URL_HOST);
    $url_host = wp_parse_url($url, PHP_URL_HOST);

    if ($url_host && $host && strtolower((string) $url_host) !== strtolower((string) $host)) {
        return ' target="_blank" rel="noopener"';
    }

    return '';
};
?>
<main class="descubre-page descubre-video-page">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <?php
        $page_id = get_the_ID();

        $hero_title = trim((string) venza_get_meta_value('descubre_titulo', $page_id));
        if ($hero_title === '') {
            $hero_title = get_the_title($page_id);
        }

        $callout = trim((string) venza_get_meta_value('descubre_callout', $page_id));
        if ($callout === '') {
            $callout = trim((string) venza_get_meta_value('descubre_subtitulo', $page_id));
        }

        $video_poster_id = $get_image_id('descubre_video_poster_id', $page_id);
        if ($video_poster_id <= 0 && has_post_thumbnail($page_id)) {
            $video_poster_id = (int) get_post_thumbnail_id($page_id);
        }

        $video_file_id = $get_image_id('descubre_video_file_id', $page_id);
        $video_file_url = $get_file_url($video_file_id);

        $video_url = trim((string) venza_get_meta_value('descubre_video_url', $page_id));
        if ($video_url === '') {
            $legacy_youtube = trim((string) venza_get_meta_value('descubre_video_youtube', $page_id));
            if ($legacy_youtube !== '') {
                $video_url = filter_var($legacy_youtube, FILTER_VALIDATE_URL)
                    ? $legacy_youtube
                    : 'https://www.youtube.com/watch?v=' . rawurlencode($legacy_youtube);
            }
        }

        $videos_title = trim((string) venza_get_meta_value('descubre_videos_title', $page_id));
        if ($videos_title === '') {
            $videos_title = 'Videos Venza';
        }

        $cta_text = trim((string) venza_get_meta_value('descubre_cta_text', $page_id));
        if ($cta_text === '') {
            $cta_text = 'Visita nuestro canal de Youtube';
        }

        $cta_url = trim((string) venza_get_meta_value('descubre_cta_url', $page_id));
        if ($cta_url === '') {
            $cta_url = trim((string) venza_get_meta_value('youtube_channel_url', $page_id));
        }
        if ($cta_url === '' || $cta_url === '#') {
            $cta_url = 'https://www.youtube.com/@jabonvenza';
        }

        $use_background_image = (bool) venza_get_meta_value('descubre_use_background_image', $page_id);
        $background_image_id = $use_background_image ? $get_image_id('descubre_background_image_id', $page_id) : 0;
        $background_url = $get_image_url($background_image_id, 'full');
        $page_style = $background_url !== '' ? '--blog-bg-image:url(' . esc_url($background_url) . ');' : '';

        $fallback_video_titles = [
            'Manos limpias, piel protegida',
            'Deja que creen libremente, mientras Venza cuida su piel',
            'Tu piel tambien necesita su momento',
            'Entrena duro y limpia tu piel con jabones Venza',
            'Respira, renueva y vuelve a empezar',
            'Rutinas de cuidado para cada dia',
        ];
        ?>
        <article class="blog-single-page blog-single-page--type2 descubre-video-page__content" style="<?php echo esc_attr($page_style); ?>">
            <section class="blog-t2-hero">
                <div class="container blog-t2-hero__container">
                    <h1><?php echo wp_kses_post($hero_title); ?></h1>
                    <?php if ($callout !== '') : ?>
                        <div class="blog-t2-hero__callout">
                            <?php echo wp_kses_post(wpautop($callout)); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </section>

            <section class="blog-t2-feature-video">
                <?php if ($video_file_url !== '') : ?>
                    <div class="blog-t2-feature-video__link blog-t2-feature-video__link--video">
                        <video controls preload="metadata">
                            <source src="<?php echo esc_url($video_file_url); ?>" type="<?php echo esc_attr($get_video_type($video_file_id, $video_file_url)); ?>">
                        </video>
                    </div>
                <?php elseif ($video_url !== '') : ?>
                    <a class="blog-t2-feature-video__link blog-t2-feature-video__link--external" href="<?php echo esc_url($video_url); ?>"<?php echo $get_link_attrs($video_url); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
                        <span class="blog-t2-feature-video__placeholder"></span>
                        <span class="blog-play blog-t2-feature-video__play" aria-hidden="true"></span>
                    </a>
                <?php else : ?>
                    <div class="blog-t2-feature-video__link">
                        <span class="blog-t2-feature-video__placeholder"></span>
                    </div>
                <?php endif; ?>
            </section>

            <section class="blog-t2-videos">
                <div class="container blog-t2-videos__container">
                    <span class="blog-t2-videos__icon" aria-hidden="true"></span>
                    <h2><?php echo esc_html($videos_title); ?></h2>
                    <a class="blog-t2-videos__cta" href="<?php echo esc_url($cta_url); ?>"<?php echo $get_link_attrs($cta_url); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>><?php echo esc_html($cta_text); ?></a>

                    <div class="blog-t2-video-strip">
                        <button class="blog-t2-video-strip__arrow blog-t2-video-strip__arrow--prev" type="button" aria-label="Anterior"></button>
                        <div class="blog-t2-video-strip__viewport">
                            <div class="blog-t2-video-strip__track">
                            <?php for ($i = 1; $i <= 6; $i++) : ?>
                                <?php
                                $enabled_raw = get_post_meta($page_id, 'descubre_video_' . $i . '_enabled', true);
                                $is_enabled = $enabled_raw === '' ? $i <= 4 : (bool) $enabled_raw;
                                if (!$is_enabled) {
                                    continue;
                                }

                                $card_image_id = $get_image_id('descubre_video_' . $i . '_image_id', $page_id);
                                if ($card_image_id <= 0) {
                                    $card_image_id = $video_poster_id;
                                }
                                $card_title = trim((string) venza_get_meta_value('descubre_video_' . $i . '_title', $page_id));
                                if ($card_title === '') {
                                    $card_title = $fallback_video_titles[$i - 1] ?? 'Video Venza';
                                }
                                $card_meta = trim((string) venza_get_meta_value('descubre_video_' . $i . '_meta', $page_id));
                                $card_duration = trim((string) venza_get_meta_value('descubre_video_' . $i . '_duration', $page_id));
                                $card_video_file_id = $get_image_id('descubre_video_' . $i . '_file_id', $page_id);
                                $card_video_file_url = $get_file_url($card_video_file_id);
                                $card_url = trim((string) venza_get_meta_value('descubre_video_' . $i . '_url', $page_id));
                                $card_href = $card_video_file_url !== '' ? $card_video_file_url : $card_url;
                                ?>
                                <?php if ($card_href !== '') : ?>
                                    <a class="blog-t2-video-card" href="<?php echo esc_url($card_href); ?>"<?php echo $get_link_attrs($card_href); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
                                        <span class="blog-t2-video-card__media">
                                            <?php if ($card_image_id > 0) : ?>
                                                <?php echo wp_get_attachment_image($card_image_id, 'noticia-card', false, ['loading' => 'lazy']); ?>
                                            <?php else : ?>
                                                <span class="blog-t2-video-card__placeholder"></span>
                                            <?php endif; ?>
                                            <?php if ($card_duration !== '') : ?>
                                                <span class="blog-t2-video-card__duration"><?php echo esc_html($card_duration); ?></span>
                                            <?php endif; ?>
                                            <span class="blog-t2-video-card__play" aria-hidden="true"></span>
                                        </span>
                                        <span class="blog-t2-video-card__content">
                                            <strong><?php echo esc_html($card_title); ?></strong>
                                            <span class="blog-t2-video-card__menu" aria-hidden="true"></span>
                                        </span>
                                        <?php if ($card_meta !== '') : ?>
                                            <small><?php echo esc_html($card_meta); ?></small>
                                        <?php endif; ?>
                                    </a>
                                <?php else : ?>
                                    <article class="blog-t2-video-card">
                                        <span class="blog-t2-video-card__media">
                                            <?php if ($card_image_id > 0) : ?>
                                                <?php echo wp_get_attachment_image($card_image_id, 'noticia-card', false, ['loading' => 'lazy']); ?>
                                            <?php else : ?>
                                                <span class="blog-t2-video-card__placeholder"></span>
                                            <?php endif; ?>
                                        </span>
                                        <span class="blog-t2-video-card__content">
                                            <strong><?php echo esc_html($card_title); ?></strong>
                                            <span class="blog-t2-video-card__menu" aria-hidden="true"></span>
                                        </span>
                                        <?php if ($card_meta !== '') : ?>
                                            <small><?php echo esc_html($card_meta); ?></small>
                                        <?php endif; ?>
                                    </article>
                                <?php endif; ?>
                            <?php endfor; ?>
                            </div>
                        </div>
                        <button class="blog-t2-video-strip__arrow blog-t2-video-strip__arrow--next" type="button" aria-label="Siguiente"></button>
                    </div>
                </div>
            </section>
        </article>
    <?php endwhile; endif; ?>
</main>
<?php get_footer(); ?>
