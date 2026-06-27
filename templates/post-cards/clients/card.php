<?php
/**
 * Template: Client Card (4s-group)
 *
 * Текстовая «ghost»-карточка клиента — название клиента вместо логотипа.
 * Переопределяет родительский clients/card.php (ключ шаблона client-card).
 *
 * @param array $post_data Данные клиента (из cw_get_post_card_data)
 * @param array $display_settings Настройки отображения
 * @param array $template_args Дополнительные аргументы (enable_link)
 */

if (!isset($post_data) || !$post_data) {
    return;
}

$template_args = wp_parse_args($template_args ?? [], [
    'enable_link' => false,
]);

$has_link = $template_args['enable_link'] && !empty($post_data['link']);
?>
<?php if ($has_link) : ?>
<a href="<?php echo esc_url($post_data['link']); ?>" class="d-block text-reset text-decoration-none">
<?php endif; ?>
  <div class="card-ghost card-lift rounded-3 p-4 text-center h-100"><?php echo esc_html($post_data['title']); ?></div>
<?php if ($has_link) : ?>
</a>
<?php endif; ?>
