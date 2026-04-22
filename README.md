# Venza — Sitio Web Corporativo
**Cliente:** Venza / Dinant  
**URL Demo:** venza.ipalmera.com  
**Deadline:** Martes 28 de abril, 2026  
**Stack:** WordPress 6.x + Tema Custom (sin page builder)

---

## Mapa del sitio

| Página | URL | Template WP | Descripción |
|--------|-----|-------------|-------------|
| Home | `/` | `front-page.php` | Hero, Productos destacados, Beneficios, Galería |
| Productos (archivo) | `/productos/` | `archive-producto.php` | Grid de todos los productos |
| Producto — Crema Humectante | `/productos/crema-humectante/` | `single-producto.php` | Hero, beneficios, tamaños, más productos |
| Producto — Frescura Extrema | `/productos/frescura-extrema/` | `single-producto.php` | ídem |
| Producto — Vitamina E | `/productos/vitamina-e/` | `single-producto.php` | ídem |
| Producto — Sábila | `/productos/sabila/` | `single-producto.php` | ídem |
| Producto — Coco | `/productos/coco/` | `single-producto.php` | ídem |
| Producto — Avena | `/productos/avena/` | `single-producto.php` | ídem |
| Beneficios | `/beneficios/` | `page-beneficios.php` | Página editorial de beneficios |
| Noticias (archivo) | `/noticias/` | `archive-noticia.php` | 3 categorías: Lanzamientos, Activaciones, Repositorio |
| Noticias — Categoría | `/noticias/categoria/lanzamientos/` | `taxonomy-noticia_cat.php` | Listado filtrado |
| Noticia individual | `/noticias/nombre-noticia/` | `single-noticia.php` | Artículo con imágenes |
| Blog (archivo) | `/blog/` | `home.php` | Posts lifestyle |
| Blog individual | `/blog/nombre-post/` | `single.php` | Artículo con fotos intercaladas |
| Descubre Venza | `/descubre-venza/` | `page-descubre-venza.php` | Video hero + carrusel YouTube |
| Quiz de piel | `/descubre-venza/quiz/` | `page-quiz.php` | Semi-app: 6 preguntas → recomendación |
| Contacto | `/contacto/` | `page-contacto.php` | Formulario de contacto |

**Navegación principal:**  
`Inicio` / `Productos ▾` / `Beneficios` / `Noticias` / `Blog` / `Descubre Venza` / `Contacto`

---

## Stack técnico

```
WordPress 6.x (latest)
├── PHP 8.2+
├── MySQL 8.0+
├── Nginx (servidor)
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
    ├── producto (con taxonomía: linea_producto)
    └── noticia (con taxonomía: noticia_cat)
```

---

## Estructura de carpetas

```
/wp-content/themes/venza/         ← Todo esto vive en este repo (carpeta /theme)
├── style.css                     ← Header del tema (nombre, versión)
├── functions.php                 ← Bootstrap del tema
├── index.php                     ← Fallback
├── front-page.php                ← Home
├── header.php
├── footer.php
├── page.php                      ← Página genérica
├── single.php                    ← Blog individual
├── home.php                      ← Blog archivo (listado)
├── 404.php
│
├── single-producto.php           ← Template único para los 6 productos
├── archive-producto.php          ← Grid de productos
├── single-noticia.php
├── archive-noticia.php
├── taxonomy-noticia_cat.php      ← Noticias por categoría
│
├── page-beneficios.php           ← Slug: beneficios
├── page-descubre-venza.php       ← Slug: descubre-venza
├── page-quiz.php                 ← Slug: quiz
├── page-contacto.php             ← Slug: contacto
│
├── assets/
│   ├── css/
│   │   └── main.css              ← Un solo CSS compilado (sin preprocessor)
│   ├── js/
│   │   ├── main.js               ← JS global (nav, sliders, etc.)
│   │   └── quiz.js               ← Lógica del quiz de piel (autocontenido)
│   └── images/                   ← Solo assets estáticos del tema (logo, iconos SVG)
│
├── inc/
│   ├── cpt.php                   ← Registro Custom Post Types y taxonomías
│   ├── acf-fields.php            ← Exportación JSON de campos ACF
│   └── helpers.php               ← Funciones reutilizables
│
└── template-parts/
    ├── global/
    │   ├── nav.php
    │   └── social-links.php
    ├── home/
    │   ├── hero.php
    │   ├── productos-destacados.php
    │   ├── beneficios-strip.php
    │   └── galeria-hoy.php
    ├── producto/
    │   ├── hero.php
    │   ├── beneficios-pills.php
    │   ├── tamanos.php
    │   └── mas-productos.php
    ├── noticias/
    │   ├── card.php
    │   └── categorias-tabs.php
    └── quiz/
        ├── step-1-piel.php
        ├── step-2-cabello.php
        ├── step-3-aroma.php
        ├── step-4-sensacion.php
        ├── step-5-entorno.php
        ├── step-6-frecuencia.php
        └── resultado.php
```

---

## Paleta de colores (a confirmar con brand guide)

```css
--color-navy:        #1B1464;   /* Azul marino oscuro — titulos, nav */
--color-blue-mid:    #3B82C4;   /* Azul medio — acentos */
--color-blue-light:  #E8F4FD;   /* Azul muy claro — fondos de sección */
--color-blue-btn:    #5BB8E8;   /* Azul botones */
--color-white:       #FFFFFF;
--color-text:        #1B1464;   /* Mismo navy para cuerpo de texto */
```

> ⚠️ Confirmar con brand guide oficial cuando el cliente lo entregue.

## Tipografía (a confirmar)

| Uso | Fuente provisional | Peso |
|-----|--------------------|------|
| Títulos display grandes | Playfair Display (serif) | 700, 900 |
| Subtítulos / UI | Nunito (sans-serif) | 400, 600, 700 |
| Cuerpo | Nunito | 400 |

> ⚠️ Reemplazar con fuentes oficiales del cliente cuando las entregue.

---

## Quiz de tipo de piel — Lógica

Ver: [`docs/quiz-logic.md`](docs/quiz-logic.md)

**6 preguntas:**
1. ¿Cuál es tu tipo de piel? (Normal / Grasa / Combinada / Seca)
2. Color de cabello (Rubio / Negro / Castaño / Canoso)
3. Aroma favorito (Herbal/Menta / Coco / Cítrico / Sábila / Frutal / Floral)
4. Sensación post-baño (Muy hidratada / Brillante y ligera / Calmada / Fresca)
5. Entorno natural que relaja (imagen de paisaje)
6. Frecuencia de baño (Más de 1x día / 1x día / Poco más de 1x / Solo cuando puedo)

**Resultado → 1 de 6 jabones:**
Crema Humectante / Frescura Extrema / Vitamina E / Sábila / Coco / Avena

Implementación: Vanilla JS puro. Sistema de puntaje por respuesta. Sin backend. Sin cookies obligatorias.

---

## Assets pendientes del cliente

### Urgente (bloquean el inicio)
- [ ] Logo Venza — SVG + PNG transparente
- [ ] Nombre oficial de las fuentes (o archivos si tienen licencia)
- [ ] Paleta de colores oficial (brand guide o valores hex)

### Esta semana
- [ ] Fotos de 6 productos — PNG fondo transparente, alta res
- [ ] Fotos hero/lifestyle de cada producto (fondos de banners)
- [ ] Fotos de la sección "Beneficios" (página 08)
- [ ] Textos reales de cada producto (no Lorem Ipsum)
- [ ] Links a tiendas externas por producto y país
- [ ] URL del canal YouTube de Venza
- [ ] Email destino del formulario de contacto
- [ ] Tabla de lógica del Quiz (qué respuestas → qué jabón)
- [ ] Fotos/imágenes para el Quiz (swatches de piel, cabello, aromas, entornos)
- [ ] Artículos reales de Noticias y Blog (o placeholders aprobados)

---

## Servidor — Digital Ocean

**Droplet recomendado:**
- **Plan:** Basic — $12/mes (2 vCPU, 2GB RAM, 50GB SSD, 2TB transfer)
- **SO:** Ubuntu 22.04 LTS
- **Stack:** Nginx + PHP 8.2 + MySQL 8.0 + SSL (Let's Encrypt)
- **Región:** más cercana al cliente (NYC o SF si es Centroamérica)

**DNS:**
```
venza.ipalmera.com  →  A record  →  [IP del Droplet]
```

**Usuario SSH de deploy:**
```
usuario: deploy
acceso: solo al directorio del tema
método: clave SSH ED25519 dedicada a este proyecto
```

Ver instrucciones completas en: [`deploy/server-setup.sh`](deploy/server-setup.sh)

---

## Workflow de desarrollo

```
Local (c:/dev/Venza)
    │
    ├── git add + git commit
    │
    └── git push origin main
                │
                └── SSH → servidor
                        └── git pull (en /wp-content/themes/venza/)
```

**Comandos de deploy:**
```bash
# Desde local, un solo comando:
bash deploy/deploy.sh
```

---

## Plugins — instalación manual en WP admin

| Plugin | Versión | Propósito | Costo |
|--------|---------|-----------|-------|
| Advanced Custom Fields | Latest free | Campos de productos y noticias | Gratis |
| Contact Form 7 | Latest | Formulario de contacto | Gratis |
| Yoast SEO | Latest free | SEO básico, sitemaps | Gratis |
| Smush (opcional) | Latest free | Compresión de imágenes | Gratis |

---

## Timeline

| Día | Fecha | Entregable |
|-----|-------|------------|
| 1 | Mié 22 Abr | Setup servidor + tema base + header/footer + Home |
| 2 | Jue 23 Abr | Template producto (×6) + Beneficios |
| 3 | Vie 24 Abr | Noticias (listado + categoría + individual) + Blog |
| 4 | Sáb 25 Abr | Descubre Venza + Quiz completo |
| 5 | Dom 26 Abr | Contacto + responsive todo el sitio |
| 6 | Lun 27 Abr | Carga de contenido real + QA + fixes |
| 7 | Mar 28 Abr | Deploy / revisión final con cliente |

---

## Comandos útiles

```bash
# Conectar al servidor
ssh deploy@venza.ipalmera.com -i ~/.ssh/venza_deploy

# Deploy rápido
bash deploy/deploy.sh

# Ver logs del servidor
ssh deploy@venza.ipalmera.com "sudo tail -f /var/log/nginx/error.log"
```

---

## Contacto del proyecto
- **Desarrollador:** juan.rueda@ipalmera.com
- **Asistido por:** Claude Code (Anthropic)
