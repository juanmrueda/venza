# Quiz de Tipo de Piel — Lógica de Recomendación

## Resumen del flujo
6 preguntas con opciones visuales → sistema de puntaje acumulado → jabón con mayor puntaje gana.

## Tabla de puntajes por respuesta

### Pregunta 1 — Tipo de piel
| Opción | Crema Humectante | Frescura Extrema | Vitamina E | Sábila | Coco | Avena |
|--------|:---:|:---:|:---:|:---:|:---:|:---:|
| Normal     | 0 | 0 | 0 | 0 | 1 | 2 |
| Grasa      | 0 | 2 | 0 | 1 | 0 | 0 |
| Combinada  | 0 | 1 | 2 | 0 | 0 | 0 |
| Seca       | 3 | 0 | 0 | 0 | 0 | 1 |

### Pregunta 2 — Color de cabello
| Opción | Crema Humectante | Frescura Extrema | Vitamina E | Sábila | Coco | Avena |
|--------|:---:|:---:|:---:|:---:|:---:|:---:|
| Rubio   | 1 | 0 | 1 | 0 | 0 | 0 |
| Negro   | 0 | 1 | 0 | 0 | 1 | 0 |
| Castaño | 0 | 0 | 0 | 1 | 0 | 1 |
| Canoso  | 2 | 0 | 0 | 0 | 0 | 1 |

### Pregunta 3 — Aroma favorito
| Opción | Crema Humectante | Frescura Extrema | Vitamina E | Sábila | Coco | Avena |
|--------|:---:|:---:|:---:|:---:|:---:|:---:|
| Herbal / Menta | 0 | 3 | 0 | 0 | 0 | 0 |
| Coco           | 0 | 0 | 0 | 0 | 3 | 0 |
| Cítrico        | 0 | 1 | 2 | 0 | 0 | 0 |
| Sábila         | 0 | 0 | 0 | 3 | 0 | 0 |
| Frutal         | 0 | 0 | 2 | 0 | 0 | 1 |
| Floral         | 2 | 0 | 0 | 0 | 0 | 1 |

### Pregunta 4 — Sensación post-baño
| Opción | Crema Humectante | Frescura Extrema | Vitamina E | Sábila | Coco | Avena |
|--------|:---:|:---:|:---:|:---:|:---:|:---:|
| Muy hidratada y protegida | 3 | 0 | 0 | 0 | 0 | 0 |
| Brillante y ligera        | 0 | 0 | 3 | 0 | 0 | 0 |
| Calmada y suavizada       | 0 | 0 | 0 | 1 | 0 | 3 |
| Fresca y revitalizada     | 0 | 3 | 0 | 0 | 0 | 0 |

### Pregunta 5 — Entorno natural
| Opción | Crema Humectante | Frescura Extrema | Vitamina E | Sábila | Coco | Avena |
|--------|:---:|:---:|:---:|:---:|:---:|:---:|
| Bosque   | 0 | 0 | 0 | 2 | 0 | 1 |
| Playa    | 0 | 1 | 0 | 0 | 2 | 0 |
| Jardín   | 2 | 0 | 0 | 0 | 0 | 1 |
| Montaña  | 0 | 2 | 1 | 0 | 0 | 0 |

### Pregunta 6 — Frecuencia de baño
| Opción | Crema Humectante | Frescura Extrema | Vitamina E | Sábila | Coco | Avena |
|--------|:---:|:---:|:---:|:---:|:---:|:---:|
| Más de 1 vez al día             | 0 | 2 | 0 | 0 | 0 | 1 |
| 1 vez al día                    | 1 | 0 | 1 | 0 | 0 | 0 |
| Poco más de una vez a la semana | 0 | 0 | 0 | 1 | 2 | 0 |
| Solo cuando puedo               | 1 | 0 | 0 | 0 | 0 | 2 |

---

## Puntaje máximo posible por producto
Sumando la opción de mayor puntaje en cada pregunta:

| Producto | Puntaje máximo teórico |
|----------|:---:|
| Crema Humectante | 3+2+2+3+2+1 = **13** |
| Frescura Extrema | 2+1+3+3+2+2 = **13** |
| Vitamina E       | 2+1+2+3+1+1 = **10** |
| Sábila           | 1+1+3+1+2+1 = **9**  |
| Coco             | 1+1+3+0+2+2 = **9**  |
| Avena            | 2+1+1+3+1+2 = **10** |

---

## Notas de ajuste
- Esta lógica fue definida inferida de los diseños y los textos del sitio.
- **Pendiente de revisión y aprobación del cliente.**
- Si hay empate, gana el que tiene mayor puntaje en Pregunta 1 (tipo de piel) y Pregunta 3 (aroma).
- Para ajustar la lógica, editar los objetos `puntos` en `theme/assets/js/quiz.js`.

---

## Imágenes necesarias para el Quiz
Carpeta destino: `theme/assets/images/quiz/`

| Archivo | Descripción |
|---------|-------------|
| `aroma-herbal.jpg` | Hierbas / menta / eucalipto |
| `aroma-coco.jpg` | Coco partido |
| `aroma-citrico.jpg` | Naranjas / limones |
| `aroma-sabila.jpg` | Planta de sábila / aloe |
| `aroma-frutal.jpg` | Frutas mixtas |
| `aroma-floral.jpg` | Flores |
| `entorno-bosque.jpg` | Bosque / naturaleza verde |
| `entorno-playa.jpg` | Playa / mar |
| `entorno-jardin.jpg` | Jardín / flores |
| `entorno-montana.jpg` | Montaña / nieve |
