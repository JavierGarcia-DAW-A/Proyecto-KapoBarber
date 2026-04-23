<?php
/* Template Name: Shop */
get_header();
?>
    <style>
        .shop-card {
            background: #262626;
            border: 1px solid #333;
            border-radius: 10px;
            height: 100%;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .shop-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.5);
        }
        .shop-img-wrapper {
            width: 100%;
            height: 250px;
            overflow: hidden;
            background: #111;
        }
        .shop-img-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }
        .shop-card:hover .shop-img-wrapper img {
            transform: scale(1.05);
        }
        .shop-content {
            padding: 30px 20px;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
            justify-content: space-between;
        }
        .shop-content h4 a {
            color: #ffffff;
            font-size: 22px;
            text-decoration: none;
            transition: color 0.3s;
        }
        .shop-content h4 a:hover {
            color: #dcaa63;
        }
        .shop-content p {
            color: #e0e0e0;
            font-size: 15px;
            line-height: 1.6;
            margin-bottom: 20px;
        }
        .shop-price {
            font-size: 26px;
            color: #dcaa63;
            font-weight: 700;
            margin-bottom: 25px;
        }
        .btn-buy {
            background-color: #dcaa63;
            color: #111;
            font-weight: 700;
            text-transform: uppercase;
            padding: 15px 30px;
            border: none;
            border-radius: 5px;
            font-size: 14px;
            transition: all 0.3s ease;
            cursor: pointer;
            width: 100%;
            text-align: center;
        }
        .btn-buy:hover {
            background-color: #c49654;
            color: #000;
            box-shadow: 0 5px 15px rgba(220, 170, 99, 0.4);
        }
    </style>
    <main>
        <!--? Inicio de Cabecera (Hero) -->
        <div class="slider-area2">
            <div class="slider-height2 d-flex align-items-center">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="hero-cap hero-cap2 pt-70 text-center">
                                <h2>Our Shop</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Fin de Cabecera (Hero) -->

        <!--? Inicio Área de Shop -->
        <section class="service-area section-padding30">
            <div class="container">
                <!-- Título de Sección -->
                <div class="row d-flex justify-content-center">
                    <div class="col-xl-7 col-lg-8 col-md-11 col-sm-11">
                        <div class="section-tittle text-center mb-90">
                            <span>Premium Barbershop Products</span>
                            <h2>Take the KapoBarber experience home</h2>
                        </div>
                    </div>
                </div>
                <!-- Productos -->
                <div class="row">
                    <?php
                    $args = array(
                        'post_type' => 'shop_product',
                        'posts_per_page' => -1,
                        'post_status' => 'publish'
                    );
                    $products = new WP_Query($args);

                    if ($products->have_posts()) :
                        while ($products->have_posts()) : $products->the_post();
                            $price = get_post_meta(get_the_ID(), '_price', true);
                            ?>
                            <div class="col-xl-4 col-lg-4 col-md-6 mb-50">
                                <div class="shop-card text-center">
                                    <div class="shop-img-wrapper">
                                        <?php if (has_post_thumbnail()) : ?>
                                            <?php the_post_thumbnail('medium', array('class' => 'img-fluid')); ?>
                                        <?php else: 
                                            // Usar imagen autogenerada de la carpeta shop
                                            $slug = sanitize_title(get_the_title());
                                            $img_url = get_template_directory_uri() . '/assets/img/shop/' . $slug . '.png';
                                        ?>
                                            <img src="<?php echo esc_url($img_url); ?>" alt="<?php the_title(); ?>" class="img-fluid">
                                        <?php endif; ?>
                                    </div> 
                                    <div class="shop-content">
                                        <div>
                                            <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                                            <p><?php echo wp_trim_words(get_the_content(), 15); ?></p>
                                        </div>
                                        <div>
                                            <div class="shop-price">
                                                $<?php echo esc_html($price); ?>
                                            </div>
                                            <a href="/Proyecto-KapoBarber/booking-backend/public/checkout?product_name=<?php echo urlencode(get_the_title()); ?>&price=<?php echo urlencode($price); ?>" class="btn-buy" style="display:block; text-decoration:none;">BUY</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        endwhile;
                        wp_reset_postdata();
                    else :
                        echo '<div class="col-12"><p class="text-center">No products available at the moment.</p></div>';
                    endif;
                    ?>
                </div>
            </div>
        </section>
        <!-- Fin Área de Shop -->

    </main>
<?php get_footer(); ?>
