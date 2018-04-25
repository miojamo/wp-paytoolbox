
<?php $all_cats = wppaytoolbox_get_all_categories(); ?>

<div class="wpptb">

	<h2><?php _e('Categories', 'wppaytoolbox')?></h2>

	<?php foreach ($all_cats as $cat) { ?>

		<div class="list-box">

			<div class="thumb">
				<?php if(!empty($cat->getThumb())){ ?>
					<img src="<?php echo $cat->getThumb()?>" />
				<?php } ?>
			</div>

			<div class="list-name">
				<a href="?category=<?php echo $cat->getCode()?>">
					<?php echo $cat->getName() ?>
				</a>
			</div>
			<div style="clear: both"> </div>

		</div>

	<?php } ?>

</div>
