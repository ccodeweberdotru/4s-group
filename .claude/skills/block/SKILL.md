---
name: block
description: Создать theme-specific Gutenberg-блок в дочерней теме CodeWeber — привязан к CPT или фиче
argument-hint: "название блока и к чему привязан, например: catalog-filter (CPT catalog)"
---

Создай theme-specific Gutenberg-блок в этой дочерней теме CodeWeber: `$ARGUMENTS`

> **Используй этот скилл** только для блоков, жёстко привязанных к CPT или фиче этой темы.
> Для универсальных блоков → скилл `/block` в плагине `codeweber-gutenberg-blocks`.

> **Правило:** весь код — на **английском**. Русский — только в `languages/ru_RU.po`.

Прочитай `.claude/RULES.md`.

---

## Шаг 1: Определить параметры темы

Прочитай `./style.css`:
- `Template:` → `PARENT_SLUG`
- `Text Domain:` → `TEXT_DOMAIN`

Документация parent: `../PARENT_SLUG/doc_claude/`

---

## Шаг 2: Коммит текущего состояния

`git status` — если есть незакоммиченные изменения, коммит перед началом.

---

## Шаг 3: Уточняющие вопросы

| Вопрос | Влияет на |
|--------|-----------|
| К какому CPT / фиче привязан? | Путь: `./functions/<feature>/blocks/<name>/` |
| Нужен ли PHP-рендер (ServerSideRender)? | Dynamic → `render_callback` в PHP |
| Какие данные нужны в редакторе? | REST API endpoint |
| Нужен ли Inspector sidebar? | `InspectorControls` + `wp.components` |
| Атрибуты блока | Список полей с типами |
| Ограничить показ блока по post_type? | `unregisterBlockType` при условии |

---

## Шаг 4: План

**Блок:** `codeweber-blocks/<name>`
**Место:** `./functions/<feature>/blocks/<name>/` (дочерняя тема)
**Тип:** Dynamic (ServerSideRender) / Static

| Файл | Путь | Назначение |
|------|------|------------|
| `index.js` | `./functions/<feature>/blocks/<name>/index.js` | Регистрация блока (vanilla JS) |
| `render.php` | `./functions/<feature>/blocks/<name>/render.php` | PHP-рендер *(если dynamic)* |
| Регистрация | `./functions.php` или `./functions/<feature>/<feature>.php` | `register_block_type` + enqueue |
| REST | `./functions/<feature>/<feature>.php` | `register_rest_route` *(если нужен API)* |

**Дождись подтверждения пользователя.**

---

## Шаг 5: Реализация

### 5.1 `./functions/<feature>/blocks/<name>/index.js`

Vanilla JS (без JSX / без npm build). Используй `wp.*` глобальные объекты.
Text domain: всегда `TEXT_DOMAIN` (из `style.css`).

### 5.2 `./functions/<feature>/blocks/<name>/render.php`

PHP-рендер с `get_block_wrapper_attributes()`.

### 5.3 Регистрация в `./functions.php`

`register_block_type` + `enqueue_block_editor_assets`.

> `get_stylesheet_directory()` / `get_stylesheet_directory_uri()` — всегда дочерняя тема.

---

## Шаг 6: Проверка

- [ ] Блок появляется в инсертере
- [ ] InspectorControls загружают данные
- [ ] ServerSideRender показывает правильный PHP-рендер
- [ ] REST: `permission_callback` через `current_user_can('edit_posts')`
- [ ] Все выводы в PHP через `esc_html()` / `esc_url()` / `esc_attr()` / `wp_kses_post()`
- [ ] Text domain везде `TEXT_DOMAIN`
- [ ] `get_stylesheet_directory()` — не `get_template_directory()`

---

## Шаг 7: Переводы

Файлы: `./languages/{TEXT_DOMAIN}.pot` и `./languages/ru_RU.po`

```bash
wp i18n make-mo languages/ru_RU.po
```

---

## Шаг 8: Коммит

```
feat: add block <name> (<feature>)
```
