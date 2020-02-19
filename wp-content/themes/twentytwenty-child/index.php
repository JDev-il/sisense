<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since 1.0.0
 */

get_header();
?>

<main id="site-content" role="main">

	<img class="" />

	<?php

	$archive_title    = '';
	$archive_subtitle = '';

	if ( is_search() ) {
		global $wp_query;

		$archive_title = sprintf(
			'%1$s %2$s',
			'<span class="color-accent">' . __( 'Search:', 'twentytwenty' ) . '</span>',
			'&ldquo;' . get_search_query() . '&rdquo;'
		);

		if ( $wp_query->found_posts ) {
			$archive_subtitle = sprintf(
				/* translators: %s: Number of search results */
				_n(
					'We found %s result for your search.',
					'We found %s results for your search.',
					$wp_query->found_posts,
					'twentytwenty'
				),
				number_format_i18n( $wp_query->found_posts )
			);
		} else {
			$archive_subtitle = __( 'We could not find any results for your search. You can give it another try through the search form below.', 'twentytwenty' );
		}
	} elseif ( ! is_home() ) {
		$archive_title    = get_the_archive_title();
		$archive_subtitle = get_the_archive_description();
	}

	if ( $archive_title || $archive_subtitle ) {
		?>

		<header class="archive-header has-text-align-center header-footer-group">

			<div class="archive-header-inner section-inner medium">

				<?php if ( $archive_title ) { ?>
					<h1 class="archive-title"><?php echo wp_kses_post( $archive_title ); ?></h1>
				<?php } ?>

				<?php if ( $archive_subtitle ) { ?>
					<div class="archive-subtitle section-inner thin max-percentage intro-text"><?php echo wp_kses_post( wpautop( $archive_subtitle ) ); ?></div>
				<?php } ?>

			</div><!-- .archive-header-inner -->

		</header><!-- .archive-header -->

		<?php
	}

	if ( have_posts() ) {

		$i = 0;

		while ( have_posts() ) {
			$i++;
			if ( $i > 1 ) {
				echo '<hr class="post-separator styled-separator is-style-wide section-inner" aria-hidden="true" />';
			}
			the_post();

			get_template_part( 'template-parts/content', get_post_type() );

		}
	} elseif ( is_search() ) {
		?>

		<div class="no-search-results-form section-inner thin">

			<?php
			get_search_form(
				array(
					'label' => __( 'search again', 'twentytwenty' ),
				)
			);
			?>

		</div><!-- .no-search-results -->

		<?php
	}
	?>

	<?php get_template_part( 'template-parts/pagination' ); ?>


	<?php 

		$err = "";

				if(isset($_POST['new_post']) == '1') {
					if(empty($_POST['post_title']) || empty($_POST['post_content'])){
						$err = "Please fill required fields!";
					} else {
						$post_title = $_POST['post_title'];
						$post_category = $_POST['cat'];
						$post_content = $_POST['post_content'];
				
						$new_post = array(
							'ID' => '',
							'post_author' => $user->ID, 
							'post_category' => array($post_category),
							'post_content' => $post_content, 
							'post_title' => $post_title,
							'post_status' => 'publish'
							);
				
						$post_id = wp_insert_post($new_post);
				
						// This will redirect you to the newly created post
						$post = get_post($post_id);
						// wp_redirect($post->guid);
						echo "<meta http-equiv='refresh' content='0'>";
					}

				}

	?>      
	<div id="sisenseDivForm">
		<h3><?php echo "Add A New Post" ?></h3>
		<form method="post" action="">
			<!-- <p><?php echo $err ?></p> -->
			<input type="text" name="post_title" size="45" placeholder="* Post Title"/>
			<br/>
			<textarea rows="5" name="post_content" cols="5" maxlength="40" placeholder="* Post Content"></textarea>
			<input type="hidden" name="new_post" value="1"/> 
			<br/>
			<input type="submit" name="submit" class="submitBtn" value="Post"/>
		</form>
	</div>



</main><!-- #site-content -->


<?php
get_footer();
				// $items = array();
				// $items[] = wp_dropdown_categories('orderby=name&hide_empty=0&exclude=1&hierarchical=1');
