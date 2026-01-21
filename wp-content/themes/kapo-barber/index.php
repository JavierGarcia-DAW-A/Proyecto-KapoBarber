<?php get_header(); ?>
    <main>
        <!--? Hero Start -->
        <div class="slider-area2">
            <div class="slider-height2 d-flex align-items-center">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="hero-cap hero-cap2 pt-70 text-center">
                                <h2><?php single_post_title(); ?></h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Hero End -->
        
        <!--? Content Area Start -->
        <section class="blog_area section-padding">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 mb-5 mb-lg-0">
                        <div class="blog_left_sidebar">
                            <?php if ( have_posts() ) : ?>
                                <?php while ( have_posts() ) : the_post(); ?>
                                    <article class="blog_item">
                                        <div class="blog_details">
                                            <a class="d-inline-block" href="<?php the_permalink(); ?>">
                                                <h2 class="blog-head" style="color: #2d2d2d;"><?php the_title(); ?></h2>
                                            </a>
                                            <div class="content">
                                                <?php the_content(); ?>
                                            </div>
                                        </div>
                                    </article>
                                <?php endwhile; ?>
                                
                                <nav class="blog-pagination justify-content-center d-flex">
                                    <?php
                                    the_posts_pagination( array(
                                        'prev_text' => '<i class="ti-angle-left"></i>',
                                        'next_text' => '<i class="ti-angle-right"></i>',
                                    ) );
                                    ?>
                                </nav>
                            <?php else : ?>
                                <p>Nothing found.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                    <!-- Sidebar -->
                    <div class="col-lg-4">
                        <div class="blog_right_sidebar">
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
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Content Area End -->
    </main>
<?php get_footer(); ?>