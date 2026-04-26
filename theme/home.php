<?php
get_header();

$blog_page_id = (int) get_option('page_for_posts');
$theme_bg = VENZA_URI . '/assets/images/backgroundhome.png';
$background_image_id = $blog_page_id > 0 ? (int) venza_get_meta_value('blog_home_background_image_id', $blog_page_id) : 0;
$background_image_url = $background_image_id > 0 ? wp_get_attachment_image_url($background_image_id, 'full') : $theme_bg;
$background_color = $blog_page_id > 0 ? trim((string) venza_get_meta_value('blog_home_background_color', $blog_page_id)) : '';
if ($background_color === '') {
    $background_color = '#eaf3fb';
}
$button_text = $blog_page_id > 0 ? trim((string) venza_get_meta_value('blog_home_button_text', $blog_page_id)) : '';
if ($button_text === '') {
    $button_text = 'Conoce mas';
}

$style = '--blog-bg-color:' . esc_attr($background_color) . ';';
if ($background_image_url) {
    $style .= '--blog-bg-image:url(' . esc_url($background_image_url) . ');';
}
?>
<main class="blog-archive" style="<?php echo esc_attr($style); ?>">
    <section class="blog-archive__stage">
        <div class="container blog-archive__container">
            <div class="blog-list">
                <?php if (have_posts()) : ?>
                    <?php while (have_posts()) : the_post(); ?>
                        <?php get_template_part('template-parts/blog/card', null, ['button_text' => $button_text]); ?>
                    <?php endwhile; ?>
                <?php else : ?>
                    <article class="blog-card blog-card--empty">
                        <div class="blog-card__content">
                            <h2>Blog Venza</h2>
                            <p>Pronto compartiremos nuevas historias y consejos de cuidado.</p>
                        </div>
                    </article>
                <?php endif; ?>
            </div>

            <div class="blog-pagination">
                <?php
                the_posts_pagination([
                    'mid_size'  => 1,
                    'prev_text' => 'Anterior',
                    'next_text' => 'Siguiente',
                ]);
                ?>
            </div>
        </div>
    </section>
</main>
<?php get_footer(); ?>
