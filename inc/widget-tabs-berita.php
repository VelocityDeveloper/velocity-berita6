<?php
/**
 * WIDGET TABS BERITA 6
 */
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

class Tabs_Berita_6_Widget extends WP_Widget {
    function __construct() {
        parent::__construct(
            'tabs_berita_6_widget',
            __('Berita 6 Tabs', 'velocity'),
            array( 'description' => __( 'Menampilkan tabs template berita 6', 'velocity' ), )
        );
    }

    public function form( $instance ) {
        $title      = ! empty( $instance['title'] ) ? $instance['title'] : '';
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Judul:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
        </p>
        <?php
    }

    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';

        return $instance;
    }
    public function widget( $args, $instance ) {
        $title = apply_filters( 'widget_title', isset( $instance['title'] ) ? $instance['title'] : '' );
        $uid   = esc_attr( $this->id );

        echo $args['before_widget'];

            if ( ! empty( $title ) ) {
                echo $args['before_title'] . $title . $args['after_title'];
            }

            ?>

            <ul class="nav nav-tabs widget-tabs p-0" id="<?php echo $uid; ?>-tabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="<?php echo $uid; ?>-popular-tab" data-bs-toggle="tab" data-bs-target="#<?php echo $uid; ?>-popular" type="button" role="tab" aria-controls="<?php echo $uid; ?>-popular" aria-selected="true">
                        <?php esc_html_e( 'Populer', 'velocity' ); ?>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="<?php echo $uid; ?>-comments-tab" data-bs-toggle="tab" data-bs-target="#<?php echo $uid; ?>-comments" type="button" role="tab" aria-controls="<?php echo $uid; ?>-comments" aria-selected="false">
                        <?php esc_html_e( 'Komentar', 'velocity' ); ?>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="<?php echo $uid; ?>-tags-tab" data-bs-toggle="tab" data-bs-target="#<?php echo $uid; ?>-tags" type="button" role="tab" aria-controls="<?php echo $uid; ?>-tags" aria-selected="false">
                        <?php esc_html_e( 'Tag', 'velocity' ); ?>
                    </button>
                </li>
            </ul>
            <div class="tab-content pt-2" id="<?php echo $uid; ?>-content">
                <div class="tab-pane fade show active" id="<?php echo $uid; ?>-popular" role="tabpanel" aria-labelledby="<?php echo $uid; ?>-popular-tab" tabindex="0">
                    <?php
                    // The Query
                    $popular_query = new WP_Query(
                        velocityberita6_popular_args(
                            array(
                                'post_type'           => 'post',
                                'posts_per_page'      => 3,
                                'ignore_sticky_posts' => true,
                                'no_found_rows'       => true,
                            )
                        )
                    );
                    // The Loop
                    if ($popular_query->have_posts()) {
                        echo '<div class="tabpopular-post-part">';
                            while ($popular_query->have_posts()) {
                                $popular_query->the_post();
                                echo '<div class="tabpopular-post-item border-bottom pb-2 mb-2">';                                    
                                    module_cardposts(1);
                                echo '</div>';
                            }
                        echo '</div>';
                    }
                    /* Restore original Post Data */
                    wp_reset_postdata();
                    ?>
                </div>
                <div class="tab-pane fade" id="<?php echo $uid; ?>-comments" role="tabpanel" aria-labelledby="<?php echo $uid; ?>-comments-tab" tabindex="0">
                    <?php
                    // The Query
                    $postcomment_query = new WP_Query(
                        array(
                            'post_type'         => 'post',
                            'posts_per_page'    => 3,
                            'orderby'           => 'comment_count',
                            'order'             => 'DESC',
                            'ignore_sticky_posts' => true,
                            'no_found_rows'     => true,
                        )
                    );
                    // The Loop
                    if ($postcomment_query->have_posts()) {
                        echo '<div class="tabcomment-post-part">';
                        while ($postcomment_query->have_posts()) {
                            $postcomment_query->the_post();
                            echo '<div class="tabcomment-post-item border-bottom pb-1 mb-1">';
                                echo '<div class="row">';
                                    echo '<div class="col-3 text-center">';
                                        echo '<div class="fst-italic text-muted">';
                                            echo '<div class="fw-bold">' . get_comments_number() . '</div>';
                                            echo '<small>Komentar</small>';
                                        echo '</div>';
                                    echo '</div>';
                                    echo '<div class="col">';
                                        echo '<a class="fw-bold" href="' . esc_url( get_permalink() ) . '">' . esc_html( get_the_title() ) . '</a>';
                                        echo '<div class="text-muted"><small>' . esc_html( get_the_date() ) . '</small></div>';
                                    echo '</div>';
                                echo '</div>';
                            echo '</div>';
                        }
                        echo '</div>';
                    }
                    /* Restore original Post Data */
                    wp_reset_postdata();
                    ?>
                </div>
                <div class="tab-pane fade" id="<?php echo $uid; ?>-tags" role="tabpanel" aria-labelledby="<?php echo $uid; ?>-tags-tab" tabindex="0">
                    <?php
                    $tags = get_tags(array(
                        'orderby'   => 'count',
                        'order'     => 'DESC',
                        'number'    => 8,
                    ));
                    echo '<div class="tabpost_tags">';
                    foreach ($tags as $tag) {
                        echo '<a href="' . esc_url( get_tag_link( $tag->term_id ) ) . '" class="btn btn-sm btn-theme me-1 mb-1">' . esc_html( $tag->name ) . '</a>';
                    }
                    echo '</div>';
                    ?>
                </div>
            </div>

            <?php

        echo $args['after_widget'];
    }

}

function register_Tabs_Berita_6_Widget() {
    register_widget( 'Tabs_Berita_6_Widget' );
}
add_action( 'widgets_init', 'register_Tabs_Berita_6_Widget' );