<?php
/**
 * Template Name: Yext Plugin - Search Results Page
 * Description: Yext custom template for displaying search results pages
 *
 * @package Yext
 */

get_header();
while ( have_posts() ) :
	the_post();
	do_action( 'yext_before_search_results' );
	the_content();
	do_action( 'yext_after_search_results' );
endwhile;

get_footer();
