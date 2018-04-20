
<?php $all_cats = wppaytoolbox_get_all_categories(); ?>

<div class="wpptb">

	<h2><?php _e('Categories', 'wppaytoolbox')?></h2>

	<?php foreach ($all_cats as $cat) { ?>

		<div class="list-box">

			<div class="thumb">
				<?php if(!empty($cat->thumb)){ ?>
					<img src="<?php echo $cat->thumb?>" />
				<?php } ?>
			</div>

			<div class="list-name">
				<a href="?category=<?php echo $cat->code?>">
					<?php echo $cat->name ?>
				</a>
			</div>
			<div style="clear: both"> </div>

		</div>

	<?php } ?>

</div>
