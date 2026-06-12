# Design Extract — 4С-ГРУП РУСМОРПРОЕКТ — 2026-06-12

## Источник
- URL: `http://127.0.0.1:8765/4С-ГРУП РУСМОРПРОЕКТ (офлайн)(4).html`
- Файл: `4С-ГРУП РУСМОРПРОЕКТ (офлайн)(4).html`
- Скриншот: `4s-group-sample.jpg` (в корне проекта)

## Визуальное впечатление

Морская/индустриальная тема. Тёмный navy/teal хедер с фото корабля, очень крупные лёгкие заголовки (font-weight 300), яркий оранжевый CTA (#ff5101), pill-кнопки. Чередование секций: белые, светло-голубые (#f0f7f9), тёмно-navy (#0a3a48). Чистый, профессиональный дизайн для B2B морской компании.

---

## Извлечённые токены

### Цвета

| Роль | Извлечённый HEX | Текущая переменная | Текущее значение | Рекомендация |
|------|-----------------|-------------------|-----------------|--------------|
| Primary / CTA (оранжевый) | `#ff5101` | `$blue` → `$primary` | `#3f78e0` | **Заменить** `$blue: #ff5101` |
| Dark navy body text | `#0e2a33` | `$navy` | `#343f52` | **Заменить** `$navy: #0e2a33` |
| Dark navy bg (тёмные секции) | `#0a3a48` | — | — | Добавить в `$custom-colors` |
| Teal accent / links | `#1689a6` | `$aqua` | `#54a8c7` | **Заменить** `$aqua: #1689a6` |
| Deep teal (btn-dark) | `#0c5266` | — | — | Добавить в `$custom-colors` |
| Muted text / secondary | `#4c6770` | — | — | Добавить в `$custom-colors` |
| Body bg (белый) | `#ffffff` | `$body-bg` | `$white` | Оставить |
| Light section bg | `#f0f7f9` | — | — | Добавить в `$custom-colors` как `"light-sea"` |
| Input bg / light | `#f0f7f9` | `$input-bg` | `$body-bg` | **Заменить** |
| Border color | `#d8e7eb` | `$input-border-color` | `rgba($shadow-border, 0.07)` | **Заменить** |
| Accent light (heading highlight) | `#9fe3ef` | — | — | Только через кастомный CSS если нужно |

### Типографика

| Параметр | Извлечённое | Текущая переменная | Текущее значение | Рекомендация |
|----------|------------|-------------------|-----------------|--------------|
| Root font size | 16px | `$font-size-root` | 20px | **Изменить на 16px** |
| Body font size | 18px = 1.125rem | `$font-size-base` | 0.8rem (=16px) | **Изменить на 1.125rem** |
| Body font family | Manrope | `$font-family-sans-serif` | Manrope | Оставить ✓ |
| Body font weight | 400 | `$font-weight-normal` | 500 | **Изменить на 400** |
| Body line height | 1.65 | `$line-height-base` | 1.7 | **Изменить на 1.65** |
| Body color | `#0e2a33` | `$body-color` | зависит от `$navy` | Станет `#0e2a33` через `$navy` |
| **Headings font weight** | H1/H2: **300**, H3: 600, H4: 700 | `$headings-font-weight` | 700 | **Изменить на 300** для H1/H2, CSS override для H3/H4 |
| H1 size | 69.9px = **4.375rem** @16px | `$h1-font-size` | `$base * 1.25 * 1.45` ≈ 1.45rem | **Изменить на 4.375rem** |
| H1 weight | 300 | — | 700 | через `$headings-font-weight: 300` |
| H1 letter-spacing | -1.4px ≈ -0.02em | — | — | CSS override |
| H2 size | 45px = **2.813rem** @16px | `$h2-font-size` | `$base * 1.25 * 1.3` ≈ 1.3rem | **Изменить на 2.813rem** |
| H2 weight | 300 | — | 700 | через `$headings-font-weight` |
| H2 letter-spacing | -0.9px ≈ -0.02em | — | — | CSS override |
| H3 size | 21.2px = **1.328rem** @16px | `$h3-font-size` | `$base * 1.25 * 1.1` ≈ 1.1rem | **Изменить на 1.328rem** |
| H3 weight | 600 | — | 700→300 | CSS override: `h3 { font-weight: 600 }` |
| H4 size | 13px = **0.813rem** @16px | `$h4-font-size` | `$base * 1.25 * 0.95` | **Изменить на 0.813rem** |
| H4 weight | 700 | — | — | CSS override: `h4 { font-weight: 700 }` |
| H4 text-transform | UPPERCASE (label) | — | — | CSS override: `h4 { text-transform: uppercase; letter-spacing: 0.14em }` |

> **⚠️ ВАЖНО: изменение `$font-size-root` с 20px на 16px** — затронет ВСЕ rem-значения в теме. Это глобальное изменение. Все переопределения в `_user-variables.scss` пересчитаны для 16px root.

### Кнопки

| Параметр | Извлечённое | Текущая переменная | Текущее значение | Рекомендация |
|----------|------------|-------------------|-----------------|--------------|
| **Форма** | Pill / капсула (border-radius 999px) | `$btn-border-radius` | `$border-radius` (0.4rem) | **Заменить на 50rem** |
| Border width | 1px | `$btn-border-width` | 2px | **Изменить на 1px** |
| Font weight | 600 | `$btn-font-weight` | 700 | **Изменить на 600** |
| **Default** padding Y/X | 16px / 30px = 1rem / 1.875rem | `$btn-padding-y` / `$btn-padding-x` | 0.5rem / 1.2rem | **Изменить** |
| Default font size | 16px = 1rem | `$btn-font-size` | `$input-btn-font-size` | **Изменить на 1rem** |
| **SM** padding Y/X | 8px / 13px = 0.5rem / 0.813rem | `$btn-padding-y-sm` / `$btn-padding-x-sm` | 0.4rem / 1rem | **Изменить** |
| SM font size | 13px = 0.813rem | `$btn-font-size-sm` | 0.75rem | **Изменить** |
| Text transform | none | — | — | Оставить |
| Box shadow (primary) | `rgba(255,81,1,0.5) 0 14px 30px -12px` | — | — | CSS override `.btn-primary` |

### Формы (inputs)

| Параметр | Извлечённое | Текущая переменная | Текущее значение | Рекомендация |
|----------|------------|-------------------|-----------------|--------------|
| **Height** | 50px | `$form-floating-height` | `add(2.5rem, border)` | **Задать `50px`** |
| Font size | 16px = 1rem | `$input-font-size` | 0.75rem | **Изменить на 1rem** |
| Font weight | 400 | `$input-font-weight` | — | **Задать 400** |
| Color | `#0e2a33` | `$input-color` | body-color | Станет правильным через `$navy` |
| Background | `#f0f7f9` | `$input-bg` | `$body-bg` (белый) | **Изменить на `#f0f7f9`** |
| Border color | `#d8e7eb` | `$input-border-color` | `rgba($shadow-border, 0.07)` | **Изменить на `#d8e7eb`** |
| Border width | 1px | — | 1px | Совпадает ✓ |
| Border radius | ~5px = 0.313rem | `$input-border-radius` | `$border-radius` | Через `$border-radius: 0.313rem` |
| Padding Y | 13px = 0.813rem | `$input-padding-y` | 0.6rem | **Изменить на 0.813rem** |
| Padding X | 15px = 0.938rem | `$input-padding-x` | 1rem | **Изменить на 0.938rem** |
| **Focus: bg** | `#f0f7f9` | `$input-focus-bg` | — | = `$input-bg`, задать явно |
| **Focus: border** | `#d8e7eb` | `$input-focus-border-color` | `$focus-border` | **= `$input-border-color`** |
| **Focus: box-shadow** | нет (transparent) | `$input-focus-box-shadow` | `unset` | **Задать `none`** |

> **Расчёт form-floating-height:** 50px = 3.125rem при 16px root. С учётом 2px border: `calc(3.125rem + 2px)`.

### Breadcrumb

На странице-образце breadcrumb не найден. Оставить дефолты темы.

### Навигация (горизонтальное меню)

| Параметр | Извлечённое | Текущая переменная | Текущее значение | Рекомендация |
|----------|------------|-------------------|-----------------|--------------|
| Font size | 15px = **0.938rem** @16px | `$nav-link-font-size` | 0.8rem | **Изменить на 0.938rem** |
| Font weight | 500 | `$nav-link-font-weight` | `$font-weight-bold` (700) | **Изменить на 500** |
| Text transform | none | `$nav-link-text-transform` | none | Совпадает ✓ |
| Letter spacing | normal | `$nav-link-letter-spacing` | `$letter-spacing` | Совпадает ✓ |
| Color (header dark) | `#ffffff` | `$nav-link-color` | `$main-dark` | Задаётся через header тему |

### Табы / Аккордеон

На странице-образце не найдены. Оставить дефолты темы.

### Шрифты

Шрифт **Manrope** уже есть в теме. Подключение не требуется.

---

## Предлагаемый `_user-variables.scss`

```scss
//--------------------------------------------------------------
// User Variables — 4s-group
// Извлечено из: 4С-ГРУП РУСМОРПРОЕКТ — морской вариант
// Дата: 2026-06-12
//--------------------------------------------------------------

// ── Кастомные цвета ──
$custom-colors: (
  "teal":      #1689a6,   // teal accent, links
  "navy-dark": #0a3a48,   // dark section backgrounds
  "navy-deep": #0c5266,   // deeper teal-navy
  "muted":     #4c6770,   // secondary/muted text
  "light-sea": #f0f7f9,   // light section backgrounds
);
$custom-theme-colors: $custom-colors;

// ── Основные цвета ──
$blue:  #ff5101;   // (было: #3f78e0) — оранжевый CTA → $primary
$navy:  #0e2a33;   // (было: #343f52) — очень тёмный navy
$aqua:  #1689a6;   // (было: #54a8c7) — бирюзовый акцент

$body-bg:    #ffffff;
$body-color: #0e2a33;   // (задаём явно, чтобы не зависеть от $navy)

// Глобальное скругление — небольшое (для карточек, инпутов)
$border-radius:    0.313rem;   // (было: 0.4rem) — ~5px при 16px root
$border-radius-sm: 0.188rem;
$border-radius-lg: 0.313rem;

// ── Типографика ──
$font-size-root:    16px;       // (было: 20px) — ВАЖНО: меняет всю rem-шкалу
$font-size-base:    1.125rem;   // (было: 0.8rem) — 18px при 16px root
$font-weight-normal: 400;       // (было: 500)
$line-height-base:  1.65;       // (было: 1.7)

// Заголовки — ЛЁГКИЕ (ключевая черта дизайна)
$headings-font-weight: 300;    // (было: 700) — H1/H2 используют 300

$h1-font-size: 4.375rem;       // (было: ~1.45rem) — 70px
$h2-font-size: 2.813rem;       // (было: ~1.3rem)  — 45px
$h3-font-size: 1.328rem;       // (было: ~1.1rem)  — 21px
$h4-font-size: 0.813rem;       // (было: ~0.95rem) — 13px (uppercase label)

// ── Кнопки ──
$btn-border-width:    1px;     // (было: 2px)
$btn-font-weight:     600;     // (было: 700)
$btn-border-radius:   50rem;   // (было: $border-radius) — pill форма
$btn-border-radius-sm: 50rem;
$btn-border-radius-lg: 50rem;

// Default (основная CTA кнопка)
$btn-padding-y:   1rem;        // (было: 0.5rem) — 16px
$btn-padding-x:   1.875rem;    // (было: 1.2rem) — 30px
$btn-font-size:   1rem;        // 16px

// Small
$btn-padding-y-sm: 0.5rem;     // (было: 0.4rem)
$btn-padding-x-sm: 0.813rem;   // (было: 1rem)
$btn-font-size-sm: 0.813rem;   // 13px

// ── Формы ──
$input-font-size:         1rem;        // (было: 0.75rem) — 16px
$input-font-weight:       400;
$input-bg:                #f0f7f9;    // (было: $body-bg) — светло-голубой
$input-color:             #0e2a33;
$input-border-color:      #d8e7eb;    // (было: rgba($shadow-border, 0.07))
$input-border-radius:     0.313rem;   // ~5px
$input-padding-y:         0.813rem;   // (было: 0.6rem) — 13px
$input-padding-x:         0.938rem;   // (было: 1rem) — 15px
$input-focus-bg:          #f0f7f9;   // без изменений при фокусе
$input-focus-border-color: #d8e7eb;  // без изменений при фокусе
$input-focus-box-shadow:  none;       // (было: unset)
$form-floating-height:    calc(3.125rem + 2px);   // 50px + 2px border

// ── Навигация ──
$nav-link-font-size:    0.938rem;   // (было: 0.8rem) — 15px
$nav-link-font-weight:  500;        // (было: 700)

//--------------------------------------------------------------
// CSS overrides
//--------------------------------------------------------------

// H3 и H4 — отличаются от $headings-font-weight: 300
h3, .h3 {
  font-weight: 600;
  letter-spacing: -0.01em;
}
h4, .h4 {
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.14em;
}
// H1/H2 — отрицательный letter-spacing (сжатые заголовки)
h1, .h1, h2, .h2 {
  letter-spacing: -0.02em;
}

// btn-primary — оранжевая тень (brand effect)
.btn-primary {
  box-shadow: rgba(255, 81, 1, 0.5) 0px 14px 30px -12px;
}
.btn-primary:hover {
  box-shadow: rgba(255, 81, 1, 0.35) 0px 8px 20px -10px;
}

//--------------------------------------------------------------
// Импорт шрифтов
//--------------------------------------------------------------
//START IMPORT FONTS
// Manrope уже подключён в теме — @import не нужен
//END IMPORT FONTS
```

---

## Открытые вопросы

1. **`$font-size-root: 16px`** — глобальное изменение с 20px. Все существующие rem-значения в родительской теме пересчитаются. Нужно проверить результат сборки.
2. **`$headings-font-weight: 300`** — очень лёгкие заголовки. Если на каких-то страницах нужны жирные заголовки — добавить точечный CSS-override.
3. **Кастомные цвета** (`$custom-colors`) — добавляют utility-классы `.bg-navy-dark`, `.text-teal`, `.btn-light-sea` и т.д. Использовать в шаблонах для оформления секций.
