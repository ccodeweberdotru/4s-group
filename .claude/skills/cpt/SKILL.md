---
name: cpt
description: Создать новый Custom Post Type в дочерней теме CodeWeber — по всем паттернам темы
argument-hint: "название CPT, например: Portfolio или portfolio"
---

Создай новый Custom Post Type в этой дочерней теме CodeWeber: `$ARGUMENTS`

> **Правило языка:** весь код, labels, slug-и, meta keys — только на **английском**.
> Русский — только в `languages/ru_RU.po`.

Прочитай `.claude/RULES.md` и `../PARENT_SLUG/doc_claude/development/CODING_STANDARDS.md`.

> Где `PARENT_SLUG` — значение строки `Template:` из `./style.css`.

---

## Шаг 1: Коммит текущего состояния

Запусти `git status`. Если есть незакоммиченные изменения — коммит перед началом.

---

## Шаг 2: Анализ

1. Прочитай `./style.css` — извлеки `PARENT_SLUG` (строка `Template:`), `TEXT_DOMAIN` (строка `Text Domain:`), `CHILD_SLUG` (строка `Theme URI:` или папка темы).

2. Прочитай:
   - `../PARENT_SLUG/doc_claude/cpt/CPT_CATALOG.md` — проверь на дубли
   - `../PARENT_SLUG/doc_claude/cpt/CPT_HOW_TO_ADD.md`

3. Проверь `./functions/cpt/` — нет ли похожего CPT в дочерней.
   Проверь `../PARENT_SLUG/functions/cpt/` — нет ли похожего в родительской.

4. Задай пользователю два блока уточняющих вопросов:

### Блок А — Базовые характеристики записи

| Вопрос | Влияет на |
|--------|-----------|
| Изображение (featured image) | `supports: thumbnail` |
| Заголовок | `supports: title` |
| Краткое описание (excerpt) | `supports: excerpt` |
| Полный контент (editor) | `supports: editor` |
| Автор | `supports: author` |
| Сортировка / иерархия | `supports: page-attributes`, `hierarchical: true` |
| История версий | `supports: revisions` |
| Публичный или структурный (только в админке) | `public`, `publicly_queryable` |
| Исключить из поиска сайта | `exclude_from_search: true` |
| Gutenberg или классический редактор | `use_block_editor_for_post_type` filter |
| REST API | `show_in_rest: true/false` |

### Блок Б — Single-страница (если нужен single)

| Вопрос | Влияет на |
|--------|-----------|
| Блок автора (аватар, имя, bio) | `get_the_author_meta()` + аватар |
| Комментарии | `comments_template()` + `supports: comments` |
| Поделиться (VK, Telegram, WhatsApp, копировать) | share-блок |
| Рекомендуемые записи после поста | `WP_Query` по таксономии или rand |

5. Уточни:
   - Нужен ли **archive** (`/{slug}/`)
   - Нужен ли **single** (`/{slug}/{post-name}/`)
   - Нужны ли **meta boxes** и какие поля
   - Нужна ли **таксономия** (см. шаг 3б)
   - Нужны ли **JS-библиотеки** (flatpickr, select2, sortable, gallery — см. шаг 3в)

---

## Шаг 3: Выбор схемы шаблонов

### Схема 1 — Классическая (стандартный loop + делегирование)

**Когда:** CPT показывает записи в обычной сетке без кастомной логики.

| Файл | Путь | Назначение |
|------|------|------------|
| `archive-{slug}.php` | `./archive-{slug}.php` | Redux + loop + `get_template_part` карточек |
| `templates/archives/{slug}/{slug}_1.php` | `./templates/archives/{slug}/{slug}_1.php` | Обёртка одной карточки |
| `single-{slug}.php` | `./single-{slug}.php` | `require_once get_template_directory() . '/single.php'` |
| `templates/singles/{slug}/default.php` | `./templates/singles/{slug}/default.php` | Реальный контент single |

Примеры: `staff`, `vacancies`, `testimonials`.

---

### Схема 2 — Прямая (специфичный контент, кастомный запрос)

**Когда:** accordion, карта, фильтры, группировка по таксономии — данные не через стандартный loop.

| Файл | Путь | Назначение |
|------|------|------------|
| `archive-{slug}.php` | `./archive-{slug}.php` | Полная разметка: `get_header()` → `get_pageheader()` → `WP_Query` → `get_footer()` |
| `single-{slug}.php` | `./single-{slug}.php` | Полная разметка с `get_post_meta` |

Примеры: `faq` (accordion), `offices` (Yandex Maps), `legal`.

---

## Шаг 3б: Таксономии

Предложи на выбор если не указано явно:

| Вариант | Slug | Тип |
|---------|------|-----|
| Категории | `{slug}_category` | `hierarchical: true` |
| Теги | `{slug}_tag` | `hierarchical: false` |
| Обе | — | — |
| Без таксономии | — | — |

Дождись ответа перед планом.

---

## Шаг 3в: JS-библиотеки

Спроси явно: нужны ли flatpickr, select2, sortable, gallery, другое?

Если да — enqueue только на страницах этого CPT через `admin_enqueue_scripts` + проверку `$screen->post_type`.

> Подключать из локальных файлов `../PARENT_SLUG/dist/vendor/`, не CDN.

---

## Шаг 4: План

**CPT:** `{name}` (`{slug}`)
**Схема:** Классическая / Прямая — объясни почему

Все файлы создаются в **дочерней теме** (`./`):

| Файл | Полный путь |
|------|-------------|
| `cpt-{slug}.php` | `./functions/cpt/cpt-{slug}.php` |
| `functions.php` | `./functions.php` — добавить `require_once` |
| + файлы шаблонов по схеме | `./templates/...` или `./archive-*.php` |

**Дождись подтверждения пользователя.**

---

## Шаг 5: Реализация

### 5.1 `functions/cpt/cpt-{slug}.php`

Text domain из `style.css` (`TEXT_DOMAIN`). Используй `get_stylesheet_directory()` — дочерняя тема.

**Именование:**

| Элемент | Паттерн |
|---------|---------|
| Регистрация CPT | `cptui_register_my_cpts_{slug}()` |
| Регистрация таксономии | `cptui_register_my_taxes_{slug}_category()` |
| Meta box ID | `cw_{slug}_{box_name}` |
| Callback | `cw_{slug}_{box_name}_callback()` |
| Сохранение | `cw_{slug}_save_{box_name}()` |
| Meta keys | `_{slug}_{field}` |
| Admin колонки | `cw_{slug}_add_admin_columns()` |

```php
<?php
/**
 * CPT: {Name}
 */

function cptui_register_my_cpts_{slug}() {
    $labels = [
        'name'          => esc_html__( '{Names}', 'TEXT_DOMAIN' ),
        'singular_name' => esc_html__( '{Name}', 'TEXT_DOMAIN' ),
        'add_new'       => esc_html__( 'Add New', 'TEXT_DOMAIN' ),
        'add_new_item'  => esc_html__( 'Add New {Name}', 'TEXT_DOMAIN' ),
        'edit_item'     => esc_html__( 'Edit {Name}', 'TEXT_DOMAIN' ),
        'all_items'     => esc_html__( 'All {Names}', 'TEXT_DOMAIN' ),
        'search_items'  => esc_html__( 'Search {Names}', 'TEXT_DOMAIN' ),
        'not_found'     => esc_html__( 'No {names} found.', 'TEXT_DOMAIN' ),
    ];

    $args = [
        'label'               => esc_html__( '{Name}', 'TEXT_DOMAIN' ),
        'labels'              => $labels,
        'public'              => true,
        'publicly_queryable'  => true,
        'show_ui'             => true,
        'show_in_rest'        => true,
        'has_archive'         => true,
        'rewrite'             => [ 'slug' => '{slug}', 'with_front' => true ],
        'supports'            => [ 'title', 'editor', 'thumbnail' ],
        'menu_icon'           => 'dashicons-portfolio',
        'hierarchical'        => false,
        'exclude_from_search' => false,
    ];

    register_post_type( '{slug}', $args );
}
add_action( 'init', 'cptui_register_my_cpts_{slug}' );
```

### 5.2 `require_once` в `functions.php` дочерней темы

```php
require_once get_stylesheet_directory() . '/functions/cpt/cpt-{slug}.php';
```

> `get_stylesheet_directory()` — всегда дочерняя тема.

---

## Шаг 6: Отчёт

- Схема и обоснование
- Список всех файлов с полными путями
- URL: `/wp-admin/edit.php?post_type={slug}`
- Что проверить вручную

---

## Шаг 7: Сброс постоянных ссылок

```bash
wp rewrite flush
```

---

## Шаг 8: Тестирование

1. `npm run build` из `../PARENT_SLUG/`
2. Проверь `cpt-{slug}.php` — 4 проверки save_post, sanitize, esc_*, text domain
3. Схема 2: `wp_reset_postdata()` после кастомного `WP_Query`

---

## Шаг 9: Обновление переводов

Файлы: `./languages/{TEXT_DOMAIN}.pot` и `./languages/ru_RU.po`

Скомпилировать: `wp i18n make-mo languages/ru_RU.po`

---

## Шаг 10: Коммит

```
feat: add CPT {slug} ({Name})
```
