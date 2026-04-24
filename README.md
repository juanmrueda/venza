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

---

## Estado actual (24 abr 2026)

| SecciÃ³n | Estado |
|---------|--------|
| Servidor Digital Ocean | âœ… Configurado |
| WordPress + SSL | âœ… Funcionando |
| Tema custom activo | âœ… |
| Plugins (ACF, CF7, Yoast) | âœ… Instalados |
| 6 productos en WP con imÃ¡genes | âœ… |
| Home page | âœ… Completa (ajustada 1:1 contra arte aprobado) |
| Header + Footer global | âœ… Ajustados segÃºn referencia visual |
| Productos (archivo `/productos/`) | âœ… Implementado y editable desde admin |
| PÃ¡ginas internas restantes | En progreso |

---

## Cambios recientes (23 abr 2026)

- Home ajustado para respetar el layout de referencia (`Assets/Venza WB_PÃ¡gina_01.jpg`).
- Header actualizado con color de fondo `#eef4ff`, lÃ­nea inferior `#8cbce1` y color de texto "SÃ­guenos" `#210a67`.
- Reemplazo de logo y redes con assets entregados en carpeta de logos.
- Footer global ajustado para quedar alineado al diseÃ±o aprobado.
- Hero temporal montado con `theme/assets/images/banners/bannerhomedemo.svg` mientras llega el video final.
- `/productos/` migrado de maqueta estÃ¡tica a versiÃ³n dinÃ¡mica editable desde WordPress admin.
- Se agregaron campos ACF locales para la portada de productos y nuevos template parts dinÃ¡micos.

---

## Actualizacion reciente (24 abr 2026)

- Pagina `Beneficios` publicada en `https://venza.ipalmera.com/beneficios/`.
- Beneficios ahora tiene fallback visual completo si ACF esta vacio (quote + 8 bloques).
- Se agrego grupo ACF local `Pagina - Beneficios` para editar:
  - quote principal
  - 8 beneficios (titulo, descripcion e imagen)
  - tipo de fondo (`default`, `image`, `video`)
  - opacidad de capa del fondo
- Soporte de fondo animado en Beneficios via video (mp4/webm) cargado desde admin.
- Estado de deploy validado en DO y produccion alineada con `main`.

## Mapa del sitio

| PÃ¡gina | URL | Template WP | Estado |
|--------|-----|-------------|--------|
| Home | `/` | `front-page.php` | âœ… |
| Productos (archivo) | `/productos/` | `archive-producto.php` | âœ… Editable (ACF + contenido dinÃ¡mico) |
| Producto â€” Crema Humectante | `/productos/crema-humectante/` | `single-producto.php` | Pendiente |
| Producto â€” Frescura Extrema | `/productos/frescura-extrema/` | `single-producto.php` | Pendiente |
| Producto â€” Vitamina E | `/productos/vitamina-e/` | `single-producto.php` | Pendiente |
| Producto â€” SÃ¡bila | `/productos/sabila/` | `single-producto.php` | Pendiente |
| Producto â€” Coco | `/productos/coco/` | `single-producto.php` | Pendiente |
| Producto â€” Avena | `/productos/avena/` | `single-producto.php` | Pendiente |
| Beneficios | `/beneficios/` | `page-beneficios.php` | âœ… Completa (editable desde admin) |
| Noticias (archivo) | `/noticias/` | `archive-noticia.php` | Pendiente |
| Noticias â€” CategorÃ­a | `/noticias/categoria/lanzamientos/` | `taxonomy-noticia_cat.php` | Pendiente |
| Noticia individual | `/noticias/nombre-noticia/` | `single-noticia.php` | Pendiente |
| Blog (archivo) | `/blog/` | `home.php` | Pendiente |
| Blog individual | `/blog/nombre-post/` | `single.php` | Pendiente |
| Descubre Venza | `/descubre-venza/` | `page-descubre-venza.php` | Pendiente |
| Quiz de piel | `/descubre-venza/quiz/` | `page-quiz.php` | Pendiente |
| Contacto | `/contacto/` | `page-contacto.php` | Pendiente |

**NavegaciÃ³n principal:**  
`Inicio` / `Productos â–¾` / `Beneficios` / `Noticias` / `Blog` / `Descubre Venza` / `Contacto`

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
/wp-content/themes/venza/         â† Todo esto vive en /theme en el repo
â”œâ”€â”€ style.css
â”œâ”€â”€ functions.php
â”œâ”€â”€ index.php
â”œâ”€â”€ front-page.php                â† âœ… Home completa
â”œâ”€â”€ header.php
â”œâ”€â”€ footer.php
â”œâ”€â”€ page.php
â”œâ”€â”€ single.php                    â† Blog individual (pendiente)
â”œâ”€â”€ home.php                      â† Blog archivo (pendiente)
â”œâ”€â”€ 404.php
â”‚
â”œâ”€â”€ single-producto.php           â† Pendiente
â”œâ”€â”€ archive-producto.php          â† âœ… Home de productos editable
â”œâ”€â”€ single-noticia.php            â† Pendiente
â”œâ”€â”€ archive-noticia.php           â† Pendiente
â”œâ”€â”€ taxonomy-noticia_cat.php      â† Pendiente
â”‚
â”œâ”€â”€ page-beneficios.php           â† âœ… Publicada y editable desde admin
â”œâ”€â”€ page-descubre-venza.php       â† Pendiente
â”œâ”€â”€ page-quiz.php                 â† Pendiente
â”œâ”€â”€ page-contacto.php             â† Pendiente
â”‚
â”œâ”€â”€ assets/
â”‚   â”œâ”€â”€ css/main.css              â† Design system completo âœ…
â”‚   â”œâ”€â”€ js/
â”‚   â”‚   â”œâ”€â”€ main.js
â”‚   â”‚   â””â”€â”€ quiz.js               â† LÃ³gica quiz completa âœ…
â”‚   â”œâ”€â”€ fonts/                    â† Montage, Satoshi, Gotham âœ…
â”‚   â””â”€â”€ images/
â”‚       â”œâ”€â”€ logo.svg              â† âœ…
â”‚       â”œâ”€â”€ productos/            â† 6 PNGs fondo transparente âœ…
â”‚       â””â”€â”€ banners/              â† JPGs hero por producto âœ…
â”‚
â”œâ”€â”€ inc/
â”‚   â”œâ”€â”€ cpt.php                   â† CPTs y taxonomÃ­as âœ…
â”‚   â”œâ”€â”€ acf-fields.php
â”‚   â”œâ”€â”€ acf-producto-home.php     â† âœ… Campos ACF de home productos
â”‚   â””â”€â”€ helpers.php
â”‚
â””â”€â”€ template-parts/
    â”œâ”€â”€ global/
    â”‚   â”œâ”€â”€ nav.php               â† âœ…
    â”‚   â””â”€â”€ social-links.php
    â”œâ”€â”€ home/
    â”‚   â”œâ”€â”€ hero.php              â† âœ… (placeholder coco.jpg â†’ reemplazar con video)
    â”‚   â”œâ”€â”€ productos-destacados.php â† âœ…
    â”‚   â”œâ”€â”€ beneficios-strip.php  â† âœ…
    â”‚   â””â”€â”€ galeria-hoy.php       â† âœ…
    â”œâ”€â”€ producto/
    â”‚   â”œâ”€â”€ hero.php              â† âœ… dinÃ¡mico
    â”‚   â”œâ”€â”€ home-beneficios.php   â† âœ… dinÃ¡mico editable
    â”‚   â”œâ”€â”€ home-descripcion.php  â† âœ… dinÃ¡mico editable
    â”‚   â”œâ”€â”€ home-claim.php        â† âœ… dinÃ¡mico editable
    â”‚   â”œâ”€â”€ disponibilidad.php    â† âœ… dinÃ¡mico editable
    â”‚   â””â”€â”€ mas-productos.php     â† âœ… dinÃ¡mico editable
    â”œâ”€â”€ noticias/                 â† Pendiente
    â””â”€â”€ quiz/                    â† Pendiente (JS listo, faltan templates PHP)
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
- [ ] Video hero principal (actualmente placeholder `bannerhomedemo.svg`)
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

| DÃ­a | Fecha | Entregable | Estado |
|-----|-------|------------|--------|
| 1 | MiÃ© 22 Abr | Servidor + WP + Home page | âœ… |
| 2 | Jue 23 Abr | Template producto (Ã—6) + Beneficios | |
| 3 | Vie 24 Abr | Noticias + Blog | |
| 4 | SÃ¡b 25 Abr | Descubre Venza + Quiz | |
| 5 | Dom 26 Abr | Contacto + responsive QA | |
| 6 | Lun 27 Abr | Carga contenido real + fixes | |
| 7 | Mar 28 Abr | Deploy final + revisiÃ³n cliente | |

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

