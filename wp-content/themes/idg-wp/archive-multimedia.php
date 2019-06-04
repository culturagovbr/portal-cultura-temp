<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Identidade_Digital_do_Governo_-_WordPress
 */

get_header();
?>

	<main id="main" class="site-main multimedia-archive">
		<div class="container">
			<div class="row">
				<?php the_breadcrumb(); ?>
			</div>
		</div>

		<section id="multimidia">
			<header class="page-header">
				<?php the_archive_title( '<h1 class="page-title text-center mt-1">', '</h1>' ); ?>
			</header>

			<div class="container">
				<div class="row">
					<?php get_template_part( 'template-parts/multimedia-block' ); ?>
				</div>
			</div>
		</section>

		<section id="social-media">
			<div class="container">

				<div class="row media-row">
					<div class="col-lg-4">
						<div class="highlight-box">
							<a href="http://facebook.com/ministeriodacultura" target="_blank">
								<div class="align">
									<div class="icon">
										<svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
										     viewBox="0 0 486.392 486.392" style="enable-background:new 0 0 486.392 486.392;" xml:space="preserve"><path style="fill:#010002;" d="M243.196,0C108.891,0,0,108.891,0,243.196s108.891,243.196,243.196,243.196
														s243.196-108.891,243.196-243.196C486.392,108.861,377.501,0,243.196,0z M306.062,243.165l-39.854,0.03l-0.03,145.917h-54.689
														V243.196H175.01v-50.281l36.479-0.03l-0.061-29.609c0-41.039,11.126-65.997,59.431-65.997h40.249v50.311h-25.171
														c-18.817,0-19.729,7.022-19.729,20.124l-0.061,25.171h45.234L306.062,243.165z"/>
										</svg>
									</div>
									<span>Facebook</span>
								</div>
							</a>
						</div>
					</div>

					<div class="col-lg-4">
						<div class="highlight-box">
							<a href="http://instagram.com/culturagovbr" target="_blank">
								<div class="align">
									<div class="icon">
										<svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
										     viewBox="0 0 468.792 468.792" style="enable-background:new 0 0 468.792 468.792;" xml:space="preserve">
												<g>
													<path style="fill:#090509;" d="M234.396,0C104.946,0,0,104.946,0,234.396s104.946,234.396,234.396,234.396
														s234.396-104.946,234.396-234.396C468.792,104.914,363.846,0,234.396,0z M380.881,370.329c0,5.816-4.736,10.552-10.615,10.552
														H98.462c-5.816,0-10.584-4.704-10.584-10.552V98.462c0-5.816,4.736-10.584,10.584-10.584h271.804
														c5.848,0,10.615,4.736,10.615,10.584C380.881,98.462,380.881,370.329,380.881,370.329z M175.789,234.396
														c0-32.355,26.252-58.607,58.607-58.607s58.607,26.252,58.607,58.607s-26.252,58.607-58.607,58.607
														S175.789,266.75,175.789,234.396z M293.003,117.182h58.607v58.607h-58.607V117.182z M319.636,219.744h31.973v131.834H117.214
														V219.744h32.005c-1.24,5.88-1.971,8.422-1.971,14.652c0,48.119,39.124,87.179,87.179,87.179
														c48.119,0,87.179-39.061,87.179-87.179C321.575,228.166,320.876,225.624,319.636,219.744z"/>
												</g>
										</svg>
									</div>
									<span>Instagram</span>
								</div>
							</a>
						</div>
					</div>

					<div class="col-lg-4">
						<div class="highlight-box">
							<a href="http://youtube.com/user/ministeriodacultura" target="_blank">
								<div class="align">
									<div class="icon">
										<svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
										     viewBox="0 0 486.392 486.392" style="enable-background:new 0 0 486.392 486.392;" xml:space="preserve">
													<g>
														<path style="fill:#010002;" d="M243.196,0C108.891,0,0,108.891,0,243.196s108.891,243.196,243.196,243.196
															s243.196-108.891,243.196-243.196C486.392,108.861,377.501,0,243.196,0z M392.609,297.641
															c-1.642,20.246-17.024,46.086-38.516,49.825c-68.855,5.35-150.447,4.682-221.764,0c-22.252-2.797-36.875-29.609-38.516-49.825
															c-3.466-42.498-3.466-66.696,0-109.195c1.642-20.216,16.629-46.876,38.516-49.308c70.496-5.928,152.545-4.651,221.764,0
															c24.745,0.912,36.875,26.417,38.516,46.663C396.014,228.3,396.014,255.143,392.609,297.641z"/>
														<polygon style="fill:#010002;" points="212.796,303.995 303.995,243.196 212.796,182.397 				"/>
													</g>
										</svg>
									</div>
									<span>Youtube</span>
								</div>
							</a>
						</div>
					</div>
				</div>

				<div class="row media-row">
					<div class="col-lg-4">
						<div class="highlight-box">
							<a href="http://flickr.com/photos/ministeriodacultura/" target="_blank">
								<div class="align">
									<div class="icon">
										<svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
										     viewBox="0 0 97.75 97.75" style="enable-background:new 0 0 97.75 97.75;" xml:space="preserve"
										>
											<g>
												<path d="M48.875,0C21.883,0,0,21.882,0,48.875S21.883,97.75,48.875,97.75S97.75,75.868,97.75,48.875S75.867,0,48.875,0z
													 M28.277,66.361c-8.895,0-16.105-7.828-16.105-17.486s7.211-17.487,16.105-17.487s16.106,7.829,16.106,17.487
													S37.172,66.361,28.277,66.361z M69.008,65.945c-9.152,0-16.57-7.735-16.57-17.279c0-9.542,7.418-17.278,16.57-17.278
													c9.15,0,16.57,7.736,16.57,17.278C85.578,58.21,78.158,65.945,69.008,65.945z"/>
											</g>
										</svg>
									</div>
									<span>Flickr</span>
								</div>
							</a>
						</div>
					</div>

					<div class="col-lg-4">
						<div class="highlight-box">
							<a href="https://twitter.com/CulturaGovBR" target="_blank">
								<div class="align">
									<div class="icon">
										<svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
										     viewBox="0 0 49.652 49.652" style="enable-background:new 0 0 49.652 49.652;"
										     xml:space="preserve">
											<g>
												<path d="M24.826,0C11.137,0,0,11.137,0,24.826c0,13.688,11.137,24.826,24.826,24.826c13.688,0,24.826-11.138,24.826-24.826
													C49.652,11.137,38.516,0,24.826,0z M35.901,19.144c0.011,0.246,0.017,0.494,0.017,0.742c0,7.551-5.746,16.255-16.259,16.255
													c-3.227,0-6.231-0.943-8.759-2.565c0.447,0.053,0.902,0.08,1.363,0.08c2.678,0,5.141-0.914,7.097-2.446
													c-2.5-0.046-4.611-1.698-5.338-3.969c0.348,0.066,0.707,0.103,1.074,0.103c0.521,0,1.027-0.068,1.506-0.199
													c-2.614-0.524-4.583-2.833-4.583-5.603c0-0.024,0-0.049,0.001-0.072c0.77,0.427,1.651,0.685,2.587,0.714
													c-1.532-1.023-2.541-2.773-2.541-4.755c0-1.048,0.281-2.03,0.773-2.874c2.817,3.458,7.029,5.732,11.777,5.972
													c-0.098-0.419-0.147-0.854-0.147-1.303c0-3.155,2.558-5.714,5.713-5.714c1.644,0,3.127,0.694,4.171,1.804
													c1.303-0.256,2.523-0.73,3.63-1.387c-0.43,1.335-1.333,2.454-2.516,3.162c1.157-0.138,2.261-0.444,3.282-0.899
													C37.987,17.334,37.018,18.341,35.901,19.144z"/>
											</g>
										</svg>


									</div>
									<span>Twitter</span>
								</div>
							</a>
						</div>
					</div>

					<div class="col-lg-4">
						<div class="highlight-box">
							<a href="https://soundcloud.com/culturagovbr" target="_blank">
								<div class="align">
									<div class="icon">

										<svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
										     width="97.75px" height="97.75px" viewBox="0 0 97.75 97.75" style="enable-background:new 0 0 97.75 97.75;" xml:space="preserve"
										><g>
												<path d="M48.875,0C21.883,0,0,21.882,0,48.875S21.883,97.75,48.875,97.75S97.75,75.868,97.75,48.875S75.867,0,48.875,0z
												 M7.739,62.171C7.712,62.364,7.573,62.5,7.399,62.5c-0.175,0-0.315-0.136-0.339-0.331l-0.621-4.633l0.621-4.713
												c0.023-0.196,0.164-0.333,0.339-0.333c0.174,0,0.313,0.136,0.34,0.33l0.736,4.717L7.739,62.171z M10.893,64.991
												c-0.03,0.2-0.176,0.342-0.354,0.342c-0.18,0-0.328-0.144-0.353-0.343l-0.834-7.454l0.834-7.622
												c0.024-0.199,0.173-0.344,0.353-0.344c0.179,0,0.324,0.141,0.354,0.344l0.948,7.622L10.893,64.991z M14.298,66.252
												c-0.026,0.241-0.205,0.415-0.426,0.415c-0.224,0-0.402-0.174-0.425-0.417l-0.792-8.712c0,0,0.792-9.043,0.792-9.044
												c0.022-0.241,0.201-0.416,0.425-0.416c0.221,0,0.399,0.175,0.426,0.416l0.899,9.044L14.298,66.252z M17.732,66.529
												c-0.024,0.277-0.238,0.488-0.497,0.488c-0.264,0-0.479-0.211-0.5-0.488l-0.748-8.989l0.748-9.292c0.021-0.28,0.236-0.49,0.5-0.49
												c0.259,0,0.473,0.21,0.497,0.487l0.85,9.294L17.732,66.529z M21.193,66.604c-0.021,0.318-0.268,0.562-0.57,0.562
												c-0.305,0-0.551-0.243-0.571-0.562l-0.706-9.063l0.706-8.619c0.021-0.321,0.267-0.563,0.571-0.563c0.303,0,0.549,0.242,0.57,0.56
												l0.801,8.623L21.193,66.604z M24.682,66.607v-0.004c-0.021,0.355-0.302,0.636-0.643,0.636c-0.344,0-0.625-0.28-0.644-0.634
												l-0.661-9.062l0.661-14.024c0.019-0.357,0.3-0.636,0.644-0.636c0.341,0,0.622,0.279,0.643,0.635l0.75,14.025L24.682,66.607z
												 M28.145,66.6v-0.005c-0.018,0.398-0.333,0.708-0.716,0.708c-0.384,0-0.698-0.31-0.713-0.705l-0.622-9.007
												c0,0,0.619-17.229,0.619-17.23c0.018-0.397,0.332-0.708,0.716-0.708c0.383,0,0.698,0.311,0.716,0.708l0.701,17.23L28.145,66.6z
												 M31.74,66.462v-0.005c-0.018,0.438-0.362,0.779-0.786,0.779c-0.427,0-0.773-0.342-0.788-0.775l-0.577-8.914
												c0,0,0.577-18.667,0.577-18.669c0.015-0.438,0.361-0.781,0.788-0.781c0.424,0,0.769,0.343,0.786,0.781l0.652,18.669L31.74,66.462z
												 M35.311,66.402c-0.014,0.478-0.393,0.853-0.859,0.853c-0.47,0-0.846-0.375-0.858-0.849l-0.536-8.858l0.534-19.297
												c0.015-0.479,0.391-0.855,0.86-0.855c0.467,0,0.846,0.375,0.859,0.855l0.603,19.298L35.311,66.402z M38.908,66.325v-0.007
												c-0.014,0.519-0.423,0.929-0.932,0.929c-0.511,0-0.92-0.41-0.931-0.924l-0.493-8.773l0.49-18.805
												c0.014-0.52,0.423-0.927,0.934-0.927c0.509,0,0.918,0.406,0.932,0.925l0.555,18.807L38.908,66.325z M42.534,66.27v-0.006
												c-0.011,0.561-0.453,1-1.005,1c-0.551,0-0.994-0.439-1.005-0.994l-0.449-8.719l0.449-18.119c0.011-0.561,0.454-1,1.005-1
												c0.552,0,0.994,0.44,1.005,1l0.503,18.121L42.534,66.27z M46.232,65.354l-0.045,0.854c-0.005,0.295-0.13,0.563-0.324,0.758
												c-0.195,0.193-0.461,0.314-0.753,0.314c-0.329,0-0.625-0.152-0.824-0.39c-0.146-0.176-0.239-0.399-0.25-0.641
												c-0.002-0.012-0.003-0.023-0.003-0.037c0,0-0.408-8.654-0.408-8.667l0.404-21.352l0.004-0.203c0.005-0.377,0.202-0.708,0.497-0.899
												c0.167-0.11,0.365-0.175,0.58-0.175c0.218,0,0.424,0.068,0.595,0.184c0.285,0.193,0.476,0.519,0.482,0.889l0.452,21.562
												L46.232,65.354z M49.825,66.092V66.09v-0.008c-0.013,0.631-0.525,1.146-1.15,1.146c-0.627,0-1.143-0.515-1.151-1.138l-0.232-4.209
												l-0.238-4.325l0.469-23.397l0.002-0.118c0.004-0.356,0.17-0.674,0.427-0.885c0.197-0.164,0.45-0.262,0.725-0.262
												c0.214,0,0.414,0.061,0.585,0.165c0.33,0.201,0.559,0.565,0.565,0.98l0.509,23.518L49.825,66.092z M80.872,67.25
												c0,0-28.909,0.003-28.937,0c-0.625-0.062-1.121-0.559-1.127-1.198c0,0,0-33.131,0-33.132c0.006-0.609,0.215-0.922,1.004-1.227
												c2.025-0.785,4.322-1.248,6.676-1.248c9.627,0,17.515,7.38,18.347,16.787c1.242-0.52,2.606-0.81,4.037-0.81
												c5.767,0,10.438,4.674,10.438,10.439C91.311,62.626,86.639,67.25,80.872,67.25z"/>
											</g></svg>
									</div>
									<span>Soundcloud</span>
								</div>
							</a>
						</div>
					</div>
				</div>

			</div>
		</section>

		<div class="container mb-5">
			<div class="col-12 pt-4 pb-4">

				<?php get_template_part( 'template-parts/searchform-archive-multimedia' ); ?>

				<?php if ( empty( $_GET['ms'] ) ) : ?>

					<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

						<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
							<header class="entry-header">
								<?php the_title( '<h2><a href="' . get_the_permalink() . '">', '</a></h2>' ); ?>
							</header>

							<div class="entry-content">
								<?php the_excerpt(); ?>
							</div>

							<footer class="entry-footer">
								<?php idg_wp_entry_footer(); ?>
								<div class="date-box mb-4">
									<span>publicado: <?php the_date( 'd/m/Y' ); ?> <?php the_time( 'H' ); ?>h<?php the_time( 'i' ); ?>, última modificação: <?php the_modified_date( 'd/m/Y' ); ?> <?php the_modified_time( 'H' ); ?>h<?php the_modified_time( 'i' ); ?></span>
								</div>
							</footer>
						</article>

					<?php endwhile;
						the_posts_navigation();
					else :
						get_template_part( 'template-parts/content', 'none' );
					endif; ?>

				<?php else: ?>
					<span id="multimedia-content" class="sr-only">Conteúdo principal</span>
					<?php
					// $paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
					$paged = ( ! empty( $_GET['page'] ) ) ? $_GET['page'] : 1;

					$args = array(
						's'              => $_GET['ms'],
						'paged'          => $paged,
						'post_type'      => 'multimedia',
					);

					if ( ! empty( $_GET['mt'] ) ) {
						$args['tax_query'] = array(
							array(
								'taxonomy' => 'multimedia-type',
								'field'    => 'slug',
								'terms'    => $_GET['mt'],
							),
						);
					}

					$search = new WP_Query( $args );

					if ( $search->have_posts() ) :
						while ( $search->have_posts() ) : $search->the_post(); ?>
							<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
								<header class="entry-header">
									<?php the_title( '<h2><a href="' . get_the_permalink() . '">', '</a></h2>' ); ?>
								</header>

								<div class="entry-content">
									<?php the_excerpt(); ?>
								</div>

								<footer class="entry-footer">
									<?php idg_wp_entry_footer(); ?>
									<div class="date-box mb-4">
										<span>publicado: <?php the_date( 'd/m/Y' ); ?> <?php the_time( 'H' ); ?>h<?php the_time( 'i' ); ?>, última modificação: <?php the_modified_date( 'd/m/Y' ); ?> <?php the_modified_time( 'H' ); ?>h<?php the_modified_time( 'i' ); ?></span>
									</div>
								</footer>
							</article>
						<?php endwhile;
						wp_reset_postdata();

						if ( $search->max_num_pages > 1 ): ?>
							<nav class="text-center" aria-label="navigation">
								<ul class="pagination justify-content-center">
									<?php
									$search_str = '/?ms=' . $_GET['ms'];
									$search_str = ( ! empty( $_GET['mt'] ) ) ? $search_str . '&mt=' . $_GET['mt'] : $search_str;
									if ( $paged <= 1 ):?>
										<li class="page-item disabled"><a href="#" class="page-link" aria-label="Previous"><span aria-hidden="true">«</span></a></li>
									<?php else: ?>
										<li><a href="<?php echo home_url( '/multimedia' . $search_str . '&page=' . ( $paged - 1 ) ); ?>" aria-label="Previous" class="page-link"><span aria-hidden="true">«</span></a></li>
									<?php endif;

									for ( $i = 1; $i <= $search->max_num_pages; $i ++ ): ?>
										<li class="page-item <?php echo ( $paged == $i ) ? 'active' : ''; ?>"><a href="<?php echo home_url( '/multimedia/' . $search_str . '&page=' . $i ); ?>" class="page-link"><?php echo $i; ?></a></li>
									<?php endfor;

									if ( $paged != $search->max_num_pages ):?>
										<li><a href="<?php echo home_url( '/multimedia' . $search_str . '&page=' . ( $paged + 1 ) ); ?>" aria-label="Next" class="page-link"><span aria-hidden="true">»</span></a></li>
									<?php else: ?>
										<li class="page-item disabled"><a href="#" aria-label="Next" class="page-link"><span aria-hidden="true">»</span></a></li>
									<?php endif; ?>
								</ul>
							</nav>
						<?php endif;

					else:
						get_template_part( 'template-parts/content', 'none' );
					endif;

				endif; ?>
			</div>
		</div>

	</main>

<?php
get_sidebar();
get_footer();
