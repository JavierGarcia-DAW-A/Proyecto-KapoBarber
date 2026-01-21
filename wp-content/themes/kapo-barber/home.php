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
                            <!-- Fallback sidebar content if get_sidebar is empty or sidebar.php doesn't handle widgets properly -->
                            <!-- Checking sidebar.php might be needed, but for now I'll leave the static fallback if no sidebar logic exists yet. 
                                 Actually, I will keep the static sidebarHTML from page-blog.php as a fallback if dynamic sidebar isn't ready. 
                                 However, to make it functional I should just use the static HTML for now or try to be smart. -->
                             <aside class="single_sidebar_widget search_widget">
                                <form action="<?php echo home_url('/'); ?>">
                                    <div class="form-group">
                                        <div class="input-group mb-3">
                                            <input type="text" name="s" class="form-control" placeholder='Search Keyword'
                                                onfocus="this.placeholder = ''"
                                                onblur="this.placeholder = 'Search Keyword'">
                                            <div class="input-group-append">
                                                <button class="btns" type="submit"><i class="ti-search"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <button class="button rounded-0 primary-bg text-white w-100 btn_1 boxed-btn"
                                        type="submit">Search</button>
                                </form>
                            </aside>

                            <aside class="single_sidebar_widget post_category_widget">
                                <h4 class="widget_title" style="color: #2d2d2d;">Category</h4>
                                <ul class="list cat-list">
                                    <?php wp_list_categories(array('title_li' => '', 'style' => 'list')); ?>
                                </ul>
                            </aside>

                            <aside class="single_sidebar_widget popular_post_widget">
                                <h3 class="widget_title" style="color: #2d2d2d;">Recent Post</h3>
                                <?php
                                $recent_posts = new WP_Query(array('posts_per_page' => 4, 'ignore_sticky_posts' => 1));
                                if($recent_posts->have_posts()):
                                    while($recent_posts->have_posts()): $recent_posts->the_post();
                                ?>
                                <div class="media post_item">
                                    <?php if(has_post_thumbnail()): ?>
                                        <img src="<?php the_post_thumbnail_url('thumbnail'); ?>" alt="post" style="max-width: 80px;">
                                    <?php else: ?>
                                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/post/post_1.png" alt="post">
                                    <?php endif; ?>
                                    <div class="media-body">
                                        <a href="<?php the_permalink(); ?>">
                                            <h3 style="color: #2d2d2d;"><?php the_title(); ?></h3>
                                        </a>
                                        <p><?php echo get_the_date(); ?></p>
                                    </div>
                                </div>
                                <?php endwhile; wp_reset_postdata(); endif; ?>
                            </aside>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Blog Area End -->
    </main>
<?php get_footer(); ?>
