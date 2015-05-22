<?php
/*
Plugin Name: Redirect URL to Post
Plugin URI:  http://www.christoph-amthor.de/software/redirect-url-post/
Description: Redirects to a post based on parameters in the URL
Author: Christoph Amthor
Author URI: http://www.christoph-amthor.de/
Version: 0.2
License: GNU GENERAL PUBLIC LICENSE, Version 3
Text Domain: redirect-url-to-post
*/


/**
 *	Initial setup: Register the filter and action
 *
 */

add_filter( 'query_vars', 'rurl2p_add_query_vars' );

add_action( 'parse_query', 'rurl2p_redirect_post', 1);


/**
 *	Makes WP aware of our custom GET query parameter
 *	
 */
function rurl2p_add_query_vars( $vars ) {

  $vars[] = "redirect_to";

  return $vars;
}


/**
 *	Does the actual work
 *
 */
function rurl2p_redirect_post() {

	// Prevent being triggered again when executing the query
	if ( did_action( 'parse_query' ) === 1 ) {

		// Retrieve search criteria from GET query
		// non-sanitized version: $redirect_to = trim( strtolower( $_GET['redirect_to'] ) );
		$redirect_to = trim( get_query_var( 'redirect_to' ) );

		// Check if parameter is set
		if ( !empty( $redirect_to ) ) {

			// Set default args		
			$args_default = array(
				'posts_per_page'	=> 1,
				'order'				=> 'DESC',
				'post_type'			=> 'post'
			);


			// Get standard parameters that make sense to use
			$args_default_items = array(
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
			);
				// not working:
				// 'has_password',
				// 'post_parent',
				// 'tag_id',
				// 'tag_and',
				// 'tag_in',
				// 'name'

			foreach ($args_default_items as $item) {

				if ( isset( $_GET[$item] ) ) {

					$args_default[$item] = get_query_var( $item );
					
				}
					
			}

			// Set up the search query depending on the criteria
			switch ($redirect_to) {
	
				// Show the latest post
				case 'latest':
				case 'last':
			
					$args_add = array(
						'orderby'			=> 'date',
						'order'				=> 'DESC',
					);
			
				break;
	
				// Show the oldest post
				case 'oldest':
				case 'first':
			
					$args_add = array(
						'orderby'			=> 'date',
						'order'				=> 'ASC',
					);
			
				break;
	
				// Show a random post
				case 'random':
			
					$args_add = array(
						'orderby'			=> 'rand'
					);
			
				break;
				
				// find a post based on orderby (and order)
				case 'custom':
			
					if ( empty( $args_default['orderby'] ) ) {
						
						echo "Error: The parameter 'custom' requires also 'orderby'";
						
						exit;
						
					}
					
					
					// Check order parameter
					$order_whitelist = array(
						'ASC',
						'DESC'
					);
			
					if ( !in_array( $args_default['order'], $order_whitelist) ) {
			
						echo "Error: Unrecognized value of parameter 'order'";
						
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
			
					if ( !in_array( $args_default['orderby'], $orderby_whitelist) ) {
			
						echo "Error: Unrecognized value of parameter 'orderby'";
						
						exit;
				
					}
					
					$args_add = array();
			
				break;
		
				// Any other value triggers error message
				default:
			
					echo "Error: Unrecognized value of 'redirect_to'";
			
					exit;
			
				break;
			}

			// Retrieve the first post and redirect to its permalink
			if ( isset( $args_add ) ) {

				$args = array_merge( $args_default, $args_add );

				$posts = get_posts( $args );	

				if ( !empty( $posts) ) {
		
					$post = array_shift( $posts );

					$permalink = get_permalink( $post );

					wp_redirect( $permalink );

					exit;
			
				} else {
		
					// Nothing found, go home
					wp_redirect( site_url() );

				exit;
		
				}

			}
		
		}
		
	}

}


