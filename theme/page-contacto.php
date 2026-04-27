<?php
/*
 * Template Name: Contacto
 */
get_header();

$page_id = (int) get_queried_object_id();

$get_text = static function ($key, $fallback) use ($page_id) {
    $value = trim((string) venza_get_meta_value($key, $page_id));
    return $value !== '' ? $value : $fallback;
};

$parse_lines = static function ($value, $fallback) {
    $value = trim((string) $value);
    if ($value === '') {
        $value = $fallback;
    }

    $items = array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', $value)));
    return array_values($items);
};

$bg_color = trim((string) venza_get_meta_value('contacto_bg_color', $page_id));
$bg_color = sanitize_hex_color($bg_color);
if ($bg_color === null || $bg_color === '') {
    $bg_color = '#eaf3fb';
}

$title_top = $get_text('contacto_title_top', 'CONTACTO');
$title_brand = $get_text('contacto_title_brand', 'venza');
$card_title = $get_text('contacto_card_title', '¿Quieres saber más sobre nuestros productos?');
$card_note = $get_text('contacto_card_note', 'Campos marcados con (*) son obligatorios');
$form_shortcode = trim((string) venza_get_meta_value('contacto_form_shortcode', $page_id));

$countries = $parse_lines(
    venza_get_meta_value('contacto_countries', $page_id),
    "Honduras\nGuatemala\nCosta Rica\nEl Salvador\nNicaragua\nRepublica Dominicana"
);
$reasons = $parse_lines(
    venza_get_meta_value('contacto_reasons', $page_id),
    "Soy Cliente\nQuiero Ser Cliente\nExportaciones\nQuiero Ser Proveedor\nSoy Periodista o Medio\nInvitaciones, Donaciones, Otros"
);
?>
<main class="contacto-page" style="<?php echo esc_attr('--contacto-bg:' . $bg_color . ';'); ?>">
    <section class="contacto-hero">
        <div class="container contacto-hero__container">
            <header class="contacto-header">
                <h1 class="contacto-header__title">
                    <span class="contacto-header__eyebrow"><?php echo esc_html($title_top); ?></span>
                    <span class="contacto-header__brand"><?php echo esc_html($title_brand); ?></span>
                </h1>
            </header>

            <div class="contacto-form-wrap">
                <h2><?php echo esc_html($card_title); ?></h2>
                <p class="contacto-note"><?php echo esc_html($card_note); ?></p>

                <?php if ($form_shortcode !== '') : ?>
                    <div class="contacto-form contacto-form--shortcode">
                        <?php echo do_shortcode($form_shortcode); ?>
                    </div>
                <?php else : ?>
                    <form class="contacto-form contacto-form--static" aria-label="Formulario de contacto Venza">
                        <label class="contacto-field">
                            <span>Selecciona el país</span>
                            <select name="pais">
                                <option value=""></option>
                                <?php foreach ($countries as $country) : ?>
                                    <option value="<?php echo esc_attr($country); ?>"><?php echo esc_html($country); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </label>

                        <label class="contacto-field">
                            <span>Selecciona el motivo*</span>
                            <select name="motivo" required>
                                <option value=""></option>
                                <?php foreach ($reasons as $reason) : ?>
                                    <option value="<?php echo esc_attr($reason); ?>"><?php echo esc_html($reason); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </label>

                        <p class="contacto-form__section-title">Tus datos</p>

                        <div class="contacto-form__grid">
                            <label class="contacto-field">
                                <span class="screen-reader-text">Nombre</span>
                                <input type="text" name="nombre" placeholder="Nombre*" required>
                            </label>

                            <label class="contacto-field">
                                <span class="screen-reader-text">Apellido</span>
                                <input type="text" name="apellido" placeholder="Apellido*" required>
                            </label>

                            <label class="contacto-field">
                                <span class="screen-reader-text">Email</span>
                                <input type="email" name="email" placeholder="Tu Email*" required>
                            </label>

                            <label class="contacto-field">
                                <span class="screen-reader-text">Ciudad</span>
                                <input type="text" name="ciudad" placeholder="Ciudad*" required>
                            </label>

                            <label class="contacto-field">
                                <span class="screen-reader-text">Dirección</span>
                                <input type="text" name="direccion" placeholder="Dirección*" required>
                            </label>

                            <label class="contacto-field">
                                <span class="screen-reader-text">Teléfono</span>
                                <input type="tel" name="telefono" placeholder="Teléfono* sin guiones" required>
                            </label>
                        </div>

                        <label class="contacto-field contacto-field--textarea">
                            <span class="screen-reader-text">Mensaje</span>
                            <textarea name="mensaje" rows="5" placeholder="Cuéntanos cómo podemos ayudarte"></textarea>
                        </label>

                        <button class="contacto-submit" type="button">Enviar</button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </section>
</main>
<?php get_footer(); ?>
