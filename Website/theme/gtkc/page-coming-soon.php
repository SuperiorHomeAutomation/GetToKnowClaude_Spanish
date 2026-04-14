<?php
/* Template Name: Coming Soon */
get_header();
?>

<section class="page-hero">
  <div class="container">
    <p class="page-hero__label">What's Next</p>
    <h1 class="page-hero__title">Coming Soon</h1>
    <p class="page-hero__desc">
      Two new books from Parmod K. Gandhi are in development.
      Sign up below to be among the first to know when they launch.
    </p>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="upcoming-books" style="max-width:760px;margin:0 auto;">

      <!-- Done with Windows -->
      <div class="upcoming-book">
        <div class="upcoming-book__cover" style="max-height:320px;">
          <?php
          $cover_w = get_template_directory_uri() . '/images/done-with-windows-cover.jpg';
          if ( file_exists( get_template_directory() . '/images/done-with-windows-cover.jpg' ) ) : ?>
            <img src="<?php echo esc_url($cover_w); ?>" alt="Done with Windows book cover">
          <?php else : ?>
            <span style="font-family:var(--font-display);font-size:1.5rem;color:var(--ink);">Done with Windows</span>
          <?php endif; ?>
        </div>
        <div class="upcoming-book__body">
          <span class="upcoming-book__badge">Coming Soon</span>
          <h2 class="upcoming-book__title">Done with Windows</h2>
          <p class="upcoming-book__desc">
            Millions of people are quietly fed up with Windows — the forced updates, the privacy concerns,
            the bloatware, the constant feeling that your computer is working for Microsoft, not for you.
          </p>
          <p class="upcoming-book__desc" style="margin-top:12px;">
            <em>Done with Windows</em> is the plain-language guide for everyday users who are ready to make the move to Linux
            — without losing their files, their habits, or their sanity. Written for people who are not
            programmers, not hobbyists, and not interested in the technical details. Just people who want
            their computer to work the way they want it to.
          </p>
        </div>
      </div>

      <!-- Let's Make a Gadget -->
      <div class="upcoming-book">
        <div class="upcoming-book__cover" style="max-height:320px;">
          <?php
          $cover_g = get_template_directory_uri() . '/images/lets-make-a-gadget-cover.jpg';
          if ( file_exists( get_template_directory() . '/images/lets-make-a-gadget-cover.jpg' ) ) : ?>
            <img src="<?php echo esc_url($cover_g); ?>" alt="Let's Make a Gadget book cover">
          <?php else : ?>
            <span style="font-family:var(--font-display);font-size:1.5rem;color:var(--ink);">Let's Make a Gadget</span>
          <?php endif; ?>
        </div>
        <div class="upcoming-book__body">
          <span class="upcoming-book__badge">Coming Soon</span>
          <h2 class="upcoming-book__title">Let's Make a Gadget</h2>
          <p class="upcoming-book__desc">
            You have an idea for something. A device that solves a problem. A tool that doesn't exist yet.
            A project that's been sitting in your head for years because you assumed you'd need an engineering
            degree to build it.
          </p>
          <p class="upcoming-book__desc" style="margin-top:12px;">
            <em>Let's Make a Gadget</em> walks you through the entire process of designing and building real hardware —
            from concept to circuit to 3D-printed enclosure — with Claude as your guide at every step.
            No engineering degree. No prior electronics experience. Just a clear idea and the willingness to try.
          </p>
        </div>
      </div>

    </div>

    <div style="text-align:center;margin-top:56px;padding:40px;background:var(--paper-warm);border-radius:var(--radius-lg);max-width:560px;margin-left:auto;margin-right:auto;">
      <h3 style="font-size:1.4rem;margin-bottom:10px;">Be the first to know</h3>
      <p style="color:var(--ink-light);margin-bottom:24px;font-size:0.95rem;">
        Subscribe to updates and we'll notify you as soon as either book is available.
      </p>
      <a href="#stay-informed" class="btn btn--primary">Subscribe for Updates</a>
    </div>

  </div>
</section>

<?php get_footer(); ?>
