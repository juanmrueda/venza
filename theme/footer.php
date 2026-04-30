<?php /* RESPALDO ORIGINAL footer.php - 2026-04-30
Cambios: se elimino el menu de navegacion del footer (footer-nav).
Se agrego logo Venza + texto "es una marca registrada de:" + logo Dinant.
Codigo original en comentario HTML mas abajo.
*/ ?>
<!-- RESPALDO ORIGINAL:
<footer class="site-footer">
    <div class="container">
        <div class="footer-brand">
            <a href="HOME_URL" class="footer-brand__link" aria-label="Dinant - Inicio">
                <img src="VENZA_URI/assets/images/logos/dinant-logo.png" alt="Dinant" class="footer-brand__img" width="180" height="57" loading="lazy" decoding="async">
            </a>
        </div>
        <nav class="footer-nav" aria-label="Navegacion footer">
            wp_nav_menu([theme_location=>primary, menu_class=>footer-menu, container=>false, fallback_cb=>venza_primary_menu_fallback]);
        </nav>
        <div class="footer-social">
            get_template_part(template-parts/global/social-links);
        </div>
    </div>
</footer>
END RESPALDO -->
<footer class="site-footer">
    <div class="container">
        <div class="footer-brand footer-brand--marca">
            <a href="<?php echo home_url('/'); ?>" class="footer-brand__link footer-brand__link--venza" aria-label="Venza - Inicio">
                <img src="<?php echo esc_url(VENZA_URI . '/assets/images/logos/logoVenza.svg'); ?>" alt="Venza" class="footer-brand__img footer-brand__img--venza" width="160" height="54" loading="lazy" decoding="async">
            </a>
            <span class="footer-brand__caption">es una marca registrada de:</span>
            <a href="https://www.dinant.com/" class="footer-brand__link footer-brand__link--dinant" target="_blank" rel="noopener" aria-label="Dinant">
                <img src="<?php echo esc_url(VENZA_URI . '/assets/images/logos/dinant-logo.png'); ?>" alt="Dinant" class="footer-brand__img footer-brand__img--dinant" width="140" height="44" loading="lazy" decoding="async">
            </a>
        </div>

        <div class="footer-social">
            <?php get_template_part('template-parts/global/social-links'); ?>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>