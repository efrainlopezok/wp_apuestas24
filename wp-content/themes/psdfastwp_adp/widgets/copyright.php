<?php

/**

 * @author Miguel Fuentes <fuentessoft@gmail.com>

 */

class Widget_customCopyright extends WP_Widget

{



    function __construct()

    {

        $widget_ops = array('classname' => 'widget_custom_copyright', 'description' => 'Displays info of copyright');

        parent::__construct('custom_copyright_widget', 'Staff Digital - Copyright', $widget_ops);

    }



    function form($instance)

    {

        $instance = wp_parse_args( $instance, array(

            'title' => __('Copyright', 'apuestas_deportivas'),

			'texto' => '',

			'empresa' => '',

			'url' => '',

        ));

        ?>

        <p>

            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'apuestas_deportivas'); ?>: </label><br>

            <input class="widefat" type="text" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo esc_attr($instance['title']); ?>" />

        </p>

        

        <p>

            <label for="<?php echo $this->get_field_id('texto'); ?>"><?php _e('Textos', 'apuestas_deportivas'); ?>: </label><br>

            <input class="widefat" type="text" id="<?php echo $this->get_field_id('texto'); ?>" name="<?php echo $this->get_field_name('texto'); ?>" value="<?php echo esc_attr($instance['texto']); ?>" />

        </p>

        

        <p>

            <label for="<?php echo $this->get_field_id('empresa'); ?>"><?php _e('Nombre empresa', 'apuestas_deportivas'); ?>: </label><br>

            <input class="widefat" type="text" id="<?php echo $this->get_field_id('empresa'); ?>" name="<?php echo $this->get_field_name('empresa'); ?>" value="<?php echo esc_attr($instance['empresa']); ?>" />

        </p>

        

        <p>

            <label for="<?php echo $this->get_field_id('url'); ?>"><?php _e('Url web', 'apuestas_deportivas'); ?>: </label><br>

            <input class="widefat" type="text" id="<?php echo $this->get_field_id('url'); ?>" name="<?php echo $this->get_field_name('url'); ?>" value="<?php echo esc_attr($instance['url']); ?>" />

        </p>





        <?php

    }



    function update($new_instance, $old_instance)

    {

        $validated = array();

        $validated['title'] = sanitize_text_field($new_instance['title']);

		$validated['texto'] = sanitize_text_field($new_instance['texto']);

		$validated['empresa'] = sanitize_text_field($new_instance['empresa']);

		$validated['url'] = sanitize_text_field($new_instance['url']);

        return $validated;

    }



    function widget($args, $instance)

    {



        $title	= apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );



		echo $args['before_widget'];

		if ( ! empty( $title ) ) {

			echo '<h3 class="title_widget">' . $title . '</h3>';

		}



		$data_texto	= $instance['texto'];

		$data_empresa	= $instance['empresa'];

		$data_url	= $instance['url'];

		?>

		<?php if(!empty($data_url)) { ?>

            <span>

            <?php echo $data_texto ?> <a class="copyright_link" title="<?php echo $data_empresa ?>" target="_blank" href="<?php echo $data_url ?>"><?php echo $data_empresa ?></a>

            </span>

        <?php } ?>

		<?php

		echo $args['after_widget'];

		

    }



    public function render($instance){}

}