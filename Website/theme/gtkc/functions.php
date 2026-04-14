<?php
/**
 * Get To Know Claude — Theme Functions
 */

// ── Theme Setup ──────────────────────────────────────────────
function gtkc_setup() {
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'html5', [ 'search-form', 'comment-form', 'gallery', 'caption' ] );
    add_theme_support( 'custom-logo' );

    register_nav_menus( [
        'primary' => __( 'Primary Menu', 'gtkc' ),
        'footer'  => __( 'Footer Menu', 'gtkc' ),
    ] );

    // Custom post type: Articles
    register_post_type( 'gtkc_article', [
        'labels' => [
            'name'               => 'Articles',
            'singular_name'      => 'Article',
            'add_new_item'       => 'Add New Article',
            'edit_item'          => 'Edit Article',
            'new_item'           => 'New Article',
            'view_item'          => 'View Article',
            'search_items'       => 'Search Articles',
            'not_found'          => 'No articles found',
        ],
        'public'      => true,
        'has_archive' => true,
        'supports'    => [ 'title', 'editor', 'excerpt', 'thumbnail', 'author' ],
        'menu_icon'   => 'dashicons-text-page',
        'rewrite'     => [ 'slug' => 'articles' ],
        'show_in_rest' => true,
    ] );

    // Custom post type: Errata
    register_post_type( 'gtkc_errata', [
        'labels' => [
            'name'          => 'Errata',
            'singular_name' => 'Erratum',
            'add_new_item'  => 'Add New Erratum',
            'edit_item'     => 'Edit Erratum',
        ],
        'public'      => true,
        'has_archive' => true,
        'supports'    => [ 'title', 'editor', 'custom-fields' ],
        'menu_icon'   => 'dashicons-edit',
        'rewrite'     => [ 'slug' => 'errata' ],
        'show_in_rest' => true,
    ] );

    // Taxonomy: Article Category
    register_taxonomy( 'article_category', 'gtkc_article', [
        'labels'       => [ 'name' => 'Categories', 'singular_name' => 'Category' ],
        'hierarchical' => true,
        'show_in_rest' => true,
        'rewrite'      => [ 'slug' => 'article-category' ],
    ] );
}
add_action( 'after_setup_theme', 'gtkc_setup' );

// ── Enqueue Assets ───────────────────────────────────────────
function gtkc_enqueue() {
    $ver = wp_get_theme()->get( 'Version' );

    // Google Fonts
    wp_enqueue_style( 'gtkc-fonts',
        'https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;1,400&family=Source+Serif+4:ital,wght@0,400;0,600;1,400&family=DM+Sans:wght@400;500;600&family=JetBrains+Mono:wght@400&display=swap',
        [], null );

    wp_enqueue_style( 'gtkc-style', get_stylesheet_uri(), [ 'gtkc-fonts' ], $ver );
    wp_enqueue_script( 'gtkc-main', get_template_directory_uri() . '/js/main.js', [], $ver, true );

    wp_localize_script( 'gtkc-main', 'gtkcAjax', [
        'ajaxurl' => admin_url( 'admin-ajax.php' ),
        'nonce'   => wp_create_nonce( 'gtkc_signup_nonce' ),
    ] );
}
add_action( 'wp_enqueue_scripts', 'gtkc_enqueue' );

// ── Email Signup Handler ─────────────────────────────────────
function gtkc_handle_signup() {
    check_ajax_referer( 'gtkc_signup_nonce', 'nonce' );

    $name  = sanitize_text_field( $_POST['name'] ?? '' );
    $email = sanitize_email( $_POST['email'] ?? '' );
    $prefs = array_map( 'sanitize_text_field', (array) ( $_POST['prefs'] ?? [] ) );

    if ( empty( $email ) || ! is_email( $email ) ) {
        wp_send_json_error( [ 'message' => 'Please enter a valid email address.' ] );
    }

    // Check for existing subscriber
    $existing = get_option( 'gtkc_subscribers', [] );
    foreach ( $existing as $sub ) {
        if ( $sub['email'] === $email ) {
            wp_send_json_error( [ 'message' => 'This email is already subscribed.' ] );
        }
    }

    // Generate verification token
    $token = wp_generate_password( 32, false );

    // Store pending subscriber
    $pending = get_option( 'gtkc_pending_subscribers', [] );
    $pending[ $token ] = [
        'name'       => $name,
        'email'      => $email,
        'prefs'      => $prefs,
        'subscribed' => current_time( 'mysql' ),
    ];
    update_option( 'gtkc_pending_subscribers', $pending );

    // Send verification email
    $verify_url = add_query_arg( [
        'gtkc_verify' => $token,
    ], home_url() );

    $subject = 'Please confirm your subscription — Get To Know Claude';
    $body    = gtkc_email_template(
        'Confirm your subscription',
        "<p>Hi {$name},</p>
        <p>Thank you for subscribing to <strong>GetToKnowClaude.com</strong>.</p>
        <p>Click the button below to confirm your email address and activate your subscription.</p>",
        'Confirm My Email',
        $verify_url,
        '<p style=\"color:#999;font-size:12px;\">If you did not sign up for this, simply ignore this email.</p>'
    );

    $headers = [ 'Content-Type: text/html; charset=UTF-8' ];
    wp_mail( $email, $subject, $body, $headers );

    wp_send_json_success( [ 'message' => 'Thanks! Please check your inbox to confirm your email address.' ] );
}
add_action( 'wp_ajax_nopriv_gtkc_signup', 'gtkc_handle_signup' );
add_action( 'wp_ajax_gtkc_signup', 'gtkc_handle_signup' );

// ── Email Verification ───────────────────────────────────────
function gtkc_verify_email() {
    if ( ! isset( $_GET['gtkc_verify'] ) ) return;

    $token   = sanitize_text_field( $_GET['gtkc_verify'] );
    $pending = get_option( 'gtkc_pending_subscribers', [] );

    if ( ! isset( $pending[ $token ] ) ) {
        wp_die( 'This verification link is invalid or has already been used.', 'Invalid Link' );
    }

    $sub = $pending[ $token ];

    // Move to confirmed subscribers
    $subscribers   = get_option( 'gtkc_subscribers', [] );
    $subscribers[] = $sub;
    update_option( 'gtkc_subscribers', $subscribers );

    // Remove from pending
    unset( $pending[ $token ] );
    update_option( 'gtkc_pending_subscribers', $pending );

    // Send welcome email
    $subject = 'Welcome to GetToKnowClaude.com!';
    $body    = gtkc_email_template(
        'You\'re subscribed!',
        "<p>Hi {$sub['name']},</p>
        <p>Your subscription to <strong>GetToKnowClaude.com</strong> is now confirmed.</p>
        <p>You'll receive notifications when new articles or errata are published.</p>",
        'Visit the Site',
        home_url(),
        ''
    );
    wp_mail( $sub['email'], $subject, $body, [ 'Content-Type: text/html; charset=UTF-8' ] );

    wp_redirect( add_query_arg( 'subscribed', '1', home_url() ) );
    exit;
}
add_action( 'init', 'gtkc_verify_email' );

// ── Notify Subscribers on New Article/Errata ────────────────
function gtkc_notify_subscribers( $post_id, $post ) {
    if ( ! in_array( $post->post_type, [ 'gtkc_article', 'gtkc_errata' ] ) ) return;
    if ( $post->post_status !== 'publish' ) return;
    if ( get_post_meta( $post_id, '_gtkc_notified', true ) ) return;

    $is_errata   = $post->post_type === 'gtkc_errata';
    $pref_key    = $is_errata ? 'errata' : 'articles';
    $subscribers = get_option( 'gtkc_subscribers', [] );
    $post_url    = get_permalink( $post_id );
    $post_title  = get_the_title( $post_id );

    foreach ( $subscribers as $sub ) {
        if ( ! in_array( $pref_key, $sub['prefs'] ) && ! in_array( 'all', $sub['prefs'] ) ) continue;

        $type    = $is_errata ? 'errata update' : 'new article';
        $subject = "New {$type}: {$post_title} — Get To Know Claude";
        $body    = gtkc_email_template(
            $is_errata ? 'Book Errata Update' : 'New Article Published',
            "<p>Hi {$sub['name']},</p>
            <p>A new {$type} has been published on <strong>GetToKnowClaude.com</strong>:</p>
            <h3 style=\"font-family:Georgia,serif;color:#1a1a2e;\">{$post_title}</h3>",
            'Read Now',
            $post_url,
            ''
        );
        wp_mail( $sub['email'], $subject, $body, [ 'Content-Type: text/html; charset=UTF-8' ] );
    }

    update_post_meta( $post_id, '_gtkc_notified', 1 );
}
add_action( 'publish_post', 'gtkc_notify_subscribers', 10, 2 );
add_action( 'publish_gtkc_article', 'gtkc_notify_subscribers', 10, 2 );
add_action( 'publish_gtkc_errata', 'gtkc_notify_subscribers', 10, 2 );

// ── Email HTML Template ──────────────────────────────────────
function gtkc_email_template( $heading, $body_html, $btn_text, $btn_url, $footer_html ) {
    return '<!DOCTYPE html><html><head><meta charset="UTF-8"></head><body style="margin:0;padding:0;background:#f2efe8;font-family:Georgia,serif;">
    <table width="100%" cellpadding="0" cellspacing="0"><tr><td align="center" style="padding:40px 20px;">
    <table width="600" cellpadding="0" cellspacing="0" style="background:#fff;border-radius:12px;overflow:hidden;box-shadow:0 4px 24px rgba(0,0,0,0.08);">
    <tr><td style="background:#1a1a2e;padding:32px 40px;">
      <p style="font-family:Georgia,serif;font-size:20px;color:#fff;margin:0;font-weight:bold;">Get To Know Claude</p>
      <p style="font-family:sans-serif;font-size:11px;color:#e8753a;margin:4px 0 0;text-transform:uppercase;letter-spacing:2px;">Your AI Thinking Partner</p>
    </td></tr>
    <tr><td style="padding:40px;">
      <h2 style="font-family:Georgia,serif;color:#1a1a2e;margin:0 0 20px;">' . $heading . '</h2>
      <div style="font-size:16px;line-height:1.8;color:#3d3d5c;">' . $body_html . '</div>
      <div style="margin:32px 0;">
        <a href="' . esc_url( $btn_url ) . '" style="display:inline-block;background:#c8590a;color:#fff;font-family:sans-serif;font-size:15px;font-weight:600;padding:14px 28px;border-radius:99px;text-decoration:none;">' . esc_html( $btn_text ) . '</a>
      </div>
      ' . $footer_html . '
    </td></tr>
    <tr><td style="background:#f2efe8;padding:20px 40px;text-align:center;">
      <p style="font-family:sans-serif;font-size:12px;color:#999;margin:0;">© ' . date('Y') . ' Superior Home Automation Corp. · Port Colborne, Ontario, Canada</p>
      <p style="font-family:sans-serif;font-size:12px;color:#999;margin:6px 0 0;"><a href="' . home_url( '/privacy-policy' ) . '" style="color:#c8590a;">Privacy Policy</a></p>
    </td></tr>
    </table></td></tr></table></body></html>';
}

// ── Widget: Recent Articles (sidebar) ───────────────────────
function gtkc_register_sidebars() {
    register_sidebar( [
        'name'          => 'Article Sidebar',
        'id'            => 'article-sidebar',
        'before_widget' => '<div class="sidebar-widget">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="sidebar-widget__title">',
        'after_title'   => '</h4>',
    ] );
}
add_action( 'widgets_init', 'gtkc_register_sidebars' );

// ── Excerpt length ───────────────────────────────────────────
add_filter( 'excerpt_length', fn() => 28 );
add_filter( 'excerpt_more',   fn() => '…' );
