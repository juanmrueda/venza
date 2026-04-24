<?php
$home_id = get_queried_object_id();
if (!$home_id) {
    $home_id = (int) get_option('page_on_front');
}

$get_home_field = static function ($key, $default = '') use ($home_id) {
    $value = venza_field($key, $home_id);
    if ($value !== null && $value !== '' && $value !== []) {
        return $value;
    }

    return $default;
};

$beneficios_title = (string) $get_home_field('home_beneficios_titulo', 'Beneficios');
$soap_green_text = (string) $get_home_field('home_beneficios_soap_green_text', 'venza');
$soap_cream_text = (string) $get_home_field('home_beneficios_soap_cream_text', 'venza');

$left_defaults = [
    [
        'title' => 'Proteccion antibacterial',
        'text'  => 'Elimina eficazmente bacterias y germenes, brindando una limpieza profunda que protege tu piel en cada uso.',
    ],
    [
        'title' => 'Formula humectante',
        'text'  => 'Disenada para mantener la piel hidratada, evitando la resequedad y proporcionando suavidad natural.',
    ],
    [
        'title' => 'Aromas agradables',
        'text'  => 'Cada jabon deja una fragancia fresca y duradera que acompana tus momentos de cuidado diario.',
    ],
    [
        'title' => 'Nutre la piel seca',
        'text'  => 'Enriquecido con componentes que aportan nutricion y alivio a la piel mas reseca.',
    ],
];

$right_defaults = [
    [
        'title' => 'Deja la piel suave y radiante',
        'text'  => 'Gracias a sus ingredientes especiales, tu piel se siente tersa y con un brillo saludable.',
    ],
    [
        'title' => 'Limpieza efectiva',
        'text'  => 'Elimina impurezas y suciedad facilmente, dejando tu piel limpia, fresca y revitalizada.',
    ],
    [
        'title' => 'Apto para uso diario',
        'text'  => 'Suavidad y frescura que podes disfrutar todos los dias sin irritar ni maltratar la piel.',
    ],
    [
        'title' => 'Alto rendimiento',
        'text'  => 'Su formula concentrada rinde mas, ofreciendo calidad y duracion en cada barra de jabon.',
    ],
];

$build_items = static function ($prefix, array $defaults) use ($get_home_field) {
    $items = [];

    for ($i = 1; $i <= 4; $i++) {
        $fallback = isset($defaults[$i - 1]) && is_array($defaults[$i - 1]) ? $defaults[$i - 1] : ['title' => '', 'text' => ''];
        $title = (string) $get_home_field($prefix . '_' . $i . '_title', isset($fallback['title']) ? (string) $fallback['title'] : '');
        $text = (string) $get_home_field($prefix . '_' . $i . '_text', isset($fallback['text']) ? (string) $fallback['text'] : '');

        $items[] = [
            'title' => $title,
            'text'  => $text,
        ];
    }

    return $items;
};

$left_items = $build_items('home_beneficios_left', $left_defaults);
$right_items = $build_items('home_beneficios_right', $right_defaults);
?>

<section class="home-beneficios">
    <div class="container">
        <h2 class="section-title section-title--lined"><?php echo esc_html($beneficios_title); ?></h2>

        <div class="home-beneficios__layout">
            <div class="home-beneficios__col home-beneficios__col--left">
                <?php foreach ($left_items as $item) : ?>
                    <div class="home-beneficio">
                        <h4><?php echo esc_html((string) $item['title']); ?></h4>
                        <p><?php echo esc_html((string) $item['text']); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="home-beneficios__soaps" aria-hidden="true">
                <div class="home-beneficios__circle"></div>
                <span class="home-soap home-soap--green"><?php echo esc_html($soap_green_text); ?></span>
                <span class="home-soap home-soap--cream"><?php echo esc_html($soap_cream_text); ?></span>
            </div>

            <div class="home-beneficios__col home-beneficios__col--right">
                <?php foreach ($right_items as $item) : ?>
                    <div class="home-beneficio">
                        <h4><?php echo esc_html((string) $item['title']); ?></h4>
                        <p><?php echo esc_html((string) $item['text']); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>
