
<?php $all_cats = wppaytoolbox_get_all_categories(); ?>

<div class="wpptb">
	<h2><?php _e('Categories', 'wppaytoolbox')?></h2>
	<?php foreach ($all_cats as $cat) { ?>
		<div class="category-box">
			<a href="?view=<?php echo $cat['code']?>">
				<?php echo $cat['name'] ?>
			</a>
		</div>
	<?php } ?>
</div>