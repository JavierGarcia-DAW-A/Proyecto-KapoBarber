<?php
require_once('c:\xampp\htdocs\Proyecto-KapoBarber\wp-load.php');

$translations = [
    '¡Nuevos estilos de corte de pelo tendencia para este verano!' => [
        'title' => 'New trending haircut styles for this summer!',
        'content' => 'We are excited to share with you the new trends for this summer season. At KapoBarber, our expert barbers have been perfecting Fade cuts, Mullets, and reinvented classics. Come and refresh yourself with a new look specifically designed to beat the heat without losing style. Book your appointment today!'
    ],
    'Abrimos una nueva sección de cuidado de barba' => [
        'title' => 'We opened a new beard care section',
        'content' => 'Due to high demand, we have expanded our services to offer premium beard treatments. From essential oils, deep hydration masks, to high-precision profiling. If you want your beard to speak for you, leave it in the hands of our professionals. We guarantee impeccable results.'
    ],
    'Renovación de nuestras instalaciones: Más confort' => [
        'title' => 'Renovation of our facilities: More comfort',
        'content' => 'Always thinking about the comfort of our clients, we have renovated our facilities. We now have new ergonomic chairs, a wider waiting area with complimentary drinks, and a decoration that mixes the classic with the urban. Come and discover your space for relaxation and transformation.'
    ],
    'KapoBarber participa en la competencia de barbería nacional' => [
        'title' => 'KapoBarber participates in the national barber competition',
        'content' => 'We are proud to announce that part of our team will participate in this year\'s national barber competition. We will be competing in the "Best Creative Cut" and "Beard Profiling" categories. We want to thank all our clients for their unconditional support which motivates us to keep improving day by day.'
    ],
    'Nueva línea de productos para el cuidado masculino en venta' => [
        'title' => 'New line of men\'s care products on sale',
        'content' => 'In collaboration with the best brands in the sector, we have launched our own sales section of products for hair and beard. Gel, matte waxes, pomades, and purifying shampoos are now available in our salon. Ask your trusted barber which is the best product for your hair type!'
    ]
];

$posts = get_posts(['post_type' => 'post', 'numberposts' => -1]);
foreach ($posts as $post) {
    if (isset($translations[$post->post_title])) {
        wp_update_post([
            'ID' => $post->ID,
            'post_title' => $translations[$post->post_title]['title'],
            'post_content' => $translations[$post->post_title]['content']
        ]);
        echo "Translated: " . $post->post_title . "\n";
    }
}
