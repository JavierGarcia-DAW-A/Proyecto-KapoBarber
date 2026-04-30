<?php
/**
 * The template for displaying all single posts
 */
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
                              <h2>Blog Details</h2>
                           </div>
                     </div>
                  </div>
               </div>
         </div>
      </div>
      <!-- Fin de Cabecera (Hero) -->
      <!--? Inicio Área del Blog -->
      <section class="blog_area single-post-area section-padding">
         <div class="container">
            <div class="row">
               <div class="col-lg-8 posts-list">
                  <?php
                  if ( have_posts() ) :
                     while ( have_posts() ) : the_post();
                  ?>
                  <div class="single-post">
                     <div class="feature-img text-center">
                        <?php if (has_post_thumbnail()) {
                           the_post_thumbnail('large', ['class' => 'img-fluid', 'style' => 'width: 100%; max-height: 400px; object-fit: cover; border-radius: 12px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); margin-bottom: 30px;']);
                        } ?>
                     </div>
                     <div class="blog_details">
                        <h2 style="color: #2d2d2d;"><?php the_title(); ?></h2>
                        <ul class="blog-info-link mt-3 mb-4">
                           <li><a href="#"><i class="fa fa-user"></i> Written by: <?php echo get_the_author(); ?></a></li>
                           <li><a href="#"><i class="fa fa-calendar"></i> <?php echo get_the_date(); ?></a></li>
                        </ul>
                        
                        <!-- Post Content -->
                        <div class="content">
                           <?php the_content(); ?>
                        </div>
                     </div>
                  </div>
                  <?php endwhile; endif; ?>
                  
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
