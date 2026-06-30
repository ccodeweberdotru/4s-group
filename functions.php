<?php
/**
 * 4s-group functions and definitions
 *
 * @package 4s-group
 */

// Allow HTML in taxonomy term descriptions (removes WP default kses sanitization)
remove_filter( 'pre_term_description', 'wp_filter_kses' );
remove_filter( 'term_description', 'wp_kses_data' );

// ── clients_category: card_index term meta ──────────────────────────────────

add_action( 'init', function () {
	register_term_meta( 'clients_category', 'card_index', [
		'type'              => 'string',
		'single'            => true,
		'sanitize_callback' => 'sanitize_text_field',
		'show_in_rest'      => false,
	] );
} );

add_action( 'clients_category_add_form_fields', function () {
	wp_nonce_field( 'save_card_index', 'card_index_nonce' );
	?>
	<div class="form-field">
		<label for="card_index"><?php esc_html_e( 'Card index', 'codeweber' ); ?></label>
		<input type="text" name="card_index" id="card_index" value="" maxlength="10">
		<p><?php esc_html_e( 'Display number on card, e.g. 01, 02.', 'codeweber' ); ?></p>
	</div>
	<?php
} );

add_action( 'clients_category_edit_form_fields', function ( WP_Term $term ) {
	$value = get_term_meta( $term->term_id, 'card_index', true );
	wp_nonce_field( 'save_card_index', 'card_index_nonce' );
	?>
	<tr class="form-field">
		<th><label for="card_index"><?php esc_html_e( 'Card index', 'codeweber' ); ?></label></th>
		<td>
			<input type="text" name="card_index" id="card_index" value="<?php echo esc_attr( $value ); ?>" maxlength="10">
			<p class="description"><?php esc_html_e( 'Display number on card, e.g. 01, 02.', 'codeweber' ); ?></p>
		</td>
	</tr>
	<?php
} );

add_action( 'created_clients_category', 'four_s_group_save_card_index' );
add_action( 'edited_clients_category', 'four_s_group_save_card_index' );
function four_s_group_save_card_index( int $term_id ): void {
	if ( ! isset( $_POST['card_index_nonce'] ) || ! wp_verify_nonce( $_POST['card_index_nonce'], 'save_card_index' ) ) {
		return;
	}
	if ( isset( $_POST['card_index'] ) ) {
		update_term_meta( $term_id, 'card_index', sanitize_text_field( $_POST['card_index'] ) );
	}
}

// ── clients_category: term_list_items repeater ──────────────────────────────

add_action( 'init', function () {
	register_term_meta( 'clients_category', 'term_list_items', [
		'type'         => 'string',
		'single'       => true,
		'show_in_rest' => false,
	] );
} );

add_action( 'clients_category_add_form_fields', function () {
	// nonce already output by card_index handler above
	?>
	<div class="form-field">
		<label><?php esc_html_e( 'List items', 'codeweber' ); ?></label>
		<div id="cw-term-list-repeater">
			<div class="cw-repeater-row" style="display:flex;gap:8px;margin-bottom:6px;">
				<input type="text" name="term_list_items[]" value="" style="flex:1;">
				<button type="button" class="button cw-repeater-remove">&#8722;</button>
			</div>
		</div>
		<button type="button" class="button" id="cw-repeater-add" style="margin-top:4px;"><?php esc_html_e( '+ Add item', 'codeweber' ); ?></button>
		<?php cw_term_list_repeater_script(); ?>
	</div>
	<?php
} );

add_action( 'clients_category_edit_form_fields', function ( WP_Term $term ) {
	$raw   = get_term_meta( $term->term_id, 'term_list_items', true );
	$items = ( $raw && is_string( $raw ) ) ? json_decode( $raw, true ) : [];
	if ( ! is_array( $items ) ) {
		$items = [];
	}
	if ( empty( $items ) ) {
		$items = [ '' ];
	}
	?>
	<tr class="form-field">
		<th><label><?php esc_html_e( 'List items', 'codeweber' ); ?></label></th>
		<td>
			<div id="cw-term-list-repeater">
				<?php foreach ( $items as $item ) : ?>
					<div class="cw-repeater-row" style="display:flex;gap:8px;margin-bottom:6px;">
						<input type="text" name="term_list_items[]" value="<?php echo esc_attr( $item ); ?>" style="flex:1;">
						<button type="button" class="button cw-repeater-remove">&#8722;</button>
					</div>
				<?php endforeach; ?>
			</div>
			<button type="button" class="button" id="cw-repeater-add" style="margin-top:4px;"><?php esc_html_e( '+ Add item', 'codeweber' ); ?></button>
			<?php cw_term_list_repeater_script(); ?>
		</td>
	</tr>
	<?php
} );

function cw_term_list_repeater_script(): void {
	?>
	<script>
	(function () {
		var wrap = document.getElementById('cw-term-list-repeater');

		function bindRemove( btn ) {
			btn.addEventListener('click', function () {
				var row = btn.closest('.cw-repeater-row');
				if ( wrap.querySelectorAll('.cw-repeater-row').length > 1 ) {
					wrap.removeChild( row );
				} else {
					row.querySelector('input').value = '';
				}
			});
		}

		wrap.querySelectorAll('.cw-repeater-remove').forEach( bindRemove );

		document.getElementById('cw-repeater-add').addEventListener('click', function () {
			var row = document.createElement('div');
			row.className = 'cw-repeater-row';
			row.style.cssText = 'display:flex;gap:8px;margin-bottom:6px;';
			row.innerHTML = '<input type="text" name="term_list_items[]" value="" style="flex:1;"><button type="button" class="button cw-repeater-remove">&#8722;</button>';
			wrap.appendChild( row );
			bindRemove( row.querySelector('.cw-repeater-remove') );
			row.querySelector('input').focus();
		});
	})();
	</script>
	<?php
}

add_action( 'created_clients_category', 'four_s_group_save_term_list_items' );
add_action( 'edited_clients_category',  'four_s_group_save_term_list_items' );
function four_s_group_save_term_list_items( int $term_id ): void {
	if ( ! isset( $_POST['card_index_nonce'] ) || ! wp_verify_nonce( $_POST['card_index_nonce'], 'save_card_index' ) ) {
		return;
	}
	$raw   = isset( $_POST['term_list_items'] ) ? (array) $_POST['term_list_items'] : [];
	$items = array_values( array_filter( array_map( 'sanitize_text_field', $raw ) ) );
	if ( $items ) {
		update_term_meta( $term_id, 'term_list_items', wp_json_encode( $items, JSON_UNESCAPED_UNICODE ) );
	} else {
		delete_term_meta( $term_id, 'term_list_items' );
	}
}

// ── Enqueue ──────────────────────────────────────────────────────────────────

add_action( 'wp_enqueue_scripts', 'four_s_group_enqueue_styles' );
function four_s_group_enqueue_styles() {
    wp_enqueue_style(
        'four-s-group-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( 'codeweber-style' ),
        wp_get_theme()->get( 'Version' )
    );
}
