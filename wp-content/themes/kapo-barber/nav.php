<!-- nav-menu start -->
<nav>
    <ul class="nav-menu dark-bg-1">
        <!-- Home -->
        <li class="nav-box nav-bg-change">
            <a href="<?php echo home_url('/'); ?>" class="pointer-large nav-link">
                <span class="nav-btn" data-text="Home">Home</span>
            </a>
            <div class="nav-bg" style="background-image: url('<?php echo get_template_directory_uri(); ?>/assets/img/gallery/gallery1.png');"></div>
        </li>

        <!-- About -->
        <li class="nav-box nav-bg-change">
            <a href="<?php echo get_page_link( get_page_object("ABOUT")->ID); ?>" class="pointer-large nav-link">
                <span class="nav-btn" data-text="About">About</span>
            </a>
            <div class="nav-bg" style="background-image: url('<?php echo get_template_directory_uri(); ?>/assets/img/gallery/about.png');"></div>
        </li>

        <!-- Services -->
        <li class="nav-box nav-bg-change">
            <a href="<?php echo get_page_link( get_page_object("SERVICES")->ID); ?>" class="pointer-large nav-link">
                <span class="nav-btn" data-text="Services">Services</span>
            </a>
            <div class="nav-bg" style="background-image: url('<?php echo get_template_directory_uri(); ?>/assets/img/gallery/gallery2.png');"></div>
        </li>

        <!-- Portfolio -->
        <li class="nav-box nav-bg-change">
            <a href="<?php echo get_page_link( get_page_object("PORTFOLIO")->ID); ?>" class="pointer-large nav-link">
                <span class="nav-btn" data-text="Portfolio">Portfolio</span>
            </a>
            <div class="nav-bg" style="background-image: url('<?php echo get_template_directory_uri(); ?>/assets/img/gallery/gallery3.png');"></div>
        </li>

        <!-- Blog -->
        <li class="nav-box nav-bg-change">
            <a href="<?php echo get_page_link( get_page_object("BLOG")->ID); ?>" class="pointer-large nav-link">
                <span class="nav-btn" data-text="Blog">Blog</span>
            </a>
            <div class="nav-bg" style="background-image: url('<?php echo get_template_directory_uri(); ?>/assets/img/gallery/home-blog1.png');"></div>
        </li>

        <!-- Contact -->
        <li class="nav-box nav-bg-change">
            <a href="<?php echo get_page_link( get_page_object("CONTACT")->ID); ?>" class="pointer-large nav-link">
                <span class="nav-btn" data-text="Contact">Contact</span>
            </a>
            <div class="nav-bg" style="background-image: url('<?php echo get_template_directory_uri(); ?>/assets/img/gallery/gallery4.png');"></div>
        </li>
    </ul>
</nav>
<!-- nav-menu end -->
