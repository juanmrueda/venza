<footer class="site-footer">
    <div class="container">
        <div class="footer-brand">
            <a href="<?php echo home_url('/'); ?>" class="footer-brand__link" aria-label="Dinant - Inicio">
                <img src="<?php echo esc_url(VENZA_URI . '/assets/images/logos/dinant-logo.png'); ?>" alt="Dinant" class="footer-brand__img" width="180" height="57" loading="lazy" decoding="async">
            </a>
        </div>

        <nav class="footer-nav" aria-label="Navegacion footer">
            <?php
            wp_nav_menu([
                'theme_location' => 'primary',
                'menu_class'     => 'footer-menu',
                'container'      => false,
                'fallback_cb'    => 'venza_primary_menu_fallback',
            ]);
            ?>
        </nav>

        <div class="footer-social">
            <?php get_template_part('template-parts/global/social-links'); ?>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
