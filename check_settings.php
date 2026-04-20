<?php
require_once('c:\xampp\htdocs\Proyecto-KapoBarber\wp-load.php');
echo 'page_on_front: ' . get_option('page_on_front') . "\n";
echo 'page_for_posts: ' . get_option('page_for_posts') . "\n";
$blog = get_page_by_path('blog');
if ($blog) echo "Blog page ID is: " . $blog->ID . "\n";
$reviews = get_page_by_path('reviews');
if ($reviews) echo "Reviews page ID is: " . $reviews->ID . "\n";
