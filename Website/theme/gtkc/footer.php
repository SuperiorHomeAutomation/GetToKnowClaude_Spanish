<?php
// Email signup band appears on every page except the signup confirmation
$show_signup = ! isset( $_GET['subscribed'] );
?>

<?php if ( $show_signup ) : ?>
<!-- ── Email Signup Band ───────────────────────── -->
<section class="signup-band" id="stay-informed">
  <div class="container">
    <div class="signup-band__inner">

      <div class="signup-band__copy">
        <h2 class="signup-band__heading">Stay in the loop</h2>
        <p class="signup-band__desc">
          Get notified when new articles are published or when errata updates are posted for
          <em>Get to Know Claude</em>. No spam. Unsubscribe any time.
        </p>
      </div>

      <form class="signup-form" id="gtkc-signup-form" novalidate>
        <?php wp_nonce_field( 'gtkc_signup_nonce', 'gtkc_nonce_field' ); ?>

        <label for="signup-name">Your Name</label>
        <input type="text" id="signup-name" name="name" placeholder="First name" autocomplete="given-name">

        <label for="signup-email">Email Address *</label>
        <input type="email" id="signup-email" name="email" placeholder="you@example.com" required autocomplete="email">

        <div class="signup-form__checkboxes">
          <p>Notify me about</p>
          <label class="signup-form__check">
            <input type="checkbox" name="prefs[]" value="articles" checked>
            <span>New articles</span>
          </label>
          <label class="signup-form__check">
            <input type="checkbox" name="prefs[]" value="errata">
            <span>Book errata (corrections)</span>
          </label>
        </div>

        <button type="submit" class="btn btn--primary">Subscribe — it's free</button>
        <div class="form-message form-message--success" id="signup-success"></div>
        <div class="form-message form-message--error" id="signup-error"></div>
      </form>

    </div>
  </div>
</section>
<?php endif; ?>

<!-- ── Upcoming Books ─────────────────────────── -->
<section class="section section--alt">
  <div class="container">
    <div class="section-heading">
      <span class="section-heading__label">Coming Soon</span>
      <h2 class="section-heading__title">More Books from Parmod K. Gandhi</h2>
      <p class="section-heading__desc">Two new titles in development. Sign up above to be among the first to know when they launch.</p>
    </div>

    <div class="upcoming-books">

      <div class="upcoming-book">
        <div class="upcoming-book__cover">
          <?php
          $windows_cover = get_template_directory_uri() . '/images/done-with-windows-cover.jpg';
          ?>
          <span>Done with Windows</span>
        </div>
        <div class="upcoming-book__body">
          <span class="upcoming-book__badge">Coming Soon</span>
          <h3 class="upcoming-book__title">Done with Windows</h3>
          <p class="upcoming-book__desc">
            A plain-language guide for everyday users who are ready to leave Windows behind and move to Linux —
            without losing their files, their habits, or their sanity.
          </p>
        </div>
      </div>

      <div class="upcoming-book">
        <div class="upcoming-book__cover">
          <span>Let's Make a Gadget</span>
        </div>
        <div class="upcoming-book__body">
          <span class="upcoming-book__badge">Coming Soon</span>
          <h3 class="upcoming-book__title">Let's Make a Gadget</h3>
          <p class="upcoming-book__desc">
            Build real hardware projects with Claude as your guide. From circuit design to 3D-printed enclosures —
            no engineering degree required.
          </p>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- ── Site Footer ───────────────────────────────── -->
<footer class="site-footer">
  <div class="container">
    <div class="site-footer__grid">

      <div class="site-footer__brand">
        <span class="site-logo__name">Get To Know Claude</span>
        <p>
          A beginner's guide to Claude AI — your new thinking partner.
          Published by Superior Home Automation Corp., Port Colborne, Ontario, Canada.
        </p>
      </div>

      <div class="site-footer__col">
        <h4>Site</h4>
        <ul>
          <li><a href="<?php echo home_url('/'); ?>">Home</a></li>
          <li><a href="<?php echo home_url('/articles'); ?>">Articles</a></li>
          <li><a href="<?php echo home_url('/errata'); ?>">Errata</a></li>
          <li><a href="<?php echo home_url('/about'); ?>">About</a></li>
          <li><a href="<?php echo home_url('/coming-soon'); ?>">Coming Soon</a></li>
        </ul>
      </div>

      <div class="site-footer__col">
        <h4>Info</h4>
        <ul>
          <li><a href="<?php echo home_url('/privacy-policy'); ?>">Privacy Policy</a></li>
          <li><a href="<?php echo home_url('/errata'); ?>">Book Errata</a></li>
          <li><a href="#stay-informed">Subscribe</a></li>
          <li><a href="https://www.amazon.com" target="_blank" rel="noopener">Buy on Kindle ↗</a></li>
        </ul>
      </div>

    </div>

    <div class="site-footer__bottom">
      <p class="site-footer__copy">
        &copy; <?php echo date('Y'); ?> Superior Home Automation Corp. All rights reserved.
        &nbsp;·&nbsp; GetToKnowClaude.com
        &nbsp;·&nbsp; Claude is a trademark of Anthropic, PBC. This site is not affiliated with or endorsed by Anthropic.
      </p>
      <nav class="site-footer__legal" aria-label="Legal">
        <a href="<?php echo home_url('/privacy-policy'); ?>">Privacy Policy</a>
        <a href="<?php echo home_url('/errata'); ?>">Errata</a>
      </nav>
    </div>

  </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
