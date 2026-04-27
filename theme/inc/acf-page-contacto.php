<?php
defined('ABSPATH') || exit;

add_action('acf/init', function () {
    if (!function_exists('acf_add_local_field_group')) {
        return;
    }

    acf_add_local_field_group([
        'key'    => 'group_venza_page_contacto',
        'title'  => 'Pagina - Contacto',
        'fields' => [
            [
                'key'   => 'field_venza_contacto_tab_general',
                'label' => 'General',
                'type'  => 'tab',
            ],
            [
                'key'           => 'field_venza_contacto_bg_color',
                'label'         => 'Background - Color',
                'name'          => 'contacto_bg_color',
                'type'          => 'color_picker',
                'default_value' => '#eaf3fb',
                'instructions'  => 'No hay imagen pesada por defecto. Usa este color para ajustar el fondo de la pagina.',
            ],
            [
                'key'           => 'field_venza_contacto_title_top',
                'label'         => 'Hero - Texto superior',
                'name'          => 'contacto_title_top',
                'type'          => 'text',
                'default_value' => 'CONTACTO',
            ],
            [
                'key'           => 'field_venza_contacto_title_brand',
                'label'         => 'Hero - Marca',
                'name'          => 'contacto_title_brand',
                'type'          => 'text',
                'default_value' => 'venza',
            ],
            [
                'key'           => 'field_venza_contacto_card_title',
                'label'         => 'Formulario - Titulo',
                'name'          => 'contacto_card_title',
                'type'          => 'text',
                'default_value' => '¿Quieres saber más sobre nuestros productos?',
            ],
            [
                'key'           => 'field_venza_contacto_card_note',
                'label'         => 'Formulario - Nota',
                'name'          => 'contacto_card_note',
                'type'          => 'text',
                'default_value' => 'Campos marcados con (*) son obligatorios',
            ],
            [
                'key'          => 'field_venza_contacto_form_shortcode',
                'label'        => 'Formulario - Shortcode',
                'name'         => 'contacto_form_shortcode',
                'type'         => 'textarea',
                'rows'         => 3,
                'instructions' => 'Opcional. Cuando se configure el envio por correo, pega aqui el shortcode de Contact Form 7.',
            ],
            [
                'key'   => 'field_venza_contacto_tab_options',
                'label' => 'Opciones formulario',
                'type'  => 'tab',
            ],
            [
                'key'           => 'field_venza_contacto_countries',
                'label'         => 'Paises',
                'name'          => 'contacto_countries',
                'type'          => 'textarea',
                'rows'          => 6,
                'default_value' => "Guatemala\nEl Salvador\nHonduras\nNicaragua\nCosta Rica\nRepublica Dominicana",
                'instructions'  => 'Un pais por linea.',
            ],
            [
                'key'           => 'field_venza_contacto_reasons',
                'label'         => 'Motivos',
                'name'          => 'contacto_reasons',
                'type'          => 'textarea',
                'rows'          => 5,
                'default_value' => "Quiero saber mas sobre productos\nDistribucion y ventas\nAtencion al cliente\nAlianzas comerciales\nOtro",
                'instructions'  => 'Un motivo por linea.',
            ],
        ],
        'location' => [
            [
                [
                    'param'    => 'page_template',
                    'operator' => '==',
                    'value'    => 'page-contacto.php',
                ],
            ],
        ],
        'position' => 'normal',
        'style'    => 'default',
    ]);
});
