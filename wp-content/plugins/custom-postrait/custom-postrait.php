<?php
/**
 * Plugin Name: Custom Postrait
 * Description: Registers a custom post type for "postrait".
 * Version: 1.0
 * Author: Antigravity
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

function register_postrait_custom_post_type() {
    $labels = array(
        'name'                  => _x( 'Postraits', 'Post Type General Name', 'text_domain' ),
        'singular_name'         => _x( 'Postrait', 'Post Type Singular Name', 'text_domain' ),
        'menu_name'             => __( 'Postraits', 'text_domain' ),
        'name_admin_bar'        => __( 'Postrait', 'text_domain' ),
        'archives'              => __( 'Item Archives', 'text_domain' ),
        'attributes'            => __( 'Item Attributes', 'text_domain' ),
        'parent_item_colon'     => __( 'Parent Item:', 'text_domain' ),
        'all_items'             => __( 'All Items', 'text_domain' ),
        'add_new_item'          => __( 'Add New Item', 'text_domain' ),
        'add_new'               => __( 'Add New', 'text_domain' ),
        'new_item'              => __( 'New Item', 'text_domain' ),
        'edit_item'             => __( 'Edit Item', 'text_domain' ),
        'update_item'           => __( 'Update Item', 'text_domain' ),
        'view_item'             => __( 'View Item', 'text_domain' ),
        'view_items'            => __( 'View Items', 'text_domain' ),
        'search_items'          => __( 'Search Item', 'text_domain' ),
        'not_found'             => __( 'Not found', 'text_domain' ),
        'not_found_in_trash'    => __( 'Not found in Trash', 'text_domain' ),
        'featured_image'        => __( 'Featured Image', 'text_domain' ),
        'set_featured_image'    => __( 'Set featured image', 'text_domain' ),
        'remove_featured_image' => __( 'Remove featured image', 'text_domain' ),
        'use_featured_image'    => __( 'Use as featured image', 'text_domain' ),
        'insert_into_item'      => __( 'Insert into item', 'text_domain' ),
        'uploaded_to_this_item' => __( 'Uploaded to this item', 'text_domain' ),
        'items_list'            => __( 'Items list', 'text_domain' ),
        'items_list_navigation' => __( 'Items list navigation', 'text_domain' ),
        'filter_items_list'     => __( 'Filter items list', 'text_domain' ),
    );
    $args = array(
        'label'                 => __( 'Postrait', 'text_domain' ),
        'description'           => __( 'Post Type Description', 'text_domain' ),
        'labels'                => $labels,
        'supports'              => array( 'title', 'editor', 'thumbnail', 'custom-fields' ),
        'taxonomies'            => array( 'category', 'post_tag' ),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'page',
        'show_in_rest'          => true, // Enable Gutenberg editor
    );
    register_post_type( 'postrait', $args );
}
add_action( 'init', 'register_postrait_custom_post_type', 0 );

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

// Register Custom REST API Endpoint for Laravel to send data
add_action('rest_api_init', function () {
    register_rest_route('kapo/v1', '/appointments', array(
        'methods' => 'POST',
        'callback' => 'kapo_create_appointment',
        'permission_callback' => '__return_true' // Allow Laravel local backend to hit it safely
    ));
});

function kapo_create_appointment(WP_REST_Request $request) {
    // Attempt to get params depending on content-type
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
    
    // Save metadata
    update_post_meta($post_id, 'client_name', $name);
    update_post_meta($post_id, 'client_email', $email);
    update_post_meta($post_id, 'client_phone', $phone);
    update_post_meta($post_id, 'appointment_date', $date);
    update_post_meta($post_id, 'appointment_time', $time);
    update_post_meta($post_id, 'barber', $barber_name);
    
    return rest_ensure_response(array('status' => 'success', 'post_id' => $post_id, 'message' => 'Cita creada en WordPress.'));
}
