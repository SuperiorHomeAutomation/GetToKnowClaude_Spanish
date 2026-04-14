<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="<?php bloginfo('description'); ?>">
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="site-header">
  <div class="container">
    <div class="site-header__inner">

      <a href="<?php echo home_url('/'); ?>" class="site-logo" aria-label="Get To Know Claude — Home">
        <span class="site-logo__name">Get To Know Claude</span>
        <span class="site-logo__sub">Your AI Thinking Partner</span>
      </a>

      <button class="hamburger" aria-label="Toggle menu" onclick="document.querySelector('.site-nav').classList.toggle('open')">
        <svg width="22" height="22" viewBox="0 0 22 22" fill="none">
          <rect y="3" width="22" height="2.2" rx="1.1" fill="currentColor"/>
          <rect y="10" width="22" height="2.2" rx="1.1" fill="currentColor"/>
          <rect y="17" width="22" height="2.2" rx="1.1" fill="currentColor"/>
        </svg>
      </button>

      <nav class="site-nav" role="navigation" aria-label="Primary navigation">
        <a href="<?php echo home_url('/'); ?>" <?php echo is_front_page() ? 'class="current"' : ''; ?>>Home</a>
        <a href="<?php echo home_url('/articles'); ?>" <?php echo is_post_type_archive('gtkc_article') ? 'class="current"' : ''; ?>>Articles</a>
        <a href="<?php echo home_url('/errata'); ?>" <?php echo is_post_type_archive('gtkc_errata') ? 'class="current"' : ''; ?>>Errata</a>
        <a href="<?php echo home_url('/about'); ?>" <?php echo is_page('about') ? 'class="current"' : ''; ?>>About</a>
        <a href="<?php echo home_url('/coming-soon'); ?>" <?php echo is_page('coming-soon') ? 'class="current"' : ''; ?>>Coming Soon</a>
        <a href="https://www.amazon.com" target="_blank" rel="noopener" class="btn-nav">
          Buy on Kindle ↗
        </a>
      </nav>

    </div>
  </div>
</header>
