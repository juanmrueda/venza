# Repo MAD - Venza

Last updated: 2026-04-26
Current phase: Home refinements with admin-enablement workflow

## Purpose

This project is the corporate site for **Venza / Dinant**, built on WordPress with a custom theme.

Main goals:

- Match approved visual references page by page.
- Keep sections editable from WordPress admin.
- Deploy directly to production DigitalOcean environment when requested.

## Technical Stack

- WordPress 6.x
- Custom theme in `theme/`
- PHP templates + ACF local fields
- CSS in `theme/assets/css/main.css`
- Vanilla JS in `theme/assets/js/`

## High-Level Modules

### 1. Theme Core

- `theme/functions.php`: bootstrap, includes, assets, image sizes.
- `theme/inc/cpt.php`: CPT and taxonomy registration (`producto`, `noticia`, `linea_producto`, `noticia_cat`).
- `theme/inc/helpers.php`: helper utilities for templates and fallbacks.

### 2. ACF Config

- `theme/inc/acf-producto-home.php`: product home and single product editable fields.
- `theme/inc/acf-home.php`: home sections editable fields (beneficios, productos, venza hoy).
- `theme/inc/acf-page-beneficios.php`: beneficios page editable fields.
- `theme/inc/acf-noticia.php`: noticia and noticia category visual fields.

### 3. Main Sections / Templates

- Home: `theme/front-page.php` + `theme/template-parts/home/*`
- Productos:
  - Archive: `theme/archive-producto.php`
  - Single: `theme/single-producto.php`
- Beneficios: `theme/page-beneficios.php`
- Noticias:
  - Home archive: `theme/archive-noticia.php`
  - Category: `theme/taxonomy-noticia_cat.php`
  - Single: `theme/single-noticia.php`
- Blog:
  - Archive: `theme/home.php`
  - Single: `theme/single.php`
- Descubre Venza: `theme/page-descubre-venza.php`
- Quiz: `theme/page-quiz.php`
- Contacto: `theme/page-contacto.php`

### 4. Global UI

- Header: `theme/header.php`
- Footer: `theme/footer.php`
- Main styling: `theme/assets/css/main.css`

## Current Functional Status

- Beneficios: implemented and editable.
- Productos: archive and single structure implemented; Frescura Extrema refined.
- Noticias: new visual structure implemented in theme and deployed.
- Demo content in production:
  - Category: `Nuevos Lanzamientos` (slug `nuevos-lanzamientos`)
  - Demo post: `Venza Crema Humectante: Limpia, Suaviza e Hidrata`

## Current Focus

Starting now: **Home adjustments**.

When touching Home, prioritize only these files unless required:

- `theme/front-page.php`
- `theme/template-parts/home/*`
- `theme/assets/css/main.css`
- Any directly related helper/ACF include if strictly needed

## Working Protocol (Required)

Before any implementation:

1. Read `docs/repo_map.md`
2. Identify relevant modules
3. Modify only necessary files
4. Avoid scanning entire repository
5. Follow existing architecture

And additionally:

- Always read this file (`docs/repo_mad.md`) at task start.
- Always update this file at the end of each completed action.

## Delivery Workflow (Agreed)

- For new sections:
  1. Build design/layout first (pixel-perfect target).
  2. Wait for explicit user trigger `ejecuta admin`.
  3. Convert that section to admin-editable (ACF + template wiring).
  4. Deploy when user requests `despliega`.

## Action Log

### 2026-04-26 - Home background and product block visual tuning

- Added `Assets/backgroundhome.png` to the theme as `theme/assets/images/backgroundhome.png`.
- Applied the background from below the hero video through the claim and products area.
- Tuned Home product blocks toward the provided reference:
  - smaller product section title rhythm
  - reduced product line title, description, caption, and CTA sizes
  - tighter row heights and spacing
  - first product block now uses a blue-to-white treatment when no admin background is set
- Files updated:
  - `theme/assets/css/main.css`
  - `theme/assets/images/backgroundhome.png`
  - `docs/repo_mad.md`

### 2026-04-24 - Deploy standard switched to root

- Deploy workflow normalized to use `root@142.93.15.66` always.
- `deploy/deploy.sh` now pulls from server repo root (`/var/repo/venza`) instead of theme path.
- This aligns script behavior with the manual deploy command currently used in production.

### 2026-04-24 - Home fully editable + front-page editor stability fix

- Home section admin-enablement completed across all blocks:
  - Hero now editable from Front Page ACF:
    - main video, poster, wait-until-end toggle, slide images 2/3/4, claim text
  - Productos section title now editable from admin
  - Venza Hoy section now editable for:
    - section title, intro/pill text, cards CTA text, video, poster
- Existing editable blocks preserved:
  - Productos line blocks (titles, descriptions, CTA, backgrounds, rotating images)
  - Beneficios home copy block
- Applied the same editor stability approach used in products to Home:
  - Gutenberg disabled specifically for Front Page edit screen (classic editor for ACF-heavy home fields)
  - Keeps ACF field rendering/paste behavior stable on Home admin
- Files updated:
  - `theme/inc/acf-home.php`
  - `theme/template-parts/home/hero.php`
  - `theme/template-parts/home/productos-destacados.php`
  - `theme/template-parts/home/galeria-hoy.php`
  - `theme/functions.php`

### 2026-04-24 - Product admin ACF visibility bug mitigation

- Addressed intermittent issue where ACF product fields (notably WYSIWYG) appeared visually blank until browser restart.
- Applied stability fix by disabling Gutenberg only for CPT `producto`, forcing classic editor meta-box flow for product editing.
- Files updated:
  - `theme/functions.php`

### 2026-04-24 - README synced with real navigation status

- Updated `README.md` to reflect current implementation reality:
  - site map status corrected (Productos single + Noticias moved from pending to implemented)
  - current progress clarified for Blog, Descubre Venza, Quiz, and Contacto
  - folder structure section aligned with actual files in `theme/`
  - timeline status adjusted to match delivered vs in-progress work

### 2026-04-24 - Header tuning approved and documented

- User validated the final header look in production (`línea inferior` + `altura compacta`).
- Documentation synced to reflect this closed adjustment cycle.
- No additional functional changes applied in this step.

### 2026-04-24 - Header compact + bottom line doubled

- Increased header bottom blue line thickness from `3px` to `6px` (double).
- Reduced header overall height for a more compact look:
  - Desktop header container: `84px` -> `76px`
  - <=1200px header container: `76px` -> `72px`
- Aligned mobile nav vertical offset to match the compact header (`top: 70px`).
- File updated:
  - `theme/assets/css/main.css`

### 2026-04-24 - Header global spacing + blue line + submenu indicator

- Adjusted global header navigation spacing for clearer separation between top menu items.
- Increased blue bottom bar under header from `1px` to `3px` for stronger visual presence.
- Updated submenu indicator in header (`Productos`) to an inverted triangle in complementary blue.
- Kept active-item underline behavior intact while moving submenu arrow rendering to a separate pseudo-element.
- File updated:
  - `theme/assets/css/main.css`

### 2026-04-24 - Home hero slider synced to first video end

- Updated Home hero carousel behavior:
  - first slide video is now marked to wait until `ended`
  - carousel advances to slide 2 only after the first video finishes
  - default 6s timer remains for non-video slides
- Technical changes:
  - `theme/template-parts/home/hero.php`: first video slide now uses `data-wait-end="1"` and disables loop
  - `theme/assets/js/main.js`: autoplay scheduler now supports video-end-triggered transition

### 2026-04-24 - Documentation sync after home admin updates

- Documentation aligned with latest Home work:
  - Home productos now 2 fixed lines, admin-editable, with per-line rotating product images.
  - Home beneficios section now admin-editable from front page fields.
  - Home `Venza hoy` video now supports default hero video + optional admin override.
- Added explicit "design first -> ejecuta admin -> despliega" workflow in this file.

### 2026-04-24 - Home beneficios editable from admin

- Converted Home `Beneficios` section from hardcoded copy to front-page ACF fields.
- Added editable fields in front page for:
  - section title
  - 4 left-column benefit items (title + text)
  - 4 right-column benefit items (title + text)
  - center soap labels (green/cream)
- Preserved current visual structure and fallbacks so design remains unchanged if fields are empty.
- Files updated:
  - `theme/template-parts/home/beneficios-strip.php`
  - `theme/inc/acf-home.php`

### 2026-04-24 - Home (2 líneas de productos + video en Venza hoy)

- Home `Productos` refactorizado para mostrar solo 2 bloques fijos:
  - `Línea Antibacterial`
  - `Línea Hidratación Profunda`
- Se eliminó el render dinámico de todos los productos en Home.
- Cada bloque ahora soporta desde admin:
  - título de línea
  - descripción
  - texto y URL de botón
  - background del bloque
  - hasta 5 imágenes rotativas con nombre por línea (la leyenda bajo imagen rota con la foto)
- Se agregó rotador automático en frontend para esas imágenes por línea.
- `Venza hoy` ahora usa el mismo video del hero por defecto (`assets/videos/venza_video_home.mp4`) y permite override desde admin (video + poster).
- Archivos actualizados:
  - `theme/template-parts/home/productos-destacados.php`
  - `theme/template-parts/home/galeria-hoy.php`
  - `theme/assets/js/main.js`
  - `theme/assets/css/main.css`
  - `theme/functions.php`
  - `theme/inc/acf-home.php` (nuevo)

### 2026-04-24 - Home Productos pixel-perfect (Pagina 01)

- Updated Home products section visuals to match `Assets/Venza WB_Página_01.jpg`:
  - stronger section spacing and title rhythm
  - alternating white/light-blue product blocks
  - larger product line and description typography
  - product image/caption composition and CTA spacing tuned to reference
- Files touched in scope:
  - `theme/template-parts/home/productos-destacados.php`
  - `theme/assets/css/main.css`
- Text polish:
  - CTA changed to `Conoce más`

### 2026-04-24 - Noticias closed, Home next

- Implemented and deployed:
  - `archive-noticia.php`
  - `taxonomy-noticia_cat.php`
  - `single-noticia.php`
  - News styles in `assets/css/main.css`
  - News helpers in `inc/helpers.php`
  - New ACF file `inc/acf-noticia.php` loaded from `functions.php`
- Created production demo content for visual review:
  - term `nuevos-lanzamientos`
  - published demo noticia with featured image and meta badges
- Next track confirmed with user: move to Home adjustments.

### 2026-04-24 - Documentation protocol established

- Added `agent.md` at repo root with mandatory implementation guardrails.
- Added `docs/repo_map.md` as required pre-read pointer.
- Added and initialized `docs/repo_mad.md` as live project map and action log.
- Updated `README.md` and `CLAUDE.md` to formalize the new protocol.

### 2026-04-24 - Home hero video integrated

- New home hero video file added:
  - `theme/assets/videos/venza_video_home.mp4`
- Updated `theme/template-parts/home/hero.php`:
  - First hero slide now uses `venza_video_home.mp4` when available.
  - Keeps image fallback if video is missing.
  - Removed floating play overlay button from hero video slide to keep clean autoplay presentation.
- Scope respected: only Home module + required docs update.
