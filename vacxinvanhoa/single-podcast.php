<?php get_header(); ?>

<!-- Page Content -->
<div class="main-content clear-fix<?php echo ( ashe_options( 'general_single_width' ) === 'boxed'  ) ? ' boxed-wrapper': ''; ?>" data-sidebar-sticky="<?php echo esc_attr( ashe_options( 'general_sidebar_sticky' )  ); ?>">


	<?php

	// Sidebar Alt 
	get_template_part( 'templates/sidebars/sidebar', 'alt' ); 

	// Sidebar Left
	get_template_part( 'templates/sidebars/sidebar', 'left' );

	?>

	<!-- Main Container -->
	<div class="main-container">

		<?php

		// Single Post

		$post_class = ( true == ashe_options('blog_page_show_dropcaps') ) ? 'blog-post ashe-dropcaps' : 'blog-post'; ?>

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

                $category_list = get_the_category_list( ',&nbsp;&nbsp;' );
                if ( ashe_options( 'single_page_show_categories' ) === true && $category_list ) {
                    echo '<div class="post-categories">' . $category_list . ' </div>';
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

                // Podcast stories 

                $stories = get_posts(array(
                    'post_type' => 'story',
                    'order' => 'ASC',
                    'orderby' => 'date',
                    'meta_query' => array(
                        array(
                            'key' => 'podcast', // name of custom field
                            'value' => '"' . get_the_ID() . '"', // matches exactly "123", not just 123. This prevents a match for "1234"
                            'compare' => 'LIKE'
                        )
                    )
                ));
                
                if ( $stories ): ?>
                    <h3 class="speaker-list-header">Chương trình có:</h3>
                    <ul class="speaker-list">
                    <?php foreach( $stories as $story ): ?>
                        <?php 

                        $speakers = get_field('speaker', $story->ID);
                        $firstSpeakerAvatar = get_the_post_thumbnail_url($speakers[0]->ID, 'thumbnail');
                        ?>

                        <li>
                            <?php echo get_the_title( $story->ID ); ?>
                            <span>được kể bởi</span>

                            <?php if ($speakers) : ?>
                                <a href="<?php echo get_permalink( $speakers[0]->ID ); ?>">
                                    <img class="speaker-avatar circle-avatar-24px" style="display:inline-block" src="<?php echo $firstSpeakerAvatar; ?>" alt="<?php echo $speakers[0]->post_title; ?>" width="30" />
                                    <?php echo $speakers[0]->post_title; ?>
                                </a>
                            <?php else: ?>
                                <span>Không rõ</span>
                            <?php endif ?>
                            
                        </li>
                    <?php endforeach; ?>
                    </ul>
                <?php endif;

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
                
            </footer>

        <?php

            endwhile; // Loop End

        endif; // have_posts()

        ?>

        </article>

        <?php 
		// Author Description
		if ( ashe_options( 'single_page_show_author_desc' ) === true ) {
			get_template_part( 'templates/single/author', 'description' );
		}

		// Single Navigation
		// get_template_part( 'templates/single/single', 'navigation' );
	
		// Related Posts
        // ashe_related_posts( esc_html__( 'You May Also Like','ashe' ), ashe_options( 'single_page_related_orderby' ) );

		// Comments
		// get_template_part( 'templates/single/comments', 'area' );

		?>

	</div><!-- .main-container -->


	<?php // Sidebar Right

	get_template_part( 'templates/sidebars/sidebar', 'right' );

	?>

</div><!-- .page-content -->

<?php get_footer(); ?>