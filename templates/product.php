
<?php $prod = wppaytoolbox_get_product(); // var_dump($prod); ?>

<div class="wpptb">

	<h2><?php echo $prod->getName()?></h2>
	
	<div class="price">
		<?php echo $prod->getCurrency()?> <?php echo number_format( $prod->getPrice() , 2)?>
		<hr />
	</div>
	
	<div class="desc">
		<?php if( $prod->getThumb()){ ?>
			<img src="<?php echo $prod->getThumb()?>" class="product-thumb" />
		<?php } ?>
		<?php echo $prod->getDescription()?>
	</div>

	<div class="images">

		<?php foreach ($prod->getImages() as $img) { ?>
			<p><img src="<?=WPPTB_BASE_URL?>/media/cache/product_medium/<?php echo $img->path?>"></p>
		<?php } ?>

	</div>

	<div class="wpptb-btn-container">

		<a href="<?php echo $prod->getQuicksellUrl() ?>" class="wpptb-btn">
			<?php _e('Buy', 'wppaytoolbox')?>
		</a>
	
	</div>

</div>