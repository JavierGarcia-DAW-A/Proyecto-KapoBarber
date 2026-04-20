<?php
get_header();
?>
    <main>
        <!--? Inicio de Cabecera (Hero) -->
        <div class="slider-area2">
            <div class="slider-height2 d-flex align-items-center">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="hero-cap hero-cap2 pt-70 text-center">
                                <h2>Blog</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Fin de Cabecera (Hero) -->
        <!--? Blog Area Start-->
        <section class="blog_area section-padding">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 mb-5 mb-lg-0">
                        <div class="blog_left_sidebar">
                            <!-- Espacio para Blog -->

                            <!-- WP Query para Blog Posts -->
                            <?php
                            $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                            $args = array(
                                'post_type'      => 'post',
                                'post_status'    => 'publish',
                                'posts_per_page' => 5,
                                'paged'          => $paged,
                            );
                            $review_query = new WP_Query($args);

                            if ($review_query->have_posts()):
                                while ($review_query->have_posts()): $review_query->the_post();
                                $reviewer_name = get_the_author();
                            ?>
                            <article class="blog_item">
                                <?php if (has_post_thumbnail()): ?>
                                <div class="blog_item_img">
                                    <?php the_post_thumbnail('large', ['class' => 'card-img rounded-0']); ?>
                                    <a href="<?php the_permalink(); ?>" class="blog_item_date">
                                        <h3><?php echo get_the_date('d'); ?></h3>
                                        <p><?php echo get_the_date('M'); ?></p>
                                    </a>
                                </div>
                                <?php else: ?>
                                <div class="blog_item_img">
                                    <!-- Si no hay imagen, mostramos fecha igual -->
                                    <a href="<?php the_permalink(); ?>" class="blog_item_date" style="position: relative; left: 0; bottom: 0;">
                                        <h3><?php echo get_the_date('d'); ?></h3>
                                        <p><?php echo get_the_date('M'); ?></p>
                                    </a>
                                </div>
                                <?php endif; ?>
                                <div class="blog_details">
                                    <a class="d-inline-block" href="<?php the_permalink(); ?>">
                                        <h2 class="blog-head" style="color: #2d2d2d;"><?php the_title(); ?></h2>
                                    </a>
                                    <p><?php echo wp_trim_words(get_the_content(), 30); ?></p>
                                    <ul class="blog-info-link">
                                        <li><a href="#"><i class="fa fa-user"></i> Written by: <?php echo esc_html($reviewer_name); ?></a></li>
                                    </ul>
                                </div>
                            </article>
                            <?php 
                                endwhile;
                                
                                // Pagination
                                $total_pages = $review_query->max_num_pages;
                                if ($total_pages > 1):
                                    $current_page = max(1, get_query_var('paged'));
                            ?>
                            <nav class="blog-pagination justify-content-center d-flex">
                                <?php 
                                    echo paginate_links(array(
                                        'base'      => get_pagenum_link(1) . '%_%',
                                        'format'    => 'page/%#%',
                                        'current'   => $current_page,
                                        'total'     => $total_pages,
                                        'prev_text' => '<i class="ti-angle-left"></i>',
                                        'next_text' => '<i class="ti-angle-right"></i>',
                                        'type'      => 'list',
                                        'add_args'  => false,
                                    ));
                                ?>
                            </nav>
                            <?php
                                endif;
                                wp_reset_postdata();

                            else:
                            ?>
                                <h4>There are no news published yet.</h4>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="blog_right_sidebar">
                            <?php get_sidebar(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Fin Área del Blog -->
    </main>
<?php get_footer(); ?>
