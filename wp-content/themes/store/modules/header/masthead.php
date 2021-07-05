<header id="masthead" class="site-header" role="banner">
    <div class="container masthead-container">
        <div class="site-branding">
            <?php if ( get_theme_mod('store_logo') != "" ) : ?>
                <div id="site-logo">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo esc_url( get_theme_mod('store_logo') ); ?>"></a>
                </div>
            <?php endif; ?>
            <div id="text-title-desc">
                <h1 class="site-title title-font"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
                <h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
            </div>
        </div>

        <?php if (class_exists('woocommerce')) : ?>
            <div id="top-cart">
                <div class="top-cart-icon">


                    <a class="cart-contents" href="<?php echo WC()->cart->get_cart_url(); ?>" title="<?php esc_html_e('View your shopping cart', 'store'); ?>">
                        <div class="count"><?php echo sprintf(_n('%d item', '%d items', WC()->cart->cart_contents_count, 'store'), WC()->cart->cart_contents_count);?></div>
                        <div class="total"> <?php echo WC()->cart->get_cart_total(); ?>
                        </div>
                    </a>

                    <i class="fa fa-shopping-cart"></i>
                </div>
            </div>
        <?php endif; ?>

        <div id="top-search">
            <?php get_template_part('modules/header/searchform', 'top'); ?>
        </div>

    </div>

    <?php get_template_part('modules/navigation/main', 'menu'); ?>

</header><!-- #masthead -->