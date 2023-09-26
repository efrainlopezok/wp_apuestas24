<?php

/**
 * @author Miguel Fuentes <fuentessoft@gmail.com>
 */

class Widget_customBanner extends WP_Widget
{
    function __construct(){
        $widget_ops = array('classname' => 'widget_custom_banner', 'description' => 'Displays Banners');
        parent::__construct('custom_banners', 'Banner +', $widget_ops);
    }
    function form($instance){
 		$instance = wp_parse_args( (array) $instance, array(
            'title' => __('Banner', 'misresultados_pe'),
			'pg_style1' => '',		
		) );
		$types1 = explode(',', $types1);
		?>
 <p>
  <label for="<?php echo $this->get_field_id('title'); ?>">
    <?php _e('Title', 'misresultados_pe'); ?>: </label><br>
  <input class="widefat" type="text" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo esc_attr($instance['title']); ?>" />
</p>

<p><label for="<?php echo $this->get_field_id('facebook'); ?>"><?php _e('Seleccionar El Banner + para mostrar', 'misresultados_pe'); ?>: </label><br>


<!-- -->

<?php 
	$custom_terms = get_terms('tipo-de-banners'); ?>
    <select class="widefat" id="<?php echo $this->get_field_id('pg_style1'); ?>" name="<?php echo $this->get_field_name('pg_style1'); ?>">
    <?php
	foreach($custom_terms as $custom_term) {
		wp_reset_query();
		$args = array('post_type' => 'banner', 'posts_per_page' => -1, 'post_status' => 'publish',
			'tax_query' => array(
			array(
				'taxonomy' => 'tipo-de-banners',
                'field' => 'slug',
                'terms' => $custom_term->slug,
                ),),
		);
		$loop = new WP_Query($args);
			if($loop->have_posts()) { ?>
                 <optgroup label="<?php echo $custom_term->name ?>"> 
				<?php
				while($loop->have_posts()) : $loop->the_post(); ?>
                	<option value="<?php the_ID(); ?>" <?php selected(get_the_ID(), $instance['pg_style1']); ?>>
						Banner - <?php the_title(); ?>
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
		$instance['pg_style1'] = $new_instance['pg_style1'];
		$types1 = implode(',', (array)$new_instance['pg_style1']);
        return $instance;
    }

    function widget($args, $instance){
        extract($args, EXTR_SKIP);
        echo $before_widget;
        $this->render($instance);
        echo $after_widget;
    }

    public function render($instance){ 
		$postID  = $instance['pg_style1'];
		?>
        <div class="banner_wrapper">
            <div class="banner"> 
                <?php $post_id = $postID;
                $queried_post = get_post($post_id);
                $title = $queried_post->post_title;?>
				<?php $meta = get_post_meta(($post_id), 'wpcf-opcion-del-link', true ); ?>
                
                <?php if( get_post_meta($post_id, 'wpcf-url-banner', true ) ) { ?>
					
					<?php if( checked( $meta, 1, false ) ) { ?>
                        <a href="<?php echo get_post_meta(($post_id), 'wpcf-url-banner', true); ?>" target="_blank" rel="nofollow" title="">
                            <?php echo get_the_post_thumbnail($post_id);  ?>
                        </a>
                     <?php } else { ?>
                        <a href="<?php echo get_post_meta(($post_id), 'wpcf-url-banner', true); ?>" rel="nofollow" title="">
                            <?php echo get_the_post_thumbnail($post_id);  ?>
                        </a>
                    <?php } ?>
                    
				<?php } else {?>
                	<?php echo get_the_post_thumbnail($post_id);  ?>
                <?php } ?>
                
            </div>
        </div>
        <br>
	<?php
    }

}
?>