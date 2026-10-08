<?php
/**
 * Kartu artikel dipakai di beranda, single, dan widget.
 * Dipanggil di dalam loop (the_post()).
 */
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

function module_cardposts($style)
{
    $link  = esc_url(get_permalink());
    $title = esc_html(get_the_title());
    $date  = '<small class="opacity-75"><time datetime="' . esc_attr(get_the_date('c')) . '">' . esc_html(get_the_date()) . '</time></small>';

    switch ((string) $style) {
        case '1':
            echo '<div class="row g-2">';
                echo '<div class="col-4">';
                    echo '<a class="d-block ratio ratio-1x1 bg-light overflow-hidden" href="' . $link . '" tabindex="-1" aria-hidden="true">' . velocityberita6_thumb('thumbnail') . '</a>';
                echo '</div>';
                echo '<div class="col-8">';
                    echo '<a class="d-block mb-1 judul-3-baris" href="' . $link . '">' . $title . '</a>';
                    echo $date;
                echo '</div>';
            echo '</div>';
            break;
        case '2':
            echo '<a class="d-block ratio ratio-16x9 bg-light overflow-hidden mb-2" href="' . $link . '" tabindex="-1" aria-hidden="true">' . velocityberita6_thumb('medium') . '</a>';
            echo '<a class="d-block mb-1 fw-semibold judul-3-baris" href="' . $link . '">' . $title . '</a>';
            echo $date;
            break;
        case '3':
            echo '<div class="d-block position-relative overflow-hidden cardposts-3">';
                echo '<a class="ratio ratio-4x3 bg-light" href="' . $link . '" tabindex="-1" aria-hidden="true">' . velocityberita6_thumb('medium') . '</a>';
                echo '<div class="cardposts-3-title position-absolute bottom-0 end-0 start-0 p-2 bg-color-theme">';
                    echo '<a class="text-white judul-2-baris" href="' . $link . '">' . $title . '</a>';
                echo '</div>';
            echo '</div>';
            break;
        case '4':
            echo '<div class="posts-item d-flex">';
                echo '<span class="me-2 color-theme flex-shrink-0">' . velocityberita6_icon('caret', 12) . '</span>';
                echo '<a class="d-block" href="' . $link . '">' . $title . '</a>';
            echo '</div>';
            break;
        case '5':
            echo '<div class="position-relative">';
                echo '<a class="d-block ratio ratio-16x9 bg-secondary overflow-hidden" href="' . $link . '" tabindex="-1" aria-hidden="true">' . velocityberita6_thumb('large', array('sizes' => '(min-width: 992px) 620px, 100vw')) . '</a>';
                echo '<div class="cardposts-5-title position-absolute end-0 start-0 bottom-0 p-3">';
                    echo '<h2 class="fs-6 m-0 fw-bold lh-sm"><a href="' . $link . '" class="text-white" rel="bookmark">' . $title . '</a></h2>';
                    echo '<small class="text-white opacity-75">' . esc_html(get_the_date()) . '</small>';
                echo '</div>';
            echo '</div>';
            break;
        case '6':
            echo '<div class="bg-light shadow-sm p-3 h-100">';
                echo '<div class="row g-2">';
                    echo '<div class="col-4">';
                        echo '<a class="d-block ratio ratio-1x1 bg-secondary overflow-hidden" href="' . $link . '" tabindex="-1" aria-hidden="true">' . velocityberita6_thumb('thumbnail') . '</a>';
                    echo '</div>';
                    echo '<div class="col-8">';
                        echo '<a class="d-block fw-bold judul-4-baris" href="' . $link . '" rel="bookmark">' . $title . '</a>';
                    echo '</div>';
                echo '</div>';
            echo '</div>';
            break;
        default:
            echo '<div class="posts-item">';
            echo '<a href="' . $link . '">' . $title . '</a>';
            echo '</div>';
            break;
    }
}
