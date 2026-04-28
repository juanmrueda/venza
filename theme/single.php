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

        $blog_blocks = function_exists('venza_blog_t1_get_blocks') ? venza_blog_t1_get_blocks($post_id, $hero_image_id) : [];
        $allowed_overlay_positions = function_exists('venza_blog_t1_allowed_overlay_positions') ? venza_blog_t1_allowed_overlay_positions() : [];
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

            <?php if (!empty($blog_blocks)) : ?>
                <section class="blog-t1-blocks">
                    <div class="blog-t1-grid">
                        <?php foreach ($blog_blocks as $block) : ?>
                        <?php
                        $block_type = isset($block['type']) ? (string) $block['type'] : '';
                        ?>
                        <?php if ($block_type === 'image') : ?>
                            <?php $block_image_id = isset($block['image_id']) ? (int) $block['image_id'] : 0; ?>
                            <div class="blog-t1-cell blog-t1-cell--image">
                                <?php if ($block_image_id > 0) : ?>
                                    <?php echo wp_get_attachment_image($block_image_id, 'full', false, ['loading' => 'lazy']); ?>
                                <?php else : ?>
                                    <span class="blog-t1-cell__placeholder"></span>
                                <?php endif; ?>
                            </div>
                        <?php elseif ($block_type === 'text') : ?>
                            <?php
                            $block_text = isset($block['text']) ? (string) $block['text'] : '';
                            $block_style = isset($block['style']) && in_array($block['style'], ['light', 'blue'], true) ? $block['style'] : 'light';
                            $overlay_image_id = isset($block['overlay_image_id']) ? (int) $block['overlay_image_id'] : 0;
                            $overlay_position = isset($block['overlay_position']) ? (string) $block['overlay_position'] : 'top-right';
                            if (!in_array($overlay_position, $allowed_overlay_positions, true)) {
                                $overlay_position = 'top-right';
                            }
                            ?>
                            <div class="blog-t1-cell blog-t1-cell--text blog-t1-cell--<?php echo esc_attr($block_style); ?>">
                                <div class="blog-t1-cell__copy"><?php echo wp_kses_post(wpautop($block_text)); ?></div>
                                <?php if ($overlay_image_id > 0) : ?>
                                    <div class="blog-t1-cell__overlay blog-t1-cell__overlay--<?php echo esc_attr($overlay_position); ?>">
                                        <?php
                                        echo wp_get_attachment_image($overlay_image_id, 'large', false, [
                                            'class'   => 'blog-t1-cell__overlay-img',
                                            'loading' => 'lazy',
                                        ]);
                                        ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </section>
            <?php endif; ?>
        </article>
    <?php endwhile; endif; ?>
</main>
<?php get_footer(); ?>
