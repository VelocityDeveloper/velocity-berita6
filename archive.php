<?php

/**
 * The template for displaying archive pages
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package justg
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

get_header();

$container = velocitytheme_option('justg_container_type', 'container');
?>

<div class="wrapper" id="archive-wrapper">

    <div class="p-0 <?php echo esc_attr($container); ?>" id="content" tabindex="-1">

        <div class="breadcrumb-box bg-light border px-3 pt-2 mb-3">
            <?php velocityberita6_breadcrumb(); ?>
        </div>

        <div class="row">

            <!-- Do the left sidebar check -->
            <?php do_action('justg_before_content'); ?>

            <main class="site-main" id="main">

                <?php if (have_posts()) : ?>
                    <header class="page-header mb-3">
                        <?php
                        if (is_search()) {
                            echo '<h1 class="heading-theme page-title"><span>' . esc_html(sprintf(__('Hasil pencarian: %s', 'justg'), get_search_query())) . '</span></h1>';
                        } else {
                            the_archive_title('<h1 class="heading-theme page-title"><span>', '</span></h1>');
                        }
                        the_archive_description('<div class="taxonomy-description border fst-italic bg-light p-3 pb-1 mb-3"><small>', '</small></div>');
                        ?>
                    </header><!-- .page-header -->
                    <?php
                    $postcount = 1;
                    while (have_posts()) :
                        the_post();
                        ?>
                        <article <?php post_class('mb-4'); ?>>

                            <?php
                            the_title(
                                sprintf('<h2 class="h6 fw-bold lh-sm mb-2"><a href="%s" rel="bookmark">', esc_url(get_permalink())),
                                '</a></h2>'
                            );
                            ?>
                            <div class="post-meta position-relative py-1 ps-2 pe-5 bg-pattern border text-muted mb-2">
                                <?php velocityberita6_post_meta(1); ?>
                                <span class="heading-mark color-theme"><?php echo velocityberita6_icon('bookmark', 30); ?></span>
                            </div>

                            <div class="row g-3">
                                <div class="col-5">
                                    <a href="<?php the_permalink(); ?>" class="d-block ratio ratio-16x9 bg-light overflow-hidden" tabindex="-1" aria-hidden="true">
                                        <?php echo velocityberita6_thumb('medium', 1 === $postcount ? array('loading' => 'eager') : array()); ?>
                                    </a>
                                </div>
                                <div class="col-7">
                                    <?php echo esc_html(vdberita_limit_text(get_the_excerpt(), 25)); ?>
                                </div>
                            </div>

                        </article>
                        <?php
                        if (1 === $postcount) {
                            get_berita_iklan('iklan_archive');
                        }
                        if (4 === $postcount) {
                            get_berita_iklan('iklan_archive_2');
                        }
                        $postcount++;
                    endwhile;
                else :
                    get_template_part('loop-templates/content', 'none');
                endif;
                ?>
                <!-- Display the pagination component. -->
                <?php justg_pagination(); ?>

            </main><!-- #main -->

            <!-- Do the right sidebar check. -->
            <?php do_action('justg_after_content'); ?>

        </div><!-- .row -->

    </div><!-- #content -->

</div><!-- #archive-wrapper -->

<?php
get_footer();
