<?php
/**
 * Footer Berita 6.
 */
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}
?>
<footer class="site-footer pb-3 mt-4" id="colophon">

    <div class="bg-color-theme py-1 mb-3"></div>

    <?php
    $footer_widgets = array();
    for ($x = 1; $x <= 3; $x++) {
        if (is_active_sidebar('footer-widget-' . $x)) {
            $footer_widgets[] = 'footer-widget-' . $x;
        }
    }
    if ($footer_widgets) :
        ?>
        <div class="row footer-widgets">
            <?php foreach ($footer_widgets as $sidebar) : ?>
                <div class="col-md">
                    <?php dynamic_sidebar($sidebar); ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <div class="site-info bg-color-theme text-white text-center p-2">
        <small>
            &copy; <?php echo esc_html(date_i18n('Y')); ?> <?php echo esc_html(get_bloginfo('name')); ?>. All Rights Reserved.
            <br>
            Design by <a class="text-white opacity-75" href="https://velocitydeveloper.com" target="_blank" rel="noopener noreferrer">Velocity Developer</a>
        </small>
    </div>

</footer>
