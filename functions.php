<?php
/**
 * 4s-group functions and definitions
 *
 * @package 4s-group
 */

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
