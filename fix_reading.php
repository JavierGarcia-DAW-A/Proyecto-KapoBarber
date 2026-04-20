<?php
require_once('c:\xampp\htdocs\Proyecto-KapoBarber\wp-load.php');
$blog = get_page_by_path('blog');
if ($blog) {
    update_option('page_for_posts', $blog->ID);
    echo "Updated page_for_posts to Blog page ID: " . $blog->ID . "\n";
}
