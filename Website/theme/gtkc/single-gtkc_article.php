<?php get_header(); ?>

<?php while ( have_posts() ) : the_post();
  $terms = get_the_terms( get_the_ID(), 'article_category' );
  $tag   = $terms ? $terms[0]->name : 'Article';
?>

<section class="article-header">
  <div class="container">
    <p class="article-header__tag"><?php echo esc_html($tag); ?></p>
    <h1 class="article-header__title"><?php the_title(); ?></h1>
    <p class="article-header__meta">
      By <?php the_author(); ?> &nbsp;·&nbsp; <?php echo get_the_date('F j, Y'); ?>
    </p>
  </div>
</section>

<section class="article-body">
  <div class="container container--text">
    <div class="prose">
      <?php the_content(); ?>
    </div>

    <div style="margin-top:56px;padding-top:36px;border-top:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:16px;">
      <a href="<?php echo home_url('/articles'); ?>" style="font-family:var(--font-ui);font-size:0.88rem;color:var(--ink-light);">← All Articles</a>
      <a href="#stay-informed" class="btn btn--teal" style="font-size:0.85rem;padding:10px 20px;">Get notified of new articles</a>
    </div>
  </div>
</section>

<?php endwhile; ?>

<?php get_footer(); ?>
