<?php

// Getting the current page
if(empty($_GET['page']))
$_GET['page'] = (getCurrentPage() == "" ? 1 : getCurrentPage());

// When this is not an Ajax request, add the header file
if(empty($_GET['ajax'])):
	get_header(); ?>
	<div class="item-holder" data-page="<?=!empty($_GET['page']) ? $_GET['page'] : 1 ?>">
<?php endif; ?>


<?php
// Get the posts from the particulair page
$postslist = get_posts(array('posts_per_page'=>3, 'paged'=>(!empty($_GET['page']) ? $_GET['page'] : 1))); ?>

<?php 
// Looping through the posts, and printing them out
foreach ($postslist as $post):
	setup_postdata($post);
	?>
	<div class="item">
		<div class="content"> 
			<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
			<?php the_content(); ?>
		</div>
		<div class="footer">
			Arco Mul - <?php the_date(); ?>
		</div>	
	</div>
<?php endforeach; ?>

<a class="nextpage" href="/page/<?=$_GET['page']+1?>/">Next page</a>
	
<?php 
// When this is not an Ajax request, add the footer
if(empty($_GET['ajax'])): ?>
	</div>
	<div class="load-animation"></div>
	<?php get_footer();
endif;