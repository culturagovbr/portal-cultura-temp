<?php
function share_box($content) {

	if( !is_single() ){
		return $content;
	}

	$post_url = get_the_permalink();
	$post_title = get_the_title();
	// $post_excerpt = strip_tags( idg_excerpt(150) );

	$content .= '<div id="share-box" class="social-buttons">';
	$content .= '<a class="share-link facebook" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u='. $post_url .'"><span class="sr-only">Facebook</span></a>';
	$content .= '<a class="share-link twitter" target="_blank" href="https://twitter.com/home?status='. $post_title .'"><span class="sr-only">Twitter</span></a>';
	$content .= '<a class="share-link g-plus" target="_blank" href="https://plus.google.com/share?url='. $post_url .'"><span class="sr-only">Google Plus</span></a>';
	$content .= '<a class="share-link linkedin" target="_blank" href="https://www.linkedin.com/shareArticle?mini=true&url='. $post_url .'&title='. $post_title .'&summary='. $post_excerpt .'&source='. get_home_url() .'"><span class="sr-only">Linkedin</span></a>';
	$content .= '</div>';

	return $content;
}

add_filter( 'the_content', 'share_box' );
