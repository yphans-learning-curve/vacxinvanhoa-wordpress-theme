<?php 

get_header();

?>

<div class="page-show main-content clear-fix<?php echo esc_attr(ashe_options( 'general_content_width' )) === 'boxed' ? ' boxed-wrapper': ''; ?>" data-layout="<?php echo esc_attr( ashe_options( 'general_home_layout' ) ); ?>" data-sidebar-sticky="<?php echo esc_attr( ashe_options( 'general_sidebar_sticky' ) ); ?>">
	
	<?php
	
	// Sidebar Left
	get_template_part( 'templates/sidebars/sidebar', 'left' ); 

	// Blog Feed Wrapper
    ?>

	<!-- Main Container -->
    <div class="main-container">
        
        <?php
        
        // Category Description
        if ( is_category() ) {
            get_template_part( 'templates/grid/category', 'description' );
        }

        // Blog Grid
        echo '<ul class="blog-grid">';

        $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

        $podcast_args = array(  
            'post_type' => 'podcast',
            'post_status' => 'publish',
            'posts_per_page' => 10,
            'paged' => $paged
        );
    
        $podcast_query = new WP_Query($podcast_args);
        
        if ( $podcast_query->have_posts() ) :

            // Loop Start
            while ( $podcast_query->have_posts() ) :

                $podcast_query->the_post();

                // if is preview (boat post)
                if ( ! ( ashe_is_preview() && get_the_ID() == 19 ) ) :

                $post_class = ( true == ashe_options('blog_page_show_dropcaps') ) ? 'blog-post ashe-dropcaps' : 'blog-post';

                echo '<li>';

                ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class($post_class); ?>>
                    
                    <div class="post-media">
                        <a href="<?php echo esc_url( get_permalink() ); ?>"></a>
                        <?php the_post_thumbnail('ashe-full-thumbnail'); ?>
                    </div>

                    <header class="post-header">

                        <?php

                        $category_list = get_the_category_list( ',&nbsp;&nbsp;' );

                        if ( ashe_options( 'blog_page_show_categories' ) === true && $category_list ) {
                            echo '<div class="post-categories">' . $category_list . ' </div>';
                        }

                        // $episode_order = get_field('episode_order');

                        // if (!empty($episode_order)) {
                        //     echo '<div class="post-categories">Vắc xin văn hoá #' . $episode_order . ' </div>';
                        // }

                        ?>

                        <?php if ( get_the_title() ) : ?>
                        <h2 class="post-title">
                            <a href="<?php esc_url( the_permalink() ); ?>"><?php the_title(); ?></a>
                        </h2>
                        <?php endif; ?>

                        <?php if ( ashe_options( 'blog_page_show_date' ) || ashe_options( 'blog_page_show_comments' ) ) : ?>
                        <div class="post-meta clear-fix">

                            <?php if ( ashe_options( 'blog_page_show_date' ) === true ) : ?>
                                <span class="post-date"><?php the_time( get_option( 'date_format' ) ); ?></span>
                            <?php endif; ?>
                            
                            <span class="meta-sep">/</span>
                            
                            <?php
                            if ( ashe_post_sharing_check() && ashe_options( 'blog_page_show_comments' ) === true ) {
                                comments_popup_link( esc_html__( '0 Comments', 'ashe' ), esc_html__( '1 Comment', 'ashe' ), '% '. esc_html__( 'Comments', 'ashe' ), 'post-comments');
                            }
                            ?>

                        </div>
                        <?php endif; ?>

                    </header>

                    <?php if ( ashe_options( 'blog_page_post_description' ) !== 'none' ) : ?>

                    <div class="post-content">
                        <?php
                            $poster_image = get_field('poster_image');
                            if (!empty($poster_image)) {
                                echo '<img width="150px" height="192px" class="alignleft" src=' . $poster_image['sizes']['rta_thumb_center_center_150x192'] . '" />';
                            }
                        ?>
                        <?php
                        if ( ashe_options( 'blog_page_post_description' ) === 'content' ) {
                            the_content('');
                        } elseif ( ashe_options( 'blog_page_post_description' ) === 'excerpt' ) {
                            ashe_excerpt( 110 );												
                        }
                        ?>
                    </div>

                    <?php endif; ?>

                    <div class="read-more">
                        <a href="<?php echo esc_url( get_permalink() ); ?>"><?php esc_html_e( 'read more','ashe' ); ?></a>
                        
                        <?php
                        $onmic_link = get_field('onmic_link');

                        if (!empty($onmic_link)) {
                            ?>
                            <a class="outbound-link" href="<?php echo $onmic_link ?>" target="__blank">Nghe trên OnMic</a>
                            <?php
                        }
                        ?>
                    </div>
                    
                    <footer class="post-footer">

                        <?php
                
                        if ( ashe_post_sharing_check() ) {
                            ashe_post_sharing();
                        } 

                        ?>
                        
                    </footer>

                    <!-- Related Posts -->
                    <?php ashe_related_posts( esc_html__( 'You May Also Like','ashe' ), ashe_options( 'blog_page_related_orderby' ) ); ?>

                </article>
            
                <?php

                echo '</li>';

                endif;

            endwhile; // Loop End

        else:

        ?>

        <div class="no-result-found">
            <h3><?php esc_html_e( 'Nothing Found!', 'ashe' ); ?></h3>
            <p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'ashe' ); ?></p>
            <div class="ashe-widget widget_search">
                <?php get_search_form(); ?>
            </div>
        </div>

        <?php
        
        endif; // have_posts()

        echo '</ul>';

        
        // Pagination links
            
        pagination( $paged, $podcast_query->max_num_pages); // Pagination Function

        wp_reset_postdata();

        ?>

    </div><!-- .main-container -->

    <?php
	// Sidebar Right
	get_template_part( 'templates/sidebars/sidebar', 'right' ); 

	?>

</div>

<?php get_footer(); ?>