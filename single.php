<?php

/**
 * The template for displaying all single posts
 *
 * @package justg
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

get_header();
$container  = velocitytheme_option('justg_container_type', 'container');
$format     = get_post_format() ?: 'standard';
?>

<div class="wrapper" id="single-wrapper">

	<div class="p-0 <?php echo esc_attr($container); ?>" id="content" tabindex="-1">

		<div class="breadcrumb-box bg-light border px-3 pt-2 mb-3">
			<?php velocityberita6_breadcrumb(); ?>
		</div>

		<div class="row">

			<!-- Do the left sidebar check -->
			<?php do_action('justg_before_content'); ?>

			<main class="site-main" id="main">

				<?php
				while (have_posts()) {
					the_post();
					?>

					<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

						<?php get_berita_iklan('iklan_content'); ?>

						<?php the_title('<h1 class="entry-title h4 fw-bold lh-sm">', '</h1>'); ?>

						<div class="post-meta position-relative mt-2 py-1 ps-2 pe-5 bg-pattern border text-muted mb-3">
							<?php velocityberita6_post_meta(3); ?>
							<span class="heading-mark color-theme"><?php echo velocityberita6_icon('bookmark', 30); ?></span>
						</div>

						<div class="entry-content">

							<?php get_berita_iklan('iklan_content_2'); ?>

							<?php
							if (has_post_thumbnail() && $format !== 'video' && $format !== 'gallery') {
								echo '<figure class="mb-3">';
									echo get_the_post_thumbnail(get_the_ID(), 'full', array(
										'class'         => 'w-100 h-auto',
										'loading'       => 'eager',
										'fetchpriority' => 'high',
										'sizes'         => '(min-width: 992px) 640px, 100vw',
									));
									$featured_image_caption = get_the_post_thumbnail_caption(get_the_ID());
									if ($featured_image_caption) {
										echo '<figcaption class="text-muted fst-italic mt-1"><small>' . wp_kses_post($featured_image_caption) . '</small></figcaption>';
									}
								echo '</figure>';
							}
							?>

							<?php the_content(); ?>

							<?php
							wp_link_pages(
								array(
									'before' => '<div class="page-links">' . __('Pages:', 'justg'),
									'after'  => '</div>',
								)
							);
							?>

							<?php $gettags = get_the_tags(); ?>
							<?php if ($gettags) : ?>
								<div class="post-tags mt-3 mb-3 d-flex flex-wrap gap-1">
									<?php foreach ($gettags as $tag) : ?>
										<a class="btn btn-sm btn-theme" href="<?php echo esc_url(get_tag_link($tag->term_id)); ?>">#<?php echo esc_html($tag->name); ?></a>
									<?php endforeach; ?>
								</div>
							<?php endif; ?>

							<?php get_berita_iklan('iklan_content_3'); ?>

						</div><!-- .entry-content -->

						<div class="single-post-nav d-flex flex-wrap gap-2 justify-content-between align-items-center border-top border-bottom py-2 my-3">
							<?php velocityberita6_share(); ?>
							<div class="btn-group" role="group" aria-label="<?php esc_attr_e('Navigasi artikel', 'justg'); ?>">
								<?php
								$prev_post = get_adjacent_post(false, '', true);
								if (!empty($prev_post)) {
									echo '<a href="' . esc_url(get_permalink($prev_post->ID)) . '" class="btn btn-sm btn-light border" title="' . esc_attr(get_the_title($prev_post)) . '" rel="prev">&lsaquo; ' . esc_html__('Sebelumnya', 'justg') . '</a>';
								}
								$next_post = get_adjacent_post(false, '', false);
								if (!empty($next_post)) {
									echo '<a href="' . esc_url(get_permalink($next_post->ID)) . '" class="btn btn-sm btn-light border" title="' . esc_attr(get_the_title($next_post)) . '" rel="next">' . esc_html__('Berikutnya', 'justg') . ' &rsaquo;</a>';
								}
								?>
							</div>
						</div>

					</article>

					<?php
					$related_query = new WP_Query(array(
						'post_type'           => 'post',
						'post__not_in'        => array(get_the_ID()),
						'posts_per_page'      => 4,
						'category__in'        => wp_get_post_categories(get_the_ID()),
						'ignore_sticky_posts' => true,
						'no_found_rows'       => true,
					));
					if ($related_query->have_posts()) :
						?>
						<section class="related-post mb-4">
							<?php velocityberita6_heading(__('Berita Terkait', 'justg'), '', 'h2'); ?>
							<div class="row g-3 align-items-stretch">
								<?php
								while ($related_query->have_posts()) {
									$related_query->the_post();
									echo '<article class="col-6 col-xl-3">';
										echo '<div class="bg-light p-2 h-100">';
										module_cardposts(2);
										echo '</div>';
									echo '</article>';
								}
								?>
							</div>
						</section>
						<?php
					endif;
					wp_reset_postdata();

					// If comments are open or we have at least one comment, load up the comment template.
					if (comments_open() || get_comments_number()) {
						do_action('justg_before_comments');
						comments_template();
						do_action('justg_after_comments');
					}
				}
				?>

			</main><!-- #main -->

			<!-- Do the right sidebar check. -->
			<?php do_action('justg_after_content'); ?>

		</div><!-- .row -->

	</div><!-- #content -->

</div><!-- #single-wrapper -->

<?php
get_footer();
