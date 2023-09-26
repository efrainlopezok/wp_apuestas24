<?php

/**
 * @author Miguel Fuentes <fuentessoft@gmail.com>
 */

class Widget_customContent extends WP_Widget
{
    function __construct(){
        $widget_ops = array('classname' => 'widget_content', 'description' => 'Mostrar Contenidos');
        parent::__construct('widget_content', 'AD - Content Widget', $widget_ops);
    }
    function form($instance){
 		$instance = wp_parse_args( (array) $instance, array(
            'title' => __('', 'misresultados_pe'),
			'show_widget_content' => '',		
		) );
		$types1 = explode(',', $types1);
		?>
 <p>
  <label for="<?php echo $this->get_field_id('title'); ?>">
    <?php _e('Titulo', 'misresultados_pe'); ?>: </label><br>
  <input class="widefat" type="text" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo esc_attr($instance['title']); ?>" />
</p>

<p><label for="<?php echo $this->get_field_id('contenido'); ?>"><?php _e('Seleccionar Contenido:', 'misresultados_pe'); ?>: </label><br>

<?php 
	$custom_terms = get_terms('seccion-widget'); ?>
    <select class="widefat" id="<?php echo $this->get_field_id('show_widget_content'); ?>" name="<?php echo $this->get_field_name('show_widget_content'); ?>">
    <?php
	foreach($custom_terms as $custom_term) {
		wp_reset_query();
		$args = array('post_type' => 'content-widget', 'posts_per_page' => -1, 'post_status' => 'publish',
			'tax_query' => array(
			array(
				'taxonomy' => 'seccion-widget',
                'field' => 'slug',
                'terms' => $custom_term->slug,
                ),),
		);
		$loop = new WP_Query($args);
			if($loop->have_posts()) { ?>
                 <optgroup label="<?php echo $custom_term->name ?>"> 
				<?php
				while($loop->have_posts()) : $loop->the_post(); ?>
                	<option value="<?php the_ID(); ?>" <?php selected(get_the_ID(), $instance['show_widget_content']); ?>>
						<?php the_title(); ?>
                	</option>
                <?php 
                endwhile;
                echo "</optgroup>";
			}
	}
	echo '</select>';
?>
</p>
 
<?php  return array($instance); ?>
     
	<?php
    }
    function update($new_instance, $old_instance) {
		$instance    = $old_instance;
        $instance = array();
        $instance['title'] = sanitize_text_field($new_instance['title']);
		$instance['show_widget_content'] = $new_instance['show_widget_content'];
		$types1 = implode(',', (array)$new_instance['show_widget_content']);
        return $instance;
    }

    function widget($args, $instance){	
		$title		= apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
		$widget_text = ! empty( $instance['content'] ) ? $instance['content'] : '';
		$content = apply_filters( 'widget_text', $widget_text, $instance, $this );

		echo $args['before_widget'];
		if ( ! empty( $title ) ) {
			echo '<h3 class="widget-title">' . $title . '</h3>';
		}
		?>
		<div class="textwidget">
			<?php
				$postID  = $instance['show_widget_content'];
				$post_id = $postID;
				$queried_post = get_post($post_id);
				$content = $queried_post->post_content;
                echo $content = apply_filters( 'the_content', $content);
                echo get_the_post_thumbnail($post_id);
			?>
        </div>
		<?php
		echo $args['after_widget'];
		
    }

    public function render($instance){ }

}
?>