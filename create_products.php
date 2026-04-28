<?php
require_once('wp-load.php');

$products = [
    ['title' => 'Hair Clay', 'content' => 'Premium styling hair clay with matte finish.', 'price' => '15.99'],
    ['title' => 'Beard Oil', 'content' => 'Nourishing beard oil for a soft and healthy beard.', 'price' => '12.50'],
    ['title' => 'Styling Comb', 'content' => 'Professional styling comb.', 'price' => '8.00'],
    ['title' => 'Shaving Cream', 'content' => 'Smooth shaving cream for sensitive skin.', 'price' => '10.00']
];

foreach ($products as $p) {
    // Check if product exists
    $existing = get_page_by_title($p['title'], OBJECT, 'shop_product');
    if (!$existing) {
        $post_id = wp_insert_post([
            'post_title'    => $p['title'],
            'post_content'  => $p['content'],
            'post_status'   => 'publish',
            'post_type'     => 'shop_product'
        ]);
        if ($post_id) {
            update_post_meta($post_id, '_price', $p['price']);
            echo "Created: " . $p['title'] . "\n";
        }
    } else {
        echo "Exists: " . $p['title'] . "\n";
    }
}
echo "Done.\n";
