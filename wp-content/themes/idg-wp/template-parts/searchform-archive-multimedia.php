<?php
/**
 * Template for displaying search form for multimedia archive template
 *
 * @package WordPress
 */
?>

<div class="search-content-wrapper">
	<h2>O que você esta procurando?</h2>
	<form class="search-content" role="search" method="get" action="<?php echo esc_url( home_url( '/multimedia/' ) );?>">
		<div class="input-wrapper">
			<input type="search" placeholder="Buscar" value="<?php echo $_GET['ms']; ?>" name="ms"/>
			<button type="submit" class="search"><i class="icon-search"></i></button>
			<button type="button" class="filter" data-toggle="collapse" href="#filter-wrapper-collapser" role="button" aria-expanded="false" aria-controls="filter-wrapper-collapser">Filtrar</button>
		</div>

		<div id="filter-wrapper-collapser" class="filter-wrapper collapse <?php echo !empty( $_GET['mt'] ) ? 'show' : '';?>">

			<label><input type="checkbox" name="mt[]" value="image" <?php echo in_array( 'image', $_GET['mt'] ) ? 'checked' : ''; ?>/> Imagens</label>
			<label><input type="checkbox" name="mt[]" value="video" <?php echo in_array( 'video', $_GET['mt'] ) ? 'checked' : ''; ?>/> Vídeos</label>
			<label><input type="checkbox" name="mt[]" value="audio" <?php echo in_array( 'audio', $_GET['mt'] ) ? 'checked' : ''; ?>/> Áudios</label>

			<button type="submit" class="apply">Aplicar</button>
		</div>
	</form>
</div>
