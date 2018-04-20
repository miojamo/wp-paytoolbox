
<?php $prod = wppaytoolbox_get_product(); ?>

<div class="wpptb">
	<h2><?php echo $prod['name']?></h2>
	<div class="desc">
		<?php echo $prod['description']?>
	</div>
	<div class="images">

		<?php foreach ($prod['images'] as $img) { ?>
			<img src="<?=WPPTB_BASE_URL?>/media/cache/product_medium/<?php echo $img->path?>">
		<?php } ?>

	</div>

	<div>
		<a href="<?=WPPTB_BASE_URL?>/products/<?=$prod['slug']?>" class="wpptb-btn">
			<?php _e('Buy', 'wppaytoolbox')?>
		</a>
	</div>
</div>