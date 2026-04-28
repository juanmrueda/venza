<?php
defined('ABSPATH') || exit;

add_action('acf/init', function () {
    if (!function_exists('acf_add_local_field_group')) {
        return;
    }

    $image_field = static function ($key, $label, $name, $instructions = '') {
        return [
            'key'           => $key,
            'label'         => $label,
            'name'          => $name,
            'type'          => 'image',
            'return_format' => 'id',
            'preview_size'  => 'medium',
            'library'       => 'all',
            'instructions'  => $instructions,
        ];
    };

    $textarea_field = static function ($key, $label, $name, $rows = 4, $instructions = '') {
        return [
            'key'          => $key,
            'label'        => $label,
            'name'         => $name,
            'type'         => 'textarea',
            'rows'         => $rows,
            'instructions' => $instructions,
        ];
    };

    acf_add_local_field_group([
        'key'    => 'group_venza_blog_home',
        'title'  => 'Blog - Home editable',
        'fields' => [
            [
                'key'           => 'field_venza_blog_home_use_background_image',
                'label'         => 'Blog Home - Usar imagen de fondo',
                'name'          => 'blog_home_use_background_image',
                'type'          => 'true_false',
                'ui'            => 1,
                'default_value' => 0,
                'instructions'  => 'Apagado por defecto para mejorar rendimiento. Enciendelo solo si necesitas una imagen de fondo.',
            ],
            $image_field(
                'field_venza_blog_home_background_image',
                'Blog Home - Background',
                'blog_home_background_image_id',
                'Imagen de fondo para el home del blog. Solo carga si el switch anterior esta encendido.'
            ),
            [
                'key'           => 'field_venza_blog_home_background_color',
                'label'         => 'Blog Home - Color base',
                'name'          => 'blog_home_background_color',
                'type'          => 'color_picker',
                'default_value' => '#eaf3fb',
            ],
            [
                'key'           => 'field_venza_blog_home_button_text',
                'label'         => 'Blog Home - Texto boton tarjetas',
                'name'          => 'blog_home_button_text',
                'type'          => 'text',
                'default_value' => 'Conoce mas',
            ],
        ],
        'location' => [
            [
                [
                    'param'    => 'page_type',
                    'operator' => '==',
                    'value'    => 'posts_page',
                ],
            ],
        ],
        'position' => 'normal',
        'style'    => 'default',
    ]);

    acf_add_local_field_group([
        'key'    => 'group_venza_blog_post',
        'title'  => 'Blog - Campos visuales',
        'fields' => [
            [
                'key'   => 'field_venza_blog_tab_general',
                'label' => 'General',
                'type'  => 'tab',
            ],
            $image_field(
                'field_venza_blog_card_image',
                'Home Blog - Imagen tarjeta',
                'blog_card_image_id',
                'Opcional. Se usa solo si la entrada no tiene imagen destacada.'
            ),
            $textarea_field(
                'field_venza_blog_card_excerpt',
                'Home Blog - Resumen tarjeta',
                'blog_card_excerpt',
                3,
                'Opcional. Si queda vacio usa el extracto o el contenido.'
            ),
            [
                'key'   => 'field_venza_blog_card_button_text',
                'label' => 'Home Blog - Texto boton',
                'name'  => 'blog_card_button_text',
                'type'  => 'text',
            ],
            [
                'key'   => 'field_venza_blog_tab_hero',
                'label' => 'Hero interna',
                'type'  => 'tab',
            ],
            $image_field(
                'field_venza_blog_hero_image',
                'Hero - Imagen principal',
                'blog_hero_image_id',
                'Opcional. Se usa solo si la entrada no tiene imagen destacada.'
            ),
            $textarea_field(
                'field_venza_blog_hero_intro',
                'Hero - Texto destacado',
                'blog_hero_intro',
                3,
                'Texto principal debajo del titulo. Acepta <strong>.'
            ),
            $textarea_field(
                'field_venza_blog_hero_body',
                'Hero - Texto secundario',
                'blog_hero_body',
                4,
                'Texto complementario debajo del destacado. Acepta <strong>.'
            ),
            [
                'key'   => 'field_venza_blog_tab_type_1',
                'label' => 'Interna tipo 1',
                'type'  => 'tab',
            ],
            [
                'key'     => 'field_venza_blog_t1_dynamic_message',
                'label'   => 'Bloques dinamicos',
                'name'    => '',
                'type'    => 'message',
                'message' => 'Agrega, quita y ordena los bloques desde la caja "Blog - Bloques dinamicos" de esta misma pantalla. Los campos antiguos siguen funcionando como respaldo si aun no guardas bloques dinamicos.',
            ],
        ],
        'location' => [
            [
                [
                    'param'    => 'post_type',
                    'operator' => '==',
                    'value'    => 'post',
                ],
            ],
        ],
        'position' => 'normal',
        'style'    => 'default',
    ]);
});

function venza_blog_t1_allowed_overlay_positions() {
    return [
        'top-left',
        'top-center',
        'top-right',
        'center-left',
        'center-right',
        'bottom-left',
        'bottom-center',
        'bottom-right',
    ];
}

function venza_blog_t1_default_texts() {
    return [
        'Estos pequenos momentos en los que <strong>te apartas de las pantallas o tareas y le das un respiro a tu cuerpo</strong> aunque solo sean <strong>5 o 10 minutos</strong>, no son poca cosa: son justo lo que tu cerebro necesita para mantenerse activo y rendir mejor.',
        '<strong>Estirate, respira con la tecnica 4-7-8</strong> (inhala durante 4 segundos, reten el aire por 7 segundos y exhala durante 8), ve a tu tienda favorita por un cafe o un te de hierbas, o simplemente date el gusto de un dulce.',
        'En esos momentos, tu cerebro tiene la oportunidad de <strong>desconectarse, liberar tensiones y reorganizar las ideas.</strong><br>Si haces de estos pequenos descansos un habito, no solo notaras el cambio en tu tranquilidad y te sentiras mas relajado, sino que tambien aumentaras tu productividad.',
        'Asi que, la proxima vez que te sientas abrumado, haz una pausa: <strong>estirate, toma agua, respira hondo... y vuelve con mas energia para terminar tu dia con exito.</strong>',
    ];
}

function venza_blog_t1_resolve_image_id($value) {
    if (is_numeric($value)) {
        return absint($value);
    }

    if (is_array($value)) {
        foreach (['ID', 'id', 'attachment_id'] as $key) {
            if (isset($value[$key]) && is_numeric($value[$key])) {
                return absint($value[$key]);
            }
        }
    }

    if (is_object($value) && isset($value->ID) && is_numeric($value->ID)) {
        return absint($value->ID);
    }

    return 0;
}

function venza_blog_t1_sanitize_block($block) {
    if (!is_array($block)) {
        return null;
    }

    $type = isset($block['type']) ? sanitize_key((string) $block['type']) : '';
    if (!in_array($type, ['image', 'text'], true)) {
        return null;
    }

    $clean = [
        'type' => $type,
    ];

    if ($type === 'image') {
        $image_id = isset($block['image_id']) ? venza_blog_t1_resolve_image_id($block['image_id']) : 0;
        if ($image_id <= 0) {
            return null;
        }
        $clean['image_id'] = $image_id;
        return $clean;
    }

    $text = isset($block['text']) ? wp_kses_post((string) $block['text']) : '';
    $style = isset($block['style']) ? sanitize_key((string) $block['style']) : 'light';
    if (!in_array($style, ['light', 'blue'], true)) {
        $style = 'light';
    }

    $overlay_image_id = isset($block['overlay_image_id']) ? venza_blog_t1_resolve_image_id($block['overlay_image_id']) : 0;
    $overlay_position = isset($block['overlay_position']) ? sanitize_key((string) $block['overlay_position']) : 'top-right';
    if (!in_array($overlay_position, venza_blog_t1_allowed_overlay_positions(), true)) {
        $overlay_position = 'top-right';
    }

    if (trim(wp_strip_all_tags($text)) === '' && $overlay_image_id <= 0) {
        return null;
    }

    $clean['text'] = $text;
    $clean['style'] = $style;
    $clean['overlay_image_id'] = $overlay_image_id;
    $clean['overlay_position'] = $overlay_position;

    return $clean;
}

function venza_blog_t1_get_legacy_blocks($post_id, $hero_image_id = 0) {
    $blocks = [];
    $fallback_texts = venza_blog_t1_default_texts();
    $allowed_overlay_positions = venza_blog_t1_allowed_overlay_positions();

    for ($i = 1; $i <= 4; $i++) {
        $block_image_id = venza_blog_t1_resolve_image_id(venza_get_meta_value('blog_t1_block_' . $i . '_image_id', $post_id));
        if ($block_image_id <= 0) {
            $block_image_id = (int) $hero_image_id;
        }

        $block_text = trim((string) venza_get_meta_value('blog_t1_block_' . $i . '_text', $post_id));
        if ($block_text === '') {
            $block_text = $fallback_texts[$i - 1] ?? '';
        }

        $block_style = trim((string) venza_get_meta_value('blog_t1_block_' . $i . '_style', $post_id));
        if (!in_array($block_style, ['light', 'blue'], true)) {
            $block_style = in_array($i, [1, 3], true) ? 'blue' : 'light';
        }

        $overlay_image_id = venza_blog_t1_resolve_image_id(venza_get_meta_value('blog_t1_block_' . $i . '_overlay_image_id', $post_id));
        $overlay_position = trim((string) venza_get_meta_value('blog_t1_block_' . $i . '_overlay_position', $post_id));
        if (!in_array($overlay_position, $allowed_overlay_positions, true)) {
            $overlay_position = in_array($i, [1, 3], true) ? 'bottom-left' : 'top-right';
        }

        $image_block = $block_image_id > 0 ? [
            'type'     => 'image',
            'image_id' => $block_image_id,
        ] : null;

        $text_block = [
            'type'             => 'text',
            'text'             => $block_text,
            'style'            => $block_style,
            'overlay_image_id' => $overlay_image_id,
            'overlay_position' => $overlay_position,
        ];

        if ($i % 2 === 1) {
            if ($image_block) {
                $blocks[] = $image_block;
            }
            $blocks[] = $text_block;
        } else {
            $blocks[] = $text_block;
            if ($image_block) {
                $blocks[] = $image_block;
            }
        }
    }

    return array_values(array_filter($blocks));
}

function venza_blog_t1_get_blocks($post_id, $hero_image_id = 0) {
    $is_dynamic = get_post_meta($post_id, 'blog_t1_blocks_is_dynamic', true) === '1';
    $saved = get_post_meta($post_id, 'blog_t1_blocks', true);
    if (is_array($saved)) {
        $blocks = [];
        foreach ($saved as $block) {
            $clean = venza_blog_t1_sanitize_block($block);
            if ($clean) {
                $blocks[] = $clean;
            }
        }

        if (!empty($blocks) || $is_dynamic) {
            return $blocks;
        }
    }

    if ($is_dynamic) {
        return [];
    }

    return venza_blog_t1_get_legacy_blocks($post_id, $hero_image_id);
}

add_action('add_meta_boxes_post', function () {
    add_meta_box(
        'venza_blog_t1_blocks',
        'Blog - Bloques dinamicos',
        'venza_blog_t1_render_blocks_metabox',
        'post',
        'normal',
        'high'
    );
});

function venza_blog_t1_render_blocks_metabox($post) {
    wp_nonce_field('venza_blog_t1_blocks_save', 'venza_blog_t1_blocks_nonce');
    wp_enqueue_media();

    $hero_image_id = has_post_thumbnail($post->ID)
        ? (int) get_post_thumbnail_id($post->ID)
        : venza_blog_t1_resolve_image_id(venza_get_meta_value('blog_hero_image_id', $post->ID));
    $blocks = venza_blog_t1_get_blocks($post->ID, $hero_image_id);
    $positions = [
        'top-left'      => 'Arriba izquierda',
        'top-center'    => 'Arriba centro',
        'top-right'     => 'Arriba derecha',
        'center-left'   => 'Centro izquierda',
        'center-right'  => 'Centro derecha',
        'bottom-left'   => 'Abajo izquierda',
        'bottom-center' => 'Abajo centro',
        'bottom-right'  => 'Abajo derecha',
    ];
    ?>
    <div class="venza-blog-blocks" data-next-index="<?php echo esc_attr((string) max(0, count($blocks))); ?>">
        <p class="description">Agrega bloques de imagen o de texto. El frontend los pinta en una grilla de dos columnas y respeta el orden que dejes aqui.</p>
        <div class="venza-blog-blocks__list">
            <?php foreach ($blocks as $index => $block) : ?>
                <?php venza_blog_t1_render_block_row($index, $block, $positions); ?>
            <?php endforeach; ?>
        </div>
        <div class="venza-blog-blocks__actions">
            <button type="button" class="button button-primary" data-venza-add-blog-block="image">Agregar imagen</button>
            <button type="button" class="button" data-venza-add-blog-block="text">Agregar texto</button>
        </div>
    </div>
    <template id="venza-blog-block-template">
        <?php
        venza_blog_t1_render_block_row('__INDEX__', [
            'type'             => 'text',
            'text'             => '',
            'style'            => 'blue',
            'overlay_image_id' => 0,
            'overlay_position' => 'top-right',
        ], $positions);
        ?>
    </template>
    <style>
        .venza-blog-blocks__list { display: grid; gap: 12px; margin: 14px 0; }
        .venza-blog-block { border: 1px solid #dcdcde; background: #fff; padding: 12px; border-radius: 4px; }
        .venza-blog-block__head { display: flex; align-items: center; justify-content: space-between; gap: 12px; margin-bottom: 10px; }
        .venza-blog-block__title { font-weight: 700; color: #1d2327; }
        .venza-blog-block__grid { display: grid; grid-template-columns: minmax(140px, 220px) 1fr; gap: 12px; align-items: start; }
        .venza-blog-block__field { display: grid; gap: 5px; margin-bottom: 10px; }
        .venza-blog-block__field label { font-weight: 600; }
        .venza-blog-block textarea { width: 100%; min-height: 110px; }
        .venza-blog-block select { max-width: 260px; }
        .venza-blog-block__preview { width: 100%; min-height: 110px; display: grid; place-items: center; background: #f0f0f1; border: 1px dashed #c3c4c7; margin-bottom: 8px; overflow: hidden; }
        .venza-blog-block__preview img { width: 100%; height: auto; display: block; }
        .venza-blog-block[data-type="image"] .venza-blog-block__text-fields,
        .venza-blog-block[data-type="image"] .venza-blog-block__overlay-fields,
        .venza-blog-block[data-type="text"] .venza-blog-block__image-fields { display: none; }
        .venza-blog-block__move { display: inline-flex; gap: 4px; }
        @media (max-width: 782px) { .venza-blog-block__grid { grid-template-columns: 1fr; } }
    </style>
    <script>
    (function () {
        const root = document.currentScript.closest('.inside').querySelector('.venza-blog-blocks');
        if (!root || root.dataset.bound === '1') return;
        root.dataset.bound = '1';

        const list = root.querySelector('.venza-blog-blocks__list');
        const template = document.getElementById('venza-blog-block-template');

        const refreshIndexes = () => {
            list.querySelectorAll('.venza-blog-block').forEach((block, index) => {
                block.querySelector('.venza-blog-block__title').textContent = 'Bloque ' + (index + 1);
            });
        };

        const setBlockType = (block, type) => {
            block.dataset.type = type;
            block.querySelector('[data-venza-block-type]').value = type;
        };

        const clearPreview = (field) => {
            field.querySelector('input[type="hidden"]').value = '';
            field.querySelector('[data-venza-image-preview]').innerHTML = '<span>Sin imagen</span>';
        };

        const setPreview = (field, id, url) => {
            field.querySelector('input[type="hidden"]').value = id;
            field.querySelector('[data-venza-image-preview]').innerHTML = '<img src="' + url + '" alt="">';
        };

        root.addEventListener('click', (event) => {
            const addButton = event.target.closest('[data-venza-add-blog-block]');
            if (addButton) {
                const index = Number(root.dataset.nextIndex || 0);
                root.dataset.nextIndex = String(index + 1);
                const html = template.innerHTML.replaceAll('__INDEX__', String(index));
                const wrapper = document.createElement('div');
                wrapper.innerHTML = html.trim();
                const block = wrapper.firstElementChild;
                setBlockType(block, addButton.dataset.venzaAddBlogBlock);
                list.appendChild(block);
                refreshIndexes();
                return;
            }

            const removeButton = event.target.closest('[data-venza-remove-blog-block]');
            if (removeButton) {
                removeButton.closest('.venza-blog-block').remove();
                refreshIndexes();
                return;
            }

            const moveButton = event.target.closest('[data-venza-move-blog-block]');
            if (moveButton) {
                const block = moveButton.closest('.venza-blog-block');
                if (moveButton.dataset.venzaMoveBlogBlock === 'up' && block.previousElementSibling) {
                    list.insertBefore(block, block.previousElementSibling);
                }
                if (moveButton.dataset.venzaMoveBlogBlock === 'down' && block.nextElementSibling) {
                    list.insertBefore(block.nextElementSibling, block);
                }
                refreshIndexes();
                return;
            }

            const pickButton = event.target.closest('[data-venza-pick-image]');
            if (pickButton && window.wp && wp.media) {
                const field = pickButton.closest('[data-venza-image-field]');
                const frame = wp.media({ title: 'Selecciona una imagen', multiple: false, library: { type: 'image' } });
                frame.on('select', () => {
                    const attachment = frame.state().get('selection').first().toJSON();
                    const thumb = attachment.sizes && attachment.sizes.thumbnail ? attachment.sizes.thumbnail.url : attachment.url;
                    setPreview(field, attachment.id, thumb);
                });
                frame.open();
                return;
            }

            const clearButton = event.target.closest('[data-venza-clear-image]');
            if (clearButton) {
                clearPreview(clearButton.closest('[data-venza-image-field]'));
            }
        });

        root.addEventListener('change', (event) => {
            const typeSelect = event.target.closest('[data-venza-block-type]');
            if (typeSelect) {
                setBlockType(typeSelect.closest('.venza-blog-block'), typeSelect.value);
            }
        });

        refreshIndexes();
    }());
    </script>
    <?php
}

function venza_blog_t1_render_block_row($index, $block, $positions) {
    $index_attr = (string) $index;
    $type = isset($block['type']) && in_array($block['type'], ['image', 'text'], true) ? $block['type'] : 'text';
    $image_id = isset($block['image_id']) ? (int) $block['image_id'] : 0;
    $overlay_image_id = isset($block['overlay_image_id']) ? (int) $block['overlay_image_id'] : 0;
    $style = isset($block['style']) && in_array($block['style'], ['light', 'blue'], true) ? $block['style'] : 'blue';
    $overlay_position = isset($block['overlay_position']) && isset($positions[$block['overlay_position']]) ? $block['overlay_position'] : 'top-right';
    $text = isset($block['text']) ? (string) $block['text'] : '';
    $image_url = $image_id > 0 ? wp_get_attachment_image_url($image_id, 'thumbnail') : '';
    $overlay_url = $overlay_image_id > 0 ? wp_get_attachment_image_url($overlay_image_id, 'thumbnail') : '';
    ?>
    <div class="venza-blog-block" data-type="<?php echo esc_attr($type); ?>">
        <div class="venza-blog-block__head">
            <span class="venza-blog-block__title">Bloque</span>
            <span class="venza-blog-block__move">
                <button type="button" class="button" data-venza-move-blog-block="up">Subir</button>
                <button type="button" class="button" data-venza-move-blog-block="down">Bajar</button>
                <button type="button" class="button-link-delete" data-venza-remove-blog-block>Eliminar</button>
            </span>
        </div>
        <div class="venza-blog-block__grid">
            <div class="venza-blog-block__field">
                <label>Tipo</label>
                <select name="venza_blog_t1_blocks[<?php echo esc_attr($index_attr); ?>][type]" data-venza-block-type>
                    <option value="image" <?php selected($type, 'image'); ?>>Imagen</option>
                    <option value="text" <?php selected($type, 'text'); ?>>Texto</option>
                </select>
            </div>

            <div>
                <div class="venza-blog-block__image-fields" data-venza-image-field>
                    <div class="venza-blog-block__field">
                        <label>Imagen</label>
                        <input type="hidden" name="venza_blog_t1_blocks[<?php echo esc_attr($index_attr); ?>][image_id]" value="<?php echo esc_attr((string) $image_id); ?>">
                        <div class="venza-blog-block__preview" data-venza-image-preview>
                            <?php if ($image_url) : ?>
                                <img src="<?php echo esc_url($image_url); ?>" alt="">
                            <?php else : ?>
                                <span>Sin imagen</span>
                            <?php endif; ?>
                        </div>
                        <button type="button" class="button" data-venza-pick-image>Seleccionar imagen</button>
                        <button type="button" class="button-link-delete" data-venza-clear-image>Quitar imagen</button>
                    </div>
                </div>

                <div class="venza-blog-block__text-fields">
                    <div class="venza-blog-block__field">
                        <label>Texto</label>
                        <textarea name="venza_blog_t1_blocks[<?php echo esc_attr($index_attr); ?>][text]"><?php echo esc_textarea($text); ?></textarea>
                    </div>
                    <div class="venza-blog-block__field">
                        <label>Estilo</label>
                        <select name="venza_blog_t1_blocks[<?php echo esc_attr($index_attr); ?>][style]">
                            <option value="light" <?php selected($style, 'light'); ?>>Fondo claro</option>
                            <option value="blue" <?php selected($style, 'blue'); ?>>Fondo azul</option>
                        </select>
                    </div>
                </div>

                <div class="venza-blog-block__overlay-fields" data-venza-image-field>
                    <div class="venza-blog-block__field">
                        <label>Imagen encima del texto (opcional)</label>
                        <input type="hidden" name="venza_blog_t1_blocks[<?php echo esc_attr($index_attr); ?>][overlay_image_id]" value="<?php echo esc_attr((string) $overlay_image_id); ?>">
                        <div class="venza-blog-block__preview" data-venza-image-preview>
                            <?php if ($overlay_url) : ?>
                                <img src="<?php echo esc_url($overlay_url); ?>" alt="">
                            <?php else : ?>
                                <span>Sin imagen</span>
                            <?php endif; ?>
                        </div>
                        <button type="button" class="button" data-venza-pick-image>Seleccionar imagen</button>
                        <button type="button" class="button-link-delete" data-venza-clear-image>Quitar imagen</button>
                    </div>
                    <div class="venza-blog-block__field">
                        <label>Posicion imagen encima</label>
                        <select name="venza_blog_t1_blocks[<?php echo esc_attr($index_attr); ?>][overlay_position]">
                            <?php foreach ($positions as $position_key => $position_label) : ?>
                                <option value="<?php echo esc_attr($position_key); ?>" <?php selected($overlay_position, $position_key); ?>><?php echo esc_html($position_label); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
}

add_action('save_post_post', function ($post_id) {
    if (!isset($_POST['venza_blog_t1_blocks_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['venza_blog_t1_blocks_nonce'])), 'venza_blog_t1_blocks_save')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    $incoming = isset($_POST['venza_blog_t1_blocks']) && is_array($_POST['venza_blog_t1_blocks'])
        ? wp_unslash($_POST['venza_blog_t1_blocks'])
        : [];

    $blocks = [];
    foreach ($incoming as $block) {
        $clean = venza_blog_t1_sanitize_block($block);
        if ($clean) {
            $blocks[] = $clean;
        }
    }

    update_post_meta($post_id, 'blog_t1_blocks_is_dynamic', '1');

    if (!empty($blocks)) {
        update_post_meta($post_id, 'blog_t1_blocks', $blocks);
    } else {
        delete_post_meta($post_id, 'blog_t1_blocks');
    }
});
