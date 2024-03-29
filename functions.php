<?php
/**
 * General Wordpress Theme Functions
 */

// Gutenberg custom stylesheet
add_theme_support( 'editor-styles' );
add_editor_style( 'editor-style.css' );

/**
 * Rewrite the default "author" slug in paths.
 * It is blocked by WP-Cerber anyways and will return 404.
 */
function new_author_base() {
    global $wp_rewrite;
    $wp_rewrite->author_base = 'team';
}
add_action('init', 'new_author_base');

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
    add_page_as_section('Newsletter', 'newsletter');
}
add_action( 'onepress_after_section_about', 'add_newsletter_section' );

/**
 * Hook to add custom section after services section
 *
 * @see wp-content/themes/onepress/template-frontpage.php
 */
function add_donations_section(){
    add_page_as_section('Spenden', 'donations');
}
add_action( 'onepress_after_section_services', 'add_donations_section' );

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

/**
* Helper function to turn a single page into a OnePress section.
*/
function add_page_as_section(string $page_title, string $section_id) {
    $page = get_page_by_title($page_title, OBJECT, 'page');
    echo '    <section id="' . $section_id .'" class="section-' . $section_id .' section-padding onepage-section">';
    ?>
        <div class="container">
            <div class="section-title-area">
                <h2 class="section-title"><?php echo apply_filters( 'the_title', $page->post_title ); ?></h2>
            </div>
            <div class="row">
                <!-- Copied from the about section's HTML code -->
                <div class="col-lg-12 col-sm-12  wow slideInUp" style="visibility: visible; animation-name: slideInUp;">
                    <?php echo apply_filters( 'the_content', $page->post_content ); ?>
                </div>
            </div>
        </div>
    </section>
    <?php
}