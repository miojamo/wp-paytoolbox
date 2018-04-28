
<?php $all_products = wppaytoolbox_get_category_products(); ?>

<div class="wpptb">
	
	<h2><?php _e('Products', 'wppaytoolbox')?></h2>
	
	<?php foreach ($all_products as $prod) { ?>

		<div class="list-box">
			
			<div class="thumb">
				<?php if(!empty($prod->getThumb())){ ?>
					<img src="<?php echo $prod->getThumb()?>" />
				<?php } ?>
			</div>
			
			<div class="list-name">
				<p>
					<a href="?product=<?php echo $prod->getCode()?>">
						<?php echo $prod->getName() ?>
					</a>
					<br>
					<?php _e('Categories', 'wppaytoolbox')?>: <?php echo $prod->printCategories(" ") ?>
					<br>
					<?php echo $prod->getPrice()?> <?php echo $prod->getCurrency()?>
					<br>
					<?php echo $prod->getDescription()?>
					
				</p>
			</div>
			
			<div style="clear: both"> </div>
		
		</div>
	
	<?php } ?>

</div>
