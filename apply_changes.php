<?php
require_once('c:\xampp\htdocs\Proyecto-KapoBarber\wp-load.php');

// 1. Rename existing 'BLOG' page to 'REVIEWS'
$blog_page = get_page_by_path('blog');
if ($blog_page && $blog_page->post_title === 'BLOG') {
    wp_update_post([
        'ID' => $blog_page->ID,
        'post_title' => 'REVIEWS',
        'post_name' => 'reviews'
    ]);
    echo "Renamed BLOG to REVIEWS.\n";
}

// 2. Create the new 'BLOG' page
$new_blog_page = get_page_by_path('blog'); // it was renamed, so 'blog' shouldn't exist
if (!$new_blog_page) {
    $new_page_id = wp_insert_post([
        'post_title' => 'BLOG',
        'post_name' => 'blog',
        'post_type' => 'page',
        'post_status' => 'publish'
    ]);
    echo "Created new BLOG page with ID " . $new_page_id . ".\n";
}

// 3. Create 5 sample news posts
$sample_news = [
    [
        'title' => '¡Nuevos estilos de corte de pelo tendencia para este verano!',
        'content' => 'Estamos emocionados de compartir con vosotros las nuevas tendencias para esta temporada de verano. En KapoBarber, nuestros expertos barberos han estado perfeccionando los cortes Fade, Mullet y los clásicos reinventados. Ven y refréscate con un nuevo look diseñado específicamente para resistir el calor sin perder el estilo. ¡Reserva tu cita hoy!',
    ],
    [
        'title' => 'Abrimos una nueva sección de cuidado de barba',
        'content' => 'Debido a la alta demanda, hemos expandido nuestros servicios para ofrecer tratamientos premium para barba. Desde aceites esenciales, mascarillas de hidratación profunda hasta perfilados de alta precisión. Si quieres que tu barba hable por ti, déjala en manos de nuestros profesionales. Te garantizamos resultados impecables.',
    ],
    [
        'title' => 'Renovación de nuestras instalaciones: Más confort',
        'content' => 'Siempre pensando en la comodidad de nuestros clientes, hemos renovado nuestras instalaciones. Ahora contamos con nuevos sillones ergonómicos, una zona de espera más amplia con bebidas de cortesía y una decoración que mezcla lo clásico con lo urbano. Ven a conocer tu espacio de relajación y transformación.',
    ],
    [
        'title' => 'KapoBarber participa en la competencia de barbería nacional',
        'content' => 'Nos llena de orgullo anunciar que parte de nuestro equipo participará en la competencia de barbería a nivel nacional de este año. Estaremos compitiendo en la categoría de "Mejor Corte Creativo" y "Perfilar de Barba". Queremos agradecer a todos nuestros clientes por su apoyo incondicional que nos motiva a seguir mejorando día a día.',
    ],
    [
        'title' => 'Nueva línea de productos para el cuidado masculino en venta',
        'content' => 'En colaboración con las mejores marcas del sector, hemos lanzado nuestra propia sección de venta de productos para el cabello y barba. Gel, ceras mate, pomadas y champús purificantes ya están disponibles en nuestro salón. ¡Pregunta a tu barbero de confianza cuál es el mejor producto para tu tipo de cabello!',
    ]
];

// Check if these posts already exist to avoid duplicates if run multiple times
$existing_posts = get_posts(['post_type' => 'post', 'numberposts' => -1]);
$existing_titles = array_map(function($p) { return $p->post_title; }, $existing_posts);

foreach ($sample_news as $news) {
    if (!in_array($news['title'], $existing_titles)) {
        wp_insert_post([
            'post_title' => $news['title'],
            'post_content' => $news['content'],
            'post_type' => 'post',
            'post_status' => 'publish'
        ]);
        echo "Inserted news: " . $news['title'] . "\n";
    } else {
        echo "News already exists: " . $news['title'] . "\n";
    }
}
