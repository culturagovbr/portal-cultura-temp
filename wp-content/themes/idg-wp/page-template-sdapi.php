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

<main id="page-sdapi" class="site-main">

	<?php if (!idg_wp_get_option('_home_widgets_sections_disable')):
		$idg_wp_widgets_areas = get_theme_mod('idg_wp_widgets_areas');
		foreach ($idg_wp_widgets_areas['areas'] as $chaveArea => $valorArea) :
			?>
			<section id="<?php echo $chaveArea; ?>">
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
		endforeach; ?>
	<?php endif; ?>

	<?php
	if (!idg_wp_get_option('_home_widgets_sections_disable')):
		$idg_wp_widgets_areas = get_theme_mod('idg_wp_widgets_areas');
		$widget_list = get_option('sidebars_widgets');
		$contador = 0;
		foreach ($widget_list as $key => $widget):
			foreach ($widget as $wid):
				foreach ($idg_wp_widgets_areas['areas'] as $chaveArea => $valorArea) :
					if (preg_match('/' . 'sdapi' . '/', $valorArea['section_title'])):
						$pattern1 = '/' . 'carousel' . '/';
						$pattern2 = '/' . 'text_image_box' . '/';
						$pattern3 = '/' . 'feature_card' . '/';
						$pattern4 = '/' . 'media_video' . '/';
						if (preg_match($pattern1, $wid) && $valorArea['section_title'] == 'carousel-sdapi'):
							?>
							<section class="carousel-wrapper">
								<?php
								wp_show_widget($chaveArea, $wid);
								?>
							</section>

							<section id="news" class="pb-5 pt-5">
							<div class="container">
							<div class="row">
							<div class="overflow-wrapper">
							<?php
							$categorias = get_categories(array('name' => 'sdapi'));
							$categoria = current($categorias);
							$args = array('category_name' => $categoria->slug, 'posts_per_page' => 3);
							$post_sdapi = new WP_Query($args);
							if ($post_sdapi->have_posts()) : ?>
								<?php
								foreach ($post_sdapi->posts as $post):
									?>
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
								<?php endforeach;
								wp_reset_postdata();
								?>
								</div>
								<div class="col-lg-12 text-center">
									<a href="<?php echo home_url('/categoria/sdapi/'); ?>"
									   class="btn text-uppercase mt-1">Mais
										notícias</a>
								</div>
								</div>
								</div>
								</section>
							<?php
							endif;
						elseif (preg_match($pattern2, $wid) && $valorArea['section_title'] == 'imagem-texto-sdapi'):
							echo "<div class='container'><section>";
							wp_show_widget($chaveArea, $wid);
							echo "</section></div>";
						elseif (preg_match($pattern3, $wid) && $valorArea['section_title'] == 'ferramentas-sdapi'): ?>
							<section class="mt-1 mb-1">
								<div class="container">
									<div class="row">
										<div class="overflow-wrapper">
											<?php
											if (is_active_sidebar($chaveArea)) :
												$contador++;
												if ($contador == 1):
													dynamic_sidebar($chaveArea);
												endif;
											endif;
											?>
										</div>
									</div>
								</div>
							</section>
						<?php
						elseif (preg_match($pattern4, $wid) && $valorArea['section_title'] == 'multimidia-sdapi'):
							echo "<section id='multimidia' class='mt-2'><div class='container'>";
							wp_show_widget($chaveArea, $wid);
							echo "</div></section>";
						endif;
						?>
					<?php
					endif;
				endforeach;
			endforeach;
		endforeach;
		?>
	<?php
	endif;
	?>
</main>

<?php get_footer(); ?>
