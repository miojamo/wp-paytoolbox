
<?php $prod = wppaytoolbox_get_product(); // var_dump($prod); ?>

<div class="wpptb">

	<h2><?php echo $prod['name']?></h2>
	
	<div class="price">
		<?php echo $prod['currency']?> <?php echo number_format( $prod['price'] , 2)?>
		<hr />
	</div>
	
	<div class="desc">
		<?php if( $prod['thumb']){ ?>
			<img src="<?php echo $prod['thumb']?>" class="product-thumb" />
		<?php } ?>
		<?php echo $prod['description']?>
	</div>

	<div class="images">

		<?php foreach ($prod['images'] as $img) { ?>
			<p><img src="<?=WPPTB_BASE_URL?>/media/cache/product_medium/<?php echo $img->path?>"></p>
		<?php } ?>

	</div>

	<div class="wpptb-btn-container">
		<a href="<?=WPPTB_BASE_URL?>/products/<?=$prod['slug']?>" class="wpptb-btn">
			<?php _e('Buy', 'wppaytoolbox')?>
		</a>
	</div>

</div>