
<?php $all_products = wppaytoolbox_get_category_products(); ?>


<div class="wpptb">
	<h2><?php _e('Products', 'wppaytoolbox')?></h2>
	<?php foreach ($all_products as $prod) { ?>
		<div class="category-box">
			<a href="?product=<?php echo $prod->code?>">
				<?php echo $prod->name ?>
			</a>
		</div>
	<?php } ?>
</div>