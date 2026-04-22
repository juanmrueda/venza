<footer class="site-footer">
    <div class="container">
        <div class="footer-brand">
            <a href="<?php echo home_url('/'); ?>" aria-label="Venza - Inicio">
                <img src="<?php echo VENZA_URI; ?>/assets/images/logo-dinant.svg" alt="Dinant" width="100">
            </a>
        </div>

        <nav class="footer-nav" aria-label="Navegación footer">
            <?php
            wp_nav_menu([
                'theme_location' => 'footer',
                'menu_class'     => 'footer-menu',
                'container'      => false,
                'fallback_cb'    => false,
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
