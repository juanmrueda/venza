# Venza — Sitio Web Corporativo
**Cliente:** Venza / Dinant  
**URL Demo:** venza.ipalmera.com  
**Deadline:** Martes 28 de abril, 2026  
**Stack:** WordPress 6.x + Tema Custom (sin page builder)

---

## Estado actual (23 abr 2026)

| Sección | Estado |
|---------|--------|
| Servidor Digital Ocean | ✅ Configurado |
| WordPress + SSL | ✅ Funcionando |
| Tema custom activo | ✅ |
| Plugins (ACF, CF7, Yoast) | ✅ Instalados |
| 6 productos en WP con imágenes | ✅ |
| Home page | ✅ Completa (ajustada 1:1 contra arte aprobado) |
| Header + Footer global | ✅ Ajustados según referencia visual |
| Productos (archivo `/productos/`) | ✅ Implementado y editable desde admin |
| Páginas internas restantes | En progreso |

---

## Cambios recientes (23 abr 2026)

- Home ajustado para respetar el layout de referencia (`Assets/Venza WB_Página_01.jpg`).
- Header actualizado con color de fondo `#eef4ff`, línea inferior `#8cbce1` y color de texto "Síguenos" `#210a67`.
- Reemplazo de logo y redes con assets entregados en carpeta de logos.
- Footer global ajustado para quedar alineado al diseño aprobado.
- Hero temporal montado con `theme/assets/images/banners/bannerhomedemo.svg` mientras llega el video final.
- `/productos/` migrado de maqueta estática a versión dinámica editable desde WordPress admin.
- Se agregaron campos ACF locales para la portada de productos y nuevos template parts dinámicos.

---

## Mapa del sitio

| Página | URL | Template WP | Estado |
|--------|-----|-------------|--------|
| Home | `/` | `front-page.php` | ✅ |
| Productos (archivo) | `/productos/` | `archive-producto.php` | ✅ Editable (ACF + contenido dinámico) |
| Producto — Crema Humectante | `/productos/crema-humectante/` | `single-producto.php` | Pendiente |
| Producto — Frescura Extrema | `/productos/frescura-extrema/` | `single-producto.php` | Pendiente |
| Producto — Vitamina E | `/productos/vitamina-e/` | `single-producto.php` | Pendiente |
| Producto — Sábila | `/productos/sabila/` | `single-producto.php` | Pendiente |
| Producto — Coco | `/productos/coco/` | `single-producto.php` | Pendiente |
| Producto — Avena | `/productos/avena/` | `single-producto.php` | Pendiente |
| Beneficios | `/beneficios/` | `page-beneficios.php` | Pendiente |
| Noticias (archivo) | `/noticias/` | `archive-noticia.php` | Pendiente |
| Noticias — Categoría | `/noticias/categoria/lanzamientos/` | `taxonomy-noticia_cat.php` | Pendiente |
| Noticia individual | `/noticias/nombre-noticia/` | `single-noticia.php` | Pendiente |
| Blog (archivo) | `/blog/` | `home.php` | Pendiente |
| Blog individual | `/blog/nombre-post/` | `single.php` | Pendiente |
| Descubre Venza | `/descubre-venza/` | `page-descubre-venza.php` | Pendiente |
| Quiz de piel | `/descubre-venza/quiz/` | `page-quiz.php` | Pendiente |
| Contacto | `/contacto/` | `page-contacto.php` | Pendiente |

**Navegación principal:**  
`Inicio` / `Productos ▾` / `Beneficios` / `Noticias` / `Blog` / `Descubre Venza` / `Contacto`

---

## Stack técnico

```
WordPress 6.x (latest)
├── PHP 8.2+ (ppa:ondrej/php)
├── MySQL 8.0+
├── Nginx — Ubuntu 22.04 LTS, Digital Ocean
├── SSL: Cloudflare Origin Certificate (Full Strict, 15 años)
│
├── Tema custom: /wp-content/themes/venza/
│   ├── PHP templates (sin page builder)
│   ├── CSS custom (variables, Grid, Flexbox — sin Bootstrap)
│   └── Vanilla JS (sin jQuery excepto el que trae WP)
│
├── Plugins
│   ├── Advanced Custom Fields (ACF) — campos de productos y noticias
│   ├── Contact Form 7 — formulario de contacto
│   └── Yoast SEO — SEO básico
│
└── Custom Post Types
    ├── producto (slug: productos, taxonomía: linea_producto)
    └── noticia (slug: noticias, taxonomía: noticia_cat)
```

---

## Design system

```css
--color-navy:       #2B255E;   /* Azul marino — titulos, nav */
--color-green:      #4EB89F;   /* Verde Venza — acentos, botones */
--color-blue-light: #8CBCE1;   /* Azul claro — detalles */
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
| Tema (symlink) | /var/repo/venza/theme → /var/www/html/wp-content/themes/venza |

---

## Workflow de deploy

```
Local (c:/dev/Venza)
    │
    ├── git add + git commit
    └── git push origin main
                │
                └── SSH → 142.93.15.66
                        └── cd /var/repo/venza && git pull origin main
```

```bash
# Deploy rápido desde local:
bash deploy/deploy.sh

# O manual:
ssh root@142.93.15.66 "cd /var/repo/venza && git pull origin main"
```

---

## Estructura de carpetas

```
/wp-content/themes/venza/         ← Todo esto vive en /theme en el repo
├── style.css
├── functions.php
├── index.php
├── front-page.php                ← ✅ Home completa
├── header.php
├── footer.php
├── page.php
├── single.php                    ← Blog individual (pendiente)
├── home.php                      ← Blog archivo (pendiente)
├── 404.php
│
├── single-producto.php           ← Pendiente
├── archive-producto.php          ← ✅ Home de productos editable
├── single-noticia.php            ← Pendiente
├── archive-noticia.php           ← Pendiente
├── taxonomy-noticia_cat.php      ← Pendiente
│
├── page-beneficios.php           ← Pendiente
├── page-descubre-venza.php       ← Pendiente
├── page-quiz.php                 ← Pendiente
├── page-contacto.php             ← Pendiente
│
├── assets/
│   ├── css/main.css              ← Design system completo ✅
│   ├── js/
│   │   ├── main.js
│   │   └── quiz.js               ← Lógica quiz completa ✅
│   ├── fonts/                    ← Montage, Satoshi, Gotham ✅
│   └── images/
│       ├── logo.svg              ← ✅
│       ├── productos/            ← 6 PNGs fondo transparente ✅
│       └── banners/              ← JPGs hero por producto ✅
│
├── inc/
│   ├── cpt.php                   ← CPTs y taxonomías ✅
│   ├── acf-fields.php
│   ├── acf-producto-home.php     ← ✅ Campos ACF de home productos
│   └── helpers.php
│
└── template-parts/
    ├── global/
    │   ├── nav.php               ← ✅
    │   └── social-links.php
    ├── home/
    │   ├── hero.php              ← ✅ (placeholder coco.jpg → reemplazar con video)
    │   ├── productos-destacados.php ← ✅
    │   ├── beneficios-strip.php  ← ✅
    │   └── galeria-hoy.php       ← ✅
    ├── producto/
    │   ├── hero.php              ← ✅ dinámico
    │   ├── home-beneficios.php   ← ✅ dinámico editable
    │   ├── home-descripcion.php  ← ✅ dinámico editable
    │   ├── home-claim.php        ← ✅ dinámico editable
    │   ├── disponibilidad.php    ← ✅ dinámico editable
    │   └── mas-productos.php     ← ✅ dinámico editable
    ├── noticias/                 ← Pendiente
    └── quiz/                    ← Pendiente (JS listo, faltan templates PHP)
```

---

## Quiz de tipo de piel

Ver: [`docs/quiz-logic.md`](docs/quiz-logic.md)

**6 preguntas → 1 de 6 jabones:**  
Crema Humectante / Frescura Extrema / Vitamina E / Sábila / Coco / Avena

Implementación: Vanilla JS puro (`quiz.js`). Sistema de puntaje por respuesta. Sin backend. Sin cookies obligatorias. Resultado solo en pantalla.

---

## Assets recibidos ✅
- Logo Venza (SVG + PNG transparente)
- Fuentes: Montage, Satoshi, Gotham
- 6 productos PNG fondo transparente
- Banners hero por producto (JPG)
- Packs de algunos productos

## Assets pendientes del cliente
- [ ] Video hero principal (actualmente placeholder `bannerhomedemo.svg`)
- [ ] Crema Humectante — banner + pack
- [ ] Coco — packs adicionales
- [ ] Fotos lifestyle para Descubre Venza
- [ ] Imágenes para el quiz (aromas, entornos, tipos de piel)
- [ ] URL canal YouTube de Venza
- [ ] Email destino formulario de contacto
- [ ] Textos reales de cada producto
- [ ] Links a tiendas externas por producto y país
- [ ] Artículos para Noticias y Blog

---

## Timeline

| Día | Fecha | Entregable | Estado |
|-----|-------|------------|--------|
| 1 | Mié 22 Abr | Servidor + WP + Home page | ✅ |
| 2 | Jue 23 Abr | Template producto (×6) + Beneficios | |
| 3 | Vie 24 Abr | Noticias + Blog | |
| 4 | Sáb 25 Abr | Descubre Venza + Quiz | |
| 5 | Dom 26 Abr | Contacto + responsive QA | |
| 6 | Lun 27 Abr | Carga contenido real + fixes | |
| 7 | Mar 28 Abr | Deploy final + revisión cliente | |

---

## Plugins instalados

| Plugin | Propósito |
|--------|-----------|
| Advanced Custom Fields (free) | Campos custom de productos y noticias |
| Contact Form 7 | Formulario de contacto |
| Yoast SEO | SEO básico, sitemaps |

---

## Contacto del proyecto
- **Desarrollador:** juan.rueda@ipalmera.com
- **Asistido por:** Claude Code (Anthropic)
