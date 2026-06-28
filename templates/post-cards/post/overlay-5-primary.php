<?php
/**
 * Template: Overlay-5 Primary Post Card (4s-group child theme override)
 *
 * Tile-big вариант с img-scroll, бейджами тегов и цифровым индексом.
 *
 * @param array $post_data        Данные поста
 * @param array $display_settings Настройки отображения
 * @param array $template_args    Дополнительные аргументы
 */

if ( ! isset( $post_data ) || ! $post_data ) {
	return;
}

$display       = cw_get_post_card_display_settings( $display_settings ?? [] );
$template_args = wp_parse_args( $template_args ?? [], [
	'hover_classes'   => 'overlay overlay-5',
	'border_radius'   => 'rounded-3',
	'tile_class'      => 'tile-big',
	'show_figcaption' => true,
	'show_card_arrow' => true,
	'index'           => '',         // e.g. '01', '02' — цифра над заголовком
	'tags_taxonomy'   => 'post_tag', // таксономия для бейджей
	'max_tags'        => 6,
] );

$title = $post_data['title'];
if ( $display['title_length'] > 0 && mb_strlen( $title ) > $display['title_length'] ) {
	$title = mb_substr( $title, 0, $display['title_length'] ) . '...';
}

$excerpt = '';
if ( ! empty( $display['show_excerpt'] ) && $display['excerpt_length'] > 0 ) {
	$excerpt_plain = wp_strip_all_tags( $post_data['excerpt'] );
	$word_count    = count( preg_split( '/\s+/', trim( $excerpt_plain ), -1, PREG_SPLIT_NO_EMPTY ) );
	if ( $word_count <= $display['excerpt_length'] ) {
		$excerpt = $post_data['excerpt'];
	} else {
		$excerpt = wp_trim_words( $excerpt_plain, $display['excerpt_length'], '...' );
	}
}

$tags = [];
if ( ! empty( $template_args['tags_taxonomy'] ) ) {
	$terms = wp_get_post_terms( $post_data['id'], $template_args['tags_taxonomy'], [
		'number' => (int) $template_args['max_tags'],
	] );
	if ( ! is_wp_error( $terms ) && ! empty( $terms ) ) {
		$tags = $terms;
	}
}

$figure_class = trim(
	$template_args['hover_classes'] . ' ' .
	$template_args['border_radius'] . ' ' .
	'card-interactive ' .
	$template_args['tile_class']
);
?>

<figure class="<?php echo esc_attr( $figure_class ); ?>">
	<a href="<?php echo esc_url( $post_data['link'] ); ?>">
		<div class="bottom-overlay post-meta position-absolute zindex-1 d-flex flex-column h-100 w-100 p-5">
			<div class="mt-auto position-relative zindex-2">
				<?php if ( ! empty( $template_args['index'] ) ) : ?>
					<p class="text-white-50 small mb-2 fw-bold"><?php echo esc_html( $template_args['index'] ); ?></p>
				<?php endif; ?>

				<?php if ( $display['show_title'] && $title ) : ?>
					<p class="cw-card-title-lg text-white mb-3"><?php echo esc_html( $title ); ?></p>
				<?php endif; ?>

				<?php if ( ! empty( $tags ) ) : ?>
					<div class="d-flex flex-wrap gap-2">
						<?php foreach ( $tags as $tag ) : ?>
							<span class="badge badge-md rounded-pill bg-white bg-opacity-25 border border-white border-opacity-50 text-white">
								<?php echo esc_html( $tag->name ); ?>
							</span>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>
			</div>
		</div>

		<?php if ( $post_data['image_url'] ) : ?>
			<div class="img-scroll-wrap" data-cw-scroll-init="1">
				<img src="<?php echo esc_url( $post_data['image_url'] ); ?>"
				     alt="<?php echo esc_attr( $post_data['image_alt'] ); ?>"
				     class="w-100 h-100 object-fit-cover img-scroll">
			</div>
		<?php endif; ?>
	</a>

	<?php if ( $template_args['show_figcaption'] && $excerpt ) : ?>
		<figcaption class="p-5">
			<div class="post-body h-100 d-flex flex-column from-left justify-content-end">
				<p class="mb-0 fs-18 text-white-75"><?php echo wp_kses( $excerpt, [ 'br' => [] ] ); ?></p>
			</div>
		</figcaption>
	<?php endif; ?>

	<?php if ( ! empty( $template_args['show_card_arrow'] ) ) : ?>
		<div class="hover_card_button_hide position-absolute top-0 end-0 p-5 zindex-10">
			<i class="fs-25 uil uil-arrow-right lh-1"></i>
		</div>
	<?php endif; ?>
</figure>
