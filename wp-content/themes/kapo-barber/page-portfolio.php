<?php
/* Template Name: Portfolio */
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
                                <h2>Portfolio</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Hero End -->
        <!--? Gallery Area Start -->
        <div class="gallery-area section-padding30">
            <div class="container">
                 <div class="row justify-content-center">
                    <div class="col-xl-6 col-lg-7 col-md-9 col-sm-10">
                        <div class="section-tittle text-center mb-100">
                            <span>Our Gallery</span>
                            <h2>Some images from our barber shop</h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="box snake mb-30">
                            <div class="gallery-img " style="background-image: url(<?php echo get_template_directory_uri(); ?>/assets/img/gallery/gallery1.png);"></div>
                            <div class="overlay"></div>
                        </div>
                    </div>
                    <div class="col-lg-8 col-md-6 col-sm-6">
                        <div class="box snake mb-30">
                            <div class="gallery-img " style="background-image: url(<?php echo get_template_directory_uri(); ?>/assets/img/gallery/gallery2.png);"></div>
                            <div class="overlay"></div>
                        </div>
                    </div>
                    <div class="col-lg-8 col-md-6 col-sm-6">
                        <div class="box snake mb-30">
                            <div class="gallery-img " style="background-image: url(<?php echo get_template_directory_uri(); ?>/assets/img/gallery/gallery3.png);"></div>
                            <div class="overlay"></div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="box snake mb-30">
                            <div class="gallery-img " style="background-image: url(<?php echo get_template_directory_uri(); ?>/assets/img/gallery/gallery4.png);"></div>
                            <div class="overlay"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Gallery Area End -->

         <!-- Cut Details / Testimonials Start -->
         <div class="cut-details section-bg section-padding2" data-background="<?php echo get_template_directory_uri(); ?>/assets/img/gallery/section_bg02.png">
           <div class="container">
            <div class="cut-active dot-style">
                <div class="single-cut">
                    <div class="cut-icon mb-20">
                        <svg xmlns="http://www.w3.org/2000/svg" width="50px" height="50px">
                             <path fill="#d4af37" d="M25,0C11.193,0,0,11.193,0,25s11.193,25,25,25s25-11.193,25-25S38.807,0,25,0z M25,45 C13.972,45,5,36.028,5,25S13.972,5,25,5s20,8.972,20,20S36.028,45,25,45z M35,25c0,5.523-4.477,10-10,10s-10-4.477-10-10s4.477-10,10-10 S35,19.477,35,25z"/>
                        </svg>
                    </div>
                    <div class="cut-descriptions">
                        <p>I have been a customer for over 10 years and I wouldn't trust anyone else with my hair. The staff is professional, friendly, and always delivers the perfect cut.</p>
                        <span>JONT NICOLIN KOOK</span>
                    </div>
                </div>
                <div class="single-cut">
                    <div class="cut-icon mb-20">
                        <svg xmlns="http://www.w3.org/2000/svg" width="50px" height="50px">
                             <path fill="#d4af37" d="M25,0C11.193,0,0,11.193,0,25s11.193,25,25,25s25-11.193,25-25S38.807,0,25,0z M25,45 C13.972,45,5,36.028,5,25S13.972,5,25,5s20,8.972,20,20S36.028,45,25,45z M35,25c0,5.523-4.477,10-10,10s-10-4.477-10-10s4.477-10,10-10 S35,19.477,35,25z"/>
                        </svg>
                    </div>
                    <div class="cut-descriptions">
                        <p>Best barbershop in town! The atmosphere is great and the service is even better. I highly recommend the hot towel shave, it's an experience you don't want to miss.</p>
                        <span>DAVID SMITH</span>
                    </div>
                </div>
            </div>
           </div>
        </div>
        <!-- Cut Details End -->
    </main>
<?php get_footer(); ?>
