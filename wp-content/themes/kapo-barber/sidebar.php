<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package Kapo_Barber
 */
?>

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
            <img src="<?php the_post_thumbnail_url('thumbnail'); ?>" alt="post" style="max-width: 80px; height: auto; margin-right: 15px;">
        <?php else: ?>
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/blog/single_blog_1.png" alt="post" style="max-width: 80px; height: auto; margin-right: 15px;">
        <?php endif; ?>
        <div class="media-body">
            <a href="<?php the_permalink(); ?>">
                <h3 style="color: #2d2d2d; font-size: 16px; line-height: 1.4;"><?php the_title(); ?></h3>
            </a>
            <p><?php echo get_the_date(); ?></p>
        </div>
    </div>
    <?php endwhile; wp_reset_postdata(); endif; ?>
</aside>
