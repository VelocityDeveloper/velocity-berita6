<?php

/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package justg
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

get_header();

$container  = velocitytheme_option('justg_container_type', 'container');
$first_page = !is_paged();

/**
 * Kategori blok beranda dari Customizer: '' = semua, 'disable' = sembunyikan.
 */
$home_cat = function ($id) {
    $cat = velocitytheme_option('cat_' . $id, '');
    return 'disable' === $cat ? false : absint($cat);
};
?>

<div class="wrapper" id="index-wrapper">

    <div class="p-0 <?php echo esc_attr($container); ?>" id="content" tabindex="-1">

        <div class="row">

            <!-- Do the left sidebar check -->
            <?php do_action('justg_before_content'); ?>

                <main class="site-main" id="main">

                    <?php
                    $carousel_cat = $home_cat('bigcarousel_home');
                    if ($first_page && false !== $carousel_cat) :
                        $carousel_query = new WP_Query(array(
                            'post_type'           => 'post',
                            'posts_per_page'      => 5,
                            'cat'                 => $carousel_cat,
                            'ignore_sticky_posts' => true,
                            'no_found_rows'       => true,
                        ));
                        if ($carousel_query->have_posts()) :
                            ?>
                            <div id="carouselHome" class="carousel slide carousel-fade mb-4" data-bs-ride="carousel">
                                <div class="carousel-inner">
                                    <?php
                                    $nm = 0;
                                    while ($carousel_query->have_posts()) :
                                        $carousel_query->the_post();
                                        // Slide pertama = gambar utama halaman: dimuat lebih dulu.
                                        $img_attr = 0 === $nm
                                            ? array('loading' => 'eager', 'fetchpriority' => 'high', 'sizes' => '(min-width: 992px) 640px, 100vw')
                                            : array('sizes' => '(min-width: 992px) 640px, 100vw');
                                        ?>
                                        <div class="slideshow-post-item carousel-item<?php echo 0 === $nm ? ' active' : ''; ?>">
                                            <a class="d-block position-relative" href="<?php the_permalink(); ?>">
                                                <div class="ratio ratio-16x9 bg-light overflow-hidden">
                                                    <?php echo velocityberita6_thumb('large', $img_attr); ?>
                                                </div>
                                                <div class="carousel-caption text-md-start text-center start-0 end-0 bottom-0 p-2 pb-4">
                                                    <span class="bg-color-theme d-inline-block p-2 px-md-3"><?php the_title(); ?></span>
                                                </div>
                                            </a>
                                        </div>
                                        <?php
                                        $nm++;
                                    endwhile;
                                    ?>
                                </div>
                                <?php if ($nm > 1) : ?>
                                    <div class="carousel-indicators m-0 p-0">
                                        <?php for ($i = 0; $i < $nm; $i++) : ?>
                                            <button type="button" data-bs-target="#carouselHome" data-bs-slide-to="<?php echo $i; ?>"<?php echo 0 === $i ? ' class="active" aria-current="true"' : ''; ?> aria-label="<?php echo esc_attr(sprintf(__('Slide %d', 'justg'), $i + 1)); ?>"></button>
                                        <?php endfor; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <?php
                        endif;
                        wp_reset_postdata();
                    endif;
                    ?>

                    <?php if ($first_page) : ?>

                        <?php
                        $post1_cat = $home_cat('posts_home_1');
                        if (false !== $post1_cat) :
                            $post1query = new WP_Query(array(
                                'post_type'           => 'post',
                                'cat'                 => $post1_cat,
                                'posts_per_page'      => 4,
                                'ignore_sticky_posts' => true,
                                'no_found_rows'       => true,
                            ));
                            if ($post1query->have_posts()) :
                                ?>
                                <section class="widget part_posts_home_1">
                                    <?php velocityberita6_heading(velocitytheme_option('title_posts_home_1', 'Recent Posts'), $post1_cat ? get_category_link($post1_cat) : ''); ?>
                                    <div class="vb-slider" data-autoplay="4000">
                                        <div class="vb-slider-track">
                                            <?php
                                            while ($post1query->have_posts()) :
                                                $post1query->the_post();
                                                echo '<div class="vb-slide">';
                                                module_cardposts(6);
                                                echo '</div>';
                                            endwhile;
                                            ?>
                                        </div>
                                        <button type="button" class="vb-slider-prev" aria-label="<?php esc_attr_e('Sebelumnya', 'justg'); ?>"><?php echo velocityberita6_icon('prev', 14); ?></button>
                                        <button type="button" class="vb-slider-next" aria-label="<?php esc_attr_e('Berikutnya', 'justg'); ?>"><?php echo velocityberita6_icon('next', 14); ?></button>
                                    </div>
                                </section>
                                <?php
                            endif;
                            wp_reset_postdata();
                        endif;
                        ?>

                        <?php
                        $post2_cat = $home_cat('posts_home_2');
                        if (false !== $post2_cat) :
                            $post2query = new WP_Query(array(
                                'post_type'           => 'post',
                                'cat'                 => $post2_cat,
                                'posts_per_page'      => 5,
                                'ignore_sticky_posts' => true,
                                'no_found_rows'       => true,
                            ));
                            if ($post2query->have_posts()) :
                                ?>
                                <section class="widget part_posts_home_2">
                                    <?php velocityberita6_heading(velocitytheme_option('title_posts_home_2', 'Recent Posts'), $post2_cat ? get_category_link($post2_cat) : ''); ?>
                                    <div class="row g-2">
                                        <?php
                                        $n2 = 1;
                                        while ($post2query->have_posts()) :
                                            $post2query->the_post();
                                            echo 1 === $n2 ? '<div class="col-12 pb-1">' : '<div class="col-6 col-xl-3">';
                                            module_cardposts(1 === $n2 ? 5 : 3);
                                            echo '</div>';
                                            $n2++;
                                        endwhile;
                                        ?>
                                    </div>
                                </section>
                                <?php
                            endif;
                            wp_reset_postdata();
                        endif;
                        ?>

                    <?php endif; ?>

                    <?php get_berita_iklan('iklan_home_1'); ?>

                    <section class="widget">
                        <?php velocityberita6_heading(__('Berita Terbaru', 'justg')); ?>
                        <?php if (have_posts()) :
                            $postcount = 1;
                            while (have_posts()) :
                                the_post();
                                ?>
                                <article <?php post_class('post-list mb-4'); ?>>
                                    <div class="row g-3">
                                        <div class="col-5 col-md-4">
                                            <a href="<?php the_permalink(); ?>" class="d-block ratio ratio-4x3 bg-light overflow-hidden" tabindex="-1" aria-hidden="true">
                                                <?php echo velocityberita6_thumb('medium'); ?>
                                            </a>
                                        </div>
                                        <div class="col-7 col-md-8">
                                            <?php
                                            the_title(
                                                sprintf('<h2 class="h6 fw-bold mb-1 lh-sm"><a href="%s" rel="bookmark">', esc_url(get_permalink())),
                                                '</a></h2>'
                                            );
                                            ?>
                                            <div class="d-none d-md-block mb-2">
                                                <?php echo esc_html(vdberita_limit_text(get_the_excerpt(), 20)); ?>
                                            </div>
                                            <div class="post-meta opacity-75">
                                                <?php velocityberita6_post_meta(0); ?>
                                            </div>
                                            <a class="btn btn-sm btn-theme mt-2 d-none d-md-inline-block" href="<?php the_permalink(); ?>"><?php esc_html_e('Baca Selengkapnya', 'justg'); ?></a>
                                        </div>
                                    </div>
                                </article>
                                <?php
                                if (3 === $postcount) {
                                    get_berita_iklan('iklan_home_2');
                                }
                                $postcount++;
                            endwhile;
                        else :
                            get_template_part('loop-templates/content', 'none');
                        endif;
                        ?>
                        <?php justg_pagination(); ?>
                    </section>

                </main><!-- #main -->

            <!-- Do the right sidebar check. -->
            <?php do_action('justg_after_content'); ?>
        </div><!-- .row -->

        <div class="row">
            <div class="col-md-6">
                <?php get_berita_iklan('iklan_home_bawah_1'); ?>
            </div>
            <div class="col-md-6">
                <?php get_berita_iklan('iklan_home_bawah_2'); ?>
            </div>
        </div>

    </div><!-- #content -->

</div><!-- #index-wrapper -->

<?php
get_footer();
