# Venza â€” Sitio Web Corporativo
**Cliente:** Venza / Dinant  
**URL Demo:** venza.ipalmera.com  
**Deadline:** Martes 28 de abril, 2026  
**Stack:** WordPress 6.x + Tema Custom (sin page builder)

---

## Protocolo de ejecucion (nuevo)

- Leer siempre `docs/repo_map.md` antes de implementar una funcionalidad.
- Usar `docs/repo_mad.md` como mapa vivo del proyecto.
- Al finalizar cada accion completada, actualizar `docs/repo_mad.md`.
- Modificar solo modulos relevantes para evitar lecturas masivas e innecesarias del repo.
- Flujo operativo acordado:
  1. primero dejar la seccion pixel-perfect,
  2. luego, cuando el usuario diga `ejecuta admin`, volverla administrable,
  3. desplegar solo cuando el usuario diga `despliega`.

---

## Estado actual (24 abr 2026)

| Seccion | Estado |
|---------|--------|
| Servidor Digital Ocean | OK (configurado) |
| WordPress + SSL | OK (funcionando) |
| Tema custom activo | OK |
| Plugins (ACF, CF7, Yoast) | OK (instalados) |
| Home page | OK (ajustada y con bloques clave administrables) |
| Header + Footer global | OK (ajustados segun referencia) |
| Productos (archivo `/productos/`) | OK (dinamico + editable) |
| Productos single (`/productos/...`) | OK (template unificado + campos admin) |
| Beneficios (`/beneficios/`) | OK (editable, con soporte de fondo animado) |
| Noticias (archivo, categoria, single) | OK (implementado y desplegado) |
| Blog (archivo + single) | En progreso (base implementada) |
| Descubre Venza + Quiz | En progreso (base implementada) |
| Contacto | En progreso (template base, falta configurar CF7 final) |

---

## Cambios recientes (23-24 abr 2026)

- Home ajustado para respetar `Assets/Venza WB_Pagina_01.jpg`.
- Header y footer actualizados segun referencia visual.
- Hero de Home actualizado a video (`theme/assets/videos/venza_video_home.mp4`) y slider sincronizado al fin del video.
- Home `Productos` refactorizado a 2 bloques fijos (Antibacterial e Hidratacion Profunda), administrables desde Front Page.
- Home `Beneficios` ahora administrable desde Front Page.
- Home `Venza hoy` usa el video del hero por defecto con opcion de override desde admin.
- Pagina `Beneficios` publicada y editable (texto, items y fondo animado).
- Noticias implementado y desplegado:
  - `archive-noticia.php`
  - `taxonomy-noticia_cat.php`
  - `single-noticia.php`

## Mapa del sitio

| Pagina | URL | Template WP | Estado |
|--------|-----|-------------|--------|
| Home | `/` | `front-page.php` | OK |
| Productos (archivo) | `/productos/` | `archive-producto.php` | OK (editable) |
| Producto - Crema Humectante | `/productos/crema-humectante/` | `single-producto.php` | OK (template unificado) |
| Producto - Frescura Extrema | `/productos/frescura-extrema/` | `single-producto.php` | OK (template unificado) |
| Producto - Vitamina E | `/productos/vitamina-e/` | `single-producto.php` | OK (template unificado) |
| Producto - Sabila | `/productos/sabila/` | `single-producto.php` | OK (template unificado) |
| Producto - Coco | `/productos/coco/` | `single-producto.php` | OK (template unificado) |
| Producto - Avena | `/productos/avena/` | `single-producto.php` | OK (template unificado) |
| Beneficios | `/beneficios/` | `page-beneficios.php` | OK (editable) |
| Noticias (archivo) | `/noticias/` | `archive-noticia.php` | OK |
| Noticias - Categoria | `/noticias/categoria/nuevos-lanzamientos/` | `taxonomy-noticia_cat.php` | OK |
| Noticia individual | `/noticias/nombre-noticia/` | `single-noticia.php` | OK |
| Blog (archivo) | `/blog/` | `home.php` | En progreso |
| Blog individual | `/blog/nombre-post/` | `single.php` | En progreso |
| Descubre Venza | `/descubre-venza/` | `page-descubre-venza.php` | En progreso |
| Quiz de piel | `/descubre-venza/quiz/` | `page-quiz.php` | En progreso |
| Contacto | `/contacto/` | `page-contacto.php` | En progreso |

**Navegacion principal:**  
`Inicio` / `Productos` (submenu) / `Beneficios` / `Noticias` / `Blog` / `Descubre Venza` / `Contacto`

---

## Edicion desde admin (Beneficios)

Ruta: WP Admin > Paginas > Beneficios.

Campos disponibles en el bloque "Pagina - Beneficios":

- Quote principal
- Beneficio 1 a Beneficio 8 (titulo, descripcion e imagen)
- Fondo animado - Tipo (default, image, video)
- Fondo animado - Imagen
- Fondo animado - Video (mp4/webm)
- Fondo animado - Opacidad de capa

Recomendacion para fondo animado:

- Subir video mp4 liviano (8-12s) en loop.
- Mantener resolucion optimizada para performance.

## Stack tÃ©cnico

```
WordPress 6.x (latest)
â”œâ”€â”€ PHP 8.2+ (ppa:ondrej/php)
â”œâ”€â”€ MySQL 8.0+
â”œâ”€â”€ Nginx â€” Ubuntu 22.04 LTS, Digital Ocean
â”œâ”€â”€ SSL: Cloudflare Origin Certificate (Full Strict, 15 aÃ±os)
â”‚
â”œâ”€â”€ Tema custom: /wp-content/themes/venza/
â”‚   â”œâ”€â”€ PHP templates (sin page builder)
â”‚   â”œâ”€â”€ CSS custom (variables, Grid, Flexbox â€” sin Bootstrap)
â”‚   â””â”€â”€ Vanilla JS (sin jQuery excepto el que trae WP)
â”‚
â”œâ”€â”€ Plugins
â”‚   â”œâ”€â”€ Advanced Custom Fields (ACF) â€” campos de productos y noticias
â”‚   â”œâ”€â”€ Contact Form 7 â€” formulario de contacto
â”‚   â””â”€â”€ Yoast SEO â€” SEO bÃ¡sico
â”‚
â””â”€â”€ Custom Post Types
    â”œâ”€â”€ producto (slug: productos, taxonomÃ­a: linea_producto)
    â””â”€â”€ noticia (slug: noticias, taxonomÃ­a: noticia_cat)
```

---

## Design system

```css
--color-navy:       #2B255E;   /* Azul marino â€” titulos, nav */
--color-green:      #4EB89F;   /* Verde Venza â€” acentos, botones */
--color-blue-light: #8CBCE1;   /* Azul claro â€” detalles */
--color-bg-light:   #eef3fb;   /* Fondo secciones alternas */
--color-gray:       #717171;   /* Texto secundario */
--font-display:     'Montage', Georgia, serif;
--font-body:        'Satoshi', 'Gotham', system-ui, sans-serif;
```

Fuentes servidas localmente desde `theme/assets/fonts/`.

---

## Servidor

| Dato | Valor |
|------|-------|
| Proveedor | Digital Ocean |
| IP | 142.93.15.66 |
| SO | Ubuntu 22.04 LTS |
| WP root | /var/www/html |
| Repo | /var/repo/venza |
| Tema (symlink) | /var/repo/venza/theme â†’ /var/www/html/wp-content/themes/venza |

---

## Workflow de deploy

```
Local (c:/dev/Venza)
    â”‚
    â”œâ”€â”€ git add + git commit
    â””â”€â”€ git push origin main
                â”‚
                â””â”€â”€ SSH â†’ 142.93.15.66
                        â””â”€â”€ cd /var/repo/venza && git pull origin main
```

```bash
# Deploy rÃ¡pido desde local:
bash deploy/deploy.sh

# O manual:
ssh root@142.93.15.66 "cd /var/repo/venza && git pull origin main"
```

---

## Estructura de carpetas

```
/wp-content/themes/venza/  (en el repo: /theme)
|- style.css
|- functions.php
|- front-page.php                 <- OK Home
|- header.php / footer.php
|- archive-producto.php           <- OK productos home
|- single-producto.php            <- OK template unificado
|- page-beneficios.php            <- OK editable
|- archive-noticia.php            <- OK
|- taxonomy-noticia_cat.php       <- OK
|- single-noticia.php             <- OK
|- home.php / single.php          <- Blog base (en progreso)
|- page-descubre-venza.php        <- Base (en progreso)
|- page-quiz.php                  <- Base (en progreso)
|- page-contacto.php              <- Base (en progreso)
|
|- assets/
|  |- css/main.css
|  |- js/main.js
|  |- js/quiz.js
|  |- videos/venza_video_home.mp4
|  |- fonts/
|  `- images/
|
|- inc/
|  |- cpt.php
|  |- helpers.php
|  |- acf-producto-home.php
|  |- acf-home.php
|  |- acf-page-beneficios.php
|  `- acf-noticia.php
|
`- template-parts/
   |- global/social-links.php
   |- home/hero.php
   |- home/productos-destacados.php
   |- home/beneficios-strip.php
   |- home/galeria-hoy.php
   |- producto/* (bloques del single)
   |- noticias/card.php
   `- noticias/categorias-tabs.php
```

---

## Quiz de tipo de piel

Ver: [`docs/quiz-logic.md`](docs/quiz-logic.md)

**6 preguntas â†’ 1 de 6 jabones:**  
Crema Humectante / Frescura Extrema / Vitamina E / SÃ¡bila / Coco / Avena

ImplementaciÃ³n: Vanilla JS puro (`quiz.js`). Sistema de puntaje por respuesta. Sin backend. Sin cookies obligatorias. Resultado solo en pantalla.

---

## Assets recibidos âœ…
- Logo Venza (SVG + PNG transparente)
- Fuentes: Montage, Satoshi, Gotham
- 6 productos PNG fondo transparente
- Banners hero por producto (JPG)
- Packs de algunos productos

## Assets pendientes del cliente
- [ ] (Opcional) Video hero final alternativo si se desea reemplazar `venza_video_home.mp4`
- [ ] Crema Humectante â€” banner + pack
- [ ] Coco â€” packs adicionales
- [ ] Fotos lifestyle para Descubre Venza
- [ ] ImÃ¡genes para el quiz (aromas, entornos, tipos de piel)
- [ ] URL canal YouTube de Venza
- [ ] Email destino formulario de contacto
- [ ] Textos reales de cada producto
- [ ] Links a tiendas externas por producto y paÃ­s
- [ ] ArtÃ­culos para Noticias y Blog

---

## Timeline

| Dia | Fecha | Entregable | Estado |
|-----|-------|------------|--------|
| 1 | Mie 22 Abr | Servidor + WP + Home page | OK |
| 2 | Jue 23 Abr | Template producto (x6) + Beneficios | OK |
| 3 | Vie 24 Abr | Noticias + Blog | Parcial (Noticias OK, Blog en progreso) |
| 4 | Sab 25 Abr | Descubre Venza + Quiz | En progreso |
| 5 | Dom 26 Abr | Contacto + responsive QA | En progreso |
| 6 | Lun 27 Abr | Carga contenido real + fixes | Pendiente |
| 7 | Mar 28 Abr | Deploy final + revision cliente | Pendiente |

---

## Plugins instalados

| Plugin | PropÃ³sito |
|--------|-----------|
| Advanced Custom Fields (free) | Campos custom de productos y noticias |
| Contact Form 7 | Formulario de contacto |
| Yoast SEO | SEO bÃ¡sico, sitemaps |

---

## Contacto del proyecto
- **Desarrollador:** juan.rueda@ipalmera.com
- **Asistido por:** Claude Code (Anthropic)

