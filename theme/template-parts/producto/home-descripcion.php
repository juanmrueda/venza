<?php
$descripcion = venza_get_meta_value('producto_home_descripcion_texto');
if (!$descripcion) {
    $descripcion = venza_get_meta_value('producto_descripcion_larga');
}
if (!$descripcion && !is_post_type_archive('producto')) {
    $descripcion = get_the_content(null, false, get_the_ID());
    $descripcion = apply_filters('the_content', $descripcion);
}
if (!$descripcion && is_post_type_archive('producto')) {
    $descripcion = '
        <p>El <strong>Nuevo Venza Crema Humectante</strong> deja tu piel <strong>suave, nutrida y sin sensación de resequedad.</strong> Desde la primera aplicación, notarás una mejor textura y una apariencia más saludable.</p>
        <p>Su fórmula suave es ideal para todo tipo de piel.<br>El Nuevo Venza Crema Humectante brinda una limpieza delicada que se adapta a tu rutina diaria, con <strong>resultados visibles y duraderos en todo tu cuerpo.</strong></p>
    ';
}

$imagen_id = venza_get_meta_value('producto_home_descripcion_imagen');
if (is_array($imagen_id) && !empty($imagen_id['ID'])) {
    $imagen_id = (int) $imagen_id['ID'];
}
if (is_numeric($imagen_id)) {
    $imagen_id = (int) $imagen_id;
}
if (empty($imagen_id) && has_post_thumbnail() && !is_post_type_archive('producto')) {
    $imagen_id = get_post_thumbnail_id();
}
?>
<section class="producto-home-descripcion">
    <div class="container producto-home-descripcion__layout">
        <div class="producto-home-descripcion__texto">
            <?php if ($descripcion) : ?>
                <?php echo wp_kses_post($descripcion); ?>
            <?php endif; ?>
        </div>
        <div class="producto-home-descripcion__imagen">
            <?php if (!empty($imagen_id)) : ?>
                <?php echo wp_get_attachment_image($imagen_id, 'large'); ?>
            <?php else : ?>
                <img
                    src="<?php echo esc_url(get_theme_file_uri('assets/images/productos/home/producto_crema_humectante.png?v=20260423-1202')); ?>"
                    alt="<?php echo esc_attr(get_the_title()); ?>"
                />
            <?php endif; ?>
        </div>
    </div>
</section>
