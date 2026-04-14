<?php get_header(); ?>

<!-- ══ HERO ══════════════════════════════════════════════════ -->
<section class="hero">
  <div class="container">
    <div class="hero__inner">

      <div class="hero__copy">
        <p class="hero__eyebrow">New Book — Now on Kindle</p>
        <h1 class="hero__title">Get to Know Claude</h1>
        <p class="hero__subtitle">Your AI Thinking Partner</p>
        <p class="hero__tagline">No Technical Mumbo Jumbo &nbsp;·&nbsp; No Learning Required</p>
        <p class="hero__desc">
          The plain-language guide to Claude AI for everyday people.
          Whether you want to write better, learn faster, run your business smarter,
          or simply understand what all the fuss is about — this is the book that meets you where you are.
        </p>
        <div class="hero__actions">
          <a href="https://www.amazon.com" target="_blank" rel="noopener" class="btn btn--primary">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 2L2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5"/><path d="M2 12l10 5 10-5"/></svg>
            Buy on Kindle
          </a>
          <a href="<?php echo home_url('/about'); ?>" class="btn btn--outline">About the Book</a>
        </div>
      </div>

      <div class="hero__book-cover" aria-hidden="true">
        <?php
        $cover = get_template_directory_uri() . '/images/book-cover.jpg';
        if ( file_exists( get_template_directory() . '/images/book-cover.jpg' ) ) : ?>
          <img src="<?php echo esc_url($cover); ?>" alt="Get to Know Claude book cover" width="280">
        <?php else : ?>
          <div class="hero__book-placeholder">
            <span class="book-title">Get to Know Claude</span>
            <span class="book-subtitle">Your AI Thinking Partner</span>
            <span class="book-author">Parmod K. Gandhi</span>
          </div>
        <?php endif; ?>
      </div>

    </div>
  </div>
</section>

<!-- ══ WHAT'S INSIDE ═════════════════════════════════════════ -->
<section class="section">
  <div class="container">
    <div class="section-heading">
      <span class="section-heading__label">12 Chapters</span>
      <h2 class="section-heading__title">What's Inside the Book</h2>
      <p class="section-heading__desc">
        From your very first conversation to running your business with AI —
        every chapter is written for real people, not technical experts.
      </p>
    </div>

    <div class="chapters-grid">
      <?php
      $chapters = [
        [ 1,  'Hello, Claude',                           'What Claude is, where it came from, and why it earns your trust.' ],
        [ 2,  'How Claude Works',                        'The context window, memory, and how to get started for free.' ],
        [ 3,  'How to Ask Claude Well',                  'You are the conductor. Learn how to get the best from every conversation.' ],
        [ 4,  'Cowork — Claude Gets to Work',            'Move from conversation to action. Claude organizes files, builds documents, and works while you step away.' ],
        [ 5,  'Writing — Blogs, Essays, Books',          'The book inside you deserves to exist. Claude helps you write it.' ],
        [ 6,  '3D Design',                               'Describe an object. Claude writes the code. You press Print.' ],
        [ 7,  'Your Website and Beyond',                 'From a blank screen to a professional website in one conversation.' ],
        [ 8,  'Health, Finance, and When You Need a Friend', 'The knowledgeable friend everyone deserves but few have.' ],
        [ 9,  'Medical Care When You Can\'t Afford It',  'A thinking partner for the moments between appointments.' ],
        [ 10, 'Learn Anything',                          'The teacher who starts where you are and never makes you feel foolish.' ],
        [ 11, 'Claude and Your Business',                'Turn a brilliant builder into a complete business.' ],
        [ 12, 'Claude and Your Future',                  'Where we are, what comes next, and what it means for you.' ],
      ];
      foreach ( $chapters as [ $num, $title, $desc ] ) : ?>
        <div class="chapter-card">
          <p class="chapter-card__num">Chapter <?php echo $num; ?></p>
          <h3 class="chapter-card__title"><?php echo esc_html($title); ?></h3>
          <p style="font-size:0.85rem;color:#666;margin-top:8px;line-height:1.6;"><?php echo esc_html($desc); ?></p>
        </div>
      <?php endforeach; ?>
    </div>

    <div style="text-align:center;margin-top:40px;">
      <a href="https://www.amazon.com" target="_blank" rel="noopener" class="btn btn--primary">Get the Full Book on Kindle</a>
    </div>
  </div>
</section>

<!-- ══ LATEST ARTICLES ═══════════════════════════════════════ -->
<?php
$articles = new WP_Query([
  'post_type'      => 'gtkc_article',
  'posts_per_page' => 3,
  'post_status'    => 'publish',
]);

if ( $articles->have_posts() ) : ?>
<section class="section section--alt">
  <div class="container">
    <div class="section-heading">
      <span class="section-heading__label">From the Site</span>
      <h2 class="section-heading__title">Latest Articles</h2>
      <p class="section-heading__desc">New articles expanding on the book's topics — free to read, no account needed.</p>
    </div>

    <div class="articles-grid">
      <?php while ( $articles->have_posts() ) : $articles->the_post();
        $terms = get_the_terms( get_the_ID(), 'article_category' );
        $tag   = $terms ? $terms[0]->name : 'Article';
      ?>
        <article class="article-card">
          <div class="article-card__body">
            <span class="article-card__tag"><?php echo esc_html($tag); ?></span>
            <h3 class="article-card__title">
              <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            </h3>
            <p class="article-card__excerpt"><?php echo wp_trim_words( get_the_excerpt(), 24 ); ?></p>
            <div class="article-card__meta">
              <span><?php echo get_the_date('M j, Y'); ?></span>
            </div>
            <a href="<?php the_permalink(); ?>" class="article-card__read-more" style="margin-top:12px;">Read article →</a>
          </div>
        </article>
      <?php endwhile; wp_reset_postdata(); ?>
    </div>

    <div style="text-align:center;margin-top:40px;">
      <a href="<?php echo home_url('/articles'); ?>" class="btn btn--teal">Browse All Articles</a>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- ══ AUTHOR QUOTE ══════════════════════════════════════════ -->
<section class="section">
  <div class="container container--text">
    <blockquote style="border-left:4px solid var(--accent);padding:24px 32px;background:var(--accent-pale);border-radius:0 12px 12px 0;font-family:var(--font-display);font-size:1.2rem;line-height:1.75;color:var(--ink);font-style:italic;">
      "For fifty years we asked humans to learn computer languages. Now computers are learning human languages.
      The direction of the burden has reversed — and that changes everything about who gets to use these tools
      and what they can accomplish with them."
      <footer style="margin-top:14px;font-family:var(--font-ui);font-size:0.82rem;font-style:normal;color:var(--ink-light);">
        — Parmod K. Gandhi, <cite>Get to Know Claude</cite>
      </footer>
    </blockquote>
  </div>
</section>

<?php get_footer(); ?>
