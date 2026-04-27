# AGENTS.md â€” Contexto para el agente

## Proyecto
Sitio web corporativo para la marca **Venza** (jabones, Dinant).
- **URL demo:** venza.ipalmera.com
- **Deadline:** Martes 28 de abril de 2026
- **Repo:** https://github.com/juanmrueda/venza.git
- **Contacto:** juan.rueda@ipalmera.com

## Regla de trabajo
**Bloque a bloque.** Cada bloque se presenta al usuario, Ã©l da el OK, luego se avanza al siguiente. Nunca ejecutar el siguiente bloque sin confirmaciÃ³n explÃ­cita.

## Protocolo obligatorio de lectura minima

Antes de implementar cualquier feature:

1. Leer `docs/repo_map.md`
2. Identificar modulos relevantes
3. Modificar solo archivos necesarios
4. Evitar escanear todo el repositorio
5. Seguir la arquitectura existente

Regla adicional:

- Leer siempre `docs/repo_mad.md` al inicio.
- Actualizar `docs/repo_mad.md` al final de cada accion completada.

## Stack decidido
- WordPress 6.x con tema 100% custom (sin page builder, sin Bootstrap)
- ACF Free, Contact Form 7, Yoast SEO
- CSS custom con variables, Grid, Flexbox
- Vanilla JS para el quiz (sin librerÃ­as)
- Servidor: Digital Ocean Droplet Ubuntu 22.04 â€” IP: 142.93.15.66
- Nginx + PHP 8.2 + MySQL 8.0
- SSL: Cloudflare Origin Certificate (15 aÃ±os, Full Strict mode)

## Design system confirmado

```css
--color-navy:       #2B255E;   /* Azul marino â€” titulos, nav */
--color-green:      #4EB89F;   /* Verde Venza â€” acentos, botones */
--color-blue-light: #8CBCE1;   /* Azul claro â€” detalles */
--color-bg-light:   #eef3fb;   /* Fondo secciones alternas */
--color-gray:       #717171;   /* Texto secundario */
--font-display:     'Montage', Georgia, serif;    /* TÃ­tulos */
--font-body:        'Satoshi', 'Gotham', system-ui, sans-serif; /* Cuerpo */
```

Fuentes cargadas desde `/theme/assets/fonts/` (archivo local, no Google Fonts).

## Servidor â€” configuraciÃ³n actual

| Dato | Valor |
|------|-------|
| IP | 142.93.15.66 |
| SO | Ubuntu 22.04 LTS |
| Web | Nginx |
| PHP | 8.2 (ppa:ondrej/php) |
| DB | MySQL 8.0 |
| SSL | Cloudflare Origin Certificate en /etc/ssl/venza/ |
| WP root | /var/www/html |
| Repo | /var/repo/venza |
| Tema | /var/repo/venza/theme â†’ symlink â†’ /var/www/html/wp-content/themes/venza |

**Deploy SSH:**
```bash
# Desde local:
bash deploy/deploy.sh
# O manual:
ssh root@142.93.15.66 "cd /var/repo/venza && git pull origin main"
```

**Logs:**
```bash
ssh root@142.93.15.66 "tail -f /var/log/nginx/error.log"
```

## Estado actual del proyecto (24 abr 2026)

### Infraestructura âœ…
- [x] Servidor Digital Ocean configurado (Nginx + PHP 8.2 + MySQL 8.0 + SSL)
- [x] WordPress instalado y funcionando en venza.ipalmera.com
- [x] SSL Cloudflare Full Strict (Origin Certificate 15 aÃ±os)
- [x] Deploy workflow activo: `git push origin main` + `ssh root@142.93.15.66 "cd /var/www/html/wp-content/themes/venza && git pull origin main"`
- [x] Tema custom activado en WP
- [x] CPTs registrados: `producto` (slug: productos), `noticia` (slug: noticias)
- [x] TaxonomÃ­as: `linea_producto`, `noticia_cat`
- [x] Design system CSS completo (`theme/assets/css/main.css`)
- [x] Fuentes cargadas localmente (Montage, Satoshi, Gotham)
- [x] 6 productos creados en WP con imÃ¡genes PNG reales
- [x] Plugins instalados: ACF Free, Contact Form 7, Yoast SEO
- [x] Helpers globales (`inc/helpers.php`): `venza_field`, `venza_get_meta_value`, `venza_get_producto_destacado_home`, `venza_get_producto_disponibilidad`, `venza_get_producto_medialuna_color`, `venza_svg`

### Home (`front-page.php`) âœ…
- Hero (placeholder `bannerhomedemo.svg` â€” pendiente video del cliente)
- Productos destacados (6 productos en filas alternas, imÃ¡genes reales)
- Beneficios strip (3 col, fondo `#eef3fb`)
- GalerÃ­a Venza Hoy (3 cards desde CPT noticia/post, fallback placeholders)
- Header: fondo `#eef4ff`, lÃ­nea inferior `#8cbce1`, "SÃ­guenos" `#210a67`
- Footer global ajustado a referencia aprobada

### Productos âœ… (estructura base completa)
- [x] `archive-producto.php` â€” home editable desde admin vÃ­a ACF
- [x] `single-producto.php` â€” router por slug:
  - Slug `frescura-extrema` â†’ template dedicado pixel-perfect (`single-frescura-extrema.php`) con hero banner, identidad, descripciÃ³n y tamaÃ±os
  - Resto de productos â†’ genÃ©rico (`hero` + `beneficios-pills` + `descripcion` + `tamanos`), pixel-perfect pendiente
  - Footer comÃºn a todos: `disponibilidad` + `mas-productos`
- [x] DegradÃ© editable por producto (`producto_single_gradient_color` â†’ CSS custom prop `--producto-gradient`), aplicado a secciones descripciÃ³n y tamaÃ±os
- [x] ACF fields completos en `inc/acf-producto-home.php` (banner, subtÃ­tulo, 3 beneficios, descripciÃ³n WYSIWYG, claim, disponibilidad override, gradient color)
- [x] Frescura Extrema pixel-perfect: fondo `#eef4ff`, descripciÃ³n 48px color `#000`, gap correcto entre descripciÃ³n y tamaÃ±os

### Templates secundarios (estructura lista, falta contenido/QA pixel-perfect)
- [x] `page-beneficios.php` - layout 1:1, fallback visual completo y edicion desde admin
- [x] `page-descubre-venza.php` â€” hero + video YouTube + carrusel playlist + CTA al quiz
- [x] `page-quiz.php` â€” contenedor listo; lÃ³gica JS en `assets/js/quiz.js`
- [x] `page-contacto.php` â€” shortcode CF7 con `FORM_ID` placeholder (pendiente ID real)
- [x] `archive-noticia.php` + `taxonomy-noticia_cat.php` + `single-noticia.php`
- [x] `home.php` (blog archivo) + `single.php` (blog single)

### Beneficios (actualizado 24 abr 2026)
- [x] Pagina publicada en `/beneficios/`
- [x] Grupo ACF local: `inc/acf-page-beneficios.php`
- [x] Campos editables: quote, 8 beneficios (titulo, descripcion e imagen)
- [x] Fondo configurable desde admin: default, image, video + opacidad de capa
- [x] Fallback de contenido e imagenes locales si ACF esta vacio

### Pendiente (en orden de prioridad)
- [ ] QA pixel-perfect productos distintos a Frescura Extrema (Crema Humectante, Vitamina E, SÃ¡bila, Coco, Avena)
- [ ] Reemplazar `FORM_ID` en `page-contacto.php` con ID real de CF7 una vez instalado el form
- [ ] QA responsive en todas las pÃ¡ginas
- [ ] Reemplazar hero home con video cuando el cliente lo entregue
- [ ] Cargar textos reales, imÃ¡genes lifestyle y links de tiendas por producto/paÃ­s
- [ ] Migrar a servidor WHM de iPalmera al finalizar

## Assets recibidos âœ…
- Logo Venza (SVG + PNG)
- Fuentes: Montage (display), Satoshi, Gotham (body)
- Fotos 6 productos PNG fondo transparente
- Banners hero por producto (JPG)
- Fotos "packs" de algunos productos

## Assets pendientes del cliente
- [ ] Video hero (actualmente placeholder con `bannerhomedemo.svg`)
- [ ] ImÃ¡genes para el quiz (aromas, entornos, tipos de piel)
- [ ] Crema Humectante â€” banner + pack
- [ ] Coco â€” packs adicionales
- [ ] Fotos lifestyle para Descubre Venza
- [ ] URL canal YouTube
- [ ] Email destino formulario de contacto
- [ ] Textos reales de cada producto
- [ ] Links a tiendas externas por producto y paÃ­s
- [ ] ArtÃ­culos para Noticias y Blog

## Estructura de carpetas clave
```
c:/dev/Venza/
â”œâ”€â”€ AGENTS.md          â† este archivo
â”œâ”€â”€ README.md          â† documentaciÃ³n del proyecto
â”œâ”€â”€ theme/             â† tema WordPress custom
â”‚   â”œâ”€â”€ assets/css/main.css        â† design system completo
â”‚   â”œâ”€â”€ assets/js/quiz.js          â† quiz de piel (vanilla JS, listo)
â”‚   â”œâ”€â”€ assets/js/main.js          â† JS global
â”‚   â”œâ”€â”€ assets/fonts/              â† Montage, Satoshi, Gotham
â”‚   â”œâ”€â”€ assets/images/             â† logo, iconos SVG
â”‚   â”œâ”€â”€ assets/images/productos/   â† PNGs fondo transparente
â”‚   â”œâ”€â”€ assets/images/banners/     â† JPG banners hero
â”‚   â”œâ”€â”€ inc/cpt.php                â† CPTs y taxonomÃ­as
â”‚   â”œâ”€â”€ inc/acf-producto-home.php  â† campos ACF para home productos
â”‚   â””â”€â”€ template-parts/
â”‚       â”œâ”€â”€ home/
â”‚       â”‚   â”œâ”€â”€ hero.php                â† âœ… listo
â”‚       â”‚   â”œâ”€â”€ productos-destacados.php â† âœ… listo
â”‚       â”‚   â”œâ”€â”€ beneficios-strip.php    â† âœ… listo
â”‚       â”‚   â””â”€â”€ galeria-hoy.php         â† âœ… listo
â”‚       â”œâ”€â”€ producto/
â”‚       â”‚   â”œâ”€â”€ hero.php
â”‚       â”‚   â”œâ”€â”€ home-beneficios.php
â”‚       â”‚   â”œâ”€â”€ home-descripcion.php
â”‚       â”‚   â”œâ”€â”€ home-claim.php
â”‚       â”‚   â”œâ”€â”€ disponibilidad.php
â”‚       â”‚   â””â”€â”€ mas-productos.php
â”‚       â”œâ”€â”€ noticias/               â† pendiente
â”‚       â””â”€â”€ quiz/                   â† pendiente
â”œâ”€â”€ deploy/
â”‚   â”œâ”€â”€ server-setup.sh
â”‚   â”œâ”€â”€ deploy.sh
â”‚   â””â”€â”€ keygen.sh
â””â”€â”€ docs/
    â””â”€â”€ quiz-logic.md
```

## Pages / Templates
| Template | Ruta | Estado |
|----------|------|--------|
| Home | `front-page.php` | âœ… Completo |
| Productos archivo | `archive-producto.php` | âœ… Completo (editable admin) |
| Producto single | `single-producto.php` | Pendiente |
| Beneficios | `page-beneficios.php` | âœ… Completo (editable admin + fondo animado) |
| Noticias archivo | `archive-noticia.php` | Pendiente |
| TaxonomÃ­a noticia | `taxonomy-noticia_cat.php` | Pendiente |
| Noticia single | `single-noticia.php` | Pendiente |
| Blog archivo | `home.php` | Pendiente |
| Blog single | `single.php` | Pendiente |
| Descubre Venza | `page-descubre-venza.php` | Pendiente |
| Quiz de piel | `page-quiz.php` | Pendiente |
| Contacto | `page-contacto.php` | Pendiente |

## Productos del sitio (6 jabones)
Crema Humectante / Frescura Extrema / Vitamina E / SÃ¡bila / Coco / Avena

## Errores conocidos y soluciones
- `apt upgrade` se colgaba: usar `DEBIAN_FRONTEND=noninteractive` siempre
- PHP 8.2 no estÃ¡ en repos default Ubuntu 22.04: agregar `ppa:ondrej/php`
- `$_SERVER` se rompÃ­a con sed en wp-config.php: usar Python para replace exacto
- Cloudflare 521: Nginx debe escuchar en 443 con certificado de origen vÃ¡lido
- `git pull` ownership error: `git config --global --add safe.directory /var/repo/venza`

