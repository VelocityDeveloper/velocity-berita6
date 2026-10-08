<?php
/**
 * WIDGET POST BERITA 6
 */
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

class Posts_Berita_6_Widget extends WP_Widget {
    function __construct() {
        parent::__construct(
            'Posts_Berita_6_Widget',
            __('Berita 6 Posts', 'velocity'),
            array( 'description' => __( 'Menampilkan postingan template berita 6', 'velocity' ), )
        );
    }

    public function form( $instance ) {
        $title      = ! empty( $instance['title'] ) ? $instance['title'] : '';
        $style      = isset( $instance['style'] ) ? $instance['style'] : '1';
        $urutkan    = isset( $instance['urutkan'] ) ? $instance['urutkan'] : 'recent';
        $jumlah     = isset( $instance['jumlah'] ) ? $instance['jumlah'] : '5';
        $cat        = isset( $instance['cat'] ) ? $instance['cat'] : '';
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Judul:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'style' ); ?>"><?php _e( 'Style:' ); ?></label>
            <select class="widefat" id="<?php echo $this->get_field_id( 'style' ); ?>" name="<?php echo $this->get_field_name( 'style' ); ?>">
                <option value="1" <?php selected( $style, '1' ); ?>><?php _e( 'Style 1' ); ?></option>
                <option value="2" <?php selected( $style, '2' ); ?>><?php _e( 'Style 2' ); ?></option>
                <option value="3" <?php selected( $style, '3' ); ?>><?php _e( 'Style 3' ); ?></option>
                <option value="4" <?php selected( $style, '4' ); ?>><?php _e( 'Style 4' ); ?></option>
                <option value="5" <?php selected( $style, '5' ); ?>><?php _e( 'Style 5' ); ?></option>
            </select>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'cat' ); ?>"><?php _e( 'Kategori :' ); ?></label>
            <span class="d-block"><?php wp_dropdown_categories(['selected'=>$cat,'name'=>$this->get_field_name( 'cat' ),'id'=>$this->get_field_id( 'cat' ),'class'=>'widefat','show_count'=>true,'show_option_all'=>__('Semua Kategori', 'velocity'),'hide_empty'=>false]); ?></span>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'urutkan' ); ?>"><?php _e( 'Urutkan berdasarkan:' ); ?></label>
            <select class="widefat" id="<?php echo $this->get_field_id( 'urutkan' ); ?>" name="<?php echo $this->get_field_name( 'urutkan' ); ?>">
                <option value="recent" <?php selected( $urutkan, 'recent' ); ?>><?php _e('Terbaru' ); ?></option>
                <option value="popular" <?php selected( $urutkan, 'popular' ); ?>><?php _e( 'Terpopuler' ); ?></option>
            </select>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'jumlah' ); ?>"><?php _e( 'Jumlah:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'jumlah' ); ?>" name="<?php echo $this->get_field_name( 'jumlah' ); ?>" type="number" min="1" value="<?php echo esc_attr( $jumlah ); ?>">
        </p>
        <?php
    }

    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';
        $instance['style'] = ( ! empty( $new_instance['style'] ) ) ? sanitize_text_field( $new_instance['style'] ) : '1';
        $instance['urutkan'] = ( ! empty( $new_instance['urutkan'] ) ) ? sanitize_text_field( $new_instance['urutkan'] ) : 'recent';
        $instance['jumlah'] = ( ! empty( $new_instance['jumlah'] ) ) ? sanitize_text_field( $new_instance['jumlah'] ) : '5';
        $instance['cat'] = ( ! empty( $new_instance['cat'] ) ) ? sanitize_text_field( $new_instance['cat'] ) : '';

        return $instance;
    }
    public function widget( $args, $instance ) {
        $title      = apply_filters( 'widget_title', isset( $instance['title'] ) ? $instance['title'] : '' );
        $style      = isset( $instance['style'] ) ? $instance['style'] : '1';
        $urutkan    = isset( $instance['urutkan'] ) ? $instance['urutkan'] : 'recent';
        $jumlah     = isset( $instance['jumlah'] ) ? $instance['jumlah'] : '5';
        $cat        = isset( $instance['cat'] ) ? $instance['cat'] : '';

        echo $args['before_widget'];

            if ( ! empty( $title ) ) {
                echo $args['before_title'];
                $cat_link = $cat ? get_term_link( (int) $cat, 'category' ) : '';
                echo ($cat_link && !is_wp_error($cat_link)) ? '<a href="' . esc_url($cat_link) . '">' . esc_html($title) . '</a>' : esc_html($title);
                echo $args['after_title'];
            }

            $args_post = array(
                'post_type'           => 'post',
                'posts_per_page'      => absint($jumlah) ? absint($jumlah) : 5,
                'cat'                 => absint($cat),
                'ignore_sticky_posts' => true,
                'no_found_rows'       => true,
            );

            if ( $urutkan == 'popular' ) {
                $args_post = velocityberita6_popular_args($args_post);
            }
            
            // The Query
            $the_query = new WP_Query($args_post);

            // The Loop
            if ($the_query->have_posts()) {
                echo '<div class="row g-2">';
                    while ($the_query->have_posts()) {
                        $the_query->the_post();

                        if($style=='3'){
                            echo '<div class="col-6">';
                                module_cardposts(3);
                            echo '</div>';
                        } else {
                            echo '<div class="col-12 border-bottom pb-2">';
                                module_cardposts($style);
                            echo '</div>';
                        }

                    }
                echo '</div>';
            } else {
                echo '<p>' . __('Tidak ada post', 'velocity') . '</p>';
            }
            /* Restore original Post Data */
            wp_reset_postdata();

        echo $args['after_widget'];
    }

}

function register_Posts_Berita_6_Widget() {
    register_widget( 'Posts_Berita_6_Widget' );
}
add_action( 'widgets_init', 'register_Posts_Berita_6_Widget' );