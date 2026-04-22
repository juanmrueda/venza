<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="site-header" id="site-header">
    <div class="container">
        <a href="<?php echo home_url('/'); ?>" class="site-logo" aria-label="Venza - Inicio">
            <?php
            if (has_custom_logo()) {
                the_custom_logo();
            } else {
                echo '<img src="' . VENZA_URI . '/assets/images/logo.svg" alt="Venza" width="120" height="40">';
            }
            ?>
        </a>

        <nav class="site-nav" id="site-nav" aria-label="Navegación principal">
            <?php
            wp_nav_menu([
                'theme_location' => 'primary',
                'menu_class'     => 'nav-menu',
                'container'      => false,
                'fallback_cb'    => false,
            ]);
            ?>
        </nav>

        <div class="header-social">
            <span class="header-social__label">Síguenos</span>
            <?php get_template_part('template-parts/global/social-links'); ?>
        </div>

        <button class="nav-toggle" id="nav-toggle" aria-label="Abrir menú" aria-expanded="false" aria-controls="site-nav">
            <span></span><span></span><span></span>
        </button>
    </div>
</header>
