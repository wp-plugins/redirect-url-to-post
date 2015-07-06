<?php

/*
  Plugin Name: Redirect URL to Post
  Plugin URI:  http://www.christoph-amthor.de/software/redirect-url-post/
  Description: Redirects to a post based on parameters in the URL
  Author: Christoph Amthor
  Author URI: http://www.christoph-amthor.de/
  Version: 0.3.1
  License: GNU GENERAL PUBLIC LICENSE, Version 3
  Text Domain: redirect-url-to-post
 */


/**
 * 	Initial setup: Register the filter and action
 *
 */
add_action( 'send_headers', 'rurl2p_redirect_post' );

if ( is_admin() ) {

    add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'add_help_link', 10 );
}


/**
 * 	Does the actual work
 *
 */
function rurl2p_redirect_post()
{

    // Prevent being triggered again when executing the query
    if ( did_action( 'parse_query' ) === 0 ) {

        // Retrieve search criteria from GET query
        // Use sanitized $_GET to be independent from current state of WP Query and possible unavailability of GET parameters.
        if ( !empty( $_GET['redirect_to'] ) ) {

            $redirect_to = sanitize_key( $_GET['redirect_to'] );

            // Set default args		
            $args_query_values = array(
                'posts_per_page' => 1,
                'order' => 'DESC',
                'post_type' => 'post'
            );


            // Get standard parameters that make sense to use
            $args_default_values = array(
                'cat', // strangely 'category' not working
                'category_name',
                'day',
                'hour',
                'minute',
                'monthnum',
                'order',
                'orderby',
                'post_type', // requires has_archive for that post_type
                's',
                'second',
                'tag',
                'w',
                'author',
                'author_name',
                'has_password',
                'tag_id'
            );

            foreach ( $args_default_values as $value ) {

                if ( isset( $_GET[$value] ) ) {

                    // values sanitized by WP
                    $args_query_values[$value] = sanitize_key( $_GET[$value] );
                }
            }

            // Set up the search query depending on the criteria
            switch ( $redirect_to ) {

                // Show the latest post
                case 'latest':
                case 'last':

                    $args_add = array(
                        'orderby' => 'date',
                        'order' => 'DESC',
                    );

                    break;

                // Show the oldest post
                case 'oldest':
                case 'first':

                    $args_add = array(
                        'orderby' => 'date',
                        'order' => 'ASC',
                    );

                    break;

                // Show a random post
                case 'random':

                    $args_add = array(
                        'orderby' => 'rand'
                    );

                    break;

                // find a post based on orderby (and order)
                case 'custom':

                    if ( empty( $args_query_values['orderby'] ) ) {

                        _e( "Error: The parameter 'custom' requires also 'orderby'", "redirect-url-to-post" );

                        exit;
                    }


                    // Check order parameter
                    $order_whitelist = array(
                        'ASC',
                        'DESC'
                    );

                    if ( !in_array( $args_query_values['order'], $order_whitelist ) ) {

                        _e( "Error: Unrecognized value of parameter 'order'", "redirect-url-to-post" );

                        exit;
                    }

                    // Check orderby parameter
                    $orderby_whitelist = array(
                        'author',
                        'comment_count',
                        'date',
                        'ID',
                        'menu_order',
                        'modified',
                        'name',
                        'none',
                        'parent',
                        'rand',
                        'title',
                        'type',
                    );

                    if ( !in_array( $args_query_values['orderby'], $orderby_whitelist ) ) {

                        _e( "Error: Unrecognized value of parameter 'orderby'", "redirect-url-to-post" );

                        exit;
                    }

                    $args_add = array();

                    break;

                // Unrecognized value of 'redirect_to' => finish processing and let other plugins do their work
                default:

                    return;

                    break;
            }

            // Retrieve the first post and redirect to its permalink
            if ( isset( $args_add ) ) {

                $args = array_merge( $args_query_values, $args_add );

                $posts = get_posts( $args );

                if ( !empty( $posts ) ) {

                    $post = array_shift( $posts );

                    $permalink = get_permalink( $post );

                    wp_redirect( $permalink );

                    exit;
                } else {

                    // Nothing found, go to post with id as specified by redirect_to_default, or home

                    if ( isset( $_GET['default_redirect_to'] ) ) {
                        $default_redirect_to = sanitize_key( $_GET['default_redirect_to'] );
                    }

                    if ( empty( $default_redirect_to ) ) {

                        // no default given => go to home page
                        wp_redirect( site_url() );
                    } else {

                        $permalink = get_permalink( $default_redirect_to );

                        if ( $permalink === FALSE ) {

                            // default post or page does not exist => go to home page
                            wp_redirect( site_url() );
                        } else {

                            wp_redirect( $permalink );
                        }
                    }

                    exit;
                }
            }
        }
    }

}


/**
 * Add Help link to plugins page
 */
function add_help_link( $links )
{

    $settings_link = '<a href="http://www.christoph-amthor.de/software/redirect-url-post/" target="_blank">' . __( "Help", "redirect-url-to-post" ) . '</a>';

    array_unshift( $links, $settings_link );

    return $links;

}
