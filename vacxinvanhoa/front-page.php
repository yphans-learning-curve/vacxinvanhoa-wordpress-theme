<?php 

$upcoming_podcast_args = array(  
    'post_type' => 'podcast',
    'post_status' => 'future',
    'posts_per_page' => 4,
    'order' => 'ASC',
    'orderby' => 'date'
);

$upcoming_podcast_query = new WP_Query($upcoming_podcast_args);


$blog_args = array(  
    'post_type' => 'post',
    'post_status' => 'publish',
    'posts_per_page' => 3,
    'order' => 'DESC',
    'orderby' => 'date'
);

$blog_query = new WP_Query($blog_args);

get_header();



// if ( is_home() ) {

// 	// Featured Slider, Carousel
// 	if ( ashe_options( 'featured_slider_label' ) === true && ashe_options( 'featured_slider_location' ) !== 'front' ) {
// 		if ( ashe_options( 'featured_slider_source' ) === 'posts' ) {
// 			get_template_part( 'templates/header/featured', 'slider' );
// 		} else {
// 			get_template_part( 'templates/header/featured', 'slider-custom' );
// 		}
// 	}

// 	// Featured Links, Banners
// 	if ( ashe_options( 'featured_links_label' ) === true && ashe_options( 'featured_links_location' ) !== 'front' ) {
// 		get_template_part( 'templates/header/featured', 'links' ); 
// 	}

// }

// ?>


<section class="section-container home__about-us__section">
    <div class="home__about-us__content">
        <header>
            <div class="home__about-us__illustration"></div>
            <h1 class="home__about-us__headline">"Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit..."</h1>
        </header>
        <main>
            <p class="home__about-us__description">Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium</p>
        </main>
    </div>
</section>

<div class="headline-ribbon"></div>

<section class="home__get-onmic__section">
    <div class="home__get-onmic__container">
        <div class="home__get-onmic__media">

        </div>
        <div class="home__get-onmic__content">
            <h2 class="home__get-onmic__headline">Ut enim ad minima veniam quism</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris eu nunc quis quam dapibus cursus. Aenean fermentum faucibus ipsum eu gravida. Duis vestibulum augue risus, ut molestie lacus auctor at. Suspendisse sagittis massa at risus auctor maximus.</p>
            <a class="home__get-onmic__redirect" href="https://getonmic.com/user/nguyentrang19" target="__blank">Nghe trên OnMic</a>
        </div>
    </div>  
</section>

<section class="home__upcoming__section">
    <div class="home__upcoming__container">
            <div class="home__differentiator__content">
                <h2 class="home__differentiator__headline">Sed ut perspiciatis unde omnis</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris eu nunc quis quam dapibus cursus. Aenean fermentum faucibus ipsum eu gravida. Duis vestibulum augue risus, ut molestie lacus auctor at.</p>
                <ul class="home_differentiator__list">
                    <li>Ut enim ad minima veniam</li>
                    <li>Quis autem vel eum iure</li>
                    <li>Nemo enim ipsam voluptatem quia</li>
                    <li>Sed ut perspiciatis unde omnis iste</li>
                </ul>
            </div>
            <div>
                <header class="home__upcoming__list-header">
                    <h2 class="">Đón nghe vào tối thứ hai hàng tuần</h2>
                </header>
                <main>
                <?php 
                    

                    if ( $upcoming_podcast_query->have_posts() ) {

                        while ( $upcoming_podcast_query->have_posts()) {
                            $upcoming_podcast_query->the_post();

                            if (str_contains(get_the_title(), 'Vắc xin văn hoá')) {
                                $the_order = substr(get_the_title(), 21, 2);
                                $the_name = substr(get_the_title(), 24);
                            } else {
                                $the_order = '0';
                                $the_name = get_the_title();
                            }

                            ?>

                                <article class="home__upcoming__list-item">
                                    <div class="home__upcoming__list_item-order">
                                        #<?php echo $the_order; ?>
                                    </div>
                                    <header class="home__upcoming__list-item-title">
                                        <h3><?php echo $the_name; ?></h3>
                                    </header>
                                    <div>
                                        <?php the_date(); ?>

                                    </div>
                                </article>
                            <?php                        
                        }

                        wp_reset_postdata();
                    } else {
                        echo "hello";
                    }

                ?>                   
                </main>  
            </div>    
    </div>
</section>

<section class="home__all-eps__section">
    <div class="home__all-eps__container">
        <div class="home__all-eps__subtitle">Nemo enim ipsam voluptatem</div>
        <a class="home__all-eps__button" href="/show">Nghe lại tất cả các chương trình</a>
    </div>
</section>

<section class="home__blog__section">
    <div class="home__blog__container">
        <header class="home__blog__header">        
            <h2>Mới nhất</h2>
            <a class="read-more" href="/blog">Xem tất cả</a>
        </header>
        <main>
            <ul class="home__blog__list">
                <?php
            if ( $blog_query->have_posts() ) {

                while ( $blog_query->have_posts()) {
                    $blog_query->the_post();
                    ?>
                        <li class="home__blog__list-item">
                            <article>
                                <div class="post-media">
                                    <a href="<?php echo esc_url( get_permalink() ); ?>"></a>
                                    <?php the_post_thumbnail('ashe-grid-thumbnail'); ?>
                                </div>
                                <header>
                                    <?php if ( get_the_title() ) : ?>
                                        <h3><a href="<?php esc_url( the_permalink() ); ?>"><?php the_title(); ?></a></h3>
                                    <?php endif; ?>
                                    <div class="post-meta clear-fix">
                                        <span class="post-date"><?php the_time( get_option( 'date_format' ) ); ?></span>                                                           
					                </div>
                                </header>
                            </article> 
                        </li>
                    <?php                        
                }

                wp_reset_postdata();
                } else {
                    echo "hello";
                } 
                ?>
            </ul>
        </main>
    </div>
</section>

<?php get_footer(); ?>