<?php get_header(); ?>

<section class="page-hero">
  <div class="container">
    <h1 class="page-hero__title"><?php wp_title(''); ?></h1>
  </div>
</section>

<section class="section">
  <div class="container container--text">
    <div class="prose">
      <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
        <h2><?php the_title(); ?></h2>
        <?php the_content(); ?>
      <?php endwhile; endif; ?>
    </div>
  </div>
</section>

<?php get_footer(); ?>
