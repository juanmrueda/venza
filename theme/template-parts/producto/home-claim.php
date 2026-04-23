<?php
$claim_texto = venza_get_meta_value('producto_home_claim_texto');
$claim_cta   = venza_get_meta_value('producto_home_claim_cta');

if (!$claim_texto) {
    $claim_texto = 'Cuidar tu piel ahora es más fácil con el nuevo Venza Crema Humectante. Prueba la limpieza efectiva de jabón Venza, ahora con el poder de la humectación.';
}
if (!$claim_cta) {
    $claim_cta = '¡Pruébalo hoy mismo!';
}
?>
<section class="producto-home-claim">
    <div class="container">
        <div class="producto-home-claim__box">
            <p><?php echo esc_html($claim_texto); ?></p>
            <h3><?php echo esc_html($claim_cta); ?></h3>
        </div>
    </div>
</section>
