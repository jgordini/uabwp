<?php
/**
 * This file adds functions to the uabwp WordPress theme.
 *
 * @package uabwp
 * @author  UAB
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
		add_editor_style( array(
            'https://use.typekit.net/yvz8uhi.css',
            get_template_directory_uri() . '/style.css'
        ));

		// Remove core block patterns.
		remove_theme_support( 'core-block-patterns' );

	}
}
add_action( 'after_setup_theme', 'uabwp_setup' );

// Enqueue stylesheets.
add_action( 'wp_enqueue_scripts', 'uabwp_enqueue_stylesheet' );
function uabwp_enqueue_stylesheet() {
    // Enqueue Typekit fonts with a high priority (1)
    wp_enqueue_style('adobe-fonts', 'https://use.typekit.net/yvz8uhi.css', array(), null);
    
    // Enqueue the theme's stylesheet after the fonts
	wp_enqueue_style( 'uabwp', get_template_directory_uri() . '/style.css', array('adobe-fonts'), wp_get_theme()->get( 'Version' ) );
}

/**
 * Add inline CSS to help ensure fonts are applied correctly.
 */
function uabwp_add_inline_styles() {
    $inline_css = "
        body, h1, h2, h3, h4, h5, h6, p, span, div, a, button, input, select, textarea, .wp-block-site-title, .wp-block-post-title {
            font-family: 'aktiv-grotesk', sans-serif;
        }
        
        .wp-block-button__link, 
        .wp-element-button {
            background-color: var(--wp--preset--color--uab-green);
            color: var(--wp--preset--color--base);
        }
        
        .wp-block-button__link:hover, 
        .wp-element-button:hover {
            background-color: var(--wp--preset--color--dragons-lair);
        }
        
        a {
            color: var(--wp--preset--color--dragons-lair);
        }
        
        a:hover, a:focus {
            color: var(--wp--preset--color--uab-green);
        }
    ";
    wp_add_inline_style('uabwp', $inline_css);
}
add_action('wp_enqueue_scripts', 'uabwp_add_inline_styles', 20);

/**
 * Enqueue Adobe Fonts (Typekit) in the editor.
 */
function uabwp_enqueue_editor_assets() {
    // Specifically for the block editor
    wp_enqueue_style('adobe-fonts-editor', 'https://use.typekit.net/yvz8uhi.css', array(), null);
    
    // Add additional inline CSS for the editor
    $editor_css = "
        .editor-styles-wrapper, 
        .editor-styles-wrapper h1,
        .editor-styles-wrapper h2,
        .editor-styles-wrapper h3,
        .editor-styles-wrapper h4,
        .editor-styles-wrapper h5,
        .editor-styles-wrapper h6,
        .editor-styles-wrapper p,
        .editor-styles-wrapper span,
        .editor-styles-wrapper div,
        .editor-styles-wrapper a,
        .editor-styles-wrapper button,
        .editor-styles-wrapper input,
        .editor-styles-wrapper select,
        .editor-styles-wrapper textarea,
        .editor-styles-wrapper .wp-block-site-title,
        .editor-styles-wrapper .wp-block-post-title,
        .block-editor-block-list__block {
            font-family: 'aktiv-grotesk', sans-serif;
        }
        
        .editor-styles-wrapper a {
            color: var(--wp--preset--color--dragons-lair);
        }
        
        .editor-styles-wrapper .wp-block-button__link, 
        .editor-styles-wrapper .wp-element-button {
            background-color: var(--wp--preset--color--uab-green);
            color: var(--wp--preset--color--base);
        }
    ";
    wp_add_inline_style('wp-edit-blocks', $editor_css);
}
add_action('enqueue_block_editor_assets', 'uabwp_enqueue_editor_assets');

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
		'core/paragraph' => array(
			'thin-text' => __( 'Thin Text', 'uabwp' ),
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
	
	register_block_pattern_category(
		'uabwp-uab',
		array(
			'label'       => __( 'UAB', 'uabwp' ),
			'description' => __( 'UAB-specific patterns and layouts.', 'uabwp' ),
		)
	);

}

add_action( 'init', 'uabwp_register_block_pattern_categories' );

/**
 * Add custom image sizes.
 */
function uabwp_add_image_sizes() {
    add_image_size( 'uab-hero', 1920, 800, true );
    add_image_size( 'uab-featured', 1200, 800, true );
    add_image_size( 'uab-card', 600, 400, true );
}
add_action( 'after_setup_theme', 'uabwp_add_image_sizes' );