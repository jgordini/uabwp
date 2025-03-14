<?php
/**
 * This file adds functions to the uabwp WordPress theme.
 *
 * @package uabwp
 * @author  WP Engine
 * @license GNU General Public License v3
 * @link    https://uabwpwp.com/
 */

if ( ! function_exists( 'uabwp_setup' ) ) {

	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 *
	 * @since 0.8.0
	 *
	 * @return void
	 */
	function uabwp_setup() {

		// Make theme available for translation.
		load_theme_textdomain( 'uabwp', get_template_directory() . '/languages' );

		// Enqueue editor stylesheet.
		add_editor_style( get_template_directory_uri() . '/style.css' );

		// Remove core block patterns.
		remove_theme_support( 'core-block-patterns' );

	}
}
add_action( 'after_setup_theme', 'uabwp_setup' );

// Enqueue stylesheet.
add_action( 'wp_enqueue_scripts', 'uabwp_enqueue_stylesheet' );
function uabwp_enqueue_stylesheet() {

	wp_enqueue_style( 'uabwp', get_template_directory_uri() . '/style.css', array(), wp_get_theme()->get( 'Version' ) );

}

/**
 * Register block styles.
 *
 * @since 0.9.2
 */
function uabwp_register_block_styles() {

	$block_styles = array(
		'core/columns' => array(
			'columns-reverse' => __( 'Reverse', 'uabwp' ),
		),
		'core/group' => array(
			'shadow-light' => __( 'Shadow', 'uabwp' ),
			'shadow-solid' => __( 'Solid', 'uabwp' ),
		),
		'core/list' => array(
			'no-disc' => __( 'No Disc', 'uabwp' ),
		),
		'core/quote' => array(
			'shadow-light' => __( 'Shadow', 'uabwp' ),
			'shadow-solid' => __( 'Solid', 'uabwp' ),
		),
		'core/social-links' => array(
			'outline' => __( 'Outline', 'uabwp' ),
		),
	);

	foreach ( $block_styles as $block => $styles ) {
		foreach ( $styles as $style_name => $style_label ) {
			register_block_style(
				$block,
				array(
					'name'  => $style_name,
					'label' => $style_label,
				)
			);
		}
	}
}
add_action( 'init', 'uabwp_register_block_styles' );

/**
 * Register block pattern categories.
 *
 * @since 1.0.4
 */
function uabwp_register_block_pattern_categories() {

	register_block_pattern_category(
		'uabwp-page',
		array(
			'label'       => __( 'Page', 'uabwp' ),
			'description' => __( 'Create a full page with multiple patterns that are grouped together.', 'uabwp' ),
		)
	);
	register_block_pattern_category(
		'uabwp-pricing',
		array(
			'label'       => __( 'Pricing', 'uabwp' ),
			'description' => __( 'Compare features for your digital products or service plans.', 'uabwp' ),
		)
	);

}

add_action( 'init', 'uabwp_register_block_pattern_categories' );
