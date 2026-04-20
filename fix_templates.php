<?php
require_once('c:\xampp\htdocs\Proyecto-KapoBarber\wp-load.php');

// Fix page templates
$reviews_page = get_page_by_path('reviews');
if ($reviews_page) {
    update_post_meta($reviews_page->ID, '_wp_page_template', 'page-reviews.php');
    echo "Reviews page template updated.\n";
}

$blog_page = get_page_by_path('blog');
if ($blog_page) {
    update_post_meta($blog_page->ID, '_wp_page_template', 'page-blog.php');
    echo "Blog page template updated.\n";
}
