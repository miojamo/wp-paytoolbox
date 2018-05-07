<?php $prod = wppaytoolbox_get_product(); // var_dump($prod); ?>

<div class="wpptb uk-section">

    <div class="uk-card uk-card-default uk-card-body">
        <div class="uk-child-width-1-2@m uk-grid-match" uk-grid>
            <div>
                <div class="uk-position-relative uk-visible-toggle" uk-slideshow="autoplay: true">
                    <ul class="uk-slideshow-items">
						<?php foreach ($prod->getImages() as $img) { ?>
                            <li>
                                <img src="<?php echo $img->absolutePaths->sylius_shop_product_large_thumbnail ?>" uk-cover>
                            </li>
						<?php } ?>

                    </ul>
                    <a class="uk-position-center-left uk-position-small uk-hidden-hover" href="#" uk-slidenav-previous uk-slideshow-item="previous"></a>
                    <a class="uk-position-center-right uk-position-small uk-hidden-hover" href="#" uk-slidenav-next uk-slideshow-item="next"></a>
                    <ul class="uk-slideshow-nav uk-dotnav uk-flex-center uk-margin"></ul>
                </div>
            </div>
            <div>
                <div class="uk-card">
                    <h2 class="uk-margin-remove-top"><?php echo $prod->getName() ?></h2>
                    <hr/>
                    <div class="uk-text-right">
                        <h3 class="uk-text-primary uk-h3">
							<?php echo number_format($prod->getPrice(), 2) ?><?php echo $prod->getCurrency() ?>
                        </h3>
                    </div>
                    <p><?php echo $prod->getShortDescription() ?></p>
                    <a href="<?php echo $prod->getQuicksellUrl() ?>" class="uk-button uk-button-secondary">
                        <span uk-icon="icon: cart;"></span> <?php _e('Buy', 'wppaytoolbox') ?>
                    </a>
                    <div class="uk-margin uk-text-uppercase uk-text-right">
                        <span uk-icon="icon: folder;"></span>
						<?php $prod->printCategories(" ") ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="uk-card uk-margin-top">
			<?php echo $prod->getDescription() ?>
        </div>
    </div>


</div>