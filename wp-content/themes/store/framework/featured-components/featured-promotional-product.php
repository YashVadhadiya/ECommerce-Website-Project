<?php if ( get_theme_mod('store_hero_enable') && is_front_page() ) : ?>
<div id="hero" class="hero-content">
    <?php if (get_theme_mod('store_hero_background_image')): ?>
        <div class="layer"></div>
    <?php endif; ?>
    <div class="container hero-container">
    <?php
        $args = array(
            'post_type' => 'product',
            'posts_per_page' => 1,
            'post__in' => array(get_theme_mod('store_fp_product_id')),
        );

        $loop = new WP_Query( $args );
        while( $loop -> have_posts() ):
            $loop->the_post();
            $product = wc_get_product($post->ID);
        $class = has_post_thumbnail() ?  'col-md-8 col-sm-8' : 'col-md-12 centered' ; ?>
        <div class="<?php echo $class; ?> h-content">
            <h1 class="title">
                <?php the_title(); ?>
            </h1>
            <?php if(get_theme_mod('store_hero1_full_content', true)) : ?>
                <div class="excerpt">
                    <?php the_content(); ?>
                </div>
            <?php else : ?>
                <div class="excerpt">
                    <?php
                    $product_description = apply_filters( 'woocommerce_short_description', $post->post_excerpt );
                    echo substr($product_description, 0, 250)."...";
                    ?>
                </div>
            <?php endif; ?>
                <div class="buynow">
                    <?php
                        woocommerce_template_loop_add_to_cart();
                    ?>
                </div></div>
        <?php if (has_post_thumbnail()) : ?>
        <div class="col-md-4 col-sm-4 col-xs-8 f-image">
                <a href="<?php the_permalink(); ?>"><img src="<?php the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>"></a>
        </div>
            <?php endif; ?>
        <?php
        endwhile; ?>
        <?php wp_reset_postdata(); ?>
    </div>
</div>
<?php endif; ?>