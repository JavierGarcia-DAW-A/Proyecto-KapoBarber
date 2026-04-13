<?php
function kapo_barber_scripts() {
    // Estilos
    wp_enqueue_style('bootstrap', get_template_directory_uri() . '/assets/css/bootstrap.min.css');
    wp_enqueue_style('owl-carousel', get_template_directory_uri() . '/assets/css/owl.carousel.min.css');
    wp_enqueue_style('slicknav', get_template_directory_uri() . '/assets/css/slicknav.css');
    wp_enqueue_style('flaticon', get_template_directory_uri() . '/assets/css/flaticon.css');
    wp_enqueue_style('gijgo', get_template_directory_uri() . '/assets/css/gijgo.css');
    wp_enqueue_style('animate', get_template_directory_uri() . '/assets/css/animate.min.css');
    wp_enqueue_style('animated-headline', get_template_directory_uri() . '/assets/css/animated-headline.css');
    wp_enqueue_style('magnific-popup', get_template_directory_uri() . '/assets/css/magnific-popup.css');
    wp_enqueue_style('fontawesome', get_template_directory_uri() . '/assets/css/fontawesome-all.min.css');
    wp_enqueue_style('themify-icons', get_template_directory_uri() . '/assets/css/themify-icons.css');
    wp_enqueue_style('slick', get_template_directory_uri() . '/assets/css/slick.css');
    wp_enqueue_style('nice-select', get_template_directory_uri() . '/assets/css/nice-select.css');
    wp_enqueue_style('price-rangs', get_template_directory_uri() . '/assets/css/price_rangs.css');
    
    // Estilo Principal (desde assets)
    wp_enqueue_style('kapo-barber-style', get_template_directory_uri() . '/assets/css/style.css');
    
    // Adaptable (Responsive)
    wp_enqueue_style('responsive', get_template_directory_uri() . '/assets/css/responsive.css');
    
    // Estilo Raíz (opcional, para info del tema o sobrescrituras)
    wp_enqueue_style('kapo-barber-root-style', get_stylesheet_uri());
}
add_action('wp_enqueue_scripts', 'kapo_barber_scripts');

function kapo_barber_setup() {
    // Registrar Menús de Navegación
    register_nav_menus( array(
        'primary' => __( 'Primary Menu', 'kapo-barber' ),
    ) );

    // Agregar Soporte de Etiqueta Title
    add_theme_support( 'title-tag' );
}
add_action( 'after_setup_theme', 'kapo_barber_setup' );

// Función de menú de respaldo, movida desde nav.php para asegurar disponibilidad
if ( ! function_exists( 'kapo_barber_menu_fallback' ) ) {
    function kapo_barber_menu_fallback() {
        echo '<ul id="navigation">';
        echo '<li class="active"><a href="' . home_url('/') . '">Home</a></li>';
        echo '<li><a href="' . site_url('/about') . '">About</a></li>';
        echo '<li><a href="' . site_url('/services') . '">Services</a></li>';
        echo '<li><a href="' . site_url('/portfolio') . '">Portfolio</a></li>';
        echo '<li><a href="' . site_url('/blog') . '">Blog</a>';
        echo '<ul class="submenu">';
        echo '<li><a href="' . site_url('/blog') . '">Blog</a></li>';
        echo '<li><a href="' . site_url('/blog-details') . '">Blog Details</a></li>';
        echo '<li><a href="' . site_url('/elements') . '">Element</a></li>';
        echo '</ul>';
        echo '</li>';
        echo '<li><a href="' . site_url('/contact') . '">Contact</a></li>';
        echo '</ul>';
    }
}

function get_page_object( $title ) {
        
        $args = array(
            'post_type' => 'page',      // Solo posts de tipo página
            'title' => $title,          // Título de la página
            'post_status' => 'publish', // Solo paginas publicadas
            'posts_per_page' => 1,
        );
        
        $query = new WP_Query( $args );
        
        if ( !empty( $query->post ) ) {
            $page =  $query->post;
        } else {
            $page = null;
        }
        
        return $page;
}

// Manejar la subida de reseñas desde el frontend
function kapo_handle_frontend_review_submission() {
    if (isset($_POST['action']) && $_POST['action'] === 'submit_review') {
        $name = sanitize_text_field($_POST['review_name']);
        $content = sanitize_textarea_field($_POST['review_content']);
        
        if (!empty($name) && !empty($content)) {
            $post_id = wp_insert_post(array(
                'post_title'    => 'Reseña de ' . $name,
                'post_content'  => $content,
                'post_type'     => 'review',
                'post_status'   => 'pending' // 'pending' para que un admin tenga que aprobarla
            ));
            
            if (!is_wp_error($post_id)) {
                update_post_meta($post_id, 'reviewer_name', $name);
                wp_redirect(add_query_arg('review_submitted', 'success', wp_get_referer()));
                exit;
            }
        }
        
        wp_redirect(add_query_arg('review_submitted', 'error', wp_get_referer()));
        exit;
    }
}
add_action('admin_post_nopriv_submit_review', 'kapo_handle_frontend_review_submission');
add_action('admin_post_submit_review', 'kapo_handle_frontend_review_submission');
