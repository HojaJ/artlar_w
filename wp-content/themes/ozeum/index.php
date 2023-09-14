<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: //codex.wordpress.org/Template_Hierarchy
 *
 * @package OZEUM
 * @since OZEUM 1.0
 */

get_template_part( apply_filters( 'ozeum_filter_get_template_part', ozeum_blog_archive_get_template() ) );
