<?php
function kapo_barber_scripts() {
    // Styles
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
    
    // Main Style (from assets)
    wp_enqueue_style('kapo-barber-style', get_template_directory_uri() . '/assets/css/style.css');
    
    // Responsive
    wp_enqueue_style('responsive', get_template_directory_uri() . '/assets/css/responsive.css');
    
    // Root Style (optional, for theme info or overrides)
    wp_enqueue_style('kapo-barber-root-style', get_stylesheet_uri());
}
add_action('wp_enqueue_scripts', 'kapo_barber_scripts');

function kapo_barber_setup() {
    // Register Navigation Menus
    register_nav_menus( array(
        'primary' => __( 'Primary Menu', 'kapo-barber' ),
    ) );

    // Add Title Tag Support
    add_theme_support( 'title-tag' );
}
add_action( 'after_setup_theme', 'kapo_barber_setup' );

// Fallback menu function, moved from nav.php to ensure availability
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
            'post_type' => 'page',      // Only page type posts
            'title' => $title,          // Page title 
            'post_status' => 'publish', // Only the published pages
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
