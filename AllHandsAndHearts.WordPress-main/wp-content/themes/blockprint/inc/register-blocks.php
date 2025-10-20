<?php
/**
 * Register blocks.
 * 
 * @link https://developer.wordpress.org/reference/functions/register_block_type/
 *
 * @package Blockprint
 */

function register_acf_blocks() {
	$blocks = [
		'accordion',
		'accordions',
		'active-programs-carousel',
		'active-programs-list',
		'active-programs-mini-carousel',
		'animated-header',
		'announcement-banner',
		'blog-post-card',
		'blog-post-header',
		'blog-posts-list',
		'card',
		'cards',
		'carousel-hero',
		'case-studies',
		'contact',
		'content-slider',
		'cta-link',
		'disaster-profile',
		'donate-hero',
		'faces-of-impact',
		'faqs',
		'featured-blog-post',
		'featured-blog-posts',
		'gallery-slideshow',
		'highlight-grid',
		'horizontal-copy',
		'image-link-card',
		'image-link-cards',
		'impact-cta-banner',
		'logo-cloud',
		'mantra',
		'media-gallery-carousel',
		'mini-stats-spotlight',
		'mission',
		'modal',
		'overlapping-content',
		'overlapping-cta-banner',
		'our-team',
		// 'overlapping-hero',
		'page-header',
		'pillars',
		'program-featured-media',
		'program-header',
		'program-history-list',
		'program-map',
		'program-response',
		'program-updates',
		'scroll-animation-hero',
		'section-header',
		'simple-cta-banner',
		'simple-hero',
		'site-footer',
		'site-header',
		'social-media-videos',
		'spacer',
		'split-content',
		'split-content-carousel',
		'split-cta-banner',
		'split-hero',
		'stat-cards',
		'stat-list',
		'stats-spotlight',
		'tab',
		'tabbed-values',
		'tabs',
		'tabbed-stories',
		'two-col-content',
		'two-col-image',
		'two-image-split-content',
		'value-prop',
		'value-prop-item',
		'video',
		'video-hero',
		'xxl-cta-banner'
	];

	if ( post_type_exists('testimonial') ) {
		array_push($blocks, 'testimonials');
	}

	foreach ( $blocks as $block ) {
		register_block_type( get_template_directory() . '/blocks/' . $block );
	}    
}
add_action( 'init', 'register_acf_blocks' );

/**
 * Disable wrapping of innerblocks on certain blocks.
 *
 * @link https://www.advancedcustomfields.com/resources/whats-new-with-acf-blocks-in-acf-6/
 * 
 */
function acf_wrap_frontend_innerblocks( $wrap, $name ) {
    $blocks = [
		
	];

    if ( in_array($name, $blocks) ) {
        return false;
    }

    return true;
}
add_filter( 'acf/blocks/wrap_frontend_innerblocks', 'acf_wrap_frontend_innerblocks', 10, 2 );