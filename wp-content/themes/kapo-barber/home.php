<?php
get_header();
?>
    <main>
        <!--? Hero Start -->
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
        <!-- Hero End -->
        <!--? Blog Area Start-->
        <section class="blog_area section-padding">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 mb-5 mb-lg-0">
                        <div class="blog_left_sidebar">
                            
                            <?php if ( have_posts() ) : ?>
                                <?php while ( have_posts() ) : the_post(); ?>
                                    <article class="blog_item">
                                        <div class="blog_item_img">
                                            <?php if ( has_post_thumbnail() ) : ?>
                                                <?php the_post_thumbnail('large', array('class' => 'card-img rounded-0')); ?>
                                            <?php else: ?>
                                                <img class="card-img rounded-0" src="<?php echo get_template_directory_uri(); ?>/assets/img/blog/single_blog_1.png" alt="">
                                            <?php endif; ?>
                                            <a href="<?php the_permalink(); ?>" class="blog_item_date">
                                                <h3><?php echo get_the_date('d'); ?></h3>
                                                <p><?php echo get_the_date('M'); ?></p>
                                            </a>
                                        </div>
                                        <div class="blog_details">
                                            <a class="d-inline-block" href="<?php the_permalink(); ?>">
                                                <h2 class="blog-head" style="color: #2d2d2d;"><?php the_title(); ?></h2>
                                            </a>
                                            <p><?php the_excerpt(); ?></p>
                                            <ul class="blog-info-link">
                                                <li><a href="#"><i class="fa fa-user"></i> <?php the_category(', '); ?></a></li>
                                                <li><a href="#"><i class="fa fa-comments"></i> <?php comments_number('0 Comments', '1 Comment', '% Comments'); ?></a></li>
                                            </ul>
                                        </div>
                                    </article>
                                <?php endwhile; ?>

                                <!-- Pagination -->
                                <nav class="blog-pagination justify-content-center d-flex">
                                    <?php
                                    the_posts_pagination( array(
                                        'mid_size'  => 2,
                                        'prev_text' => '<i class="ti-angle-left"></i>',
                                        'next_text' => '<i class="ti-angle-right"></i>',
                                        'screen_reader_text' => ' ',
                                    ) );
                                    ?>
                                </nav>

                            <?php else : ?>
                                <p>No posts found.</p>
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
        <!-- Blog Area End -->
    </main>
<?php get_footer(); ?>
