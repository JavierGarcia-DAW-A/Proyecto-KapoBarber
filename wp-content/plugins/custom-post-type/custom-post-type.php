<?php
/**
 * Plugin Name: Custom Reviews
 * Description: Registra un Custom Post Type para "Reseñas".
 * Version: 1.0
 * Author: Antigravity
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Salir si se accede directamente
}

function register_review_custom_post_type() {
    $labels = array(
        'name'                  => _x( 'Reseñas', 'Post Type General Name', 'text_domain' ),
        'singular_name'         => _x( 'Reseña', 'Post Type Singular Name', 'text_domain' ),
        'menu_name'             => __( 'Reseñas', 'text_domain' ),
        'name_admin_bar'        => __( 'Reseña', 'text_domain' ),
        'archives'              => __( 'Archivos de Reseñas', 'text_domain' ),
        'attributes'            => __( 'Atributos de Reseña', 'text_domain' ),
        'parent_item_colon'     => __( 'Reseña Padre:', 'text_domain' ),
        'all_items'             => __( 'Todas las Reseñas', 'text_domain' ),
        'add_new_item'          => __( 'Añadir Nueva Reseña', 'text_domain' ),
        'add_new'               => __( 'Añadir Nueva', 'text_domain' ),
        'new_item'              => __( 'Nueva Reseña', 'text_domain' ),
        'edit_item'             => __( 'Editar Reseña', 'text_domain' ),
        'update_item'           => __( 'Actualizar Reseña', 'text_domain' ),
        'view_item'             => __( 'Ver Reseña', 'text_domain' ),
        'view_items'            => __( 'Ver Reseñas', 'text_domain' ),
        'search_items'          => __( 'Buscar Reseña', 'text_domain' ),
        'not_found'             => __( 'No encontrada', 'text_domain' ),
        'not_found_in_trash'    => __( 'No encontrada en la papelera', 'text_domain' ),
        'featured_image'        => __( 'Imagen destacada', 'text_domain' ),
        'set_featured_image'    => __( 'Establecer imagen destacada', 'text_domain' ),
        'remove_featured_image' => __( 'Quitar imagen destacada', 'text_domain' ),
        'use_featured_image'    => __( 'Usar como imagen destacada', 'text_domain' ),
        'insert_into_item'      => __( 'Insertar en la reseña', 'text_domain' ),
        'uploaded_to_this_item' => __( 'Subido a esta reseña', 'text_domain' ),
        'items_list'            => __( 'Lista de reseñas', 'text_domain' ),
        'items_list_navigation' => __( 'Navegación de reseñas', 'text_domain' ),
        'filter_items_list'     => __( 'Filtrar reseñas', 'text_domain' ),
    );
    $args = array(
        'label'                 => __( 'Reseña', 'text_domain' ),
        'description'           => __( 'Reseñas de clientes para KapoBarber', 'text_domain' ),
        'labels'                => $labels,
        'supports'              => array( 'title', 'editor', 'thumbnail', 'custom-fields' ),
        'taxonomies'            => array( 'category', 'post_tag' ),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'menu_icon'             => 'dashicons-star-filled',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'page',
        'show_in_rest'          => true, // Habilitar el editor Gutenberg
    );
    register_post_type( 'review', $args );
}
add_action( 'init', 'register_review_custom_post_type', 0 );

// --- KAPOBARBER APPOINTMENTS SYSTEM --- //

function register_appointment_cpt() {
    $args = array(
        'label'               => __( 'Citas (Reservas)', 'text_domain' ),
        'supports'            => array( 'title', 'custom-fields' ),
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'menu_position'       => 6,
        'menu_icon'           => 'dashicons-calendar-alt',
        'capability_type'     => 'post',
        'show_in_rest'        => true,
    );
    register_post_type( 'appointment', $args );
}
add_action( 'init', 'register_appointment_cpt', 0 );

// Registrar Endpoint REST API personalizado para que Laravel envíe datos
add_action('rest_api_init', function () {
    register_rest_route('kapo/v1', '/appointments', array(
        'methods' => 'POST',
        'callback' => 'kapo_create_appointment',
        'permission_callback' => '__return_true' // Permitir que Laravel local lo llame de forma segura
    ));
});

function kapo_create_appointment(WP_REST_Request $request) {
    // Intentar obtener parámetros dependiendo del tipo de contenido
    $parameters = $request->get_json_params();
    if (empty($parameters)) {
        $parameters = $request->get_body_params();
    }
    
    $name = sanitize_text_field(isset($parameters['name']) ? $parameters['name'] : '');
    $email = sanitize_email(isset($parameters['email']) ? $parameters['email'] : '');
    $phone = sanitize_text_field(isset($parameters['phone']) ? $parameters['phone'] : '');
    $date = sanitize_text_field(isset($parameters['date']) ? $parameters['date'] : '');
    $time = sanitize_text_field(isset($parameters['time']) ? $parameters['time'] : '');
    $barber_name = sanitize_text_field(isset($parameters['barber_name']) ? $parameters['barber_name'] : '');
    
    if (!$name || !$date || !$time) {
        return new WP_Error('missing_data', 'Datos incompletos', array('status' => 400));
    }
    
    $post_id = wp_insert_post(array(
        'post_title'    => "Cita: $name - $date $time",
        'post_content'  => '',
        'post_status'   => 'publish',
        'post_type'     => 'appointment'
    ));
    
    if (is_wp_error($post_id)) {
        return new WP_Error('cant-create', 'No se pudo guardar la cita en WP', array('status' => 500));
    }
    
    // Guardar los metadatos (campos personalizados)
    update_post_meta($post_id, 'client_name', $name);
    update_post_meta($post_id, 'client_email', $email);
    update_post_meta($post_id, 'client_phone', $phone);
    update_post_meta($post_id, 'appointment_date', $date);
    update_post_meta($post_id, 'appointment_time', $time);
    update_post_meta($post_id, 'barber', $barber_name);
    
    return rest_ensure_response(array('status' => 'success', 'post_id' => $post_id, 'message' => 'Cita creada en WordPress.'));
}
