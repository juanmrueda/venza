# Repo MAD - Venza

Last updated: 2026-04-30
Current phase: Descubre Venza dynamic videos deployed

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

Current task: **Descubre Venza dynamic videos**.

When touching Product internals, prioritize only these files unless required:

- `theme/single-producto.php`
- `theme/template-parts/producto/single-frescura-extrema.php`
- `theme/template-parts/producto/*`
- `theme/inc/acf-producto-home.php`
- `theme/assets/css/main.css`

Previous focus retained for Blog/Descubre work:

**Blog + Descubre Venza separation**.

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

### 2026-04-30 - Production deploy for Descubre Venza dynamic videos

- Deployed the unlimited dynamic Descubre Venza video carousel editor to production.
- Verified PHP syntax for the modified Descubre ACF and page template before deploy.
- Verified the Descubre Venza page responds successfully after deploy.

### 2026-04-30 - Descubre Venza dynamic videos

- Converted the Descubre Venza video carousel from a fixed 6-card setup to an unlimited dynamic admin metabox.
- Added `Descubre Venza - Videos dinamicos` with add/remove/reorder controls, poster, local video file, title, URL, meta, duration, and show/hide toggle.
- New videos are inserted at the top of the list automatically so previous videos move down.
- The frontend reads the dynamic list and falls back to the legacy 6 ACF video cards until the dynamic metabox is saved.
- Files updated:
  - `theme/inc/acf-page-descubre.php`
  - `theme/page-descubre-venza.php`
  - `docs/repo_mad.md`

### 2026-04-30 - Production deploy for Descubre Venza video card playback

- Deployed the Descubre Venza lower video card playback fix to production.
- Verified the modified page template passes PHP syntax checks before production pull.
- Verified the Descubre Venza page responds successfully after deploy.

### 2026-04-30 - Descubre Venza video card playback

- Fixed Descubre Venza lower video cards so YouTube links and local video files can load into the main featured video area.
- Added robust YouTube URL parsing for watch, short, live, embed, and youtu.be formats.
- Added active-card styling for the selected video card.
- Files updated:
  - `theme/page-descubre-venza.php`
  - `theme/assets/js/main.js`
  - `theme/assets/css/main.css`
  - `docs/repo_mad.md`

### 2026-04-30 - Production deploy for blog optional editable closing

- Deployed the optional editable blog closing section to production.
- Verified PHP syntax for the modified blog ACF and single templates before pulling production.
- Verified production blog URLs respond successfully after deploy.

### 2026-04-30 - Blog optional editable closing

- Added an optional per-post blog closing section.
- Editors can enable the closing only on selected blog posts and edit the closing text from admin.
- The closing renders after the dynamic editorial blocks when enabled and text is present.
- Files updated:
  - `theme/inc/acf-blog.php`
  - `theme/single.php`
  - `theme/assets/css/main.css`
  - `docs/repo_mad.md`

### 2026-04-30 - Production theme editor write permissions

- Fixed WordPress Theme File Editor save error by making the deployed theme files writable by the PHP-FPM user `www-data`.
- Applied `www-data:www-data` ownership and group-writable permissions to `/var/repo/venza/theme`.
- Added a production `.git/hooks/post-merge` hook so future `git pull` deploys reapply theme ownership and permissions.
- Verified `www-data` can write `theme/functions.php`, `theme/assets/css/main.css`, and create files inside the theme directory.
- Verified the public site still responds successfully after the permission change.

### 2026-04-29 - Production deploy for blog mobile editorial spacing

- Deployed the Blog type 1 mobile spacing adjustment to production.
- Verified the production blog and the affected internal blog URL respond successfully.

### 2026-04-28 - Blog mobile editorial block spacing

- Adjusted Blog type 1 mobile editorial grid so image/text cells render as separated stacked cards instead of a continuous strip.
- Added mobile spacing, side padding, rounded corners, and tighter text sizing for the blog internal block section.
- Files updated:
  - `theme/assets/css/main.css`
  - `docs/repo_mad.md`

### 2026-04-28 - Production deploy for blog dynamic editorial blocks

- Deployed the dynamic Blog type 1 editorial block editor to production.
- Production now supports adding, removing, and reordering image/text blocks per blog post from the WordPress admin.

### 2026-04-28 - Blog dynamic editorial blocks

- Converted the Blog type 1 internal editorial grid from fixed 4 hardcoded block pairs to dynamic admin-managed blocks.
- Added a custom post metabox, `Blog - Bloques dinamicos`, where editors can add, remove, reorder, and choose each block as image or text.
- Text blocks support editable copy, light/blue background style, optional overlay image, and overlay position.
- Existing fixed ACF block values remain available as a fallback until a post is saved with the new dynamic block editor.
- Files updated:
  - `theme/inc/acf-blog.php`
  - `theme/single.php`
  - `docs/repo_mad.md`

### 2026-04-28 - Production deploy for product archive availability flags

- Deployed the `/productos/` availability row sizing adjustment to production.
- Verified production `/productos/` responds successfully after deploy.

### 2026-04-28 - Product archive availability flags aligned

- Matched the `/productos/` availability row typography to product internal pages.
- The `Disponible en:` label and flag emojis now use the same paragraph font scale, line-height, and weight treatment as `.producto-single`.
- Files updated:
  - `theme/assets/css/main.css`
  - `docs/repo_mad.md`

### 2026-04-28 - Production deploy for product archive banner size

- Deployed the `/productos/` banner sizing adjustment to production.
- Verified production `/productos/` responds successfully after deploy.

### 2026-04-28 - Product archive banner size aligned

- Matched the `/productos/` home banner sizing to product internal banners.
- Applied the same `1922 / 815` aspect ratio and `object-fit: cover` used by internal product heroes.
- Files updated:
  - `theme/assets/css/main.css`
  - `docs/repo_mad.md`

### 2026-04-28 - Footer mobile products link fix

- Scoped the mobile submenu click handler to the header navigation only.
- This lets the `Productos` item in the footer keep its normal link behavior on mobile and redirect to `/productos/`.
- Files updated:
  - `theme/assets/js/main.js`
  - `docs/repo_mad.md`

### 2026-04-28 - Quiz result card pixel adjustment

- Tuned the Quiz result card toward the supplied reference:
  - full-width visual result card with 1626/780 aspect ratio on desktop
  - large rounded corners and left-side mint overlay
  - white copy panel with matching desktop offset, size, radius, and typography scale
  - tablet/mobile fallbacks to prevent text clipping or horizontal overflow
- Added editable result URLs in `Pagina - Descubre Venza`:
  - global `Ver todos los productos` URL
  - per-product `Conoce mas` URL
- Confirmed existing editable result fields remain wired:
  - result image per product
  - result title per product
  - result description per product
  - result button texts
- Local checks:
  - `node --check theme/assets/js/quiz.js`
  - Playwright fixture at 390, 768, 1024, and 1776px confirmed no horizontal overflow and no clipped copy panel.
- Files updated:
  - `theme/assets/css/main.css`
  - `theme/assets/js/quiz.js`
  - `theme/page-quiz.php`
  - `theme/inc/acf-page-descubre.php`
  - `docs/repo_mad.md`

### 2026-04-28 - Quiz heavy background removed

- Removed `backgroundhome.png` from the Quiz page background for a lighter load.
- Kept the Quiz page on a flat `#eef4ff` background so the layout stays visually aligned without the heavy image asset.
- Files updated:
  - `theme/assets/css/main.css`
  - `docs/repo_mad.md`

### 2026-04-28 - Production deploy for responsive quiz block

- Committed and pushed responsive/quiz/mobile-products-nav changes to `main`.
- Pulled the latest `main` on the production server at `/var/repo/venza`.
- Server-side PHP lint passed for:
  - `theme/page-quiz.php`
  - `theme/inc/acf-page-descubre.php`
  - `theme/functions.php`
- Verified `https://venza.ipalmera.com/descubre-venza/quiz/` responds with HTTP 200.

### 2026-04-28 - Quiz graphic/admin adjustments and mobile products nav

- Updated Quiz page hero to match the provided reference more closely:
  - large centered title
  - bordered intro text box below the title
  - water-style background using the existing theme background asset
- Added editable Quiz text controls to `Pagina - Descubre Venza` admin:
  - main title and intro
  - progress label
  - back/next/result/action/restart button labels
  - every question title
  - every option label
  - result title and description per product recommendation
- Updated Quiz frontend config so `page-quiz.php` sends those admin texts to `quiz.js`.
- Updated visual quiz option layout:
  - image-based questions render in 3 columns
  - mobile keeps compact 3-column visual cards to avoid the old 2/2/1 layout
- Reworked Quiz result layout to match the supplied direction:
  - large rounded visual result card
  - white text panel over the product/result image
  - `Conoce mas` and `Ver todos los productos` aligned together
  - `Intentar de nuevo` below the two primary actions
- Fixed mobile Products navigation by adding a visible mobile submenu link:
  - `Ver todos los productos`
  - keeps parent `Productos` tap behavior for expanding the submenu
  - provides direct access to `/productos/` from the mobile menu
- Local checks:
  - `node --check theme/assets/js/quiz.js`
  - `node --check theme/assets/js/main.js`
  - `git diff --check`
  - Playwright fixture confirmed 3-column image grid, result render, and mobile products overview link.
- PHP CLI was not available locally on this Windows environment, so PHP lint could not be run.
- Files updated:
  - `theme/page-quiz.php`
  - `theme/assets/js/quiz.js`
  - `theme/assets/js/main.js`
  - `theme/assets/css/main.css`
  - `theme/inc/acf-page-descubre.php`
  - `theme/functions.php`
  - `docs/repo_mad.md`

### 2026-04-28 - Responsive QA local pass

- Ran a local responsive fixture against the real theme CSS at 390, 768, 1024, and 1366px.
- Confirmed no horizontal overflow after adjustments across the tested breakpoints.
- Fixed the tablet header breakpoint so navigation switches to the hamburger layout at 1100px and below, preventing the desktop menu/social area from crowding around 1024px.
- Synced mobile submenu JavaScript with the new 1100px breakpoint so product dropdowns work correctly on tablet navigation.
- Added final responsive hardening for:
  - accidental page-level horizontal overflow
  - mobile hero media height
  - Descubre Venza floating quiz bottom spacing
  - quiz button stacking on narrow screens
- Files updated:
  - `theme/assets/css/main.css`
  - `theme/assets/js/main.js`
  - `docs/repo_mad.md`

### 2026-04-27 - Header/footer social links connected

- Wired the global social links component used by both header and footer to Venza official URLs.
- Added safe fallback behavior so if WP options are empty, links still point to:
  - Facebook: `https://www.facebook.com/jabonvenza/`
  - Instagram: `https://www.instagram.com/jabonvenza/`
  - YouTube: `https://www.youtube.com/@jabonvenza`
- File updated:
  - `theme/template-parts/global/social-links.php`

### 2026-04-27 - Header social icons matched to footer icons

- Updated header social icon styling to match footer icon presentation exactly:
  - 36x36 circular navy background
  - 18x18 white icon treatment (invert filter)
  - same hover offset behavior
- File updated:
  - `theme/assets/css/main.css`

### 2026-04-27 - Product hero claim supports manual line breaks

- Updated product admin field `Hero interno - Texto destacado` to a 2-row textarea so product claims can be entered on two lines.
- Updated the product internal hero template to render admin line breaks as visible line breaks.
- Removed forced single-line rendering from the product hero claim and added a max-width guard so long claims stay on the right side of the banner instead of overlapping the product pack.
- Files updated:
  - `theme/inc/acf-producto-home.php`
  - `theme/template-parts/producto/single-frescura-extrema.php`
  - `theme/assets/css/main.css`

### 2026-04-27 - Contact page scale and option lists adjusted

- Reduced the visual scale of the Contact page to avoid oversized typography and form fields:
  - smaller hero title
  - smaller form card
  - reduced form title/note sizes
  - reduced label, input, select, textarea, and button sizes
  - added mobile width override so the form remains usable on small screens
- Updated Contact defaults for country select:
  - Honduras
  - Guatemala
  - Costa Rica
  - El Salvador
  - Nicaragua
  - Republica Dominicana
- Updated Contact defaults for reason select:
  - Soy Cliente
  - Quiero Ser Cliente
  - Exportaciones
  - Quiero Ser Proveedor
  - Soy Periodista o Medio
  - Invitaciones, Donaciones, Otros
- Files updated:
  - `theme/inc/acf-page-contacto.php`
  - `theme/page-contacto.php`
  - `theme/assets/css/main.css`
  - `docs/repo_mad.md`

### 2026-04-27 - Contact page visual/admin implementation

- Rebuilt `page-contacto.php` based on `Assets/Venza WB_Pagina_17.jpg`.
- Kept the approved composition:
  - centered `CONTACTO / venza` hero
  - large rounded white form card
  - country and reason selectors
  - personal data fields
- Avoided the heavy aqueous background image by default.
- Added editable contact background color through ACF:
  - `Background - Color`
- Added editable contact page copy:
  - hero top text
  - hero brand text
  - form title
  - form note
  - countries list
  - reasons list
- Prepared future email sending through an editable `Formulario - Shortcode` field for Contact Form 7.
- Current fallback form is visual/static and does not send email until the shortcode is configured.
- Disabled Gutenberg for the contact page template to keep ACF editing stable.
- Files updated:
  - `theme/page-contacto.php`
  - `theme/inc/acf-page-contacto.php`
  - `theme/functions.php`
  - `theme/assets/css/main.css`
  - `docs/repo_mad.md`

### 2026-04-27 - Quiz images editable from Descubre Venza admin

- Added editable quiz image controls inside `Pagina - Descubre Venza`:
  - question 1: skin type option images
  - question 2: hair color option images
  - question 3: aroma option images
  - question 5: landscape option images
  - result image override per recommended product
- Updated `page-quiz.php` to read those image fields from the `Descubre Venza` page and expose them to `quiz.js`.
- Added `venza_get_descubre_page_id()` so the virtual route `/descubre-venza/quiz/` can still use the editable fields from the real Descubre page.
- Updated `quiz.js`:
  - uses admin-uploaded option images when available
  - avoids broken images if a field is empty
  - supports result image overrides per product
  - aligns quiz option labels closer to the supplied quiz reference
  - fixes scoring recalculation when users go back and change answers
- Tuned quiz option CSS so uploaded images display as visual cards with overlay labels.
- Files updated:
  - `theme/inc/acf-page-descubre.php`
  - `theme/page-quiz.php`
  - `theme/assets/js/quiz.js`
  - `theme/assets/css/main.css`
  - `theme/functions.php`
  - `docs/repo_mad.md`

### 2026-04-26 - Descubre Venza floating quiz entry

- Added a floating quiz entry CTA to `Descubre Venza`.
- CTA behavior:
  - desktop: fixed card on the right side of the page
  - mobile: bottom pill so it does not block the content flow
  - default text: `¿Ya sabes cuál jabón va contigo?`
  - default icon: theme product image `frescura-extrema.png`
- Added admin controls in `Pagina - Descubre Venza`:
  - `Quiz flotante - Mostrar`
  - `Quiz flotante - Icono / jabon`
  - `Quiz flotante - Texto`
  - `Quiz flotante - URL`
- Added route support for `/descubre-venza/quiz/` so the CTA can open the quiz template as a Descubre Venza child experience.
- Updated navigation active state so `Descubre Venza` remains active on the quiz route.
- Files updated:
  - `theme/page-descubre-venza.php`
  - `theme/inc/acf-page-descubre.php`
  - `theme/functions.php`
  - `theme/assets/css/main.css`
  - `docs/repo_mad.md`

### 2026-04-26 - Descubre Venza optional exclusive background

- Re-enabled optional background support only for `Descubre Venza`.
- Default state remains no background image.
- If editors activate `Hero - Usar background superior` and upload `Hero - Background superior`, the selected image renders only on `page-descubre-venza.php`.
- Files updated:
  - `theme/assets/css/main.css`
  - `docs/repo_mad.md`

### 2026-04-26 - Descubre Venza background removed

- Removed the water-texture/background image from `Descubre Venza`.
- The video template now uses a flat light-blue background for better performance and cleaner visual QA.
- File updated:
  - `theme/assets/css/main.css`
  - `docs/repo_mad.md`

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
