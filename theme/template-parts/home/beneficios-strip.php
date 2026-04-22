<section class="home-beneficios">
    <div class="container">
        <h2 class="section-title">Beneficios</h2>
        <div class="home-beneficios__layout">

            <div class="home-beneficios__col home-beneficios__col--left">
                <div class="home-beneficio">
                    <h4>Buen sabor al ambiente</h4>
                    <p>Su aroma fresco y agradable transforma cada baño en una experiencia sensorial única.</p>
                </div>
                <div class="home-beneficio">
                    <h4>Ideal para piel mixta</h4>
                    <p>Formulado para equilibrar y cuidar todo tipo de piel, todos los días.</p>
                </div>
                <div class="home-beneficio">
                    <h4>Fórmula humectante</h4>
                    <p>Ingredientes naturales que nutren e hidratan profundamente desde el primer uso.</p>
                </div>
            </div>

            <div class="home-beneficios__producto">
                <?php
                $p = get_posts(['post_type' => 'producto', 'posts_per_page' => 1, 'orderby' => 'menu_order', 'order' => 'ASC']);
                if ($p) echo get_the_post_thumbnail($p[0]->ID, 'large', ['class' => 'home-beneficios__img']);
                ?>
            </div>

            <div class="home-beneficios__col home-beneficios__col--right">
                <div class="home-beneficio">
                    <h4>Alto rendimiento</h4>
                    <p>Cada barra rinde más y actúa desde el primer uso para el cuidado de tu piel.</p>
                </div>
                <div class="home-beneficio">
                    <h4>Limpieza efectiva</h4>
                    <p>Elimina el 99.9% de las bacterias protegiendo tu piel de manera segura y natural.</p>
                </div>
                <div class="home-beneficio">
                    <h4>Nutre la piel seca</h4>
                    <p>Sus componentes activos nutren desde adentro para una piel saludable y radiante.</p>
                </div>
            </div>

        </div>
    </div>
</section>
