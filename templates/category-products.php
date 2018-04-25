
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
				<a href="?product=<?php echo $prod->getCode()?>">
					<?php echo $prod->getName() ?>
				</a>
			</div>
			
			<div style="clear: both"> </div>
		
		</div>
	
	<?php } ?>

</div>
