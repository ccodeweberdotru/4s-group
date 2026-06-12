---
name: design-extract
description: Извлечь цвета, шрифты, кнопки, формы, breadcrumb, навигацию с веб-страницы и применить к _user-variables.scss
argument-hint: <URL страницы-образца (одна или несколько через пробел)>
---

Извлеки дизайн-токены (цвета, типографика, кнопки, формы, breadcrumb, навигация) со страницы-образца и обнови `_user-variables.scss` темы CodeWeber.

**URL(ы) для анализа:** `$ARGUMENTS`

---

## Золотое правило извлечения стилей

**Для каждого компонента** (кнопки, инпуты, табы, аккордеон, навигация, карточки и т.д.) обязательно снимать **все параметры** в **трёх состояниях**:

| Параметр | Normal | :hover | :active / .active | :focus | :disabled |
|----------|--------|--------|-------------------|--------|-----------|
| Отступы (padding top/right/bottom/left) | ✓ | ✓ | ✓ | — | — |
| Внешние отступы (margin) | ✓ | — | — | — | — |
| Промежуток (gap) в flex-контейнерах | ✓ | — | — | — | — |
| Размер шрифта (font-size) | ✓ | ✓ | ✓ | — | — |
| Толщина шрифта (font-weight) | ✓ | ✓ | ✓ | — | — |
| Цвет шрифта (color) | ✓ | ✓ | ✓ | ✓ | ✓ |
| Межстрочный интервал (line-height) | ✓ | — | — | — | — |
| Межбуквенный интервал (letter-spacing) | ✓ | ✓ | ✓ | — | — |
| Трансформация текста (text-transform) | ✓ | — | ✓ | — | — |
| Оформление текста (text-decoration) | ✓ | ✓ | ✓ | — | — |
| Бордер — толщина (border-width) | ✓ | ✓ | ✓ | ✓ | ✓ |
| Бордер — стиль (border-style) | ✓ | ✓ | ✓ | ✓ | — |
| Бордер — цвет (border-color) | ✓ | ✓ | ✓ | ✓ | ✓ |
| Скругление (border-radius) | ✓ | — | — | — | — |
| Цвет фона (background-color) | ✓ | ✓ | ✓ | ✓ | ✓ |
| Тень (box-shadow) | ✓ | ✓ | ✓ | ✓ | — |
| Прозрачность (opacity) | ✓ | ✓ | — | — | ✓ |
| Курсор (cursor) | — | ✓ | — | — | ✓ |
| Outline (контур доступности) | — | — | — | ✓ | — |

---

## Шаг 1: Получение дизайн-токенов

Для каждого URL из аргументов:

1. Открой страницу в Playwright: `browser_navigate → URL`
2. Дождись загрузки (browser_wait_for → networkidle или 3 секунды)
3. Сделай скриншот: `browser_take_screenshot`
4. Выполни скрипт извлечения через `browser_evaluate`:
   Прочитай `.claude/skills/design-extract/scripts/extract-design-tokens.js`
   и выполни его содержимое через `browser_evaluate`.

---

## Шаг 2: Анализ и рекомендации

Прочитай текущие значения из:
- `src/assets/scss/_theme-colors.scss` (parent: `../codeweber/src/assets/scss/_theme-colors.scss`)
- `src/assets/scss/_variables.scss` (parent: `../codeweber/src/assets/scss/_variables.scss`)
- `src/assets/scss/_user-variables.scss` (в этой теме)

Создай отчёт `doc_claude/reports/YYYY-MM-DD/DESIGN-EXTRACT-[domain].md`.

**Покажи отчёт пользователю и жди подтверждения** перед обновлением `_user-variables.scss`.

---

## Шаг 3: Обновление _user-variables.scss

После подтверждения пользователя запиши переменные в `src/assets/scss/_user-variables.scss`.

**Правила записи:**
- Только переменные, значения которых **отличаются** от дефолтных
- Комментарий с прежним значением `// (было: ...)`
- Группировка: Цвета → Типографика → Кнопки → Формы → Навигация → Кастомные правила → Шрифты
- Все переменные **без** `!default`
- Используй `$blue` вместо `$primary`, `#ffffff` вместо `$white`

---

## Шаг 4: Проверка (опционально)

Если пользователь хочет увидеть результат:
1. Запусти `/build`
2. Открой страницу в Playwright и сделай скриншот для сравнения
