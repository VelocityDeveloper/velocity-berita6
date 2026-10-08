<?php

/**
 * Pengaturan Customizer bawaan WordPress (pengganti Kirki).
 *
 * Nama setting sama dengan versi Kirki (theme_mod) sehingga isian lama
 * tetap terbaca setelah pembaruan.
 */
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

if (!function_exists('velocityberita6_default_color')) {
	function velocityberita6_default_color()
	{
		return '#3faf48';
	}
}

if (!function_exists('velocityberita6_ad_slots')) {
	/**
	 * Slot iklan: id => [label, keterangan ukuran].
	 */
	function velocityberita6_ad_slots()
	{
		return array(
			'iklan_header'       => array('Iklan Header', 'Sebelah logo, 728x90'),
			'iklan_home_1'       => array('Iklan Home 1', 'Halaman depan, 650x70'),
			'iklan_home_2'       => array('Iklan Home 2', 'Halaman depan di antara berita terbaru, 650x70'),
			'iklan_home_bawah_1' => array('Iklan Home Bawah 1', 'Halaman depan bawah, 600x80'),
			'iklan_home_bawah_2' => array('Iklan Home Bawah 2', 'Halaman depan bawah, 600x80'),
			'iklan_content'      => array('Iklan Single', 'Atas judul artikel, 650x70'),
			'iklan_content_2'    => array('Iklan Single 2', 'Atas gambar artikel, 650x70'),
			'iklan_content_3'    => array('Iklan Single 3', 'Akhir artikel, 650x70'),
			'iklan_archive'      => array('Iklan Archive', 'Arsip setelah artikel ke-1, 600x60'),
			'iklan_archive_2'    => array('Iklan Archive 2', 'Arsip setelah artikel ke-4, 600x60'),
		);
	}
}

if (!function_exists('velocityberita6_sosmed_list')) {
	/**
	 * Sosial media: id => [label, warna tombol].
	 */
	function velocityberita6_sosmed_list()
	{
		return array(
			'facebook'  => array('Facebook', '#2d59a1'),
			'twitter'   => array('X (Twitter)', '#111111'),
			'instagram' => array('Instagram', '#e72283'),
			'youtube'   => array('Youtube', '#dd2c26'),
			'tiktok'    => array('TikTok', '#000000'),
		);
	}
}

if (!function_exists('velocityberita6_sanitize_select')) {
	function velocityberita6_sanitize_select($value, $setting)
	{
		$value   = sanitize_text_field($value);
		$control = $setting->manager->get_control($setting->id);
		$choices = $control ? $control->choices : array();

		return array_key_exists($value, $choices) ? $value : $setting->default;
	}
}

if (!function_exists('velocityberita6_get_category_choices')) {
	function velocityberita6_get_category_choices()
	{
		$choices = array(
			''        => __('Semua Kategori', 'justg'),
			'disable' => __('Nonaktifkan', 'justg'),
		);

		$categories = get_categories(array('hide_empty' => false));
		foreach ($categories as $category) {
			$choices[(string) $category->term_id] = $category->name;
		}

		return $choices;
	}
}

add_action('customize_register', 'velocityberita6_customize_register', 20);
function velocityberita6_customize_register(WP_Customize_Manager $wp_customize)
{
	// Warna tema diatur dari panel Berita; bagian warna induk tidak dipakai child ini.
	$wp_customize->remove_section('velocity_section_colors');
	$wp_customize->remove_control('display_header_text');

	$wp_customize->add_panel('panel_berita', array(
		'title'    => __('Berita', 'justg'),
		'priority' => 10,
	));

	// Warna.
	$wp_customize->add_section('section_colorberita', array(
		'panel'       => 'panel_berita',
		'title'       => __('Warna', 'justg'),
		'description' => __('Latar halaman diatur di menu Background.', 'justg'),
		'priority'    => 10,
	));
	$wp_customize->add_setting('color_theme', array(
		'default'           => velocityberita6_default_color(),
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'color_theme', array(
		'label'   => __('Warna Tema', 'justg'),
		'section' => 'section_colorberita',
	)));

	// Iklan.
	$wp_customize->add_section('section_iklanberita', array(
		'panel'       => 'panel_berita',
		'title'       => __('Iklan', 'justg'),
		'description' => __('Slot yang gambarnya kosong tidak ditampilkan.', 'justg'),
		'priority'    => 20,
	));
	foreach (velocityberita6_ad_slots() as $slot => $data) {
		$wp_customize->add_setting('image_' . $slot, array(
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
		));
		$wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'image_' . $slot, array(
			'label'       => $data[0],
			'description' => $data[1],
			'section'     => 'section_iklanberita',
		)));
		$wp_customize->add_setting('link_' . $slot, array(
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
		));
		$wp_customize->add_control('link_' . $slot, array(
			'type'        => 'url',
			'label'       => sprintf(__('Link %s', 'justg'), $data[0]),
			'section'     => 'section_iklanberita',
			'input_attrs' => array('placeholder' => 'https://'),
		));
	}

	// Sosial media.
	$wp_customize->add_section('section_sosmedberita', array(
		'panel'       => 'panel_berita',
		'title'       => __('Sosial Media', 'justg'),
		'description' => __('Kosongkan link untuk menyembunyikan ikon.', 'justg'),
		'priority'    => 30,
	));
	foreach (velocityberita6_sosmed_list() as $id => $data) {
		$wp_customize->add_setting('link_sosmed_' . $id, array(
			'default'           => 'tiktok' === $id ? '' : 'https://' . $id . '.com/',
			'sanitize_callback' => 'esc_url_raw',
		));
		$wp_customize->add_control('link_sosmed_' . $id, array(
			'type'    => 'url',
			'label'   => sprintf(__('Link %s', 'justg'), $data[0]),
			'section' => 'section_sosmedberita',
		));
	}

	// Home.
	$wp_customize->add_section('section_homeberita', array(
		'panel'    => 'panel_berita',
		'title'    => __('Home', 'justg'),
		'priority' => 40,
	));
	$categories = velocityberita6_get_category_choices();
	$blocks     = array(
		'bigcarousel_home' => array('label' => 'Big Carousel Home'),
		'posts_home_1'     => array('label' => 'Posts Home 1', 'title' => 'Recent Posts'),
		'posts_home_2'     => array('label' => 'Posts Home 2', 'title' => 'Recent Posts'),
	);
	foreach ($blocks as $id => $data) {
		if (isset($data['title'])) {
			$wp_customize->add_setting('title_' . $id, array(
				'default'           => $data['title'],
				'sanitize_callback' => 'sanitize_text_field',
			));
			$wp_customize->add_control('title_' . $id, array(
				'type'    => 'text',
				'label'   => sprintf(__('Judul %s', 'justg'), $data['label']),
				'section' => 'section_homeberita',
			));
		}
		$wp_customize->add_setting('cat_' . $id, array(
			'default'           => '',
			'sanitize_callback' => 'velocityberita6_sanitize_select',
		));
		$wp_customize->add_control('cat_' . $id, array(
			'type'    => 'select',
			'label'   => sprintf(__('Kategori %s', 'justg'), $data['label']),
			'section' => 'section_homeberita',
			'choices' => $categories,
		));
	}
}

// Pratinjau warna tema langsung tanpa memuat ulang.
add_action('customize_preview_init', 'velocityberita6_customize_preview');
function velocityberita6_customize_preview()
{
	wp_add_inline_script(
		'customize-preview',
		"wp.customize('color_theme',function(v){v.bind(function(c){document.documentElement.style.setProperty('--color-theme',c);});});"
	);
}

// Latar bawaan desain Berita 6 untuk menu Background induk.
add_filter('justg_theme_default_settings', 'velocityberita6_default_settings');
function velocityberita6_default_settings($defaults)
{
	$defaults['background_website_color'] = '#f1f1f1';
	return $defaults;
}

/**
 * Migrasi sekali dari versi Kirki: latar dari field Kirki `background_themewebsite`
 * dipindah ke menu Background induk. Induk sudah menyimpan putih otomatis,
 * jadi putih bawaan itu diganti dengan latar yang selama ini tampil.
 */
add_action('after_setup_theme', 'velocityberita6_migrasi_kirki', 5);
function velocityberita6_migrasi_kirki()
{
	if (get_theme_mod('velocityberita6_migrasi', 0) >= 2) {
		return;
	}

	$legacy = get_theme_mod('background_themewebsite', array());
	$saved  = get_theme_mod('background_website_color', null);

	if (is_array($legacy) && !empty($legacy)) {
		$map = array(
			'background-color'      => 'background_website_color',
			'background-image'      => 'background_website_image',
			'background-repeat'     => 'background_website_repeat',
			'background-position'   => 'background_website_position',
			'background-size'       => 'background_website_size',
			'background-attachment' => 'background_website_attachment',
		);
		foreach ($map as $from => $to) {
			if (isset($legacy[$from]) && '' !== $legacy[$from]) {
				set_theme_mod($to, 'background-image' === $from ? esc_url_raw($legacy[$from]) : sanitize_text_field($legacy[$from]));
			}
		}
	} elseif (class_exists('Kirki') && (null === $saved || '#ffffff' === strtolower((string) $saved))) {
		// Field Kirki belum pernah disimpan: yang tampil adalah default Kirki #f1f1f1.
		set_theme_mod('background_website_color', '#f1f1f1');
	}

	set_theme_mod('velocityberita6_migrasi', 2);
}

/**
 * Warna tema, warna link, dan latar (latar dicetak di sini hanya bila plugin
 * Kirki aktif, karena induk tidak mencetak CSS Customizer-nya saat Kirki aktif).
 */
add_action('wp_head', 'velocityberita6_inline_css', 30);
function velocityberita6_inline_css()
{
	$color = sanitize_hex_color(velocitytheme_option('color_theme', velocityberita6_default_color()));
	$color = $color ? $color : velocityberita6_default_color();
	$css   = ':root{--color-theme:' . $color . ';}';
	// Warna link desain Berita 6 (menimpa warna bawaan induk).
	$css  .= ':root[data-bs-theme=light]{--bs-link-color:#333333;--bs-link-color-rgb:51,51,51;--bs-link-hover-color:' . $color . ';--bs-body-color:#212529;}';

	if (class_exists('Kirki')) {
		$bg    = velocitytheme_option('background_website', array());
		$bg    = is_array($bg) ? $bg : array();
		$hex   = sanitize_hex_color(isset($bg['background-color']) ? $bg['background-color'] : '');
		$rules = 'background-color:' . ($hex ? $hex : '#f1f1f1') . ';';
		$image = isset($bg['background-image']) ? esc_url($bg['background-image']) : '';
		if ($image) {
			$rules .= 'background-image:url("' . $image . '");';
			foreach (array('repeat', 'position', 'size', 'attachment') as $prop) {
				if (!empty($bg['background-' . $prop])) {
					$rules .= 'background-' . $prop . ':' . preg_replace('/[^a-z\- ]/', '', $bg['background-' . $prop]) . ';';
				}
			}
		}
		$css .= ':root[data-bs-theme=light] body{' . $rules . '}';
	}

	echo '<style id="velocityberita6-css">' . $css . '</style>';
}
