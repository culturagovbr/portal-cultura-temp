<?php /* Template Name: SDAPI */ ?>

<?php

get_header();

/**
 * @param $index
 * @param $id
 * @return bool
 * @author Walquirio Saraiva Rocha
 * @version 1.0
 * @copyright desenvolvido para secretaria sdapi - exibir a section sdapi todos os itens de imagens e textos
 */
function wp_show_widget($index, $id)
{
	global $wp_registered_widgets, $wp_registered_sidebars;
	$did_one = false;

	if (!isset($wp_registered_widgets[$id])
		|| !isset($wp_registered_widgets[$id]['params'][0])) :
		return false;
	endif;

	$sidebars_widgets = wp_get_sidebars_widgets();
	if (empty($wp_registered_sidebars[$index])
		|| empty($sidebars_widgets[$index])
		|| !is_array($sidebars_widgets[$index])) :
		return false;
	endif;

	$sidebar = $wp_registered_sidebars[$index];
	$params = array_merge(
		array(array_merge($sidebar, array('widget_id' => $id, 'widget_name' => $wp_registered_widgets[$id]['name']))),
		(array)$wp_registered_widgets[$id]['params']
	);

	$classname_ = '';
	foreach ((array)$wp_registered_widgets[$id]['classname'] as $cn):
		if (is_string($cn)):
			$classname_ .= '_' . $cn;
		elseif (is_object($cn)):
			$classname_ .= '_' . get_class($cn);
		endif;
	endforeach;

	$classname_ = ltrim($classname_, '_');
	$params[0]['before_widget'] = sprintf($params[0]['before_widget'], $id, $classname_);
	$params = apply_filters('dynamic_sidebar_params', $params);

	$callback = $wp_registered_widgets[$id]['callback'];
	if (is_callable($callback)):
		call_user_func_array($callback, $params);
		$did_one = true;
	endif;

	return $did_one;
}

?>

<script type='text/javascript'>
    /*jQuery(function () {
        jQuery('.page-template').addClass('home');
    });*/
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

	<?php if (!idg_wp_get_option('_home_widgets_sections_disable')):
		$idg_wp_widgets_areas = get_theme_mod('idg_wp_widgets_areas');
		foreach ($idg_wp_widgets_areas['areas'] as $chaveArea => $valorArea) :
			if (strtolower($valorArea['name']) == 'sdapi'):
				?>
				<section id="<?php echo $chaveArea; ?>"
						 class="<?php echo empty($valorArea['section_class']) ? 'mt-5 mb-5 pt-4' : $valorArea['section_class']; ?>">
					<div class="container">
						<div class="row">
							<div class="overflow-wrapper">
								<?php
								is_active_sidebar($chaveArea);
								?>
							</div>
						</div>
					</div>
				</section>
			<?php
			endif;
		endforeach; ?>
	<?php endif; ?>

	<?php
	if (!idg_wp_get_option('_home_widgets_sections_disable')):
		$idg_wp_widgets_areas = get_theme_mod('idg_wp_widgets_areas');
		$widget_list = get_option('sidebars_widgets');

		foreach ($widget_list as $key=>$widget):
			foreach ($widget as $wid):
				foreach ($idg_wp_widgets_areas['areas'] as $chaveArea => $valorArea) :
					if (strtolower($valorArea['name']) == 'sdapi' && $chaveArea == $key):
						echo "<div class='container'>";
						wp_show_widget($chaveArea, $wid);
						echo "</div>";
					endif;
				endforeach;
			endforeach;
		endforeach;
	endif;
	?>

	<section id="participacao-social" class="mt-5 mb-5">
		<div class="container">
			<div class="row">
				<div class="overflow-wrapper">
					<?php
					if ( is_active_sidebar( 'social-participation-widgets-area' ) ) :
						dynamic_sidebar( 'social-participation-widgets-area' );
					endif;
					?>
				</div>
			</div>
		</div>
	</section>

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
