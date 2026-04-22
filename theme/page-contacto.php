<?php
/*
 * Template Name: Contacto
 */
get_header(); ?>
<main class="contacto-page">
    <div class="contacto-bg">
        <div class="container">

            <header class="contacto-header">
                <h1 class="contacto-header__title">CONTACTO<br><span>venza</span></h1>
            </header>

            <div class="contacto-form-wrap">
                <h2>¿Quieres saber más sobre nuestros productos?</h2>
                <p class="contacto-note">Campos marcados con (*) son obligatorios</p>
                <?php
                // Contact Form 7 — reemplazar el ID con el real después de crear el form
                if (function_exists('wpcf7_contact_form')) {
                    echo do_shortcode('[contact-form-7 id="FORM_ID" title="Contacto Venza"]');
                }
                ?>
            </div>

        </div>
    </div>
</main>
<?php get_footer(); ?>
