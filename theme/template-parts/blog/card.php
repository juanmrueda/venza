<?php
$post_id = get_the_ID();
$card_image = venza_get_meta_value('blog_card_image_id', $post_id);
$card_image_id = is_numeric($card_image) ? (int) $card_image : 0;
if ($card_image_id <= 0 && has_post_thumbnail($post_id)) {
    $card_image_id = (int) get_post_thumbnail_id($post_id);
}

$excerpt = trim((string) venza_get_meta_value('blog_card_excerpt', $post_id));
if ($excerpt === '') {
    $excerpt = venza_get_post_preview_text($post_id, 24);
}

$button_text = isset($args['button_text']) ? trim((string) $args['button_text']) : '';
$post_button_text = trim((string) venza_get_meta_value('blog_card_button_text', $post_id));
if ($post_button_text !== '') {
    $button_text = $post_button_text;
}
if ($button_text === '') {
    $button_text = 'Conoce mas';
}
?>
<article class="blog-card">
    <a class="blog-card__image" href="<?php the_permalink(); ?>" aria-label="<?php echo esc_attr(get_the_title()); ?>">
        <?php if ($card_image_id > 0) : ?>
            <?php echo wp_get_attachment_image($card_image_id, 'blog-card-wide', false, ['loading' => 'lazy']); ?>
        <?php else : ?>
            <span class="blog-card__placeholder"></span>
        <?php endif; ?>
    </a>

    <div class="blog-card__content">
        <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
        <?php if ($excerpt !== '') : ?>
            <p><?php echo esc_html($excerpt); ?></p>
        <?php endif; ?>
        <a href="<?php the_permalink(); ?>" class="btn blog-card__button"><?php echo esc_html($button_text); ?></a>
    </div>
</article>
