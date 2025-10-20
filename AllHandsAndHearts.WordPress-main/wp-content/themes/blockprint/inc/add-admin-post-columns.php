<?php

/* Program list */

// Add a new column to the admin list for the "program" post type
add_filter('manage_program_posts_columns', 'acf_add_program_code_column');
function acf_add_program_code_column($columns) {
    // Insert the new column after the title
    $new_columns = [];

    foreach ($columns as $key => $value) {
        $new_columns[$key] = $value;
        if ($key === 'title') {
            $new_columns['program_code'] = 'Program Code';
        }
    }

    return $new_columns;
}

// Show the ACF field value in the new column
add_action('manage_program_posts_custom_column', 'acf_show_program_code_column', 10, 2);
function acf_show_program_code_column($column, $post_id) {
    if ($column === 'program_code') {
        // Use ACF's helper to get the field value
        $program_code = get_field('project_code', $post_id);
        echo esc_html($program_code ?: '—');
    }
}

// Make the new column sortable
add_filter('manage_edit-program_sortable_columns', 'acf_make_program_code_sortable');
function acf_make_program_code_sortable($columns) {
    $columns['program_code'] = 'program_code';
    return $columns;
}

// Handle sorting logic for the custom field
add_action('pre_get_posts', 'acf_program_code_sorting');
function acf_program_code_sorting($query) {
    if (!is_admin() || !$query->is_main_query()) return;

    if ($query->get('orderby') === 'program_code') {
        $query->set('meta_key', 'program_code');
        $query->set('orderby', 'meta_value'); // use 'meta_value_num' if numeric
    }
}


/* Stat list */

// Add a new column to the admin list for the "stat" post type
add_filter('manage_stat_posts_columns', 'acf_add_date_created_column');
function acf_add_date_created_column($columns) {
    // Insert the new column after the title
    $new_columns = [];

    foreach ($columns as $key => $value) {
        $new_columns[$key] = $value;
        if ($key === 'title') {
            $new_columns['date_created'] = 'Date Created';
        }
    }

    return $new_columns;
}

// Show the ACF field value in the new column
add_action('manage_stat_posts_custom_column', 'acf_show_date_created_column', 10, 2);
function acf_show_date_created_column($column, $post_id) {
    if ($column === 'date_created') {
        // Use ACF's helper to get the field value
        $date_created = get_field('date_created', $post_id);
        echo esc_html($date_created ?: '—');
    }
}

// Make the new column sortable
add_filter('manage_edit-stat_sortable_columns', 'acf_make_date_created_sortable');
function acf_make_date_created_sortable($columns) {
    $columns['date_created'] = 'date_created';
    return $columns;
}

// Handle sorting logic for the custom field
add_action('pre_get_posts', 'acf_date_created_sorting');
function acf_date_created_sorting($query) {
    if (!is_admin() || !$query->is_main_query()) return;

    if ($query->get('orderby') === 'date_created') {
        $query->set('meta_key', 'date_created');
        $query->set('orderby', 'meta_value'); // use 'meta_value_num' if numeric
    }
}