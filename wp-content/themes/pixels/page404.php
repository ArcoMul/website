<?php 

get_header();

if(is_numeric(getCurrentPage())):
	get_template_part( 'loop', 'posts' );
else: ?>

<div class="item">
	<div class="content"> 
		<h1>Sorry, I can't find this page</h1>
		<p>In the chaos of all those pixels I probably lost the page you are looking for. You better search somewhere else. Try <a href="http://google.com">Google</a>, often they know where my pages are better than I do.</p>
		<p>Best regards,</p>
		<p>An ashamed server</p>
	</div>
</div>

<?php endif;

get_footer(); ?>
