<?php
/**
 * OnePress Child Theme Functions
 *
 */

/**
 * Enqueue child theme style
 */
add_action( 'wp_enqueue_scripts', 'onepress_child_enqueue_styles', 15 );
function onepress_child_enqueue_styles() {
    wp_enqueue_style( 'onepress-child-style', get_stylesheet_directory_uri() . '/style.css' );
}

/**
 * Hook to add custom section after about section
 *
 * @see wp-content/themes/onepress/template-frontpage.php
 */
function add_newsletter_section(){
    $newsletter_page = get_page_by_title('Newsletter', OBJECT, 'page');
    ?>
    <section id="newsletter" class="section-newsletter section-padding onepage-section">
        <div class="container">
            <div class="section-title-area">
                <h2 class="section-title"><?php echo apply_filters( 'the_title', $newsletter_page->post_title ); ?></h2>
            </div>
            <div class="row">
                <!-- Copied from the about section's HTML code -->
                <div class="col-lg-12 col-sm-12  wow slideInUp" style="visibility: visible; animation-name: slideInUp;">
                    <?php echo apply_filters( 'the_content', $newsletter_page->post_content ); ?>
                </div>
            </div>
        </div>
    </section>
    <?php
}
add_action( 'onepress_after_section_about', 'add_newsletter_section' );

/**
 * Hook to add custom section after team section
 *
 * @see wp-content/themes/onepress/template-frontpage.php
 */
function add_contact_section(){
    $kontakt_page = get_page_by_title('Kontakt', OBJECT, 'page');
    ?>
    <section id="kontakt" class="section-kontakt section-padding onepage-section">
        <div class="container">
            <div class="section-title-area">
                <h2 class="section-title"><?php echo apply_filters( 'the_title', $kontakt_page->post_title ); ?></h2>
            </div>
            <div class="row">
                <!-- Copied from the about section's HTML code -->
                <div class="col-lg-12 col-sm-12  wow slideInUp" style="visibility: visible; animation-name: slideInUp;">
                <?php echo apply_filters( 'the_content', $kontakt_page->post_content ); ?>
                </div>
            </div>
        </div>
    </section>
    <?php
}
add_action( 'onepress_after_section_team', 'add_contact_section' );

/**
 * Hook to add custom section after team section
 *
 * @see wp-content/themes/onepress/template-frontpage.php
 */
function add_donations_section(){
    $donations_page = get_page_by_title('Spenden', OBJECT, 'page');
    ?>
    <section id="donations" class="section-donations section-padding onepage-section">
        <div class="container">
            <div class="section-title-area">
                <h2 class="section-title"><?php echo apply_filters( 'the_title', $donations_page->post_title ); ?></h2>
            </div>
            <div class="row">
                <!-- Copied from the about section's HTML code -->
                <div class="col-lg-12 col-sm-12  wow slideInUp" style="visibility: visible; animation-name: slideInUp;">
                    <?php echo apply_filters( 'the_content', $donations_page->post_content ); ?>
                </div>
            </div>
        </div>
    </section>
    <?php
}
add_action( 'onepress_after_section_team', 'add_donations_section' );

/*
 Footer menu for administrative links.
 Source: https://lorepirri.com/onepress-wp-theme-add-footer-menu.html
 Code:   https://gist.github.com/lorepirri/e887aa37a060a7d2691b3c2cc730c8dc
*/

function wp_custom_new_menu() {
    // Add two menus: this theme uses wp_nav_menu() in two locations.  
    register_nav_menus( array(  
      'primary' => __( 'Primary Navigation', 'onepress-child' ),  
      'secondary' => __('Secondary Navigation', 'onepress-child')  
    ) );   
}
add_action( 'init', 'wp_custom_new_menu' );

// Customize the footer area (show also the secondary menu)
if ( ! function_exists( 'onepress_footer_site_info' ) ) {
    /**
    * Add Copyright and Credit text to footer
    * @since 1.1.3
    */
    function onepress_footer_site_info()
    {
     ?>
     
     <!-- shows our custom menu -->
     <?php if( has_nav_menu( 'secondary', 'onepress-child' ) ) {
         ?> <div class="footer-menu-container"> <?php
         wp_nav_menu( array( 'theme_location' => 'secondary' ) );
         ?> </div> <?php
     } ?>
     <!-- end: shows our custom menu -->

     <?php printf(esc_html__('Copyright %1$s %2$s %3$s', 'onepress'), '&copy;', esc_attr(date('Y')), esc_attr(get_bloginfo())); ?>
     <span class="sep"> &ndash; </span>
     <?php printf(esc_html__('%1$s theme by %2$s', 'onepress'), '<a href="' . esc_url('https://www.famethemes.com/themes/onepress', 'onepress') . '">OnePress</a>', 'FameThemes'); ?>
     <?php
    }
}
