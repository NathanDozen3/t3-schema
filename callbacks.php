<?php

namespace t3\schema;

/**
 * Define the T3 schema capability.
 * 
 * @return void
 */
function define_t3_schema_capability() : void {
	$capability = 'manage_options';
	if( class_exists( 'WPSEO_Options' ) ) {
		$capability = 'wpseo_manage_options';
	}
	define( 'T3_MANAGE_SCHEMA_CAPABILITY', $capability );
}


/**
 * Register the post meta to show in REST API.
 * 
 * @return void
 */
function register_post_meta_to_show_in_rest_api() : void {

	$options = get_option( 't3_schema' );
	$post_types = $options[ 't3-schema-post-types' ] ?? [];

	foreach( $post_types as $post_type ) {
		register_post_meta(
			$post_type,
			't3-faq',
			[
				'show_in_rest' => true,
				'single'       => true,
				'type'         => 'string',
			]
		);
	}
}


/**
 * Registers the block using the metadata loaded from the `block.json` file.
 * 
 * @return void
 */
function register_faq_block() : void {
	register_block_type( T3_DIR . '/build' );
}


/**
 * Register T3 Schema settings.
 * 
 * @return void
 */
function register_t3_schema_settings() : void {
	register_setting( 't3-schema-settings', 't3_schema' );

	add_settings_section(
		'my-plugin-settings-section',
		__( '', 't3-schema' ),
		'__return_null',
		't3-schema-settings'
	);

	add_settings_field(
		't3-schema-post-types',
		__( 'Schema Post Types', 't3-schema' ),
		__NAMESPACE__ . '\render_multi_select_field',
		't3-schema-settings',
		'my-plugin-settings-section',
		[
			'id' => 't3-schema-post-types',
		]
	);

	add_settings_field(
		'global-schema',
		__( 'Global Schema', 't3-schema' ),
		__NAMESPACE__ . '\render_textarea_field',
		't3-schema-settings',
		'my-plugin-settings-section',
		[
			'id' => 'global-schema',
		]
	);

	add_settings_field(
		'homepage-schema',
		__( 'Homepage Schema', 't3-schema' ),
		__NAMESPACE__ . '\render_textarea_field',
		't3-schema-settings',
		'my-plugin-settings-section',
		[
			'id' => 'homepage-schema',
		]
	);

	add_settings_field(
		'all-pages-except-homepage-schema',
		__( 'All Pages Except Homepage Schema', 't3-schema' ),
		__NAMESPACE__ . '\render_textarea_field',
		't3-schema-settings',
		'my-plugin-settings-section',
		[
			'id' => 'all-pages-except-homepage-schema',
		]
	);
}


/**
 * Print a text area field.
 * 
 * @param array $args This is the description.
 *
 * @return void
 */
function render_textarea_field( array $args ) : void {
    if ( ! current_user_can( T3_MANAGE_SCHEMA_CAPABILITY ) ) {
		return;
	}

	$options = get_option( 't3_schema' );
	$args[ 'value' ] = $options[ $args[ 'id' ] ] ?? '';
	get_partial( 'textarea', $args );
}


/**
 * Print a multi select field.
 * 
 * @param array $args This is the description.
 *
 * @return void
 */
function render_multi_select_field( array $args ) : void {
    if ( ! current_user_can( T3_MANAGE_SCHEMA_CAPABILITY ) ) {
		return;
	}

	$options = get_option( 't3_schema' );
	$post_types = get_post_types( [ 'public' => true ] );
	unset( $post_types[ 'attachment' ] );
	get_partial( 'multi-select', [ 
		'post_types' => $post_types, 
		'options' => $options[ 't3-schema-post-types' ] ?? [],
	] );
}


/**
 * Add submenu page to general options menu.
 * 
 * @return void
 */
function add_submenu_to_general_options() : void {
    if ( ! current_user_can( T3_MANAGE_SCHEMA_CAPABILITY ) ) {
		return;
	}

	add_submenu_page( 
		'options-general.php',
		'T3 Schema',
		'T3 Schema',
		T3_MANAGE_SCHEMA_CAPABILITY,
		't3-schema', 
		__NAMESPACE__ . '\render_options_page'
	);
}


/**
 * Print the T3 Schema options page.
 * 
 * @return void
 */
function render_options_page() : void {
	if ( ! current_user_can( T3_MANAGE_SCHEMA_CAPABILITY ) ) {
		return;
	}

	get_partial( 'options-page' );
}


/**
 * Add settings link to plugins administration page.
 * 
 * @param array $links An array of links for the plugin.
 * 
 * @return array
 */
function add_settings_link_to_plugins_administration_page( array $links ) : array {
	if ( ! current_user_can( T3_MANAGE_SCHEMA_CAPABILITY ) ) {
        return $links;
    }

    $settings_link = sprintf(
        '<a href="%s">%s</a>',
        esc_url( admin_url( '/options-general.php?page=t3-schema' ) ),
        esc_html__( 'Settings', 't3-schema' )
    );

    array_unshift( $links, $settings_link );
	return $links;
}


/**
 * Add meta boxes.
 * 
 * @return void
 */
function add_meta_boxes() : void {
	if ( ! current_user_can( T3_MANAGE_SCHEMA_CAPABILITY ) ) {
		return;
	}

	$options = get_option( 't3_schema' );
	$post_types = $options[ 't3-schema-post-types' ] ?? [];

	foreach( $post_types as $post_type ) {
		add_meta_box(
			't3-schema',
			'T3 Meta Data',
			__NAMESPACE__ . '\meta_box',
			$post_type,
			'side'
		);
	
	}
}


/**
 * Print page meta boxes.
 * 
 * @return void
 */
function meta_box( \WP_Post $post ) : void {
    if ( ! current_user_can( T3_MANAGE_SCHEMA_CAPABILITY ) ) {
		return;
	}

	wp_nonce_field( basename( __FILE__ ), 't3-schema-nonce' );
	get_partial( 'meta-box', [ 'id' => $post->ID ] );
}


/**
 * Enqueue T3 Schema post editor assets.
 * 
 * @param string $hook
 * 
 * @return void
 */
function enqueue_t3_schema_post_editor_assets( string $hook ) : void {
    global $post;

	$options = get_option( 't3_schema' );
	$post_types = $options[ 't3-schema-post-types' ] ?? [];

    if(
		in_array( $hook, [ 'post-new.php', 'post.php' ] ) &&
		in_array( $post->post_type, $post_types )
	) {
		wp_enqueue_style( 't3-schema', plugins_url( 't3-schema-admin.css', __FILE__ ), [], T3_SCHEMA_VERSION );
    }
}


/**
 * Save T3 post meta data.
 * 
 * @param int $post_id Post ID.
 * @param WP_Post $post Post object.
 * @param bool $update Whether this is an existing post being updated.
 * 
 * @return void
 */
function save_t3_post_meta_data( int $post_id, \WP_Post $post, bool $update ) : void {
	save_t3_meta_data( 't3-schema', $post_id, $post, $update );
	save_t3_meta_data( 't3-faq', $post_id, $post, $update );
}


/**
 * Save a meta value.
 * 
 * @param string $args Meta key.
 * @param int $post_id Post ID.
 * @param WP_Post $post Post object.
 * @param bool $update Whether this is an existing post being updated.
 * 
 * @return void
 */
function save_t3_meta_data( string $meta_key, int $post_id, \WP_Post $post, bool $update ) : void {

	/* Verify user can save meta data. */
	if ( ! current_user_can( T3_MANAGE_SCHEMA_CAPABILITY ) ) {
		return;
	}

	/* Verify the nonce. */
	if (
		! isset( $_POST[ 't3-schema-nonce' ] ) || 
		! wp_verify_nonce( $_POST[ 't3-schema-nonce' ], basename( __FILE__ ) )
	) {
		return;
	}
  
	/* Get the post type object. */
	$post_type = get_post_type_object( $post->post_type );
  
	/* Check if the current user has permission to edit the post. */
	if ( !current_user_can( $post_type->cap->edit_post, $post_id ) ) {
		return;
	}
  
	/* Get the posted data and sanitize it. */
	$new_meta_value = ( isset( $_POST[ $meta_key ] ) ? $_POST[ $meta_key ] : '' );
	if( ! current_user_can( T3_MANAGE_SCHEMA_CAPABILITY ) ) {
		$new_meta_value = sanitize_textarea_field( $new_meta_value );
	}
  
	/* Get the meta value of the custom field key. */
	$meta_value = get_post_meta( $post_id, $meta_key, true );
  
	/* If a new meta value was added and there was no previous value, add it. */
	if( $new_meta_value && '' == $meta_value ) {
		add_post_meta( $post_id, $meta_key, $new_meta_value, true );
	}
	/* If the new meta value does not match the old value, update it. */
	elseif( $new_meta_value && $new_meta_value != $meta_value ) {
		update_post_meta( $post_id, $meta_key, $new_meta_value );
	}  
	/* If there is no new meta value but an old value exists, delete it. */
	elseif( '' == $new_meta_value && $meta_value ) {
		delete_post_meta( $post_id, $meta_key, $meta_value );
	}
}


/**
 * Print T3 schema.
 * 
 * @return void
 */
function print_t3_schema() : void {
	$options = get_option( 't3_schema' );
	if( ! empty( $options[ 'global-schema' ] ) ) {
		echo minify_html( $options[ 'global-schema' ] );
		echo PHP_EOL;
	}

	if( is_front_page() ) {
		if( ! empty( $options[ 'homepage-schema' ] ) ) {
			echo minify_html( $options[ 'homepage-schema' ] );
			echo PHP_EOL;
		}
	}
	else {
		if( ! empty( $options[ 'all-pages-except-homepage-schema' ] ) ) {
			echo minify_html( $options[ 'all-pages-except-homepage-schema' ] );
			echo PHP_EOL;
		}
	}

	$schema = get_post_meta( get_the_ID(), 't3-schema', true );
	if( ! empty( $schema ) ) {
		echo minify_html( $schema );
		echo PHP_EOL;
	}

	$faqs = json_decode( get_post_meta( get_the_ID(), 't3-faq', true ) );
	if( $faqs ) {
		ob_start();
		get_partial( 'schema', [ 'faqs' => $faqs ] );
		$buffer = ob_get_clean();
		echo minify_html( $buffer );
		echo PHP_EOL;
	}
}
