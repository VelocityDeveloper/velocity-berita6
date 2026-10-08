<?php

/**
 * Fuction yang digunakan di theme ini.
 */
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

add_action('after_setup_theme', 'velocitychild_theme_setup', 9);
function velocitychild_theme_setup()
{
	//remove action from Parent Theme
	remove_action('justg_header', 'justg_header_menu');
	remove_action('justg_do_footer', 'justg_the_footer_open');
	remove_action('justg_do_footer', 'justg_the_footer_content');
	remove_action('justg_do_footer', 'justg_the_footer_close');
}

add_action('after_setup_theme', 'childtheme_formats', 11);
function childtheme_formats()
{
	add_theme_support(
		'post-formats',
		array(
			'aside',
			'gallery',
			'image',
			'video',
			'quote',
			'link',
		)
	);
}

///add action builder part
add_action('justg_before_header', 'vdberita_before_header');
function vdberita_before_header()
{
	echo '<div class="bg-color-theme p-1"></div>';
	echo '<div class="px-2 px-md-0">';
	echo '<div class="container shadow-sm">';
}
add_action('justg_after_footer', 'vdberita_after_footer');
function vdberita_after_footer()
{
	echo '</div>';
	echo '</div>';
	echo '<div class="bg-color-theme p-1"></div>';
}

add_action('justg_header', 'justg_header_berita');
function justg_header_berita()
{
	require_once(get_stylesheet_directory() . '/inc/part-header.php');
}
add_action('justg_do_footer', 'justg_footer_berita');
function justg_footer_berita()
{
	require_once(get_stylesheet_directory() . '/inc/part-footer.php');
}

/**
 * Ikon SVG (pengganti Font Awesome).
 */
function velocityberita6_icon($name, $size = 16)
{
	$paths = array(
		'search'    => '<path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>',
		'facebook'  => '<path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951"/>',
		'twitter'   => '<path d="M12.6.75h2.454l-5.36 6.142L16 15.25h-4.937l-3.867-5.07-4.425 5.07H.316l5.733-6.57L0 .75h5.063l3.495 4.633L12.601.75Zm-.86 13.028h1.36L4.323 2.145H2.865z"/>',
		'instagram' => '<path d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.9 3.9 0 0 0-1.417.923A3.9 3.9 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.9 3.9 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.9 3.9 0 0 0-.923-1.417A3.9 3.9 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599s.453.546.598.92c.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.5 2.5 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.5 2.5 0 0 1-.92-.598 2.5 2.5 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233s.008-2.388.046-3.231c.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92s.546-.453.92-.598c.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92m-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217m0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334"/>',
		'youtube'   => '<path d="M8.051 1.999h.089c.822.003 4.987.033 6.11.335a2.01 2.01 0 0 1 1.415 1.42c.101.38.172.883.22 1.402l.01.104.022.26.008.104c.065.914.073 1.77.074 1.957v.075c-.001.194-.01 1.108-.082 2.06l-.008.105-.009.104c-.05.572-.124 1.14-.235 1.558a2.01 2.01 0 0 1-1.415 1.42c-1.16.312-5.569.334-6.18.335h-.142c-.309 0-1.587-.006-2.927-.052l-.17-.006-.087-.004-.171-.007-.171-.007c-1.11-.049-2.167-.128-2.654-.26a2.01 2.01 0 0 1-1.415-1.419c-.111-.417-.185-.986-.235-1.558L.09 9.82l-.008-.104A31 31 0 0 1 0 7.68v-.123c.002-.215.01-.958.064-1.778l.007-.103.003-.052.008-.104.022-.26.01-.104c.048-.519.119-1.023.22-1.402a2.01 2.01 0 0 1 1.415-1.42c.487-.13 1.544-.21 2.654-.26l.17-.007.172-.006.086-.003.171-.007A100 100 0 0 1 7.858 2zM6.4 5.209v4.818l4.157-2.408z"/>',
		'tiktok'    => '<path d="M9 0h1.98c.144.715.54 1.617 1.235 2.512C12.895 3.389 13.797 4 15 4v2c-1.753 0-3.07-.814-4-1.829V11a5 5 0 1 1-5-5v2a3 3 0 1 0 3 3z"/>',
		'whatsapp'  => '<path d="M13.601 2.326A7.85 7.85 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.9 7.9 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.9 7.9 0 0 0 13.6 2.326zM7.994 14.521a6.6 6.6 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.56 6.56 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592m3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.73.73 0 0 0-.529.247c-.182.198-.691.677-.691 1.654s.71 1.916.81 2.049c.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232"/>',
		'telegram'  => '<path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8.287 5.906q-1.168.486-4.666 2.01-.567.225-.595.442c-.03.243.275.339.69.47l.175.055c.408.133.958.288 1.243.294q.39.01.868-.32 3.269-2.206 3.374-2.23c.05-.012.12-.026.166.016s.042.12.037.141c-.03.129-1.227 1.241-1.846 1.817-.193.18-.33.307-.358.336a8 8 0 0 1-.188.186c-.38.366-.664.64.015 1.088.327.216.589.393.85.571.284.194.568.387.936.629q.14.092.27.187c.331.236.63.448.997.414.214-.02.435-.22.547-.82.265-1.417.786-4.486.906-5.751a1.4 1.4 0 0 0-.013-.315.34.34 0 0 0-.114-.217.53.53 0 0 0-.31-.093c-.3.005-.763.166-2.984 1.09"/>',
		'bookmark'  => '<path d="M2 2v13.5a.5.5 0 0 0 .74.439L8 13.069l5.26 2.87A.5.5 0 0 0 14 15.5V2a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2"/>',
		'prev'      => '<path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0"/>',
		'next'      => '<path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708"/>',
		'caret'     => '<path d="m12.14 8.753-5.482 4.796c-.646.566-1.658.106-1.658-.753V3.204a1 1 0 0 1 1.659-.753l5.48 4.796a1 1 0 0 1 0 1.506z"/>',
	);

	if (!isset($paths[$name])) {
		return '';
	}

	return '<svg xmlns="http://www.w3.org/2000/svg" width="' . absint($size) . '" height="' . absint($size) . '" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true" focusable="false">' . $paths[$name] . '</svg>';
}

/**
 * Judul blok bergaya pita warna tema + ikon bookmark.
 */
function velocityberita6_heading($title, $link = '', $tag = 'h3')
{
	$tag   = in_array($tag, array('h2', 'h3', 'h4', 'h5', 'h6'), true) ? $tag : 'h3';
	$title = esc_html($title);
	if ($link) {
		$title = '<a href="' . esc_url($link) . '">' . $title . '</a>';
	}
	echo '<' . $tag . ' class="heading-theme position-relative"><span>' . $title . '</span>';
	echo '<span class="heading-mark color-theme">' . velocityberita6_icon('bookmark', 30) . '</span>';
	echo '</' . $tag . '>';
}

/**
 * Gambar unggulan artikel dengan srcset; fallback gambar pertama di konten
 * lalu no-image.
 */
function velocityberita6_thumb($size = 'medium', $attr = array(), $post_id = null)
{
	$post_id = $post_id ? $post_id : get_the_ID();
	$attr    = wp_parse_args($attr, array(
		'class'    => 'w-100 h-100 object-fit-cover',
		'alt'      => get_the_title($post_id),
		'loading'  => 'lazy',
		'decoding' => 'async',
	));

	if (has_post_thumbnail($post_id)) {
		return get_the_post_thumbnail($post_id, $size, $attr);
	}

	$src     = get_stylesheet_directory_uri() . '/img/no-image.webp';
	$content = get_post_field('post_content', $post_id);
	if ($content && preg_match('/<img[^>]+src=[\'"]([^\'"]+)[\'"]/i', $content, $match)) {
		$src = $match[1];
	}

	$html = '<img src="' . esc_url($src) . '"';
	foreach ($attr as $key => $value) {
		$html .= ' ' . esc_attr($key) . '="' . esc_attr($value) . '"';
	}

	return $html . '>';
}

function get_berita_iklan($idiklan)
{
	$iklan_content = velocitytheme_option('image_' . $idiklan, '');
	if (!$iklan_content) {
		return;
	}

	$linkiklan = velocitytheme_option('link_' . $idiklan, '');
	echo '<div class="part_' . esc_attr($idiklan) . ' theme-slot mb-3 text-center">';
	echo $linkiklan ? '<a href="' . esc_url($linkiklan) . '" target="_blank" rel="noopener nofollow sponsored">' : '';
	echo '<img class="img-fluid" src="' . esc_url($iklan_content) . '" alt="' . esc_attr(get_bloginfo('name')) . '" loading="lazy" decoding="async">';
	echo $linkiklan ? '</a>' : '';
	echo '</div>';
}

function vdberita_limit_text($text, $limit)
{
	return wp_trim_words($text, $limit, '...');
}

/**
 * Hitung tayangan artikel (meta `hit`) bila velocity-addons tidak aktif;
 * velocity-addons sudah menghitung meta yang sama.
 */
add_action('template_redirect', 'tambahkan_hit_ke_post_meta', 20);
function tambahkan_hit_ke_post_meta()
{
	if (!is_singular('post') || is_preview() || class_exists('Velocity_Addons_Statistic')) {
		return;
	}

	$post_id = get_queried_object_id();
	update_post_meta($post_id, 'hit', absint(get_post_meta($post_id, 'hit', true)) + 1);
}

function justg_get_hit()
{
	echo absint(get_post_meta(get_the_ID(), 'hit', true));
}

/**
 * Argumen query terpopuler: artikel tanpa meta `hit` tetap ikut di urutan bawah.
 */
function velocityberita6_popular_args($args = array())
{
	return array_merge($args, array(
		'meta_query' => array(
			'relation'   => 'OR',
			'hit_clause' => array('key' => 'hit', 'type' => 'NUMERIC'),
			array('key' => 'hit', 'compare' => 'NOT EXISTS'),
		),
		'orderby'    => array('hit_clause' => 'DESC', 'date' => 'DESC'),
	));
}

function justg_get_sosmed()
{
	foreach (velocityberita6_sosmed_list() as $key => $data) {
		$default  = 'tiktok' === $key ? '' : 'https://' . $key . '.com/';
		$datalink = velocitytheme_option('link_sosmed_' . $key, $default);
		if ($datalink) {
			echo '<a class="btn-sosmed" style="--sosmed:' . esc_attr($data[1]) . ';" href="' . esc_url($datalink) . '" target="_blank" rel="noopener noreferrer" aria-label="' . esc_attr($data[0]) . '">' . velocityberita6_icon($key, 14) . '</a>';
		}
	}
}

/**
 * Tombol bagikan artikel.
 */
function velocityberita6_share()
{
	$url   = rawurlencode(get_permalink());
	$title = rawurlencode(html_entity_decode(get_the_title(), ENT_QUOTES, 'UTF-8'));
	$links = array(
		'facebook' => array('Facebook', '#2d59a1', 'https://www.facebook.com/sharer/sharer.php?u=' . $url),
		'twitter'  => array('X', '#111111', 'https://twitter.com/intent/tweet?text=' . $title . '&url=' . $url),
		'whatsapp' => array('WhatsApp', '#25d366', 'https://api.whatsapp.com/send?text=' . $title . '%20' . $url),
		'telegram' => array('Telegram', '#229ed9', 'https://t.me/share/url?url=' . $url . '&text=' . $title),
	);

	echo '<div class="share-buttons d-flex align-items-center flex-wrap gap-1"><small class="me-1 opacity-75">' . esc_html__('Bagikan:', 'justg') . '</small>';
	foreach ($links as $key => $data) {
		echo '<a class="btn-sosmed" style="--sosmed:' . esc_attr($data[1]) . ';" href="' . esc_url($data[2]) . '" target="_blank" rel="noopener nofollow" aria-label="' . esc_attr(sprintf(__('Bagikan ke %s', 'justg'), $data[0])) . '">' . velocityberita6_icon($key, 14) . '</a>';
	}
	echo '</div>';
}

/**
 * Baris info artikel: penulis, tanggal, kategori.
 */
function velocityberita6_post_meta($max_cat = 3)
{
	echo '<small>' . esc_html__('Oleh', 'justg') . ' ' . esc_html(get_the_author()) . '</small>';
	echo '<small class="ms-2"><time datetime="' . esc_attr(get_the_date('c')) . '">' . esc_html(get_the_date()) . '</time></small>';

	$categories = get_the_category();
	if ($categories && $max_cat > 0) {
		$links = array();
		foreach (array_slice($categories, 0, $max_cat) as $cat) {
			$links[] = '<a href="' . esc_url(get_category_link($cat->term_id)) . '">' . esc_html($cat->name) . '</a>';
		}
		echo '<small class="ms-2">' . implode(', ', $links) . '</small>';
	}
}

/**
 * Breadcrumb: halaman arsip memakai judul arsip (breadcrumb induk di arsip
 * kategori mengambil kategori artikel pertama, bukan kategori yang dibuka).
 */
function velocityberita6_breadcrumb()
{
	if (is_singular() || !(is_archive() || is_search())) {
		echo justg_breadcrumb();
		return;
	}

	$title = is_search() ? sprintf(__('Hasil pencarian: %s', 'justg'), get_search_query()) : wp_strip_all_tags(get_the_archive_title());
	echo '<div class="breadcrumbs pb-2"><div class="breadcrumbs-inner">';
	echo '<a href="' . esc_url(home_url('/')) . '">' . esc_html__('Home', 'justg') . '</a><span class="separator"> / </span>';
	echo '<span aria-current="page">' . esc_html($title) . '</span>';
	echo '</div></div>';
}
