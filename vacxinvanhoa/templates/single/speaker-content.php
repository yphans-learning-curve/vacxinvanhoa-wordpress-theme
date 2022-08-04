<?php $post_class = ( true == ashe_options('blog_page_show_dropcaps') ) ? 'blog-post ashe-dropcaps' : 'blog-post'; ?>


<?php
    $podcasts = get_posts(array(
        'post_type' => 'podcast',
		'posts_per_page' => 100,
        'meta_query' => array(
            array(
                'key' => 'speakers', // name of custom field
                'value' => '"' . get_the_ID() . '"', // matches exactly "123", not just 123. This prevents a match for "1234"
                'compare' => 'LIKE'
            )
        )
    ));

    if (!isset($podcasts)) {
        echo 'Không tìm thấy podcast nào liên kết với ' . the_title() ;
    }

    $stories = get_posts(array(
        'post_type' => 'story',
		'posts_per_page' => 100,
        'meta_query' => array(
            array(
                'key' => 'speaker', // name of custom field
                'value' => '"' . get_the_ID() . '"', // matches exactly "123", not just 123. This prevents a match for "1234"
                'compare' => 'LIKE'
            )
        )
    ));

    if (!isset($stories)) {
        echo 'Không tìm thấy câu chuyện nào liên kết với ' . the_title() ;
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

        // Podcasts
        if ($podcasts) {
            echo '<h2>Các chương trình</h2>';
            echo '<ul>';

            foreach( $podcasts as $podcast ): ?>
                <li>
                    <a href="<?php echo get_permalink( $podcast->ID ); ?>">
                        <?php echo get_the_title( $podcast->ID ); ?>
                    </a>
                </li>
            <?php endforeach;

            echo '</ul>';
        }

        // Stories
        if ($stories) {
            echo '<h2>Các câu chuyện ' . get_the_title() . ' kể</h2>';
            echo '<ul>';

            foreach( $stories as $story ): ?>
                <li>
                    <a href="<?php echo get_permalink( $story->ID ); ?>">
                        <?php echo get_the_title( $story->ID ); ?>
                    </a>
                </li>
            <?php endforeach;

            echo '</ul>';
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