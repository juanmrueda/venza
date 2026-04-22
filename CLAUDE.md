# CLAUDE.md — Contexto para el agente

## Proyecto
Sitio web corporativo para la marca **Venza** (jabones, Dinant).
- **URL demo:** venza.ipalmera.com
- **Deadline:** Martes 28 de abril de 2026
- **Repo:** https://github.com/juanmrueda/venza.git
- **Contacto:** juan.rueda@ipalmera.com

## Regla de trabajo
**Bloque a bloque.** Cada bloque se presenta al usuario, él da el OK, luego se avanza al siguiente. Nunca ejecutar el siguiente bloque sin confirmación explícita.

## Stack decidido
- WordPress 6.x con tema 100% custom (sin page builder, sin Bootstrap)
- ACF Free, Contact Form 7, Yoast SEO
- CSS custom con variables, Grid, Flexbox
- Vanilla JS para el quiz (sin librerías)
- Servidor: Digital Ocean Droplet Ubuntu 22.04, Nginx + PHP 8.2 + MySQL 8.0

## Estado actual del proyecto
Ver [README.md](README.md) para el mapa completo del sitio y checklist de assets.

### Completado
- [x] Esqueleto del tema WordPress (42 archivos en `/theme/`)
- [x] CSS base responsive con design system completo
- [x] Quiz de piel en Vanilla JS (6 preguntas → 6 jabones, lógica en `docs/quiz-logic.md`)
- [x] Scripts de deploy (`deploy/server-setup.sh`, `deploy/deploy.sh`, `deploy/keygen.sh`)
- [x] Git inicializado y pusheado a GitHub

### Pendiente (en orden)
- [ ] **Bloque 2:** Configurar servidor Digital Ocean + SSH key
- [ ] **Bloque 3:** Instalar WordPress en el servidor (script `deploy/server-setup.sh`)
- [ ] **Bloque 4:** Configurar el tema en el servidor + git clone del repo
- [ ] **Bloque 5:** CSS real con assets del cliente (logo, fuentes, paleta)
- [ ] **Bloque 6:** Contenido real en WP (productos, noticias, blog)
- [ ] **Bloque 7:** QA responsive + ajustes finales
- [ ] **Bloque 8:** Deploy final / revisión con cliente

## Assets pendientes del cliente
- [ ] Logo SVG + PNG transparente
- [ ] Nombre de fuentes o archivos de tipografía
- [ ] Paleta de colores hex oficial
- [ ] Fotos de 6 productos (PNG fondo transparente, alta res)
- [ ] Fotos hero/lifestyle de cada producto
- [ ] Textos reales de cada producto
- [ ] Links tiendas externas por producto
- [ ] URL canal YouTube de Venza
- [ ] Email destino del formulario de contacto
- [ ] Imágenes para el quiz (aromas y entornos — ver `docs/quiz-logic.md`)

## Estructura de carpetas clave
```
c:/dev/Venza/
├── CLAUDE.md          ← este archivo
├── README.md          ← plan completo del proyecto
├── theme/             ← tema WordPress custom (va a /wp-content/themes/venza/)
│   ├── assets/css/main.css     ← design system completo
│   ├── assets/js/quiz.js       ← quiz de piel (vanilla JS, listo)
│   ├── assets/js/main.js       ← JS global
│   ├── inc/cpt.php             ← Custom Post Types: producto, noticia
│   └── template-parts/         ← componentes reutilizables
├── deploy/            ← scripts de servidor y deploy
└── docs/              ← quiz-logic.md con tabla de puntajes
```

## Productos del sitio (6 jabones)
Crema Humectante / Frescura Extrema / Vitamina E / Sábila / Coco / Avena

## Pages / Templates
| Template | Ruta |
|----------|------|
| Home | `front-page.php` |
| Producto single (×6) | `single-producto.php` |
| Beneficios | `page-beneficios.php` |
| Noticias archivo | `archive-noticia.php` |
| Noticia single | `single-noticia.php` |
| Blog | `home.php` + `single.php` |
| Descubre Venza | `page-descubre-venza.php` |
| Quiz de piel | `page-quiz.php` |
| Contacto | `page-contacto.php` |
