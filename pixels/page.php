<?php 

if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

	<?php get_header(); ?>

	<div class="item">
		<div class="content"> 
			<h1><?php the_title(); ?></h1>
			<?php the_content(); ?>
		</div>
	</div>
	
	<?php get_footer(); ?>

<?php endwhile;