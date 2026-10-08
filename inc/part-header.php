<?php
/**
 * Header Berita 6: baris berita terkini + sosmed, logo + iklan, menu.
 */
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

$ticker_query = new WP_Query(array(
    'post_type'           => 'post',
    'posts_per_page'      => 5,
    'post_status'         => 'publish',
    'ignore_sticky_posts' => true,
    'no_found_rows'       => true,
));
?>
<div class="header-top border-bottom py-1">
    <div class="d-flex align-items-center gap-2">
        <div class="ticker-news d-none d-md-flex align-items-center flex-grow-1 overflow-hidden">
            <span class="ticker-label bg-color-theme text-white text-nowrap"><?php esc_html_e('Terkini', 'justg'); ?></span>
            <?php if ($ticker_query->have_posts()) : ?>
                <div id="carouselTickerNews" class="carousel slide carousel-fade flex-grow-1 overflow-hidden" data-bs-ride="carousel" data-bs-interval="4000">
                    <div class="carousel-inner">
                        <?php
                        $nm = 0;
                        while ($ticker_query->have_posts()) :
                            $ticker_query->the_post();
                            ?>
                            <div class="carousel-item<?php echo 0 === $nm ? ' active' : ''; ?>">
                                <a class="d-block text-truncate ps-2" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </div>
                            <?php
                            $nm++;
                        endwhile;
                        wp_reset_postdata();
                        ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <div class="header-sosmed d-flex align-items-center gap-1 mx-auto me-md-0">
            <?php justg_get_sosmed(); ?>
            <button type="button" class="btn-sosmed bg-color-theme border-0" data-bs-toggle="modal" data-bs-target="#searchHeaderModal" aria-label="<?php esc_attr_e('Cari', 'justg'); ?>">
                <?php echo velocityberita6_icon('search', 14); ?>
            </button>
        </div>
    </div>
</div>

<div class="modal fade" id="searchHeaderModal" tabindex="-1" aria-label="<?php esc_attr_e('Cari berita', 'justg'); ?>" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content rounded-0">
            <div class="modal-body p-2">
                <form action="<?php echo esc_url(home_url('/')); ?>" method="get" role="search" class="d-flex border border-dark bg-light">
                    <input type="search" name="s" placeholder="<?php esc_attr_e('Cari berita...', 'justg'); ?>" aria-label="<?php esc_attr_e('Kata kunci', 'justg'); ?>" class="form-control bg-light border-0 rounded-0" value="<?php echo esc_attr(get_search_query()); ?>">
                    <button type="submit" class="btn btn-link text-secondary py-1 px-3" aria-label="<?php esc_attr_e('Cari', 'justg'); ?>">
                        <?php echo velocityberita6_icon('search', 16); ?>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="header-middle py-3">
    <div class="row align-items-center g-3">
        <div class="col-md-4 col-xl-3 text-center text-md-start site-logo">
            <?php
            if (has_custom_logo()) {
                the_custom_logo();
            } else {
                echo '<a class="site-title h3 fw-bold text-decoration-none" href="' . esc_url(home_url('/')) . '">' . esc_html(get_bloginfo('name')) . '</a>';
            }
            ?>
        </div>
        <div class="col-md-8 col-xl-9">
            <?php get_berita_iklan('iklan_header'); ?>
        </div>
    </div>
</div>

<nav id="main-nav" class="navbar navbar-expand-md d-block navbar-light border-top bg-light p-0" aria-labelledby="main-nav-label">

    <h2 id="main-nav-label" class="screen-reader-text">
        <?php esc_html_e('Main Navigation', 'justg'); ?>
    </h2>

    <button class="navbar-toggler border-0 rounded-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#navbarNavOffcanvas" aria-controls="navbarNavOffcanvas" aria-expanded="false" aria-label="<?php esc_attr_e('Toggle navigation', 'justg'); ?>">
        <span class="navbar-toggler-icon"></span>
        <small><?php esc_html_e('Menu', 'justg'); ?></small>
    </button>

    <div class="offcanvas offcanvas-start" tabindex="-1" id="navbarNavOffcanvas">

        <div class="offcanvas-header justify-content-end">
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="<?php esc_attr_e('Close', 'justg'); ?>"></button>
        </div>

        <?php
        wp_nav_menu(
            array(
                'theme_location'  => 'primary',
                'container_class' => 'offcanvas-body',
                'container_id'    => '',
                'menu_class'      => 'navbar-nav justify-content-start flex-grow-1 flex-wrap',
                'fallback_cb'     => '',
                'menu_id'         => 'main-menu',
                'depth'           => 4,
                'walker'          => new justg_WP_Bootstrap_Navwalker(),
            )
        );
        ?>
    </div><!-- .offcanvas -->

</nav>
<div class="bg-color-theme d-block w-100 pb-1"></div>
