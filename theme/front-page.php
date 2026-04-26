<?php
get_header();

$home_id = get_queried_object_id();
if (!$home_id) {
    $home_id = (int) get_option('page_on_front');
}

$home_styles = [];
$home_background_id = (int) venza_field('home_background_image', $home_id);
if ($home_background_id > 0) {
    $home_background_url = wp_get_attachment_image_url($home_background_id, 'full');
    if (is_string($home_background_url) && $home_background_url !== '') {
        $home_styles[] = '--home-bg-image: url(' . esc_url($home_background_url) . ')';
    }
}

$home_background_color = trim((string) venza_field('home_background_color', $home_id));
if ($home_background_color !== '') {
    $home_background_color = sanitize_hex_color($home_background_color);
    if ($home_background_color) {
        $home_styles[] = '--home-bg-color: ' . $home_background_color;
    }
}

$home_style_attr = !empty($home_styles) ? ' style="' . esc_attr(implode('; ', $home_styles)) . ';"' : '';
?>
<main class="home"<?php echo $home_style_attr; ?>>
    <?php get_template_part('template-parts/home/hero'); ?>
    <?php get_template_part('template-parts/home/productos-destacados'); ?>
    <?php get_template_part('template-parts/home/beneficios-strip'); ?>
    <?php get_template_part('template-parts/home/galeria-hoy'); ?>
</main>
<?php get_footer(); ?>
