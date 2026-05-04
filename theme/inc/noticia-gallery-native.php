<?php
defined('ABSPATH') || exit;

/**
 * Galeria nativa para Noticias (sin ACF Pro)
 */

add_action('add_meta_boxes', function () {
    add_meta_box(
        'venza_noticia_gallery_box',
        'Galeria de imagenes (Nativa)',
        'venza_render_noticia_gallery_box',
        'noticia',
        'normal',
        'high'
    );
});

function venza_render_noticia_gallery_box($post) {
    $gallery_ids = get_post_meta($post->ID, '_venza_noticia_gallery_ids', true);
    wp_nonce_field('venza_save_gallery', 'venza_gallery_nonce');
    ?>
    <div id="venza-gallery-container">
        <ul id="venza-gallery-list" style="display: flex; flex-wrap: wrap; gap: 10px; list-style: none; padding: 0;">
            <?php
            if ($gallery_ids) {
                $ids = explode(',', $gallery_ids);
                foreach ($ids as $id) {
                    $img_url = wp_get_attachment_image_url($id, 'thumbnail');
                    if ($img_url) {
                        echo '<li data-id="' . esc_attr($id) . '" style="position: relative; width: 100px; height: 100px; border: 1px solid #ddd; border-radius: 8px; overflow: hidden; cursor: move;">';
                        echo '<img src="' . esc_url($img_url) . '" style="width: 100%; height: 100%; object-fit: cover;">';
                        echo '<button type="button" class="venza-remove-image" style="position: absolute; top: 2px; right: 2px; background: rgba(255,0,0,0.7); color: #fff; border: none; border-radius: 50%; width: 20px; height: 20px; cursor: pointer; font-size: 12px; line-height: 1;">&times;</button>';
                        echo '</li>';
                    }
                }
            }
            ?>
        </ul>
        <input type="hidden" name="venza_noticia_gallery_ids" id="venza_noticia_gallery_ids" value="<?php echo esc_attr($gallery_ids); ?>">
        <button type="button" class="button button-primary" id="venza-add-gallery-images">Agregar imagenes a la galeria</button>
        <p class="description">Puedes arrastrar las imagenes para reordenarlas.</p>
    </div>

    <script>
    jQuery(document).ready(function($) {
        var frame;
        $('#venza-add-gallery-images').on('click', function(e) {
            e.preventDefault();
            if (frame) { frame.open(); return; }
            frame = wp.media({
                title: 'Seleccionar imagenes para la galeria',
                button: { text: 'Agregar a la galeria' },
                multiple: true
            });
            frame.on('select', function() {
                var selection = frame.state().get('selection');
                var ids = $('#venza_noticia_gallery_ids').val() ? $('#venza_noticia_gallery_ids').val().split(',') : [];
                selection.map(function(attachment) {
                    attachment = attachment.toJSON();
                    if (ids.indexOf(attachment.id.toString()) === -1) {
                        ids.push(attachment.id);
                        $('#venza-gallery-list').append(
                            '<li data-id="' + attachment.id + '" style="position: relative; width: 100px; height: 100px; border: 1px solid #ddd; border-radius: 8px; overflow: hidden; cursor: move;">' +
                            '<img src="' + (attachment.sizes.thumbnail ? attachment.sizes.thumbnail.url : attachment.url) + '" style="width: 100%; height: 100%; object-fit: cover;">' +
                            '<button type="button" class="venza-remove-image" style="position: absolute; top: 2px; right: 2px; background: rgba(255,0,0,0.7); color: #fff; border: none; border-radius: 50%; width: 20px; height: 20px; cursor: pointer; font-size: 12px; line-height: 1;">&times;</button>' +
                            '</li>'
                        );
                    }
                });
                $('#venza_noticia_gallery_ids').val(ids.join(','));
            });
            frame.open();
        });

        $(document).on('click', '.venza-remove-image', function() {
            var id = $(this).parent().data('id').toString();
            var ids = $('#venza_noticia_gallery_ids').val().split(',');
            var index = ids.indexOf(id);
            if (index > -1) {
                ids.splice(index, 1);
                $('#venza_noticia_gallery_ids').val(ids.join(','));
            }
            $(this).parent().remove();
        });

        if (typeof jQuery.ui !== 'undefined' && typeof jQuery.ui.sortable !== 'undefined') {
            $('#venza-gallery-list').sortable({
                update: function() {
                    var ids = [];
                    $('#venza-gallery-list li').each(function() {
                        ids.push($(this).data('id'));
                    });
                    $('#venza_noticia_gallery_ids').val(ids.join(','));
                }
            });
        }
    });
    </script>
    <?php
}

add_action('save_post', function ($post_id) {
    if (!isset($_POST['venza_gallery_nonce']) || !wp_verify_nonce($_POST['venza_gallery_nonce'], 'venza_save_gallery')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (isset($_POST['venza_noticia_gallery_ids'])) {
        update_post_meta($post_id, '_venza_noticia_gallery_ids', sanitize_text_field($_POST['venza_noticia_gallery_ids']));
    }
});

add_action('admin_enqueue_scripts', function($hook) {
    if ($hook === 'post.php' || $hook === 'post-new.php') {
        global $post;
        if ($post && $post->post_type === 'noticia') {
            wp_enqueue_media();
            wp_enqueue_script('jquery-ui-sortable');
        }
    }
});
