<?php get_header(); ?>

<section class="page-hero">
  <div class="container">
    <p class="page-hero__label">From the Site</p>
    <h1 class="page-hero__title">Articles</h1>
    <p class="page-hero__desc">
      Original articles expanding on the topics in <em>Get to Know Claude</em>.
      Free to read — no account needed.
    </p>
  </div>
</section>

<section class="section">
  <div class="container">

    <?php if ( have_posts() ) : ?>
      <div class="articles-grid">
        <?php while ( have_posts() ) : the_post();
          $terms = get_the_terms( get_the_ID(), 'article_category' );
          $tag   = $terms ? $terms[0]->name : 'Article';
        ?>
          <article class="article-card">
            <div class="article-card__body">
              <span class="article-card__tag"><?php echo esc_html($tag); ?></span>
              <h2 class="article-card__title">
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
              </h2>
              <p class="article-card__excerpt"><?php echo wp_trim_words( get_the_excerpt(), 28 ); ?></p>
              <div class="article-card__meta">
                <span><?php echo get_the_date('M j, Y'); ?></span>
              </div>
              <a href="<?php the_permalink(); ?>" class="article-card__read-more" style="margin-top:14px;display:inline-flex;">Read article →</a>
            </div>
          </article>
        <?php endwhile; ?>
      </div>

      <div style="margin-top:48px;">
        <?php the_posts_pagination([ 'prev_text' => '← Older', 'next_text' => 'Newer →' ]); ?>
      </div>

    <?php else : ?>
      <div style="text-align:center;padding:80px 0;">
        <h3 style="font-size:1.4rem;margin-bottom:8px;">Articles coming soon</h3>
        <p style="color:var(--ink-light);margin-bottom:28px;">Sign up below to be notified when the first article is published.</p>
        <a href="#stay-informed" class="btn btn--primary">Get notified</a>
      </div>
    <?php endif; ?>

  </div>
</section>

<?php get_footer(); ?>
