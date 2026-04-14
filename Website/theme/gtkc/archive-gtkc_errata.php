<?php get_header(); ?>

<section class="page-hero">
  <div class="container">
    <p class="page-hero__label">Book Corrections</p>
    <h1 class="page-hero__title">Errata</h1>
    <p class="page-hero__desc">
      Corrections to <em>Get to Know Claude</em>, organized by chapter.
      Updated as errors are found and verified.
    </p>
  </div>
</section>

<section class="section">
  <div class="container container--text">

    <div class="notice notice--info" style="margin-bottom:36px;">
      <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0;margin-top:2px;"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
      <span>
        Found an error not listed here? Please use the contact information on the
        <a href="<?php echo home_url('/about'); ?>">About page</a> to let us know.
        We appreciate every reader who takes the time to report corrections.
      </span>
    </div>

    <?php if ( have_posts() ) : ?>

      <?php
      // Group errata by chapter (using the title field which should start with "Chapter N")
      $errata_by_chapter = [];
      while ( have_posts() ) : the_post();
        $chapter = get_post_meta( get_the_ID(), 'chapter', true ) ?: 'General';
        $errata_by_chapter[ $chapter ][] = [
          'id'        => get_the_ID(),
          'title'     => get_the_title(),
          'content'   => get_the_content(),
          'original'  => get_post_meta( get_the_ID(), 'original_text', true ),
          'corrected' => get_post_meta( get_the_ID(), 'corrected_text', true ),
          'page'      => get_post_meta( get_the_ID(), 'page_number', true ),
          'date'      => get_the_date('M j, Y'),
        ];
      endwhile;
      ksort( $errata_by_chapter );
      ?>

      <?php foreach ( $errata_by_chapter as $chapter => $items ) : ?>
        <div class="errata-chapter">
          <div class="errata-chapter__header">
            <div>
              <p class="errata-chapter__num">Correction</p>
              <h3 class="errata-chapter__title"><?php echo esc_html($chapter); ?></h3>
            </div>
            <span class="errata-chapter__count"><?php echo count($items); ?> item<?php echo count($items) !== 1 ? 's' : ''; ?></span>
          </div>

          <?php foreach ( $items as $item ) : ?>
            <div class="errata-item">
              <p class="errata-item__page">
                <?php echo $item['page'] ? 'p. ' . esc_html($item['page']) : 'General'; ?>
                <br><small style="color:#bbb;"><?php echo esc_html($item['date']); ?></small>
              </p>
              <div class="errata-item__text">
                <strong><?php echo esc_html($item['title']); ?></strong>
                <?php if ( $item['original'] ) : ?>
                  <div style="margin-top:10px;">
                    <span class="errata-item__original"><?php echo esc_html($item['original']); ?></span>
                    <br>
                    <span class="errata-item__corrected"><?php echo esc_html($item['corrected']); ?></span>
                  </div>
                <?php endif; ?>
                <?php if ( $item['content'] ) : ?>
                  <p style="margin-top:8px;font-size:0.88rem;"><?php echo wp_kses_post($item['content']); ?></p>
                <?php endif; ?>
              </div>
            </div>
          <?php endforeach; ?>

        </div>
      <?php endforeach; ?>

    <?php else : ?>
      <div style="text-align:center;padding:64px 0;">
        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#27ae60" stroke-width="1.5" style="margin:0 auto 16px;display:block;"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
        <h3 style="font-size:1.4rem;margin-bottom:8px;">No errata at this time</h3>
        <p style="color:var(--ink-light);">No corrections have been posted yet. This page will be updated as needed.</p>
      </div>
    <?php endif; ?>

  </div>
</section>

<?php get_footer(); ?>
