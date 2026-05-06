<?php
require_once 'c:\xampp\htdocs\Proyecto-KapoBarber\wp-load.php';

// Find the old terms-privacy page
$old_page = get_page_by_path('terms-privacy');
if ($old_page) {
    wp_delete_post($old_page->ID, true);
    echo "Old terms-privacy page deleted.\n";
}

// Create Terms of Service page if it doesn't exist
$terms_page = get_page_by_path('terms');
if (!$terms_page) {
    $terms_id = wp_insert_post([
        'post_type' => 'page',
        'post_title' => 'Terms of Service',
        'post_name' => 'terms',
        'post_status' => 'publish'
    ]);
    if (!is_wp_error($terms_id)) {
        update_post_meta($terms_id, '_wp_page_template', 'page-terms.php');
        echo "Terms page created.\n";
    }
} else {
    update_post_meta($terms_page->ID, '_wp_page_template', 'page-terms.php');
    echo "Terms page updated.\n";
}

// Create Privacy Policy page if it doesn't exist
$privacy_page = get_page_by_path('privacy');
if (!$privacy_page) {
    $privacy_id = wp_insert_post([
        'post_type' => 'page',
        'post_title' => 'Privacy Policy',
        'post_name' => 'privacy',
        'post_status' => 'publish'
    ]);
    if (!is_wp_error($privacy_id)) {
        update_post_meta($privacy_id, '_wp_page_template', 'page-privacy.php');
        echo "Privacy page created.\n";
    }
} else {
    update_post_meta($privacy_page->ID, '_wp_page_template', 'page-privacy.php');
    echo "Privacy page updated.\n";
}
