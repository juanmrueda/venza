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
- Servidor: Digital Ocean Droplet Ubuntu 22.04 — IP: 142.93.15.66
- Nginx + PHP 8.2 + MySQL 8.0
- SSL: Cloudflare Origin Certificate (15 años, Full Strict mode)

## Design system confirmado

```css
--color-navy:       #2B255E;   /* Azul marino — titulos, nav */
--color-green:      #4EB89F;   /* Verde Venza — acentos, botones */
--color-blue-light: #8CBCE1;   /* Azul claro — detalles */
--color-bg-light:   #eef3fb;   /* Fondo secciones alternas */
--color-gray:       #717171;   /* Texto secundario */
--font-display:     'Montage', Georgia, serif;    /* Títulos */
--font-body:        'Satoshi', 'Gotham', system-ui, sans-serif; /* Cuerpo */
```

Fuentes cargadas desde `/theme/assets/fonts/` (archivo local, no Google Fonts).

## Servidor — configuración actual

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
| Tema | /var/repo/venza/theme → symlink → /var/www/html/wp-content/themes/venza |

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

## Estado actual del proyecto (23 abr 2026)

### Completado ✅
- [x] Servidor Digital Ocean configurado (Nginx + PHP 8.2 + MySQL 8.0 + SSL)
- [x] WordPress instalado y funcionando en venza.ipalmera.com
- [x] SSL Cloudflare Full Strict (Origin Certificate 15 años)
- [x] Deploy workflow: git push → ssh git pull (funciona)
- [x] Tema custom activado en WP
- [x] CPTs registrados: `producto` (slug: productos), `noticia` (slug: noticias)
- [x] Taxonomías: `linea_producto`, `noticia_cat`
- [x] Design system CSS completo (`theme/assets/css/main.css`)
- [x] Fuentes cargadas localmente (Montage, Satoshi, Gotham)
- [x] Logo Venza integrado en header
- [x] 6 productos creados en WP con imágenes PNG reales
- [x] Plugins instalados: ACF Free, Contact Form 7, Yoast SEO
- [x] Quiz lógica JS lista (`theme/assets/js/quiz.js`)
- [x] **Home page completa** — 4 secciones:
  - Hero (placeholder `bannerhomedemo.svg` — reemplazar con video del cliente)
  - Productos destacados (6 productos en filas alternas, imágenes reales)
  - Beneficios strip (3 col: texto | imagen producto | texto, fondo #eef3fb)
  - Galería Venza Hoy (3 cards desde CPT noticia/post, fallback placeholders)
- [x] Header home ajustado a referencia aprobada:
  - Fondo `#eef4ff`
  - Línea inferior `#8cbce1`
  - Color de texto "Síguenos" `#210a67`
  - Logo y redes actualizados con assets entregados
- [x] Footer global ajustado a referencia aprobada
- [x] `archive-producto.php` implementado como home de productos editable desde admin (sin imagen estática)
- [x] Campos ACF locales agregados para home de productos (`inc/acf-producto-home.php`)
- [x] Nuevos template parts de productos:
  - `template-parts/producto/home-beneficios.php`
  - `template-parts/producto/home-descripcion.php`
  - `template-parts/producto/home-claim.php`

### Pendiente (en orden de prioridad)
- [ ] **Siguiente:** `single-producto.php` — página individual de producto
- [ ] `page-beneficios.php` — página editorial Beneficios
- [ ] `archive-noticia.php` + `taxonomy-noticia_cat.php` + `single-noticia.php`
- [ ] `home.php` (blog archivo) + `single.php` (blog individual)
- [ ] `page-descubre-venza.php` — video hero + carrusel YouTube
- [ ] `page-quiz.php` — quiz de piel (JS ya está listo, falta template)
- [ ] `page-contacto.php` — formulario CF7 (pedir ID del form al instalar)
- [ ] QA responsive en todas las páginas
- [ ] Reemplazar hero con video cuando el cliente lo entregue
- [ ] Migrar a servidor WHM de iPalmera al finalizar

## Assets recibidos ✅
- Logo Venza (SVG + PNG)
- Fuentes: Montage (display), Satoshi, Gotham (body)
- Fotos 6 productos PNG fondo transparente
- Banners hero por producto (JPG)
- Fotos "packs" de algunos productos

## Assets pendientes del cliente
- [ ] Video hero (actualmente placeholder con `bannerhomedemo.svg`)
- [ ] Imágenes para el quiz (aromas, entornos, tipos de piel)
- [ ] Crema Humectante — banner + pack
- [ ] Coco — packs adicionales
- [ ] Fotos lifestyle para Descubre Venza
- [ ] URL canal YouTube
- [ ] Email destino formulario de contacto
- [ ] Textos reales de cada producto
- [ ] Links a tiendas externas por producto y país
- [ ] Artículos para Noticias y Blog

## Estructura de carpetas clave
```
c:/dev/Venza/
├── CLAUDE.md          ← este archivo
├── README.md          ← documentación del proyecto
├── theme/             ← tema WordPress custom
│   ├── assets/css/main.css        ← design system completo
│   ├── assets/js/quiz.js          ← quiz de piel (vanilla JS, listo)
│   ├── assets/js/main.js          ← JS global
│   ├── assets/fonts/              ← Montage, Satoshi, Gotham
│   ├── assets/images/             ← logo, iconos SVG
│   ├── assets/images/productos/   ← PNGs fondo transparente
│   ├── assets/images/banners/     ← JPG banners hero
│   ├── inc/cpt.php                ← CPTs y taxonomías
│   ├── inc/acf-producto-home.php  ← campos ACF para home productos
│   └── template-parts/
│       ├── home/
│       │   ├── hero.php                ← ✅ listo
│       │   ├── productos-destacados.php ← ✅ listo
│       │   ├── beneficios-strip.php    ← ✅ listo
│       │   └── galeria-hoy.php         ← ✅ listo
│       ├── producto/
│       │   ├── hero.php
│       │   ├── home-beneficios.php
│       │   ├── home-descripcion.php
│       │   ├── home-claim.php
│       │   ├── disponibilidad.php
│       │   └── mas-productos.php
│       ├── noticias/               ← pendiente
│       └── quiz/                   ← pendiente
├── deploy/
│   ├── server-setup.sh
│   ├── deploy.sh
│   └── keygen.sh
└── docs/
    └── quiz-logic.md
```

## Pages / Templates
| Template | Ruta | Estado |
|----------|------|--------|
| Home | `front-page.php` | ✅ Completo |
| Productos archivo | `archive-producto.php` | ✅ Completo (editable admin) |
| Producto single | `single-producto.php` | Pendiente |
| Beneficios | `page-beneficios.php` | Pendiente |
| Noticias archivo | `archive-noticia.php` | Pendiente |
| Taxonomía noticia | `taxonomy-noticia_cat.php` | Pendiente |
| Noticia single | `single-noticia.php` | Pendiente |
| Blog archivo | `home.php` | Pendiente |
| Blog single | `single.php` | Pendiente |
| Descubre Venza | `page-descubre-venza.php` | Pendiente |
| Quiz de piel | `page-quiz.php` | Pendiente |
| Contacto | `page-contacto.php` | Pendiente |

## Productos del sitio (6 jabones)
Crema Humectante / Frescura Extrema / Vitamina E / Sábila / Coco / Avena

## Errores conocidos y soluciones
- `apt upgrade` se colgaba: usar `DEBIAN_FRONTEND=noninteractive` siempre
- PHP 8.2 no está en repos default Ubuntu 22.04: agregar `ppa:ondrej/php`
- `$_SERVER` se rompía con sed en wp-config.php: usar Python para replace exacto
- Cloudflare 521: Nginx debe escuchar en 443 con certificado de origen válido
- `git pull` ownership error: `git config --global --add safe.directory /var/repo/venza`
