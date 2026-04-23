<?php
$disponibilidad = venza_get_producto_disponibilidad(get_the_ID());
if (!$disponibilidad) return;
?>
<div class="producto-disponibilidad">
    <p><strong>Disponible en:</strong> <?php echo esc_html($disponibilidad); ?></p>
</div>
