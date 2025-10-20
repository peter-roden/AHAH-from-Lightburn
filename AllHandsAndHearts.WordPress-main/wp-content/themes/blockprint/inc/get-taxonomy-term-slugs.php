<?php
/**
 * Get a comma-separated list of taxonomy term slugs for a post.
 *
 * @param int    $post_id   The ID of the post.
 * @param string $taxonomy  The taxonomy slug (e.g., 'country').
 * @return string           Comma-separated term names or empty string.
 */

function get_taxonomy_term_slugs($post_id, $taxonomy) {
    $terms = get_the_terms($post_id, $taxonomy);

    if (is_wp_error($terms) || empty($terms)) {
        return '';
    }

    $term_names = wp_list_pluck($terms, 'slug');
    return implode(', ', $term_names);
}
