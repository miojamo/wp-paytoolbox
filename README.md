# Wordpress Paytoolbox plugin

Wordpress plugin to list categories and products from Paytoolbox to your Wordpress site.

## Requirements

1. Wordpress 4.9 (might work on others but not tested)

## Installation

1. Upload and activate the plugin
2. Update BASE_URL and credentials constants in wppaytoolbox.php
3. Create a standard Wodpress page or post where you want to show a shop homepage (list of categories)
4. Add shortcode [wpptb-shop] to the page and save it.
5. Open the post URL and it should show you all categories and subcategories from your Paytoolbox shop

## Customize templates/layouts

**Warning** - don't customize default plugin files b/c a plugin update will override your changes.

### Customize HTML

1. Copy files from the plugin directory /templates to your theme.
2. Rename files by adding "wpptb-" prefix to filename.
3. Customize file as needed.

### Customize CSS

1. Replace all CSS through your theme CSS files - not by editing default plugin files 

## Show thumbnail in the list of categories

In order to show thumbnail in the list of categories, you need to login to the Paytoolbox admin, edit category/taxons by adding an image.