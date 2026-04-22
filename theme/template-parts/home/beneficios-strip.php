<section class="home-beneficios">
    <div class="container">
        <h2 class="section-title">Beneficios</h2>
        <div class="home-beneficios__grid">
            <div class="home-beneficio-col">
                <div class="home-beneficio-item">
                    <div class="home-beneficio-item__icon">🛡️</div>
                    <div>
                        <h4>Protección Antibacterial</h4>
                        <p>Elimina el 99.9% de las bacterias con su fórmula especial.</p>
                    </div>
                </div>
                <div class="home-beneficio-item">
                    <div class="home-beneficio-item__icon">🌿</div>
                    <div>
                        <h4>Fórmula Humectante</h4>
                        <p>Ingredientes naturales que hidratan y cuidan tu piel en cada baño.</p>
                    </div>
                </div>
                <div class="home-beneficio-item">
                    <div class="home-beneficio-item__icon">🌸</div>
                    <div>
                        <h4>Aromas Agradables</h4>
                        <p>Fragancias únicas que transforman tu rutina diaria.</p>
                    </div>
                </div>
            </div>

            <div class="home-beneficios__producto-center">
                <?php
                $featured = get_posts(['post_type' => 'producto', 'posts_per_page' => 1, 'orderby' => 'menu_order', 'order' => 'ASC']);
                if ($featured) echo get_the_post_thumbnail($featured[0]->ID, 'large', ['class' => 'home-beneficios__producto-img']);
                ?>
            </div>

            <div class="home-beneficio-col home-beneficio-col--right">
                <div class="home-beneficio-item">
                    <div class="home-beneficio-item__icon">✨</div>
                    <div>
                        <h4>Deja la Piel Radiante</h4>
                        <p>Su riqueza en ingredientes suavizantes deja una sensación de limpieza profunda.</p>
                    </div>
                </div>
                <div class="home-beneficio-item">
                    <div class="home-beneficio-item__icon">👨‍👩‍👧</div>
                    <div>
                        <h4>Apto Para Toda la Familia</h4>
                        <p>Fórmula ideal para el cuidado de toda la familia, todos los días.</p>
                    </div>
                </div>
                <div class="home-beneficio-item">
                    <div class="home-beneficio-item__icon">💧</div>
                    <div>
                        <h4>Nutre la Piel Seca</h4>
                        <p>Componentes que nutren desde adentro para una piel saludable.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
