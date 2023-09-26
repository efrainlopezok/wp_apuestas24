<?php

/**
 * @author Miguel Fuentes <fuentessoft@gmail.com>
 */

class Widget_Apuestas extends WP_Widget
{

    function __construct()
    {
        $widget_ops = array('classname' => 'widget_custom_apuestas', 'description' => 'Mostrar las apuestas del dia');
        parent::__construct('custom_apuestas_widget', 'AD - Apuestas del dia', $widget_ops);
    }

    function form($instance)
    {
        $instance = wp_parse_args( $instance, array(
            'title' => __('Apuestas del dia', 'apuestas_deportivas'),
        ));
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'apuestas_deportivas'); ?>: </label><br>
            <input class="widefat" type="text" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo esc_attr($instance['title']); ?>" />
        </p>
        <?php
    }

    function update($new_instance, $old_instance)
    {
        $validated = array();
        $validated['title'] = sanitize_text_field($new_instance['title']);
        return $validated;
    }

    function widget($args, $instance)
    {
        $title	= apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
		echo $args['before_widget'];
		if ( ! empty( $title ) ) {
			echo '<h3 class="widget-title">' . $title . '</h3>';
		}
		?>
		<?php
		echo $args['after_widget'];
    }
    public function render($instance){}
}