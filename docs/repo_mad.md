# Repo MAD - Venza

Last updated: 2026-04-26
Current phase: Descubre Venza pixel QA and video carousel

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
- `theme/inc/acf-page-descubre.php`: Descubre Venza video/home page editable fields.

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

Starting now: **Blog + Descubre Venza separation**.

When touching Blog, prioritize only these files unless required:

- `theme/home.php`
- `theme/single.php`
- `theme/template-parts/blog/card.php`
- `theme/inc/acf-blog.php`
- `theme/assets/css/main.css`
- `theme/functions.php` only for includes, image sizes, editor stability, or active menu state

When touching Descubre Venza, prioritize:

- `theme/page-descubre-venza.php`
- `theme/inc/acf-page-descubre.php`
- `theme/assets/css/main.css`
- `theme/functions.php` only for includes, editor stability, or active menu state

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

### 2026-04-26 - Descubre Venza hero and carousel tuning

- Tuned the top `Descubre Venza` hero toward the supplied reference:
  - smaller centered title
  - thinner rounded callout border
  - tighter callout text sizing and spacing
  - water-texture fallback background restored for this page.
- Removed the principal video cover behavior:
  - uploaded main video now renders without `poster`
  - external video fallback shows only the play treatment over a neutral placeholder, not a cover image.
- Reworked the lower videos from grid to carousel:
  - 4 cards visible on desktop, matching the reference
  - horizontal scroll with left/right arrows
  - responsive 2-card/tablet and 1-card/mobile behavior
- Added per-video admin switches:
  - `Video card N - Mostrar`
  - defaults: cards 1-4 on, cards 5-6 off.
- Files updated:
  - `theme/page-descubre-venza.php`
  - `theme/inc/acf-page-descubre.php`
  - `theme/assets/css/main.css`
  - `theme/assets/js/main.js`
  - `docs/repo_mad.md`

### 2026-04-26 - Descubre Venza video uploads and six video cards

- Updated `Descubre Venza` so the large media block under the intro can be a real uploaded video:
  - `Video principal - Archivo video`
  - `Video principal - Poster`
  - `Video principal - URL externa` remains as fallback/recommended option for hosted video.
- Set default YouTube CTA URL to `https://www.youtube.com/@jabonvenza`.
- Expanded the lower video section from 4 to 6 editable video cards.
- Each lower card now supports:
  - title
  - poster image
  - uploaded MP4/WebM/MOV file
  - external URL fallback
  - optional meta and duration
- Frontend renders uploaded card videos inline with native controls and `preload="none"` to avoid loading all heavy videos at page load.
- Tuned desktop/mobile grid so the six videos display as 3 columns on desktop, 2 columns on tablet, and 1 column on mobile.
- Production upload limits adjusted for the admin:
  - PHP-FPM `upload_max_filesize` and `post_max_size`: `256M`
  - Nginx `client_max_body_size`: `256M`
- Files updated:
  - `theme/page-descubre-venza.php`
  - `theme/inc/acf-page-descubre.php`
  - `theme/assets/css/main.css`
  - `docs/repo_mad.md`

### 2026-04-26 - Blog single unified and Descubre Venza video template

- Corrected architecture after user clarification:
  - Blog posts now use only the editorial type 1 template.
  - The former Blog type 2 video layout moved to the `Descubre Venza` page template.
- Removed the Blog post layout selector and all type 2 Blog ACF controls from `Blog - Campos visuales`.
- Added local ACF group `Pagina - Descubre Venza` with editable fields for:
  - hero title and callout
  - optional background toggle/image
  - main video poster and URL
  - videos section title, CTA, and 4 video cards
- Disabled Gutenberg for the `Descubre Venza` page template to keep ACF-heavy editing stable.
- Files updated:
  - `theme/single.php`
  - `theme/page-descubre-venza.php`
  - `theme/inc/acf-blog.php`
  - `theme/inc/acf-page-descubre.php`
  - `theme/functions.php`
  - `docs/repo_mad.md`

### 2026-04-26 - Blog featured image priority fix

- Fixed Blog image priority so the standard WordPress featured image controls the Blog card and single hero image.
- ACF image fields now act as fallbacks only when no featured image is selected.
- This prevents old demo ACF image IDs from overriding newly selected featured images.
- Files updated:
  - `theme/single.php`
  - `theme/template-parts/blog/card.php`
  - `theme/inc/acf-blog.php`
  - `docs/repo_mad.md`

### 2026-04-26 - Blog type 1 hero and overlay image controls

- Tuned Blog `Interna tipo 1 editorial` based on the supplied reference:
  - right hero image now starts flush under the header
  - title scale reduced
  - highlighted intro and body text reduced
  - editorial block row heights and text sizes tightened
- Added optional admin-controlled overlay images per type 1 block:
  - `Interna Tipo 1 - Bloque N imagen encima del texto`
  - `Interna Tipo 1 - Bloque N posicion imagen encima`
  - If no overlay image is selected, no overlay markup renders.
- Files updated:
  - `theme/single.php`
  - `theme/inc/acf-blog.php`
  - `theme/assets/css/main.css`
  - `docs/repo_mad.md`

### 2026-04-26 - Heavy background cleanup for Blog and internal pages

- Removed heavy automatic background image fallbacks from Blog:
  - `/blog/` no longer loads `backgroundhome.png` by default.
  - Blog internal type 2 no longer loads `backgroundhome.png` by default.
- Added Blog admin switches:
  - `Blog Home - Usar imagen de fondo`
  - `Interna Tipo 2 - Usar background superior`
  - Both are off by default to protect performance.
- Removed hardcoded background image from `/noticias/` home layout.
- Removed legacy image background reference from Contact page CSS.
- Kept lightweight CSS gradients/colors so layouts still preserve visual atmosphere without loading large background assets.
- Files updated:
  - `theme/home.php`
  - `theme/single.php`
  - `theme/inc/acf-blog.php`
  - `theme/assets/css/main.css`
  - `docs/repo_mad.md`

### 2026-04-26 - Blog home and two internal templates admin-enabled

- Implemented Blog home layout based on `Venza WB_Pagina_12.jpg`:
  - water-texture background
  - large horizontal white cards
  - editable card image, excerpt, and CTA text per post
  - editable Blog posts page background and global card CTA text
- Reworked standard WordPress post single template with two selectable layouts:
  - `Interna tipo 1 editorial` based on `Venza WB_Pagina_13.jpg`
  - `Interna tipo 2 video` based on `Venza WB_Pagina_14.jpg`
- Added local ACF group `theme/inc/acf-blog.php`:
  - Blog home settings on the posts page
  - per-post layout selector
  - hero image/text fields
  - type 1 editorial image/text blocks
  - type 2 video poster, CTA, and video card fields
- Applied editor stability fix to standard posts by disabling Gutenberg for `post`, matching the product/home approach.
- Updated global navigation active state so `Blog` remains active on archive, post single, category, tag, date, and author routes.
- Production configured after deploy:
  - Page `Blog` created and assigned as `page_for_posts`.
  - Default `Hello world!` post moved to draft.
  - Demo posts published for visual QA:
    - `no-puedes-dormir` (type 2 video)
    - `como-trabajar-menos-y-ser-productivo` (type 1 editorial)
    - `autocuidado-es-mas-que-solo-consentirte` (type 1 editorial)
    - `corre-al-ritmo-de-tu-playlist` (type 1 editorial)
- Files updated:
  - `theme/home.php`
  - `theme/single.php`
  - `theme/template-parts/blog/card.php`
  - `theme/inc/acf-blog.php`
  - `theme/functions.php`
  - `theme/assets/css/main.css`
  - `docs/repo_mad.md`

### 2026-04-26 - Noticia badge icon fallback fix

- Fixed internal news badge rendering when editors add only the new icon/position fields while badge text still lives in the legacy `noticia_badges` textarea.
- Badge helper now merges legacy badge text with the new icon and position fields by slot.
- Icon rendering now falls back to attachment URL when `wp_get_attachment_image()` cannot generate markup.
- Files updated:
  - `theme/inc/helpers.php`
  - `theme/single-noticia.php`
  - `docs/repo_mad.md`

### 2026-04-26 - Noticia single visual and badge controls

- Tuned `single-noticia.php` toward the supplied internal news reference:
  - light blue page background
  - text-left / image-right hero without card container
  - reduced typography scale and tighter title/excerpt rhythm
  - white body content card below hero
- Reworked internal news badges:
  - two editable badge slots per noticia
  - each slot supports text, icon image, and position (`top-left`, `top-right`, `bottom-left`, `bottom-right`)
  - legacy textarea badges remain as frontend fallback if new fields are empty
- Updated navigation active state so `Noticias` remains active on archive, category, and single noticia routes.
- Files updated:
  - `theme/single-noticia.php`
  - `theme/inc/acf-noticia.php`
  - `theme/inc/helpers.php`
  - `theme/functions.php`
  - `theme/assets/css/main.css`
  - `docs/repo_mad.md`

### 2026-04-26 - Noticias category listing card tuning

- Tuned the general `noticia_cat` template cards to match the supplied category reference:
  - smaller hero subtitle and tighter spacing above listing
  - white card with softer radius and shadow
  - left image ratio adjusted to reference
  - title, excerpt, and CTA sizes reduced
  - CTA text normalized to `Conoce más`
- Files updated:
  - `theme/taxonomy-noticia_cat.php`
  - `theme/assets/css/main.css`
  - `docs/repo_mad.md`

### 2026-04-26 - Noticias tab labels stacked

- Adjusted `/noticias/` card tabs so the light label line stacks above the bold label line.
- This fixes the visual order requested for:
  - `Nuevos` / `Lanzamientos`
  - `Activaciones` / `Venza`
  - `Repositorio` / `Sensorial`
- Files updated:
  - `theme/assets/css/main.css`
  - `docs/repo_mad.md`

### 2026-04-26 - Noticias home admin controls and tab typography

- Completed admin controls for each `/noticias/` landing card through `noticia_cat` fields:
  - tab line 1 (light) and tab line 2 (bold)
  - card title, summary, image, CTA text, and custom URL
- Updated the archive logic so card content prefers:
  - admin override first
  - latest post in the category second
  - visual fallback copy last
- Adjusted the Noticias card tab typography so the first line renders light and the second line bold.
- Files updated:
  - `theme/archive-noticia.php`
  - `theme/inc/acf-noticia.php`
  - `theme/inc/helpers.php`
  - `theme/assets/css/main.css`
  - `docs/repo_mad.md`

### 2026-04-26 - Noticias home layout aligned to reference

- Tuned `/noticias/` landing layout to match the supplied visual reference:
  - water-texture background applied behind the three cards
  - compact three-column card composition
  - purple top tabs, white framed cards, smaller copy, and blue CTA buttons
  - three-column layout preserved until mobile, without changing content or admin fields
- Files updated:
  - `theme/assets/css/main.css`
  - `docs/repo_mad.md`

### 2026-04-26 - Home product blocks full width

- Updated Home product blocks (`Linea Antibacterial` and `Linea Hidratacion Profunda`) to span 100% page width.
- Removed the Home products container max-width while preserving inner row padding and existing responsive behavior.
- Files updated:
  - `theme/assets/css/main.css`
  - `docs/repo_mad.md`

### 2026-04-26 - Home beneficios central image editable

- Added admin fields in the Home `Beneficios` tab:
  - `Home Beneficios - Imagen central`
  - `Home Beneficios - Texto alterno imagen central`
- Home beneficios template now renders the uploaded central image when present.
- Existing CSS soap visual remains as fallback when no image is selected.
- Files updated:
  - `theme/inc/acf-home.php`
  - `theme/template-parts/home/beneficios-strip.php`
  - `theme/assets/css/main.css`
  - `docs/repo_mad.md`

### 2026-04-26 - Home theme background toggle

- Added admin toggle `Home - Usar background del tema`.
- Behavior:
  - custom background image wins if selected
  - if no custom image and toggle is on, theme uses `backgroundhome.png`
  - if no custom image and toggle is off, home uses only the base color
- Files updated:
  - `theme/inc/acf-home.php`
  - `theme/front-page.php`
  - `docs/repo_mad.md`

### 2026-04-26 - Home global background editable from admin

- Added a new `General` tab to the Front Page ACF group.
- Home global background is now editable from admin:
  - `Home - Background general`
  - `Home - Color base del background`
- `front-page.php` now passes the selected background image/color as CSS variables on `<main class="home">`.
- CSS keeps `backgroundhome.png` as the fallback when admin fields are empty.
- Files updated:
  - `theme/inc/acf-home.php`
  - `theme/front-page.php`
  - `theme/assets/css/main.css`
  - `docs/repo_mad.md`

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
