<?php /* Template Name: SDAPI */ ?>

<?php get_header(); ?>

<script type='text/javascript'>
    jQuery(function () {
        jQuery('.page-template').addClass('home');
    });
</script>

<main id="page-sdapi" class="site-main">

	<section class="carousel-wrapper">
		<?php
		if (idg_wp_get_option('_main_carousel_custom')) {
			if (is_active_sidebar(idg_wp_get_option('_home_widgets_carousel_sidebar'))) :
				dynamic_sidebar(idg_wp_get_option('_home_widgets_carousel_sidebar'));
			endif;
		} else {
			get_template_part('template-parts/jumbotron-carousel');
		} ?>
	</section>

	<section id="news" class="pb-5 pt-5">
		<div class="container">
			<div class="row">
				<div class="overflow-wrapper">
					<?php
					$categorias = get_categories(array('orderby' => 'name', 'order' => 'ASC'));
					for ($i = 0; $i < 3; $i++):
						$args = array(
							'posts_per_page' => 1,
							'category_name' => $categorias[$i]->slug
						);
						$news_query = new WP_Query($args);
						if ($news_query->have_posts()) : ?>
							<?php while ($news_query->have_posts()) : $news_query->the_post(); ?>
								<div class="col-lg-4 mb-5">
									<?php
									if (has_post_thumbnail()) :
										$post_thumb = get_the_post_thumbnail_url(get_the_ID(), 'highlight-box');
									else :
										$post_thumb = get_template_directory_uri() . '/assets/img/fake-img.jpg';
									endif;
									?>
									<div class="highlight-box"
										 style="background-image: url('<?php echo $post_thumb; ?>')">
										<div class="box-body">
											<?php if ($post_subtitle = get_post_meta($post->ID, '_post_subtitle', true)): ?>
												<span class="cat"><?php echo $post_subtitle ?></span>
											<?php endif; ?>
											<h3 class="box-title">
												<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
											</h3>
										</div>
									</div>
								</div>
							<?php endwhile;
							wp_reset_postdata();
							?>
						<?php endif;
					endfor;
					?>
				</div>
				<div class="col-lg-12 text-center">
					<a href="<?php echo home_url('/categoria/noticias/'); ?>" class="btn text-uppercase mt-1">Mais
						notícias</a>
				</div>
			</div>
		</div>
	</section>

	<?php if (!idg_wp_get_option('_home_widgets_sections_disable')): ?>
		<?php
		$idg_wp_widgets_areas = get_theme_mod('idg_wp_widgets_areas');
		foreach ($idg_wp_widgets_areas['areas'] as $chaveArea => $valorArea) :
			if (strtolower($valorArea['name']) == 'sdapi'):
				?>
				<section id="<?php echo $chaveArea; ?>"
						 class="<?php echo empty($valorArea['section_class']) ? 'mt-5 mb-5 pt-4' : $valorArea['section_class']; ?>">
					<div class="container">
						<div class="row">
							<?php if ($valorArea['section_title']): ?>
								<div class="col-lg-12">
									<h2 class="section-title mb-5 text-center"><?php echo $valorArea['section_title']; ?></h2>
								</div>
							<?php endif; ?>
							<div class="overflow-wrapper">
								<?php
								if (is_active_sidebar($chaveArea)) :
									dynamic_sidebar($chaveArea);
								endif;
								?>
							</div>
						</div>
					</div>
				</section>
			<?php
			endif;
		endforeach; ?>
	<?php endif; ?>

	<section id="multimidia" class="mt-5">
		<div class="container">
			<div class="row">
				<?php get_template_part('template-parts/multimedia-block'); ?>

				<a href="<?php echo get_bloginfo('url'); ?>/multimedia" class="btn btn-ver-mais">Mais Vídeos</a>
			</div>
		</div>
	</section>

</main>

<?php get_footer(); ?>

