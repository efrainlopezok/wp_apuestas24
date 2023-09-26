<?php

/**
 * @author Miguel Fuentes <fuentessoft@gmail.com>
 */

class Widget_customSlider extends WP_Widget
{
    function __construct(){
        $widget_ops = array('classname' => 'widget_custom_slider', 'description' => 'Displays Sliders');
        parent::__construct('custom_sliders', 'Slider +', $widget_ops);
    }
    function form($instance){
 		$instance = wp_parse_args( (array) $instance, array(
            'title' => __('', 'misresultados_pe'),
			'pg_styleSlider' => '',		
		) );
		$types1 = explode(',', $types1);
		?>
 <p>
  <label for="<?php echo $this->get_field_id('title'); ?>">
    <?php _e('Title', 'misresultados_pe'); ?>: </label><br>
  <input class="widefat" type="text" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo esc_attr($instance['title']); ?>" />
</p>

<p><label for="<?php echo $this->get_field_id('facebook'); ?>"><?php _e('Seleccionar la categoria de Slider', 'misresultados_pe'); ?>: </label><br>


<!-- -->

<?php 
	$custom_terms = get_terms('categoria-de-slider'); ?>
    <select class="widefat" id="<?php echo $this->get_field_id('pg_styleSlider'); ?>" name="<?php echo $this->get_field_name('pg_styleSlider'); ?>">
    <?php
	foreach($custom_terms as $custom_term) {
		wp_reset_query();
		$args = array('post_type' => 'slider', 'posts_per_page' => -1, 'post_status' => 'publish',
			'tax_query' => array(
			array(
				'taxonomy' => 'categoria-de-slider',
                'field' => 'slug',
                'terms' => $custom_term->slug,
                ),),
		);
		$loop = new WP_Query($args);
			if($loop->have_posts()) { ?>
                 <optgroup label="<?php echo $custom_term->name ?>"> 
				<?php
				while($loop->have_posts()) : $loop->the_post(); ?>
                	<option value="<?php the_ID(); ?>" <?php selected(get_the_ID(), $instance['pg_styleSlider']); ?>>
						Categoria Slider - <?php the_title(); ?> - <?php echo $custom_term->name ?>
                	</option>
                <?php 
                endwhile;
                echo "</optgroup>";
			}
	} // end foreach
	echo '</select>';
?>

<!-- -->
 
</p>

<?php  return array($instance); ?>
     
	<?php
    }
    function update($new_instance, $old_instance) {
		$instance    = $old_instance;
        $instance = array();
        $instance['title'] = sanitize_text_field($new_instance['title']);
		$instance['pg_styleSlider'] = $new_instance['pg_styleSlider'];
		$types1 = implode(',', (array)$new_instance['pg_styleSlider']);
        return $instance;
    }

    function widget($args, $instance){
        extract($args, EXTR_SKIP);
        echo $before_widget;
        $this->render($instance);
        echo $after_widget;
    }

    public function render($instance){ 
		$postID  = $instance['pg_styleSlider'];
		?>
        <div class="banner_wrapper">
            <div class="banner"> 
                 
				 
            </div>
        </div>
        <br>
	<?php
    }

}
?>