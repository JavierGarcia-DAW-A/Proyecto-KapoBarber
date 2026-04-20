<?php
require_once('c:\xampp\htdocs\Proyecto-KapoBarber\wp-load.php');

$pages = get_pages();
$info = [];
foreach($pages as $page) {
    $info[] = ['ID' => $page->ID, 'post_title' => $page->post_title, 'post_name' => $page->post_name, 'post_type' => $page->post_type];
}
echo json_encode($info);
