<?php
$categorias = get_terms(['taxonomy' => 'noticia_cat', 'hide_empty' => true]);
if (!$categorias || is_wp_error($categorias)) return;
$current = get_queried_object();
?>
<nav class="noticias-tabs" aria-label="Categorías de noticias">
    <div class="container">
        <?php foreach ($categorias as $cat) : ?>
            <a href="<?php echo get_term_link($cat); ?>"
               class="noticia-tab <?php echo (is_a($current, 'WP_Term') && $current->term_id === $cat->term_id) ? 'is-active' : ''; ?>">
                <?php echo esc_html($cat->name); ?>
            </a>
        <?php endforeach; ?>
    </div>
</nav>
