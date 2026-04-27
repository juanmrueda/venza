<ul class="social-links" aria-label="Redes sociales">
    <?php
    $social_defaults = [
        'facebook'  => 'https://www.facebook.com/jabonvenza/',
        'instagram' => 'https://www.instagram.com/jabonvenza/',
        'youtube'   => 'https://www.youtube.com/@jabonvenza',
    ];

    $redes = [
        'facebook'  => ['url' => trim((string) get_option('venza_facebook', '')) ?: $social_defaults['facebook'],  'label' => 'Facebook',  'icon' => VENZA_URI . '/assets/images/logos/facebook.png'],
        'instagram' => ['url' => trim((string) get_option('venza_instagram', '')) ?: $social_defaults['instagram'], 'label' => 'Instagram', 'icon' => VENZA_URI . '/assets/images/logos/instagram.png'],
        'youtube'   => ['url' => trim((string) get_option('venza_youtube', '')) ?: $social_defaults['youtube'],   'label' => 'YouTube',   'icon' => VENZA_URI . '/assets/images/logos/youtube.png'],
    ];
    foreach ($redes as $red => $data) : ?>
        <li>
            <a href="<?php echo esc_url($data['url']); ?>" target="_blank" rel="noopener" aria-label="<?php echo esc_attr($data['label']); ?>" class="social-link social-link--<?php echo $red; ?>">
                <img src="<?php echo esc_url($data['icon']); ?>" alt="" width="16" height="16" loading="lazy" decoding="async">
            </a>
        </li>
    <?php endforeach; ?>
</ul>
