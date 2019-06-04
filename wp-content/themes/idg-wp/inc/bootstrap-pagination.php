<?php
/**
 * WordPress Bootstrap Pagination
 *
 */
function wp_bootstrap_pagination( $args = array() ) {
	$defaults = array(
		'range'             => 5,
		'custom_query'      => false,
		'first_string'      => 'Primeira',
		'previous_string'   => 'Anterior',
		'next_string'       => 'Próxima',
		'last_string'       => 'Última',
		'before_output'     => '<nav aria-label="navigation"><ul class="pagination justify-content-center">',
		'after_output'      => '</ul></nav>'
	);

	$args = wp_parse_args(
		$args,
		apply_filters('wp_bootstrap_pagination_defaults', $defaults)
	);

	$args['range'] = (int)$args['range'] - 1;
	if (!$args['custom_query'])
		$args['custom_query'] = @$GLOBALS['wp_query'];

	$count = (int)$args['custom_query']->max_num_pages;
	$page = intval(get_query_var('paged'));
	$ceil = ceil($args['range'] / 2);

	if ($count <= 1)
		return FALSE;

	if (!$page)
		$page = 1;

	if ($count > $args['range']) {
		if ($page <= $args['range']) {
			$min = 1;
			$max = $args['range'] + 1;
		} elseif ($page >= ($count - $ceil)) {
			$min = $count - $args['range'];
			$max = $count;
		} elseif ($page >= $args['range'] && $page < ($count - $ceil)) {
			$min = $page - $ceil;
			$max = $page + $ceil;
		}
	} else {
		$min = 1;
		$max = $count;
	}

	$echo = '';
	$previous = intval($page) - 1;
	$previous = esc_attr(get_pagenum_link($previous));

	$firstpage = esc_attr(get_pagenum_link(1));
	if ($firstpage && (1 != $page))
		$echo .= '<li class="page-item previous first"><a class="page-link" href="' . $firstpage . '">' . $args['first_string'] . '</a></li>';
	if ($previous && (1 != $page))
		$echo .= '<li class="page-item"><a class="page-link" href="' . $previous . '" title="' . __('previous', 'text-domain') . '">' . $args['previous_string'] . '</a></li>';

	if (!empty($min) && !empty($max)) {
		for ($i = $min; $i <= $max; $i++) {
			if ($page == $i) {
				$echo .= '<li class="page-item active"><a href="#" class="page-link active">' . str_pad((int)$i, 2, '0', STR_PAD_LEFT) . '</a></li>';
			} else {
				$echo .= sprintf('<li class="page-item"><a href="%s" class="page-link">%002d</a></li>', esc_attr(get_pagenum_link($i)), $i);
			}
		}
	}

	$next = intval($page) + 1;
	$next = esc_attr(get_pagenum_link($next));
	if ($next && ($count != $page))
		$echo .= '<li class="page-item"><a class="page-link" href="' . $next . '" title="' . __('next', 'text-domain') . '">' . $args['next_string'] . '</a></li>';

	$lastpage = esc_attr(get_pagenum_link($count));
	if ($lastpage) {
		$echo .= '<li class="page-item next last"><a class="page-link" href="' . $lastpage . '">' . $args['last_string'] . '</a></li>';
	}
	if (isset($echo))
		echo $args['before_output'] . $echo . $args['after_output'];

}
