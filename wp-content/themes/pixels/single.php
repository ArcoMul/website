<?php 

if ( have_posts() ) 
	while ( have_posts() ) : the_post(); 
		
		get_header(); ?>
		
		<div class="item">
			<div class="header">
				<div class="prev"><?php previous_post_link(); ?></div>
				<div class="next"><?php next_post_link(); ?></div>
			</div>	
			<div class="content"> 
				
				<h2><?php the_title(); ?></h2>
				<?php the_content(); ?>
			</div>
			<div class="footer">
				Arco Mul - <?php the_date(); ?>
			</div>	
		</div>
		
	<?php get_footer(); 
	
	endwhile;