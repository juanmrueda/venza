<ul class="social-links" aria-label="Redes sociales">
    <?php
    $redes = [
        'facebook'  => ['url' => get_option('venza_facebook', '#'),  'label' => 'Facebook',  'icon' => VENZA_URI . '/assets/images/logos/facebook.png'],
        'instagram' => ['url' => get_option('venza_instagram', '#'), 'label' => 'Instagram', 'icon' => VENZA_URI . '/assets/images/logos/instagram.png'],
        'youtube'   => ['url' => get_option('venza_youtube', '#'),   'label' => 'YouTube',   'icon' => VENZA_URI . '/assets/images/logos/youtube.png'],
    ];
    foreach ($redes as $red => $data) : ?>
        <li>
            <a href="<?php echo esc_url($data['url']); ?>" target="_blank" rel="noopener" aria-label="<?php echo esc_attr($data['label']); ?>" class="social-link social-link--<?php echo $red; ?>">
                <img src="<?php echo esc_url($data['icon']); ?>" alt="" width="16" height="16" loading="lazy" decoding="async">
            </a>
        </li>
    <?php endforeach; ?>
</ul>
