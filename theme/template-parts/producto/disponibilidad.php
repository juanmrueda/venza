<?php
$paises = venza_field('producto_paises_disponibles');
if (!$paises) return;
?>
<div class="producto-disponibilidad">
    <p><strong>Disponible en:</strong> <?php echo esc_html(implode(', ', $paises)); ?></p>
</div>
