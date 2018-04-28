<?php $all_cats = wppaytoolbox_get_all_categories(); ?>

<div class="wpptb">

    <h2><?php _e('Categories', 'wppaytoolbox') ?></h2>

    <div class="uk-child-width-1-2@s uk-child-width-1-4@m uk-grid-match" uk-grid>
		<?php foreach ($all_cats as $cat): ?>
            <div>
                <div class="uk-card uk-card-default">
                    <div class="uk-card-media-top uk-text-center">
						<?php if (!empty($cat->getThumb())): ?>
                            <img src="<?php echo $cat->getThumb() ?>"/>
                            <a href="?product=<?php echo $cat->getCode() ?>" class="uk-position-cover"></a>
						<?php endif; ?>
                    </div>
                    <div class="uk-card-body uk-text-center">
                        <h2 class="uk-card-title">
                            <a href="?category=<?php echo $cat->getCode() ?>">
								<?php echo $cat->getName() ?>
                            </a>
                        </h2>
                        <p>DESCR</p>
                    </div>
                </div>
            </div>
		<?php endforeach; ?>
    </div>

</div>
