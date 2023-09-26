<?php get_header(); ?>
<section class="components">
	<div class="wrapper clearfix">
		<div class="adp_content">
			<?php
 		if ( function_exists('yoast_breadcrumb') ) {
 			yoast_breadcrumb( '<p id="breadcrumbs">','</p>' );
 		}
 		?>
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<h1><?php the_title(); ?></h1>
			<?php the_content(); ?>
		<?php endwhile; else: ?>
            <p><?php __('Sorry, no posts matched your criteria.', 'misresultados_pe');?></p>
		<?php endif; ?>
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
