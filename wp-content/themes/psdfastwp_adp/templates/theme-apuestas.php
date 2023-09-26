<?php
/* Template Name: Template - Apuestas */
get_header(); ?>
<section class="components">
	<div class="wrapper clearfix">
		<div class="adp_content">
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<h1><?php the_title(); ?></h1>

			<figure class="post_thumbnail"><?php the_post_thumbnail(); ?></figure>
			
			<?php the_content(); ?>
		<?php endwhile; else: ?>
            <p><?php __('Sorry, no posts matched your criteria.', 'misresultados_pe');?></p>
		<?php endif; ?>

		<?php echo do_shortcode('[estract_probabilidades]') ?>
		
		</div>
		<div class="adp_sidebar">
			<?php if ( is_active_sidebar( 'sidebar-right' ) ) : ?>
                <div class="clearfix">
                    <?php dynamic_sidebar( 'sidebar-right' ); ?>
                </div>
            <?php endif; ?>
		</div>
		
	</div>
</section>

<?php get_footer(); ?>