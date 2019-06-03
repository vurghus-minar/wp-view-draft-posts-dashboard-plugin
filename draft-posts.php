<?php
/**
 * Plugin Name: View Draft Posts Dashboard Plugin
 */

//Add a simple draft posts view widget to the dashboard.
function draft_posts_dashboard_widgets() {
    wp_add_dashboard_widget(
        'draft_posts_dashboard_widget', // widget slug
        'Draft Posts Widget', // title
        'view_draft_posts_dashboard_widget_function' // widget content function
    );
}
add_action( 'wp_dashboard_setup', 'draft_posts_dashboard_widgets' );

// Output the draft posts to our Dashboard Widget.
function view_draft_posts_dashboard_widget_function() {
    // Draft posts WP_Query arguments
    // Get draft posts by title in ascending order
    $args = array(
        'post_type'   => array( 'post' ),
        'post_status' => array( 'draft' ),
        'order'       => 'ASC',
        'orderby'     => 'title',
    );
    // Create custom query
    $query = new WP_Query( $args );
    ?>
    <ul>
    <?php
        // The loop
        if ( $query->have_posts() ) {
            while ( $query->have_posts() ) {
                $query->the_post();
            ?>
                <li>
                    <?php 
                        // Get draft post edit link with post title label
                        edit_post_link( get_the_title());
                    
                    ?>
                </li>
            <?php	
            }
        } else {
            // if no posts found
            ?>
                <li>No draft posts.</li>
            <?php
        }
    ?>
    </ul>
    <?php

    // restore original Post Data
    wp_reset_postdata();
}