# Repo MAD - Venza

Last updated: 2026-04-24
Current phase: Home adjustments (Noticias block closed for now)

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

## Action Log

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
