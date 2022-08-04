<?php $post_class = ( true == ashe_options('blog_page_show_dropcaps') ) ? 'blog-post ashe-dropcaps' : 'blog-post'; ?>


<?php

    $speakers = get_field('speaker');

    if (!isset($speakers)) {
        echo 'Chưa điền người kể cho câu chuyện này!.';
    }

    $podcasts = get_field('podcast');

    if (!isset($podcasts)) {
        echo 'Chưa điền show cho câu chuyện này!.';
    }

	function map_podcast_to_id($object) {
		return $object->ID;
	}

	if ($podcasts) {
		$podcast_ids_string = implode(',',array_map('map_podcast_to_id', $podcasts));
	}

?>


<article id="post-<?php the_ID(); ?>" <?php post_class($post_class); ?>>

<?php

if ( have_posts() ) :

	// Loop Start
	while ( have_posts() ) :

		the_post();

?>	



	<?php if ( ashe_options( 'single_page_show_featured_image' ) === true ) : ?>
	<div class="post-media">
		<?php the_post_thumbnail('ashe-full-thumbnail'); ?>
	</div>
	<?php endif; ?>

	<header class="post-header">

		<?php
        // Replace the category with the speakers

        if (isset($speakers)) {
            echo '<div class="post-categories">' . '<a href="' . get_the_permalink($speakers[0]->ID) . '">' . $speakers[0]->post_title . '</a> kể' . ' </div>';
        }

		?>

		<?php if ( get_the_title() ) : ?>
		<h1 class="post-title"><?php the_title(); ?></h1>
		<?php endif; ?>

		<?php if ( ashe_options( 'single_page_show_date' ) || ashe_options( 'single_page_show_comments' ) ) : ?>
		<div class="post-meta clear-fix">

			<?php if ( ashe_options( 'single_page_show_date' ) === true ) : ?>
				<span class="post-date"><?php the_time( get_option( 'date_format' ) ); ?></span>
			<?php endif; ?>
			
			<span class="meta-sep">/</span>
			
			<?php
			if ( ashe_post_sharing_check() && ashe_options( 'single_page_show_comments' ) === true ) {
				comments_popup_link( esc_html__( '0 Comments', 'ashe' ), esc_html__( '1 Comment', 'ashe' ), '% '. esc_html__( 'Comments', 'ashe' ), 'post-comments');
			}
			?>

		</div>
		<?php endif; ?>

	</header>

	<div class="post-content">

		<?php

		// The Post Content
		the_content('');

        // Podcast
        if ($podcasts) {
            echo '<h2>Nghe toàn bộ chương trình:</h2>';
            $podcast_ids_string = $podcast_ids_string;
			echo do_shortcode("[podcast_playlist episodes=\"$podcast_ids_string\" style=\"dark\"]");
        }

		// Post Pagination
		$defaults = array(
			'before' => '<p class="single-pagination">'. esc_html__( 'Pages:', 'ashe' ),
			'after' => '</p>'
		);

		wp_link_pages( $defaults );

		?>
	</div>

	<footer class="post-footer">

		<?php 

		// The Tags
		$tag_list = get_the_tag_list( '<div class="post-tags">','','</div>');
		
		if ( $tag_list ) {
			echo ''. $tag_list;
		}

		?>

		<?php if ( ashe_options( 'single_page_show_author' ) === true ) : ?>
		<span class="post-author"><?php esc_html_e( 'By', 'ashe' ); ?>&nbsp;<?php the_author_posts_link(); ?></span>
		<?php endif; ?>

		<?php
			
		if ( ashe_post_sharing_check() ) {
			ashe_post_sharing();
		} else if ( ashe_options( 'single_page_show_comments' ) === true ) {
			comments_popup_link( esc_html__( '0 Comments', 'ashe' ), esc_html__( '1 Comment', 'ashe' ), '% '. esc_html__( 'Comments', 'ashe' ), 'post-comments');
		}

		?>
		
	</footer>

<?php

	endwhile; // Loop End
endif; // have_posts()

?>

</article>