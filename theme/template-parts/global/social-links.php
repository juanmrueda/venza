<ul class="social-links" aria-label="Redes sociales">
    <?php
    $redes = [
        'facebook'  => ['url' => get_option('venza_facebook', '#'),  'label' => 'Facebook'],
        'instagram' => ['url' => get_option('venza_instagram', '#'), 'label' => 'Instagram'],
        'youtube'   => ['url' => get_option('venza_youtube', '#'),   'label' => 'YouTube'],
    ];
    foreach ($redes as $red => $data) : ?>
        <li>
            <a href="<?php echo esc_url($data['url']); ?>" target="_blank" rel="noopener" aria-label="<?php echo esc_attr($data['label']); ?>" class="social-link social-link--<?php echo $red; ?>">
                <?php venza_svg('icon-' . $red); ?>
            </a>
        </li>
    <?php endforeach; ?>
</ul>
