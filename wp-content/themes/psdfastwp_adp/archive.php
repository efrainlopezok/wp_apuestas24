<?php  get_header(); ?>
<section class="components">
	<div class="wrapper clearfix">
		<div class="adp_content">
			<h3 class="section-title"><?php printf( __( 'Categoría: %s', 'apuestas_deportivas' ), single_cat_title( '', false ) ); ?></h3>
			<div class="content_block_info">
				<div class="news_day">
					<?php while ($wp_query->have_posts()) : $wp_query->the_post(); ?>
						<?php get_template_part( 'content', 'post'); ?>
					<?php endwhile; wp_reset_query(); ?>
				</div>
			</div>
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